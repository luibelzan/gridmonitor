<?php




namespace App\Http\Controllers;


use App\Exports\EventosPFExport;
use App\Exports\ReportesPFCierresMensualesExport;
use App\Exports\ReportesPFCurvasCuartihorariasExport;
use App\Jobs\ExportCurvasCuartihorariasJob;
use App\Exports\ResultsExport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel; 
use Maatwebsite\Excel\Excel as ExcelFormat;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use App\Models\ExportProgress;





class PuntoFronteraController extends Controller
{
    public function informacionpf(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }




        $id_cnt = $request->input('id_cnt');
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');




        // Guardar el id_cnt en la sesión
        Session::put('id_cnt', $id_cnt);




        // Guardar el nombre de la vista actual en la sesión
        Session::put('vista_actual', 'informacionpf');




        // Obtener la conexión dinámica con la base de datos MYSQL
        $connectionpf = User::conexionPuntoFrontera();




        $user = Auth::user(); //obtenemos los datos del usuario autenticado




        $cod_id_group = $user->cod_id_group; //metemos el codigo del grupo del usuario autentiado en la variable
        // dd($cod_id_group);




        //llamadas a las funciones
        $datos = $this->datosGrupos($connectionpf);
        $parametros = $this->parametros($connectionpf);
        $resultadosQ1pf = $this->consultaUnopf($id_cnt, $connectionpf);
        $resultadosQ2pf = $this->consultaDospf($id_cnt, $connectionpf);
        $resultadosQ3pf = $this->consultaTrespf($id_cnt, $connectionpf);
        $resultadosQ4pf = $this->consultaCuatropf($id_cnt, $connectionpf);
        //$resultadosQ5pf = $this->consultaCincopf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin);
        $resultadosQ6pf = $this->consultaSeispf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin);
        $resultadosQ7pf = $this->consultaSietepf($id_cnt, $connectionpf);
        $resultadosQ26pf = $this->consultaVeintiSeispf($id_cnt, $connectionpf);
        $resultadosQ27pf = $this->consultaVeintiSietepf($id_cnt, $connectionpf);
        $resultadosQ28pf = $this->consultaVeintiOchopf($id_cnt, $connectionpf);
        $mostrarcurvascuartihorarias = $this->mostrarCurvasCuartihorarias($id_cnt, $connectionpf);


        // Pasar los datos de los a la vista
        return view('puntofrontera/informacionpf', [
            'user' => $user,
            'cod_id_group' => $cod_id_group,
            'id_cnt' => $id_cnt,
            'selected_cnt' => $id_cnt,
            'datos' => $datos,
            'parametros' => $parametros,
            'resultadosQ1pf' => $resultadosQ1pf,
            'resultadosQ2pf' => $resultadosQ2pf,
            'resultadosQ3pf' => $resultadosQ3pf,
            'resultadosQ4pf' => $resultadosQ4pf,
            //'resultadosQ5pf' => $resultadosQ5pf,
            'resultadosQ6pf' => $resultadosQ6pf,
            'resultadosQ7pf' => $resultadosQ7pf,
            'resultadosQ26pf' => $resultadosQ26pf,
            'resultadosQ27pf' => $resultadosQ27pf,
            'resultadosQ28pf' => $resultadosQ28pf,
            'mostrarcurvascuartihorarias' => $mostrarcurvascuartihorarias,


        ]);
    }




    public function curvashorariaspf(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }




        $id_cnt = $request->input('id_cnt');
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');




        // Guardar el id_cnt en la sesión
        Session::put('id_cnt', $id_cnt);


        // Guardar el nombre de la vista actual en la sesión
        Session::put('vista_actual', 'curvashorariaspf');




        // Obtener la conexión dinámica con la base de datos MYSQL
        $connectionpf = User::conexionPuntoFrontera();




        $user = Auth::user(); //obtenemos los datos del usuario autenticado




        $cod_id_group = $user->cod_id_group; //metemos el codigo del grupo del usuario autentiado en la variable
        // dd($cod_id_group);




        //llamadas a las funciones
        $datos = $this->datosGrupos($connectionpf);
        $parametros = $this->parametros($connectionpf);
        $resultadosQ1pf = $this->consultaUnopf($id_cnt, $connectionpf);
        $resultadosQ8pf = $this->consultaOchopf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin);
        $resultadosQ12pf = $this->consultaDocepf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin);
        $resultadosQ13pf = $this->consultaTrecepf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin);
        $resultadosQ14pf = $this->consultaCatorcepf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin);
        $resultadosQ15pf = $this->consultaQuincepf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin);
        $resultadosQ16pf = $this->consultaDieciseispf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin);
        $mostrarcurvascuartihorarias = $this->mostrarCurvasCuartihorarias($id_cnt, $connectionpf);


        // Pasar los datos de los a la vista
        return view('puntofrontera/curvashorariaspf', [
            'user' => $user,
            'cod_id_group' => $cod_id_group,
            'id_cnt' => $id_cnt,
            'selected_cnt' => $id_cnt,
            'datos' => $datos,
            'parametros' => $parametros,
            'resultadosQ1pf' => $resultadosQ1pf,
            'resultadosQ8pf' => $resultadosQ8pf,
            'resultadosQ12pf' => $resultadosQ12pf,
            'resultadosQ13pf' => $resultadosQ13pf,
            'resultadosQ14pf' => $resultadosQ14pf,
            'resultadosQ15pf' => $resultadosQ15pf,
            'resultadosQ16pf' => $resultadosQ16pf,
            'mostrarcurvascuartihorarias' => $mostrarcurvascuartihorarias,


        ]);
    }


    public function eventospf(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }




        $id_cnt = $request->input('id_cnt');
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');




        // Guardar el id_cnt en la sesión
        Session::put('id_cnt', $id_cnt);




        // Guardar el nombre de la vista actual en la sesión
        Session::put('vista_actual', 'eventospf');




        // Obtener la conexión dinámica con la base de datos MYSQL
        $connectionpf = User::conexionPuntoFrontera();




        $user = Auth::user(); //obtenemos los datos del usuario autenticado




        $cod_id_group = $user->cod_id_group; //metemos el codigo del grupo del usuario autentiado en la variable
        // dd($cod_id_group);




        //llamadas a las funciones
        $datos = $this->datosGrupos($connectionpf);
        $parametros = $this->parametros($connectionpf);


        $resultadosQ1pf = $this->consultaUnopf($id_cnt, $connectionpf);
        $resultadosQ9pf = $this->consultaNuevepf($id_cnt, $connectionpf);
        $resultadosQ10pf = $this->consultaDiezpf($id_cnt, $connectionpf);
        $resultadosQ11pf = $this->consultaOncepf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin, $request);
        $resultadosQ11pfFiltro =  $this->buscarDescripcion($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin, $request);
        $mostrarcurvascuartihorarias = $this->mostrarCurvasCuartihorarias($id_cnt, $connectionpf);
        $exportEventsPF = $this->exportEventsPF($request);



        // Pasar los datos de los a la vista
        return view('puntofrontera/eventospf', [
            'user' => $user,
            'cod_id_group' => $cod_id_group,
            'id_cnt' => $id_cnt,
            'selected_cnt' => $id_cnt,
            'datos' => $datos,
            'parametros' => $parametros,
            'resultadosQ1pf' => $resultadosQ1pf,
            'resultadosQ9pf' => $resultadosQ9pf,
            'resultadosQ10pf' => $resultadosQ10pf,
            'resultadosQ11pf' => $resultadosQ11pf,
            'resultadosQ11pfFiltro' => $resultadosQ11pfFiltro,
            'mostrarcurvascuartihorarias' => $mostrarcurvascuartihorarias,
            'exportEventsPF' => $exportEventsPF,


        ]);
    }


    public function curvascuartihorariaspf(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }




        $id_cnt = $request->input('id_cnt');
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');




        // Guardar el id_cnt en la sesión
        Session::put('id_cnt', $id_cnt);


        // Guardar el nombre de la vista actual en la sesión
        Session::put('vista_actual', 'curvascuartihorariaspf');




        // Obtener la conexión dinámica con la base de datos MYSQL
        $connectionpf = User::conexionPuntoFrontera();
        $user = Auth::user(); //obtenemos los datos del usuario autenticado
        $cod_id_group = $user->cod_id_group; //metemos el codigo del grupo del usuario autentiado en la variable
        // dd($cod_id_group);
        // dd($user);


        //llamadas a las funciones
        $datos = $this->datosGrupos($connectionpf);
        $parametros = $this->parametros($connectionpf);
        $resultadosQ1pf = $this->consultaUnopf($id_cnt, $connectionpf);
        $resultadosQ17pf = $this->consultaDiecisietepf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin);
        $resultadosQ18pf = $this->consultaDieciochopf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin);
        $resultadosQ19pf = $this->consultaDiecinuevepf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin);
        $resultadosQ20pf = $this->consultaVeintepf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin);
        $resultadosQ21pf = $this->consultaVeintiunopf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin);
        $resultadosQ22pf = $this->consultaVeintidospf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin);
        $mostrarcurvascuartihorarias = $this->mostrarCurvasCuartihorarias($id_cnt, $connectionpf);




        // Pasar los datos de los a la vista
        return view('puntofrontera/curvascuartihorariaspf', [
            'user' => $user,
            'cod_id_group' => $cod_id_group,
            'id_cnt' => $id_cnt,
            'selected_cnt' => $id_cnt,
            'datos' => $datos,
            'parametros' => $parametros,
            'resultadosQ1pf' => $resultadosQ1pf,
            'mostrarcurvascuartihorarias' => $mostrarcurvascuartihorarias,
            'resultadosQ17pf' => $resultadosQ17pf,
            'resultadosQ18pf' => $resultadosQ18pf,
            'resultadosQ19pf' => $resultadosQ19pf,
            'resultadosQ20pf' => $resultadosQ20pf,
            'resultadosQ21pf' => $resultadosQ21pf,
            'resultadosQ22pf' => $resultadosQ22pf,
        ]);
    }


    public function reportespf(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }


        $id_cnts = $request->input('id_cnts', []);  // Cambiado para múltiples id_cnts
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');


        // Guardar el primer id_cnt en la sesión (para mantener compatibilidad con otras partes del código)
        // Session::put('id_cnt', !empty($id_cnts) ? $id_cnts[0] : null);


        // Guardar el nombre de la vista actual en la sesión
        Session::put('vista_actual', 'reportespf');


        // Obtener la conexión dinámica con la base de datos MYSQL
        $connectionpf = User::conexionPuntoFrontera();


        $user = Auth::user(); //obtenemos los datos del usuario autenticado


        $cod_id_group = $user->cod_id_group; //metemos el codigo del grupo del usuario autentiado en la variable


        // llamadas a las funciones
        $datos = $this->datosGrupos($connectionpf);
        $parametros = $this->parametros($connectionpf);
        $resultadosQ1pf = $this->consultaUnopf($id_cnts, $connectionpf);
        $resultadosQ23pf = $this->consultaVeintitrespf($request, $connectionpf, $fecha_inicio, $fecha_fin);  // Pasar el request directamente
        $resultadosQ24pf = $this->consultaVeintiCuatropf($request, $connectionpf, $fecha_inicio, $fecha_fin);  // Pasar el request directamente
        $resultadosQ25pf = $this->consultaVeintiCincopf($request, $connectionpf, $fecha_inicio, $fecha_fin);  // Pasar el request directamente
        $mostrarcurvascuartihorarias = $this->mostrarCurvasCuartihorarias($id_cnts, $connectionpf);
        $exportCierresMensuales = $this->exportCierresMensuales($request);
        //$exportCurvasCuartihorarias = $this->exportCurvasCuartihorarias($request);



        // Pasar los datos a la vista
        return view('puntofrontera/reportespf', [
            'user' => $user,
            'cod_id_group' => $cod_id_group,
            'id_cnts' => $id_cnts,  // Cambiado para múltiples id_cnts
            'selected_cnt' => !empty($id_cnts) ? $id_cnts[0] : null,
            'datos' => $datos,
            'parametros' => $parametros,
            'resultadosQ1pf' => $resultadosQ1pf,
            'resultadosQ23pf' => $resultadosQ23pf,
            'resultadosQ24pf' => $resultadosQ24pf,
            'resultadosQ25pf' => $resultadosQ25pf,
            'mostrarcurvascuartihorarias' => $mostrarcurvascuartihorarias,
            'exportCierresMensuales' => $exportCierresMensuales,
            'connection' => $connectionpf,
            //'exportCurvasCuartihorarias' => $exportCurvasCuartihorarias,


        ]);
    }






    //CONSULTAS iniciales para extraer datos
    public function datosGrupos($connectionpf)
    {
        $user = Auth::user(); //obtenemos los datos del usuario autenticado
        $cod_id_group = $user->cod_id_group; //metemos el codigo del grupo del usuario autentiado en la variable


        $datos = DB::connection($connectionpf)
            ->select("SELECT * FROM t_reader_dsos WHERE dso_id = $cod_id_group;");
        //  dd($datos);
        return $datos ?: [];
    }




    public function parametros($connectionpf)
    {
        $user = Auth::user(); //obtenemos los datos del usuario autenticado
        $cod_id_group = $user->cod_id_group; //metemos el codigo del grupo del usuario autentiado en la variable


        $parametros = DB::connection($connectionpf)->select(
            "SELECT * FROM t_meter_params_iec870 WHERE dso_id = :dso_id",
            ['dso_id' => $cod_id_group]
        );


        return $parametros ?: [];
    }


    public function mostrarCurvasCuartihorarias($id_cnt, $connectionpf) //Mostrar Curvas Cuartihorarias
    {
        $user = Auth::user(); // obtenemos los datos del usuario autenticado
        $cod_id_group = $user->cod_id_group; // metemos el codigo del grupo del usuario autenticado en la variable


        if ($id_cnt) {
            // Verificar si $id_cnt es un array o un solo valor
            if (is_array($id_cnt)) {
                // Consulta para múltiples id_cnts
                $placeholders = implode(',', array_fill(0, count($id_cnt), '?'));
                $query = "
                SELECT lp_2, dso_id
                FROM t_meter_params_iec870
                WHERE dso_id = ?
                AND id_cnt IN ($placeholders)";


                $params = array_merge([$cod_id_group], $id_cnt);
                $mostrarcurvascuartihorarias = DB::connection($connectionpf)->select($query, $params);
            } else {
                // Consulta para un solo id_cnt
                $query = "
                SELECT lp_2, dso_id
                FROM t_meter_params_iec870
                WHERE dso_id = ?
                AND id_cnt = ?";


                $params = [$cod_id_group, $id_cnt];
                $mostrarcurvascuartihorarias = DB::connection($connectionpf)->select($query, $params);
            }
            // dd($mostrarcurvascuartihorarias);


            return $mostrarcurvascuartihorarias ?: [];
        }


        return [];
    }








    //CONSULTAS del documento ------------------------------------------------------------------
    public function consultaUnopf($id_cnt, $connectionpf)
    {
        if ($id_cnt) {
            // Verificar si $id_cnt es un array o un solo valor
            if (is_array($id_cnt)) {
                // Consulta para múltiples id_cnts
                $placeholders = implode(',', array_fill(0, count($id_cnt), '?'));
                $query = "
                SELECT 
                    t_meter_params_iec870.id_cnt,
                    t_meter_params_iec870.id_cups,
                    t_meter_params_iec870.cnt_enlace,
                    t_meter_params_iec870.cnt_pm,
                    t_meter_params_iec870.cnt_password,
                    t_reader_meter_data.voltage_primary,
                    t_reader_meter_data.voltage_secondary,
                    t_reader_meter_data.current_primary,
                    t_reader_meter_data.current_secondary,
                    t_reader_meter_data.dir_cups,
                    t_reader_meter_data.tip_cups,
                    t_reader_meter_data.lat_cups,
                    t_reader_meter_data.lon_cups,
                    t_reader_connections.conx_name,
                    t_reader_connections.conx_info,
                    t_reader_connections.conx_params
                FROM 
                    t_meter_params_iec870, t_reader_meter_data, t_reader_connections
                WHERE
                    t_meter_params_iec870.id_cups = t_reader_meter_data.id_cups  
                    AND t_meter_params_iec870.id_cnt = t_reader_meter_data.id_cnt
                    AND t_meter_params_iec870.conx_id = t_reader_connections.conx_id
                    AND t_meter_params_iec870.id_cnt IN ($placeholders)
            ";
                $resultadosQ1pf = DB::connection($connectionpf)->select($query, $id_cnt);
            } else {
                // Consulta para un solo id_cnt
                $query = "
                SELECT 
                    t_meter_params_iec870.id_cnt,
                    t_meter_params_iec870.id_cups,
                    t_meter_params_iec870.cnt_enlace,
                    t_meter_params_iec870.cnt_pm,
                    t_meter_params_iec870.cnt_password,
                    t_reader_meter_data.voltage_primary,
                    t_reader_meter_data.voltage_secondary,
                    t_reader_meter_data.current_primary,
                    t_reader_meter_data.current_secondary,
                    t_reader_meter_data.dir_cups,
                    t_reader_meter_data.tip_cups,
                    t_reader_meter_data.lat_cups,
                    t_reader_meter_data.lon_cups,
                    t_reader_connections.conx_name,
                    t_reader_connections.conx_info,
                    t_reader_connections.conx_params
                FROM 
                    t_meter_params_iec870, t_reader_meter_data, t_reader_connections
                WHERE  
                    t_meter_params_iec870.id_cups = t_reader_meter_data.id_cups  
                    AND t_meter_params_iec870.id_cnt = t_reader_meter_data.id_cnt
                    AND t_meter_params_iec870.conx_id = t_reader_connections.conx_id
                    AND t_meter_params_iec870.id_cnt = :id_cnt
            ";
                $resultadosQ1pf = DB::connection($connectionpf)->select($query, ['id_cnt' => $id_cnt]);
            }
            return $resultadosQ1pf ?: [];
        }
        return [];
    }


    public function consultaDospf($id_cnt, $connectionpf) // Fecha último cierre
{
    if (!$id_cnt) {
        return [];
    }

    $resultadosQ2pf = DB::connection($connectionpf)->select(
        "
        SELECT
            fhf AS max_fhf,
            TO_CHAR(fhf, 'DD/MM/YYYY HH24:MI:SS') AS fecha_ultima_cierre
        FROM t_dat_iec870_monthly_billing
        WHERE id_cnt = ?
        ORDER BY fhf DESC
        LIMIT 1
        ",
        [$id_cnt]
    );

    return $resultadosQ2pf ?: [];
}


    public function consultaTrespf($id_cnt, $connectionpf) // Fecha última curva
{
    if (!$id_cnt) {
        return [];
    }
    $resultadosQ3pf = DB::connection($connectionpf)->select(
        "
        SELECT
            fh AS max_fh,
            TO_CHAR(fh, 'DD/MM/YYYY HH24:MI:SS') AS fecha_ultima_curva
        FROM t_dat_iec870_load_profile_2
        WHERE id_cnt = ?
        ORDER BY fh DESC
        LIMIT 1
        ",
        [$id_cnt]
    );

    return $resultadosQ3pf ?: [];
}


    public function consultaCuatropf($id_cnt, $connectionpf) // Fecha último evento
{
    if (!$id_cnt) {
        return [];
    }

    $resultadosQ4pf = DB::connection($connectionpf)->select(
        "
        SELECT
            fh AS max_fh,
            TO_CHAR(fh, 'DD/MM/YYYY HH24:MI:SS') AS fecha_ultimo_evento
        FROM t_dat_iec870_events
        WHERE id_cnt = ?
        ORDER BY fh DESC
        LIMIT 1
        ",
        [$id_cnt]
    );

    return $resultadosQ4pf ?: [];
}




