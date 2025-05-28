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

    public function dashboardsabt(Request $request) {
        if(!Auth::check()) {
            return redirect()->route('login')->with('message', 'Tu sesion ha expirado por inactividad');
        }

        Session::put('vistal_actual', 'dashboardsabt');

        $connection = User::conexion();

        if($connection == 'psql') {
            return view('admin/admin');
        } else {
            $dashboardSABTInfo = $this->getDashboardSABTInfo($connection);
            
            return view('supervisionavanzada/dashboardsabt', [
                'dashboardSABTInfo' => $dashboardSABTInfo,
            ]);
        }
    }

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

    public function indicadoressabt(Request $request) {
        
        if(!Auth::check()) {
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }

        //Guardar el nombre de la vista actual en la sesion
        Session::put('vista_actual', 'indicadoressabt');

        $connection = User::conexion();

        if($connection == 'psql') {
            return view('admin');
        } else {

            $distorsionesArmonicas = $this->getDistorsionesArmonicas($connection);
            $numDistorsionesArmonicas = $this->getNumDistorsionesArmonicas($connection);
            $promedioFase = $this->getPromedioFase($connection);
            $numFlickers = $this->getNumFlickers($connection);
            $desbalancesTension = $this->getDesbalancesTension($connection);
            $numDesbalancesTension = $this->getNumDesbalancesTension($connection);
            $variacionesTension = $this->getVariacionesTension($connection);
            $numVariacionesTension = $this->getNumVariacionesTension($connection);

            return view('supervisionavanzada/indicadoressabt', [
                'distorsionesArmonicas' => $distorsionesArmonicas,
                'numDistorsionesArmonicas' => $numDistorsionesArmonicas,
                'promedioFase' => $promedioFase,
                'numFlickers' => $numFlickers,
                'desbalancesTension' => $desbalancesTension,
                'numDesbalancesTension' => $numDesbalancesTension,
                'variacionesTension' => $variacionesTension,
                'numVariacionesTension' => $numVariacionesTension,
            ]);
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
        Session::put('vista_actual', 'fasessabt');

        // Obtener la conexión dinámica
        $connection = User::conexion();

        if ($connection == 'pgsql') {
            // Si la conexión es la predeterminada, retornar un mensaje de bienvenida para el admin
            return view('admin/admin');
        } else {
            $ct_info = Ct::on($connection)->select('id_ct', 'nom_ct')->get();

            $fasessabt = $this->getFasesSABT($id_ct, $connection);
            $tramos = $this->getTramos($request, $connection);

            //$cups_info = $this->getCupsInfo($request, $id_ct, $connection);

            return view('supervisionavanzada/fasessabt', [
                'fasessabt' => $fasessabt,
                'ct_info' => $ct_info,
                'tramos' => $tramos,
            ]);
        }
    }

    public function calidadsabt(Request $request) {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }

        $id_ct = $request->input('id_ct');

        // Guardar el id_ct en la sesión
        Session::put('id_ct', $id_ct);

        // Guardar el nombre de la vista actual en la sesión
        Session::put('vista_actual', 'calidadsabt');

        // Obtener la conexión dinámica
        $connection = User::conexion();

        if ($connection == 'pgsql') {
            // Si la conexión es la predeterminada, retornar un mensaje de bienvenida para el admin
            return view('admin/admin');
        } else {
            $ct_info = Ct::on($connection)->select('id_ct', 'nom_ct')->get();

            return view('supervisionavanzada/calidadsabt', [
                
            ]);
        }
    }

    public function balancessabt(Request $request) {
        if(!Auth::check()) {
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }

        Session::put('vista_actual', 'balancessabt');

        $connection = User::conexion();

        if($connection == 'pgsql') {
            return view('admin/admin');
        } else {
            $balancesSABT = $this->getBalancesSABT($request, $connection);

            return view('supervisionavanzada/balancessabt', [
                'balancesSABT' => $balancesSABT,
            ]);
        }
    }

    public function getDashboardSABTInfo($connection) {
        try {
            if(Schema::connection($connection)->hasTable('t_ct')
            && Schema::connection($connection)->hasTable('t_trafos')
            && Schema::connection($connection)->hasTable('t_lineas')
            && Schema::connection($connection)->hasTable('t_cups')) {
                $dashboardSABTInfo = DB::connection($connection)->select("
                SELECT
                    ct.id_ct,
                    ct.nom_ct,
                    COUNT(DISTINCT tra.id_trafo) AS nro_trafos,
                    COUNT(DISTINCT li.id_linea) AS nro_lineas,
                    COUNT(DISTINCT cu.id_cnt) AS nro_contadores
                FROM
                    core.t_ct ct
                LEFT JOIN core.t_lineas li ON ct.id_ct = li.id_ct
                LEFT JOIN core.t_trafos tra ON li.id_trafo = tra.id_trafo
                LEFT JOIN core.t_cups cu ON ct.id_ct = cu.id_ct
                GROUP BY
                    ct.id_ct, ct.nom_ct
                ORDER BY
                    ct.id_ct;
                ");

                return $dashboardSABTInfo ?: ['message' => 'No hay datos'];
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch(\Exception $e) {
            return ['message' => 'No hay datos'];
        }
    }

    public function getBalancesSABT(Request $request, $connection) {
        try {
            if(Schema::connection($connection)->hasTable('t_balances_horarios_lineas')) {
                $fecha_inicio = $request->input('fecha_inicio');
                $fecha_fin = $request->input('fecha_fin');
                
                $query = "
                SELECT
                    id_ct,
                    id_linea,
                    num_cnt,
                    SUM(COALESCE(ai_lvs, 0)) AS total_ai_lvs,
                    SUM(COALESCE(ae_lvs, 0)) AS total_ae_lvs,
                    SUM(COALESCE(ai_lvs, 0) + COALESCE(ae_lvs, 0)) AS total_lvs,
                    SUM(COALESCE(ai_cnt, 0)) AS total_ai_cnt,
                    SUM(COALESCE(ae_cnt, 0)) AS total_ae_cnt,
                    SUM(COALESCE(ai_lvs, 0) + COALESCE(ae_lvs, 0) - COALESCE(ai_cnt, 0)) AS perdida_energia,
                    CASE
                        WHEN SUM(COALESCE(ai_lvs, 0) + COALESCE(ae_lvs, 0)) = 0 THEN 0
                        ELSE
                            ROUND(
                                (SUM(COALESCE(ai_lvs, 0) + COALESCE(ae_lvs, 0)) - SUM(COALESCE(ai_cnt, 0))) * 100.0
                                / SUM(COALESCE(ai_lvs, 0) + COALESCE(ae_lvs, 0)),
                                2
                            )
                    END AS porcentaje_perdida
                FROM
                    core.t_balances_horarios_lineas
                WHERE";

                if ($fecha_inicio && $fecha_fin) {
                    $query .= " fecha_inicio >= :fecha_inicio AND fecha_inicio <= :fecha_fin";
                    $params = ['fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin];
                } else {
                    $query .= " fecha_inicio >= CURRENT_DATE - INTERVAL '30 days'";
                }

                $query .= " GROUP BY
                            id_ct,
                            id_linea,
                            num_cnt
                        ORDER BY
                            id_ct,
                            id_linea;";

                $balancesSABT = DB::connection($connection)->select($query, $params);

                return $balancesSABT ?: ['message' => 'No hay datos'];
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            return ['message' => 'Error: ' . $e->getMessage()];
        }
    }

    //KPI1
    public function getDistorsionesArmonicas($connection) {
        try {
            if(Schema::connection($connection)->hasTable('t_s96')) {
                $distorsionesArmonicas = DB::connection($connection)->select("
                SELECT  
                    AVG(hr_thd) AS avg_hr_thd,  
                    AVG(hs_thd) AS avg_hs_thd,  
                    AVG(ht_thd) AS avg_ht_thd FROM core.t_s96 		 
                WHERE fh >= NOW() - INTERVAL '72 hours';");

                return $distorsionesArmonicas ?: ['message' => 'No hay datos'];
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch(\Exception $e) {
            return ['message' => 'No hay datos'];
        }

    }

    //KPI1
    public function getNumDistorsionesArmonicas($connection) {
        try {
            if(Schema::connection($connection)->hasTable('t_s96')) {
                $numDistorsionesArmonicas = DB::connection($connection)->select("
                SELECT COUNT(*) AS total_distorsiones 
                FROM core.t_s96 
                WHERE hr_thd > 8 OR hs_thd > 8 OR ht_thd > 8;");

                return $numDistorsionesArmonicas ?: ['message' => 'No hay datos'];
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch(\Exception $e) {
            return ['message' => 'No hay datos'];
        }
    }

    //KPI2
    public function getPromedioFase($connection) {
        try {
            if(Schema::connection($connection)-> hasTable('t_s94')) {
                $promedioFase = DB::connection($connection)->select("
                SELECT  
                    AVG(fr) AS avg_fr, 
                    AVG(fs) AS avg_fs, 
                    AVG(ft) AS avg_ft 
                FROM core.t_s94 
                WHERE fh >= NOW() - INTERVAL '3 days'; ");

                return $promedioFase ?: ['message' => 'No hay datos'];
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch(\Exception $e) {
            return ['message' => 'No hay datos'];
        }
    }

    //KPI2
    public function getNumFlickers($connection) {
        try {
            if(Schema::connection($connection)->hasTable('t_s94')) {
                $numFlickers = DB::connection($connection)->select("
                SELECT COUNT(*) AS total_flickers 
                FROM core.t_s94 
                WHERE fr > 1 OR fs > 1 OR ft > 1; ");

                return $numFlickers ?: ['message' => 'No hay datos'];
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }

    //KPI3
    public function getDesbalancesTension($connection) {
        try {
            if(Schema::connection($connection)->hasTable('t_s95')) {
                $desbalancesTension = DB::connection($connection)->select("
                SELECT AVG(vu) AS avg_desbalance_tension 
                FROM core.t_s95 
                WHERE fh >= NOW() - INTERVAL '72 hours'; ");

                return $desbalancesTension ?: ['message' => 'No hay datos'];
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }

    //KPI3
    public function getNumDesbalancesTension($connection) {
        try {
            if(Schema::connection($connection)->hasTable('t_s95')) {
                $numDesbalancesTension = DB::connection($connection)->select("
                SELECT COUNT(*) AS total_desbalances 
                FROM core.t_s95 
                WHERE vu > 2; ");

                return $numDesbalancesTension ?: ['message' => 'No hay datos'];
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }

    //KPI4
    public function getVariacionesTension($connection) {
        try {
            if(Schema::connection($connection)->hasTable('t_s97')) {
                $variacionesTension = DB::connection($connection)->select("
                SELECT SUM(nr) AS total_variaciones_r, 
                    SUM(ns) AS total_variaciones_s, 
                    SUM(nt) AS total_variaciones_t 
                FROM core.t_s97 WHERE fh >= NOW() - INTERVAL '72 hours';");

                return $variacionesTension ?: ['message' => 'No hay datos'];
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }

    public function getNumVariacionesTension($connection) {
        try {
            if(Schema::connection($connection)->hasTable('t_s97')) {
                $numVariacionesTension = DB::connection($connection)->select("
                SELECT id_rtu, sum(nr) , sum(ns), sum(nt)  
                FROM core.t_s97 
                group by 1; ");
                
                return $numVariacionesTension ?: ['message' => 'No hay datos'];
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
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



    Public function getTramos(Request $request, $connection) {
        try {
            if(Schema::connection($connection)->hasTable('t_tramos')) {
                $query = "
                SELECT *
                FROM core.t_tramos
                ";

                $tramos = DB::connection($connection)->select($query);

                return $tramos ?: ['message' => 'No hay datos'];
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch(\Exception $e) {
            return ['message' => 'No hay datos error', $e];
        }
    }

}