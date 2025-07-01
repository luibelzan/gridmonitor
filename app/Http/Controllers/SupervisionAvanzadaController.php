<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ct;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class SupervisionAvanzadaController extends Controller
{

    public function dashboardsabt(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Tu sesion ha expirado por inactividad');
        }

        Session::put('vistal_actual', 'dashboardsabt');

        $connection = User::conexion();

        if ($connection == 'psql') {
            return view('admin/admin');
        } else {
            $dashboardSABTInfo = $this->getDashboardSABTInfo($request, $connection);

            return view('supervisionavanzada/dashboardsabt', [
                'dashboardSABTInfo' => $dashboardSABTInfo,
            ]);
        }
    }

    public function supervisionavanzada(Request $request)
    {
        //Verificar si el usuario esta autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Tu sesion ha expirado por inactividad');
        }

        //Guardar el nombre de la vista actual en la sesion
        Session::put('vista_actual', 'supervisionavanzada');

        //Obtener la conexion dinamica
        $connection = User::conexion();

        if ($connection == 'psql') {
            //Si la conexion es la predeterminada, retornar un mensaje de bienvenida para el admin
            return view('admin/admin');
        } else {
            //Obtener los datos de todos los G53, S64, S52, S96, S97
            $tipo_evento = $request->input('tipo_evento');
            $id_ct = $request->input('id_ct');
            $ct_info = Ct::on($connection)->select('id_ct', 'nom_ct', 'ind_sabt')->get();
            $numTrafosAndCapacity = $this->getNumTrafosAndCapacity($id_ct, $connection);
            $numCups = $this->getNumCups($id_ct, $connection);
            $numAutoconsumos = $this->getNumAutoconsumos($id_ct, $connection);
            $numLineas = $this->getNumLineas($id_ct, $connection);
            $comunicaciones = $this->getComunicaciones($id_ct, $connection);
            $datosSABT = $this->getDatosSABT($id_ct, $connection);

            Session::put('id_ct', $id_ct);


            if ($tipo_evento == null) {
                $tipo_evento = 'S64';
            }

            if ($tipo_evento == 'S64') {
                $resultadosS64 = $this->getAllS64($request, $connection);
                return view('supervisionavanzada/supervisionavanzada', [
                    'resultadosS64' => $resultadosS64['paginatedS64'],
                    'resultadosS64Full' => $resultadosS64['allS64'],
                    'id_ct' => $id_ct,
                    'ct_info' => $ct_info,
                    'numTrafosAndCapacity' => $numTrafosAndCapacity,
                    'numCups' => $numCups,
                    'numAutoconsumos' => $numAutoconsumos,
                    'numLineas' => $numLineas,
                    'comunicaciones' => $comunicaciones,
                    'datosSABT' => $datosSABT
                ]);
            } else if ($tipo_evento == 'G53') {
                $resultadosG53 = $this->getAllG53($request, $connection);
                return view('supervisionavanzada/supervisionavanzada', [
                    'resultadosG53' => $resultadosG53['paginatedG53'],
                    'resultadosG53Full' => $resultadosG53['allG53'],
                    'id_ct' => $id_ct,
                    'ct_info' => $ct_info,
                    'numTrafosAndCapacity' => $numTrafosAndCapacity,
                    'numCups' => $numCups,
                    'numAutoconsumos' => $numAutoconsumos,
                    'numLineas' => $numLineas,
                    'comunicaciones' => $comunicaciones,
                    'datosSABT' => $datosSABT
                ]);
            } else if ($tipo_evento == 'S52') {
                $resultadosS52 = $this->getAllS52($request, $connection);
                return view('supervisionavanzada/supervisionavanzada', [
                    'resultadosS52' => $resultadosS52['paginatedS52'],
                    'resultadosS52Full' => $resultadosS52['allS52'],
                    'id_ct' => $id_ct,
                    'ct_info' => $ct_info,
                    'numTrafosAndCapacity' => $numTrafosAndCapacity,
                    'numCups' => $numCups,
                    'numAutoconsumos' => $numAutoconsumos,
                    'numLineas' => $numLineas,
                    'comunicaciones' => $comunicaciones,
                    'datosSABT' => $datosSABT
                ]);
            } else if ($tipo_evento == 'S96') {
                $resultadosS96 = $this->getAllS96($request, $connection);
                return view('supervisionavanzada/supervisionavanzada', [
                    'resultadosS96' => $resultadosS96['paginatedS96'],
                    'resultadosS96Full' => $resultadosS96['allS96'],
                    'id_ct' => $id_ct,
                    'ct_info' => $ct_info,
                    'numTrafosAndCapacity' => $numTrafosAndCapacity,
                    'numCups' => $numCups,
                    'numAutoconsumos' => $numAutoconsumos,
                    'numLineas' => $numLineas,
                    'comunicaciones' => $comunicaciones,
                    'datosSABT' => $datosSABT
                ]);
            } else if ($tipo_evento == 'S97') {
                $resultadosS97 = $this->getAllS97($request, $connection);
                return view('supervisionavanzada/supervisionavanzada', [
                    'resultadosS97' => $resultadosS97['paginatedS97'],
                    'resultadosS97Full' => $resultadosS97['allS97'],
                    'id_ct' => $id_ct,
                    'ct_info' => $ct_info,
                    'numTrafosAndCapacity' => $numTrafosAndCapacity,
                    'numCups' => $numCups,
                    'numAutoconsumos' => $numAutoconsumos,
                    'numLineas' => $numLineas,
                    'comunicaciones' => $comunicaciones,
                    'datosSABT' => $datosSABT
                ]);
            } else {
                return view('supervisionavanzada/supervisionavanzada', []);
            }




        }
    }

    public function indicadoressabt(Request $request)
    {

        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }

        //Guardar el nombre de la vista actual en la sesion
        Session::put('vista_actual', 'indicadoressabt');

        $connection = User::conexion();

        if ($connection == 'psql') {
            return view('admin');
        } else {

            $distorsionesArmonicas = $this->getDistorsionesArmonicas($request, $connection);
            $numDistorsionesArmonicas = $this->getNumDistorsionesArmonicas($request, $connection);
            $promedioFase = $this->getPromedioFase($request, $connection);
            $numFlickers = $this->getNumFlickers($request, $connection);
            $desbalancesTension = $this->getDesbalancesTension($request, $connection);
            $numDesbalancesTension = $this->getNumDesbalancesTension($request, $connection);
            $variacionesTension = $this->getVariacionesTension($request, $connection);
            $numVariacionesTension = $this->getNumVariacionesTension($request, $connection);
            $infoDistorsionesArmonicas = $this->getInfoDistorsionesArmonicas($request, $connection);
            $infoFlickers = $this->getInfoFlickers($request, $connection);
            $infoDesbalancesTension = $this->getInfoDesbalancesTension($request, $connection);
            $ct_info = Ct::on($connection)->select('id_ct', 'nom_ct', 'ind_sabt')->get();
            $id_ct = $request->input('id_ct');

            Session::put('id_ct', $id_ct);

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
                'ct_info' => $ct_info,
                'id_ct' => $id_ct,
            ]);
        }
    }

    public function fasessabt(Request $request)
    {
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

    public function calidadsabt(Request $request)
    {
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
        $id_ct = session('id_ct');

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

    public function balancessabt(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }

        Session::put('vista_actual', 'balancessabt');

        $connection = User::conexion();

        if ($connection == 'pgsql') {
            return view('admin/admin');
        } else {
            $ct_info = Ct::on($connection)->select('id_ct', 'nom_ct', 'ind_sabt')->get();
            $id_ct = $request->input('id_ct');
            $balancesSABT = $this->getBalancesSABT($request, $connection, $id_ct);
            $balancesFasesSABT = $this->getBalancesFaseSABT($request, $connection, $id_ct);

            Session::put('id_ct', $id_ct);

            return view('supervisionavanzada/balancessabt', [
                'balancesSABT' => $balancesSABT,
                'balancesFasesSABT' => $balancesFasesSABT,
                'ct_info' => $ct_info,
                'id_ct' => $id_ct,
            ]);
        }
    }

    public function getDashboardSABTInfo(Request $request, $connection)
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_ct')
                && Schema::connection($connection)->hasTable('t_trafos')
                && Schema::connection($connection)->hasTable('t_lineas')
                && Schema::connection($connection)->hasTable('t_cups')
            ) {
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

                if ($nom_ct) {
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
        } catch (\Exception $e) {
            return ['message' => 'No hay datos'];
        }
    }

    public function getBalancesSABT(Request $request, $connection, $id_ct)
    {
        try {
            if (Schema::connection($connection)->hasTable('t_balances_horarios_lineas')) {
                $fecha_inicio = $request->input('fecha_inicio');
                $fecha_fin = $request->input('fecha_fin');

                $params = ['id_ct' => $id_ct];

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
            WHERE
                id_ct = :id_ct";

                if ($fecha_inicio && $fecha_fin) {
                    $query .= " AND fecha_inicio >= :fecha_inicio AND fecha_inicio <= :fecha_fin";
                    $params['fecha_inicio'] = $fecha_inicio;
                    $params['fecha_fin'] = $fecha_fin;
                } else {
                    $query .= " AND fecha_inicio >= CURRENT_DATE - INTERVAL '30 days'";
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


    public function getBalancesFaseSABT(Request $request, $connection, $id_ct)
    {
        try {
            if (Schema::connection($connection)->hasTable('t_balances_horarios_fases')) {
                $fecha_inicio = $request->input('fecha_inicio');
                $fecha_fin = $request->input('fecha_fin');

                $params = ['id_ct' => $id_ct];

                $query = "
            SELECT
                id_ct,
                id_linea,

                -- FASE R
                SUM(COALESCE(lvs_ai_r, 0)) AS total_ai_lvs_r,
                SUM(COALESCE(lvs_ae_r, 0)) AS total_ae_lvs_r,
                SUM(COALESCE(lvs_ai_r, 0) + COALESCE(lvs_ae_r, 0)) AS total_lvs_r,
                SUM(COALESCE(cnt_ai_r, 0)) AS total_ai_cnt_r,
                SUM(COALESCE(cnt_ae_r, 0)) AS total_ae_cnt_r,
                SUM((COALESCE(lvs_ai_r, 0) + COALESCE(lvs_ae_r, 0)) - (COALESCE(cnt_ai_r, 0) + COALESCE(cnt_ae_r, 0))) AS perdida_energia_r,
                CASE
                    WHEN SUM(COALESCE(lvs_ai_r, 0) + COALESCE(lvs_ae_r, 0)) = 0 THEN 0
                    ELSE ROUND(
                        (SUM((COALESCE(lvs_ai_r, 0) + COALESCE(lvs_ae_r, 0)) - (COALESCE(cnt_ai_r, 0) + COALESCE(cnt_ae_r, 0))) * 100.0)
                        / SUM(COALESCE(lvs_ai_r, 0) + COALESCE(lvs_ae_r, 0)), 2)
                END AS porcentaje_perdida_r,

                -- FASE S
                SUM(COALESCE(lvs_ai_s, 0)) AS total_ai_lvs_s,
                SUM(COALESCE(lvs_ae_s, 0)) AS total_ae_lvs_s,
                SUM(COALESCE(lvs_ai_s, 0) + COALESCE(lvs_ae_s, 0)) AS total_lvs_s,
                SUM(COALESCE(cnt_ai_s, 0)) AS total_ai_cnt_s,
                SUM(COALESCE(cnt_ae_s, 0)) AS total_ae_cnt_s,
                SUM((COALESCE(lvs_ai_s, 0) + COALESCE(lvs_ae_s, 0)) - (COALESCE(cnt_ai_s, 0) + COALESCE(cnt_ae_s, 0))) AS perdida_energia_s,
                CASE
                    WHEN SUM(COALESCE(lvs_ai_s, 0) + COALESCE(lvs_ae_s, 0)) = 0 THEN 0
                    ELSE ROUND(
                        (SUM((COALESCE(lvs_ai_s, 0) + COALESCE(lvs_ae_s, 0)) - (COALESCE(cnt_ai_s, 0) + COALESCE(cnt_ae_s, 0))) * 100.0)
                        / SUM(COALESCE(lvs_ai_s, 0) + COALESCE(lvs_ae_s, 0)), 2)
                END AS porcentaje_perdida_s,

                -- FASE T
                SUM(COALESCE(lvs_ai_t, 0)) AS total_ai_lvs_t,
                SUM(COALESCE(lvs_ae_t, 0)) AS total_ae_lvs_t,
                SUM(COALESCE(lvs_ai_t, 0) + COALESCE(lvs_ae_t, 0)) AS total_lvs_t,
                SUM(COALESCE(cnt_ai_t, 0)) AS total_ai_cnt_t,
                SUM(COALESCE(cnt_ae_t, 0)) AS total_ae_cnt_t,
                SUM((COALESCE(lvs_ai_t, 0) + COALESCE(lvs_ae_t, 0)) - (COALESCE(cnt_ai_t, 0) + COALESCE(cnt_ae_t, 0))) AS perdida_energia_t,
                CASE
                    WHEN SUM(COALESCE(lvs_ai_t, 0) + COALESCE(lvs_ae_t, 0)) = 0 THEN 0
                    ELSE ROUND(
                        (SUM((COALESCE(lvs_ai_t, 0) + COALESCE(lvs_ae_t, 0)) - (COALESCE(cnt_ai_t, 0) + COALESCE(cnt_ae_t, 0))) * 100.0)
                        / SUM(COALESCE(lvs_ai_t, 0) + COALESCE(lvs_ae_t, 0)), 2)
                END AS porcentaje_perdida_t

            FROM
                core.t_balances_horarios_fases
            WHERE
                id_ct = :id_ct";

                if ($fecha_inicio && $fecha_fin) {
                    $query .= " AND fecha_inicio >= :fecha_inicio AND fecha_inicio <= :fecha_fin";
                    $params['fecha_inicio'] = $fecha_inicio;
                    $params['fecha_fin'] = $fecha_fin;
                } else {
                    $query .= " AND fecha_inicio >= CURRENT_DATE - INTERVAL '30 days'";
                }

                $query .= " GROUP BY
                            id_ct,
                            id_linea
                        ORDER BY
                            id_ct,
                            id_linea;";

                $balancesFasesSABT = DB::connection($connection)->select($query, $params);

                return $balancesFasesSABT ?: ['message' => 'No hay datos'];
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            return ['message' => 'Error: ' . $e->getMessage()];
        }
    }


    //KPI1
    public function getDistorsionesArmonicas(Request $request, $connection)
    {
        try {
            if (!Schema::connection($connection)->hasTable('t_s96')) {
                return ['message' => 'No hay datos'];
            }

            $id_ct = $request->input('id_ct');

            $query = "
            SELECT  
                s.rtu_id,
                AVG(s.hr_thd) AS avg_hr_thd,  
                AVG(s.hs_thd) AS avg_hs_thd,  
                AVG(s.ht_thd) AS avg_ht_thd
            FROM core.t_s96 s
            INNER JOIN core.t_equipos_sabt e ON s.rtu_id = e.id_rtu
            WHERE s.fh >= NOW() - INTERVAL '72 hours'
        ";

            $params = [];

            if ($id_ct) {
                $query .= " AND e.id_ct = :id_ct";
                $params['id_ct'] = $id_ct;
            }

            $query .= " GROUP BY s.rtu_id";

            $distorsionesArmonicas = DB::connection($connection)->select($query, $params);

            return $distorsionesArmonicas ?: ['message' => 'No hay datos'];

        } catch (\Exception $e) {
            return ['message' => 'No hay datos'];
        }
    }


    //KPI1
    public function getNumDistorsionesArmonicas(Request $request, $connection)
    {
        try {
            if (!Schema::connection($connection)->hasTable('t_s96')) {
                return ['message' => 'No hay datos'];
            }

            $id_ct = $request->input('id_ct');

            $query = "
            SELECT COUNT(*) AS total_distorsiones 
            FROM core.t_s96 s
            INNER JOIN core.t_equipos_sabt e ON s.rtu_id = e.id_rtu
            WHERE (s.hr_thd > 8 OR s.hs_thd > 8 OR s.ht_thd > 8)
        ";

            $params = [];

            if ($id_ct) {
                $query .= " AND e.id_ct = :id_ct";
                $params['id_ct'] = $id_ct;
            }

            $result = DB::connection($connection)->select($query, $params);

            return $result ?: ['message' => 'No hay datos'];

        } catch (\Exception $e) {
            return ['message' => 'No hay datos'];
        }
    }



    //KPI1
    public function getInfoDistorsionesArmonicas(Request $request, $connection)
    {
        try {
            if (!Schema::connection($connection)->hasTable('t_s96')) {
                return ['message' => 'No hay datos'];
            }

            $id_ct = $request->input('id_ct');

            $query = "
            SELECT s.*
            FROM core.t_s96 s
            INNER JOIN core.t_equipos_sabt e ON s.rtu_id = e.id_rtu
            WHERE s.hr_thd > 8 OR s.hs_thd > 8 OR s.ht_thd > 8
        ";

            $params = [];

            if ($id_ct) {
                $query .= " AND e.id_ct = :id_ct";
                $params['id_ct'] = $id_ct;
            }

            $result = DB::connection($connection)->select($query, $params);

            return $result ?: ['message' => 'No hay datos'];

        } catch (\Exception $e) {
            return ['message' => 'No hay datos'];
        }
    }


    //KPI2
    public function getPromedioFase(Request $request, $connection)
    {
        try {
            if (!Schema::connection($connection)->hasTable('t_s94')) {
                return ['message' => 'No hay datos'];
            }

            $id_ct = $request->input('id_ct');

            $query = "
            SELECT  
                AVG(s.fr) AS avg_fr, 
                AVG(s.fs) AS avg_fs, 
                AVG(s.ft) AS avg_ft
            FROM core.t_s94 s
            INNER JOIN core.t_equipos_sabt e ON s.rtu_id = e.id_rtu
            WHERE s.fh >= NOW() - INTERVAL '3 days'
        ";

            $params = [];

            if ($id_ct) {
                $query .= " AND e.id_ct = :id_ct";
                $params['id_ct'] = $id_ct;
            }

            $result = DB::connection($connection)->select($query, $params);

            return $result ?: ['message' => 'No hay datos'];

        } catch (\Exception $e) {
            return ['message' => 'No hay datos'];
        }
    }


    //KPI2
    public function getNumFlickers(Request $request, $connection)
    {
        try {
            if (!Schema::connection($connection)->hasTable('t_s94')) {
                return ['message' => 'No hay datos'];
            }

            $id_ct = $request->input('id_ct');

            $query = "
            SELECT COUNT(*) AS total_flickers 
            FROM core.t_s94 s
            INNER JOIN core.t_equipos_sabt e ON s.rtu_id = e.id_rtu
            WHERE (s.fr > 1 OR s.fs > 1 OR s.ft > 1)
        ";

            $params = [];

            if ($id_ct) {
                $query .= " AND e.id_ct = :id_ct";
                $params['id_ct'] = $id_ct;
            }

            $result = DB::connection($connection)->select($query, $params);

            return $result ?: ['message' => 'No hay datos'];

        } catch (\Exception $e) {
            return ['message' => 'No hay datos'];
        }
    }


    //KPI2
    public function getInfoFlickers(Request $request, $connection)
    {
        try {
            if (!Schema::connection($connection)->hasTable('t_s94')) {
                return ['message' => 'No hay datos'];
            }

            $id_ct = $request->input('id_ct');

            $query = "
            SELECT s.*
            FROM core.t_s94 s
            INNER JOIN core.t_equipos_sabt e ON s.rtu_id = e.id_rtu
            WHERE s.fr > 1 OR s.fs > 1 OR s.ft > 1
        ";

            $params = [];

            if ($id_ct) {
                $query .= " AND e.id_ct = :id_ct";
                $params['id_ct'] = $id_ct;
            }

            $result = DB::connection($connection)->select($query, $params);

            return $result ?: ['message' => 'No hay datos'];

        } catch (\Exception $e) {
            return ['message' => 'No hay datos'];
        }
    }


    //KPI3
    public function getDesbalancesTension(Request $request, $connection)
    {
        try {
            if (!Schema::connection($connection)->hasTable('t_s95')) {
                return ['message' => 'No hay datos'];
            }

            $id_ct = $request->input('id_ct');

            $query = "
            SELECT AVG(s.vu) AS avg_desbalance_tension
            FROM core.t_s95 s
            INNER JOIN core.t_equipos_sabt e ON s.rtu_id = e.id_rtu
            WHERE s.fh >= NOW() - INTERVAL '72 hours'
        ";

            $params = [];

            if ($id_ct) {
                $query .= " AND e.id_ct = :id_ct";
                $params['id_ct'] = $id_ct;
            }

            $result = DB::connection($connection)->select($query, $params);

            return $result ?: ['message' => 'No hay datos'];

        } catch (\Exception $e) {
            return ['message' => 'No hay datos'];
        }
    }


    //KPI3
    public function getNumDesbalancesTension(Request $request, $connection)
    {
        try {
            if (!Schema::connection($connection)->hasTable('t_s95')) {
                return ['message' => 'No hay datos'];
            }

            $id_ct = $request->input('id_ct');

            $query = "
            SELECT COUNT(*) AS total_desbalances 
            FROM core.t_s95 s
            INNER JOIN core.t_equipos_sabt e ON s.rtu_id = e.id_rtu
            WHERE s.vu > 2
        ";

            $params = [];

            if ($id_ct) {
                $query .= " AND e.id_ct = :id_ct";
                $params['id_ct'] = $id_ct;
            }

            $result = DB::connection($connection)->select($query, $params);

            return $result ?: ['message' => 'No hay datos'];

        } catch (\Exception $e) {
            return ['message' => 'No hay datos'];
        }
    }


    //KPI3
    public function getInfoDesbalancesTension(Request $request, $connection)
    {
        try {
            if (!Schema::connection($connection)->hasTable('t_s95')) {
                return ['message' => 'No hay datos'];
            }

            $id_ct = $request->input('id_ct');

            $query = "
            SELECT s.* 
            FROM core.t_s95 s
            INNER JOIN core.t_equipos_sabt e ON s.rtu_id = e.id_rtu
            WHERE s.vu > 2
        ";

            $params = [];

            if ($id_ct) {
                $query .= " AND e.id_ct = :id_ct";
                $params['id_ct'] = $id_ct;
            }

            $result = DB::connection($connection)->select($query, $params);

            return $result ?: ['message' => 'No hay datos'];

        } catch (\Exception $e) {
            return ['message' => 'No hay datos'];
        }
    }


    //KPI4
    public function getVariacionesTension(Request $request, $connection)
    {
        try {
            if (!Schema::connection($connection)->hasTable('t_s97')) {
                return ['message' => 'No hay datos'];
            }

            $id_ct = $request->input('id_ct');

            $query = "
            SELECT 
                SUM(s.nr) AS total_variaciones_r, 
                SUM(s.ns) AS total_variaciones_s, 
                SUM(s.nt) AS total_variaciones_t
            FROM core.t_s97 s
            INNER JOIN core.t_equipos_sabt e ON s.rtu_id = e.id_rtu
            WHERE s.fh >= NOW() - INTERVAL '72 hours'
        ";

            $params = [];

            if ($id_ct) {
                $query .= " AND e.id_ct = :id_ct";
                $params['id_ct'] = $id_ct;
            }

            $result = DB::connection($connection)->select($query, $params);

            return $result ?: ['message' => 'No hay datos'];

        } catch (\Exception $e) {
            return ['message' => 'No hay datos'];
        }
    }


    public function getNumVariacionesTension(Request $request, $connection)
    {
        try {
            if (!Schema::connection($connection)->hasTable('t_s97')) {
                return ['message' => 'No hay datos'];
            }

            $id_ct = $request->input('id_ct');

            $query = "
            SELECT 
                s.id_rtu, 
                SUM(s.nr) AS sum_nr, 
                SUM(s.ns) AS sum_ns, 
                SUM(s.nt) AS sum_nt
            FROM core.t_s97 s
            INNER JOIN core.t_equipos_sabt e ON s.rtu_id = e.id_rtu
        ";

            $params = [];

            if ($id_ct) {
                $query .= " WHERE e.id_ct = :id_ct";
                $params['id_ct'] = $id_ct;
            }

            $query .= " GROUP BY s.id_rtu";

            $result = DB::connection($connection)->select($query, $params);

            return $result ?: ['message' => 'No hay datos'];

        } catch (\Exception $e) {
            return ['message' => 'No hay datos'];
        }
    }



    public function getAllS64(Request $request, $connection)
    {
        try {
            if (Schema::connection($connection)->hasTable('t_s64')) {
                $fecha_inicio = $request->input('fecha_inicio');
                $fecha_fin = $request->input('fecha_fin');
                $id_ct = $request->input('id_ct');

                // Inicia el query con JOIN para filtrar por id_ct
                $query = "
                SELECT DISTINCT s.*, e.id_linea
                FROM core.t_s64 s
                INNER JOIN core.t_equipos_sabt e 
                    ON s.rtu_id = e.id_rtu 
                    AND s.lvs_id = e.id_equipo
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
                    $query .= " AND s.fh >= NOW() - INTERVAL '48 hours'";
                }

                $query .= " ORDER BY s.fh DESC, e.id_linea ASC";

                $resultadosS64 = DB::connection($connection)->select($query, $params);
                $resultadosS64Collection = new Collection($resultadosS64);
                $currentPage = LengthAwarePaginator::resolveCurrentPage();
                $perPage = 100;
                $currentItems = $resultadosS64Collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
                
                $resultadosS64 = new LengthAwarePaginator($currentItems, count($resultadosS64Collection), $perPage, $currentPage, [
                    'path' => request()->url(),
                    'query' => request()->query()
                ]);
                $resultadosS64Full = DB::connection($connection)->select($query, $params);

                return [
                    'paginatedS64' => $resultadosS64,
                    'allS64' => $resultadosS64Full
                ];
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            return ['message' => 'Error al consultar', 'error' => $e->getMessage()];
        }
    }


    public function getAllG53(Request $request, $connection)
    {
        try {
            if (Schema::connection($connection)->hasTable('t_g53')) {
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
                    $query .= " AND fh >= NOW() - INTERVAL '48 hours'";
                }

                $query .= " ORDER BY fh DESC";

                $params = [];
                if ($id_ct)
                    $params['id_ct'] = $id_ct;
                if ($fecha_inicio)
                    $params['fecha_inicio'] = $fecha_inicio;
                if ($fecha_fin)
                    $params['fecha_fin'] = $fecha_fin;

                $resultadosG53 = DB::connection($connection)->select($query, $params);
                $resultadosG53Collection = new Collection($resultadosG53);
                $currentPage = LengthAwarePaginator::resolveCurrentPage();
                $perPage = 100;
                $currentItems = $resultadosG53Collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
                
                $resultadosG53 = new LengthAwarePaginator($currentItems, count($resultadosG53Collection), $perPage, $currentPage, [
                    'path' => request()->url(),
                    'query' => request()->query()
                ]);
                $resultadosG53Full = DB::connection($connection)->select($query, $params);

                return [
                    'paginatedG53' => $resultadosG53,
                    'allG53' => $resultadosG53Full
                ];

            } else {
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }



    public function getAllS52(Request $request, $connection)
    {
        try {
            if (Schema::connection($connection)->hasTable('t_s52')) {
                $fecha_inicio = $request->input('fecha_inicio');
                $fecha_fin = $request->input('fecha_fin');
                $id_ct = $request->input('id_ct');

                $query = "
                SELECT DISTINCT s.*, e.id_linea 
                FROM core.t_s52 s
                INNER JOIN core.t_equipos_sabt e 
                    ON s.rtu_id = e.id_rtu 
                    AND s.lvs_id = e.id_equipo
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
                    $query .= " AND fec_inicio >= NOW() - INTERVAL '48 hours'";
                }

                $query .= " ORDER BY s.fec_inicio, s.hor_inicio DESC, e.id_linea ASC";

                $resultadosS52 = DB::connection($connection)->select($query, $params);
                $resultadosS52Collection = new Collection($resultadosS52);
                $currentPage = LengthAwarePaginator::resolveCurrentPage();
                $perPage = 100;
                $currentItems = $resultadosS52Collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
                
                $resultadosS52 = new LengthAwarePaginator($currentItems, count($resultadosS52Collection), $perPage, $currentPage, [
                    'path' => request()->url(),
                    'query' => request()->query()
                ]);
                $resultadosS52Full = DB::connection($connection)->select($query, $params);

                return [
                    'paginatedS52' => $resultadosS52,
                    'allS52' => $resultadosS52Full
                ];
            } else {
                return ['message' => 'La tabla t_s52 no existe'];
            }
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }


    public function getAllS96(Request $request, $connection)
    {
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
                    $query .= " AND fh >= NOW() - INTERVAL '48 hours'";
                }

                $query .= " ORDER BY fh DESC";

                // Ejecutar consulta segura con parámetros
                $resultadosS96 = DB::connection($connection)->select($query, $params);
                $resultadosS96Collection = new Collection($resultadosS96);
                $currentPage = LengthAwarePaginator::resolveCurrentPage();
                $perPage = 100;
                $currentItems = $resultadosS96Collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
                
                $resultadosS96 = new LengthAwarePaginator($currentItems, count($resultadosS96Collection), $perPage, $currentPage, [
                    'path' => request()->url(),
                    'query' => request()->query()
                ]);
                $resultadosS96Full = DB::connection($connection)->select($query, $params);

                return [
                    'paginatedS96' => $resultadosS96,
                    'allS96' => $resultadosS96Full
                ];
            } else {
                return ['message' => 'La tabla t_s96 no existe'];
            }
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }


    public function getAllS97(Request $request, $connection)
    {
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
                    $query .= " AND fh >= NOW() - INTERVAL '48 hours'";
                }

                $query .= " ORDER BY fh DESC";

                $resultadosS97 = DB::connection($connection)->select($query, $params);
                $resultadosS97Collection = new Collection($resultadosS97);
                $currentPage = LengthAwarePaginator::resolveCurrentPage();
                $perPage = 100;
                $currentItems = $resultadosS97Collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
                
                $resultadosS97 = new LengthAwarePaginator($currentItems, count($resultadosS97Collection), $perPage, $currentPage, [
                    'path' => request()->url(),
                    'query' => request()->query()
                ]);
                $resultadosS97Full = DB::connection($connection)->select($query, $params);

                return [
                    'paginatedS97' => $resultadosS97,
                    'allS97' => $resultadosS97Full
                ];
            } else {
                return ['message' => 'La tabla t_s97 no existe'];
            }
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }


    public function getFasesSABT($id_ct, $connection)
    {
        try {
            if (Schema::connection($connection)->hasTable('t_cups')) {
                $fasessabt = DB::connection($connection)->select("
                 SELECT * FROM core.t_cups 
                 WHERE id_ct = :id_ct", ['id_ct' => $id_ct]);

                return $fasessabt ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico 
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            return ['message' => 'No hay datos'];
        }
    }

    public function getCTSABT($id_ct, $connection)
    {
        try {
            if (Schema::connection($connection)->hasTable('t_ct')) {
                $ctSABT = DB::connection($connection)->select("
                SELECT * FROM core.t_ct
                WHERE id_ct = :id_ct", ['id_ct' => $id_ct]);

                return $ctSABT ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico 
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            return ['message' => 'No hay datos'];
        }
    }



    public function getTramos(Request $request, $connection)
    {
        try {
            if (Schema::connection($connection)->hasTable('t_tramos')) {
                $query = "
                SELECT *
                FROM core.t_tramos
                ";

                $tramos = DB::connection($connection)->select($query);

                return $tramos ?: ['message' => 'No hay datos'];
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            return ['message' => 'No hay datos error', $e];
        }
    }

    public function getNumTrafosAndCapacity($id_ct, $connection)
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_ct') &&
                Schema::connection($connection)->hasTable('t_concentradores') &&
                Schema::connection($connection)->hasTable('t_supervisores') &&
                Schema::connection($connection)->hasTable('t_trafos')
            ) {
                $numTrafosAndCapacity = DB::connection($connection)
                    ->select('
                    SELECT
                        count(t_trafos.id_trafo) as nro_trafos,
                        t_ct.id_ct,
                        t_ct.nom_ct,
                        t_ct.lat_ct,  
						t_ct.lon_ct,
                        t_concentradores.id_cnc,
                        t_concentradores.cod_mod,
                        t_concentradores.des_cnc_af,
                        t_concentradores.des_vdlms,
                        t_supervisores.id_svr,
                        t_supervisores.id_trafo,
                        t_trafos.nom_trafo,
                        sum(t_trafos.val_kva) as kva_ct
                    FROM
                        core.t_ct,
                        core.t_concentradores,
                        core.t_supervisores,
                        core.t_trafos
                    WHERE
                        t_concentradores.id_ct = t_ct.id_ct AND
                        t_supervisores.id_trafo = t_trafos.id_trafo AND
                        t_trafos.id_cnc = t_concentradores.id_cnc AND
                        t_ct.id_ct = :id_ct
                    GROUP BY
                        t_ct.id_ct, t_ct.nom_ct, t_concentradores.id_cnc,
                        t_concentradores.cod_mod, t_concentradores.des_cnc_af,
                        t_concentradores.des_vdlms,
                        t_supervisores.id_svr, t_supervisores.id_trafo,
                        t_trafos.nom_trafo
                    ORDER BY
                        t_ct.id_ct ASC, t_ct.nom_ct ASC;
                ', ['id_ct' => $id_ct]);


                // dd($resultadosQ1);


                return $numTrafosAndCapacity ?: ['message' => 'No hay datos'];
            } else {
                // La tabla no existe, retornar un mensaje específico 
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }

    public function getNumCups($id_ct, $connection)
    {
        try {
            if (Schema::connection($connection)->hasTable('t_cups')) {
                $numCups = DB::connection($connection)
                    ->select('
                    SELECT count(*) as nro_cups
                    FROM core.t_cups
                    WHERE t_cups.id_ct = :id_ct;
                ', ['id_ct' => $id_ct]);




                return empty($numCups) ? [['nro_cups' => 0]] : $numCups;
            } else {
                // La tabla no existe, retornar un mensaje específico 
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }

    public function getNumAutoconsumos($id_ct, $connection)
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_cups') &&
                Schema::connection($connection)->hasTable('t_ct')
            ) {
                $numAutoconsumos = DB::connection($connection)
                    ->select("
                        SELECT count(*) as nro_autoconsumos
                        FROM core.t_cups, core.t_ct
                        WHERE 
                        t_cups.ind_autoconsumo = 'S' AND
                        t_cups.id_ct = t_ct.id_ct AND
                        t_cups.id_ct = :id_ct;
                    ", ['id_ct' => $id_ct]);




                return empty($numAutoconsumos) ? [['nro_autoconsumos' => 0]] : $numAutoconsumos;
            } else {
                // Una de las tablas no existe, retornar un mensaje específico 
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }

    public function getNumLineas($id_ct, $connection)
    {
        try {
            if (Schema::connection($connection)->hasTable('t_lineas')) {
                $numLineas = DB::connection($connection)
                    ->select("
                        SELECT count(id_linea) as nro_lineas
                        FROM core.t_lineas
                        WHERE t_lineas.id_trafo = id_trafo
                        AND t_lineas.id_ct = :id_ct;
                    ", ['id_ct' => $id_ct]);




                return empty($numLineas) ? [['nro_lineas' => 0]] : $numLineas;
            } else {
                // La tabla no existe, retornar un mensaje específico 
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }

    public function getComunicaciones($id_ct, $connection)
    {
        if ($id_ct) {
            // Verificar si la tabla existe
            if (Schema::connection($connection)->hasTable('t_hw_comunicaciones')) {
                // La tabla existe, ejecutar la consulta
                $comunicaciones = DB::connection($connection)
                    ->select("
                    SELECT * FROM core.t_hw_comunicaciones
                    WHERE id_ct = :id_ct
                    ", ['id_ct' => $id_ct]);
                return $comunicaciones ?: [];
            } else {
                // La tabla no existe, retornar un array vacío 
                return [];
            }
        }
    }

    public function getDatosSABT($id_ct, $connection)
    {
        if ($id_ct) {
            if (
                Schema::connection($connection)->hasTable('t_equipos_sabt') &&
                Schema::connection($connection)->hasTable('t_s62')
            ) {
                $datosSABT = DB::connection($connection)
                    ->select("
                    SELECT
                        sabt.id_rtu AS id,
                        s62.mod AS modelo,
                        s62.af AS anio,
                        s62.te AS tipo,
                        s62.vf AS firmware,
                        s62.\"revConf\" AS config
                    FROM
                        core.t_equipos_sabt sabt
                    JOIN
                        core.t_s62 s62
                        ON sabt.id_rtu = s62.id_rtu
                    WHERE 
                        sabt.id_ct = :id_ct;
                ", [$id_ct]);

                return $datosSABT ?: [];
            }
        }
        return [];
    }

}