/*
    public function consultaCincopf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin)
    {
        if ($id_cnt) {
            $query = "SELECT    
                    t_iec870_executed_tasks.id_cnt,
                    DATE_FORMAT(t_iec870_executed_tasks.ts, '%d/%m/%Y %H:%i:%s') as ts,
                    t_iec870_executed_tasks.log    
                FROM t_iec870_executed_tasks
                INNER JOIN t_meter_params_iec870 ON t_iec870_executed_tasks.id_cnt = t_meter_params_iec870.id_cnt
                WHERE t_iec870_executed_tasks.id_cnt = :id_cnt";




            if ($fecha_inicio && $fecha_fin) {
                $query .= "
                AND t_iec870_executed_tasks.ts >= :fecha_inicio
                AND t_iec870_executed_tasks.ts <= :fecha_fin
                ORDER BY t_iec870_executed_tasks.ts DESC";
                $params = ['id_cnt' => $id_cnt, 'fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin];
            } else {
                $query .= "
            ORDER BY t_iec870_executed_tasks.ts DESC";
                // No se aplican restricciones de fecha
                $params = ['id_cnt' => $id_cnt];
            }




            $resultadosQ5pf = DB::connection($connectionpf)->select($query, $params);
            return $resultadosQ5pf ?: [];
        }
    }
*/



    public function consultaSeispf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin)
{
    if ($id_cnt) {
        $query = "SELECT
                t_meter_params_iec870.id_cups AS cups,
                t_dat_iec870_monthly_billing.id_cnt,
                t_dat_iec870_monthly_billing.ctr AS contrato,
                t_dat_iec870_monthly_billing.pt AS periodo_tarifario,
                TO_CHAR(t_dat_iec870_monthly_billing.fhi, 'DD/MM/YYYY') AS fecha_inicio,
                TO_CHAR(t_dat_iec870_monthly_billing.fhf, 'DD/MM/YYYY') AS fecha_fin,
                t_dat_iec870_monthly_billing.e_act_abs AS energia_activa_absoluta,
                t_dat_iec870_monthly_billing.e_act_inc AS energia_activa_incremental,
                t_dat_iec870_monthly_billing.e_act_bc AS bit_calidad_activa,
                t_dat_iec870_monthly_billing.e_react_ind_abs AS energia_reactiva_inductiva_absoluta,
                t_dat_iec870_monthly_billing.e_react_ind_inc AS energia_reactiva_inductiva_incremental,
                t_dat_iec870_monthly_billing.e_react_ind_bc AS bit_calidad_reactiva_inductiva,
                t_dat_iec870_monthly_billing.e_react_cap_abs AS energia_reactiva_capacitiva_absoluta,
                t_dat_iec870_monthly_billing.e_react_cap_inc AS energia_reactiva_capacitiva_incremental,
                t_dat_iec870_monthly_billing.e_react_cap_bc AS bit_calidad_reactiva_capacitiva,
                t_dat_iec870_monthly_billing.e_act_exceso AS excesos_de_potencias,
                t_dat_iec870_monthly_billing.e_act_exceso_bc AS bit_calidad_excesos,
                t_dat_iec870_monthly_billing.pot_max AS maximetros,
                TO_CHAR(t_dat_iec870_monthly_billing.pot_max_fh, 'DD/MM/YYYY HH24:MI:SS') AS fecha_maximetros,
                t_dat_iec870_monthly_billing.pot_max_bc AS bit_calidad_maximetros
            FROM t_dat_iec870_monthly_billing
            INNER JOIN t_meter_params_iec870
                ON t_dat_iec870_monthly_billing.id_cnt = t_meter_params_iec870.id_cnt
            WHERE t_dat_iec870_monthly_billing.id_cnt = :id_cnt";

        if ($fecha_inicio && $fecha_fin) {
            $query .= "
            AND t_dat_iec870_monthly_billing.fhi >= :fecha_inicio
            AND t_dat_iec870_monthly_billing.fhf <= :fecha_fin
            ORDER BY t_dat_iec870_monthly_billing.fhi DESC,
                     t_dat_iec870_monthly_billing.fhf DESC";

            $params = [
                'id_cnt' => $id_cnt,
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin
            ];
        } else {
            $query .= "
            ORDER BY t_dat_iec870_monthly_billing.fhi DESC,
                     t_dat_iec870_monthly_billing.fhf DESC";

            $params = ['id_cnt' => $id_cnt];
        }

        $resultadosQ6pf = DB::connection($connectionpf)->select($query, $params);
        return $resultadosQ6pf ?: [];
    }
}


    public function consultaSietepf($id_cnt, $connectionpf) //Log de Comnicaciones
    {
        if ($id_cnt) {
            $resultadosQ7pf = DB::connection($connectionpf)
                ->select('
                SELECT v.des_fab AS fabricante
                FROM t_meter_params_iec870 p
                JOIN t_reader_meter_data d
                    ON d.id_cnt = p.id_cnt
                JOIN t_reader_meter_vendors v
                    ON v.cod_fab = d.cod_fab
                WHERE p.id_cnt = :id_cnt;
            ', ['id_cnt' => $id_cnt]);
            return $resultadosQ7pf  ?: [];
        }
    }




    public function consultaOchopf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin)
    {
        if ($id_cnt) {
            $query = "
            SELECT
                t_meter_params_iec870.cups as 'CUPS',
                t_dat_iec870_load_profile_2.id_cnt,
                DATE_FORMAT(t_dat_iec870_load_profile_2.fh, '%d/%m/%Y') as 'Fecha',
                DATE_FORMAT(t_dat_iec870_load_profile_2.fh, '%H:%i:%s') as 'Hora',
                t_dat_iec870_load_profile_2.e_act_imp as 'Energia_Activa_Importada_A',
                t_dat_iec870_load_profile_2.e_act_imp_cualif as 'Bit_Calidad_Activa_A',
                t_dat_iec870_load_profile_2.e_act_exp as 'Energia_Activa_Exportada_A',
                t_dat_iec870_load_profile_2.e_act_exp_cualif as 'Bit_Calidad_Activa_A2',
                t_dat_iec870_load_profile_2.e_react_ind_imp as 'Energia_Reactiva_Inductiva_Importada_Ri',
                t_dat_iec870_load_profile_2.e_react_ind_imp_cualif as 'Bit_Calidad_Reactiva_Imp_Ri',
                t_dat_iec870_load_profile_2.e_react_ind_exp as 'Energia_Reactiva_Inductiva_Exportada_Ri',
                t_dat_iec870_load_profile_2.e_react_ind_exp_cualif as 'Bit_Calidad_Reactiva_Imp_Ri2',
                t_dat_iec870_load_profile_2.e_react_cap_imp as 'Energia_Reactiva_Capacitiva_Importada_Rc',
                t_dat_iec870_load_profile_2.e_react_cap_imp_cualif as 'Bit_Calidad_Reactiva_Imp_Rc',
                t_dat_iec870_load_profile_2.e_react_cap_exp as 'Energia_Reactiva_Capacitiva_Exportada_Rc',
                t_dat_iec870_load_profile_2.e_react_cap_exp_cualif as 'Bit_Calidad_Reactiva_Exp_Rc'
            FROM t_dat_iec870_load_profile_2
            INNER JOIN t_meter_params_iec870 ON t_dat_iec870_load_profile_2.id_cnt = t_meter_params_iec870.id_cnt
            WHERE t_dat_iec870_load_profile_2.id_cnt = :id_cnt";




            if ($fecha_inicio && $fecha_fin) {
                $query .= "
                AND t_dat_iec870_load_profile_2.fh >= :fecha_inicio
                AND t_dat_iec870_load_profile_2.fh <= :fecha_fin
                ORDER BY t_dat_iec870_load_profile_2.fh DESC
                ";
                $params = ['id_cnt' => $id_cnt, 'fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin];
            } else {
                $query .= "
                ORDER BY t_dat_iec870_load_profile_2.fh DESC
                LIMIT 168";
                $params = ['id_cnt' => $id_cnt];
            }




            $resultadosQ8pf = DB::connection($connectionpf)->select($query, $params);




            // dd($resultadosQ8pf);
            return $resultadosQ8pf ?: [];
        }
    }






    public function consultaNuevepf($id_cnt, $connectionpf) //Numero de Cortes
    {
        if ($id_cnt) {
            $resultadosQ9pf = DB::connection($connectionpf)
                ->select("
                SELECT Count(*) as numero
                FROM t_dat_iec870_events
                WHERE t_dat_iec870_events.id_cnt = :id_cnt
                and t_dat_iec870_events.dr = '52'
                and t_dat_iec870_events.spa = '3'
                and t_dat_iec870_events.spq = '0'
                and t_dat_iec870_events.spi = '1';
        ", ['id_cnt' => $id_cnt]);
            return $resultadosQ9pf  ?: [];
        }
    }




    public function consultaDiezpf($id_cnt, $connectionpf) //Estadisticas de Cortes
{
    if ($id_cnt) {

        if (Str::startsWith($id_cnt, 'B') || Str::startsWith($id_cnt, 'C')) {
            $resultadosQ10pf = DB::connection($connectionpf)
                ->select("
                SELECT
                    t_meter_params_iec870.cups AS cups,
                    e.id_cnt,
                    e.fh AS fecha_corte,
                    (
                        SELECT EXTRACT(EPOCH FROM (
                            TO_TIMESTAMP(fin.fh, 'DD/MM/YYYY HH24:MI:SS') - TO_TIMESTAMP(e.fh, 'DD/MM/YYYY HH24:MI:SS')
                        ))
                        FROM t_dat_iec870_events fin
                        WHERE fin.id_cnt = e.id_cnt
                        AND fin.dr = 52 AND fin.spa = 1 AND fin.spq = 2 AND fin.spi = 1
                        AND TO_TIMESTAMP(fin.fh, 'DD/MM/YYYY HH24:MI:SS') > TO_TIMESTAMP(e.fh, 'DD/MM/YYYY HH24:MI:SS')
                        ORDER BY TO_TIMESTAMP(fin.fh, 'DD/MM/YYYY HH24:MI:SS') ASC
                        LIMIT 1
                    ) AS duracion_segundos
                FROM t_dat_iec870_events e
                JOIN t_meter_params_iec870
                    ON e.id_cnt = t_meter_params_iec870.id_cnt
                WHERE e.id_cnt = :id_cnt
                AND e.dr = '52'
                AND e.spa = '3'
                AND e.spq = '0'
                AND e.spi = '1'
                ORDER BY TO_TIMESTAMP(e.fh, 'DD/MM/YYYY HH24:MI:SS') DESC
                ", ['id_cnt' => $id_cnt]);

        } else if (Str::startsWith($id_cnt, 'Q') || Str::startsWith($id_cnt, 'Z')) {
            $resultadosQ10pf = DB::connection($connectionpf)
                ->select("
                SELECT
                    t_meter_params_iec870.cups AS cups,
                    e.id_cnt,
                    e.fh AS fecha_corte,
                    (
                        SELECT EXTRACT(EPOCH FROM (
                            TO_TIMESTAMP(fin.fh, 'DD/MM/YYYY HH24:MI:SS') - TO_TIMESTAMP(e.fh, 'DD/MM/YYYY HH24:MI:SS')
                        ))
                        FROM t_dat_iec870_events fin
                        WHERE fin.id_cnt = e.id_cnt
                        AND fin.dr = 52 AND fin.spa = 3 AND fin.spq = 0 AND fin.spi = 0
                        AND TO_TIMESTAMP(fin.fh, 'DD/MM/YYYY HH24:MI:SS') > TO_TIMESTAMP(e.fh, 'DD/MM/YYYY HH24:MI:SS')
                        ORDER BY TO_TIMESTAMP(fin.fh, 'DD/MM/YYYY HH24:MI:SS') ASC
                        LIMIT 1
                    ) AS duracion_segundos
                FROM t_dat_iec870_events e
                JOIN t_meter_params_iec870
                    ON e.id_cnt = t_meter_params_iec870.id_cnt
                WHERE e.id_cnt = :id_cnt
                AND e.dr = '52'
                AND e.spa = '1'
                AND e.spq = '2'
                AND e.spi = '0'
                ORDER BY TO_TIMESTAMP(e.fh, 'DD/MM/YYYY HH24:MI:SS') DESC
                ", ['id_cnt' => $id_cnt]);
        }

        return $resultadosQ10pf ?: [];
    }
}





    public function consultaOncepf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin, Request $request)
    {
        if ($id_cnt) {

            // Si ha hecho una búsqueda por filtro, lo mandamos a su método
            if ($request->filled('descripcion')) {
                return $this->buscarDescripcion($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin, $request);
            }

            $query = "
        SELECT    
            t_dat_iec870_eventos.id_cnt,
            t_dat_iec870_eventos.fh,    
            t_dat_iec870_eventos.DR,
            t_dat_iec870_eventos.SPA,
            t_dat_iec870_eventos.SPQ,
            t_dat_iec870_eventos.SPI,
            t_reader_events_description.description
        FROM t_dat_iec870_eventos, t_reader_events_description
        WHERE
            t_dat_iec870_eventos.DR = t_reader_events_description.DR
            AND t_dat_iec870_eventos.SPA = t_reader_events_description.SPA
            AND t_dat_iec870_eventos.SPQ = t_reader_events_description.SPQ
            AND t_dat_iec870_eventos.SPI = t_reader_events_description.SPI
            AND t_dat_iec870_eventos.id_cnt = :id_cnt";


            if ($fecha_inicio && $fecha_fin) {
                $query .= "
                AND STR_TO_DATE(t_dat_iec870_eventos.fh, '%d/%m/%Y %H:%i:%s') >= :fecha_inicio
                AND STR_TO_DATE(t_dat_iec870_eventos.fh, '%d/%m/%Y %H:%i:%s') <= :fecha_fin";
                $params = ['id_cnt' => $id_cnt, 'fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin];
            } else {
                $query .= "
                AND STR_TO_DATE(t_dat_iec870_eventos.fh, '%d/%m/%Y %H:%i:%s') >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                ORDER BY STR_TO_DATE(t_dat_iec870_eventos.fh, '%d/%m/%Y %H:%i:%s') DESC";
                $params = ['id_cnt' => $id_cnt];
            }


            $resultadosQ11pf = DB::connection($connectionpf)
                ->select($query, $params);
            $resultadosQ11pfCollection = new Collection($resultadosQ11pf);
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $perPage = 100; // Número de elementos por página
            $currentItems = $resultadosQ11pfCollection->slice(($currentPage - 1) * $perPage, $perPage)->all();


                    // Crear paginador manualmente
            $resultadosQ11pf = new LengthAwarePaginator($currentItems, count($resultadosQ11pfCollection), $perPage, $currentPage, [
                'path' => request()->url(),
                'query' => request()->query()
            ]);

            return $resultadosQ11pf ?: [];
        }
    }

    public function exportEventsPF(Request $request)
{
    $id_cnt = $request->input('id_cnt'); // <- lo obtienes aquí
    $fecha_inicio = $request->input('fecha_inicio');
    $fecha_fin = $request->input('fecha_fin');
    // NUEVO: Tipo de archivo ('excel' por default)
    $format = $request->input('format', 'excel'); 
    $extension = $format === 'csv' ? 'csv' : 'xlsx';
    $exportFormat = $format === 'csv' ? ExcelFormat::CSV : ExcelFormat::XLSX;

    // Obtener la conexión dinámica (esto lo puedes mover a un método privado si se repite)
    $connectionpf = User::conexionPuntoFrontera();

    if ($request->filled('descripcion')) {
        return $this->buscarDescripcion($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin, $request);
    }

    $query = "
        SELECT    
            t_dat_iec870_eventos.id_cnt,
            t_dat_iec870_eventos.fh,    
            t_dat_iec870_eventos.DR,
            t_dat_iec870_eventos.SPA,
            t_dat_iec870_eventos.SPQ,
            t_dat_iec870_eventos.SPI,
            t_reader_events_description.description
        FROM t_dat_iec870_eventos, t_reader_events_description
        WHERE
            t_dat_iec870_eventos.DR = t_reader_events_description.DR
            AND t_dat_iec870_eventos.SPA = t_reader_events_description.SPA
            AND t_dat_iec870_eventos.SPQ = t_reader_events_description.SPQ
            AND t_dat_iec870_eventos.SPI = t_reader_events_description.SPI
            AND t_dat_iec870_eventos.id_cnt = :id_cnt";

    if ($fecha_inicio && $fecha_fin) {
        $query .= "
            AND STR_TO_DATE(t_dat_iec870_eventos.fh, '%d/%m/%Y %H:%i:%s') >= :fecha_inicio
            AND STR_TO_DATE(t_dat_iec870_eventos.fh, '%d/%m/%Y %H:%i:%s') <= :fecha_fin";
        $params = ['id_cnt' => $id_cnt, 'fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin];
    } else {
        $query .= "
            AND STR_TO_DATE(t_dat_iec870_eventos.fh, '%d/%m/%Y %H:%i:%s') >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
            ORDER BY STR_TO_DATE(t_dat_iec870_eventos.fh, '%d/%m/%Y %H:%i:%s') DESC";
        $params = ['id_cnt' => $id_cnt];
    }

    $exportEventsPF = DB::connection($connectionpf)
        ->select($query, $params);

    if ($exportEventsPF) {
        return Excel::download(new EventosPFExport($exportEventsPF), 'eventos_pf.' . $extension, $exportFormat);
    } else {
        return response()->json(['message' => 'No hay datos'], 404);
    }
}



    /* FILTRO DE BÚSQUEDA */
    public function buscarDescripcion($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin, Request $request)
    {
        $descripcion = strtolower($request->input('descripcion'));


        $query = "
        SELECT    
            t_dat_iec870_eventos.id_cnt,
            t_dat_iec870_eventos.fh,    
            t_dat_iec870_eventos.DR,
            t_dat_iec870_eventos.SPA,
            t_dat_iec870_eventos.SPQ,
            t_dat_iec870_eventos.SPI,
            t_reader_events_description.description
        FROM t_dat_iec870_eventos, t_reader_events_description
        WHERE
            t_dat_iec870_eventos.DR = t_reader_events_description.DR
            AND t_dat_iec870_eventos.SPA = t_reader_events_description.SPA
            AND t_dat_iec870_eventos.SPQ = t_reader_events_description.SPQ
            AND t_dat_iec870_eventos.SPI = t_reader_events_description.SPI
            AND t_dat_iec870_eventos.id_cnt = :id_cnt";




        if ($fecha_inicio && $fecha_fin) {
            $query .= "
            AND LOWER(t_reader_events_description.description) LIKE :descripcion
            AND STR_TO_DATE(t_dat_iec870_eventos.fh, '%d/%m/%Y %H:%i:%s') >= :fecha_inicio
            AND STR_TO_DATE(t_dat_iec870_eventos.fh, '%d/%m/%Y %H:%i:%s') <= :fecha_fin";
            $params = ['id_cnt' => $id_cnt, 'descripcion' => "%$descripcion%", 'fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin];
        } else {
            $query .= "
            AND LOWER(t_reader_events_description.description) LIKE :descripcion
            AND STR_TO_DATE(t_dat_iec870_eventos.fh, '%d/%m/%Y %H:%i:%s')
            ORDER BY STR_TO_DATE(t_dat_iec870_eventos.fh, '%d/%m/%Y %H:%i:%s') DESC";
            $params = ['id_cnt' => $id_cnt, 'descripcion' => "%$descripcion%"];
        }
        $resultadosQ11pfFiltro = DB::connection($connectionpf)
            ->select($query, $params);
        $resultadosQ11pfFiltroCollection = new Collection($resultadosQ11pfFiltro);
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 100; // Número de elementos por página
        $currentItems = $resultadosQ11pfFiltroCollection->slice(($currentPage - 1) * $perPage, $perPage)->all();


        // Crear paginador manualmente
        $resultadosQ11pfFiltro = new LengthAwarePaginator($currentItems, count($resultadosQ11pfFiltroCollection), $perPage, $currentPage, [
            'path' => request()->url(),
            'query' => request()->query()
        ]);






        return $resultadosQ11pfFiltro ?: [];
    }





    public function consultaDocepf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin,) //Cuenta de curvas a 0
    {
        if ($id_cnt) {
            $query = "
            SELECT
                COUNT(t_dat_iec870_load_profile_2.fh) AS Energia_Activa_Importada_A
            FROM
                t_dat_iec870_load_profile_2,  t_meter_params_iec870
                WHERE t_meter_params_iec870.id_cnt = :id_cnt
            AND t_dat_iec870_load_profile_2.id_cnt = t_meter_params_iec870.id_cnt
                AND t_dat_iec870_load_profile_2.e_act_imp = 0";




            if ($fecha_inicio && $fecha_fin) {
                $query .= "
                AND t_dat_iec870_load_profile_2.fh BETWEEN :fecha_inicio AND :fecha_fin";
                $params = ['id_cnt' => $id_cnt, 'fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin];
            } else {
                $query .= "
                AND t_dat_iec870_load_profile_2.fh >= (
                    SELECT MAX(fh) - INTERVAL 168 HOUR
                    FROM t_dat_iec870_load_profile_2
                  );
                ";
                $params = ['id_cnt' => $id_cnt];
            }


            $resultadosQ12pf = DB::connection($connectionpf)
                ->select($query, $params);


            return $resultadosQ12pf ?: [];
        }
    }


    public function consultaTrecepf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin)
    {
        try {
            if ($id_cnt) {
                $query = "
                    SELECT 
                        SUM(e_act_imp) AS suma_importada
                    FROM 
                        t_dat_iec870_load_profile_2
                    WHERE 
                        id_cnt = :id_cnt";


                // Aplicar filtro por fechas si están definidas
                if ($fecha_inicio && $fecha_fin) {
                    $query .= "
                        AND fh BETWEEN :fecha_inicio AND :fecha_fin";
                    $params = ['id_cnt' => $id_cnt, 'fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin];
                } else {
                    // Si no hay fechas definidas, calcular para el mes actual
                    $query .= "
                        AND MONTH(fh) = MONTH(CURRENT_DATE)";
                    $params = ['id_cnt' => $id_cnt];
                }


                $resultadosQ13pf = DB::connection($connectionpf)
                    ->select($query, $params);


                return $resultadosQ13pf ?: [];
            }
        } catch (\Exception $e) {
            return ['message' => 'Error: ' . $e->getMessage()];
        }
    }




    public function consultaCatorcepf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin)
    {
        try {
            if ($id_cnt) {
                $query = "
                SELECT 
                    SUM(e_act_exp) AS suma_exportada
                FROM 
                    t_dat_iec870_load_profile_2
                WHERE 
                    id_cnt = :id_cnt";


                // Aplicar filtro por fechas si están definidas
                if ($fecha_inicio && $fecha_fin) {
                    $query .= "
                    AND fh BETWEEN :fecha_inicio AND :fecha_fin";
                    $params = ['id_cnt' => $id_cnt, 'fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin];
                } else {
                    // Si no hay fechas definidas, calcular para el mes actual
                    $query .= "
                    AND MONTH(fh) = MONTH(CURRENT_DATE)";
                    $params = ['id_cnt' => $id_cnt];
                }


                $resultadosQ14pf = DB::connection($connectionpf)
                    ->select($query, $params);


                return $resultadosQ14pf ?: [];
            }
        } catch (\Exception $e) {
            return ['message' => 'Error: ' . $e->getMessage()];
        }
    }




    public function consultaQuincepf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin)
    {
        try {
            if ($id_cnt) {
                $query = "
                SELECT 
                    DATE_FORMAT(fh, '%H:00:00') AS hora,
                    ROUND(AVG(e_act_imp), 2) AS media_consumo_hora_imp,
                    ROUND(AVG(e_act_exp), 2) AS media_consumo_hora_exp
                FROM 
                    t_dat_iec870_load_profile_2
                WHERE 
                    id_cnt = :id_cnt";


                // Aplicar filtro por fechas si están definidas
                if ($fecha_inicio && $fecha_fin) {
                    $query .= "
                    AND fh BETWEEN :fecha_inicio AND :fecha_fin";
                    $params = ['id_cnt' => $id_cnt, 'fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin];
                } else {
                    // Si no hay fechas definidas, calcular para el último mes
                    $query .= "
                    AND fh >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
                    $params = ['id_cnt' => $id_cnt];
                }


                $query .= "
                GROUP BY 
                    hora
                ORDER BY 
                    hora";


                $resultadosQ15pf = DB::connection($connectionpf)
                    ->select($query, $params);


                return $resultadosQ15pf ?: [];
            }
        } catch (\Exception $e) {
            return ['message' => 'Error: ' . $e->getMessage()];
        }
    }




    public function consultaDieciseispf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin)
    {
        try {
            if ($id_cnt) {
                $query = "
                SELECT 
                    ELT(DAYOFWEEK(fh), 'Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado') AS dia_semana,
                    ROUND(AVG(e_act_imp), 2) AS media_consumo_dia_imp,
                    ROUND(AVG(e_act_exp), 2) AS media_consumo_dia_exp
                FROM 
                    t_dat_iec870_load_profile_2
                WHERE 
                    id_cnt = :id_cnt";


                // Aplicar filtro por fechas si están definidas
                if ($fecha_inicio && $fecha_fin) {
                    $query .= "
                    AND fh BETWEEN :fecha_inicio AND :fecha_fin";
                    $params = ['id_cnt' => $id_cnt, 'fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin];
                } else {
                    // Si no hay fechas definidas, calcular para el último mes
                    $query .= "
                    AND fh >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
                    AND fh < CURDATE()";
                    $params = ['id_cnt' => $id_cnt];
                }


                $query .= "
                GROUP BY 
                    dia_semana
                ORDER BY 
                    FIELD(dia_semana, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo')";


                $resultadosQ16pf = DB::connection($connectionpf)
                    ->select($query, $params);


                return $resultadosQ16pf ?: [];
            }
        } catch (\Exception $e) {
            return ['message' => 'Error: ' . $e->getMessage()];
        }
    }


    //CONSULTAS CURVAS CUARTIHORARIAS --------------------
    public function consultaDiecisietepf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin) // Cuenta de curvas a 0
{
    if ($id_cnt) {

        $query = "
            SELECT
                COUNT(lp2.fh) AS energia_activa_importada_a
            FROM t_dat_iec870_load_profile_2 lp2
            JOIN t_meter_params_iec870 mp
                ON lp2.id_cnt = mp.id_cnt
            WHERE
                mp.id_cnt = :id_cnt
                AND lp2.ai = 0
        ";

        if ($fecha_inicio && $fecha_fin) {
            $query .= "
                AND lp2.fh BETWEEN :fecha_inicio AND :fecha_fin
            ";

            $params = [
                'id_cnt' => $id_cnt,
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin
            ];
        } else {
            $query .= "
                AND lp2.fh >= (
                    SELECT MAX(fh) - INTERVAL '168 hours'
                    FROM t_dat_iec870_load_profile_2
                )
            ";

            $params = [
                'id_cnt' => $id_cnt
            ];
        }

        $resultadosQ17pf = DB::connection($connectionpf)->select($query, $params);

        return $resultadosQ17pf ?: [];
    }

    return [];
}



    public function consultaDieciochopf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin)
{
    try {
        if ($id_cnt) {

            $query = "
                SELECT
                    SUM(ai) AS suma_importada
                FROM t_dat_iec870_load_profile_2
                WHERE id_cnt = :id_cnt
            ";

            if ($fecha_inicio && $fecha_fin) {
                $query .= "
                    AND fh BETWEEN :fecha_inicio AND :fecha_fin
                ";

                $params = [
                    'id_cnt' => $id_cnt,
                    'fecha_inicio' => $fecha_inicio,
                    'fecha_fin' => $fecha_fin
                ];
            } else {
                // Mes actual (año incluido)
                $query .= "
                    AND fh >= date_trunc('month', CURRENT_DATE)
                    AND fh <  date_trunc('month', CURRENT_DATE) + INTERVAL '1 month'
                ";

                $params = [
                    'id_cnt' => $id_cnt
                ];
            }

            $resultadosQ18pf = DB::connection($connectionpf)->select($query, $params);

            return $resultadosQ18pf ?: [];
        }
    } catch (\Exception $e) {
        return ['message' => 'Error: ' . $e->getMessage()];
    }

    return [];
}



    public function consultaDiecinuevepf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin)
{
    try {
        if ($id_cnt) {

            $query = "
                SELECT 
                    SUM(ae) AS suma_exportada
                FROM t_dat_iec870_load_profile_2
                WHERE id_cnt = :id_cnt
            ";

            if ($fecha_inicio && $fecha_fin) {
                $query .= "
                    AND fh BETWEEN :fecha_inicio AND :fecha_fin
                ";
                $params = [
                    'id_cnt' => $id_cnt,
                    'fecha_inicio' => $fecha_inicio,
                    'fecha_fin' => $fecha_fin
                ];
            } else {
                // Mes actual (correcto por año)
                $query .= "
                    AND fh >= date_trunc('month', CURRENT_DATE)
                    AND fh <  date_trunc('month', CURRENT_DATE) + INTERVAL '1 month'
                ";
                $params = ['id_cnt' => $id_cnt];
            }

            $resultadosQ19pf = DB::connection($connectionpf)->select($query, $params);

            return $resultadosQ19pf ?: [];
        }
    } catch (\Exception $e) {
        return ['message' => 'Error: ' . $e->getMessage()];
    }
}



    public function consultaVeintepf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin)
{
    if ($id_cnt) {

        $query = "
        SELECT
            t_meter_params_iec870.id_cups AS cups,
            t_dat_iec870_load_profile_2.id_cnt AS id_cnt,
            TO_CHAR(t_dat_iec870_load_profile_2.fh, 'DD/MM/YYYY') AS fecha,
            TO_CHAR(t_dat_iec870_load_profile_2.fh, 'HH24:MI:SS') AS hora,
            t_dat_iec870_load_profile_2.ai AS energia_activa_importada_a,
            t_dat_iec870_load_profile_2.ai_bc AS bit_calidad_activa_a,
            t_dat_iec870_load_profile_2.ae AS energia_activa_exportada_a,
            t_dat_iec870_load_profile_2.ae_bc AS bit_calidad_activa_a2,
            t_dat_iec870_load_profile_2.r1 AS energia_reactiva_inductiva_importada_ri,
            t_dat_iec870_load_profile_2.r1_bc AS bit_calidad_reactiva_imp_ri,
            t_dat_iec870_load_profile_2.r2 AS energia_reactiva_inductiva_exportada_ri,
            t_dat_iec870_load_profile_2.r2_bc AS bit_calidad_reactiva_imp_ri2,
            t_dat_iec870_load_profile_2.r3 AS energia_reactiva_capacitiva_importada_rc,
            t_dat_iec870_load_profile_2.r3_bc AS bit_calidad_reactiva_imp_rc,
            t_dat_iec870_load_profile_2.r4 AS energia_reactiva_capacitiva_exportada_rc,
            t_dat_iec870_load_profile_2.r4_bc AS bit_calidad_reactiva_exp_rc
        FROM t_dat_iec870_load_profile_2
        INNER JOIN t_meter_params_iec870
            ON t_dat_iec870_load_profile_2.id_cnt = t_meter_params_iec870.id_cnt
        WHERE t_dat_iec870_load_profile_2.id_cnt = :id_cnt
        ";

        if ($fecha_inicio && $fecha_fin) {
            $query .= "
            AND t_dat_iec870_load_profile_2.fh >= :fecha_inicio
            AND t_dat_iec870_load_profile_2.fh <= :fecha_fin
            ORDER BY t_dat_iec870_load_profile_2.fh ASC
            ";

            $params = [
                'id_cnt' => $id_cnt,
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin
            ];
        } else {
            $query .= "
            ORDER BY t_dat_iec870_load_profile_2.fh DESC
            LIMIT 2880
            ";

            $params = ['id_cnt' => $id_cnt];
        }

        $resultadosQ20pf = DB::connection($connectionpf)->select($query, $params);

        // Invertir resultados para orden ascendente si no hay fechas
        if (!$fecha_inicio && !$fecha_fin) {
            $resultadosQ20pf = array_reverse($resultadosQ20pf);
        }

        return $resultadosQ20pf ?: [];
    }
}


    public function consultaVeintiunopf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin)
{
    try {
        if ($id_cnt) {
            $query = "
            SELECT 
                TO_CHAR(fh, 'HH24:00:00') AS hora,
                ROUND(AVG(ai), 2) AS media_consumo_hora_imp,
                ROUND(AVG(ae), 2) AS media_consumo_hora_exp
            FROM 
                t_dat_iec870_load_profile_2
            WHERE 
                id_cnt = :id_cnt
            ";

            // Aplicar filtro por fechas si están definidas
            if ($fecha_inicio && $fecha_fin) {
                $query .= "
                AND fh BETWEEN :fecha_inicio AND :fecha_fin";
                $params = [
                    'id_cnt' => $id_cnt,
                    'fecha_inicio' => $fecha_inicio,
                    'fecha_fin' => $fecha_fin
                ];
            } else {
                // Si no hay fechas definidas, calcular para el último mes
                $query .= "
                AND fh >= NOW() - INTERVAL '1 month'";
                $params = ['id_cnt' => $id_cnt];
            }

            $query .= "
            GROUP BY 
                hora
            ORDER BY 
                hora
            ";

            $resultadosQ21pf = DB::connection($connectionpf)
                ->select($query, $params);

            return $resultadosQ21pf ?: [];
        }
    } catch (\Exception $e) {
        return ['message' => 'Error: ' . $e->getMessage()];
    }
}



    public function consultaVeintidospf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin)
{
    try {
        if ($id_cnt) {

            $query = "
            SELECT *
            FROM (
                SELECT
                    CASE EXTRACT(DOW FROM fh)
                        WHEN 0 THEN 'domingo'
                        WHEN 1 THEN 'lunes'
                        WHEN 2 THEN 'martes'
                        WHEN 3 THEN 'miércoles'
                        WHEN 4 THEN 'jueves'
                        WHEN 5 THEN 'viernes'
                        WHEN 6 THEN 'sábado'
                    END AS dia_semana,
                    ROUND(AVG(ai), 2) AS media_consumo_dia_imp,
                    ROUND(AVG(ae), 2) AS media_consumo_dia_exp
                FROM 
                    t_dat_iec870_load_profile_2
                WHERE 
                    id_cnt = :id_cnt
            ";

            if ($fecha_inicio && $fecha_fin) {
                $query .= "
                AND fh BETWEEN :fecha_inicio AND :fecha_fin";
                $params = [
                    'id_cnt' => $id_cnt,
                    'fecha_inicio' => $fecha_inicio,
                    'fecha_fin' => $fecha_fin
                ];
            } else {
                $query .= "
                AND fh >= CURRENT_DATE - INTERVAL '1 month'
                AND fh < CURRENT_DATE";
                $params = ['id_cnt' => $id_cnt];
            }

            $query .= "
                GROUP BY 
                    CASE EXTRACT(DOW FROM fh)
                        WHEN 0 THEN 'domingo'
                        WHEN 1 THEN 'lunes'
                        WHEN 2 THEN 'martes'
                        WHEN 3 THEN 'miércoles'
                        WHEN 4 THEN 'jueves'
                        WHEN 5 THEN 'viernes'
                        WHEN 6 THEN 'sábado'
                    END
            ) AS sub
            ORDER BY 
                CASE dia_semana
                    WHEN 'lunes' THEN 1
                    WHEN 'martes' THEN 2
                    WHEN 'miércoles' THEN 3
                    WHEN 'jueves' THEN 4
                    WHEN 'viernes' THEN 5
                    WHEN 'sábado' THEN 6
                    WHEN 'domingo' THEN 7
                END
            ";

            $resultadosQ22pf = DB::connection($connectionpf)
                ->select($query, $params);
            return $resultadosQ22pf ?: [];
        }
    } catch (\Exception $e) {
        return ['message' => 'Error: ' . $e->getMessage()];
    }
}




    //REPORTES PF 
    // public function consultaVeintitrespf(Request $request, $connectionpf, $fecha_inicio, $fecha_fin)
    // {
    //     $id_cnts = $request->input('id_cnts', []);
    //     $fecha_inicio = $request->input('fecha_inicio');
    //     $fecha_fin = $request->input('fecha_fin');


    //     if (!empty($id_cnts)) {
    //         $query = "SELECT
    //             t_meter_params_iec870.cups as CUPS,
    //             t_dat_iec870_monthly_billing.id_cnt,
    //             t_dat_iec870_monthly_billing.ctr as Contrato,
    //             t_dat_iec870_monthly_billing.pt as Periodo_Tarifario,
    //             date_format(t_dat_iec870_monthly_billing.fhi,'%d/%m/%Y') as Fecha_Inicio,
    //             date_format(t_dat_iec870_monthly_billing.fhf,'%d/%m/%Y') as Fecha_Fin,
    //             t_dat_iec870_monthly_billing.e_act_abs as Energia_Activa_Absoluta,
    //             t_dat_iec870_monthly_billing.e_act_inc as Energia_Activa_Incremental,
    //             t_dat_iec870_monthly_billing.e_act_cualif as Bit_Calidad_Activa,
    //             t_dat_iec870_monthly_billing.e_react_ind_abs as Energia_Reactiva_Inductiva_Absoluta,
    //             t_dat_iec870_monthly_billing.e_react_ind_inc as Energia_Reactiva_Inductiva_Incremental,
    //             t_dat_iec870_monthly_billing.e_react_ind_cualif as Bit_Calidad_Reactiva_Inductiva,
    //             t_dat_iec870_monthly_billing.e_react_cap_abs as Energia_Reactiva_Capacitiva_Absoluta,
    //             t_dat_iec870_monthly_billing.e_react_cap_inc as Energia_Reactiva_Capacitiva_Incremental,
    //             t_dat_iec870_monthly_billing.e_react_cap_cualif as Bit_Calidad_Reactiva_Capacitiva,
    //             t_dat_iec870_monthly_billing.e_act_exceso as Excesos_de_Potencias,
    //             t_dat_iec870_monthly_billing.e_act_exceso_cualif as Bit_Calidad_Excesos,
    //             t_dat_iec870_monthly_billing.pot_max as Maximetros,
    //             date_format(t_dat_iec870_monthly_billing.pot_max_fh, '%d/%m/%Y %H:%i:%s') as Fecha_Maximetros,
    //             t_dat_iec870_monthly_billing.pot_max_cualif as Bit_Calidad_Maximetros
    //         FROM reader.t_dat_iec870_monthly_billing
    //         INNER JOIN reader.t_meter_params_iec870 ON t_dat_iec870_monthly_billing.id_cnt = t_meter_params_iec870.id_cnt
    //         WHERE t_dat_iec870_monthly_billing.id_cnt IN (" . implode(',', array_fill(0, count($id_cnts), '?')) . ")";


    //         $params = $id_cnts;


    //         if ($fecha_inicio && $fecha_fin) {
    //             $query .= "
    //         AND t_dat_iec870_monthly_billing.fhi >= ?
    //         AND t_dat_iec870_monthly_billing.fhf <= ?
    //         ORDER BY t_dat_iec870_monthly_billing.fhi DESC, t_dat_iec870_monthly_billing.fhf DESC";
    //             $params = array_merge($params, [$fecha_inicio, $fecha_fin]);
    //         } else {
    //             $query .= "
    //     ORDER BY t_dat_iec870_monthly_billing.fhi DESC, t_dat_iec870_monthly_billing.fhf DESC";
    //         }


    //         $resultadosQ23pf = DB::connection($connectionpf)->select($query, $params);
    //         // dd($resultadosQ23pf);
    //         return $resultadosQ23pf ?: [];
    //     }


    //     return [];
    // }


    //con paginacion y descarga en excel:
    public function consultaVeintitrespf(Request $request, $connectionpf, $fecha_inicio, $fecha_fin)
{
    set_time_limit(0);

    $id_cnts = $request->input('id_cnts', []);
    $fecha_inicio = $request->input('fecha_inicio');
    $fecha_fin = $request->input('fecha_fin');
    $tipo_reporte = $request->input('tipo_reporte', []);
    $perPage = 15;  
    $page = max(1, (int)$request->input('page', 1));
    $offset = ($page - 1) * $perPage;

    if (empty($id_cnts) || !in_array('cierres_mensuales', $tipo_reporte)) {
        return [];
    }

    // Construir query con Query Builder
    $queryBuilder = DB::connection($connectionpf)
        ->table('t_dat_iec870_monthly_billing as b')
        ->join('t_meter_params_iec870 as m', 'b.id_cnt', '=', 'm.id_cnt')
        ->selectRaw("
            m.id_cups as cups,
            b.id_cnt,
            b.ctr as contrato,
            b.pt as periodo_tarifario,
            TO_CHAR(b.fhi,'DD/MM/YYYY') as fecha_inicio,
            TO_CHAR(b.fhf,'DD/MM/YYYY') as fecha_fin,
            b.e_act_abs as energia_activa_absoluta,
            b.e_act_inc as energia_activa_incremental,
            b.e_act_bc as bit_calidad_activa,
            b.e_react_ind_abs as energia_reactiva_inductiva_absoluta,
            b.e_react_ind_inc as energia_reactiva_inductiva_incremental,
            b.e_react_ind_bc as bit_calidad_reactiva_inductiva,
            b.e_react_cap_abs as energia_reactiva_capacitiva_absoluta,
            b.e_react_cap_inc as energia_reactiva_capacitiva_incremental,
            b.e_react_cap_bc as bit_calidad_reactiva_capacitiva,
            b.e_act_exceso as excesos_de_potencias,
            b.e_act_exceso_bc as bit_calidad_excesos,
            b.pot_max as maximetros,
            TO_CHAR(b.pot_max_fh, 'DD/MM/YYYY HH24:MI:SS') as fecha_maximetros,
            b.pot_max_bc as bit_calidad_maximetros
        ")
        ->whereIn('b.id_cnt', $id_cnts);

    if ($fecha_inicio && $fecha_fin) {
        $queryBuilder = $queryBuilder
            ->where('b.fhi', '>=', $fecha_inicio)
            ->where('b.fhf', '<=', $fecha_fin)
            ->orderByDesc('b.fhi')
            ->orderByDesc('b.fhf');
    } else {
        $queryBuilder = $queryBuilder
            ->orderBy('b.id_cnt')
            ->orderByDesc('b.fhi')
            ->orderBy('b.ctr')
            ->orderBy('b.pt');
    }

    // Clonar query para contar total registros
    $total = (clone $queryBuilder)->count();

    // Obtener resultados con paginación SQL
    $resultadosQ23pf = $queryBuilder
        ->offset($offset)
        ->limit($perPage)
        ->get();

    // Crear paginación
    $paginatedResults = new LengthAwarePaginator(
        $resultadosQ23pf,
        $total,
        $perPage,
        $page,
        [
            'path' => $request->url(),
            'query' => $request->query(),
        ]
    );

    return $paginatedResults;
}



    public function exportCierresMensuales(Request $request) {
        try {
            $connection = User::conexionPuntoFrontera();
            if(Schema::connection($connection)->hasTable('t_dat_iec870_monthly_billing')) {
                $format = $request->input('format', 'excel'); 
                $extension = $format === 'csv' ? 'csv' : 'xlsx';
                $exportFormat = $format === 'csv' ? ExcelFormat::CSV : ExcelFormat::XLSX;

                $id_cnts = $request->input('id_cnts', []);
                $fecha_inicio = $request->input('fecha_inicio');
                $fecha_fin = $request->input('fecha_fin');


                if (!empty($id_cnts)) {
                    $query = "SELECT
                    t_meter_params_iec870.id_cups as CUPS,
                    t_dat_iec870_monthly_billing.id_cnt,
                    t_dat_iec870_monthly_billing.ctr as Contrato,
                    t_dat_iec870_monthly_billing.pt as Periodo_Tarifario,
                    date_format(t_dat_iec870_monthly_billing.fhi,'%d/%m/%Y') as Fecha_Inicio,
                    date_format(t_dat_iec870_monthly_billing.fhf,'%d/%m/%Y') as Fecha_Fin,
                    t_dat_iec870_monthly_billing.e_act_abs as Energia_Activa_Absoluta,
                    t_dat_iec870_monthly_billing.e_act_inc as Energia_Activa_Incremental,
                    t_dat_iec870_monthly_billing.e_act_cualif as Bit_Calidad_Activa,
                    t_dat_iec870_monthly_billing.e_react_ind_abs as Energia_Reactiva_Inductiva_Absoluta,
                    t_dat_iec870_monthly_billing.e_react_ind_inc as Energia_Reactiva_Inductiva_Incremental,
                    t_dat_iec870_monthly_billing.e_react_ind_cualif as Bit_Calidad_Reactiva_Inductiva,
                    t_dat_iec870_monthly_billing.e_react_cap_abs as Energia_Reactiva_Capacitiva_Absoluta,
                    t_dat_iec870_monthly_billing.e_react_cap_inc as Energia_Reactiva_Capacitiva_Incremental,
                    t_dat_iec870_monthly_billing.e_react_cap_cualif as Bit_Calidad_Reactiva_Capacitiva,
                    t_dat_iec870_monthly_billing.e_act_exceso as Excesos_de_Potencias,
                    t_dat_iec870_monthly_billing.e_act_exceso_cualif as Bit_Calidad_Excesos,
                    t_dat_iec870_monthly_billing.pot_max as Maximetros,
                    date_format(t_dat_iec870_monthly_billing.pot_max_fh, '%d/%m/%Y %H:%i:%s') as Fecha_Maximetros,
                    t_dat_iec870_monthly_billing.pot_max_cualif as Bit_Calidad_Maximetros
                FROM t_dat_iec870_monthly_billing
                INNER JOIN t_meter_params_iec870 ON t_dat_iec870_monthly_billing.id_cnt = t_meter_params_iec870.id_cnt
                WHERE t_dat_iec870_monthly_billing.id_cnt IN (" . implode(',', array_fill(0, count($id_cnts), '?')) . ")";


                    $params = $id_cnts;


                    if ($fecha_inicio && $fecha_fin) {
                        $query .= "
                    AND t_dat_iec870_monthly_billing.fhi >= ?
                    AND t_dat_iec870_monthly_billing.fhf <= ?
                    ORDER BY t_dat_iec870_monthly_billing.fhi DESC, t_dat_iec870_monthly_billing.fhf DESC";
                        $params = array_merge($params, [$fecha_inicio, $fecha_fin]);
                    } else {
                        $query .= "
                            ORDER BY 
                            t_dat_iec870_monthly_billing.id_cnt ASC,          
                            t_dat_iec870_monthly_billing.fhi DESC,            
                            t_dat_iec870_monthly_billing.ctr ASC,             
                            t_dat_iec870_monthly_billing.pt ASC    ";
                    }
                    $exportCierresMensuales = DB::connection($connection)->select($query, $params);

                    if($exportCierresMensuales) {
                        //dd($params); // En ambos métodos
                        return Excel::download(new ReportesPFCierresMensualesExport($exportCierresMensuales), 'cierres_mensuales.' . $extension, $exportFormat);
                    } else {
                        return response()->json(['message' => 'No hay datos'], 404);
                    }

                }
        } else {
            return ['message' => 'No hay datos'];
        }
    } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'Error: ' . $e->getMessage()];
        }
}








    // public function consultaVeintiCuatropf(Request $request, $connectionpf, $fecha_inicio, $fecha_fin)
    // {
    //     $id_cnts = $request->input('id_cnts', []);
    //     $fecha_inicio = $request->input('fecha_inicio');
    //     $fecha_fin = $request->input('fecha_fin');


    //     if (!empty($id_cnts)) {
    //         // // Construir la parte de la consulta que maneja los múltiples id_cnts
    //         // $id_cnt_placeholders = implode(',', array_fill(0, count($id_cnts), '?'));


    //         $query = "
    //         SELECT
    //             t_meter_params_iec870.cups as 'CUPS',
    //             t_dat_iec870_load_profile_2.id_cnt,
    //             DATE_FORMAT(t_dat_iec870_load_profile_2.fh, '%d/%m/%Y') as 'Fecha',
    //             DATE_FORMAT(t_dat_iec870_load_profile_2.fh, '%H:%i:%s') as 'Hora',
    //             t_dat_iec870_load_profile_2.e_act_imp as 'Energia_Activa_Importada_A',
    //             t_dat_iec870_load_profile_2.e_act_imp_cualif as 'Bit_Calidad_Activa_A',
    //             t_dat_iec870_load_profile_2.e_act_exp as 'Energia_Activa_Exportada_A',
    //             t_dat_iec870_load_profile_2.e_act_exp_cualif as 'Bit_Calidad_Activa_A2',
    //             t_dat_iec870_load_profile_2.e_react_ind_imp as 'Energia_Reactiva_Inductiva_Importada_Ri',
    //             t_dat_iec870_load_profile_2.e_react_ind_imp_cualif as 'Bit_Calidad_Reactiva_Imp_Ri',
    //             t_dat_iec870_load_profile_2.e_react_ind_exp as 'Energia_Reactiva_Inductiva_Exportada_Ri',
    //             t_dat_iec870_load_profile_2.e_react_ind_exp_cualif as 'Bit_Calidad_Reactiva_Imp_Ri2',
    //             t_dat_iec870_load_profile_2.e_react_cap_imp as 'Energia_Reactiva_Capacitiva_Importada_Rc',
    //             t_dat_iec870_load_profile_2.e_react_cap_imp_cualif as 'Bit_Calidad_Reactiva_Imp_Rc',
    //             t_dat_iec870_load_profile_2.e_react_cap_exp as 'Energia_Reactiva_Capacitiva_Exportada_Rc',
    //             t_dat_iec870_load_profile_2.e_react_cap_exp_cualif as 'Bit_Calidad_Reactiva_Exp_Rc'
    //         FROM reader.t_dat_iec870_load_profile_2
    //         INNER JOIN reader.t_meter_params_iec870 ON t_dat_iec870_load_profile_2.id_cnt = t_meter_params_iec870.id_cnt
    //         WHERE t_dat_iec870_load_profile_2.id_cnt IN (" . implode(',', array_fill(0, count($id_cnts), '?')) . ")";


    //         $params = $id_cnts;


    //         if ($fecha_inicio && $fecha_fin) {
    //             $query .= "
    //             AND t_dat_iec870_load_profile_2.fh >= ?
    //             AND t_dat_iec870_load_profile_2.fh <= ?
    //             ORDER BY t_meter_params_iec870.cups desc, t_dat_iec870_load_profile_2.fh DESC";
    //             $params = array_merge($params, [$fecha_inicio, $fecha_fin]);
    //         } else {
    //             $query .= "
    //             ORDER BY t_meter_params_iec870.cups desc, t_dat_iec870_load_profile_2.fh DESC
    //             LIMIT 168";
    //         }


    //         $resultadosQ24pf = DB::connection($connectionpf)->select($query, $params);
    //         dd($resultadosQ24pf);
    //         return $resultadosQ24pf ?: [];
    //     }


    //     return [];
    // }


    //con paginacion
    // public function consultaVeintiCuatropf(Request $request, $connectionpf, $fecha_inicio, $fecha_fin)
    // {
    //     $id_cnts = $request->input('id_cnts', []);
    //     $fecha_inicio = $request->input('fecha_inicio');
    //     $fecha_fin = $request->input('fecha_fin');


    //     if (!empty($id_cnts)) {
    //         $query = "
    //         SELECT
    //             t_meter_params_iec870.cups as 'CUPS',
    //             t_dat_iec870_load_profile_2.id_cnt,
    //             DATE_FORMAT(t_dat_iec870_load_profile_2.fh, '%d/%m/%Y') as 'Fecha',
    //             DATE_FORMAT(t_dat_iec870_load_profile_2.fh, '%H:%i:%s') as 'Hora',
    //             t_dat_iec870_load_profile_2.e_act_imp as 'Energia_Activa_Importada_A',
    //             t_dat_iec870_load_profile_2.e_act_imp_cualif as 'Bit_Calidad_Activa_A',
    //             t_dat_iec870_load_profile_2.e_act_exp as 'Energia_Activa_Exportada_A',
    //             t_dat_iec870_load_profile_2.e_act_exp_cualif as 'Bit_Calidad_Activa_A2',
    //             t_dat_iec870_load_profile_2.e_react_ind_imp as 'Energia_Reactiva_Inductiva_Importada_Ri',
    //             t_dat_iec870_load_profile_2.e_react_ind_imp_cualif as 'Bit_Calidad_Reactiva_Imp_Ri',
    //             t_dat_iec870_load_profile_2.e_react_ind_exp as 'Energia_Reactiva_Inductiva_Exportada_Ri',
    //             t_dat_iec870_load_profile_2.e_react_ind_exp_cualif as 'Bit_Calidad_Reactiva_Imp_Ri2',
    //             t_dat_iec870_load_profile_2.e_react_cap_imp as 'Energia_Reactiva_Capacitiva_Importada_Rc',
    //             t_dat_iec870_load_profile_2.e_react_cap_imp_cualif as 'Bit_Calidad_Reactiva_Imp_Rc',
    //             t_dat_iec870_load_profile_2.e_react_cap_exp as 'Energia_Reactiva_Capacitiva_Exportada_Rc',
    //             t_dat_iec870_load_profile_2.e_react_cap_exp_cualif as 'Bit_Calidad_Reactiva_Exp_Rc'
    //         FROM reader.t_dat_iec870_load_profile_2
    //         INNER JOIN reader.t_meter_params_iec870 ON t_dat_iec870_load_profile_2.id_cnt = t_meter_params_iec870.id_cnt
    //         WHERE t_dat_iec870_load_profile_2.id_cnt IN (" . implode(',', array_fill(0, count($id_cnts), '?')) . ")";


    //         $params = $id_cnts;


    //         if ($fecha_inicio && $fecha_fin) {
    //             $query .= "
    //             AND t_dat_iec870_load_profile_2.fh >= ?
    //             AND t_dat_iec870_load_profile_2.fh <= ?
    //             ORDER BY t_meter_params_iec870.cups desc, t_dat_iec870_load_profile_2.fh DESC";
    //             $params = array_merge($params, [$fecha_inicio, $fecha_fin]);
    //         } else {
    //             $query .= "
    //             ORDER BY t_meter_params_iec870.cups desc, t_dat_iec870_load_profile_2.fh DESC
    //             LIMIT 168";
    //         }


    //         // Añadir paginación
    //         $perPage = 15;  // Número de resultados por página
    //         $page = $request->input('page', 1);  // Página actual
    //         $offset = ($page - 1) * $perPage;


    //         // Obtener todos los resultados
    //         $resultadosQ24pf = DB::connection($connectionpf)->select($query, $params);


    //         // Crear una colección paginada manualmente
    //         $items = array_slice($resultadosQ24pf, $offset, $perPage);
    //         $paginatedResults = new LengthAwarePaginator($items, count($resultadosQ24pf), $perPage, $page, [
    //             'path' => $request->url(),
    //             'query' => $request->query(),
    //         ]);


    //         return $paginatedResults;
    //     }


    //     return [];
    // }


    public function consultaVeintiCuatropf(Request $request, $connectionpf, $fecha_inicio, $fecha_fin)
{
    set_time_limit(0);

    $id_cnts = $request->input('id_cnts', []);
    $fecha_inicio = $request->input('fecha_inicio');
    $fecha_fin = $request->input('fecha_fin');

    if (!empty($id_cnts)) {
        // Construir query con Query Builder para compatibilidad PostgreSQL
        $resultadosQ24pf = DB::connection($connectionpf)
            ->table('t_dat_iec870_load_profile_2')
            ->join('t_meter_params_iec870', 't_dat_iec870_load_profile_2.id_cnt', '=', 't_meter_params_iec870.id_cnt')
            ->selectRaw("
                t_meter_params_iec870.id_cups as cups,
                t_dat_iec870_load_profile_2.id_cnt,
                TO_CHAR(t_dat_iec870_load_profile_2.fh, 'DD/MM/YYYY') as fecha,
                TO_CHAR(t_dat_iec870_load_profile_2.fh, 'HH24:MI:SS') as hora,
                t_dat_iec870_load_profile_2.ai as energia_activa_importada_a,
                t_dat_iec870_load_profile_2.ai_bc as bit_calidad_activa_a,
                t_dat_iec870_load_profile_2.ae as energia_activa_exportada_a,
                t_dat_iec870_load_profile_2.ae_bc as bit_calidad_activa_a2,
                t_dat_iec870_load_profile_2.r1 as energia_reactiva_inductiva_importada_ri,
                t_dat_iec870_load_profile_2.r1_bc as bit_calidad_reactiva_imp_ri,
                t_dat_iec870_load_profile_2.r2 as energia_reactiva_inductiva_exportada_ri,
                t_dat_iec870_load_profile_2.r2_bc as bit_calidad_reactiva_imp_ri2,
                t_dat_iec870_load_profile_2.r3 as energia_reactiva_capacitiva_importada_rc,
                t_dat_iec870_load_profile_2.r3_bc as bit_calidad_reactiva_imp_rc,
                t_dat_iec870_load_profile_2.r4 as energia_reactiva_capacitiva_exportada_rc,
                t_dat_iec870_load_profile_2.r4_bc as bit_calidad_reactiva_exp_rc
            ")
            ->whereIn('t_dat_iec870_load_profile_2.id_cnt', $id_cnts);

        if ($fecha_inicio && $fecha_fin) {
            $resultadosQ24pf = $resultadosQ24pf
                ->where('t_dat_iec870_load_profile_2.fh', '>=', $fecha_inicio)
                ->where('t_dat_iec870_load_profile_2.fh', '<=', $fecha_fin)
                ->orderByDesc('t_meter_params_iec870.id_cups')
                ->orderByDesc('t_dat_iec870_load_profile_2.fh');
        } else {
            $resultadosQ24pf = $resultadosQ24pf
                ->orderByDesc('t_meter_params_iec870.id_cups')
                ->orderByDesc('t_dat_iec870_load_profile_2.fh')
                ->limit(168);
        }

        // Obtener resultados
        $resultadosQ24pf = $resultadosQ24pf->get();

        // Exportación a Excel si se solicita
        if ($request->input('export24') === 'excel24') {
            $export = new ResultsExport($resultadosQ24pf);
            return $export->downloadQ24pf();
        }

        // Paginación manual
        $perPage = 15;
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $perPage;
        $items = $resultadosQ24pf->slice($offset, $perPage);
        $paginatedResults = new LengthAwarePaginator($items, count($resultadosQ24pf), $perPage, $page, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return $paginatedResults;
    }

    return [];
}

















    // public function consultaVeintiCuatropf(Request $request, $connectionpf, $fecha_inicio, $fecha_fin)
    // {
    //     $id_cnts = $request->input('id_cnts', []);
    //     $fecha_inicio = $request->input('fecha_inicio');
    //     $fecha_fin = $request->input('fecha_fin');


    //     $allResultados = [];


    //     foreach ($id_cnts as $id_cnt) {
    //         $query = "
    //         SELECT *
    //         FROM v_reportes_curvas_horarias
    //         WHERE id_cnt = ?";


    //         $params = [$id_cnt];


    //         if ($fecha_inicio && $fecha_fin) {
    //             $query .= " AND (STR_TO_DATE(CONCAT(Fecha, ' ', Hora), '%d/%m/%Y %H:%i:%s') BETWEEN ? AND ?)";
    //             $params[] = $fecha_inicio;
    //             $params[] = $fecha_fin;
    //         }


    //         $query .= " ORDER BY CUPS ASC, id_cnt ASC, STR_TO_DATE(CONCAT(Fecha, ' ', Hora), '%d/%m/%Y %H:%i:%s') DESC";


    //         if (empty($fecha_inicio) || empty($fecha_fin)) {
    //             $query .= " LIMIT 168";
    //         }


    //         $resultados = DB::connection($connectionpf)->select($query, $params);
    //         if ($resultados) {
    //             $allResultados[$id_cnt] = $resultados;
    //         }
    //     }
    //     // dd($allResultados);
    //     return $allResultados;
    // }










    // public function consultaVeintiCincopf(Request $request, $connectionpf, $fecha_inicio, $fecha_fin)
    // {
    //     $id_cnts = $request->input('id_cnts', []);
    //     $fecha_inicio = $request->input('fecha_inicio');
    //     $fecha_fin = $request->input('fecha_fin');


    //     if (!empty($id_cnts)) {
    //         // Construir la parte de la consulta que maneja los múltiples id_cnts
    //         // $id_cnt_placeholders = implode(',', array_fill(0, count($id_cnts), '?'));


    //         $query = "
    //     SELECT
    //         t_meter_params_iec870.cups as 'CUPS',
    //         t_dat_iec870_load_profile_1.id_cnt,
    //         DATE_FORMAT(t_dat_iec870_load_profile_1.fh, '%d/%m/%Y') as 'Fecha',
    //         DATE_FORMAT(t_dat_iec870_load_profile_1.fh, '%H:%i:%s') as 'Hora',
    //         t_dat_iec870_load_profile_1.e_act_imp as 'Energia_Activa_Importada_A',
    //         t_dat_iec870_load_profile_1.e_act_imp_cualif as 'Bit_Calidad_Activa_A',
    //         t_dat_iec870_load_profile_1.e_act_exp as 'Energia_Activa_Exportada_A',
    //         t_dat_iec870_load_profile_1.e_act_exp_cualif as 'Bit_Calidad_Activa_A2',
    //         t_dat_iec870_load_profile_1.e_react_ind_imp as 'Energia_Reactiva_Inductiva_Importada_Ri',
    //         t_dat_iec870_load_profile_1.e_react_ind_imp_cualif as 'Bit_Calidad_Reactiva_Imp_Ri',
    //         t_dat_iec870_load_profile_1.e_react_ind_exp as 'Energia_Reactiva_Inductiva_Exportada_Ri',
    //         t_dat_iec870_load_profile_1.e_react_ind_exp_cualif as 'Bit_Calidad_Reactiva_Imp_Ri2',
    //         t_dat_iec870_load_profile_1.e_react_cap_imp as 'Energia_Reactiva_Capacitiva_Importada_Rc',
    //         t_dat_iec870_load_profile_1.e_react_cap_imp_cualif as 'Bit_Calidad_Reactiva_Imp_Rc',
    //         t_dat_iec870_load_profile_1.e_react_cap_exp as 'Energia_Reactiva_Capacitiva_Exportada_Rc',
    //         t_dat_iec870_load_profile_1.e_react_cap_exp_cualif as 'Bit_Calidad_Reactiva_Exp_Rc'
    //     FROM reader.t_dat_iec870_load_profile_1
    //     INNER JOIN reader.t_meter_params_iec870 ON t_dat_iec870_load_profile_1.id_cnt = t_meter_params_iec870.id_cnt
    //     WHERE t_dat_iec870_load_profile_1.id_cnt IN (" . implode(',', array_fill(0, count($id_cnts), '?')) . ")";


    //         $params = $id_cnts;


    //         if ($fecha_inicio && $fecha_fin) {
    //             $query .= "
    //         AND t_dat_iec870_load_profile_1.fh >= ?
    //         AND t_dat_iec870_load_profile_1.fh <= ?
    //         ORDER BY t_meter_params_iec870.cups desc, t_dat_iec870_load_profile_1.fh DESC";
    //             $params = array_merge($params, [$fecha_inicio, $fecha_fin]);
    //         } else {
    //             $query .= "
    //         ORDER BY t_meter_params_iec870.cups desc, t_dat_iec870_load_profile_1.fh DESC
    //         LIMIT 168";
    //         }


    //         $resultadosQ25pf = DB::connection($connectionpf)->select($query, $params);
    //         // dd($resultadosQ25pf);
    //         return $resultadosQ25pf ?: [];
    //     }


    //     return [];
    // }


    //con paginacion y descarga:
    public function consultaVeintiCincopf(Request $request, $connectionpf, $fecha_inicio, $fecha_fin)
{
    set_time_limit(0);

    $id_cnts = $request->input('id_cnts', []);
    $fecha_inicio = $request->input('fecha_inicio');
    $fecha_fin = $request->input('fecha_fin');
    $tipo_reporte = $request->input('tipo_reporte', []);

    if (!empty($id_cnts) && in_array('curvas_cuartihorarias', $tipo_reporte)) {
        // Construir query con Query Builder para PostgreSQL
        $resultadosQ25pf = DB::connection($connectionpf)
            ->table('t_dat_iec870_load_profile_2')
            ->join('t_meter_params_iec870', 't_dat_iec870_load_profile_2.id_cnt', '=', 't_meter_params_iec870.id_cnt')
            ->selectRaw("
                t_meter_params_iec870.id_cups as cups,
                t_dat_iec870_load_profile_2.id_cnt,
                TO_CHAR(t_dat_iec870_load_profile_2.fh, 'DD/MM/YYYY') as fecha,
                TO_CHAR(t_dat_iec870_load_profile_2.fh, 'HH24:MI:SS') as hora,
                t_dat_iec870_load_profile_2.ai as energia_activa_importada_a,
                t_dat_iec870_load_profile_2.ai_bc as bit_calidad_activa_a,
                t_dat_iec870_load_profile_2.ae as energia_activa_exportada_a,
                t_dat_iec870_load_profile_2.ae_bc as bit_calidad_activa_a2,
                t_dat_iec870_load_profile_2.r1 as energia_reactiva_inductiva_importada_ri,
                t_dat_iec870_load_profile_2.r1_bc as bit_calidad_reactiva_imp_ri,
                t_dat_iec870_load_profile_2.r2 as energia_reactiva_inductiva_exportada_ri,
                t_dat_iec870_load_profile_2.r2_bc as bit_calidad_reactiva_imp_ri2,
                t_dat_iec870_load_profile_2.r3 as energia_reactiva_capacitiva_importada_rc,
                t_dat_iec870_load_profile_2.r3_bc as bit_calidad_reactiva_imp_rc,
                t_dat_iec870_load_profile_2.r4 as energia_reactiva_capacitiva_exportada_rc,
                t_dat_iec870_load_profile_2.r4_bc as bit_calidad_reactiva_exp_rc
            ")
            ->whereIn('t_dat_iec870_load_profile_2.id_cnt', $id_cnts);

        if ($fecha_inicio && $fecha_fin) {
            $resultadosQ25pf = $resultadosQ25pf
                ->where('t_dat_iec870_load_profile_2.fh', '>=', $fecha_inicio)
                ->where('t_dat_iec870_load_profile_2.fh', '<=', $fecha_fin)
                ->orderByDesc('t_meter_params_iec870.id_cups')
                ->orderByDesc('t_dat_iec870_load_profile_2.fh');
        } else {
            $resultadosQ25pf = $resultadosQ25pf
                ->orderByDesc('t_meter_params_iec870.id_cups')
                ->orderByDesc('t_dat_iec870_load_profile_2.fh')
                ->limit(168);
        }

        // Obtener resultados
        $resultadosQ25pf = $resultadosQ25pf->get();

        // Paginación manual
        $perPage = 15;
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $perPage;
        $items = $resultadosQ25pf->slice($offset, $perPage);
        $paginatedResults = new LengthAwarePaginator($items, count($resultadosQ25pf), $perPage, $page, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return $paginatedResults;
    }

    return [];
}



public function exportCurvasCuartihorarias(Request $request)
{
    try {
        $connectionName = User::conexionPuntoFrontera();
        //$connectionName2 = 'pgsql-exports';

        if (!Schema::connection($connectionName)->hasTable('t_dat_iec870_load_profile_2')) {
            return response()->json(['message' => 'La tabla no existe'], 404);
        }

        $format = $request->input('format', 'excel');
        $extension = $format === 'csv' ? 'csv' : 'xlsx';

        $id_cnts = $request->input('id_cnts', []);
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');

        if (empty($id_cnts)) {
            return response()->json(['message' => 'Debe proporcionar id_cnts'], 422);
        }

        $fileName = 'exports/curvas_cuartihorarias_' . time() . '.' . $extension;
        $exportId = (string) Str::uuid();

        ExportProgress::create([
            'export_id' => $exportId,
            'status' => 'pending',
            'progress' => 0,
        ]);

        ExportCurvasCuartihorariasJob::dispatch($id_cnts, $fecha_inicio, $fecha_fin, $fileName, $connectionName, $exportId)
            ->onQueue('default')
            ->onConnection('pgsql-exports');

        return response()->json([
            'message' => 'Exportación iniciada.',
            'export_id' => $exportId
        ]);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
    }
}





    public function consultaVeintiSeispf($id_cnt, $connectionpf)
{
    if ($id_cnt) {
        $resultadosQ26pf = DB::connection($connectionpf)->select("
            SELECT
                TO_CHAR(t_dat_iec870_monthly_billing.fhi, 'MM/YYYY') AS fecha_inicio,
                t_dat_iec870_monthly_billing.e_act_inc AS energia_activa_incremental,
                t_dat_iec870_monthly_billing.ctr AS contrato
            FROM
                t_dat_iec870_monthly_billing
            INNER JOIN
                t_meter_params_iec870
                ON t_dat_iec870_monthly_billing.id_cnt = t_meter_params_iec870.id_cnt
            WHERE
                t_dat_iec870_monthly_billing.id_cnt = :id_cnt1
                AND t_dat_iec870_monthly_billing.pt = '0'  -- Periodo Tarifario 0
                AND t_dat_iec870_monthly_billing.fhf >= (
                    SELECT
                        MAX(fhf) - INTERVAL '11 months'
                    FROM
                        t_dat_iec870_monthly_billing
                    WHERE
                        id_cnt = :id_cnt2
                )
            ORDER BY
                t_dat_iec870_monthly_billing.fhi ASC;
        ", [
            'id_cnt1' => $id_cnt,
            'id_cnt2' => $id_cnt
        ]);


        return $resultadosQ26pf ?: [];
    }

    return [];
}



    public function consultaVeintiSietepf($id_cnt, $connectionpf)
{
    if ($id_cnt) {
        $resultadosQ27pf = DB::connection($connectionpf)->select("
            SELECT 
                TO_CHAR(t_dat_iec870_monthly_billing.pot_max_fh, 'MM/YYYY') AS fecha,
                TO_CHAR(
                    MAX(t_dat_iec870_monthly_billing.pot_max),
                    'FM999999990.00'
                ) AS maximetros
            FROM 
                t_dat_iec870_monthly_billing
            INNER JOIN 
                t_meter_params_iec870
                ON t_dat_iec870_monthly_billing.id_cnt = t_meter_params_iec870.id_cnt
            WHERE 
                t_dat_iec870_monthly_billing.id_cnt = :id_cnt
                AND t_dat_iec870_monthly_billing.pot_max_fh >=
                    CURRENT_DATE - INTERVAL '12 months'
            GROUP BY 
                TO_CHAR(t_dat_iec870_monthly_billing.pot_max_fh, 'MM/YYYY')
            ORDER BY 
                MAX(t_dat_iec870_monthly_billing.pot_max_fh) DESC;
        ", ['id_cnt' => $id_cnt]);

        return $resultadosQ27pf ?: [];
    }

    return [];
}

    


public function consultaVeintiOchopf($id_cnt, $connectionpf)
{
    if ($id_cnt) {
        // Ejecuta la consulta usando el valor de $id_cnt
        $resultadosQ28pf = DB::connection($connectionpf)->select("
             SELECT  
            t_dat_iec870_monthly_billing.ctr as contrato,
            t_dat_iec870_monthly_billing.pt as periodo_tarifario,
            SUM(t_dat_iec870_monthly_billing.e_act_inc) as energia_activa_incremental
        FROM 
            t_dat_iec870_monthly_billing
        INNER JOIN 
            t_meter_params_iec870 
            ON t_dat_iec870_monthly_billing.id_cnt = t_meter_params_iec870.id_cnt
        WHERE 
            t_dat_iec870_monthly_billing.id_cnt = :id_cnt
            AND t_dat_iec870_monthly_billing.pt > 0  -- Excluir el periodo tarifario 0
            AND t_dat_iec870_monthly_billing.ctr IN (1, 2, 3) -- Filtrar contratos tipo 1, 2 y 3
        GROUP BY 
            t_dat_iec870_monthly_billing.ctr, 
            t_dat_iec870_monthly_billing.pt  
        ORDER BY 
            t_dat_iec870_monthly_billing.ctr ASC; 
        ", ['id_cnt' => $id_cnt]);


        //dd($resultadosQ28pf); // Descomenta si necesitas inspeccionar los resultados en desarrollo


        // Retorna los resultados o un array vacío si no hay datos
        return $resultadosQ28pf ?: [];
    }


    return [];
}


}




