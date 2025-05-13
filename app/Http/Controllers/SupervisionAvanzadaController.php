<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class SupervisionAvanzadaController extends Controller {

    public function supervisionavanzada(Request $request) {
        //Verificar si el usuario esta autenticado
        if(!Auth::check()) {
            return redirect()->route('login')->with('message', 'Tu sesion ha expirado por inactividad');
        }

        //Guardar el nombre de la vista actual en la sesion
        Session::put('vista_actual', 'supervisionavanzada');

        //Obtener la conexion dinamica
        $connection = User::conexion();

        if($connection == 'psql') {
            //Si la conexion es la predeterminada, retornar un mensaje de bienvenida para el admin
            return view('admin/admin');
        } else {
            //Obtener los datos de todos los G53, S64, S52, S96, S97
            $tipo_evento = $request -> input('tipo_evento');
            $resultadosG53 = [];

            if($tipo_evento == null) {
                $tipo_evento = 'S64';
            }

            if($tipo_evento == 'S64') {
                $resultadosS64 = $this->getAllS64($request, $connection);
                return view('supervisionavanzada/supervisionavanzada', [
                    'resultadosS64' => $resultadosS64]);
            } else if($tipo_evento == 'G53') {
                $resultadosG53 = $this->getAllG53($request, $connection);
                return view('supervisionavanzada/supervisionavanzada', [
                    'resultadosG53' => $resultadosG53]);
            } else if($tipo_evento == 'S52') {
                $resultadosS52 = $this->getAllS52($request, $connection);
                return view('supervisionavanzada/supervisionavanzada', [
                    'resultadosS52' => $resultadosS52]);
            } else if($tipo_evento == 'S96') {
                $resultadosS96 = $this->getAllS96($request, $connection);
                return view('supervisionavanzada/supervisionavanzada', [
                    'resultadosS96' => $resultadosS96]);
            } else if($tipo_evento == 'S97') {
                $resultadosS97 = $this->getAllS97($request, $connection);
                return view('supervisionavanzada/supervisionavanzada', [
                    'resultadosS97' => $resultadosS97]);
            } else {
                return view('supervisionavanzada/supervisionavanzada', []);
            }


            
        }
    }

    public function fasessabt(Request $request) {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }

        $id_ct = $request->input('id_ct');

        // Guardar el id_ct en la sesión
        Session::put('id_ct', $id_ct);

        // Guardar el nombre de la vista actual en la sesión
        Session::put('vista_actual', 'informacionct');

        // Obtener la conexión dinámica
        $connection = User::conexion();

        if ($connection == 'pgsql') {
            // Si la conexión es la predeterminada, retornar un mensaje de bienvenida para el admin
            return view('admin/admin');
        } else {
            $ct_info = Ct::on($connection)->select('id_ct', 'nom_ct')->get();

            $fasessabt = $this->getFasesSABT($id_ct, $connection);

            //$cups_info = $this->getCupsInfo($request, $id_ct, $connection);

            return view('supervisionavanzada/fasessabt', [
                'fasessabt' => $fasessabt,
                'ct_info' => $ct_info,
            ]);
        }
    }

    public function getAllS64(Request $request, $connection) {
        try {
            if(Schema::connection($connection)->hasTable('t_s64')) {
                //Obtener las fechas de inicio y de fin del request
                $fecha_inicio = $request->input('fecha_inicio');
                $fecha_fin = $request->input('fecha_fin');

                //Construir la consulta SQL para obtener los eventos S64
                $query = "
                SELECT * FROM t_s64";

                // Añadir el filtro de fecha_inicio si está disponible
                if ($fecha_inicio && !$fecha_fin) {
                    $query .= " WHERE fh >= TO_TIMESTAMP('$fecha_inicio', 'YYYY-MM-DD') LIMIT 20";
                }

                if($fecha_fin && !$fecha_inicio) {
                    $query .= " WHERE fh <= TO_TIMESTAMP('$fecha_fin', 'YYYY-MM-DD') LIMIT 20";
                }

                // Añadir el filtro de fecha_fin si está disponible
                if ($fecha_fin && $fecha_inicio) {
                    $query .= " WHERE fh >= TO_TIMESTAMP('$fecha_inicio', 'YYYY-MM-DD')
                                AND fh <= TO_TIMESTAMP('$fecha_fin', 'YYYY-MM-DD') LIMIT 20";
                }

                // Si no se especifica ni fecha_inicio ni fecha_fin, usar las últimas 24 horas por defecto
                if (!$fecha_inicio && !$fecha_fin) {
                    $query .= " WHERE fh >= NOW() - INTERVAL '24 hours' LIMIT 20";
                }

                //Ejecutar la consulta
                $resultadosS64 = DB::connection($connection)->select($query);

                return $resultadosS64 ?: ['message' => 'No hay datos db'];
            } else {
                return ['message' => 'No hay datos'];
            }

        } catch(\Exception $e) {
            return ['message' => 'No hay datos error', $e];
        }
    }

    public function getAllG53(Request $request, $connection) {
        try {
            if(Schema::connection($connection) -> hasTable('t_g53')) {
                $fecha_inicio = $request->input('fecha_inicio');
                $fecha_fin = $request->input('fecha_fin');

                //Construir la consulta SQL para obtener los eventos S64
                $query = "
                SELECT * FROM t_g53";

                // Añadir el filtro de fecha_inicio si está disponible
                if ($fecha_inicio && !$fecha_fin) {
                    $query .= " WHERE fh >= TO_TIMESTAMP('$fecha_inicio', 'YYYY-MM-DD') LIMIT 20";
                }

                if($fecha_fin && !$fecha_inicio) {
                    $query .= " WHERE fh <= TO_TIMESTAMP('$fecha_fin', 'YYYY-MM-DD') LIMIT 20";
                }

                // Añadir el filtro de fecha_fin si está disponible
                if ($fecha_fin && $fecha_inicio) {
                    $query .= " WHERE fh >= TO_TIMESTAMP('$fecha_inicio', 'YYYY-MM-DD')
                                AND fh <= TO_TIMESTAMP('$fecha_fin', 'YYYY-MM-DD') LIMIT 20";
                }

                // Si no se especifica ni fecha_inicio ni fecha_fin, usar las últimas 24 horas por defecto
                if (!$fecha_inicio && !$fecha_fin) {
                    $query .= " WHERE fh >= NOW() - INTERVAL '24 hours' LIMIT 20";
                }

                //Ejecutar la consulta
                $resultadosS64 = DB::connection($connection)->select($query);

                return $resultadosS64 ?: ['message' => 'No hay datos db'];
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch(\Exception $e) {

        }
    }


    public function getAllS52(Request $request, $connection) {
        try {
            if(Schema::connection($connection) -> hasTable('t_s52')) {
                $fecha_inicio = $request->input('fecha_inicio');
                $fecha_fin = $request->input('fecha_fin');

                //Construir la consulta SQL para obtener los eventos S64
                $query = "
                SELECT * FROM t_s52";

                // Añadir el filtro de fecha_inicio si está disponible
                if ($fecha_inicio && !$fecha_fin) {
                    $query .= " WHERE fh >= TO_TIMESTAMP('$fecha_inicio', 'YYYY-MM-DD') LIMIT 20";
                }

                if($fecha_fin && !$fecha_inicio) {
                    $query .= " WHERE fh <= TO_TIMESTAMP('$fecha_fin', 'YYYY-MM-DD') LIMIT 20";
                }

                // Añadir el filtro de fecha_fin si está disponible
                if ($fecha_fin && $fecha_inicio) {
                    $query .= " WHERE fh >= TO_TIMESTAMP('$fecha_inicio', 'YYYY-MM-DD')
                                AND fh <= TO_TIMESTAMP('$fecha_fin', 'YYYY-MM-DD') LIMIT 20";
                }

                // Si no se especifica ni fecha_inicio ni fecha_fin, usar las últimas 24 horas por defecto
                if (!$fecha_inicio && !$fecha_fin) {
                    $query .= " WHERE fh >= NOW() - INTERVAL '24 hours' LIMIT 20";
                }

                //Ejecutar la consulta
                $resultadosS52 = DB::connection($connection)->select($query);

                return $resultadosS52 ?: ['message' => 'No hay datos db'];
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch(\Exception $e) {

        }
    }

    public function getAllS96(Request $request, $connection) {
        try {
            if(Schema::connection($connection) -> hasTable('t_s96')) {
                $fecha_inicio = $request->input('fecha_inicio');
                $fecha_fin = $request->input('fecha_fin');

                //Construir la consulta SQL para obtener los eventos S64
                $query = "
                SELECT * FROM t_s96";

                // Añadir el filtro de fecha_inicio si está disponible
                if ($fecha_inicio && !$fecha_fin) {
                    $query .= " WHERE fh >= TO_TIMESTAMP('$fecha_inicio', 'YYYY-MM-DD') LIMIT 20";
                }

                if($fecha_fin && !$fecha_inicio) {
                    $query .= " WHERE fh <= TO_TIMESTAMP('$fecha_fin', 'YYYY-MM-DD') LIMIT 20";
                }

                // Añadir el filtro de fecha_fin si está disponible
                if ($fecha_fin && $fecha_inicio) {
                    $query .= " WHERE fh >= TO_TIMESTAMP('$fecha_inicio', 'YYYY-MM-DD')
                                AND fh <= TO_TIMESTAMP('$fecha_fin', 'YYYY-MM-DD') LIMIT 20";
                }

                // Si no se especifica ni fecha_inicio ni fecha_fin, usar las últimas 24 horas por defecto
                if (!$fecha_inicio && !$fecha_fin) {
                    $query .= " WHERE fh >= NOW() - INTERVAL '24 hours' LIMIT 20";
                }

                //Ejecutar la consulta
                $resultadosS96 = DB::connection($connection)->select($query);

                return $resultadosS96 ?: ['message' => 'No hay datos db'];
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch(\Exception $e) {

        }
    }

    public function getAllS97(Request $request, $connection) {
        try {
            if(Schema::connection($connection) -> hasTable('t_s97')) {
                $fecha_inicio = $request->input('fecha_inicio');
                $fecha_fin = $request->input('fecha_fin');

                //Construir la consulta SQL para obtener los eventos S64
                $query = "
                SELECT * FROM t_s97";

                // Añadir el filtro de fecha_inicio si está disponible
                if ($fecha_inicio && !$fecha_fin) {
                    $query .= " WHERE fh >= TO_TIMESTAMP('$fecha_inicio', 'YYYY-MM-DD') LIMIT 20";
                }

                if($fecha_fin && !$fecha_inicio) {
                    $query .= " WHERE fh <= TO_TIMESTAMP('$fecha_fin', 'YYYY-MM-DD') LIMIT 20";
                }

                // Añadir el filtro de fecha_fin si está disponible
                if ($fecha_fin && $fecha_inicio) {
                    $query .= " WHERE fh >= TO_TIMESTAMP('$fecha_inicio', 'YYYY-MM-DD')
                                AND fh <= TO_TIMESTAMP('$fecha_fin', 'YYYY-MM-DD') LIMIT 20";
                }

                // Si no se especifica ni fecha_inicio ni fecha_fin, usar las últimas 24 horas por defecto
                if (!$fecha_inicio && !$fecha_fin) {
                    $query .= " WHERE fh >= NOW() - INTERVAL '24 hours' LIMIT 20";
                }

                //Ejecutar la consulta
                $resultadosS97 = DB::connection($connection)->select($query);

                return $resultadosS97 ?: ['message' => 'No hay datos db'];
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch(\Exception $e) {

        }
    }

    public function getFasesSABT($id_ct, $connection) {
        try {
            if(Schema::connection($connection)->hasTable('t_cups')) {
                 $fasessabt = DB::connection($connection)->select("
                 SELECT * FROM core.t_cups 
                 WHERE id_ct = :id_ct", ['id_ct' => $id_ct]);

                 return $fasessabt ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico 
                return ['message' => 'No hay datos'];
            }
        } catch(\Exception $e) {
            return ['message' => 'No hay datos'];
        }
    }

}