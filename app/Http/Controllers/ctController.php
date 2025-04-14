<?php




namespace App\Http\Controllers;




use App\Exports\EventosCTExport;
use App\Exports\ReportesCalidadExport;
use App\Exports\ReportesInventarioExport;
use App\Exports\ReportesInventarioFWExport;
use App\Exports\SumBalancesExport;
use App\Models\ConsumoDiario;
use App\Models\Ct;
use App\Models\Cups;
use App\Models\Estadisticas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Maatwebsite\Excel\Facades\Excel; 
use Maatwebsite\Excel\Excel as ExcelFormat;
use App\Exports\CurvasHorariasExport;
use App\Exports\ReportesEventosExport;




class ctController extends Controller
{




    // INFORMACION DEL CT ------------------------------------------------
    public function informacionct(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }




        $id_ct = $request->input('id_ct');




        // Guardar el id_ct en la sesión
        Session::put('id_ct', $id_ct);
        // dd(session('id_ct'));




        // Guardar el nombre de la vista actual en la sesión
        Session::put('vista_actual', 'informacionct');




        // Obtener la conexión dinámica
        $connection = User::conexion();




        if ($connection == 'pgsql') {
            // Si la conexión es la predeterminada, retornar un mensaje de bienvenida para el admin
            return view('admin/admin');
        } else {
            // Obtener los datos de todos los CTs
            $ct_info = Ct::on($connection)->select('id_ct', 'nom_ct', 'ind_balance')->get(); //se necesita siempre ind_balance para la condicion




            // dd($ct_info);
            //COMPROBAR DESPUES LAS QUE NO VAN A INFORMACIONCT Y BORRARLAS
            $resultadosQ1 = $this->consultaUno($id_ct, $connection);
            $resultadosQ2 = $this->consultaDos($id_ct, $connection);
            $resultadosQ4 = $this->consultaCuatro($id_ct, $connection);
            $resultadosQ5 = $this->consultaCinco($id_ct, $connection);
            $resultadosQ17 = $this->consultaDiecisiete($id_ct, $connection);
            $resultadosQ28 = $this->consultaVeintiOcho($request, $id_ct, $connection);
            $resultadosQ29 = $this->consultaVeintiNueve($request, $id_ct, $connection);
            $resultadosQ30 = $this->consultaTreinta($request, $id_ct, $connection);
            $resultadosQ31 = $this->consultaTreintayUno($request, $id_ct, $connection);
            $resultadosQ32 = $this->consultaTreintayDos($id_ct, $connection, $request);
            $resultadosQ50 = $this->consultaCincuenta($id_ct, $connection, $request);












            $cups_info = $this->getCupsInfo($request, $id_ct, $connection);




            // Pasar los datos de los CTs a la vista
            return view('ct/informacionct', [
                'ct_info' => $ct_info,
                'resultadosQ1' => $resultadosQ1,
                'resultadosQ2' => $resultadosQ2,
                'resultadosQ4' => $resultadosQ4,
                'resultadosQ5' => $resultadosQ5,
                'resultadosQ17' => $resultadosQ17,
                'resultadosQ28' => $resultadosQ28,
                'resultadosQ29' => $resultadosQ29,
                'resultadosQ30' => $resultadosQ30,
                'resultadosQ31' => $resultadosQ31,
                'resultadosQ32' => $resultadosQ32,
                'resultadosQ50' => $resultadosQ50,
                'id_ct' => $id_ct,
                'cups_info' => $cups_info,
                'selected_ct' => $id_ct,
            ]);
        }
    }




    private function getCupsInfo(Request $request, $id_ct, $connection)
    {
        try {
            if ($id_ct && Schema::connection($connection)->hasTable('t_cups')) {
                // Obtener las fechas de inicio y fin del request
                $fecha_inicio = $request->input('fecha_inicio');
                $fecha_fin = $request->input('fecha_fin');




                // Construir la consulta principal
                $cups_info = Cups::on($connection)
                    ->where('id_ct', $id_ct)
                    ->with(['estadisticasContadores' => function ($query) use ($fecha_inicio, $fecha_fin) {
                        // Filtrar estadísticas de contadores por fechas si están presentes
                        if ($fecha_inicio && $fecha_fin) {
                            $query->whereBetween('fec_fin', [$fecha_inicio, $fecha_fin]);
                        }
                        $query->select('id_cups', 'id_cnt', 'fec_fin', 'por_minutos_contador');
                    }])
                    ->join('core.t_contadores', 'core.t_cups.id_cnt', '=', 'core.t_contadores.id_cnt')
                    ->join('core.t_modelos_contadores', 'core.t_contadores.mod_cnt', '=', 'core.t_modelos_contadores.mod_cnt')
                    ->where(function ($query) {
                        $query->where('t_modelos_contadores.num_fases', '1F')
                            ->orWhere('t_modelos_contadores.num_fases', '3F');
                    }) // Condición para el número de fases
                    ->get();




                return $cups_info;
            } else {
                return collect(); // Retornar una colección vacía si no hay ID de CT válido
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return collect(); // Retornar una colección vacía en caso de excepción
        }
    }








    public function senialplc(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }




        $id_ct = $request->input('id_ct');




        // Guardar el id_ct en la sesión
        Session::put('id_ct', $id_ct);
        // dd(session('id_ct'));




        // Guardar el nombre de la vista actual en la sesión
        Session::put('vista_actual', 'señalplc');




        // Obtener la conexión dinámica
        $connection = User::conexion();








        if ($connection == 'pgsql') {
            // Si la conexión es la predeterminada, retornar un mensaje de bienvenida para el admin
            return view('admin/admin');
        } else {
            // Obtener los datos de todos los CTs
            $ct_info = Ct::on($connection)->select('id_ct', 'nom_ct', 'ind_balance')->get(); //se necesita siempre ind_balance para la condicion
            $resultadosQ2 = $this->consultaDos($id_ct, $connection);
            $resultadosQ6 = $this->consultaSeis($id_ct, $connection);
            $resultadosQ3 = $this->consultaTres($id_ct, $connection);
            $resultadosQ7 = $this->consultaSiete($id_ct, $connection);
            $resultadosQ13 = $this->consultaTrece($id_ct, $connection);
            $resultadosQ14 = $this->consultaCatorce($id_ct, $connection);
            $resultadosQ20 = $this->consultaVeinte($id_ct, $connection);
            $resultadosQ21 = $this->consultaVeintiuno($id_ct, $connection);
            $resultadosQ22 = $this->consultaVeintidos($id_ct, $connection);








            // Pasar los datos de los CTs a la vista
            return view('ct/señalplc', [
                'ct_info' => $ct_info,
                'id_ct' => $id_ct,
                'resultadosQ2' => $resultadosQ2,
                'resultadosQ6' => $resultadosQ6,
                'resultadosQ3' => $resultadosQ3,
                'resultadosQ7' => $resultadosQ7,
                'resultadosQ13' => $resultadosQ13,
                'resultadosQ14' => $resultadosQ14,
                'resultadosQ20' => $resultadosQ20,
                'resultadosQ21' => $resultadosQ21,
                'resultadosQ22' => $resultadosQ22,
                'selected_ct' => $id_ct,
            ]);
        }
    }




    public function energia(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }




        $id_ct = $request->input('id_ct');




        // Guardar el id_ct en la sesión
        Session::put('id_ct', $id_ct);
        // dd(session('id_ct'));




        // Guardar el nombre de la vista actual en la sesión
        Session::put('vista_actual', 'energia');




        // Obtener la conexión dinámica
        $connection = User::conexion();




        if ($connection == 'pgsql') {
            // Si la conexión es la predeterminada, retornar un mensaje de bienvenida para el admin
            return view('admin/admin');
        } else {
            // Obtener los datos de todos los CTs
            $ct_info = Ct::on($connection)->select('id_ct', 'nom_ct', 'ind_balance')->get(); //se necesita siempre ind_balance para la condicion




            $resultadosQ6 = $this->consultaSeis($id_ct, $connection);
            $resultadosQ8 = $this->consultaOcho($id_ct, $connection);
            $resultadosQ9 = $this->consultaNueve($id_ct, $connection);
            $resultadosQ10 = $this->consultaDiez($id_ct, $connection);
            $resultadosQ11 = $this->consultaOnce($id_ct, $connection);
            $resultadosQ12 = $this->consultaDoce($id_ct, $connection);
            $resultadosQ15 = $this->consultaQuince($id_ct, $connection, $request);
            $resultadosQ16 = $this->consultaDieciseis($id_ct, $connection, $request);
            $resultadosQ18 = $this->consultaDieciocho($id_ct, $connection);
            $resultadosQ19 = $this->consultaDiecinueve($id_ct, $connection);
            $resultadosQ47 = $this->consultaCuarentaySiete($id_ct, $connection, $request);








            // Pasar los datos de los CTs a la vista
            return view('ct/energia', [
                'ct_info' => $ct_info,
                'resultadosQ6' => $resultadosQ6,
                'resultadosQ8' => $resultadosQ8,
                'resultadosQ9' => $resultadosQ9,
                'resultadosQ10' => $resultadosQ10,
                'resultadosQ11' => $resultadosQ11,
                'resultadosQ12' => $resultadosQ12,
                'resultadosQ15' => $resultadosQ15,
                'resultadosQ16' => $resultadosQ16,
                'resultadosQ18' => $resultadosQ18,
                'resultadosQ19' => $resultadosQ19,
                'resultadosQ47' => $resultadosQ47,
                'selected_ct' => $id_ct,
                'id_ct' => $id_ct,
            ]);
        }
    }




    public function eventosct(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }




        $id_ct = $request->input('id_ct');




        // Guardar el id_ct en la sesión
        Session::put('id_ct', $id_ct);
        // dd(session('id_ct'));




        // Guardar el nombre de la vista actual en la sesión
        Session::put('vista_actual', 'eventosct');




        // Obtener la conexión dinámica
        $connection = User::conexion();




        if ($connection == 'pgsql') {
            // Si la conexión es la predeterminada, retornar un mensaje de bienvenida para el admin
            return view('admin/admin');
        } else {
            // Obtener los datos de todos los CTs
            $ct_info = Ct::on($connection)->select('id_ct', 'nom_ct', 'ind_balance')->get(); //se necesita siempre ind_balance para la condicion




            $resultadosQ23 = $this->consultaVeintitres($id_ct, $connection, $request);
            $resultadosQ24 = $this->consultaVeintiCuatro($id_ct, $connection);




            // Pasar los datos de los CTs a la vista
            return view('ct/eventosct', [
                'ct_info' => $ct_info,
                'resultadosQ23' => $resultadosQ23,
                'resultadosQ24' => $resultadosQ24,
                'selected_ct' => $id_ct,
                'id_ct' => $id_ct,
            ]);
        }
    }




    public function balances(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }




        $id_ct = $request->input('id_ct');




        // Guardar el id_ct en la sesión
        Session::put('id_ct', $id_ct);
        // dd(session('id_ct'));




        // Guardar el nombre de la vista actual en la sesión
        Session::put('vista_actual', 'balances');




        // Obtener la conexión dinámica
        $connection = User::conexion();




        if ($connection == 'pgsql') {
            // Si la conexión es la predeterminada, retornar un mensaje de bienvenida para el admin
            return view('admin/admin');
        } else {
            // Obtener los datos de todos los CTs
            $ct_info = Ct::on($connection)->select('id_ct', 'nom_ct', 'ind_balance')->get(); //se necesita siempre ind_balance para la condicion



            $resultadosQ25 = $this->consultaVeintiCinco($id_ct, $connection, $request);
            $resultadosQ2 = $this->consultaDos($id_ct, $connection);
            $resultadosQ26 = $this->consultaVeintiSeis($id_ct, $connection, $request);
            $fecha = !empty($resultadosQ26[0]->fecha) ? $resultadosQ26[0]->fecha : null;
            $resultadosQ27 = $this->consultaVeintiSiete($id_ct, $connection, $request);
            $sumBalances = $this->getSumBalances($id_ct, $request, $connection);
            $exportSumBalances = $this->exportSumBalances($request);






            // Pasar los datos de los CTs a la vista
            return view('ct/balances', [
                'ct_info' => $ct_info,
                'resultadosQ25' => $resultadosQ25,
                'resultadosQ26' => $resultadosQ26,
                'resultadosQ2' => $resultadosQ2,
                'resultadosQ27' => $resultadosQ27,
                'selected_ct' => $id_ct,
                'id_ct' => $id_ct,
                'sumBalances' => $sumBalances,
                'exportSumBalances' => $exportSumBalances,
            ]);
        }
    }












    // Reportes 
    public function reportes(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }




        // Guardar el nombre de la vista actual en la sesión
        Session::put('vista_actual', 'reportes');




        // Obtener la conexión dinámica
        $connection = User::conexion();




        if ($connection == 'pgsql') {
            // Si la conexión es la predeterminada, retornar un mensaje de bienvenida para el admin
            return view('admin/admin');
        } else {
            // Obtener los datos de todos los CTs
            $ct_info = Ct::on($connection)->select('id_ct', 'nom_ct', 'ind_balance')->get(); //se necesita siempre ind_balance para la condicion




            // dd($ct_info);




            $resultadosQ33 = $this->consultaTreintayTres($connection);
            $resultadosQ34 = $this->consultaTreintayCuatro($connection);
            $resultadosQ35 = $this->consultaTreintayCinco($connection);
            $resultadosQ36 = $this->consultaTreintaySeis($connection);




            // Pasar los datos de los CTs a la vista
            return view('ct/reportes', [
                'ct_info' => $ct_info,
                'resultadosQ33' => $resultadosQ33,
                'resultadosQ34' => $resultadosQ34,
                'resultadosQ35' => $resultadosQ35,
                'resultadosQ36' => $resultadosQ36,
            ]);
        }
    }




    public function reportescalidad(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }




        // Guardar el nombre de la vista actual en la sesión
        Session::put('vista_actual', 'reportescalidad');




        // Obtener la conexión dinámica
        $connection = User::conexion();




        if ($connection == 'pgsql') {
            // Si la conexión es PostgreSQL, retornar una vista específica para admin
            return view('admin/admin');
        } else {
            // Obtener los datos de todos los CTs
            $ct_info = Ct::on($connection)->select('id_ct', 'nom_ct', 'ind_balance')->get();




            // Obtener resultados de las consultas
            $resultadosQ37 = $this->consultaTreintaySiete($request, $connection);
            $resultadosQ38 = $this->consultaTreintayOcho($request, $connection);
            $resultadosQ39 = $this->consultaTreintayNueve($request, $connection);
            $resultadosQ40 = $this->consultaCuarenta($request, $connection);
            $resultadosQ41 = $this->consultaCuarentayUno($request, $connection);
            $resultadosQ42 = $this->consultaCuarentayDos($request, $connection);
            $resultadosQ43 = $this->consultaCuarentayTres($request, $connection);
            $resultadosQ44 = $this->consultaCuarentayCuatro($request, $connection);
            $resultadosQ45 = $this->consultaCuarentayCinco($request, $connection);
            $resultadosQ46 = $this->consultaCuarentaySeis($request, $connection);
            $resultadosQ48 = $this->consultaCuarentayOcho($request, $connection);
            $resultadosQ49 = $this->consultaCuarentayNueve($request, $connection);
            $resultadosQ51 = $this->consultaCincuentayUno($request, $connection);








            // Pasar los datos de los CTs y los resultados de las consultas a la vista
            return view('ct/reportescalidad', [
                'ct_info' => $ct_info,
                'resultadosQ37' => $resultadosQ37,
                'resultadosQ38' => $resultadosQ38,
                'resultadosQ39' => $resultadosQ39,
                'resultadosQ40' => $resultadosQ40,
                'resultadosQ41' => $resultadosQ41,
                'resultadosQ42' => $resultadosQ42,
                'resultadosQ43' => $resultadosQ43,
                'resultadosQ44' => $resultadosQ44,
                'resultadosQ45' => $resultadosQ45,
                'resultadosQ46' => $resultadosQ46,
                'resultadosQ48' => $resultadosQ48,
                'resultadosQ49' => $resultadosQ49,
                'resultadosQ51' => $resultadosQ51,




            ]);
        }
    }

    public function reportesinventario(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }




        // Guardar el nombre de la vista actual en la sesión
        Session::put('vista_actual', 'reportesinventario');




        // Obtener la conexión dinámica
        $connection = User::conexion();




        if ($connection == 'pgsql') {
            // Si la conexión es la predeterminada, retornar un mensaje de bienvenida para el admin
            return view('admin/admin');
        } else {
            // Obtener los datos de todos los CTs
            $ct_info = Ct::on($connection)->select('id_ct', 'nom_ct', 'ind_balance')->get(); //se necesita siempre ind_balance para la condicion




            // dd($ct_info);




            $resultadosQ52 = $this->consultaCincuentayDos($connection);
            $resultadosQ53 = $this->consultaCincuentayTres($connection);
            $resultadosQ54 = $this->consultaCincuentayCuatro($connection);
            $resultadosQ55 = $this->consultaCincuentayCinco($connection);
            $resultadosQ56 = $this->consultaCincuentaySeis($connection);
            $resultadosQ57 = $this->consultaCincuentaySiete($connection);



            // Pasar los datos de los CTs a la vista
            return view('ct/reportesinventario', [
                'ct_info' => $ct_info,
                'resultadosQ52' => $resultadosQ52,
                'resultadosQ53' => $resultadosQ53,
                'resultadosQ54' => $resultadosQ54,
                'resultadosQ55' => $resultadosQ55,
                'resultadosQ56' => $resultadosQ56,
                'resultadosQ57' => $resultadosQ57,


            ]);
        }
    }

    public function reportescurvashorarias(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }

        // Guardar el nombre de la vista actual en la sesión
        Session::put('vista_actual', 'reportescurvashorarias');

        // Obtener la conexión dinámica
        $connection = User::conexion();


        if ($connection == 'pgsql') {
            // Si la conexión es PostgreSQL, retornar una vista específica para admin
            return view('admin/admin');
        } else {
            // Obtener los datos de todos los CTs
            $ct_info = Ct::on($connection)->select('id_ct', 'nom_ct', 'ind_balance')->get();

            // Obtener resultados de las consultas
            $resultadosQ58 = $this->consultaCincuentayOcho($request, $connection);
            $exportCurvasHorarias = $this->exportCurvasHorarias($request, $connection);


            // Pasar los datos de los CTs y los resultados de las consultas a la vista
            return view('ct/reportescurvashorarias', [
                'ct_info' => $ct_info,
                'resultadosQ58' => $resultadosQ58,
                'exportCurvasHorarias' => $exportCurvasHorarias,
            ]);
        }
    }

    public function reporteseventos(Request $request) {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }




        // Guardar el nombre de la vista actual en la sesión
        Session::put('vista_actual', 'reporteseventos');




        // Obtener la conexión dinámica
        $connection = User::conexion();




        if ($connection == 'pgsql') {
            // Si la conexión es PostgreSQL, retornar una vista específica para admin
            return view('admin/admin');
        } else {
            // Obtener los datos de todos los CTs
            $ct_info = Ct::on($connection)->select('id_ct', 'nom_ct', 'ind_balance')->get();

            $reporteseventos = $this->getAllReportesEventos($request, $connection);
            $numeroeventos = $this->getNumEventos($request, $connection);
            //$eventosByDescription = $this-> getEventosByDescription($request, $connection);

            // Pasar los datos de los CTs y los resultados de las consultas a la vista
            return view('reportes/reporteseventos', [
                'ct_info' => $ct_info,
                'reporteseventos' => $reporteseventos,
                'numeroeventos' => $numeroeventos,
                //'eventosByDescription'=> $eventosByDescription,

            ]);
    }
}


    //CONSULTAS -------------------------------------------
    public function consultaUno($id_ct, $connection)
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_ct') &&
                Schema::connection($connection)->hasTable('t_concentradores') &&
                Schema::connection($connection)->hasTable('t_supervisores') &&
                Schema::connection($connection)->hasTable('t_trafos')
            ) {
                $resultadosQ1 = DB::connection($connection)
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


                return $resultadosQ1 ?: ['message' => 'No hay datos'];
            } else {
                // La tabla no existe, retornar un mensaje específico 
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }




    public function consultaDos($id_ct, $connection)
    {
        try {
            if (Schema::connection($connection)->hasTable('t_cups')) {
                $resultadosQ2 = DB::connection($connection)
                    ->select('
                    SELECT count(*) as nro_cups
                    FROM core.t_cups
                    WHERE t_cups.id_ct = :id_ct;
                ', ['id_ct' => $id_ct]);




                return empty($resultadosQ2) ? [['nro_cups' => 0]] : $resultadosQ2;
            } else {
                // La tabla no existe, retornar un mensaje específico 
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }








    public function consultaTres($id_ct, $connection)
    {
        if ($id_ct) {
            try {
                // Realiza la consulta
                $resultadosQ3 = DB::connection($connection)
                    ->select("
                        SELECT count(*) as contadores_sin_lectura_7_dias
                        FROM core.v_contadores_no_leidos_7_dias, core.t_cups
                        WHERE core.v_contadores_no_leidos_7_dias.id_cnt = t_cups.id_cnt
                        AND t_cups.id_ct = :id_ct;
                    ", ['id_ct' => $id_ct]);




                // Verifica si hay resultados
                return empty($resultadosQ3) ? [['contadores_sin_lectura_7_dias' => 0]] : $resultadosQ3;
            } catch (\Exception $e) {
                // Captura cualquier excepción y maneja el error aquí
                return "Error en la consulta: " . $e->getMessage();
            }
        } else {
            return "ID de concentrador no proporcionado";
        }
    }












    public function consultaCuatro($id_ct, $connection)
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_cups') &&
                Schema::connection($connection)->hasTable('t_ct')
            ) {
                $resultadosQ4 = DB::connection($connection)
                    ->select("
                        SELECT count(*) as nro_autoconsumos
                        FROM core.t_cups, core.t_ct
                        WHERE 
                        t_cups.ind_autoconsumo = 'S' AND
                        t_cups.id_ct = t_ct.id_ct AND
                        t_cups.id_ct = :id_ct;
                    ", ['id_ct' => $id_ct]);




                return empty($resultadosQ4) ? [['nro_autoconsumos' => 0]] : $resultadosQ4;
            } else {
                // Una de las tablas no existe, retornar un mensaje específico 
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }








    public function consultaCinco($id_ct, $connection)
    {
        try {
            if (Schema::connection($connection)->hasTable('t_lineas')) {
                $resultadosQ5 = DB::connection($connection)
                    ->select("
                        SELECT count(id_linea) as nro_lineas
                        FROM core.t_lineas
                        WHERE t_lineas.id_trafo = id_trafo
                        AND t_lineas.id_ct = :id_ct;
                    ", ['id_ct' => $id_ct]);




                return empty($resultadosQ5) ? [['nro_lineas' => 0]] : $resultadosQ5;
            } else {
                // La tabla no existe, retornar un mensaje específico 
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }








    public function consultaSeis($id_ct, $connection)
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_indices_lectura') &&
                Schema::connection($connection)->hasTable('t_cups') &&
                Schema::connection($connection)->hasTable('t_supervisores')
            ) {
                $resultadosQ6 = DB::connection($connection)
                    ->select("
                    SELECT  
                        t_cups.id_ct,
                        t_indices_lectura.fec_lectura,
                        COUNT(CASE WHEN t_indices_lectura.ind_s02 = 'S' THEN 1 END) AS lect_s02,
                        COUNT(CASE WHEN t_indices_lectura.ind_s04 = 'S' THEN 1 END) AS lect_s04,  
                        COUNT(CASE WHEN t_indices_lectura.ind_s05 = 'S' THEN 1 END) AS lect_s05
                    FROM 
                        core.t_indices_lectura,
                        core.t_cups
                    WHERE  
                        t_indices_lectura.id_cnt = t_cups.id_cnt
                        AND t_indices_lectura.id_cnt IN (SELECT id_cnt FROM core.t_cups WHERE cups_estado = 'A' AND ind_repetidor = 'N')
                        AND t_indices_lectura.id_cnt NOT IN (SELECT id_svr FROM core.t_supervisores)
                        AND t_indices_lectura.fec_lectura >= (SELECT MAX(fec_lectura) FROM core.t_indices_lectura) 
                        AND t_cups.id_ct = :id_ct
                    GROUP BY 
                        t_cups.id_ct, t_indices_lectura.fec_lectura;
                ", ['id_ct' => $id_ct]);




                return $resultadosQ6 ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico 
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }





    public function consultaSiete($id_ct, $connection)
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_g02_estadisticas_contadores') &&
                Schema::connection($connection)->hasTable('t_cups')
            ) {
                $resultadosQ7 = DB::connection($connection)
                    ->select("
                        SELECT count(*) as disponibilidad_menos_30
                        FROM core.t_g02_estadisticas_contadores, core.t_cups
                        WHERE 
                            core.t_g02_estadisticas_contadores.por_minutos_contador < 30 AND
                            core.t_g02_estadisticas_contadores.fec_fin = (SELECT MAX(fec_fin) FROM core.t_g02_estadisticas_contadores) AND
                            core.t_g02_estadisticas_contadores.id_cnt = t_cups.id_cnt AND
                            t_cups.id_ct = :id_ct;
                    ", ['id_ct' => $id_ct]);




                return $resultadosQ7 ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico 
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }








    public function consultaOcho($id_ct, $connection) //microcortes
    {
        if ($id_ct) {
            $resultadosQ8 = DB::connection($connection)
                ->select("
                SELECT t_cups.id_ct, count(v_micro_cortes.id_cups) AS micro_cortes_tension
                FROM core.t_cups
                JOIN core.v_micro_cortes ON v_micro_cortes.id_cups = t_cups.id_cups
                WHERE t_cups.cups_estado = 'A'
                AND t_cups.ind_repetidor = 'N'
                AND t_cups.id_ct = :id_ct
                AND v_micro_cortes.fec_evento >= DATE_TRUNC('month', CURRENT_DATE)
                AND v_micro_cortes.fec_evento < DATE_TRUNC('month', CURRENT_DATE) + INTERVAL '1 month'
                GROUP BY t_cups.id_ct;




                    ", ['id_ct' => $id_ct]);
            return $resultadosQ8 ?: [];
        }
    }




    public function consultaNueve($id_ct, $connection) //subtensiones
    {
        if ($id_ct) {
            $resultadosQ9 = DB::connection($connection)
                ->select("
                SELECT t_cups.id_ct,count(v_sub_voltajes.id_cups) AS sub_tensiones
                FROM core.t_cups
                JOIN core.v_sub_voltajes ON v_sub_voltajes.id_cups = t_cups.id_cups
                WHERE t_cups.cups_estado = 'A'
                AND t_cups.ind_repetidor = 'N'
                AND t_cups.id_ct = :id_ct
                AND v_sub_voltajes.fec_evento >= DATE_TRUNC('month', CURRENT_DATE)
                AND v_sub_voltajes.fec_evento < DATE_TRUNC('month', CURRENT_DATE) + INTERVAL '1 month'
                GROUP BY t_cups.id_ct;
                    ", ['id_ct' => $id_ct]);
            return $resultadosQ9 ?: [];
        }
    }




    public function consultaDiez($id_ct, $connection) //cortes de tension 
    {
        if ($id_ct) {
            $resultadosQ10 = DB::connection($connection)
                ->select("
                SELECT t_cups.id_ct, count(v_apagones.id_cups) AS cortes_tension
                FROM core.t_cups
                JOIN core.v_apagones ON v_apagones.id_cups = t_cups.id_cups
                WHERE t_cups.cups_estado = 'A'
                AND t_cups.ind_repetidor = 'N'
                AND t_cups.id_ct = :id_ct
                AND v_apagones.fec_evento >= DATE_TRUNC('month', CURRENT_DATE)
                AND v_apagones.fec_evento < DATE_TRUNC('month', CURRENT_DATE) + INTERVAL '1 month'
                GROUP BY t_cups.id_ct;




                    ", ['id_ct' => $id_ct]);
            return $resultadosQ10 ?: [];
        }
    }




    public function consultaOnce($id_ct, $connection) //sobretensiones
    {
        if ($id_ct) {
            $resultadosQ11 = DB::connection($connection)
                ->select("
                    SELECT t_cups.id_ct,count(v_sobre_voltajes.id_cups) AS sobre_tensiones
                    FROM core.t_cups
                    JOIN core.v_sobre_voltajes ON v_sobre_voltajes.id_cups = t_cups.id_cups
                    WHERE t_cups.cups_estado = 'A'
                    AND t_cups.ind_repetidor = 'N'
                    AND t_cups.id_ct = :id_ct
                    AND v_sobre_voltajes.fec_evento >= DATE_TRUNC('month', CURRENT_DATE)
                    AND v_sobre_voltajes.fec_evento < DATE_TRUNC('month', CURRENT_DATE) + INTERVAL '1 month'
                    GROUP BY t_cups.id_ct;
                    ", ['id_ct' => $id_ct]);
            return $resultadosQ11 ?: [];
        }
    }




    public function consultaDoce($id_ct, $connection)
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_consumos_diarios') &&
                Schema::connection($connection)->hasTable('t_cups') &&
                Schema::connection($connection)->hasTable('t_ct') &&
                Schema::connection($connection)->hasTable('t_supervisores') &&
                Schema::connection($connection)->hasTable('t_trafos')
            ) {
                $resultadosQ12 = DB::connection($connection)
                    ->select("
                    SELECT 
                        t_consumos_diarios.fec_inicio AS fecha_energia, 
                        t_supervisores.id_svr,
                        SUM(t_consumos_diarios.val_ai_d) AS energia_importada_total, 
                        SUM(t_consumos_diarios.val_ae_d) AS energia_generada_total
                    FROM
                        core.t_consumos_diarios,
                        core.t_cups,
                        core.t_ct,
                        core.t_supervisores,
                        core.t_trafos
                    WHERE
                        t_cups.id_cnt = t_consumos_diarios.id_cnt AND
                        t_cups.id_ct = t_ct.id_ct AND
                        t_cups.id_trafo = t_trafos.id_trafo AND
                        t_trafos.id_svr = t_supervisores.id_svr AND
                        t_ct.id_ct = :id_ct AND
                        t_consumos_diarios.fec_inicio >= (SELECT MAX(fec_inicio) FROM core.t_consumos_diarios) - INTERVAL '6 days'
                    GROUP BY
                        t_consumos_diarios.fec_inicio,
                        t_supervisores.id_svr
                    ORDER BY t_consumos_diarios.fec_inicio ASC;
                ", ['id_ct' => $id_ct]);




                return $resultadosQ12 ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico 
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }








    public function consultaTrece($id_ct, $connection)
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_g01_estadisticas_comunicaciones') &&
                Schema::connection($connection)->hasTable('t_concentradores') &&
                Schema::connection($connection)->hasTable('t_cups')
            ) {
                $resultadosQ13 = DB::connection($connection)
                    ->select("
                    SELECT DISTINCT estadisticas.id_cnc, 
                        estadisticas.fec_estadistica, 
                        estadisticas.hor_estadistica, 
                        estadisticas.por_conta,
                        concentradores.id_cnc AS nombre_concentrador
                    FROM core.t_g01_estadisticas_comunicaciones AS estadisticas
                    JOIN core.t_concentradores AS concentradores ON estadisticas.id_cnc = concentradores.id_cnc
                    JOIN core.t_cups AS cups ON cups.id_ct = concentradores.id_ct
                    WHERE cups.id_ct = :id_ct
                    AND (estadisticas.fec_estadistica || ' ' || estadisticas.hor_estadistica)::timestamp >= 
                        (SELECT MAX((fec_estadistica || ' ' || hor_estadistica)::timestamp) FROM core.t_g01_estadisticas_comunicaciones)
                        - INTERVAL '23 hours' 
                    ORDER BY estadisticas.fec_estadistica DESC, estadisticas.hor_estadistica DESC;
                ", ['id_ct' => $id_ct]);




                return $resultadosQ13 ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico 
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }








    public function consultaCatorce($id_ct, $connection)
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_g01_estadisticas_comunicaciones') &&
                Schema::connection($connection)->hasTable('t_concentradores') &&
                Schema::connection($connection)->hasTable('t_cups')
            ) {
                $resultadosQ14 = DB::connection($connection)
                    ->select("
                    SELECT DISTINCT estadisticas.id_cnc, 
                        estadisticas.fec_estadistica, 
                        estadisticas.hor_estadistica, 
                        estadisticas.por_conta,
                        concentradores.id_cnc AS nombre_concentrador
                    FROM core.t_g01_estadisticas_comunicaciones AS estadisticas
                    JOIN core.t_concentradores AS concentradores ON estadisticas.id_cnc = concentradores.id_cnc
                    JOIN core.t_cups AS cups ON cups.id_ct = concentradores.id_ct
                    WHERE cups.id_ct = :id_ct
                    AND (estadisticas.fec_estadistica || ' ' || estadisticas.hor_estadistica)::timestamp >= 
                        (SELECT MAX((fec_estadistica || ' ' || hor_estadistica)::timestamp) FROM core.t_g01_estadisticas_comunicaciones)
                        - INTERVAL '47 hours' 
                    ORDER BY estadisticas.fec_estadistica ASC, estadisticas.hor_estadistica DESC;
                ", ['id_ct' => $id_ct]);




                return $resultadosQ14 ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico 
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }








    // public function consultaQuince($id_ct, $connection)
    // {
    //     if ($id_ct) {
    //         try {
    //             // Realiza la consulta filtrando por el id_ct seleccionado
    //             $resultadosQ15 = DB::connection($connection)
    //                 ->select("SELECT * FROM core.v_valores_supervisor_7_dias WHERE id_cnc = (
    //                     SELECT t_concentradores.id_cnc FROM core.t_ct
    //                     JOIN core.t_concentradores ON core.t_ct.id_ct = core.t_concentradores.id_ct
    //                     WHERE core.t_ct.id_ct = :id_ct
    //                 )", ['id_ct' => $id_ct]);




    //             // Verifica si hay resultados
    //             if (count($resultadosQ15) > 0) {
    //                 return $resultadosQ15;
    //             } else {
    //                 return "No hay datos";
    //             }
    //         } catch (\Exception $e) {
    //             // Captura cualquier excepción y maneja el error aquí
    //             // Puedes agregar un mensaje de error específico si lo deseas
    //             return "Error en la consulta: " . $e->getMessage();
    //         }
    //     }
    // }




    public function consultaQuince($id_ct, $connection, Request $request)
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_supervisores_voltajes') &&
                Schema::connection($connection)->hasTable('t_concentradores')
            ) {
                // Obtener las fechas de inicio y fin de los parámetros de la solicitud
                $fecha_inicio = $request->input('fecha_inicio');
                $fecha_fin = $request->input('fecha_fin');




                // Consulta base
                $query = "
                    SELECT 
                        t_supervisores_voltajes.id_cnc,
                        t_concentradores.id_ct,
                        t_supervisores_voltajes.id_svr,
                        MIN(t_supervisores_voltajes.val_voltaje_1) AS min_volt1,
                        MAX(t_supervisores_voltajes.val_voltaje_1) AS max_volt_1,
                        CEIL(AVG(t_supervisores_voltajes.val_voltaje_1)) AS prom_volt1,
                        MIN(t_supervisores_voltajes.val_voltaje_2) AS min_volt2,
                        MAX(t_supervisores_voltajes.val_voltaje_2) AS max_volt_2,
                        CEIL(AVG(t_supervisores_voltajes.val_voltaje_2)) AS prom_volt2,
                        MIN(t_supervisores_voltajes.val_voltaje_3) AS min_volt3,
                        MAX(t_supervisores_voltajes.val_voltaje_3) AS max_volt_3,
                        CEIL(AVG(t_supervisores_voltajes.val_voltaje_3)) AS prom_volt3
                    FROM 
                        core.t_supervisores_voltajes 
                    JOIN 
                        core.t_concentradores ON core.t_supervisores_voltajes.id_cnc = core.t_concentradores.id_cnc
                    WHERE 
                        core.t_concentradores.id_ct = :id_ct 
                ";




                // Condición y parámetros para el filtro de fechas si están presentes
                if ($fecha_inicio && $fecha_fin) {
                    $query .= "
                        AND core.t_supervisores_voltajes.fec_registro BETWEEN :fecha_inicio AND :fecha_fin
                    ";
                    $params = ['id_ct' => $id_ct, 'fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin];
                } else {
                    // Condición y parámetros para mostrar los datos de las últimas 47 horas
                    $query .= "
                        AND core.t_supervisores_voltajes.fec_registro >= (
                            SELECT MAX(core.t_supervisores_voltajes.fec_registro) 
                            FROM core.t_supervisores_voltajes
                        ) - INTERVAL '48 hours'
                    ";
                    $params = ['id_ct' => $id_ct];
                }




                // Agregar el ordenamiento
                $query .= " GROUP BY 
                            t_supervisores_voltajes.id_cnc, 
                            t_supervisores_voltajes.id_svr, 
                            t_concentradores.id_ct;";




                // Ejecutar la consulta con los parámetros adecuados
                $resultadosQ15 = DB::connection($connection)->select($query, $params);
                // dd($resultadosQ15);




                return $resultadosQ15 ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico 
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }








    public function consultaDieciseis($id_ct, $connection, Request $request)
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_supervisores_voltajes') &&
                Schema::connection($connection)->hasTable('t_concentradores')
            ) {
                // Obtener las fechas de inicio y fin de los parámetros de la solicitud
                $fecha_inicio = $request->input('fecha_inicio');
                $fecha_fin = $request->input('fecha_fin');




                // Consulta base
                $query = "
                SELECT 
                    TO_CHAR(core.t_supervisores_voltajes.fec_registro, 'DD/MM/YYYY') as fec_registro,
                    core.t_supervisores_voltajes.hor_registro, 
                    core.t_supervisores_voltajes.val_voltaje_1, 
                    core.t_supervisores_voltajes.val_voltaje_2, 
                    core.t_supervisores_voltajes.val_voltaje_3,
                    core.t_concentradores.id_ct
                FROM 
                    core.t_supervisores_voltajes
                JOIN 
                    core.t_concentradores ON core.t_supervisores_voltajes.id_cnc = core.t_concentradores.id_cnc
                WHERE 
                    core.t_concentradores.id_ct = :id_ct 
            ";




                // Condición y parámetros para el filtro de fechas si están presentes
                if ($fecha_inicio && $fecha_fin) {
                    $query .= "
                    AND core.t_supervisores_voltajes.fec_registro BETWEEN :fecha_inicio AND :fecha_fin
                ";
                    $params = ['id_ct' => $id_ct, 'fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin];
                } else {
                    // Condición y parámetros para mostrar los datos de las últimas 47 horas
                    $query .= "
                    AND core.t_supervisores_voltajes.fec_registro >= (
                        SELECT MAX(core.t_supervisores_voltajes.fec_registro) 
                        FROM core.t_supervisores_voltajes
                    ) - INTERVAL '48 hours'
                ";
                    $params = ['id_ct' => $id_ct];
                }




                // Agregar el ordenamiento
                $query .= " ORDER BY core.t_supervisores_voltajes.fec_registro ASC";




                // Ejecutar la consulta con los parámetros adecuados
                $resultadosQ16 = DB::connection($connection)->select($query, $params);
                // dd($resultadosQ16);




                return $resultadosQ16 ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico 
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }












    public function consultaDiecisiete($id_ct, $connection)
    {
        if ($id_ct) {
            // Verificar si la tabla existe
            if (Schema::connection($connection)->hasTable('t_hw_comunicaciones')) {
                // La tabla existe, ejecutar la consulta
                $resultadosQ17 = DB::connection($connection)
                    ->select("
                    SELECT * FROM core.t_hw_comunicaciones
                    WHERE id_ct = :id_ct
                    ", ['id_ct' => $id_ct]);
                return $resultadosQ17 ?: [];
            } else {
                // La tabla no existe, retornar un array vacío 
                return [];
            }
        }
    }




    public function consultaDieciocho($id_ct, $connection) //Q15 en el documento
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_supervisores_voltajes') &&
                Schema::connection($connection)->hasTable('t_trafos') &&
                Schema::connection($connection)->hasTable('t_concentradores') &&
                Schema::connection($connection)->hasTable('t_ct')
            ) {








                $resultadosQ18 = DB::connection($connection)
                    ->select("
                        SELECT
                            date_trunc('month', fec_registro) AS mes,
                            avg(((t_supervisores_voltajes.val_kva_t)/1000)*100)/ avg(t_trafos.val_kva) AS cap_instalada,
                            t_ct.id_ct, val_kva
                        FROM
                            core.t_supervisores_voltajes,
                            core.t_trafos,
                            core.t_concentradores,
                            core.t_ct
                        WHERE
                            t_supervisores_voltajes.id_svr = t_trafos.id_svr
                        AND
                            t_concentradores.id_cnc = t_trafos.id_cnc
                        AND
                            t_ct.id_ct = t_concentradores.id_ct
                        AND
                            t_ct.id_ct = :id_ct
                        GROUP BY
                            1, t_ct.id_ct, val_kva
                        ORDER BY
                            1 DESC
                        LIMIT 1;
                    ", ['id_ct' => $id_ct]);








                return $resultadosQ18 ?: ['message' => 'No hay datos'];
            } else {
                // La tabla no existe, retornar un mensaje específico
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }




















    public function consultaDiecinueve($id_ct, $connection)
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_supervisores_voltajes') &&
                Schema::connection($connection)->hasTable('t_trafos') &&
                Schema::connection($connection)->hasTable('t_concentradores') &&
                Schema::connection($connection)->hasTable('t_ct')
            ) {
                $resultadosQ19 = DB::connection($connection)
                    ->select("
                    SELECT date_trunc('month', fec_registro) AS date_trunc_anio,
                        avg(((t_supervisores_voltajes.val_kva_t) / 1000) * 100) / avg(t_trafos.val_kva) AS cap_instalada,
                            t_ct.id_ct
                    FROM core.t_supervisores_voltajes, 
                        core.t_trafos,	
                        core.t_concentradores,
                        core.t_ct
                    WHERE 
                    t_supervisores_voltajes.id_svr = t_trafos.id_svr
                        AND 
                    fec_registro >= date_trunc('month', current_date) - interval '12 months'
                    AND 
                        t_concentradores.id_cnc = t_trafos.id_cnc 
                    AND
                        t_ct.id_ct = t_concentradores.id_ct
                    AND
                        t_ct.id_ct = :id_ct
                    GROUP BY 
                        1, t_ct.id_ct
                    ORDER BY 1
                    ", ['id_ct' => $id_ct]);




                return $resultadosQ19 ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico 
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }








    public function consultaVeinte($id_ct, $connection)
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_g02_estadisticas_contadores') &&
                Schema::connection($connection)->hasTable('t_cups')
            ) {
                $resultadosQ20 = DB::connection($connection)
                    ->select("
                    SELECT t_cups.id_cups, t_cups.nom_cups, t_cups.dir_cups, t_cups.id_ct, t_g02_estadisticas_contadores.por_minutos_contador
                    FROM core.t_g02_estadisticas_contadores, core.t_cups
                    WHERE
                        core.t_g02_estadisticas_contadores.por_minutos_contador < 30 AND
                        core.t_g02_estadisticas_contadores.fec_fin = (SELECT MAX(fec_fin) FROM core.t_g02_estadisticas_contadores) AND
                        core.t_g02_estadisticas_contadores.id_cnt = t_cups.id_cnt AND
                        t_cups.id_ct = :id_ct;
                        ", ['id_ct' => $id_ct]);
                // dd($resultadosQ20);
                return $resultadosQ20 ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico 
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }












    public function consultaVeintiuno($id_ct, $connection) // Tabla con contadores no leídos
    {
        if ($id_ct) {
            try {
                // Realiza la consulta filtrando por el id_ct seleccionado
                $resultadosQ21 = DB::connection($connection)
                    ->select("
                    SELECT DISTINCT ON (t_cups.id_cups)
                        t_cups.id_cups,
                        t_cups.nom_cups,
                        t_cups.dir_cups,
                        t_cups.id_ct
                    FROM core.v_contadores_no_leidos_7_dias
                    JOIN core.t_cups ON core.v_contadores_no_leidos_7_dias.id_cnt = t_cups.id_cnt
                    JOIN core.t_ct ON t_cups.id_ct = core.t_ct.id_ct
                    WHERE t_cups.id_ct = :id_ct;
                        ", ['id_ct' => $id_ct]);




                // Verifica si hay resultados
                return $resultadosQ21 ?: [];
            } catch (\Exception $e) {
                // Captura cualquier excepción y maneja el error aquí
                // Puedes agregar un mensaje de error específico si lo deseas
                return "Error en la consulta: " . $e->getMessage();
            }
        } else {
            return "ID de concentrador no proporcionado";
        }
    }


//CONSULTA 6 PERO PARA LOS ÚLTIMOS 7 DÍAS
public function consultaVeintidos($id_ct, $connection)
{
    try {
        if (
            Schema::connection($connection)->hasTable('t_indices_lectura') &&
            Schema::connection($connection)->hasTable('t_cups') &&
            Schema::connection($connection)->hasTable('t_supervisores')
        ) {
            $resultadosQ22 = DB::connection($connection)
                ->select("
                SELECT  
	                core.t_cups.id_ct,
                    core.t_indices_lectura.fec_lectura,
                    COUNT(CASE WHEN t_indices_lectura.ind_s02 = 'S' THEN 1 END) AS lect_s02,
                    COUNT(CASE WHEN t_indices_lectura.ind_s04 = 'S' THEN 1 END) AS lect_s04,  
                    COUNT(CASE WHEN t_indices_lectura.ind_s05 = 'S' THEN 1 END) AS lect_s05
                FROM 
                    core.t_indices_lectura,
                    core.t_cups
                WHERE  
                    t_indices_lectura.id_cnt = t_cups.id_cnt
                    AND t_indices_lectura.id_cnt IN (SELECT id_cnt FROM core.t_cups WHERE cups_estado = 'A' AND ind_repetidor = 'N')
                    AND t_indices_lectura.id_cnt NOT IN (SELECT id_svr FROM core.t_supervisores)
                    AND t_indices_lectura.fec_lectura >= (SELECT MAX(fec_lectura) FROM core.t_indices_lectura)  - INTERVAL '7 days'
                    AND t_cups.id_ct = :id_ct
                GROUP BY 
                    t_cups.id_ct, t_indices_lectura.fec_lectura						
                    ORDER BY fec_lectura ASC;
            ", ['id_ct' => $id_ct]);



            // dd($resultadosQ22);
            return $resultadosQ22 ?: ['message' => 'No hay datos'];
        } else {
            // Una de las tablas no existe, retornar un mensaje específico 
            return ['message' => 'No hay datos'];
        }
    } catch (\Exception $e) {
        // Manejo de excepciones con mensaje específico
        return ['message' => 'No hay datos'];
    }
}





    public function consultaVeintitres($id_ct, $connection, Request $request)
    {
        try {
            $fecha_inicio = $request->input('fecha_inicio');
            $fecha_fin = $request->input('fecha_fin');

            if ($id_ct) {
                $query = "
                SELECT 
                    t_eventos_concentrador.id_ct, 
                    t_eventos_concentrador.id_cnc, 
                    TO_CHAR(t_eventos_concentrador.fec_evento, 'DD/MM/YYYY') as fecha,
                    t_eventos_concentrador.hor_evento,
                    t_eventos_concentrador.txt_adicionales_1,
                    t_eventos_concentrador.txt_adicionales_2,
                    t_descripcion_eventos_concentrador.des_evento_dc
                FROM core.t_eventos_concentrador, core.t_descripcion_eventos_concentrador
                WHERE t_eventos_concentrador.grp_evento_dc = t_descripcion_eventos_concentrador.grp_evento_dc
                AND t_eventos_concentrador.cod_evento_dc = t_descripcion_eventos_concentrador.cod_evento_dc";




                $params = ['id_ct' => $id_ct];




                if ($fecha_inicio && $fecha_fin) {
                    $query .= "
                AND t_eventos_concentrador.fec_evento >= :fecha_inicio
                AND t_eventos_concentrador.fec_evento <= :fecha_fin";
                    $params['fecha_inicio'] = $fecha_inicio;
                    $params['fecha_fin'] = $fecha_fin;
                }




                $query .= "
                AND t_eventos_concentrador.id_ct = :id_ct
                ORDER BY t_eventos_concentrador.fec_evento desc, t_eventos_concentrador.hor_evento desc";




                //$query .= $fecha_inicio && $fecha_fin ? ";" : " LIMIT 2000;";




                $resultadosQ23 = DB::connection($connection)->select($query, $params);
                $resultadosQ23Collection = new Collection($resultadosQ23);
                $currentPage = LengthAwarePaginator::resolveCurrentPage();
                $perPage = 100; // Número de elementos por página
                $currentItems = $resultadosQ23Collection->slice(($currentPage - 1) * $perPage, $perPage)->all();


                // Crear paginador manualmente
                $resultadosQ23 = new LengthAwarePaginator($currentItems, count($resultadosQ23Collection), $perPage, $currentPage, [
                    'path' => request()->url(),
                    'query' => request()->query()
                ]);


                return $resultadosQ23 ?: ['message' => 'No hay datos'];
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            return ['message' => 'Error: ' . $e->getMessage()];
        }
    }

    public function exportEventosCT(Request $request)
    {
        try {
            $user = auth()->user();
            $connection = 'pgsql' . '-' . strtolower($user->nom_distribuidora);
            $fecha_inicio = $request->input('fecha_inicio');
            $fecha_fin = $request->input('fecha_fin');
            $id_ct = $request->input('id_ct');
            // NUEVO: Tipo de archivo ('excel' por default)
            $format = $request->input('format', 'excel'); 
            $extension = $format === 'csv' ? 'csv' : 'xlsx';
            $exportFormat = $format === 'csv' ? ExcelFormat::CSV : ExcelFormat::XLSX;

            if ($id_ct) {
                $query = "
                SELECT 
                    t_eventos_concentrador.id_ct, 
                    t_eventos_concentrador.id_cnc, 
                    TO_CHAR(t_eventos_concentrador.fec_evento, 'DD/MM/YYYY') as fecha,
                    t_eventos_concentrador.hor_evento,
                    t_eventos_concentrador.txt_adicionales_1,
                    t_eventos_concentrador.txt_adicionales_2,
                    t_descripcion_eventos_concentrador.des_evento_dc
                FROM core.t_eventos_concentrador, core.t_descripcion_eventos_concentrador
                WHERE t_eventos_concentrador.grp_evento_dc = t_descripcion_eventos_concentrador.grp_evento_dc
                AND t_eventos_concentrador.cod_evento_dc = t_descripcion_eventos_concentrador.cod_evento_dc";

                $params = ['id_ct' => $id_ct];

                if ($fecha_inicio && $fecha_fin) {
                    $query .= "
                AND t_eventos_concentrador.fec_evento >= :fecha_inicio
                AND t_eventos_concentrador.fec_evento <= :fecha_fin";
                    $params['fecha_inicio'] = $fecha_inicio;
                    $params['fecha_fin'] = $fecha_fin;
                }

                $query .= "
                AND t_eventos_concentrador.id_ct = :id_ct
                ORDER BY t_eventos_concentrador.fec_evento desc, t_eventos_concentrador.hor_evento desc";


                $exportEventosCT = DB::connection($connection)->select($query, $params);
                if($exportEventosCT) {
                    return Excel::download(new EventosCTExport($exportEventosCT), 'eventos_ct.' . $extension, $exportFormat);                   
                } else {
                    return response()->json(['message' => 'No hay datos'], 404);
                } 
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            return ['message' => 'No hay datos'];
        }
    }












    public function consultaVeintiCuatro($id_ct, $connection)
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_alertas_dc') &&
                Schema::connection($connection)->hasTable('t_alertas_distribuidora')
            ) {
                $resultadosQ24 = DB::connection($connection)
                    ->select("
                        SELECT 
                            t_alertas_dc.id_ct,
                            t_alertas_dc.id_cnc,
                            TO_CHAR(t_alertas_dc.fec_alerta_dc, 'DD/MM/YYYY') as fecha,
                            t_alertas_dc.hor_alerta_dc,
                            t_alertas_dc.cod_gravedad_dc,
                            t_alertas_distribuidora.des_evento
                        FROM core.t_alertas_dc, core.t_alertas_distribuidora
                        WHERE
                            t_alertas_dc.grp_alerta_dc = t_alertas_distribuidora.grp_alerta 
                        AND
                            t_alertas_dc.cod_alerta_dc = t_alertas_distribuidora.cod_alerta
                        AND t_alertas_dc.id_ct = :id_ct
                        ORDER BY fec_alerta_dc DESC, hor_alerta_dc DESC 
                        LIMIT 100
                ", ['id_ct' => $id_ct]);




                return $resultadosQ24 ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico 
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }








    public function consultaVeintiCinco($id_ct, $connection, Request $request) //BALANCES
    {
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');




        if ($id_ct) {
            $query = "
                SELECT id_ct, 
                    TO_CHAR(fec_inicio, 'DD/MM/YYYY') as fecha, 
                    val_ai_d_sum_cnt as energia_consumida, 
                    val_ae_d_sum_cnt as energia_autoconsumos, 
                    val_ai_d_sum_svr as energia_red,
                    num_contadores_d as nro_contadores,
                    (val_ai_d_sum_svr+val_ae_d_sum_cnt) as generacion, 
                    ((val_ai_d_sum_svr+val_ae_d_sum_cnt) - (val_ai_d_sum_cnt)) as perdida, 
                    (100 -((val_ai_d_sum_cnt)*100)/(val_ai_d_sum_svr+val_ae_d_sum_cnt)) as porcentaje_perdida 
                FROM core.t_balances_diarios
                WHERE tip_calculo = '1' and val_ai_d_sum_svr > 0 ";




            if ($fecha_inicio && $fecha_fin) {
                $query .= "
                    AND  t_balances_diarios.fec_inicio >= :fecha_inicio
                    AND  t_balances_diarios.fec_inicio <= :fecha_fin
                    AND id_ct = :id_ct
                    ORDER BY id_ct DESC, fec_inicio DESC, hor_inicio DESC, fec_fin DESC, hor_fin DESC, tip_calculo DESC;";
                $params = ['id_ct' => $id_ct, 'fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin];
            } else {
                $query .= "
                AND t_balances_diarios.fec_inicio >= (SELECT MAX(fec_inicio) FROM core.t_balances_diarios) 
                AND id_ct = :id_ct
                ORDER BY id_ct DESC, fec_inicio DESC, hor_inicio DESC, fec_fin DESC, hor_fin DESC, tip_calculo DESC;";
                $params = ['id_ct' => $id_ct];
            }




            $resultadosQ25 = DB::connection($connection)->select($query, $params);
            //  dd($resultadosQ25);




            return $resultadosQ25 ?: [];
        }
    }




    public function consultaVeintiSeis($id_ct, $connection, Request $request)
    {
        try {
            if (Schema::connection($connection)->hasTable('t_balances_diarios')) {
                $fecha_inicio = $request->input('fecha_inicio');
                $fecha_fin = $request->input('fecha_fin');




                if ($fecha_inicio && $fecha_fin) {
                    // Consulta con fechas (suma y agregaciones)
                    $query = "
                    SELECT id_ct, 
                        SUM(val_ai_d_sum_cnt) as energia_consumida, 
                        SUM(val_ae_d_sum_cnt) as energia_autoconsumos, 
                        SUM(val_ai_d_sum_svr) as energia_red,
                        AVG(num_contadores_d) as nro_contadores,
                        SUM(val_ai_d_sum_svr + val_ae_d_sum_cnt) as generacion, 
                        SUM(val_ai_d_sum_svr + val_ae_d_sum_cnt - val_ai_d_sum_cnt) as perdida, 
                        Round((100 - SUM(val_ai_d_sum_cnt) * 100 / SUM(val_ai_d_sum_svr + val_ae_d_sum_cnt)),1) as porcentaje_perdida 
                    FROM core.t_balances_diarios
                    WHERE tip_calculo = '1' 
                        AND val_ai_d_sum_svr > 0
                        AND fec_inicio >= :fecha_inicio
                        AND fec_inicio <= :fecha_fin
                        AND id_ct = :id_ct
                    GROUP BY id_ct
                    ORDER BY id_ct DESC;
                ";
                    $params = ['id_ct' => $id_ct, 'fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin];
                } else {
                    // Consulta sin fechas (sin suma y agregaciones)
                    $query = "
                    SELECT id_ct, 
                        TO_CHAR(fec_inicio, 'DD/MM/YYYY') as fecha, 
                        val_ai_d_sum_cnt as energia_consumida, 
                        val_ae_d_sum_cnt as energia_autoconsumos, 
                        val_ai_d_sum_svr as energia_red,
                        num_contadores_d as nro_contadores,
                        (val_ai_d_sum_svr + val_ae_d_sum_cnt) as generacion, 
                        (val_ai_d_sum_svr + val_ae_d_sum_cnt - val_ai_d_sum_cnt) as perdida, 
                        Round((100 - (val_ai_d_sum_cnt * 100) / (val_ai_d_sum_svr + val_ae_d_sum_cnt)),1) as porcentaje_perdida 
                    FROM core.t_balances_diarios
                    WHERE tip_calculo = '1' 
                        AND val_ai_d_sum_svr > 0
                        AND fec_inicio >= (
                            SELECT MAX(fec_inicio) 
                            FROM core.t_balances_diarios 
                            WHERE id_ct = :id_ct
                        )
                        AND id_ct = :id_ct
                    ORDER BY id_ct DESC, fec_inicio DESC, hor_inicio DESC, fec_fin DESC, hor_fin DESC, tip_calculo DESC;
                ";
                    $params = ['id_ct' => $id_ct];
                }




                $resultadosQ26 = DB::connection($connection)->select($query, $params);




                return $resultadosQ26 ?: [];
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            return ['message' => 'Error: ' . $e->getMessage()];
        }
    }




    public function consultaVeintiSiete($id_ct, $connection, Request $request) //grafico
    {
        try {
            if (Schema::connection($connection)->hasTable('t_balances_diarios')) {
                $fecha_inicio = $request->input('fecha_inicio');
                $fecha_fin = $request->input('fecha_fin');




                $query = "
                    SELECT id_ct, 
                        TO_CHAR(fec_inicio, 'DD/MM/YYYY') as fecha_inicio, 
                        val_ai_d_sum_cnt as energia_consumida, 
                        val_ae_d_sum_cnt as energia_autoconsumos, 
                        val_ai_d_sum_svr as energia_red,
                        num_contadores_d as nro_contadores,
                        (val_ai_d_sum_svr+val_ae_d_sum_cnt) as generacion, 
                        ((val_ai_d_sum_svr+val_ae_d_sum_cnt) - (val_ai_d_sum_cnt)) as perdida, 
                        (100 -((val_ai_d_sum_cnt)*100)/(val_ai_d_sum_svr+val_ae_d_sum_cnt)) as porcentaje_perdida 
                    FROM core.t_balances_diarios
                    WHERE tip_calculo = '1' and val_ai_d_sum_svr > 0 
                    AND id_ct = :id_ct";




                if ($fecha_inicio && $fecha_fin) {
                    $query .= " AND fec_inicio >= :fecha_inicio AND fec_inicio <= :fecha_fin";
                    $params = ['id_ct' => $id_ct, 'fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin];
                } else {
                    $params = ['id_ct' => $id_ct];
                }




                $query .= " ORDER BY fec_inicio DESC LIMIT 30";




                $resultadosQ27 = DB::connection($connection)->select($query, $params);




                // Ordenar los resultados en PHP
                usort($resultadosQ27, function ($a, $b) {
                    $dateA = \DateTime::createFromFormat('d/m/Y', $a->fecha_inicio);
                    $dateB = \DateTime::createFromFormat('d/m/Y', $b->fecha_inicio);
                    return $dateA <=> $dateB;
                });




                // dd($resultadosQ27);
                return $resultadosQ27 ?: [];
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            return ['message' => 'Error: ' . $e->getMessage()];
        }
    }




    
    public function consultaVeintiOcho(Request $request, $id_ct, $connection) // mapa sobretensiones
    {
        try {
            // Verificar si las tablas existen
            if (
                !Schema::connection($connection)->hasTable('t_ct') ||
                !Schema::connection($connection)->hasTable('t_cups')
            ) {
                return ['message' => 'No hay datos (Tablas no encontradas)'];
            }
    
            // Obtener las fechas de inicio y fin del request
            $fecha_inicio = $request->input('fecha_inicio');
            $fecha_fin = $request->input('fecha_fin');
    
            // Definir los parámetros iniciales
            $params = ['id_ct' => $id_ct];
    
            // Construcción de la consulta SQL
            $query = "
                WITH max_fec_evento AS (
                    SELECT
                        id_cups,
                        MAX(fec_evento) AS max_fecha
                    FROM core.v_sobre_voltajes
                    WHERE 1=1
                        " . (!empty($fecha_inicio) ? "AND fec_evento >= :fecha_inicio " : "") . "
                        " . (!empty($fecha_fin) ? "AND fec_evento <= :fecha_fin " : "") . "
                    GROUP BY id_cups
                ),
                max_fec_hor_evento AS (
                    SELECT
                        v.id_cups,
                        MAX(v.fec_evento) AS max_fecha,
                        MAX(v.hor_evento) AS max_hora
                    FROM core.v_sobre_voltajes v
                    JOIN max_fec_evento m 
                        ON v.id_cups = m.id_cups 
                        AND v.fec_evento = m.max_fecha
                    GROUP BY v.id_cups
                ),
                sobre_voltajes_totales AS (
                    SELECT
                        id_cups,
                        COUNT(*) AS nro_sobre_voltajes
                    FROM core.v_sobre_voltajes
                    WHERE 1=1 " . 
                    (!empty($fecha_inicio) ? "AND fec_evento >= :fecha_inicio " : "") . 
                    (!empty($fecha_fin) ? "AND fec_evento <= :fecha_fin " : "") . "
                    GROUP BY id_cups
                )
                SELECT
                    c.id_cups,
                    c.nom_cups,
                    c.dir_cups,
                    c.ind_autoconsumo,
                    c.lat_cups,
                    c.lon_cups,
                    TO_CHAR(m.max_fecha, 'DD/MM/YYYY') AS fecha,
                    TO_CHAR(h.max_hora, 'HH24:MI:SS') AS hora,
                    s.nro_sobre_voltajes
                FROM core.t_cups c
                JOIN core.t_ct t ON c.id_ct = t.id_ct
                JOIN max_fec_evento m ON c.id_cups = m.id_cups
                JOIN max_fec_hor_evento h ON c.id_cups = h.id_cups AND m.max_fecha = h.max_fecha
                JOIN sobre_voltajes_totales s ON c.id_cups = s.id_cups
                WHERE t.id_ct = :id_ct
            ";
    
            // Añadir condiciones de fecha si están presentes
            if ($fecha_inicio) {
                $params['fecha_inicio'] = $fecha_inicio;
            }
            if ($fecha_fin) {
                $params['fecha_fin'] = $fecha_fin;
            }
    
            // Depurar consulta antes de ejecutarla
            // dd($query, $params); // Descomentar para ver la consulta exacta en Laravel
    
            // Ejecutar la consulta
            $resultadosQ28 = DB::connection($connection)->select($query, $params);
    
            return !empty($resultadosQ28) ? $resultadosQ28 : ['message' => 'No hay datos'];
    
        } catch (\Exception $e) {
            return ['message' => 'Error: ' . $e->getMessage()];
        }
    }
    
    
















    public function consultaVeintiNueve(Request $request, $id_ct, $connection) //mapa subtensiones
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_ct') &&
                Schema::connection($connection)->hasTable('t_cups')
            ) {
                // Obtener las fechas de inicio y fin del request
                $fecha_inicio = $request->input('fecha_inicio');
                $fecha_fin = $request->input('fecha_fin');




                // Construir la consulta SQL con las fechas
                $query = "
                WITH max_fec_evento AS (
                    SELECT
                        id_cups,
                        MAX(fec_evento) AS max_fecha
                    FROM core.v_sub_voltajes
                    WHERE 1=1
                        " . (!empty($fecha_inicio) ? "AND fec_evento >= :fecha_inicio " : "") . "
                        " . (!empty($fecha_fin) ? "AND fec_evento <= :fecha_fin " : "") . "
                    GROUP BY id_cups
                ),
                max_fec_hor_evento AS (
                    SELECT
                        v.id_cups,
                        MAX(v.fec_evento) AS max_fecha,
                        MAX(v.hor_evento) AS max_hora
                    FROM core.v_sub_voltajes v
                    JOIN max_fec_evento m ON v.id_cups = m.id_cups AND v.fec_evento = m.max_fecha
                    GROUP BY v.id_cups, v.fec_evento
                ),
                sub_voltajes_totales AS (
                    SELECT
                        id_cups,
                        COUNT(*) AS nro_sub_voltajes
                    FROM core.v_sub_voltajes
                    WHERE 1=1 " . 
                    (!empty($fecha_inicio) ? "AND fec_evento >= :fecha_inicio " : "") . 
                    (!empty($fecha_fin) ? "AND fec_evento <= :fecha_fin " : "") . "
                    GROUP BY id_cups
                )
                SELECT
                    c.id_cups,
                    c.nom_cups,
                    c.dir_cups,
                    c.ind_autoconsumo,
                    c.lat_cups,
                    c.lon_cups,
                    TO_CHAR(m.max_fecha, 'DD/MM/YYYY') AS fecha,
                    TO_CHAR(h.max_hora, 'HH24:MI:SS') AS hora,
                    s.nro_sub_voltajes
                FROM core.t_cups c
                JOIN core.t_ct t ON c.id_ct = t.id_ct
                JOIN max_fec_evento m ON c.id_cups = m.id_cups
                JOIN max_fec_hor_evento h ON c.id_cups = h.id_cups AND m.max_fecha = h.max_fecha
                JOIN sub_voltajes_totales s ON c.id_cups = s.id_cups
                WHERE t.id_ct = :id_ct
            ";




                // Añadir condiciones de fecha si están presentes
                $params = ['id_ct' => $id_ct];
                if ($fecha_inicio) {
                    $params['fecha_inicio'] = $fecha_inicio;
                }
                if ($fecha_fin) {
                    $params['fecha_fin'] = $fecha_fin;
                }




                // Ejecutar la consulta
                $resultadosQ29 = DB::connection($connection)->select($query, $params);




                return $resultadosQ29 ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico 
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }








    public function consultaTreinta(Request $request, $id_ct, $connection) //mapa cortes
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_ct') &&
                Schema::connection($connection)->hasTable('t_cups')
            ) {
                // Obtener las fechas de inicio y fin del request
                $fecha_inicio = $request->input('fecha_inicio');
                $fecha_fin = $request->input('fecha_fin');




                // Construir la consulta SQL con las fechas
                $query = "
                WITH max_fec_evento AS (
                    SELECT
                        id_cups,
                        MAX(fec_evento) AS max_fecha
                    FROM core.v_apagones
                    WHERE 1=1
                        " . (!empty($fecha_inicio) ? "AND fec_evento >= :fecha_inicio " : "") . "
                        " . (!empty($fecha_fin) ? "AND fec_evento <= :fecha_fin " : "") . "
                    GROUP BY id_cups
                ),
                max_fec_hor_evento AS (
                    SELECT
                        v.id_cups,
                        MAX(v.fec_evento) AS max_fecha,
                        MAX(v.hor_evento) AS max_hora
                    FROM core.v_apagones v
                    JOIN max_fec_evento m ON v.id_cups = m.id_cups AND v.fec_evento = m.max_fecha
                    GROUP BY v.id_cups, v.fec_evento
                ),
                apagones_totales AS (
                SELECT
                    id_cups,
                    COUNT(*) AS apagones
                FROM core.v_apagones
                WHERE 1=1 " . 
                (!empty($fecha_inicio) ? "AND fec_evento >= :fecha_inicio " : "") . 
                (!empty($fecha_fin) ? "AND fec_evento <= :fecha_fin " : "") . "
                GROUP BY id_cups
                )
                SELECT
                    c.id_cups,
                    c.nom_cups,
                    c.dir_cups,
                    c.ind_autoconsumo,
                    c.lat_cups,
                    c.lon_cups,
                    TO_CHAR(m.max_fecha, 'DD/MM/YYYY') AS fecha,
                    TO_CHAR(h.max_hora, 'HH24:MI:SS') AS hora,
                    s.apagones
                FROM core.t_cups c
                JOIN core.t_ct t ON c.id_ct = t.id_ct
                JOIN max_fec_evento m ON c.id_cups = m.id_cups
                JOIN max_fec_hor_evento h ON c.id_cups = h.id_cups AND m.max_fecha = h.max_fecha
                JOIN apagones_totales s ON c.id_cups = s.id_cups
                WHERE t.id_ct = :id_ct
            ";




                // Añadir condiciones de fecha si están presentes
                $params = ['id_ct' => $id_ct];
                if ($fecha_inicio) {
                    $params['fecha_inicio'] = $fecha_inicio;
                }
                if ($fecha_fin) {
                    $params['fecha_fin'] = $fecha_fin;
                }




                // Ejecutar la consulta
                $resultadosQ30 = DB::connection($connection)->select($query, $params);




                return $resultadosQ30 ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico 
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }








    public function consultaTreintayUno(Request $request, $id_ct, $connection) //mapa microcortes
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_ct') &&
                Schema::connection($connection)->hasTable('t_cups')
            ) {
                // Obtener las fechas de inicio y fin del request
                $fecha_inicio = $request->input('fecha_inicio');
                $fecha_fin = $request->input('fecha_fin');




                // Construir la consulta SQL con las fechas
                $query = "
                WITH max_fec_evento AS (
                    SELECT
                        id_cups,
                        MAX(fec_evento) AS max_fecha
                    FROM core.v_micro_cortes
                    WHERE 1=1
                        " . (!empty($fecha_inicio) ? "AND fec_evento >= :fecha_inicio " : "") . "
                        " . (!empty($fecha_fin) ? "AND fec_evento <= :fecha_fin " : "") . "
                    GROUP BY id_cups
                ),
                max_fec_hor_evento AS (
                    SELECT
                        v.id_cups,
                        MAX(v.fec_evento) AS max_fecha,
                        MAX(v.hor_evento) AS max_hora
                    FROM core.v_micro_cortes v
                    JOIN max_fec_evento m ON v.id_cups = m.id_cups AND v.fec_evento = m.max_fecha
                    GROUP BY v.id_cups, v.fec_evento
                ),
                micro_cortes_totales AS (
                    SELECT
                        id_cups,
                        COUNT(*) AS microcortes
                    FROM core.v_micro_cortes
                    WHERE 1=1 " . 
                    (!empty($fecha_inicio) ? "AND fec_evento >= :fecha_inicio " : "") . 
                    (!empty($fecha_fin) ? "AND fec_evento <= :fecha_fin " : "") . "
                    GROUP BY id_cups
                )
                SELECT
                    c.id_cups,
                    c.nom_cups,
                    c.dir_cups,
                    c.ind_autoconsumo,
                    c.lat_cups,
                    c.lon_cups,
                    TO_CHAR(m.max_fecha, 'DD/MM/YYYY') AS fecha,
                    TO_CHAR(h.max_hora, 'HH24:MI:SS') AS hora,
                    s.microcortes
                FROM core.t_cups c
                JOIN core.t_ct t ON c.id_ct = t.id_ct
                JOIN max_fec_evento m ON c.id_cups = m.id_cups
                JOIN max_fec_hor_evento h ON c.id_cups = h.id_cups AND m.max_fecha = h.max_fecha
                JOIN micro_cortes_totales s ON c.id_cups = s.id_cups
                WHERE t.id_ct = :id_ct
            ";




                // Añadir condiciones de fecha si están presentes
                $params = ['id_ct' => $id_ct];
                if ($fecha_inicio) {
                    $params['fecha_inicio'] = $fecha_inicio;
                }
                if ($fecha_fin) {
                    $params['fecha_fin'] = $fecha_fin;
                }




                // Ejecutar la consulta
                $resultadosQ31 = DB::connection($connection)->select($query, $params);
                // dd($resultadosQ31);
                return $resultadosQ31 ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico 
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }
    












    public function consultaTreintayDos($id_ct, $connection, Request $request) //mapa lecturas
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_ct') &&
                Schema::connection($connection)->hasTable('t_cups') &&
                Schema::connection($connection)->hasTable('t_indices_lectura')
            ) {
                $fecha = $request->input('fecha_lecturas');
                $query = "
                WITH MaxFechaPorCups AS (
                SELECT 
                    id_cups
                FROM core.t_indices_lectura
                GROUP BY id_cups
            )
                SELECT 
                                t_cups.nom_cups,
                                t_cups.dir_cups,




                t_indices_lectura.id_cups, 
                t_indices_lectura.id_cnt, 
                TO_CHAR(t_indices_lectura.fec_lectura, 'DD/MM/YYYY') AS fecha, 
                t_indices_lectura.ind_s05,
                t_cups.lat_cups,
                t_cups.lon_cups,
                t_cups.ind_autoconsumo
            FROM core.t_indices_lectura
            JOIN core.t_cups ON t_indices_lectura.id_cups = t_cups.id_cups
            JOIN core.t_ct ON t_cups.id_ct = t_ct.id_ct
            JOIN MaxFechaPorCups ON t_indices_lectura.id_cups = MaxFechaPorCups.id_cups 
                WHERE t_ct.id_ct = :id_ct
                ";




                $params = ['id_ct' => $id_ct];




                if ($fecha) {
                    $query .= " AND DATE(t_indices_lectura.fec_lectura) = :fecha";
                    $params['fecha'] = $fecha;
                } else {
                    $query .= "  AND DATE(fec_lectura) = (SELECT MAX(fec_lectura) FROM core.t_indices_lectura)";
                }




                $query .= " ORDER BY id_cups ASC, id_cnt ASC, fec_lectura ASC";




                $resultadosQ32 = DB::connection($connection)->select($query, $params);
                // dd($resultadosQ32);
                return $resultadosQ32 ?: ['message' => 'No hay datos'];
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            return ['message' => 'No hay datos'];
        }
    }
























    //CONSULTAS PARA REPORTES 
    public function consultaTreintayTres($connection) // Tabla con contadores no leídos
    {
        try {
            // Realiza la consulta
            $resultadosQ33 = DB::connection($connection)
                ->select("
                    SELECT count(*) as contadores_sin_lectura_7_dias
                    FROM core.v_contadores_no_leidos_7_dias, core.t_cups
                    WHERE core.v_contadores_no_leidos_7_dias.id_cnt = t_cups.id_cnt;
                ");




            // Verifica si hay resultados
            return $resultadosQ33 ?: [];
        } catch (\Exception $e) {
            // Captura cualquier excepción y maneja el error aquí
            return "Error en la consulta: " . $e->getMessage();
        }
    }








    public function consultaTreintayCuatro($connection)
    {
        try {
            // Realiza la consulta
            $resultadosQ34 = DB::connection($connection)
                ->select("
                SELECT DISTINCT ON (t_cups.id_cups)
                core.v_contadores_no_leidos_7_dias.id_cnt,
                    t_cups.id_cups,
                    t_cups.nom_cups,
                    t_cups.dir_cups,
                    t_cups.id_ct,
					t_ct.nom_ct
                FROM core.v_contadores_no_leidos_7_dias
                JOIN core.t_cups ON core.v_contadores_no_leidos_7_dias.id_cnt = t_cups.id_cnt
	                JOIN core.t_ct ON core.t_ct.id_ct = t_cups.id_ct;
            ");




            // Verifica si hay resultados
            return $resultadosQ34 ?: [];
        } catch (\Exception $e) {
            // Captura cualquier excepción y maneja el error aquí
            return "Error en la consulta: " . $e->getMessage();
        }
    }








    public function consultaTreintayCinco($connection)
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_g02_estadisticas_contadores') &&
                Schema::connection($connection)->hasTable('t_cups')
            ) {
                $resultadosQ35 = DB::connection($connection)
                    ->select("
                            SELECT count(*) as disponibilidad_menos_30
                            FROM core.t_g02_estadisticas_contadores, core.t_cups
                            WHERE
                                core.t_g02_estadisticas_contadores.por_minutos_contador < 30 AND
                                core.t_g02_estadisticas_contadores.fec_fin = (SELECT MAX(fec_fin) FROM core.t_g02_estadisticas_contadores) AND
                                core.t_g02_estadisticas_contadores.id_cnt = t_cups.id_cnt ;
                        ");
                //    dd($resultadosQ35);
                return $resultadosQ35 ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }
















    public function consultaTreintaySeis($connection)
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_g02_estadisticas_contadores') &&
                Schema::connection($connection)->hasTable('t_cups')
            ) {
                $resultadosQ36 = DB::connection($connection)
                    ->select("
                        SELECT 
                        t_cups.id_cups, 
                        t_cups.nom_cups, 
                        t_cups.id_cnt, 
                        t_cups.dir_cups, 
                        t_cups.id_ct,
                        t_ct.nom_ct,
                        t_g02_estadisticas_contadores.por_minutos_contador,
                        TO_CHAR(t_g02_estadisticas_contadores.fec_fin, 'DD/MM/YYY') as fec_fin
                        FROM core.t_g02_estadisticas_contadores, core.t_cups, core.t_ct
                        WHERE
                        core.t_ct.id_ct = t_cups.id_ct
                        AND
                            core.t_g02_estadisticas_contadores.por_minutos_contador < 30 
                        AND
                            core.t_g02_estadisticas_contadores.fec_fin = (SELECT MAX(fec_fin) 
                        FROM core.t_g02_estadisticas_contadores) 
                        AND
                            core.t_g02_estadisticas_contadores.id_cnt = t_cups.id_cnt;
                            ");
                // dd($resultadosQ36);
                return $resultadosQ36 ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }




    // REPORTES CALIDAD
    public function consultaTreintaySiete(Request $request, $connection)
{
    try {
        if (
            Schema::connection($connection)->hasTable('t_ct') &&
            Schema::connection($connection)->hasTable('t_cups')
        ) {
            // Obtener las fechas de inicio y fin del request
            $fecha_inicio = $request->input('fecha_inicio');
            $fecha_fin = $request->input('fecha_fin');

            // Inicializar el array de parámetros
            $params = [];

            // Construir la consulta SQL con las fechas
            $query = "
                SELECT
                    t.nom_ct,
                    c.id_cups,
                    c.nom_cups,
                    c.dir_cups,
                    TO_CHAR(MAX(COALESCE(p.fec_evento, s.fec_evento, a.fec_evento, m.fec_evento)), 'DD/MM/YYYY') AS fecha,
                    COALESCE(p.apagones, 0) AS apagones,
                    COALESCE(s.sobrevoltajes, 0) AS sobrevoltajes,
                    COALESCE(a.sub_voltajes, 0) AS sub_voltajes,
                    COALESCE(m.micro_cortes, 0) AS micro_cortes
                FROM core.t_cups c
                JOIN core.t_ct t ON c.id_ct = t.id_ct
                LEFT JOIN (
                    SELECT id_cups, MAX(fec_evento) AS fec_evento, COUNT(fec_evento) AS apagones
                    FROM core.v_apagones
                    WHERE 1=1 ";

            // Agregar filtro de fechas para apagones
            if ($fecha_inicio && $fecha_fin) {
                $query .= "AND fec_evento >= :fecha_inicio
                            AND fec_evento <= :fecha_fin ";
                $params['fecha_inicio'] = $fecha_inicio;
                $params['fecha_fin'] = $fecha_fin;
            } else if ($fecha_inicio) {
                $query .= " AND fec_evento >= :fecha_inicio ";
                $params['fecha_inicio'] = $fecha_inicio;
            } else if ($fecha_fin) {
                $query .= " AND fec_evento <= :fecha_fin ";
                $params['fecha_fin'] = $fecha_fin;
            } else {
                $query .= " AND fec_evento >= NOW() - INTERVAL '30 days' ";
            }

            $query .= "GROUP BY id_cups) p ON c.id_cups = p.id_cups";

            // Hacer lo mismo para las otras subconsultas (sobrevoltajes, sub_voltajes, micro_cortes)
            $query .= "
                LEFT JOIN (
                    SELECT id_cups, MAX(fec_evento) AS fec_evento, COUNT(fec_evento) AS sobrevoltajes
                    FROM core.v_sobre_voltajes
                    WHERE 1=1 ";

            if ($fecha_inicio && $fecha_fin) {
                $query .= "AND fec_evento >= :fecha_inicio
                            AND fec_evento <= :fecha_fin ";
            } else if ($fecha_inicio) {
                $query .= " AND fec_evento >= :fecha_inicio ";
            } else if ($fecha_fin) {
                $query .= " AND fec_evento <= :fecha_fin ";
            } else {
                $query .= " AND fec_evento >= NOW() - INTERVAL '30 days' ";
            }

            $query .= "GROUP BY id_cups) s ON c.id_cups = s.id_cups";

            $query .= "
                LEFT JOIN (
                    SELECT id_cups, MAX(fec_evento) AS fec_evento, COUNT(fec_evento) AS sub_voltajes
                    FROM core.v_sub_voltajes
                    WHERE 1=1 ";

            if ($fecha_inicio && $fecha_fin) {
                $query .= "AND fec_evento >= :fecha_inicio
                            AND fec_evento <= :fecha_fin ";
            } else if ($fecha_inicio) {
                $query .= " AND fec_evento >= :fecha_inicio ";
            } else if ($fecha_fin) {
                $query .= " AND fec_evento <= :fecha_fin ";
            } else {
                $query .= " AND fec_evento >= NOW() - INTERVAL '30 days' ";
            }

            $query .= "GROUP BY id_cups) a ON c.id_cups = a.id_cups";

            $query .= "
                LEFT JOIN (
                    SELECT id_cups, MAX(fec_evento) AS fec_evento, COUNT(fec_evento) AS micro_cortes
                    FROM core.v_micro_cortes
                    WHERE 1=1 ";

            if ($fecha_inicio && $fecha_fin) {
                $query .= "AND fec_evento >= :fecha_inicio
                            AND fec_evento <= :fecha_fin ";
            } else if ($fecha_inicio) {
                $query .= " AND fec_evento >= :fecha_inicio ";
            } else if ($fecha_fin) {
                $query .= " AND fec_evento <= :fecha_fin ";
            } else {
                $query .= " AND fec_evento >= NOW() - INTERVAL '30 days' ";
            }

            $query .= "GROUP BY id_cups) m ON c.id_cups = m.id_cups";

            // Filtro de fechas en la consulta principal
            $query .= " WHERE 1=1 ";

            if ($fecha_inicio && $fecha_fin) {
                $query .= " AND COALESCE(p.fec_evento, s.fec_evento, a.fec_evento, m.fec_evento) >= :fecha_inicio
                            AND COALESCE(p.fec_evento, s.fec_evento, a.fec_evento, m.fec_evento) <= :fecha_fin ";
                $params['fecha_inicio'] = $fecha_inicio;
                $params['fecha_fin'] = $fecha_fin;
            } else if ($fecha_inicio) {
                $query .= " AND COALESCE(p.fec_evento, s.fec_evento, a.fec_evento, m.fec_evento) >= :fecha_inicio ";
                $params['fecha_inicio'] = $fecha_inicio;
            } else if ($fecha_fin) {
                $query .= " AND COALESCE(p.fec_evento, s.fec_evento, a.fec_evento, m.fec_evento) <= :fecha_fin ";
                $params['fecha_fin'] = $fecha_fin;
            } else {
                $query .= " AND COALESCE(p.fec_evento, s.fec_evento, a.fec_evento, m.fec_evento) >= NOW() - INTERVAL '30 days' ";
            }

            // Añadir la cláusula GROUP BY y ORDER BY
            $query .= "
                GROUP BY c.id_cups, t.nom_ct, c.nom_cups, p.apagones, s.sobrevoltajes, a.sub_voltajes, m.micro_cortes
                ORDER BY MAX(COALESCE(p.fec_evento, s.fec_evento, a.fec_evento, m.fec_evento)) DESC
            ";

            // Ejecutar la consulta
            $resultadosQ37 = DB::connection($connection)->select($query, $params);
            $resultadosQ37Collection = new Collection($resultadosQ37);
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $perPage = 100; // Número de elementos por página
            $currentItems = $resultadosQ37Collection->slice(($currentPage - 1) * $perPage, $perPage)->all();


            // Crear paginador manualmente
            $resultadosQ37 = new LengthAwarePaginator($currentItems, count($resultadosQ37Collection), $perPage, $currentPage, [
                'path' => request()->url(),
                'query' => request()->query()
            ]);
            return $resultadosQ37;
        }
    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }
}


public function exportReportesCalidad(Request $request)
{
    try {
        $user = auth()->user();
        $connection = 'pgsql' . '-' . strtolower($user->nom_distribuidora);
        if (
            Schema::connection($connection)->hasTable('t_ct') &&
            Schema::connection($connection)->hasTable('t_cups')
        ) {
            // Obtener las fechas de inicio y fin del request
            $fecha_inicio = $request->input('fecha_inicio');
            $fecha_fin = $request->input('fecha_fin');

            // NUEVO: Tipo de archivo ('excel' por default)
            $format = $request->input('format', 'excel'); 
            $extension = $format === 'csv' ? 'csv' : 'xlsx';
            $exportFormat = $format === 'csv' ? ExcelFormat::CSV : ExcelFormat::XLSX;

            // Inicializar el array de parámetros
            $params = [];

            // Construir la consulta SQL con las fechas
            $query = "
                SELECT
                    t.nom_ct,
                    c.id_cups,
                    c.nom_cups,
                    c.dir_cups,
                    TO_CHAR(MAX(COALESCE(p.fec_evento, s.fec_evento, a.fec_evento, m.fec_evento)), 'DD/MM/YYYY') AS fecha,
                    COALESCE(p.apagones, 0) AS apagones,
                    COALESCE(s.sobrevoltajes, 0) AS sobrevoltajes,
                    COALESCE(a.sub_voltajes, 0) AS sub_voltajes,
                    COALESCE(m.micro_cortes, 0) AS micro_cortes
                FROM core.t_cups c
                JOIN core.t_ct t ON c.id_ct = t.id_ct
                LEFT JOIN (
                    SELECT id_cups, MAX(fec_evento) AS fec_evento, COUNT(fec_evento) AS apagones
                    FROM core.v_apagones
                    WHERE 1=1 ";

            // Agregar filtro de fechas para apagones
            if ($fecha_inicio && $fecha_fin) {
                $query .= "AND fec_evento >= :fecha_inicio
                            AND fec_evento <= :fecha_fin ";
                $params['fecha_inicio'] = $fecha_inicio;
                $params['fecha_fin'] = $fecha_fin;
            } else if ($fecha_inicio) {
                $query .= " AND fec_evento >= :fecha_inicio ";
                $params['fecha_inicio'] = $fecha_inicio;
            } else if ($fecha_fin) {
                $query .= " AND fec_evento <= :fecha_fin ";
                $params['fecha_fin'] = $fecha_fin;
            } else {
                $query .= " AND fec_evento >= NOW() - INTERVAL '30 days' ";
            }

            $query .= "GROUP BY id_cups) p ON c.id_cups = p.id_cups";

            // Hacer lo mismo para las otras subconsultas (sobrevoltajes, sub_voltajes, micro_cortes)
            $query .= "
                LEFT JOIN (
                    SELECT id_cups, MAX(fec_evento) AS fec_evento, COUNT(fec_evento) AS sobrevoltajes
                    FROM core.v_sobre_voltajes
                    WHERE 1=1 ";

            if ($fecha_inicio && $fecha_fin) {
                $query .= "AND fec_evento >= :fecha_inicio
                            AND fec_evento <= :fecha_fin ";
            } else if ($fecha_inicio) {
                $query .= " AND fec_evento >= :fecha_inicio ";
            } else if ($fecha_fin) {
                $query .= " AND fec_evento <= :fecha_fin ";
            } else {
                $query .= " AND fec_evento >= NOW() - INTERVAL '30 days' ";
            }

            $query .= "GROUP BY id_cups) s ON c.id_cups = s.id_cups";

            $query .= "
                LEFT JOIN (
                    SELECT id_cups, MAX(fec_evento) AS fec_evento, COUNT(fec_evento) AS sub_voltajes
                    FROM core.v_sub_voltajes
                    WHERE 1=1 ";

            if ($fecha_inicio && $fecha_fin) {
                $query .= "AND fec_evento >= :fecha_inicio
                            AND fec_evento <= :fecha_fin ";
            } else if ($fecha_inicio) {
                $query .= " AND fec_evento >= :fecha_inicio ";
            } else if ($fecha_fin) {
                $query .= " AND fec_evento <= :fecha_fin ";
            } else {
                $query .= " AND fec_evento >= NOW() - INTERVAL '30 days' ";
            }

            $query .= "GROUP BY id_cups) a ON c.id_cups = a.id_cups";

            $query .= "
                LEFT JOIN (
                    SELECT id_cups, MAX(fec_evento) AS fec_evento, COUNT(fec_evento) AS micro_cortes
                    FROM core.v_micro_cortes
                    WHERE 1=1 ";

            if ($fecha_inicio && $fecha_fin) {
                $query .= "AND fec_evento >= :fecha_inicio
                            AND fec_evento <= :fecha_fin ";
            } else if ($fecha_inicio) {
                $query .= " AND fec_evento >= :fecha_inicio ";
            } else if ($fecha_fin) {
                $query .= " AND fec_evento <= :fecha_fin ";
            } else {
                $query .= " AND fec_evento >= NOW() - INTERVAL '30 days' ";
            }

            $query .= "GROUP BY id_cups) m ON c.id_cups = m.id_cups";

            // Filtro de fechas en la consulta principal
            $query .= " WHERE 1=1 ";

            if ($fecha_inicio && $fecha_fin) {
                $query .= " AND COALESCE(p.fec_evento, s.fec_evento, a.fec_evento, m.fec_evento) >= :fecha_inicio
                            AND COALESCE(p.fec_evento, s.fec_evento, a.fec_evento, m.fec_evento) <= :fecha_fin ";
                $params['fecha_inicio'] = $fecha_inicio;
                $params['fecha_fin'] = $fecha_fin;
            } else if ($fecha_inicio) {
                $query .= " AND COALESCE(p.fec_evento, s.fec_evento, a.fec_evento, m.fec_evento) >= :fecha_inicio ";
                $params['fecha_inicio'] = $fecha_inicio;
            } else if ($fecha_fin) {
                $query .= " AND COALESCE(p.fec_evento, s.fec_evento, a.fec_evento, m.fec_evento) <= :fecha_fin ";
                $params['fecha_fin'] = $fecha_fin;
            } else {
                $query .= " AND COALESCE(p.fec_evento, s.fec_evento, a.fec_evento, m.fec_evento) >= NOW() - INTERVAL '30 days' ";
            }

            // Añadir la cláusula GROUP BY y ORDER BY
            $query .= "
                GROUP BY c.id_cups, t.nom_ct, c.nom_cups, p.apagones, s.sobrevoltajes, a.sub_voltajes, m.micro_cortes
                ORDER BY MAX(COALESCE(p.fec_evento, s.fec_evento, a.fec_evento, m.fec_evento)) DESC
            ";

            // Ejecutar la consulta
            $exportReportesCalidad = DB::connection($connection)->select($query, $params);
            if($exportReportesCalidad) {
                return Excel::download(new ReportesCalidadExport($exportReportesCalidad), 'reportes_calidad.' . $extension, $exportFormat);
            } else {
                return response()->json(['message' => 'No hay datos'], 404);
            }
        }
    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }
}





    public function consultaTreintayOcho(Request $request, $connection)
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_ct') &&
                Schema::connection($connection)->hasTable('t_cups')
            ) {




                // Inicializar el array de parámetros
                $params = [];




                // Obtener las fechas de inicio y fin del request
                $fecha_inicio = $request->input('fecha_inicio');
                $fecha_fin = $request->input('fecha_fin');




                // Construir la consulta SQL base
                $query = "
                    SELECT
                        sub.nom_ct,
                        sub.total_cups,
                        sub.apagones,
                        sub.sobrevoltajes,
                        sub.sub_voltajes,
                        sub.micro_cortes,
                        sub.total_eventos,
                        ROUND((sub.total_eventos / sub.total_cups), 2) AS ratio
                    FROM (
                        SELECT
                            t.nom_ct,
                            COUNT(c.id_cups) AS total_cups,
                            COALESCE(SUM(p.apagones), 0) AS apagones,
                            COALESCE(SUM(s.sobrevoltajes), 0) AS sobrevoltajes,
                            COALESCE(SUM(a.sub_voltajes), 0) AS sub_voltajes,
                            COALESCE(SUM(m.micro_cortes), 0) AS micro_cortes,
                            COALESCE(SUM(p.apagones), 0) + COALESCE(SUM(s.sobrevoltajes), 0) + COALESCE(SUM(a.sub_voltajes), 0) + COALESCE(SUM(m.micro_cortes), 0) AS total_eventos
                        FROM core.t_cups c
                        JOIN core.t_ct t ON c.id_ct = t.id_ct
                        LEFT JOIN (
                            SELECT id_cups, COUNT(fec_evento) AS apagones
                            FROM core.v_apagones
                            WHERE 1 = 1 "; // Iniciar con WHERE siempre verdadero para facilitar construcción de condiciones adicionales




                // Añadir filtro de fecha por defecto (últimos 30 días) si no se especifica en el formulario
                if ($fecha_inicio && $fecha_fin) {
                    $query .= "AND fec_evento >= :fecha_inicio
                        AND fec_evento <= :fecha_fin";
                    $params['fecha_inicio'] = $fecha_inicio;
                    $params['fecha_fin'] = $fecha_fin;
                } else if($fecha_inicio) {
                    $query .= " AND fec_evento >= :fecha_inicio";
                    $params['fecha_inicio'] = $fecha_inicio;
                } else if($fecha_fin) {
                    $query .= "AND fec_evento <= :fecha_fin";
                    $params['fecha_fin'] = $fecha_fin;
                } else {
                    $query .= " AND fec_evento >= NOW() - INTERVAL '30 days'";
                }



                $query .= "
                            GROUP BY id_cups
                        ) p ON c.id_cups = p.id_cups
                        LEFT JOIN (
                            SELECT id_cups, COUNT(fec_evento) AS sobrevoltajes
                            FROM core.v_sobre_voltajes
                            WHERE 1 = 1 ";




                if ($fecha_inicio && $fecha_fin) {
                    $query .= " AND fec_evento >= :fecha_inicio
                            AND fec_evento <= :fecha_fin";
                    $params['fecha_inicio'] = $fecha_inicio;
                    $params['fecha_fin'] = $fecha_fin;
                } else if($fecha_inicio) {
                    $query .= " AND fec_evento >= :fecha_inicio";
                    $params['fecha_inicio'] = $fecha_inicio;
                } else if($fecha_fin) {
                    $query .= "AND fec_evento <= :fecha_fin";
                    $params['fecha_fin'] = $fecha_fin;
                } else {
                    $query .= " AND fec_evento >= NOW() - INTERVAL '30 days'";
                }




                $query .= "
                            GROUP BY id_cups
                        ) s ON c.id_cups = s.id_cups
                        LEFT JOIN (
                            SELECT id_cups, COUNT(fec_evento) AS sub_voltajes
                            FROM core.v_sub_voltajes
                            WHERE 1 = 1 ";

                if ($fecha_inicio && $fecha_fin) {
                    $query .= " AND fec_evento >= :fecha_inicio
                        AND fec_evento <= :fecha_fin";
                    $params['fecha_inicio'] = $fecha_inicio;
                    $params['fecha_fin'] = $fecha_fin;
                } else if($fecha_inicio) {
                    $query .= " AND fec_evento >= :fecha_inicio";
                    $params['fecha_inicio'] = $fecha_inicio;
                } else if($fecha_fin) {
                    $query .= "AND fec_evento <= :fecha_fin";
                    $params['fecha_fin'] = $fecha_fin;
                } else {
                    $query .= " AND fec_evento >= NOW() - INTERVAL '30 days'";
                }




                $query .= "
                            GROUP BY id_cups
                        ) a ON c.id_cups = a.id_cups
                        LEFT JOIN (
                            SELECT id_cups, COUNT(fec_evento) AS micro_cortes
                            FROM core.v_micro_cortes
                            WHERE 1 = 1 ";




                if ($fecha_inicio && $fecha_fin) {
                    $query .= " AND fec_evento >= :fecha_inicio
                        AND fec_evento <= :fecha_fin";
                    $params['fecha_inicio'] = $fecha_inicio;
                    $params['fecha_fin'] = $fecha_fin;
                } else if($fecha_inicio) {
                    $query .= " AND fec_evento >= :fecha_inicio";
                    $params['fecha_inicio'] = $fecha_inicio;
                } else if($fecha_fin) {
                    $query .= "AND fec_evento <= :fecha_fin";
                    $params['fecha_fin'] = $fecha_fin;
                } else {
                    $query .= " AND fec_evento >= NOW() - INTERVAL '30 days'";
                }




                $query .= "
                            GROUP BY id_cups
                        ) m ON c.id_cups = m.id_cups
                        GROUP BY t.nom_ct
                    ) sub
                    ORDER BY sub.nom_ct";




                // Ejecutar la consulta
                $resultadosQ38 = DB::connection($connection)->select($query, $params);
                //dd($query);
                return $resultadosQ38 ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico 
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }




    public function consultaTreintayNueve(Request $request, $connection) //gráfico barras cortes reportes de calidad
    {
        try {
            // Obtener las fechas de inicio y fin del request
            $fecha_inicio = $request->input('fecha_inicio');
            $fecha_fin = $request->input('fecha_fin');




            // Inicializar el array de parámetros
            $params = [];




            // Construir la consulta SQL
            $query = "
                SELECT COUNT(fec_evento) AS cantidad,
                    TO_CHAR(fec_evento, 'DD/MM/YYYY') as fec_evento
                FROM core.v_apagones
            ";




            // Añadir condiciones de fecha si están presentes
            if ($fecha_inicio) {
                $query .= " WHERE fec_evento >= :fecha_inicio ";
                $params['fecha_inicio'] = $fecha_inicio;
            } else {
                $query .= " WHERE fec_evento >= NOW() - INTERVAL '30 days'";
            }




            if ($fecha_fin) {
                $query .= "AND fec_evento <= :fecha_fin ";
                $params['fecha_fin'] = $fecha_fin;
            }




            // Añadir el GROUP BY
            $query .= " GROUP BY fec_evento;";




            // Ejecutar la consulta
            $resultadosQ39 = DB::connection($connection)->select($query, $params);
            // Verificar si hay resultados
            if (empty($resultadosQ39)) {
                return ['message' => 'No hay datos'];
            }
            // dd($resultadosQ39);




            return $resultadosQ39;
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }








    public function consultaCuarenta(Request $request, $connection) //gráfico barras microcortes reportes de calidad
    {
        try {
            // Obtener las fechas de inicio y fin del request
            $fecha_inicio = $request->input('fecha_inicio');
            $fecha_fin = $request->input('fecha_fin');




            // Inicializar el array de parámetros
            $params = [];




            // Construir la consulta SQL
            $query = "
            SELECT COUNT(fec_evento) AS cantidad,
                    TO_CHAR(fec_evento, 'DD/MM/YYYY') as fec_evento
            FROM core.v_micro_cortes
        ";




            // Añadir condiciones de fecha si están presentes
            if ($fecha_inicio) {
                $query .= " WHERE fec_evento >= :fecha_inicio ";
                $params['fecha_inicio'] = $fecha_inicio;
            } else {
                $query .= " WHERE fec_evento >= NOW() - INTERVAL '30 days'";
            }




            if ($fecha_fin) {
                $query .= "AND fec_evento <= :fecha_fin ";
                $params['fecha_fin'] = $fecha_fin;
            }




            // Añadir el GROUP BY
            $query .= " GROUP BY fec_evento;";




            // Ejecutar la consulta
            $resultadosQ40 = DB::connection($connection)->select($query, $params);




            // Verificar si hay resultados
            if (empty($resultadosQ40)) {
                return ['message' => 'No hay datos'];
            }




            return $resultadosQ40;
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }








    public function consultaCuarentayUno(Request $request, $connection) //gráfico barras subtensiones reportes de calidad
    {
        try {
            // Obtener las fechas de inicio y fin del request
            $fecha_inicio = $request->input('fecha_inicio');
            $fecha_fin = $request->input('fecha_fin');




            // Inicializar el array de parámetros
            $params = [];




            // Construir la consulta SQL
            $query = "
            SELECT COUNT(fec_evento) AS cantidad,
                    TO_CHAR(fec_evento, 'DD/MM/YYYY') as fec_evento
            FROM core.v_sub_voltajes
        ";




            // Añadir condiciones de fecha si están presentes
            if ($fecha_inicio) {
                $query .= " WHERE fec_evento >= :fecha_inicio ";
                $params['fecha_inicio'] = $fecha_inicio;
            } else {
                $query .= " WHERE fec_evento >= NOW() - INTERVAL '30 days'";
            }




            if ($fecha_fin) {
                $query .= "AND fec_evento <= :fecha_fin ";
                $params['fecha_fin'] = $fecha_fin;
            }




            // Añadir el GROUP BY
            $query .= " GROUP BY fec_evento
            ORDER BY fec_evento::DATE ASC;";




            // Ejecutar la consulta
            $resultadosQ41 = DB::connection($connection)->select($query, $params);




            // Verificar si hay resultados
            if (empty($resultadosQ41)) {
                return ['message' => 'No hay datos'];
            }




            return $resultadosQ41;
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }




    public function consultaCuarentayDos(Request $request, $connection) //gráfico barras sobretensiones reportes de calidad
    {
        try {
            // Obtener las fechas de inicio y fin del request
            $fecha_inicio = $request->input('fecha_inicio');
            $fecha_fin = $request->input('fecha_fin');




            // Inicializar el array de parámetros
            $params = [];




            // Construir la consulta SQL
            $query = "
            SELECT COUNT(fec_evento) AS cantidad,
                    TO_CHAR(fec_evento, 'DD/MM/YYYY') as fec_evento
            FROM core.v_sobre_voltajes
        ";




            // Añadir condiciones de fecha si están presentes
            if ($fecha_inicio) {
                $query .= " WHERE fec_evento >= :fecha_inicio ";
                $params['fecha_inicio'] = $fecha_inicio;
            } else {
                $query .= " WHERE fec_evento >= NOW() - INTERVAL '30 days'";
            }




            if ($fecha_fin) {
                $query .= "AND fec_evento <= :fecha_fin ";
                $params['fecha_fin'] = $fecha_fin;
            }




            // Añadir el GROUP BY
            $query .= " GROUP BY fec_evento
            ORDER BY fec_evento::DATE ASC;";




            // Ejecutar la consulta
            $resultadosQ42 = DB::connection($connection)->select($query, $params);




            // Verificar si hay resultados
            if (empty($resultadosQ42)) {
                return ['message' => 'No hay datos'];
            }




            return $resultadosQ42;
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }








    public function consultaCuarentayTres(Request $request, $connection) //ratio cortes reportes de calidad
    {
        try {
            // Obtener las fechas de inicio y fin del request
            $fecha_inicio = $request->input('fecha_inicio');
            $fecha_fin = $request->input('fecha_fin');




            // Inicializar el array de parámetros
            $params = [];




            // Construir la consulta SQL
            $query = "
            WITH total_cups AS (
                SELECT count(t_cups.id_cups) AS total_cups
                FROM core.t_cups
            ),
            total_eventos AS (
                SELECT COUNT(v_apagones.fec_evento) AS total_eventos
                FROM core.v_apagones
        ";




            // Añadir condiciones de fecha si están presentes
            if ($fecha_inicio) {
                $query .= " WHERE fec_evento >= :fecha_inicio ";
                $params['fecha_inicio'] = $fecha_inicio;
            } else {
                $query .= " WHERE fec_evento >= NOW() - INTERVAL '30 days'";
            }




            if ($fecha_fin) {
                $query .= "AND fec_evento <= :fecha_fin ";
                $params['fecha_fin'] = $fecha_fin;
            }




            // Completar la consulta SQL
            $query .= "
            )
            SELECT 
                total_cups.total_cups,
                total_eventos.total_eventos,
                CASE 
                    WHEN total_eventos.total_eventos = 0 THEN NULL
                    ELSE ROUND(total_eventos.total_eventos / total_cups.total_cups::decimal, 2)
                END AS ratio
            FROM total_cups, total_eventos;
        ";




            // Ejecutar la consulta
            $resultadosQ43 = DB::connection($connection)->select($query, $params);




            // Verificar si hay resultados
            if (empty($resultadosQ43)) {
                return ['message' => 'No hay datos'];
            }
            // dd($resultadosQ43);
            return $resultadosQ43;
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }




    public function consultaCuarentayCuatro(Request $request, $connection) //ratio microcortes reportes de calidad
    {
        try {
            // Obtener las fechas de inicio y fin del request
            $fecha_inicio = $request->input('fecha_inicio');
            $fecha_fin = $request->input('fecha_fin');




            // Inicializar el array de parámetros
            $params = [];




            // Construir la consulta SQL
            $query = "
            WITH total_cups AS (
                SELECT count(t_cups.id_cups) AS total_cups
                FROM core.t_cups
            ),
            total_eventos AS (
                SELECT COUNT(v_micro_cortes.fec_evento) AS total_eventos
                FROM core.v_micro_cortes
        ";




            // Añadir condiciones de fecha si están presentes
            if ($fecha_inicio) {
                $query .= " WHERE fec_evento >= :fecha_inicio ";
                $params['fecha_inicio'] = $fecha_inicio;
            } else {
                $query .= " WHERE fec_evento >= NOW() - INTERVAL '30 days'";
            }




            if ($fecha_fin) {
                $query .= "AND fec_evento <= :fecha_fin ";
                $params['fecha_fin'] = $fecha_fin;
            }




            // Completar la consulta SQL
            $query .= "
            )
            SELECT 
                total_cups.total_cups,
                total_eventos.total_eventos,
                CASE 
                    WHEN total_eventos.total_eventos = 0 THEN NULL
                    ELSE ROUND(total_eventos.total_eventos / total_cups.total_cups::decimal, 2)
                END AS ratio
            FROM total_cups, total_eventos;
        ";




            // Ejecutar la consulta
            $resultadosQ44 = DB::connection($connection)->select($query, $params);




            // Verificar si hay resultados
            if (empty($resultadosQ44)) {
                return ['message' => 'No hay datos'];
            }
            // dd($resultadosQ44);
            return $resultadosQ44;
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }




    public function consultaCuarentayCinco(Request $request, $connection) //ratio subtensiones reportes de calidad
    {
        try {
            // Obtener las fechas de inicio y fin del request
            $fecha_inicio = $request->input('fecha_inicio');
            $fecha_fin = $request->input('fecha_fin');




            // Inicializar el array de parámetros
            $params = [];




            // Construir la consulta SQL
            $query = "
            WITH total_cups AS (
                SELECT count(t_cups.id_cups) AS total_cups
                FROM core.t_cups
            ),
            total_eventos AS (
                SELECT COUNT(v_sub_voltajes.fec_evento) AS total_eventos
                FROM core.v_sub_voltajes
        ";




            // Añadir condiciones de fecha si están presentes
            if ($fecha_inicio) {
                $query .= " WHERE fec_evento >= :fecha_inicio ";
                $params['fecha_inicio'] = $fecha_inicio;
            } else {
                $query .= " WHERE fec_evento >= NOW() - INTERVAL '30 days'";
            }




            if ($fecha_fin) {
                $query .= "AND fec_evento <= :fecha_fin ";
                $params['fecha_fin'] = $fecha_fin;
            }




            // Completar la consulta SQL
            $query .= "
            )
            SELECT 
                total_cups.total_cups,
                total_eventos.total_eventos,
                CASE 
                    WHEN total_eventos.total_eventos = 0 THEN NULL
                    ELSE ROUND(total_eventos.total_eventos / total_cups.total_cups::decimal, 2)
                END AS ratio
            FROM total_cups, total_eventos;
        ";




            // Ejecutar la consulta
            $resultadosQ45 = DB::connection($connection)->select($query, $params);




            // Verificar si hay resultados
            if (empty($resultadosQ45)) {
                return ['message' => 'No hay datos'];
            }
            // dd($resultadosQ45);
            return $resultadosQ45;
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }




    public function consultaCuarentaySeis(Request $request, $connection) //ratio sobretensiones reportes de calidad
    {
        try {
            // Obtener las fechas de inicio y fin del request
            $fecha_inicio = $request->input('fecha_inicio');
            $fecha_fin = $request->input('fecha_fin');




            // Inicializar el array de parámetros
            $params = [];




            // Construir la consulta SQL
            $query = "
            WITH total_cups AS (
                SELECT count(t_cups.id_cups) AS total_cups
                FROM core.t_cups
            ),
            total_eventos AS (
                SELECT COUNT(v_sobre_voltajes.fec_evento) AS total_eventos
                FROM core.v_sobre_voltajes
        ";




            // Añadir condiciones de fecha si están presentes
            if ($fecha_inicio) {
                $query .= " WHERE fec_evento >= :fecha_inicio ";
                $params['fecha_inicio'] = $fecha_inicio;
            } else {
                $query .= " WHERE fec_evento >= NOW() - INTERVAL '30 days'";
            }




            if ($fecha_fin) {
                $query .= "AND fec_evento <= :fecha_fin ";
                $params['fecha_fin'] = $fecha_fin;
            }




            // Completar la consulta SQL
            $query .= "
            )
            SELECT 
                total_cups.total_cups,
                total_eventos.total_eventos,
                CASE 
                    WHEN total_eventos.total_eventos = 0 THEN NULL
                    ELSE ROUND(total_eventos.total_eventos / total_cups.total_cups::decimal, 2)
                END AS ratio
            FROM total_cups, total_eventos;
        ";




            // Ejecutar la consulta
            $resultadosQ46 = DB::connection($connection)->select($query, $params);




            // Verificar si hay resultados
            if (empty($resultadosQ46)) {
                return ['message' => 'No hay datos'];
            }
            // dd($resultadosQ46);
            return $resultadosQ46;
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }




    public function consultaCuarentaySiete($id_ct, $connection, Request $request) //porcentaje desequilibrio
    {
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');




        if ($id_ct) {
            $query = "
            SELECT 
                ROUND(MAX(tsv.pct_deseq_voltaje)::numeric, 2) AS max_pct_deseq_voltaje, 
                ROUND(MIN(tsv.pct_deseq_voltaje)::numeric, 2) AS min_pct_deseq_voltaje, 
                ROUND(AVG(tsv.pct_deseq_voltaje)::numeric, 2) AS avg_pct_deseq_voltaje, 
                ROUND(MAX(tsv.pct_deseq_corriente)::numeric, 2) AS max_pct_deseq_corriente, 
                ROUND(MIN(tsv.pct_deseq_corriente)::numeric, 2) AS min_pct_deseq_corriente, 
                ROUND(AVG(tsv.pct_deseq_corriente)::numeric, 2) AS avg_pct_deseq_corriente, 
                tc.id_ct
            FROM 
                core.t_supervisores_voltajes tsv
            JOIN 
                core.t_concentradores tc ON tsv.id_cnc = tc.id_cnc
            WHERE 
                tc.id_ct = :id_ct ";




            if ($fecha_inicio && $fecha_fin) {
                $query .= "
                    AND 
                tsv.fec_registro BETWEEN :fecha_inicio AND :fecha_fin
            GROUP BY 
                tc.id_ct
            ";
                $params = ['id_ct' => $id_ct, 'fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin];
            } else {
                $query .= "
                AND 
                        tsv.fec_registro >= (
                            SELECT 
                                MAX(fec_registro) 
                            FROM 
                                core.t_supervisores_voltajes
                        ) - INTERVAL '48 hours'
                    GROUP BY tc.id_ct";
                $params = ['id_ct' => $id_ct];
            }




            $resultadosQ47 = DB::connection($connection)->select($query, $params);
            // dd($resultadosQ47);




            return $resultadosQ47 ?: [];
        }
    }




    public function consultaCuarentayOcho(Request $request, $connection) // porcentaje desequilibrio por CT para reportescalidad
    {
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');




        try {
            $query = "
            SELECT 
                ROUND(MAX(tsv.pct_deseq_voltaje)::numeric, 2) AS max_pct_deseq_voltaje, 
                ROUND(MIN(tsv.pct_deseq_voltaje)::numeric, 2) AS min_pct_deseq_voltaje, 
                ROUND(AVG(tsv.pct_deseq_voltaje)::numeric, 2) AS avg_pct_deseq_voltaje, 
                ROUND(MAX(tsv.pct_deseq_corriente)::numeric, 2) AS max_pct_deseq_corriente, 
                ROUND(MIN(tsv.pct_deseq_corriente)::numeric, 2) AS min_pct_deseq_corriente, 
                ROUND(AVG(tsv.pct_deseq_corriente)::numeric, 2) AS avg_pct_deseq_corriente, 
                tc.id_ct, t_ct.nom_ct
            FROM 
                core.t_supervisores_voltajes tsv
            JOIN 
                core.t_concentradores tc ON tsv.id_cnc = tc.id_cnc
            JOIN 
                core.t_ct ON tc.id_ct = t_ct.id_ct
            ";




            $params = [];




            if ($fecha_inicio && $fecha_fin) {
                $query .= "
                WHERE 
                    tsv.fec_registro BETWEEN :fecha_inicio AND :fecha_fin
                ";
                $params = ['fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin];
            } else {
                $query .= "
                WHERE 
                    tsv.fec_registro >= (
                        SELECT 
                            MAX(fec_registro) 
                        FROM 
                            core.t_supervisores_voltajes
                    ) - INTERVAL '48 hours'
                ";
            }




            $query .= "
            GROUP BY 
                tc.id_ct, t_ct.nom_ct
            ";




            // Depurar la consulta SQL y los parámetros
            // dd($query, $params);




            $resultadosQ48 = DB::connection($connection)->select($query, $params);
            return $resultadosQ48 ?: [];
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos', 'error' => $e->getMessage()];
        }
    }












    public function consultaCuarentayNueve(Request $request, $connection)
    {
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');




        try {
            $query = "
        SELECT 
            t_supervisores_voltajes.id_cnc,
            tc.id_ct,
            tct.nom_ct,  
            id_svr,
            MIN(val_voltaje_1) AS min_volt1,
            MAX(val_voltaje_1) AS max_volt1,
            CEIL(AVG(val_voltaje_1)) AS prom_volt1,
            MIN(val_voltaje_2) AS min_volt2,
            MAX(val_voltaje_2) AS max_volt2,
            CEIL(AVG(val_voltaje_2)) AS prom_volt2,
            MIN(val_voltaje_3) AS min_volt3,
            MAX(val_voltaje_3) AS max_volt3,
            CEIL(AVG(val_voltaje_3)) AS prom_volt3
        FROM 
            core.t_supervisores_voltajes
        JOIN 
            core.t_concentradores tc ON t_supervisores_voltajes.id_cnc = tc.id_cnc
        JOIN 
            core.t_ct tct ON tc.id_ct = tct.id_ct  -- Agregamos el JOIN con la tabla t_ct
        ";




            $params = [];




            if ($fecha_inicio && $fecha_fin) {
                $query .= "
            WHERE 
                fec_registro BETWEEN :fecha_inicio AND :fecha_fin
            ";
                $params = ['fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin];
            } else {
                $query .= "
            WHERE 
                t_supervisores_voltajes.fec_registro >= (
                    SELECT 
                        MAX(fec_registro) 
                    FROM 
                        core.t_supervisores_voltajes
                ) - INTERVAL '48 hours'
            ";
            }




            $query .= "
        GROUP BY 
            t_supervisores_voltajes.id_cnc, id_svr, tc.id_ct, tct.nom_ct
        ";




            $resultadosQ49 = DB::connection($connection)->select($query, $params);
            // dd($resultadosQ49);
            return $resultadosQ49 ?: [];
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos', 'error' => $e->getMessage()];
        }
    }








    public function consultaCincuenta($id_ct, $connection, Request $request) //NIVELES DE TENSION PARA EL MAPA
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_valores_instantaneos') &&
                Schema::connection($connection)->hasTable('t_cups')
            ) {
                // Obtener las fechas de inicio y fin del request
                $fecha_inicio = $request->input('fecha_inicio');
                $fecha_fin = $request->input('fecha_fin');

                // Construir la consulta SQL con las fechas
                $query = "
                SELECT core.t_valores_instantaneos.id_cups,
                    round(avg(L1v)) as avg_L1v,
                    max(L1v) as max_L1v,
                    min(L1v) as min_L1v,
                    count(*) as total_lecturas,
                    dir_cups,
                    nom_cups,
                    lat_cups,
                    lon_cups,
                    ind_autoconsumo,
                    core.t_cups.id_cnt,
       TO_CHAR(MAX(core.t_valores_instantaneos.fec_lectura), 'DD/MM/YYYY') as ultima_fecha
                FROM core.t_valores_instantaneos
                INNER JOIN core.t_cups
                    ON core.t_valores_instantaneos.id_cups = core.t_cups.id_cups
                WHERE core.t_cups.id_ct = :id_ct
                ";

                // Añadir condiciones de fecha si están presentes
                $params = ['id_ct' => $id_ct];
                if ($fecha_inicio && $fecha_fin) {
                    $query .= "
                    AND core.t_valores_instantaneos.fec_lectura BETWEEN :fecha_inicio AND :fecha_fin
                    ";
                    $params['fecha_inicio'] = $fecha_inicio;
                    $params['fecha_fin'] = $fecha_fin;
                }

                // Agrupar por id_cups y los datos necesarios
                $query .= "
                GROUP BY core.t_valores_instantaneos.id_cups, dir_cups, nom_cups, core.t_cups.id_cnt, lat_cups, lon_cups, ind_autoconsumo
                ORDER BY avg_L1v    
                ";

                // Ejecutar la consulta
                $resultadosQ50 = DB::connection($connection)->select($query, $params);
                // dd($resultadosQ50);








                return $resultadosQ50 ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'Error: ' . $e->getMessage()];
        }
    }
















    public function consultaCincuentayUno(Request $request, $connection) // Niveles de tensión para reportes de calidad
    {
        try {
            // Verificar que las tablas existen
            if (
                Schema::connection($connection)->hasTable('t_valores_instantaneos') &&
                Schema::connection($connection)->hasTable('t_cups')
            ) {
                // Obtener las fechas de inicio y fin del request, si están presentes
                $fecha_inicio = $request->input('fecha_inicio');
                $fecha_fin = $request->input('fecha_fin');
    
                // Inicializar array de parámetros
                $params = [];
    
                // Construir la consulta SQL
                $query = "
                    SELECT 
                        vi.id_cups,
                        tc.dir_cups,
                        tc.nom_cups,
                        tc.id_cnt,
                        TO_CHAR(MAX(vi.fec_lectura), 'DD/MM/YYYY') as fec_lectura,
                        ROUND(AVG(vi.L1v)) AS round,
                        MAX(vi.L1v) AS max,
                        MIN(vi.L1v) AS min,
                        COUNT(*) AS count
                    FROM core.t_valores_instantaneos vi
                    JOIN core.t_cups tc 
                        ON vi.id_cups = tc.id_cups
                    WHERE 1 = 1
                ";
    
                // Añadir condiciones de fecha si están presentes
                if ($fecha_inicio && $fecha_fin) {
                    $query .= "
                        AND vi.fec_lectura BETWEEN :fecha_inicio AND :fecha_fin
                    ";
                    $params['fecha_inicio'] = $fecha_inicio;
                    $params['fecha_fin'] = $fecha_fin;
                } else {
                    $query .= "
                        AND vi.fec_lectura >= CURRENT_DATE - INTERVAL '7 days'
                    ";
                }
    
                // Agrupar por id_cups y los datos necesarios
                $query .= "
                    GROUP BY vi.id_cups, tc.dir_cups, tc.nom_cups, tc.id_cnt
                ";
    
                // Ejecutar la consulta
                $resultadosQ51 = DB::connection($connection)->select($query, $params);
                // dd($resultadosQ51);

                // Retornar los resultados
                return $resultadosQ51 ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'Error: ' . $e->getMessage()];
        }
    }
    

    //CONSULTAS PARA REPORTES INVENTARIO
    public function consultaCincuentayDos($connection)
    {
        try {
            // Realiza la consulta, seleccionando las columnas necesarias
            // y ordenando por la fecha original
            $resultadosQ52 = DB::connection($connection)
                ->select("
                    SELECT 
                        id_cups, 
                        id_cnt, 
                        TO_CHAR(fec_evento::DATE, 'DD/MM/YYYY') as fec_evento,  -- Formatea la fecha
                        hor_evento, 
                        txt_adicionales_1, 
                        txt_adicionales_2 
                    FROM core.v_actualizaciones_fw
                    ORDER BY fec_evento::DATE DESC;  -- Ordena por la fecha original
                ");
    
            $resultadosQ52Collection = new Collection($resultadosQ52);
            $currentPage = LengthAwarePaginator::resolveCurrentPage('page_q52');
            $perPage = 100; // Número de elementos por página
            $currentItems = $resultadosQ52Collection->slice(($currentPage - 1) * $perPage, $perPage)->all();


                // Crear paginador manualmente
                $resultadosQ52 = new LengthAwarePaginator($currentItems, count($resultadosQ52Collection), $perPage, $currentPage, [
                    'path' => request()->url(),
                    'query' => request()->query(),
                    'pageName' => 'page_q52'
                ]);
    
            // Retorna los resultados formateados o un array vacío si no hay
            return $resultadosQ52 ?: [];
        } catch (\Exception $e) {
            // Captura cualquier excepción y maneja el error aquí
            return "Error en la consulta: " . $e->getMessage();
        }
    }

    public function exportReportesInventarioFW(Request $request)
    {
        try {
            $user = auth()->user();
            $connection = 'pgsql' . '-' . strtolower($user->nom_distribuidora);
            // NUEVO: Tipo de archivo ('excel' por default)
            $format = $request->input('format', 'excel'); 
            $extension = $format === 'csv' ? 'csv' : 'xlsx';
            $exportFormat = $format === 'csv' ? ExcelFormat::CSV : ExcelFormat::XLSX;
            // Realiza la consulta, seleccionando las columnas necesarias
            // y ordenando por la fecha original
            $exportReportesInventarioFW = DB::connection($connection)
                ->select("
                    SELECT 
                        id_cups, 
                        id_cnt, 
                        TO_CHAR(fec_evento::DATE, 'DD/MM/YYYY') as fec_evento,  -- Formatea la fecha
                        hor_evento, 
                        txt_adicionales_1, 
                        txt_adicionales_2 
                    FROM core.v_actualizaciones_fw
                    ORDER BY fec_evento::DATE DESC;  -- Ordena por la fecha original
                ");
    
            if($exportReportesInventarioFW) {
                return Excel::download(new ReportesInventarioFWExport($exportReportesInventarioFW), 'reportes_actualizaciones.' . $extension, $exportFormat);
            } else {
                return response()->json(['message' => 'No hay datos'], 404);
            }
        } catch (\Exception $e) {
            // Captura cualquier excepción y maneja el error aquí
            return "Error en la consulta: " . $e->getMessage();
        }
    }
    

    public function consultaCincuentayTres($connection) // kpi total actualizaciones
    {
        try {
            // Realiza la consulta
            $resultadosQ53 = DB::connection($connection)
                ->select("
                   SELECT COUNT(*)
                        FROM core.v_actualizaciones_fw;
                ");


            //dd($resultadosQ53);
            // Verifica si hay resultados
            return $resultadosQ53 ?: [];
        } catch (\Exception $e) {
            // Captura cualquier excepción y maneja el error aquí
            return "Error en la consulta: " . $e->getMessage();
        }
    }

    public function consultaCincuentayCuatro($connection) // kpi total actualizaciones por mes para grafico de barras
    {
        try {
            // Realiza la consulta
            $resultadosQ54 = DB::connection($connection)
                ->select("
                    SELECT 
                        TO_CHAR(DATE_TRUNC('month', fec_evento), 'DD/MM/YYYY') AS mes,
                        COUNT(*) AS actualizaciones
                    FROM 
                        core.v_actualizaciones_fw
                    WHERE 
                        fec_evento >= (CURRENT_DATE - INTERVAL '12 months')
                    GROUP BY 
                        mes
                    ORDER BY 
                        mes;
                ");


            //dd($resultadosQ54);
            // Verifica si hay resultados
            return $resultadosQ54 ?: [];
        } catch (\Exception $e) {
            // Captura cualquier excepción y maneja el error aquí
            return "Error en la consulta: " . $e->getMessage();
        }
    }

    public function consultaCincuentayCinco($connection) // tabla modelos contadores
    {
        try {
            // Realiza la consulta
            $resultadosQ55 = DB::connection($connection)
                ->select("
                   SELECT * FROM core.v_contadores_modelos;
                ");

            $resultadosQ55Collection = new Collection($resultadosQ55);
            $currentPage = LengthAwarePaginator::resolveCurrentPage('page_q55');
            $perPage = 100; // Número de elementos por página
            $currentItems = $resultadosQ55Collection->slice(($currentPage - 1) * $perPage, $perPage)->all();

            $resultadosQ55 = new LengthAwarePaginator($currentItems, count($resultadosQ55Collection), $perPage, $currentPage, [
                'path' => request()->url(),
                'query' => request()->query(),
                'pageName' => 'page_q55'
            ]);
            return $resultadosQ55 ?: [];
        } catch (\Exception $e) {
            // Captura cualquier excepción y maneja el error aquí
            return "Error en la consulta: " . $e->getMessage();
        }
    }

    public function exportReportesInventario(Request $request) // tabla modelos contadores
    {
        try {
            $user = auth()->user();
            $connection = 'pgsql' . '-' . strtolower($user->nom_distribuidora);
            // NUEVO: Tipo de archivo ('excel' por default)
            $format = $request->input('format', 'excel'); 
            $extension = $format === 'csv' ? 'csv' : 'xlsx';
            $exportFormat = $format === 'csv' ? ExcelFormat::CSV : ExcelFormat::XLSX;
            // Realiza la consulta
            $exportReportesInventario = DB::connection($connection)
                ->select("
                   SELECT * FROM core.v_contadores_modelos;
                ");
            if($exportReportesInventario) {
                return Excel::download(new ReportesInventarioExport($exportReportesInventario), 'reportes_inventario.' . $extension, $exportFormat);
            } else {
                return response()->json(['message' => 'No hay datos'], 404);
            }
        } catch (\Exception $e) {
            // Captura cualquier excepción y maneja el error aquí
            return "Error en la consulta: " . $e->getMessage();
        }
    }

    public function consultaCincuentaySeis($connection) // grafico tarta des_companion
    {
        try {
            // Realiza la consulta
            $resultadosQ56 = DB::connection($connection)
                ->select("
                   SELECT des_companion, COUNT(*) AS count
                    FROM core.v_contadores_modelos
                    GROUP BY des_companion;

                ");

            //dd($resultadosQ56);
            // Verifica si hay resultados
            return $resultadosQ56 ?: [];
        } catch (\Exception $e) {
            // Captura cualquier excepción y maneja el error aquí
            return "Error en la consulta: " . $e->getMessage();
        }
    }

    public function consultaCincuentaySiete($connection) // grafico tarta des_companion
    {
        try {
            // Realiza la consulta
            $resultadosQ57 = DB::connection($connection)
                ->select("
                   SELECT nom_fabricante, COUNT(*) AS count
                    FROM core.v_contadores_modelos
                    GROUP BY nom_fabricante;
                ");

            //dd($resultadosQ57);
            // Verifica si hay resultados
            return $resultadosQ57 ?: [];
        } catch (\Exception $e) {
            // Captura cualquier excepción y maneja el error aquí
            return "Error en la consulta: " . $e->getMessage();
        }
    }

    public function consultaCincuentayOcho(Request $request, $connection) // reportes curvas horarias
    {
        try {
            // Verificar que las tablas existen
            if (
                Schema::connection($connection)->hasTable('t_consumos_horarios') &&
                Schema::connection($connection)->hasTable('t_cups')
            ) {
                // Obtener las fechas de inicio y fin del request, si están presentes
                $fecha_inicio = $request->input('fecha_inicio');
                $fecha_fin = $request->input('fecha_fin');
                $nom_ct = $request->input('nom_ct');
                $id_cups = $request->input('id_cups');
                $nom_cups = $request->input('nom_cups');
    
                // Si no hay fechas, establecer fechas predeterminadas (últimos 30 días)
                if (!$fecha_inicio || !$fecha_fin) {
                    $fecha_inicio = Carbon::now()->subDays(30)->format('Y-m-d');
                    $fecha_fin = Carbon::now()->format('Y-m-d'); // Fecha actual
                }
    
                // Inicializar array de parámetros
                $params = [
                    'fecha_inicio' => $fecha_inicio,
                    'fecha_fin' => $fecha_fin,
                ];
    
                // Construir la consulta SQL
                $query = "
                    WITH cups_data AS (
                        SELECT
                            cups.id_cups,
                            cups.nom_cups,
                            cups.dir_cups,
                            cups.id_ct,
                            cups.cod_poliza,
                            cups.id_cnt,
                            ct.nom_ct,
                            cups.ind_autoconsumo
                        FROM
                            core.t_cups cups
                        JOIN
                            core.t_ct ct ON cups.id_ct = ct.id_ct
                        WHERE 1 = 1 
                        ";

                if($id_cups) {
                    $query .= " AND LOWER(cups.id_cups) LIKE LOWER('%' ||:id_cups || '%') ";
                    $params['id_cups'] = "%{$id_cups}%";
                } else if($nom_ct) {
                    $query .= " AND LOWER(ct.nom_ct) LIKE LOWER('%' || :nom_ct || '%') ";
                    $params['nom_ct'] = "%{$nom_ct}%";
                } else if($nom_cups) {
                    $nom_cups = $nom_cups ? (string) $nom_cups : null;
                    $query .= " AND LOWER(cups.nom_cups) LIKE LOWER('%' || :nom_cups || '%') ";
                    $params['nom_cups'] = "%{$nom_cups}%";
                }
                            
                $query .= "
                    ),
                    consumos_data AS (
                        SELECT
                            id_cups,
                            MIN(fec_inicio) AS fec_inicio,
                            MAX(fec_fin) AS fec_fin,
                            COUNT(hor_fin) AS curvas_leidas,
                            ROUND(SUM(val_ai_h) / 1000, 2) AS total_curva_imp,
                            ROUND(SUM(val_ae_h) / 1000, 2) AS total_curva_exp,
                            COUNT(CASE WHEN val_ai_h = 0 THEN 1 END) AS curvas_sin_consumo
                        FROM
                            core.t_consumos_horarios
                        WHERE
                            fec_inicio BETWEEN :fecha_inicio AND :fecha_fin
                        GROUP BY
                            id_cups
                    )
                    SELECT
                        cd.id_cups,
                        cd.nom_cups,
                        cd.dir_cups,
                        cd.id_ct,
                        cd.id_cnt,
                        cd.ind_autoconsumo,
                        cd.nom_ct,
                        TO_CHAR(co.fec_inicio, 'DD/MM/YYYY') AS fec_inicio,
                        TO_CHAR(co.fec_fin, 'DD/MM/YYYY') AS fec_fin,
                        co.total_curva_imp,
                        co.total_curva_exp,
                        co.curvas_leidas,
                        co.curvas_sin_consumo
                    FROM
                        cups_data cd
                    LEFT JOIN
                        consumos_data co ON cd.id_cups = co.id_cups
                    ORDER BY
                        cd.id_cups ASC;

                ";
    
                // Ejecutar la consulta con los parámetros
                $res = DB::connection($connection)->select($query, $params);
                
                $resCollection = new Collection($res);
                // Obtener la página actual
                $currentPage = LengthAwarePaginator::resolveCurrentPage();
                $perPage = 100; // Número de elementos por página
                $currentItems = $resCollection->slice(($currentPage - 1) * $perPage, $perPage)->all();


                // Crear paginador manualmente
                $resultadosQ58 = new LengthAwarePaginator($currentItems, count($resCollection), $perPage, $currentPage, [
                    'path' => request()->url(),
                    'query' => request()->query()
                ]);
                //dd($resultadosQ58 instanceof LengthAwarePaginator);
            
                return $resultadosQ58 ?: ['message' => 'No hay datos'];
                
            } else {
                // Si alguna tabla no existe, retornar un mensaje de error
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'Error: ' . $e->getMessage()];
        }
    }

    public function exportCurvasHorarias(Request $request) // reportes curvas horarias
    {
        try {
            
            $user = auth()->user();
            $connection = 'pgsql' . '-' . strtolower($user->nom_distribuidora);

            if (
                Schema::connection($connection)->hasTable('t_consumos_horarios') &&
                Schema::connection($connection)->hasTable('t_cups')
            ) {
                // Obtener las fechas de inicio y fin del request, si están presentes
                $fecha_inicio = $request->input('fecha_inicio');
                $fecha_fin = $request->input('fecha_fin');
                $id_ct = $request->input('id_ct');
                $id_cups = $request->input('id_cups');
                $nom_cups = $request->input('nom_cups');
                // NUEVO: Tipo de archivo ('excel' por default)
                $format = $request->input('format', 'excel'); 
                $extension = $format === 'csv' ? 'csv' : 'xlsx';
                $exportFormat = $format === 'csv' ? ExcelFormat::CSV : ExcelFormat::XLSX;
    
                // Si no hay fechas, establecer fechas predeterminadas (últimos 30 días)
                if (!$fecha_inicio || !$fecha_fin) {
                    $fecha_inicio = Carbon::now()->subDays(30)->format('Y-m-d');
                    $fecha_fin = Carbon::now()->format('Y-m-d'); // Fecha actual
                }
    
                // Inicializar array de parámetros
                $params = [
                    'fecha_inicio' => $fecha_inicio,
                    'fecha_fin' => $fecha_fin,
                ];
    
                // Construir la consulta SQL
                $query = "
                    WITH cups_data AS (
                        SELECT
                            cups.id_cups,
                            cups.nom_cups,
                            cups.dir_cups,
                            cups.id_ct,
                            cups.cod_poliza,
                            cups.id_cnt,
                            ct.nom_ct,
                            cups.ind_autoconsumo
                        FROM
                            core.t_cups cups
                        JOIN
                            core.t_ct ct ON cups.id_ct = ct.id_ct
                        WHERE 1 = 1 
                        ";

                if($id_cups) {
                    $query .= " AND LOWER(cups.id_cups) = LOWER(:id_cups) ";
                    $params['id_cups'] = "%{$id_cups}%";
                } else if($id_ct) {
                    $query .= " AND LOWER(cups.id_ct) = LOWER(:id_ct) ";
                    $params['id_ct'] = "%{$id_ct}%";
                } else if($nom_cups) {
                    $nom_cups = $nom_cups ? (string) $nom_cups : null;
                    $query .= " AND LOWER(cups.nom_cups) LIKE LOWER('%' || :nom_cups || '%') ";
                    $params['nom_cups'] = "%{$nom_cups}%";
                }
                            
                $query .= "
                    ),
                    consumos_data AS (
                        SELECT
                            id_cups,
                            MIN(fec_inicio) AS fec_inicio,
                            MAX(fec_fin) AS fec_fin,
                            COUNT(hor_fin) AS curvas_leidas,
                            ROUND(SUM(val_ai_h) / 1000, 2) AS total_curva_imp,
                            ROUND(SUM(val_ae_h) / 1000, 2) AS total_curva_exp,
                            COUNT(CASE WHEN val_ai_h = 0 THEN 1 END) AS curvas_sin_consumo
                        FROM
                            core.t_consumos_horarios
                        WHERE
                            fec_inicio BETWEEN :fecha_inicio AND :fecha_fin
                        GROUP BY
                            id_cups
                    )
                    SELECT
                        cd.id_cups,
                        cd.nom_cups,
                        cd.dir_cups,
                        cd.id_ct,
                        cd.id_cnt,
                        cd.ind_autoconsumo,
                        cd.nom_ct,
                        TO_CHAR(co.fec_inicio, 'DD/MM/YYYY') AS fec_inicio,
                        TO_CHAR(co.fec_fin, 'DD/MM/YYYY') AS fec_fin,
                        co.total_curva_imp,
                        co.total_curva_exp,
                        co.curvas_leidas,
                        co.curvas_sin_consumo
                    FROM
                        cups_data cd
                    LEFT JOIN
                        consumos_data co ON cd.id_cups = co.id_cups
                    ORDER BY
                        cd.id_cups ASC;

                ";
    
                $exportCurvasHorarias = DB::connection($connection)->select($query, $params);

            // Devuelve el archivo Excel si los datos existen
            if ($exportCurvasHorarias) {
                return Excel::download(new CurvasHorariasExport($exportCurvasHorarias), 'curvas_horarias.' . $extension, $exportFormat);
            } else {
                return response()->json(['message' => 'No hay datos'], 404);
            }
                
            } else {
                // Si alguna tabla no existe, retornar un mensaje de error
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'Error: ' . $e->getMessage()];
        }
    }



    public function getNumEventos(Request $request, $connection) {
        try {
            // Verificar que las tablas existen
            if (
                Schema::connection($connection)->hasTable('t_consumos_horarios') &&
                Schema::connection($connection)->hasTable('t_cups')
            ) {
                // Obtener las fechas de inicio y fin del request, si están presentes
                $fecha_inicio = $request->input('fecha_inicio');
                $fecha_fin = $request->input('fecha_fin');
                $descripcion = $request->input('descripcion');

                $params = [];
    
                // Construir la consulta SQL
                $query = "
                    SELECT COUNT(*) as total_eventos
                    FROM core.t_eventos_contador
                    JOIN core.t_descripcion_eventos_contador 
                        ON t_eventos_contador.grp_evento = t_descripcion_eventos_contador.grp_evento
                        AND t_eventos_contador.cod_evento = t_descripcion_eventos_contador.cod_evento
                    WHERE 1=1 
                ";

                // Agregar filtro por descripción si existe
                if (!empty($descripcion)) {
                    $query .= " AND t_descripcion_eventos_contador.des_evento_contador ILIKE :descripcion ";
                    $params['descripcion'] = "%{$descripcion}%"; // Agregar '%' para buscar coincidencias parciales
                } 
                if($fecha_inicio) {
                    $query .= "
                        AND t_eventos_contador.fec_evento >= :fecha_inicio ";
                    $params['fecha_inicio'] = $fecha_inicio;
                }
                if($fecha_fin) {
                    $query .= "
                    AND t_eventos_contador.fec_evento <= :fecha_fin ;";   
                    $params['fecha_fin'] = $fecha_fin;   
                } 
    
                // Ejecutar la consulta con los parámetros
                $numeroeventos = DB::connection($connection)->select($query, $params);
                //dd($query);
                // Retornar los resultados, o un mensaje si no hay datos
                return $numeroeventos ?: ['message' => 'No hay datos'];
            } else {
                // Si alguna tabla no existe, retornar un mensaje de error
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'Error: ' . $e->getMessage()];
        }
    }



    public function getAllReportesEventos(Request $request, $connection) {
        try {
            // Verificar que las tablas existen
            if (
                Schema::connection($connection)->hasTable('t_consumos_horarios') &&
                Schema::connection($connection)->hasTable('t_cups')
            ) {
                // Obtener los parámetros del request
                $fecha_inicio = $request->input('fecha_inicio');
                $fecha_fin = $request->input('fecha_fin');
                $descripcion = $request->input('descripcion');
                
    
                $params = [];
                $query = "
                    SELECT
                        t_eventos_contador.id_cups,
                        t_eventos_contador.id_cnt,
                        TO_CHAR(t_eventos_contador.fec_evento, 'DD/MM/YYYY') as fecha,
                        t_eventos_contador.hor_evento,
                        t_eventos_contador.txt_adicionales_1,
                        t_eventos_contador.txt_adicionales_2,
                        t_descripcion_eventos_contador.des_evento_contador
                    FROM core.t_eventos_contador
                    JOIN core.t_descripcion_eventos_contador 
                        ON t_eventos_contador.grp_evento = t_descripcion_eventos_contador.grp_evento
                        AND t_eventos_contador.cod_evento = t_descripcion_eventos_contador.cod_evento
                    WHERE 1=1 
                ";
    
                // Agregar filtro por descripción si existe
                if (!empty($descripcion)) {
                    $query .= " AND t_descripcion_eventos_contador.des_evento_contador ILIKE :descripcion";
                    $params['descripcion'] = "%{$descripcion}%"; // Agregar '%' para buscar coincidencias parciales
                }
    
                // Agregar filtros de fecha
                if (!empty($fecha_inicio) && !empty($fecha_fin)) {
                    $query .= " AND t_eventos_contador.fec_evento BETWEEN :fecha_inicio AND :fecha_fin";
                    $params['fecha_inicio'] = $fecha_inicio;
                    $params['fecha_fin'] = $fecha_fin;
                } elseif (!empty($fecha_inicio)) {
                    $query .= " AND t_eventos_contador.fec_evento >= :fecha_inicio";
                    $params['fecha_inicio'] = $fecha_inicio;
                } elseif (!empty($fecha_fin)) {
                    $query .= " AND t_eventos_contador.fec_evento <= :fecha_fin";
                    $params['fecha_fin'] = $fecha_fin;
                }
                
                if(empty($fecha_fin) && empty($fecha_inicio)) {
                    $query .= " ORDER BY t_eventos_contador.fec_evento DESC, t_eventos_contador.hor_evento DESC LIMIT 500;";
                } else {
                    // Agregar orden y límite
                    $query .= " ORDER BY t_eventos_contador.fec_evento DESC, t_eventos_contador.hor_evento DESC;";
                }
    
                // Ejecutar la consulta con los parámetros correctos
                $reporteseventos = DB::connection($connection)->select($query, $params);
                
                $reporteseventosCollection = new Collection($reporteseventos);
                // Obtener la página actual
                $currentPage = LengthAwarePaginator::resolveCurrentPage();
                $perPage = 100; // Número de elementos por página
                $currentItems = $reporteseventosCollection->slice(($currentPage - 1) * $perPage, $perPage)->all();


                // Crear paginador manualmente
                $reporteseventos = new LengthAwarePaginator($currentItems, count($reporteseventosCollection), $perPage, $currentPage, [
                    'path' => request()->url(),
                    'query' => request()->query()
                ]);
    
                return $reporteseventos ?: ['message' => 'No hay datos'];
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            return ['message' => 'Error: ' . $e->getMessage()];
        }
    }

    public function exportReportesEventos(Request $request) {
        try {
            $user = auth()->user();
            $connection = 'pgsql' . '-' . strtolower($user->nom_distribuidora);
            if (
                Schema::connection($connection)->hasTable('t_consumos_horarios') &&
                Schema::connection($connection)->hasTable('t_cups')
            ) {
                // Obtener los parámetros del request
                $fecha_inicio = $request->input('fecha_inicio');
                $fecha_fin = $request->input('fecha_fin');
                $descripcion = $request->input('descripcion');
                // NUEVO: Tipo de archivo ('excel' por default)
                $format = $request->input('format', 'excel'); 
                $extension = $format === 'csv' ? 'csv' : 'xlsx';
                $exportFormat = $format === 'csv' ? ExcelFormat::CSV : ExcelFormat::XLSX;
    
                $params = [];
                $query = "
                    SELECT
                        t_eventos_contador.id_cups,
                        t_eventos_contador.id_cnt,
                        TO_CHAR(t_eventos_contador.fec_evento, 'DD/MM/YYYY') as fecha,
                        t_eventos_contador.hor_evento,
                        t_eventos_contador.txt_adicionales_1,
                        t_eventos_contador.txt_adicionales_2,
                        t_descripcion_eventos_contador.des_evento_contador
                    FROM core.t_eventos_contador
                    JOIN core.t_descripcion_eventos_contador 
                        ON t_eventos_contador.grp_evento = t_descripcion_eventos_contador.grp_evento
                        AND t_eventos_contador.cod_evento = t_descripcion_eventos_contador.cod_evento
                    WHERE 1=1 
                ";
    
                // Agregar filtro por descripción si existe
                if (!empty($descripcion)) {
                    $query .= " AND t_descripcion_eventos_contador.des_evento_contador ILIKE :descripcion";
                    $params['descripcion'] = "%{$descripcion}%"; // Agregar '%' para buscar coincidencias parciales
                }
    
                // Agregar filtros de fecha
                if (!empty($fecha_inicio) && !empty($fecha_fin)) {
                    $query .= " AND t_eventos_contador.fec_evento BETWEEN :fecha_inicio AND :fecha_fin";
                    $params['fecha_inicio'] = $fecha_inicio;
                    $params['fecha_fin'] = $fecha_fin;
                } elseif (!empty($fecha_inicio)) {
                    $query .= " AND t_eventos_contador.fec_evento >= :fecha_inicio";
                    $params['fecha_inicio'] = $fecha_inicio;
                } elseif (!empty($fecha_fin)) {
                    $query .= " AND t_eventos_contador.fec_evento <= :fecha_fin";
                    $params['fecha_fin'] = $fecha_fin;
                }
                
                if(empty($fecha_fin) && empty($fecha_inicio)) {
                    $query .= " ORDER BY t_eventos_contador.fec_evento DESC, t_eventos_contador.hor_evento DESC LIMIT 500;";
                } else {
                    // Agregar orden y límite
                    $query .= " ORDER BY t_eventos_contador.fec_evento DESC, t_eventos_contador.hor_evento DESC;";
                }
    
                // Ejecutar la consulta con los parámetros correctos
                $exportreporteseventos = DB::connection($connection)->select($query, $params);
                
                if($exportreporteseventos) {
                    return Excel::download(new ReportesEventosExport($exportreporteseventos), 'reportes_eventos.' . $extension, $exportFormat);
                } else {
                    return response()->json(['message' => 'No hay datos'], 404);
                }    
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            return ['message' => 'Error: ' . $e->getMessage()];
        }
    }


    public function getSumBalances($id_ct, Request $request, $connection) {
        try {
                if(Schema::connection($connection)->hasTable('t_cups') &&
                Schema::connection($connection)->hasTable('t_consumos_diarios')) {
                    $fecha_inicio = $request->input('fecha_inicio');
                    $fecha_fin = $request->input('fecha_fin');
                    $resultadosQ26 = $this->consultaVeintiSeis($id_ct, $connection, $request);
                    $fecha = !empty($resultadosQ26[0]->fecha) ? $resultadosQ26[0]->fecha : null;
                    
                    $params = [];
                    $query = "
                    SELECT 
                        c.nom_cups,
                        c.id_cnt,
                        d.id_cups,
                        SUM(d.val_ai_d) AS total_val_ai_d,
                        SUM(d.val_ae_d) AS total_val_ae_d
                    FROM core.t_consumos_diarios d
                    JOIN core.t_cups c ON d.id_cups = c.id_cups
                    WHERE c.id_ct = :id_ct
                    ";
    
                    $params['id_ct'] = $id_ct;
    
                    if ($fecha) {
                        $fecha = Carbon::createFromFormat('d/m/Y', $fecha)->format('Y-m-d');
                        $query .= " AND d.fec_inicio = :fecha ";
                        $params['fecha'] = $fecha;
                    } else {
                        $query .= " AND d.fec_inicio BETWEEN :fecha_inicio AND :fecha_fin "; 
                        $params['fecha_inicio'] = $fecha_inicio;
                        $params['fecha_fin'] = $fecha_fin;
                    }
    
                    $query .= " GROUP BY d.id_cups, c.id_cnt, c.nom_cups ORDER BY d.id_cups;";
    
                    $sumBalances = DB::connection($connection)->select($query, $params);
    
                    $sumBalancesCollection = new Collection($sumBalances);
                    $currentPage = LengthAwarePaginator::resolveCurrentPage();
                    $perPage = 100; // Número de elementos por página
                    $currentItems = $sumBalancesCollection->slice(($currentPage - 1) * $perPage, $perPage)->all();


                    // Crear paginador manualmente
                    $sumBalances = new LengthAwarePaginator($currentItems, count($sumBalancesCollection), $perPage, $currentPage, [
                        'path' => request()->url(),
                        'query' => request()->query()
                    ]);
                    // Return an empty array if no data is found
                    //dd($query);
                    return $sumBalances ?: ['message' => 'No hay datos'];
                }
        } catch (\Exception $e) {
            return ['message' => 'Error: ' . $e->getMessage()]; // Return an empty array instead of a string on error
        }
    
        return []; // Default return an empty array
    }


    public function exportSumBalances(Request $request) {
        try {
            $user = auth()->user();
            $connection = 'pgsql' . '-' . strtolower($user->nom_distribuidora);
                if(Schema::connection($connection)->hasTable('t_cups') &&
                Schema::connection($connection)->hasTable('t_consumos_diarios')) {
                    $fecha_inicio = $request->input('fecha_inicio');
                    $fecha_fin = $request->input('fecha_fin');
                    $id_ct = $request->input('id_ct');
                    $resultadosQ26 = $this->consultaVeintiSeis($id_ct, $connection, $request);
                    $fecha = !empty($resultadosQ26[0]->fecha) ? $resultadosQ26[0]->fecha : null;
                    // NUEVO: Tipo de archivo ('excel' por default)
                    $format = $request->input('format', 'excel'); 
                    $extension = $format === 'csv' ? 'csv' : 'xlsx';
                    $exportFormat = $format === 'csv' ? ExcelFormat::CSV : ExcelFormat::XLSX;   
    
                    $params = [];
                    $query = "
                    SELECT 
                        c.nom_cups,
                        c.id_cnt,
                        d.id_cups,
                        SUM(d.val_ai_d) AS total_val_ai_d,
                        SUM(d.val_ae_d) AS total_val_ae_d
                    FROM core.t_consumos_diarios d
                    JOIN core.t_cups c ON d.id_cups = c.id_cups
                    WHERE c.id_ct = :id_ct
                    ";
    
                    $params['id_ct'] = $id_ct;
    
                    if ($fecha_inicio && $fecha_fin) {
                        $query .= " AND d.fec_inicio >= :fecha_inicio AND d.fec_inicio <= :fecha_fin ";
                        $params['fecha_inicio'] = $fecha_inicio;
                        $params['fecha_fin'] = $fecha_fin;
                    } else {
                        $fecha = Carbon::createFromFormat('d/m/Y', $fecha)->format('Y-m-d');
                        $query .= " AND d.fec_inicio = :fecha ";
                        $params['fecha'] = $fecha;
                    }
    
                    $query .= " GROUP BY d.id_cups, c.id_cnt, c.nom_cups ORDER BY d.id_cups;";
    
                    $exportSumBalances = DB::connection($connection)->select($query, $params);
                    if($exportSumBalances) {
                        return Excel::download(new SumBalancesExport($exportSumBalances), 'consumos_cups.' . $extension, $exportFormat);
                    } else {
                        return response()->json(['message' => 'No hay datos'], 404);
                    }                    
                }
            
        } catch (\Exception $e) {
            return []; // Return an empty array instead of a string on error
        }
    
        return []; // Default return an empty array
    }
    
    

    function validarFecha($fecha) {
        try {
            // Intentar crear la fecha con el formato esperado
            Carbon::createFromFormat('d/m/Y', $fecha);
    
            // Si no hay error, la fecha es válida
            return true;
        } catch (\Exception $e) {
            // Si hay un error, la fecha es inválida
            return false;
        }
    }
    
    
    


}
