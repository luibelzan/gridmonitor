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
            $dashboardSABTInfo = $this->getDashboardSABTInfo($request, $connection);
            
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
            $id_ct = $request -> input('id_ct');
            $ct_info = Ct::on($connection)->select('id_ct', 'nom_ct', 'ind_sabt')->get();

            if($tipo_evento == null) {
                $tipo_evento = 'S64';
            }

            if($tipo_evento == 'S64') {
                $resultadosS64 = $this->getAllS64($request, $connection);
                return view('supervisionavanzada/supervisionavanzada', [
                    'resultadosS64' => $resultadosS64,
                    'id_ct' => $id_ct,
                'ct_info' => $ct_info]);
            } else if($tipo_evento == 'G53') {
                $resultadosG53 = $this->getAllG53($request, $connection);
                return view('supervisionavanzada/supervisionavanzada', [
                    'resultadosG53' => $resultadosG53,
                    'id_ct' => $id_ct,
                'ct_info' => $ct_info]);
            } else if($tipo_evento == 'S52') {
                $resultadosS52 = $this->getAllS52($request, $connection);
                return view('supervisionavanzada/supervisionavanzada', [
                    'resultadosS52' => $resultadosS52,
                    'id_ct' => $id_ct,
                'ct_info' => $ct_info]);
            } else if($tipo_evento == 'S96') {
                $resultadosS96 = $this->getAllS96($request, $connection);
                return view('supervisionavanzada/supervisionavanzada', [
                    'resultadosS96' => $resultadosS96,
                    'id_ct' => $id_ct,
                'ct_info' => $ct_info]);
            } else if($tipo_evento == 'S97') {
                $resultadosS97 = $this->getAllS97($request, $connection);
                return view('supervisionavanzada/supervisionavanzada', [
                    'resultadosS97' => $resultadosS97,
                    'id_ct' => $id_ct,
                'ct_info' => $ct_info]);
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
            $infoDistorsionesArmonicas = $this->getInfoDistorsionesArmonicas($connection);
            $infoFlickers = $this->getInfoFlickers($connection);
            $infoDesbalancesTension = $this->getInfoDesbalancesTension($connection);

            return view('supervisionavanzada/indicadoressabt', [
                'distorsionesArmonicas' => $distorsionesArmonicas,
                'numDistorsionesArmonicas' => $numDistorsionesArmonicas,
                'promedioFase' => $promedioFase,
                'numFlickers' => $numFlickers,
                'desbalancesTension' => $desbalancesTension,
                'numDesbalancesTension' => $numDesbalancesTension,
                'variacionesTension' => $variacionesTension,
                'numVariacionesTension' => $numVariacionesTension,
                'infoDistorsionesArmonicas' => $infoDistorsionesArmonicas,
                'infoFlickers' => $infoFlickers,
                'infoDesbalancesTension' => $infoDesbalancesTension,
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
            $ct_info = Ct::on($connection)->select('id_ct', 'nom_ct', 'ind_sabt')->get();

            $fasessabt = $this->getFasesSABT($id_ct, $connection);
            $tramos = $this->getTramos($request, $connection);
            $ctSABT = $this->getCTSABT($id_ct, $connection);
            //$cups_info = $this->getCupsInfo($request, $id_ct, $connection);

            return view('supervisionavanzada/fasessabt', [
                'fasessabt' => $fasessabt,
                'ct_info' => $ct_info,
                'tramos' => $tramos,
                'ctSABT' => $ctSABT,
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

    public function getDashboardSABTInfo(Request $request, $connection) {
        try {
            if(Schema::connection($connection)->hasTable('t_ct')
            && Schema::connection($connection)->hasTable('t_trafos')
            && Schema::connection($connection)->hasTable('t_lineas')
            && Schema::connection($connection)->hasTable('t_cups')) {
                $nom_ct = $request->input('nom_ct');
                $params = [];

                $query = "
                SELECT
                    ct.id_ct,
                    ct.nom_ct,
                    COUNT(DISTINCT tra.id_trafo) AS nro_trafos,
                    COUNT(DISTINCT li.id_linea) AS nro_lineas,
                    COUNT(DISTINCT cu.id_cnt) AS nro_contadores,

                    COUNT(DISTINCT CASE WHEN cu.cod_fase = 'R' THEN cu.id_cnt END) AS nro_contadores_r,
                    COUNT(DISTINCT CASE WHEN cu.cod_fase = 'S' THEN cu.id_cnt END) AS nro_contadores_s,
                    COUNT(DISTINCT CASE WHEN cu.cod_fase = 'T' THEN cu.id_cnt END) AS nro_contadores_t,
                    COUNT(DISTINCT CASE WHEN cu.cod_fase = '3' THEN cu.id_cnt END) AS nro_contadores_3
                FROM
                    core.t_ct ct
                LEFT JOIN core.t_lineas li ON ct.id_ct = li.id_ct
                LEFT JOIN core.t_trafos tra ON li.id_trafo = tra.id_trafo
                LEFT JOIN core.t_cups cu ON ct.id_ct = cu.id_ct
                WHERE ind_sabt = 'true'
                ";

                if($nom_ct) {
                    $query .= " AND ct.nom_ct ILIKE :nom_ct";
                    $params = ['nom_ct' => '%' . $nom_ct . '%'];
                }

                $query .= "
                GROUP BY
                    ct.id_ct, ct.nom_ct
                ORDER BY
                    ct.id_ct;
                ";

                $dashboardSABTInfo = DB::connection($connection)->select($query, $params);

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

                $params = [];
                
                $query = "
                SELECT
                id_ct,
                id_linea,
                AVG(num_cnt) AS total_cnt,
                SUM(COALESCE(ai_lvs, 0)) AS total_ai_lvs,
                SUM(COALESCE(ae_lvs, 0)) AS total_ae_lvs,
                SUM(COALESCE(ai_lvs, 0) + COALESCE(ae_cnt, 0)) AS total_lvs,
                SUM(COALESCE(ai_cnt, 0)) AS total_ai_cnt,
                SUM(COALESCE(ae_cnt, 0)) AS total_ae_cnt,
                SUM(COALESCE(ai_lvs, 0) + COALESCE(ae_cnt, 0) - COALESCE(ai_cnt, 0)) AS perdida_energia,
                CASE
                    WHEN SUM(COALESCE(ai_lvs, 0) + COALESCE(ae_lvs, 0)) = 0 THEN 0
                    ELSE
                        ROUND(
                            (SUM(COALESCE(ai_lvs, 0) + COALESCE(ae_cnt, 0)) - SUM(COALESCE(ai_cnt, 0))) * 100.0
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
                            id_linea
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

    //KPI1
    public function getInfoDistorsionesArmonicas($connection) {
        try {
            if(Schema::connection($connection)->hasTable('t_s96')) {
                $infoDistorsionesArmonicas = DB::connection($connection)->select("
                SELECT *  
                FROM core.t_s96 
                WHERE hr_thd > 8 OR hs_thd > 8 OR ht_thd > 8;");

                return $infoDistorsionesArmonicas ?: ['message' => 'No hay datos'];
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

    //KPI2
    public function getInfoFlickers($connection) {
        try {
            if(Schema::connection($connection)->hasTable('t_s94')) {
                $infoFlickers = DB::connection($connection)->select("
                SELECT * 
                FROM core.t_s94 
                WHERE fr > 1 OR fs > 1 OR ft > 1; ");

                return $infoFlickers ?: ['message' => 'No hay datos'];
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

    //KPI3
    public function getInfoDesbalancesTension($connection) {
        try {
            if(Schema::connection($connection)->hasTable('t_s95')) {
                $infoDesbalancesTension = DB::connection($connection)->select("
                SELECT * 
                FROM core.t_s95 
                WHERE vu > 2; ");

                return $infoDesbalancesTension ?: ['message' => 'No hay datos'];
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
            $fecha_inicio = $request->input('fecha_inicio');
            $fecha_fin = $request->input('fecha_fin');
            $id_ct = $request->input('id_ct');

            // Inicia el query con JOIN para filtrar por id_ct
            $query = "
                SELECT DISTINCT s.*
                FROM core.t_s64 s
                INNER JOIN core.t_equipos_sabt e ON s.rtu_id = e.id_rtu
                WHERE 1=1
            ";

            $params = [];

            // Filtro por ID_CT si viene en el request
            if ($id_ct) {
                $query .= " AND e.id_ct = :id_ct";
                $params['id_ct'] = $id_ct;
            }

            // Filtros por fecha
            if ($fecha_inicio && $fecha_fin) {
                $query .= " AND s.fh BETWEEN TO_TIMESTAMP(:fecha_inicio, 'YYYY-MM-DD') AND TO_TIMESTAMP(:fecha_fin, 'YYYY-MM-DD')";
                $params['fecha_inicio'] = $fecha_inicio;
                $params['fecha_fin'] = $fecha_fin;
            } elseif ($fecha_inicio) {
                $query .= " AND s.fh >= TO_TIMESTAMP(:fecha_inicio, 'YYYY-MM-DD')";
                $params['fecha_inicio'] = $fecha_inicio;
            } elseif ($fecha_fin) {
                $query .= " AND s.fh <= TO_TIMESTAMP(:fecha_fin, 'YYYY-MM-DD')";
                $params['fecha_fin'] = $fecha_fin;
            } else {
                $query .= " AND s.fh >= NOW() - INTERVAL '24 hours'";
            }

            $query .= " ORDER BY s.fh DESC LIMIT 20";

            $resultadosS64 = DB::connection($connection)->select($query, $params);

            return $resultadosS64 ?: ['message' => 'No hay datos'];
        } else {
            return ['message' => 'No hay datos'];
        }
    } catch(\Exception $e) {
        return ['message' => 'Error al consultar', 'error' => $e->getMessage()];
    }
}


    public function getAllG53(Request $request, $connection) {
    try {
        if(Schema::connection($connection)->hasTable('t_g53')) {
            $fecha_inicio = $request->input('fecha_inicio');
            $fecha_fin = $request->input('fecha_fin');
            $id_ct = $request->input('id_ct');

            $query = "
                SELECT DISTINCT s.* 
                FROM core.t_g53 s
                INNER JOIN core.t_equipos_sabt e ON s.rtu_id = e.id_rtu
                WHERE 1=1
            ";

            // Construcción dinámica
            if ($id_ct) {
                $query .= " AND e.id_ct = :id_ct";
            }

            if ($fecha_inicio && $fecha_fin) {
                $query .= " AND fh >= TO_TIMESTAMP(:fecha_inicio, 'YYYY-MM-DD')";
                $query .= " AND fh <= TO_TIMESTAMP(:fecha_fin, 'YYYY-MM-DD')";
            } elseif ($fecha_inicio) {
                $query .= " AND fh >= TO_TIMESTAMP(:fecha_inicio, 'YYYY-MM-DD')";
            } elseif ($fecha_fin) {
                $query .= " AND fh <= TO_TIMESTAMP(:fecha_fin, 'YYYY-MM-DD')";
            } else {
                $query .= " AND fh >= NOW() - INTERVAL '24 hours'";
            }

            $query .= " ORDER BY fh DESC LIMIT 20";

            $params = [];
            if ($id_ct) $params['id_ct'] = $id_ct;
            if ($fecha_inicio) $params['fecha_inicio'] = $fecha_inicio;
            if ($fecha_fin) $params['fecha_fin'] = $fecha_fin;

            return DB::connection($connection)->select($query, $params);
        } else {
            return ['message' => 'No hay datos'];
        }
    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }
}



    public function getAllS52(Request $request, $connection) {
    try {
        if (Schema::connection($connection)->hasTable('t_s52')) {
            $fecha_inicio = $request->input('fecha_inicio');
            $fecha_fin = $request->input('fecha_fin');
            $id_ct = $request->input('id_ct');

            $query = "
                SELECT DISTINCT s.* 
                FROM core.t_s52 s
                INNER JOIN core.t_equipos_sabt e ON s.rtu_id = e.id_rtu
                WHERE 1=1
            ";

            $params = [];

            if ($id_ct) {
                $query .= " AND e.id_ct = :id_ct";
                $params['id_ct'] = $id_ct;
            }

            if ($fecha_inicio && $fecha_fin) {
                $query .= " AND fec_inicio >= TO_TIMESTAMP(:fecha_inicio, 'YYYY-MM-DD')";
                $query .= " AND fec_fin <= TO_TIMESTAMP(:fecha_fin, 'YYYY-MM-DD')";
                $params['fecha_inicio'] = $fecha_inicio;
                $params['fecha_fin'] = $fecha_fin;
            } elseif ($fecha_inicio) {
                $query .= " AND fec_inicio >= TO_TIMESTAMP(:fecha_inicio, 'YYYY-MM-DD')";
                $params['fecha_inicio'] = $fecha_inicio;
            } elseif ($fecha_fin) {
                $query .= " AND fec_fin <= TO_TIMESTAMP(:fecha_fin, 'YYYY-MM-DD')";
                $params['fecha_fin'] = $fecha_fin;
            } else {
                $query .= " AND fec_inicio >= NOW() - INTERVAL '24 hours'";
            }

            $query .= " ORDER BY fec_inicio DESC LIMIT 20";

            $resultadosS52 = DB::connection($connection)->select($query, $params);

            return $resultadosS52 ?: ['message' => 'No hay datos db'];
        } else {
            return ['message' => 'La tabla t_s52 no existe'];
        }
    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }
}


    public function getAllS96(Request $request, $connection) {
    try {
        if (Schema::connection($connection)->hasTable('t_s96')) {
            $fecha_inicio = $request->input('fecha_inicio');
            $fecha_fin = $request->input('fecha_fin');
            $id_ct = $request->input('id_ct');

            $query = "
                SELECT DISTINCT s.*
                FROM core.t_s96 s
                INNER JOIN core.t_equipos_sabt e ON s.rtu_id = e.id_rtu
                WHERE 1=1
            ";

            $params = [];

            if ($id_ct) {
                $query .= " AND e.id_ct = :id_ct";
                $params['id_ct'] = $id_ct;
            }

            if ($fecha_inicio && $fecha_fin) {
                $query .= " AND fh >= TO_TIMESTAMP(:fecha_inicio, 'YYYY-MM-DD')";
                $query .= " AND fh <= TO_TIMESTAMP(:fecha_fin, 'YYYY-MM-DD')";
                $params['fecha_inicio'] = $fecha_inicio;
                $params['fecha_fin'] = $fecha_fin;
            } elseif ($fecha_inicio) {
                $query .= " AND fh >= TO_TIMESTAMP(:fecha_inicio, 'YYYY-MM-DD')";
                $params['fecha_inicio'] = $fecha_inicio;
            } elseif ($fecha_fin) {
                $query .= " AND fh <= TO_TIMESTAMP(:fecha_fin, 'YYYY-MM-DD')";
                $params['fecha_fin'] = $fecha_fin;
            } else {
                $query .= " AND fh >= NOW() - INTERVAL '24 hours'";
            }

            $query .= " ORDER BY fh DESC LIMIT 20";

            // Ejecutar consulta segura con parámetros
            $resultadosS96 = DB::connection($connection)->select($query, $params);

            return $resultadosS96 ?: ['message' => 'No hay datos db'];
        } else {
            return ['message' => 'La tabla t_s96 no existe'];
        }
    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }
}


    public function getAllS97(Request $request, $connection) {
    try {
        if (Schema::connection($connection)->hasTable('t_s97')) {
            $fecha_inicio = $request->input('fecha_inicio');
            $fecha_fin = $request->input('fecha_fin');
            $id_ct = $request->input('id_ct');

            $query = "
                SELECT DISTINCT s.*
                FROM core.t_s97 s
                INNER JOIN core.t_equipos_sabt e ON s.rtu_id = e.id_rtu
                WHERE 1=1
            ";

            $params = [];

            if ($id_ct) {
                $query .= " AND e.id_ct = :id_ct";
                $params['id_ct'] = $id_ct;
            }

            if ($fecha_inicio && $fecha_fin) {
                $query .= " AND fh >= TO_TIMESTAMP(:fecha_inicio, 'YYYY-MM-DD')";
                $query .= " AND fh <= TO_TIMESTAMP(:fecha_fin, 'YYYY-MM-DD')";
                $params['fecha_inicio'] = $fecha_inicio;
                $params['fecha_fin'] = $fecha_fin;
            } elseif ($fecha_inicio) {
                $query .= " AND fh >= TO_TIMESTAMP(:fecha_inicio, 'YYYY-MM-DD')";
                $params['fecha_inicio'] = $fecha_inicio;
            } elseif ($fecha_fin) {
                $query .= " AND fh <= TO_TIMESTAMP(:fecha_fin, 'YYYY-MM-DD')";
                $params['fecha_fin'] = $fecha_fin;
            } else {
                $query .= " AND fh >= NOW() - INTERVAL '24 hours'";
            }

            $query .= " ORDER BY fh DESC LIMIT 20";

            $resultadosS97 = DB::connection($connection)->select($query, $params);

            return $resultadosS97 ?: ['message' => 'No hay datos db'];
        } else {
            return ['message' => 'La tabla t_s97 no existe'];
        }
    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
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

    public function getCTSABT($id_ct, $connection) {
        try {
            if(Schema::connection($connection)->hasTable('t_ct')) {
                $ctSABT = DB::connection($connection)->select("
                SELECT * FROM core.t_ct
                WHERE id_ct = :id_ct", ['id_ct' => $id_ct]);

                return $ctSABT ?: ['message' => 'No hay datos'];
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