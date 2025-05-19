<?php




namespace App\Http\Controllers;


use App\Exports\EventosPFExport;
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
        $resultadosQ5pf = $this->consultaCincopf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin);
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
            'resultadosQ5pf' => $resultadosQ5pf,
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


        ]);
    }






    //CONSULTAS iniciales para extraer datos
    public function datosGrupos($connectionpf)
    {
        $user = Auth::user(); //obtenemos los datos del usuario autenticado
        $cod_id_group = $user->cod_id_group; //metemos el codigo del grupo del usuario autentiado en la variable


        $datos = DB::connection($connectionpf)
            ->select("SELECT * FROM reader.t_reader_groups WHERE cod_id_group = $cod_id_group;");
        //  dd($datos);
        return $datos ?: [];
    }




    public function parametros($connectionpf)
    {
        $user = Auth::user(); //obtenemos los datos del usuario autenticado
        $cod_id_group = $user->cod_id_group; //metemos el codigo del grupo del usuario autentiado en la variable


        $parametros = DB::connection($connectionpf)
            ->select("SELECT * FROM reader.t_meter_params_iec870
            WHERE cod_id_group = $cod_id_group;");
        //  dd($parametros);
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
                SELECT curva_1, cod_id_group
                FROM t_meter_params_iec870
                WHERE cod_id_group = ?
                AND id_cnt IN ($placeholders)";


                $params = array_merge([$cod_id_group], $id_cnt);
                $mostrarcurvascuartihorarias = DB::connection($connectionpf)->select($query, $params);
            } else {
                // Consulta para un solo id_cnt
                $query = "
                SELECT curva_1, cod_id_group
                FROM t_meter_params_iec870
                WHERE cod_id_group = ?
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
                    t_meter_params_iec870.cups,
                    t_meter_params_iec870.description,
                    t_meter_params_iec870.direnlace,
                    t_meter_params_iec870.pm,
                    t_meter_params_iec870.password,
                    t_reader_meter_data.rel_trafos_intensidad,
                    t_reader_meter_data.rel_trafos_tension,
                    t_reader_meter_data.dir_punto_medida,
                    t_reader_meter_data.tip_punto_medida,
                    t_reader_meter_data.id_punto_medida,
                    t_reader_meter_data.lat_punto_medida,
                    t_reader_meter_data.lon_punto_medida,
                    t_reader_connections.conx_name,
                    t_reader_connections.conx_info
                FROM 
                    t_meter_params_iec870, t_reader_meter_data, t_reader_connections
                WHERE  
                    t_meter_params_iec870.id_cnt = t_reader_meter_data.id_cnt
                    AND t_meter_params_iec870.cod_id_conx = t_reader_connections.cod_id_conx
                    AND t_meter_params_iec870.id_cnt IN ($placeholders)
            ";
                $resultadosQ1pf = DB::connection($connectionpf)->select($query, $id_cnt);
            } else {
                // Consulta para un solo id_cnt
                $query = "
                SELECT 
                    t_meter_params_iec870.id_cnt,
                    t_meter_params_iec870.cups,
                    t_meter_params_iec870.description,
                    t_meter_params_iec870.direnlace,
                    t_meter_params_iec870.pm,
                    t_meter_params_iec870.password,
                    t_reader_meter_data.rel_trafos_intensidad,
                    t_reader_meter_data.rel_trafos_tension,
                    t_reader_meter_data.dir_punto_medida,
                    t_reader_meter_data.tip_punto_medida,
                    t_reader_meter_data.id_punto_medida,
                    t_reader_meter_data.lat_punto_medida,
                    t_reader_meter_data.lon_punto_medida,
                    t_reader_connections.conx_name,
                    t_reader_connections.conx_info
                FROM 
                    t_meter_params_iec870, t_reader_meter_data, t_reader_connections
                WHERE  
                    t_meter_params_iec870.id_cnt = t_reader_meter_data.id_cnt
                    AND t_meter_params_iec870.cod_id_conx = t_reader_connections.cod_id_conx
                    AND t_meter_params_iec870.id_cnt = :id_cnt
            ";
                $resultadosQ1pf = DB::connection($connectionpf)->select($query, ['id_cnt' => $id_cnt]);
            }
            return $resultadosQ1pf ?: [];
        }
        return [];
    }






    public function consultaDospf($id_cnt, $connectionpf) //Fecha ultimo cierre
    {
        if ($id_cnt) {
            $resultadosQ2pf = DB::connection($connectionpf)
                ->select('
                SELECT MAX(id) as max_id, DATE_FORMAT(t_dat_iec870_monthly_billing.fhf, "%d/%m/%Y %H:%i:%s") as fecha_ultima_cierre
                FROM t_dat_iec870_monthly_billing,t_meter_params_iec870
                WHERE t_meter_params_iec870.id_cnt = :id_cnt
                AND t_dat_iec870_monthly_billing.id_cnt = t_meter_params_iec870.id_cnt
                GROUP BY 2
                ORDER BY 1 DESC
                LIMIT 1
            ', ['id_cnt' => $id_cnt]);
            return $resultadosQ2pf  ?: [];
        }
    }




    public function consultaTrespf($id_cnt, $connectionpf) //Fecha ultima curva
    {
        if ($id_cnt) {
            $resultadosQ3pf = DB::connection($connectionpf)
                ->select('
                SELECT MAX(id) as max_id, DATE_FORMAT(t_dat_iec870_load_profile_1.fh, "%d/%m/%Y %H:%i:%s") as fecha_ultima_curva
                FROM t_dat_iec870_load_profile_1, t_meter_params_iec870
                WHERE t_meter_params_iec870.id_cnt = :id_cnt
                AND t_dat_iec870_load_profile_1.id_cnt = t_meter_params_iec870.id_cnt
                GROUP BY 2
                ORDER BY 1 DESC
                LIMIT 1
            ', ['id_cnt' => $id_cnt]);
            // dd($resultadosQ3pf);
            return $resultadosQ3pf  ?: [];
        }
    }




    public function consultaCuatropf($id_cnt, $connectionpf) //Fecha ultimo evento
    {
        if ($id_cnt) {
            $resultadosQ4pf = DB::connection($connectionpf)
                ->select('
                SELECT MAX(id) as max_id, t_dat_iec870_eventos.fh as fecha_ultimo_evento
                FROM t_dat_iec870_eventos,t_meter_params_iec870
                WHERE t_meter_params_iec870.id_cnt = :id_cnt
                AND t_dat_iec870_eventos.id_cnt = t_meter_params_iec870.id_cnt
                group by 2
                order by 1 desc
                limit 1
            ', ['id_cnt' => $id_cnt]);
            return $resultadosQ4pf  ?: [];
        }
    }




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




    public function consultaSeispf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin)
    {
        if ($id_cnt) {
            $query = "SELECT
                    t_meter_params_iec870.cups as CUPS,
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
                FROM reader.t_dat_iec870_monthly_billing
                INNER JOIN reader.t_meter_params_iec870 ON t_dat_iec870_monthly_billing.id_cnt = t_meter_params_iec870.id_cnt
                WHERE t_dat_iec870_monthly_billing.id_cnt = :id_cnt";


            if ($fecha_inicio && $fecha_fin) {
                $query .= "
                AND t_dat_iec870_monthly_billing.fhi >= :fecha_inicio
                AND t_dat_iec870_monthly_billing.fhf <= :fecha_fin
                ORDER BY t_dat_iec870_monthly_billing.fhi DESC, t_dat_iec870_monthly_billing.fhf DESC";
                $params = ['id_cnt' => $id_cnt, 'fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin];
            } else {
                $query .= "
            ORDER BY t_dat_iec870_monthly_billing.fhi DESC, t_dat_iec870_monthly_billing.fhf DESC";
                // No se aplican restricciones de fecha
                $params = ['id_cnt' => $id_cnt];
            }




            $resultadosQ6pf = DB::connection($connectionpf)->select($query, $params);
            // dd($resultadosQ6pf);
            return $resultadosQ6pf ?: [];
        }
    }








    public function consultaSietepf($id_cnt, $connectionpf) //Log de Comnicaciones
    {
        if ($id_cnt) {
            $resultadosQ7pf = DB::connection($connectionpf)
                ->select('
                SELECT des_fab as fabricante
                FROM t_reader_meter_vendors, t_meter_params_iec870
                WHERE substring(t_meter_params_iec870.id_cnt, 1, 1) = t_reader_meter_vendors.id_fab
                AND t_meter_params_iec870.id_cnt = :id_cnt
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
            FROM reader.t_dat_iec870_load_profile_2
            INNER JOIN reader.t_meter_params_iec870 ON t_dat_iec870_load_profile_2.id_cnt = t_meter_params_iec870.id_cnt
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
                FROM t_dat_iec870_eventos
                WHERE reader.t_dat_iec870_eventos.id_cnt = :id_cnt
                and t_dat_iec870_eventos.DR = '52'
                and t_dat_iec870_eventos.SPA = '3'
                and t_dat_iec870_eventos.SPQ = '0'
                and t_dat_iec870_eventos.SPI = '1';
        ", ['id_cnt' => $id_cnt]);
            return $resultadosQ9pf  ?: [];
        }
    }




    public function consultaDiezpf($id_cnt, $connectionpf) //Estadisticas de Cortes
    {
        if ($id_cnt) {

            if(Str::startsWith($id_cnt, 'B') || Str::startsWith($id_cnt, 'C')) {
                $resultadosQ10pf = DB::connection($connectionpf)
                ->select("
                SELECT
                    t_meter_params_iec870.cups AS 'CUPS',
                    e.id_cnt,
                    e.fh AS 'Fecha_Corte',
                    (SELECT TIMESTAMPDIFF(SECOND, 
                                STR_TO_DATE(e.fh, '%d/%m/%Y %H:%i:%s'), 
                                STR_TO_DATE(fin.fh, '%d/%m/%Y %H:%i:%s'))
                    FROM t_dat_iec870_eventos fin
                    WHERE fin.id_cnt = e.id_cnt
                    AND fin.DR = 52 AND fin.SPA = 1 AND fin.SPQ = 2 AND fin.SPI = 1
                    AND STR_TO_DATE(fin.fh, '%d/%m/%Y %H:%i:%s') > STR_TO_DATE(e.fh, '%d/%m/%Y %H:%i:%s')
                    ORDER BY STR_TO_DATE(fin.fh, '%d/%m/%Y %H:%i:%s') ASC
                    LIMIT 1
                    ) AS 'duracion_segundos'
                FROM t_dat_iec870_eventos e
                JOIN t_meter_params_iec870
                    ON e.id_cnt = t_meter_params_iec870.id_cnt
                WHERE e.id_cnt = :id_cnt
                AND e.DR = '52'
                AND e.SPA = '3'
                AND e.SPQ = '0'
                AND e.SPI = '1'
                ORDER BY STR_TO_DATE(e.fh, '%d/%m/%Y %H:%i:%s') DESC;

                ", ['id_cnt' => $id_cnt]);

            } else if(Str::startsWith($id_cnt, 'Q') || Str::startsWith($id_cnt, 'Z')) {
                $resultadosQ10pf = DB::connection($connectionpf)
                ->select("
                SELECT
                    t_meter_params_iec870.cups AS 'CUPS',
                    e.id_cnt,
                    e.fh AS 'Fecha_Corte',
                    (SELECT TIMESTAMPDIFF(SECOND, 
                                STR_TO_DATE(e.fh, '%d/%m/%Y %H:%i:%s'), 
                                STR_TO_DATE(fin.fh, '%d/%m/%Y %H:%i:%s'))
                    FROM t_dat_iec870_eventos fin
                    WHERE fin.id_cnt = e.id_cnt
                    AND fin.DR = 52 AND fin.SPA = 3 AND fin.SPQ = 0 AND fin.SPI = 0
                    AND STR_TO_DATE(fin.fh, '%d/%m/%Y %H:%i:%s') > STR_TO_DATE(e.fh, '%d/%m/%Y %H:%i:%s')
                    ORDER BY STR_TO_DATE(fin.fh, '%d/%m/%Y %H:%i:%s') ASC
                    LIMIT 1
                    ) AS 'duracion_segundos'
                FROM t_dat_iec870_eventos e
                JOIN t_meter_params_iec870
                    ON e.id_cnt = t_meter_params_iec870.id_cnt
                WHERE e.id_cnt = :id_cnt
                AND e.DR = '52'
                AND e.SPA = '1'
                AND e.SPQ = '2'
                AND e.SPI = '0'
                ORDER BY STR_TO_DATE(e.fh, '%d/%m/%Y %H:%i:%s') DESC;

                ", ['id_cnt' => $id_cnt]);

            } 
            return $resultadosQ10pf  ?: [];
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
        FROM reader.t_dat_iec870_eventos, t_reader_events_description
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
        FROM reader.t_dat_iec870_eventos, t_reader_events_description
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
        FROM reader.t_dat_iec870_eventos, t_reader_events_description
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
                reader.t_dat_iec870_load_profile_2,  t_meter_params_iec870
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
                    FROM reader.t_dat_iec870_load_profile_2
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
                        reader.t_dat_iec870_load_profile_2
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
                    reader.t_dat_iec870_load_profile_2
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
                    reader.t_dat_iec870_load_profile_2
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
                    reader.t_dat_iec870_load_profile_2
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
    public function consultaDiecisietepf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin,) //Cuenta de curvas a 0
    {
        if ($id_cnt) {
            $query = "
            SELECT
                COUNT(t_dat_iec870_load_profile_1.fh) AS Energia_Activa_Importada_A
            FROM
                reader.t_dat_iec870_load_profile_1,  t_meter_params_iec870
                WHERE t_meter_params_iec870.id_cnt = :id_cnt
            AND t_dat_iec870_load_profile_1.id_cnt = t_meter_params_iec870.id_cnt
                AND t_dat_iec870_load_profile_1.e_act_imp = 0";




            if ($fecha_inicio && $fecha_fin) {
                $query .= "
                AND t_dat_iec870_load_profile_1.fh BETWEEN :fecha_inicio AND :fecha_fin";
                $params = ['id_cnt' => $id_cnt, 'fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin];
            } else {
                $query .= "
                AND t_dat_iec870_load_profile_1.fh >= (
                    SELECT MAX(fh) - INTERVAL 168 HOUR
                    FROM reader.t_dat_iec870_load_profile_1
                  );
                ";
                $params = ['id_cnt' => $id_cnt];
            }


            $resultadosQ17pf = DB::connection($connectionpf)
                ->select($query, $params);


            // dd($resultadosQ17pf);


            return $resultadosQ17pf ?: [];
        }
    }


    public function consultaDieciochopf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin)
    {
        try {
            if ($id_cnt) {
                $query = "
                    SELECT 
                        SUM(e_act_imp) AS suma_importada
                    FROM 
                        reader.t_dat_iec870_load_profile_1
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


                $resultadosQ18pf = DB::connection($connectionpf)
                    ->select($query, $params);


                // dd($resultadosQ18pf);
                return $resultadosQ18pf ?: [];
            }
        } catch (\Exception $e) {
            return ['message' => 'Error: ' . $e->getMessage()];
        }
    }


    public function consultaDiecinuevepf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin)
    {
        try {
            if ($id_cnt) {
                $query = "
                SELECT 
                    SUM(e_act_exp) AS suma_exportada
                FROM 
                    reader.t_dat_iec870_load_profile_1
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


                $resultadosQ19pf = DB::connection($connectionpf)
                    ->select($query, $params);


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
                t_meter_params_iec870.cups as 'CUPS',
                t_dat_iec870_load_profile_1.id_cnt,
                DATE_FORMAT(t_dat_iec870_load_profile_1.fh, '%d/%m/%Y') as 'Fecha',
                DATE_FORMAT(t_dat_iec870_load_profile_1.fh, '%H:%i:%s') as 'Hora',
                t_dat_iec870_load_profile_1.e_act_imp as 'Energia_Activa_Importada_A',
                t_dat_iec870_load_profile_1.e_act_imp_cualif as 'Bit_Calidad_Activa_A',
                t_dat_iec870_load_profile_1.e_act_exp as 'Energia_Activa_Exportada_A',
                t_dat_iec870_load_profile_1.e_act_exp_cualif as 'Bit_Calidad_Activa_A2',
                t_dat_iec870_load_profile_1.e_react_ind_imp as 'Energia_Reactiva_Inductiva_Importada_Ri',
                t_dat_iec870_load_profile_1.e_react_ind_imp_cualif as 'Bit_Calidad_Reactiva_Imp_Ri',
                t_dat_iec870_load_profile_1.e_react_ind_exp as 'Energia_Reactiva_Inductiva_Exportada_Ri',
                t_dat_iec870_load_profile_1.e_react_ind_exp_cualif as 'Bit_Calidad_Reactiva_Imp_Ri2',
                t_dat_iec870_load_profile_1.e_react_cap_imp as 'Energia_Reactiva_Capacitiva_Importada_Rc',
                t_dat_iec870_load_profile_1.e_react_cap_imp_cualif as 'Bit_Calidad_Reactiva_Imp_Rc',
                t_dat_iec870_load_profile_1.e_react_cap_exp as 'Energia_Reactiva_Capacitiva_Exportada_Rc',
                t_dat_iec870_load_profile_1.e_react_cap_exp_cualif as 'Bit_Calidad_Reactiva_Exp_Rc'
            FROM reader.t_dat_iec870_load_profile_1
            INNER JOIN reader.t_meter_params_iec870 ON t_dat_iec870_load_profile_1.id_cnt = t_meter_params_iec870.id_cnt
            WHERE t_dat_iec870_load_profile_1.id_cnt = :id_cnt";




            if ($fecha_inicio && $fecha_fin) {
                $query .= "
                AND t_dat_iec870_load_profile_1.fh >= :fecha_inicio
                AND t_dat_iec870_load_profile_1.fh <= :fecha_fin
                ORDER BY t_dat_iec870_load_profile_1.fh DESC
                ";
                $params = ['id_cnt' => $id_cnt, 'fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin];
            } else {
                $query .= "
                ORDER BY t_dat_iec870_load_profile_1.fh DESC
                LIMIT 168";
                $params = ['id_cnt' => $id_cnt];
            }




            $resultadosQ20pf = DB::connection($connectionpf)->select($query, $params);




            // dd($resultadosQ20pf);
            return $resultadosQ20pf ?: [];
        }
    }


    public function consultaVeintiunopf($id_cnt, $connectionpf, $fecha_inicio, $fecha_fin)
    {
        try {
            if ($id_cnt) {
                $query = "
                SELECT 
                    DATE_FORMAT(fh, '%H:00:00') AS hora,
                    ROUND(AVG(e_act_imp), 2) AS media_consumo_hora_imp,
                    ROUND(AVG(e_act_exp), 2) AS media_consumo_hora_exp
                FROM 
                    reader.t_dat_iec870_load_profile_1
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
                SELECT 
                    ELT(DAYOFWEEK(fh), 'Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado') AS dia_semana,
                    ROUND(AVG(e_act_imp), 2) AS media_consumo_dia_imp,
                    ROUND(AVG(e_act_exp), 2) AS media_consumo_dia_exp
                FROM 
                    reader.t_dat_iec870_load_profile_1
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


        if (!empty($id_cnts)) {
            $query = "SELECT
            t_meter_params_iec870.cups as CUPS,
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
        FROM reader.t_dat_iec870_monthly_billing
        INNER JOIN reader.t_meter_params_iec870 ON t_dat_iec870_monthly_billing.id_cnt = t_meter_params_iec870.id_cnt
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


            // Añadir paginación
            $perPage = 15;  // Número de resultados por página
            $page = $request->input('page', 1);  // Página actual
            $offset = ($page - 1) * $perPage;


            // Obtener todos los resultados
            $resultadosQ23pf = DB::connection($connectionpf)->select($query, $params);


            if ($request->input('export23') === 'excel23') {
                // Llama a la clase ResultsExport para generar y descargar el archivo Excel
                $export = new ResultsExport($resultadosQ23pf);
                return $export->downloadQ23pf();
            }


            // Crear una colección paginada manualmente
            $items = array_slice($resultadosQ23pf, $offset, $perPage);
            $paginatedResults = new LengthAwarePaginator($items, count($resultadosQ23pf), $perPage, $page, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);
            // dd($paginatedResults);
            return $paginatedResults;
        }


        return [];
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
            FROM reader.t_dat_iec870_load_profile_2
            INNER JOIN reader.t_meter_params_iec870 ON t_dat_iec870_load_profile_2.id_cnt = t_meter_params_iec870.id_cnt
            WHERE t_dat_iec870_load_profile_2.id_cnt IN (" . implode(',', array_fill(0, count($id_cnts), '?')) . ")";


            $params = $id_cnts;


            if ($fecha_inicio && $fecha_fin) {
                $query .= "
                AND t_dat_iec870_load_profile_2.fh >= ?
                AND t_dat_iec870_load_profile_2.fh <= ?
                ORDER BY t_meter_params_iec870.cups desc, t_dat_iec870_load_profile_2.fh DESC";
                $params = array_merge($params, [$fecha_inicio, $fecha_fin]);
            } else {
                $query .= "
                ORDER BY t_meter_params_iec870.cups desc, t_dat_iec870_load_profile_2.fh DESC
                LIMIT 168";
            }


            // Añadir paginación
            $perPage = 15;  // Número de resultados por página
            $page = $request->input('page', 1);  // Página actual
            $offset = ($page - 1) * $perPage;


            // Obtener todos los resultados
            $resultadosQ24pf = DB::connection($connectionpf)->select($query, $params);


            if ($request->input('export24') === 'excel24') {
                // Llama a la clase ResultsExport para generar y descargar el archivo Excel
                $export = new ResultsExport($resultadosQ24pf);
                return $export->downloadQ24pf();
            }


            // Crear una colección paginada manualmente
            $items = array_slice($resultadosQ24pf, $offset, $perPage);
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


        if (!empty($id_cnts)) {
            $query = "
        SELECT
            t_meter_params_iec870.cups as 'CUPS',
            t_dat_iec870_load_profile_1.id_cnt,
            DATE_FORMAT(t_dat_iec870_load_profile_1.fh, '%d/%m/%Y') as 'Fecha',
            DATE_FORMAT(t_dat_iec870_load_profile_1.fh, '%H:%i:%s') as 'Hora',
            t_dat_iec870_load_profile_1.e_act_imp as 'Energia_Activa_Importada_A',
            t_dat_iec870_load_profile_1.e_act_imp_cualif as 'Bit_Calidad_Activa_A',
            t_dat_iec870_load_profile_1.e_act_exp as 'Energia_Activa_Exportada_A',
            t_dat_iec870_load_profile_1.e_act_exp_cualif as 'Bit_Calidad_Activa_A2',
            t_dat_iec870_load_profile_1.e_react_ind_imp as 'Energia_Reactiva_Inductiva_Importada_Ri',
            t_dat_iec870_load_profile_1.e_react_ind_imp_cualif as 'Bit_Calidad_Reactiva_Imp_Ri',
            t_dat_iec870_load_profile_1.e_react_ind_exp as 'Energia_Reactiva_Inductiva_Exportada_Ri',
            t_dat_iec870_load_profile_1.e_react_ind_exp_cualif as 'Bit_Calidad_Reactiva_Imp_Ri2',
            t_dat_iec870_load_profile_1.e_react_cap_imp as 'Energia_Reactiva_Capacitiva_Importada_Rc',
            t_dat_iec870_load_profile_1.e_react_cap_imp_cualif as 'Bit_Calidad_Reactiva_Imp_Rc',
            t_dat_iec870_load_profile_1.e_react_cap_exp as 'Energia_Reactiva_Capacitiva_Exportada_Rc',
            t_dat_iec870_load_profile_1.e_react_cap_exp_cualif as 'Bit_Calidad_Reactiva_Exp_Rc'
        FROM reader.t_dat_iec870_load_profile_1
        INNER JOIN reader.t_meter_params_iec870 ON t_dat_iec870_load_profile_1.id_cnt = t_meter_params_iec870.id_cnt
        WHERE t_dat_iec870_load_profile_1.id_cnt IN (" . implode(',', array_fill(0, count($id_cnts), '?')) . ")";


            $params = $id_cnts;


            if ($fecha_inicio && $fecha_fin) {
                $query .= "
            AND t_dat_iec870_load_profile_1.fh >= ?
            AND t_dat_iec870_load_profile_1.fh <= ?
            ORDER BY t_meter_params_iec870.cups desc, t_dat_iec870_load_profile_1.fh DESC";
                $params = array_merge($params, [$fecha_inicio, $fecha_fin]);
            } else {
                $query .= "
            ORDER BY t_meter_params_iec870.cups desc, t_dat_iec870_load_profile_1.fh DESC
            LIMIT 168";
            }


            // Añadir paginación
            $perPage = 15;  // Número de resultados por página
            $page = $request->input('page', 1);  // Página actual
            $offset = ($page - 1) * $perPage;


            // Obtener todos los resultados
            $resultadosQ25pf = DB::connection($connectionpf)->select($query, $params);


            if ($request->input('export25') === 'excel25') {
                // Llama a la clase ResultsExport para generar y descargar el archivo Excel
                $export = new ResultsExport($resultadosQ25pf);
                return $export->downloadQ25pf();
            }


            // Crear una colección paginada manualmente
            $items = array_slice($resultadosQ25pf, $offset, $perPage);
            $paginatedResults = new LengthAwarePaginator($items, count($resultadosQ25pf), $perPage, $page, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);


            return $paginatedResults;
        }


        return [];
    }


    public function consultaVeintiSeispf($id_cnt, $connectionpf)
    {
        if ($id_cnt) {
            // Ejecuta la consulta usando el valor de $id_cnt en el parámetro
            $resultadosQ26pf = DB::connection($connectionpf)->select("
            SELECT
                date_format(t_dat_iec870_monthly_billing.fhi, '%m/%Y') as Fecha_Inicio,
                t_dat_iec870_monthly_billing.e_act_inc as Energia_Activa_Incremental,
                t_dat_iec870_monthly_billing.ctr as Contrato
            FROM
                reader.t_dat_iec870_monthly_billing
            INNER JOIN
                reader.t_meter_params_iec870 
                ON t_dat_iec870_monthly_billing.id_cnt = t_meter_params_iec870.id_cnt
            WHERE
                t_dat_iec870_monthly_billing.id_cnt = :id_cnt1                
                AND t_dat_iec870_monthly_billing.pt = '0'  -- Periodo Tarifario 0
                AND t_dat_iec870_monthly_billing.fhf >= (
                    SELECT 
                        DATE_SUB(MAX(fhf), INTERVAL 11 MONTH)
                    FROM 
                        reader.t_dat_iec870_monthly_billing
                    WHERE 
                        id_cnt = :id_cnt2
                )
            ORDER BY 
                t_dat_iec870_monthly_billing.fhi ASC;
        ", [
                'id_cnt1' => $id_cnt,  // Primer uso de id_cnt
                'id_cnt2' => $id_cnt   // Segundo uso de id_cnt en la subconsulta
            ]);


            // Depuración de resultados
            //dd($resultadosQ26pf); // Descomenta si necesitas inspeccionar los resultados en desarrollo


            // Devuelve los resultados o un array vacío si no hay datos
            return $resultadosQ26pf ?: [];
        }


        // Si $id_cnt no está presente, retorna un array vacío
        return [];
    }


    public function consultaVeintiSietepf($id_cnt, $connectionpf)
    {
        if ($id_cnt) {
            // Ejecuta la consulta usando el valor de $id_cnt
            $resultadosQ27pf = DB::connection($connectionpf)->select("
                 SELECT 
                    DATE_FORMAT(t_dat_iec870_monthly_billing.pot_max_fh, '%m/%Y') AS Fecha,
                    FORMAT(AVG(t_dat_iec870_monthly_billing.pot_max), 2) AS Maximetros
                FROM 
                    reader.t_dat_iec870_monthly_billing
                INNER JOIN 
                    reader.t_meter_params_iec870 
                    ON t_dat_iec870_monthly_billing.id_cnt = t_meter_params_iec870.id_cnt
                WHERE 
                    t_dat_iec870_monthly_billing.id_cnt = :id_cnt
                    AND t_dat_iec870_monthly_billing.pot_max_fh >= DATE_SUB(CURRENT_DATE, INTERVAL 12 MONTH)
                GROUP BY 
                    DATE_FORMAT(t_dat_iec870_monthly_billing.pot_max_fh, '%m/%Y')
                ORDER BY 
                    MAX(t_dat_iec870_monthly_billing.pot_max_fh) DESC;
            ", ['id_cnt' => $id_cnt]);
    
    
            //dd($resultadosQ27pf); // Descomenta si necesitas inspeccionar los resultados en desarrollo
    
    
            // Retorna los resultados o un array vacío si no hay datos
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
            t_dat_iec870_monthly_billing.ctr as Contrato,
            t_dat_iec870_monthly_billing.pt as Periodo_Tarifario,
            SUM(t_dat_iec870_monthly_billing.e_act_inc) as Energia_Activa_Incremental
        FROM 
            reader.t_dat_iec870_monthly_billing
        INNER JOIN 
            reader.t_meter_params_iec870 
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




