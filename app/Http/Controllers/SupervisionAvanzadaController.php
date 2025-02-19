<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Nodels\Ct;
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

            if($tipo_evento == null) {
                $tipo_evento = 'S64';
            }

            if($tipo_evento == 'S64') {
                $resultadosS64 = $this->getAllS64($request, $connection);
            } else if($tipo_evento == 'G53') {
                //$resultadosG53 = $this->getAllG53($request, $connection);
            } else if($tipo_evento == 'S52') {
                //$resultadosS52 = $this->getAllS52($request, $connection);
            } else if($tipo_evento == 'S97') {
                //$resultadosS96 = $this->getAllS97($request, $connection);
            } 


            return view('supervisionavanzada/supervisionavanzada', [
                //'resultadosG53' => $resultadosG53,
                'resultadosS64' => $resultadosS64,
                'tipo_evento' => $tipo_evento
                //'resultadosS52' => $resultadosS52,
                //'resultadosS96' => $resultadosS96,
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


}