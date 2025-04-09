<?php




namespace App\Http\Controllers;




use App\Exports\ConsumosTotalesDiariosExport;
use App\Exports\CurvasHorariasCupsExport;
use App\Exports\EventosCupsExport;
use App\Exports\RegistrosMensualesExport;
use App\Models\Ct;
use App\Models\Cups;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Maatwebsite\Excel\Facades\Excel;







class CupsController extends Controller
{




    // INFORMACION DEL CUPS ------------------------------------------------
    public function informacioncups(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }


        // Obtener los valores de búsqueda
        $id_cups = $request->input('id_cups');
        $id_cnt = $request->input('id_cnt'); // Obtener el id_cnt
        $nom_cups = $request->input('nom_cups');


        // Convertir a mayúsculas si no son nulos
        if (!is_null($id_cups)) {
            $id_cups = strtoupper($id_cups);
        }


        if (!is_null($id_cnt)) {
            $id_cnt = strtoupper($id_cnt);
        }

        if (!is_null($nom_cups)) {
            $nom_cups = strtoupper($nom_cups);
        }


        // Guardar id_cups y vista actual en la sesión
        Session::put('id_cups', $id_cups);
        Session::put('id_cnt', $id_cnt);
        Session::put('nom_cups', $nom_cups);
        Session::put('vista_actual', 'informacioncups');


        // Obtener la conexión dinámica
        $connection = User::conexion();


        if ($connection == 'pgsql') {
            return view('admin');
        } else {
            // Obtener los datos de los CTs
            $ct_info = Ct::on($connection)->select('id_ct', 'nom_ct')->get();
            // dd($ct_info);


            // Realizar la consulta por ID de CUPS o ID de CNT si hay valores
            if ((!is_null($id_cups) && $id_cups !== '') || (!is_null($id_cnt) && $id_cnt !== '') || !is_null($nom_cups) && $nom_cups !== '') {
                $resultadosQ1cups = $this->consultaUnoCups($id_cups, $id_cnt, $nom_cups, $connection, $request);
            } else {
                // Si no hay valores de búsqueda, no hacer consulta
                $resultadosQ1cups = [];
            }


            // Pasar los datos a la vista
            return view('cups/informacioncups', [
                'ct_info' => $ct_info,
                'id_cups' => $id_cups,
                'id_cnt' => $id_cnt,  // Pasar el id_cnt a la vista
                'nom_cups' => $nom_cups,
                'resultadosQ1cups' => $resultadosQ1cups,
            ]);
        }
    }








    public function detallesinformacioncups(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }




        $id_cups = strtoupper($request->input('id_cups'));
        $id_cnt = strtoupper($request->input('id_cnt')); // Obtener el id_cnt
        $nom_cups = strtoupper($request->input('nom_cups'));



        // Guardar el id_ct en la sesión
        Session::put('id_cups', $id_cups);
        Session::put('id_cnt', $id_cnt);
        Session::put('nom_cups', $nom_cups);
        // Guardar el nombre de la vista actual en la sesión
        Session::put('vista_actual', 'detallesinformacioncups');




        // Obtener la conexión dinámica
        $connection = User::conexion();




        if ($connection == 'pgsql') {
            // Si la conexión es la predeterminada, retornar un mensaje de bienvenida para el admin
            return view('admin');
        } else {
            // Obtener los datos de todos los CTs
            $ct_info = Ct::on($connection)->select('id_ct', 'nom_ct')->get();




            // Si hay un valor de búsqueda, realizar la consulta por ID de CUPS
            if ($id_cups || $id_cnt || $nom_cups) {
                $resultadosQ1cups = $this->consultaUnoCups($id_cups, $id_cnt, $nom_cups, $connection, $request);
                $resultadosQ2cups = $this->consultaDosCups($id_cups, $connection, $request);
                $resultadosQ3cups = $this->consultaTresCups($id_cups, $connection, $request);
                $resultadosQ4cups = $this->consultaCuatroCups($id_cups, $connection, $request);
                $resultadosQ5cups = $this->consultaCincoCups($id_cups, $connection, $request);
                $resultadosQ27cups = $this->consultaVeintisieteCups($id_cups, $connection, $request);
                $exportRegistrosMensuales = $this->exportRegistrosMensuales($request);
            } else {
                // De lo contrario, obtener todos los resultados
                $resultadosQ1cups = [];
                $resultadosQ2cups = [];
                $resultadosQ3cups = [];
                $resultadosQ4cups = [];
                $resultadosQ5cups = [];
                $resultadosQ27cups = [];
                $exportRegistrosMensuales = [];
            }




            // Pasar los datos de los CTs a la vista
            return view('cups/detallesinformacioncups', [
                'ct_info' => $ct_info,
                'id_cups' => $id_cups,
                'id_cnt' => $id_cnt,  // Pasar el id_cnt a la vista
                'nom_cups' => $nom_cups,
                'resultadosQ1cups' => $resultadosQ1cups,
                'resultadosQ2cups' => $resultadosQ2cups,
                'resultadosQ3cups' => $resultadosQ3cups,
                'resultadosQ4cups' => $resultadosQ4cups,
                'resultadosQ5cups' => $resultadosQ5cups,
                'resultadosQ27cups' => $resultadosQ27cups,
                'exportRegistrosMensuales' => $exportRegistrosMensuales,


            ]);
        }
    }




    // EVENTOS DEL CUPS ------------------------------------------------
    public function eventoscups(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }


        // Obtener el valor de id_cups
        $id_cups = $request->input('id_cups');
        $id_cnt = $request->input('id_cnt'); // Obtener el id_cnt
        $nom_cups = $request->input('nom_cups');


        // Convertir a mayúsculas si no es nulo
        if (!is_null($id_cups)) {
            $id_cups = strtoupper($id_cups);
        }


        // Convertir a mayúsculas si no es nulo
        if (!is_null($id_cnt)) {
            $id_cnt = strtoupper($id_cnt);
        }

        // Convertir a mayúsculas si no es nulo
        if (!is_null($nom_cups)) {
            $nom_cups = strtoupper($nom_cups);
        }


        // Guardar el id_cups en la sesión
        Session::put('id_cups', $id_cups);
        Session::put('id_cnt', $id_cnt);
        Session::put('nom_cups', $nom_cups);


        // Guardar el nombre de la vista actual en la sesión
        Session::put('vista_actual', 'eventoscups');


        // Obtener la conexión dinámica
        $connection = User::conexion();


        if ($connection == 'pgsql') {
            // Si la conexión es la predeterminada, retornar un mensaje de bienvenida para el admin
            return view('admin');
        } else {
            // Obtener los datos de todos los CTs
            $ct_info = Ct::on($connection)->select('id_ct', 'nom_ct')->get();


            // Realizar la consulta por ID de CUPS o ID de CNT si hay valores
            if ((!is_null($id_cups) && $id_cups !== '') || (!is_null($id_cnt) && $id_cnt !== '')) {
                $resultadosQ1cups = $this->consultaUnoCups($id_cups, $id_cnt, $nom_cups, $connection, $request);
            } else {
                // Si no hay valores de búsqueda, no hacer consulta
                $resultadosQ1cups = [];
            }


            // Pasar los datos de los CTs a la vista
            return view('cups/eventoscups', [
                'ct_info' => $ct_info,
                'id_cups' => $id_cups,
                'id_cnt' => $id_cnt,  // Pasar el id_cnt a la vista
                'nom_cups' => $nom_cups,
                'resultadosQ1cups' => $resultadosQ1cups,
            ]);
        }
    }




    public function detalleseventoscups(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }




        $id_cups = strtoupper($request->input('id_cups'));
        $id_cnt = strtoupper($request->input('id_cnt')); // Obtener el id_cnt
        $nom_cups = strtoupper($request->input('nom_cups'));



        // Guardar el id_ct en la sesión
        Session::put('id_cups', $id_cups);
        Session::put('id_cnt', $id_cnt);
        Session::put('nom_cups', $nom_cups);
        // Guardar el nombre de la vista actual en la sesión
        Session::put('vista_actual', 'detalleseventoscups');



        // Obtener la conexión dinámica
        $connection = User::conexion();




        if ($connection == 'pgsql') {
            // Si la conexión es la predeterminada, retornar un mensaje de bienvenida para el admin
            return view('admin');
        } else {
            // Obtener los datos de todos los CTs
            $ct_info = Ct::on($connection)->select('id_ct', 'nom_ct')->get();




            // Si hay un valor de búsqueda, realizar la consulta por ID de CUPS
            if ($id_cups || $id_cnt || $nom_cups) {
                $resultadosQ1cups = $this->consultaUnoCups($id_cups, $id_cnt, $nom_cups, $connection, $request);
                $resultadosQ6cups = $this->consultaSeisCups($id_cups, $connection, $request);
                $resultadosQ7cups = $this->consultaSieteCups($id_cups, $connection, $request);
                $resultadosSumaEventos = $this->consultaSumaEventos($id_cups, $connection, $request);
            } else {
                // De lo contrario, obtener todos los resultados
                $resultadosQ1cups = [];
                $resultadosQ6cups = [];
                $resultadosQ7cups = [];
                $resultadosSumaEventos = [];
            }




            // Pasar los datos de los CTs a la vista
            return view('cups/detalleseventoscups', [
                'ct_info' => $ct_info,
                'id_cups' => $id_cups,
                'id_cnt' => $id_cnt,  // Pasar el id_cnt a la vista
                'nom_cups' => $nom_cups,
                'resultadosQ1cups' => $resultadosQ1cups,
                'resultadosQ6cups' => $resultadosQ6cups,
                'resultadosQ7cups' => $resultadosQ7cups,
                'resultadosSumaEventos' => $resultadosSumaEventos,


            ]);
        }
    }




    // CURVAS HORARIAS DEL CUPS ------------------------------------------------
    public function curvashorariascups(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }


        // Obtener el valor de id_cups
        $id_cups = $request->input('id_cups');
        $id_cnt = $request->input('id_cnt'); // Obtener el id_cnt
        $nom_cups = $request->input('nom_cups');




        // Convertir a mayúsculas si no es nulo
        if (!is_null($id_cups)) {
            $id_cups = strtoupper($id_cups);
        }


        // Convertir a mayúsculas si no es nulo
        if (!is_null($id_cnt)) {
            $id_cnt = strtoupper($id_cnt);
        }

        // Convertir a mayúsculas si no es nulo
        if (!is_null($nom_cups)) {
            $nom_cups = strtoupper($nom_cups);
        }


        // Guardar el id_cups en la sesión
        Session::put('id_cups', $id_cups);
        Session::put('id_cnt', $id_cnt);
        Session::put('nom_cups', $nom_cups);


        // Guardar el nombre de la vista actual en la sesión
        Session::put('vista_actual', 'curvashorariascups');


        // Obtener la conexión dinámica
        $connection = User::conexion();


        if ($connection == 'pgsql') {
            // Si la conexión es la predeterminada, retornar un mensaje de bienvenida para el admin
            return view('admin');
        } else {
            // Obtener los datos de todos los CTs
            $ct_info = Ct::on($connection)->select('id_ct', 'nom_ct')->get();


            // Realizar la consulta por ID de CUPS o ID de CNT si hay valores
            if ((!is_null($id_cups) && $id_cups !== '') || (!is_null($id_cnt) && $id_cnt !== '')) {
                $resultadosQ1cups = $this->consultaUnoCups($id_cups, $id_cnt, $nom_cups, $connection, $request);
            } else {
                // Si no hay valores de búsqueda, no hacer consulta
                $resultadosQ1cups = [];
            }


            // Pasar los datos de los CTs a la vista
            return view('cups/curvashorariascups', [
                'ct_info' => $ct_info,
                'id_cups' => $id_cups,
                'id_cnt' => $id_cnt,  // Pasar el id_cnt a la vista
                'nom_cups' => $nom_cups,
                'resultadosQ1cups' => $resultadosQ1cups,
            ]);
        }
    }

    public function consumodiariocups(Request $request) {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }


        // Obtener el valor de id_cups
        $id_cups = $request->input('id_cups');
        $id_cnt = $request->input('id_cnt'); // Obtener el id_cnt
        $nom_cups = $request->input('nom_cups');




        // Convertir a mayúsculas si no es nulo
        if (!is_null($id_cups)) {
            $id_cups = strtoupper($id_cups);
        }


        // Convertir a mayúsculas si no es nulo
        if (!is_null($id_cnt)) {
            $id_cnt = strtoupper($id_cnt);
        }

        // Convertir a mayúsculas si no es nulo
        if (!is_null($nom_cups)) {
            $nom_cups = strtoupper($nom_cups);
        }


        // Guardar el id_cups en la sesión
        Session::put('id_cups', $id_cups);
        Session::put('id_cnt', $id_cnt);
        Session::put('nom_cups', $nom_cups);


        // Guardar el nombre de la vista actual en la sesión
        Session::put('vista_actual', 'consumodiariocups');


        // Obtener la conexión dinámica
        $connection = User::conexion();


        if ($connection == 'pgsql') {
            // Si la conexión es la predeterminada, retornar un mensaje de bienvenida para el admin
            return view('admin');
        } else {
            // Obtener los datos de todos los CTs
            $ct_info = Ct::on($connection)->select('id_ct', 'nom_ct')->get();


            // Realizar la consulta por ID de CUPS o ID de CNT si hay valores
            if ((!is_null($id_cups) && $id_cups !== '') || (!is_null($id_cnt) && $id_cnt !== '')) {
                $resultadosQ1cups = $this->consultaUnoCups($id_cups, $id_cnt, $nom_cups, $connection, $request);
            } else {
                // Si no hay valores de búsqueda, no hacer consulta
                $resultadosQ1cups = [];
            }


            // Pasar los datos de los CTs a la vista
            return view('cups/consumodiariocups', [
                'ct_info' => $ct_info,
                'id_cups' => $id_cups,
                'id_cnt' => $id_cnt,  // Pasar el id_cnt a la vista
                'nom_cups' => $nom_cups,
                'resultadosQ1cups' => $resultadosQ1cups,
            ]);
        }
    }

    public function detallesconsumodiariocups(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }


        // Obtener el valor de id_cups
        $id_cups = $request->input('id_cups');
        $id_cnt = $request->input('id_cnt'); // Obtener el id_cnt
        $nom_cups = $request->input('nom_cups');




        // Convertir a mayúsculas si no es nulo
        if (!is_null($id_cups)) {
            $id_cups = strtoupper($id_cups);
        }


        // Convertir a mayúsculas si no es nulo
        if (!is_null($id_cnt)) {
            $id_cnt = strtoupper($id_cnt);
        }

        // Convertir a mayúsculas si no es nulo
        if (!is_null($nom_cups)) {
            $nom_cups = strtoupper($nom_cups);
        }


        // Guardar el id_cups en la sesión
        Session::put('id_cups', $id_cups);
        Session::put('id_cnt', $id_cnt);
        Session::put('nom_cups', $nom_cups);


        // Guardar el nombre de la vista actual en la sesión
        Session::put('vista_actual', 'detallesconsumodiariocups');


        // Obtener la conexión dinámica
        $connection = User::conexion();


        if ($connection == 'pgsql') {
            // Si la conexión es la predeterminada, retornar un mensaje de bienvenida para el admin
            return view('admin');
        } else {
            // Obtener los datos de todos los CTs
            $ct_info = Ct::on($connection)->select('id_ct', 'nom_ct')->get();


            // Realizar la consulta por ID de CUPS o ID de CNT si hay valores
            if ((!is_null($id_cups) && $id_cups !== '')) {
                $resultadosQ1cups = $this->consultaUnoCups($id_cups, $id_cnt, $nom_cups, $connection, $request);
                $consumoDiario = $this->getConsumoDiario($id_cups, $connection, $request);
                $consumosTotalesDiarios = $this->getConsumosTotalesDiarios($id_cups, $connection, $request);
            } else {
                // Si no hay valores de búsqueda, no hacer consulta
                $consumoDiario = [];
                $resultadosQ1cups = [];
            }


            // Pasar los datos de los CTs a la vista
            return view('cups/detallesconsumodiariocups', [
                'ct_info' => $ct_info,
                'id_cups' => $id_cups,
                'id_cnt' => $id_cnt,  // Pasar el id_cnt a la vista
                'nom_cups' => $nom_cups,
                'resultadosQ1cups' => $resultadosQ1cups,
                'consumoDiario' => $consumoDiario,
                'consumosTotalesDiarios' => $consumosTotalesDiarios,
            ]);
        }
    }






    public function detallescurvashorariascups(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }




        $id_cups = strtoupper($request->input('id_cups'));
        $id_cnt = strtoupper($request->input('id_cnt')); // Obtener el id_cnt
        $nom_cups = strtoupper($request->input('nom_cups'));



        // Guardar el id_ct en la sesión
        Session::put('id_cups', $id_cups);
        Session::put('id_cnt', $id_cnt);
        Session::put('nom_cups', $nom_cups);
        // Guardar el nombre de la vista actual en la sesión
        Session::put('vista_actual', 'detallescurvashorariascups');




        // Obtener la conexión dinámica
        $connection = User::conexion();




        if ($connection == 'pgsql') {
            // Si la conexión es la predeterminada, retornar un mensaje de bienvenida para el admin
            return view('admin');
        } else {
            // Obtener los datos de todos los CTs
            $ct_info = Ct::on($connection)->select('id_ct', 'nom_ct')->get();




            // Si hay un valor de búsqueda, realizar la consulta por ID de CUPS
            if ($id_cups || $id_cnt || $nom_cups) {
                $resultadosQ1cups = $this->consultaUnoCups($id_cups, $id_cnt, $nom_cups, $connection, $request);
                $resultadosQ8cups = $this->consultaOchoCups($id_cups, $connection, $request);
                $resultadosQ9cups = $this->consultaNueveCups($id_cups, $connection, $request);
                $resultadosQ10cups = $this->consultaDiezCups($id_cups, $connection, $request);
                $resultadosQ11cups = $this->consultaOnceCups($id_cups, $connection, $request);
                $resultadosQ12cups = $this->consultaDoceCups($id_cups, $connection, $request);
                $resultadosQ13cups = $this->consultaTreceCups($id_cups, $connection, $request);
            } else {
                // De lo contrario, obtener todos los resultados
                $resultadosQ1cups = [];
                $resultadosQ8cups = [];
                $resultadosQ9cups = [];
                $resultadosQ10cups = [];
                $resultadosQ11cups = [];
                $resultadosQ12cups = [];
                $resultadosQ13cups = [];
            }


            // Pasar los datos de los CTs a la vista
            return view('cups/detallescurvashorariascups', [
                'ct_info' => $ct_info,
                'id_cups' => $id_cups,
                'id_cnt' => $id_cnt,  // Pasar el id_cnt a la vista
                'nom_cups' => $nom_cups,
                'resultadosQ1cups' => $resultadosQ1cups,
                'resultadosQ8cups' => $resultadosQ8cups,
                'resultadosQ9cups' => $resultadosQ9cups,
                'resultadosQ10cups' => $resultadosQ10cups,
                'resultadosQ11cups' => $resultadosQ11cups,
                'resultadosQ12cups' => $resultadosQ12cups,
                'resultadosQ13cups' => $resultadosQ13cups,
            ]);
        }
    }




    // CURVAS HORARIAS DEL CUPS ------------------------------------------------
    public function energiacups(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }


        // Obtener el valor de id_cups
        $id_cups = $request->input('id_cups');
        $id_cnt = $request->input('id_cnt'); // Obtener el id_cnt
        $nom_cups = $request->input('nom_cups');




        // Convertir a mayúsculas si no es nulo
        if (!is_null($id_cups)) {
            $id_cups = strtoupper($id_cups);
        }


        // Convertir a mayúsculas si no es nulo
        if (!is_null($id_cnt)) {
            $id_cnt = strtoupper($id_cnt);
        }

        // Convertir a mayúsculas si no es nulo
        if (!is_null($nom_cups)) {
            $nom_cups = strtoupper($nom_cups);
        }


        // Guardar el id_cups en la sesión
        Session::put('id_cups', $id_cups);
        Session::put('id_cnt', $id_cnt);
        Session::put('nom_cups', $nom_cups);


        // Guardar el nombre de la vista actual en la sesión
        Session::put('vista_actual', 'energiacups');


        // Obtener la conexión dinámica
        $connection = User::conexion();


        if ($connection == 'pgsql') {
            // Si la conexión es la predeterminada, retornar un mensaje de bienvenida para el admin
            return view('admin');
        } else {
            // Obtener los datos de todos los CTs
            $ct_info = Ct::on($connection)->select('id_ct', 'nom_ct')->get();


            // Realizar la consulta por ID de CUPS o ID de CNT si hay valores
            if ((!is_null($id_cups) && $id_cups !== '') || (!is_null($id_cnt) && $id_cnt !== '')) {
                $resultadosQ1cups = $this->consultaUnoCups($id_cups, $id_cnt, $nom_cups, $connection, $request);
            } else {
                // Si no hay valores de búsqueda, no hacer consulta
                $resultadosQ1cups = [];
            }


            // Pasar los datos de los CTs a la vista
            return view('cups/energiacups', [
                'ct_info' => $ct_info,
                'id_cups' => $id_cups,
                'id_cnt' => $id_cnt,  // Pasar el id_cnt a la vista
                'nom_cups' => $nom_cups,
                'resultadosQ1cups' => $resultadosQ1cups,
            ]);
        }
    }






    public function detallesenergiacups(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }


        $id_cups = strtoupper($request->input('id_cups'));
        $id_cnt = strtoupper($request->input('id_cnt')); // Obtener el id_cnt
        $nom_cups = strtoupper($request->input('nom_cups')); // Obtener el id_cnt




        // Guardar el nombre de la vista actual en la sesión
        Session::put('vista_actual', 'detallesenergiacups');


        // Guardar el id_ct en la sesión
        Session::put('id_cups', $id_cups);
        Session::put('id_cnt', $id_cnt);
        Session::put('nom_cups', $nom_cups);


        // Obtener la conexión dinámica
        $connection = User::conexion();


        if ($connection == 'pgsql') {
            // Si la conexión es la predeterminada, retornar un mensaje de bienvenida para el admin
            return view('admin');
        } else {
            // Obtener los datos de todos los CTs
            $ct_info = Ct::on($connection)->select('id_ct', 'nom_ct')->get();




            // Si hay un valor de búsqueda, realizar la consulta por ID de CUPS
            if ($id_cups || $id_cnt) {
                $resultadosQ1cups = $this->consultaUnoCups($id_cups, $id_cnt, $nom_cups, $connection, $request);
                $resultadosQ14cups = $this->consultaCatorceCups($id_cups, $connection, $request);
                $resultadosQ15cups = $this->consultaQuinceCups($id_cups, $connection, $request);
                $resultadosQ16cups = $this->consultaDieciseisCups($id_cups, $connection, $request);
                $resultadosQ17cups = $this->consultaDiecisieteCups($id_cups, $connection, $request);
                $resultadosQ18cups = $this->consultaDieciochoCups($id_cups, $connection, $request);
                $resultadosQ19cups = $this->consultaDiecinueveCups($id_cups, $connection, $request);
                $resultadosQ20cups = $this->consultaVeinteCups($id_cups, $connection, $request);
                $resultadosQ21cups = $this->consultaVeintiUnoCups($id_cups, $connection, $request);
                $resultadosQ22cups = $this->consultaVeintiDosCups($id_cups, $connection, $request);
                $resultadosQ23cups = $this->consultaVeintiTresCups($id_cups, $connection, $request);
                $resultadosQ24cups = $this->consultaVeintiCuatroCups($id_cups, $connection, $request);
                $resultadosQ26cups = $this->consultaVeintiSeisCups($id_cups, $connection, $request);
            } else {
                // De lo contrario, obtener todos los resultados
                $resultadosQ1cups = [];
                $resultadosQ14cups = [];
                $resultadosQ15cups = [];
                $resultadosQ16cups = [];
                $resultadosQ17cups = [];
                $resultadosQ18cups = [];
                $resultadosQ19cups = [];
                $resultadosQ20cups = [];
                $resultadosQ21cups = [];
                $resultadosQ22cups = [];
                $resultadosQ23cups = [];
                $resultadosQ24cups = [];
                $resultadosQ26cups = [];
            }


            // Pasar los datos de los CTs a la vista
            return view('cups/detallesenergiacups', [
                'ct_info' => $ct_info,
                'id_cups' => $id_cups,
                'id_cnt' => $id_cnt,  // Pasar el id_cnt a la vista
                'nom_cups' => $nom_cups,
                'resultadosQ1cups' => $resultadosQ1cups,
                'resultadosQ14cups' => $resultadosQ14cups,
                'resultadosQ15cups' => $resultadosQ15cups,
                'resultadosQ16cups' => $resultadosQ16cups,
                'resultadosQ17cups' => $resultadosQ17cups,
                'resultadosQ18cups' => $resultadosQ18cups,
                'resultadosQ19cups' => $resultadosQ19cups,
                'resultadosQ20cups' => $resultadosQ20cups,
                'resultadosQ21cups' => $resultadosQ21cups,
                'resultadosQ22cups' => $resultadosQ22cups,
                'resultadosQ23cups' => $resultadosQ23cups,
                'resultadosQ24cups' => $resultadosQ24cups,
                'resultadosQ26cups' => $resultadosQ26cups,
            ]);
        }
    }




    //CONSULTAS:
    public function consultaUnoCups($id_cups, $id_cnt, $nom_cups, $connection, Request $request)
    {
        if (Schema::connection($connection)->hasTable('t_cups')) {
            // Convertir a mayúsculas si no son nulos
            if (!is_null($id_cups)) {
                $id_cups = strtoupper($id_cups);
            }


            if (!is_null($id_cnt)) {
                $id_cnt = strtoupper($id_cnt);
            }

            if (!is_null($nom_cups)) {
                $nom_cups = strtoupper($nom_cups);
            }


            // Obtener el valor de autoconsumo del request
            $autoconsumo = $request->has('autoconsumo') ? $request->input('autoconsumo') : null;


            // Iniciar la consulta base
            $query = '
           SELECT
                cups.id_cups,
                cups.nom_cups,
                cups.dir_cups,
                cups.cp_cups,
                cups.cups_estado,
                cups.id_ct,
                cups.tip_tarifa,
                cups.val_potencia_contratada,
                cups.cod_poliza,
                cups.id_cnt,
                cups.id_linea,
                cups.ind_maximetro,
                cups.ind_autoconsumo,
                ct.nom_ct  
            FROM
                core.t_cups cups
            JOIN
                core.t_ct ct ON cups.id_ct = ct.id_ct  
            WHERE 1 = 1';  // Siempre cierto para concatenar condiciones dinámicamente


            $bindings = [];


            // Añadir condición por id_cups si está presente
            if (!is_null($id_cups) && $id_cups !== '') {
                $query .= ' AND cups.id_cups LIKE :id_cups';
                $bindings['id_cups'] = "%$id_cups%";
            }


            // Añadir condición por id_cnt si está presente
            if (!is_null($id_cnt) && $id_cnt !== '') {
                $query .= ' AND cups.id_cnt LIKE :id_cnt';
                $bindings['id_cnt'] = "%$id_cnt%";
            }

            // Añadir condición por nom_cups si está presente
            if (!is_null($nom_cups) && $nom_cups !== '') {
                $query .= ' AND cups.nom_cups LIKE :nom_cups';
                $bindings['nom_cups'] = "%$nom_cups%";
            }



            // Si el checkbox de autoconsumo está marcado
            if ($autoconsumo === 'S') {
                $query .= ' AND cups.ind_autoconsumo = :autoconsumo';
                $bindings['autoconsumo'] = 'S';
            } else {
                // Si no está marcado, incluir ambos valores
                $query .= ' AND cups.ind_autoconsumo IN (\'S\', \'N\')';
            }


            $query .= ' ORDER BY cups.id_cups ASC';


            // Ejecutar la consulta con las variables enlazadas
            $resultadosQ1cups = DB::connection($connection)->select($query, $bindings);

            // Convertir el array a una colección
            $resultadosQ1Collection = new Collection($resultadosQ1cups);

            // Obtener la página actual
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $perPage = 10; // Número de elementos por página
            $currentItems = $resultadosQ1Collection->slice(($currentPage - 1) * $perPage, $perPage)->all();

            // Crear paginador manualmente
            $resultadosQ1cups = new LengthAwarePaginator($currentItems, count($resultadosQ1Collection), $perPage, $currentPage, [
                'path' => request()->url(),
                'query' => request()->query()
            ]);

            return $resultadosQ1cups ?: [];
        } else {
            return ['message' => 'No hay datos'];
        }
    }










    public function consultaDosCups($id_cups, $connection, Request $request)
    {
        $id_cups = strtoupper($request->input('id_cups'));
        $id_cnt = strtoupper($request->input('id_cnt')); // Obtener el id_cnt
        $nom_cups = strtoupper($request->input('nom_cups'));



        if (Schema::connection($connection)->hasTable('t_contadores')) {


            if ($id_cups) {
                // Obtener el id_cnt de la primera consulta
                $resultadosQ1cups = $this->consultaUnoCups($id_cups, $id_cnt, $nom_cups, $connection, $request);




                // Verificar si se encontraron resultados en la primera consulta
                if (!empty($resultadosQ1cups) && isset($resultadosQ1cups[0]) && $resultadosQ1cups[0] !== null) {
                    $id_cnt = $resultadosQ1cups[0]->id_cnt;




                    // Realizar la segunda consulta usando el id_cnt obtenido
                    $resultadosQ2cups = DB::connection($connection)
                        ->select('
                    SELECT t_contadores.id_cnt,
                        t_contadores.mod_cnt,
                        t_contadores.fw_dlms_cnt,
                        t_contadores.fw_prime_cnt,
                        t_contadores.fab_cnt,
                        t_contadores.des_cnt_af,
                        t_contadores.des_te,
                        t_contadores.des_companion,
                        t_modelos_contadores.nom_fabricante,
                        t_modelos_contadores.num_fases,
                        t_modelos_contadores.tipo_cnt
                    FROM core.t_contadores
                    JOIN core.t_modelos_contadores ON t_contadores.mod_cnt::text = t_modelos_contadores.mod_cnt::text  
                    WHERE t_contadores.id_cnt = :id_cnt
                ', ['id_cnt' => $id_cnt]);
                    //  dd($resultadosQ2cups);
                    return $resultadosQ2cups ?: [];
                }
            }
        } else {
            // Una de las tablas no existe, retornar un mensaje específico
            return ['message' => 'No hay datos'];
        }
    }




    public function consultaTresCups($id_cups, $connection, Request $request) //consumos mensuales 12 meses
    {
        $id_cups = strtoupper($request->input('id_cups'));


        if (Schema::connection($connection)->hasTable('t_consumos_mensual')) {


            if ($id_cups) {
                $resultadosQ3cups = DB::connection($connection)
                    ->select("
                WITH meses AS (
                    SELECT generate_series(
                        date_trunc('month', (SELECT MAX(fec_fin) FROM core.t_consumos_mensual)) - INTERVAL '11 months',
                        date_trunc('month', (SELECT MAX(fec_fin) FROM core.t_consumos_mensual)),
                        INTERVAL '1 month'
                    )::date AS mes
                )
                SELECT 
                    TO_CHAR(m.mes, 'MM/YYYY') AS fec_fin,
                    TO_CHAR(c.fec_inicio, 'MM/YYYY') AS fec_inicio,
                    COALESCE(c.val_ai_m, 0) AS val_ai_m,
                    COALESCE(c.val_ae_m, 0) AS val_ae_m
                FROM meses m
                LEFT JOIN core.t_consumos_mensual c 
                    ON date_trunc('month', c.fec_fin) = m.mes
                    AND c.cod_contrato = '1'
                    AND c.cod_periodotarifa = '0'
                    AND c.id_cups LIKE :id_cups
                ORDER BY m.mes ASC;
            ", bindings: ['id_cups' => "%$id_cups%"]);


                // dd($resultadosQ3cups);
                return $resultadosQ3cups ?: [];
            }
        } else {
            // Una de las tablas no existe, retornar un mensaje específico
            return ['message' => 'No hay datos'];
        }
    }




    public function consultaCuatroCups($id_cups, $connection, Request $request) //periodo tarifario
    {
        $id_cups = strtoupper($request->input('id_cups'));


        if (Schema::connection($connection)->hasTable('t_consumos_mensual')) {


            if ($id_cups) {
                $resultadosQ4cups = DB::connection($connection)
                    ->select("
                SELECT cod_periodotarifa, sum(val_ai_m) AS val_ai_m ,sum(val_ae_m) AS val_ae_m
                FROM core.t_consumos_mensual
                where cod_contrato = '1' and cod_periodotarifa > 0
                and id_cups LIKE :id_cups
                group by 1
                order by 1
            ", ['id_cups' => "%$id_cups%"]);


                // dd($resultadosQ4cups);
                return $resultadosQ4cups ?: [];
            }
        } else {
            // Una de las tablas no existe, retornar un mensaje específico
            return ['message' => 'No hay datos'];
        }
    }








    public function consultaCincoCups($id_cups, $connection, Request $request) //Registros mensuales
    {
        $id_cups = strtoupper($request->input('id_cups'));
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');


        if (Schema::connection($connection)->hasTable('t_consumos_totales_mensuales')) {


            if ($id_cups) {
                $query = "
            SELECT id_cups, TO_CHAR(fec_consumo, 'DD/MM/YYYY') as fec_consumo,
            cod_periodotarifa, val_ai_m, val_ae_m, val_r1_m, val_r2_m, val_r3_m, val_r4_m
            FROM core.t_consumos_totales_mensuales
            WHERE id_cups LIKE :id_cups";


                if ($fecha_inicio && $fecha_fin) {
                    $query .= "
            AND fec_consumo::DATE >= :fecha_inicio
            AND fec_consumo::DATE <= :fecha_fin          
            ORDER BY fec_consumo::DATE ASC, hor_consumo ASC, cod_contrato ASC, cod_periodotarifa ASC";




                    $params = ['id_cups' => "%$id_cups%", 'fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin];
                } else {
                    $query .= "
            ORDER BY fec_consumo::DATE DESC, hor_consumo ASC, cod_contrato ASC, cod_periodotarifa ASC";




                    $params = ['id_cups' => "%$id_cups%"];
                }
                $resultadosQ5cups = DB::connection($connection)->select($query, $params);
                $resultadosQ5cupsCollection = new Collection($resultadosQ5cups);
                $currentPage = LengthAwarePaginator::resolveCurrentPage();
                $perPage = 100;
                $currentItems = $resultadosQ5cupsCollection->slice(($currentPage - 1) * $perPage, $perPage)->all();
                $resultadosQ5cups = new LengthAwarePaginator($currentItems, count($resultadosQ5cupsCollection), $perPage, $currentPage, [
                    'path' => request()->url(),
                    'query' => request()->query()
                ]);

                return $resultadosQ5cups ?: [];
            }
        } else {
            // Una de las tablas no existe, retornar un mensaje específico
            return ['message' => 'No hay datos'];
        }
    }


    public function exportRegistrosMensuales(Request $request) //Registros mensuales
    {
        $user = auth()->user();
        $connection = 'pgsql' . '-' . strtolower($user->nom_distribuidora);
        $id_cups = strtoupper($request->input('id_cups'));
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');


        if (Schema::connection($connection)->hasTable('t_consumos_totales_mensuales')) {
                $query = "
            SELECT id_cups, TO_CHAR(fec_consumo, 'DD/MM/YYYY') as fec_consumo,
            cod_periodotarifa, val_ai_m, val_ae_m, val_r1_m, val_r2_m, val_r3_m, val_r4_m
            FROM core.t_consumos_totales_mensuales
            WHERE id_cups LIKE :id_cups";


                if ($fecha_inicio && $fecha_fin) {
                    $query .= "
            AND fec_consumo::DATE >= :fecha_inicio
            AND fec_consumo::DATE <= :fecha_fin          
            ORDER BY fec_consumo::DATE ASC, hor_consumo ASC, cod_contrato ASC, cod_periodotarifa ASC";




                    $params = ['id_cups' => "%$id_cups%", 'fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin];
                } else {
                    $query .= "
            ORDER BY fec_consumo::DATE DESC, hor_consumo ASC, cod_contrato ASC, cod_periodotarifa ASC";




                    $params = ['id_cups' => "%$id_cups%"];
                }
                $exportRegistrosMensuales = DB::connection($connection)->select($query, $params);
                
                if($exportRegistrosMensuales) {
                    return Excel::download(new RegistrosMensualesExport($exportRegistrosMensuales), 'registros_mensuales.xlsx');
                } else {
                    return response()->json(['message' => 'No hay datos'], 404);
                }
            
        } else {
            // Una de las tablas no existe, retornar un mensaje específico
            return ['message' => 'No hay datos'];
        }
    }




    public function consultaSeisCups($id_cups, $connection, Request $request) //Eventos cups
    {
        $id_cups = strtoupper($request->input('id_cups'));
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');


        if (
            Schema::connection($connection)->hasTable('t_eventos_contador') &&
            Schema::connection($connection)->hasTable('t_descripcion_eventos_contador')
        ) {
            if ($id_cups) {
                $query = "
            SELECT
                t_eventos_contador.id_cups,
                t_eventos_contador.id_cnt,
                TO_CHAR(t_eventos_contador.fec_evento, 'DD/MM/YYYY') as fecha,
                t_eventos_contador.hor_evento,
                t_eventos_contador.txt_adicionales_1,
                t_eventos_contador.txt_adicionales_2,
                t_descripcion_eventos_contador.des_evento_contador
            FROM core.t_eventos_contador, core.t_descripcion_eventos_contador
            WHERE t_eventos_contador.grp_evento = t_descripcion_eventos_contador.grp_evento
            AND t_eventos_contador.cod_evento = t_descripcion_eventos_contador.cod_evento
           ";




                if ($fecha_inicio && $fecha_fin) {
                    $query .= "
                        AND t_eventos_contador.fec_evento >= :fecha_inicio
                        AND t_eventos_contador.fec_evento <= :fecha_fin
                        AND t_eventos_contador.id_cups LIKE :id_cups
                    ORDER BY
                        t_eventos_contador.fec_evento DESC, t_eventos_contador.hor_evento DESC;";




                    $params = ['id_cups' => "%$id_cups%", 'fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin];
                } else {
                    $query .= "
                AND t_eventos_contador.id_cups LIKE :id_cups
                ORDER BY
                    t_eventos_contador.fec_evento DESC, t_eventos_contador.hor_evento DESC
                LIMIT 100;";




                    $params = ['id_cups' => "%$id_cups%"];
                }




                $resultadosQ6cups = DB::connection($connection)->select($query, $params);
                $resultadosQ6cupsCollection = new Collection($resultadosQ6cups);
                $currentPage = LengthAwarePaginator::resolveCurrentPage();
                $perPage = 100; // Número de elementos por página
                $currentItems = $resultadosQ6cupsCollection->slice(($currentPage - 1) * $perPage, $perPage)->all();


                // Crear paginador manualmente
                $resultadosQ6cups = new LengthAwarePaginator($currentItems, count($resultadosQ6cupsCollection), $perPage, $currentPage, [
                    'path' => request()->url(),
                    'query' => request()->query()
                ]);


                return $resultadosQ6cups ?: [];
            }
        } else {
            // Una de las tablas no existe, retornar un mensaje específico
            return ['message' => 'No hay datos'];
        }
    }

    public function exportEventsCups(Request $request) //Eventos cups
    {
        $user = auth()->user();
        $connection = 'pgsql' . '-' . strtolower($user->nom_distribuidora);
        $id_cups = strtoupper($request->input('id_cups'));
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');


        if (
            Schema::connection($connection)->hasTable('t_eventos_contador') &&
            Schema::connection($connection)->hasTable('t_descripcion_eventos_contador')
        ) {
            if ($id_cups) {
                $query = "
            SELECT
                t_eventos_contador.id_cups,
                t_eventos_contador.id_cnt,
                TO_CHAR(t_eventos_contador.fec_evento, 'DD/MM/YYYY') as fecha,
                t_eventos_contador.hor_evento,
                t_eventos_contador.txt_adicionales_1,
                t_eventos_contador.txt_adicionales_2,
                t_descripcion_eventos_contador.des_evento_contador
            FROM core.t_eventos_contador, core.t_descripcion_eventos_contador
            WHERE t_eventos_contador.grp_evento = t_descripcion_eventos_contador.grp_evento
            AND t_eventos_contador.cod_evento = t_descripcion_eventos_contador.cod_evento
           ";




                if ($fecha_inicio && $fecha_fin) {
                    $query .= "
                        AND t_eventos_contador.fec_evento >= :fecha_inicio
                        AND t_eventos_contador.fec_evento <= :fecha_fin
                        AND t_eventos_contador.id_cups LIKE :id_cups
                    ORDER BY
                        t_eventos_contador.fec_evento DESC, t_eventos_contador.hor_evento DESC;";




                    $params = ['id_cups' => "%$id_cups%", 'fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin];
                } else {
                    $query .= "
                AND t_eventos_contador.id_cups LIKE :id_cups
                ORDER BY
                    t_eventos_contador.fec_evento DESC, t_eventos_contador.hor_evento DESC
                LIMIT 100;";




                    $params = ['id_cups' => "%$id_cups%"];
                }




                $exportEventsCups = DB::connection($connection)->select($query, $params);
                if($exportEventsCups) {
                    return Excel::download(new EventosCupsExport($exportEventsCups), 'eventos_cups.xlsx');
                } else {
                    return response()->json(['message' => 'No hay datos'], 404);
                }
            }
        } else {
            // Una de las tablas no existe, retornar un mensaje específico
            return ['message' => 'No hay datos'];
        }
    }


    public function consultaSumaEventos($id_cups, $connection, Request $request) //suma de todos los eventos de ese cups
    {
        $id_cups = strtoupper($request->input('id_cups'));


        if (
            Schema::connection($connection)->hasTable('t_eventos_contador')
        ) {
            if ($id_cups) {
                $resultadosSumaEventos = DB::connection($connection)
                    ->select("
                    SELECT
                    COUNT(t_eventos_contador.id_cups) as total_eventos
                FROM
                    core.t_eventos_contador
                WHERE
                    t_eventos_contador.id_cups LIKE :id_cups;
            ", ['id_cups' => "%$id_cups%"]);


                // dd($resultadosSumaEventos);
                return $resultadosSumaEventos ?: [];
            }
        } else {
            // Una de las tablas no existe, retornar un mensaje específico
            return ['message' => 'No hay datos'];
        }
    }




    public function consultaSieteCups($id_cups, $connection, Request $request) //consumos mensuales 12 meses
    {
        $id_cups = strtoupper($request->input('id_cups'));


        if (
            Schema::connection($connection)->hasTable('t_alertas_cups') &&
            Schema::connection($connection)->hasTable('t_alertas_distribuidora')
        ) {
            if ($id_cups) {
                $resultadosQ7cups = DB::connection($connection)
                    ->select("
                SELECT
                t_alertas_cups.id_cups,
                t_alertas_cups.id_cnt,
                TO_CHAR(t_alertas_cups.fec_alerta, 'DD/MM/YYYY') as fecha,
                t_alertas_cups.hor_alerta,
                t_alertas_cups.cod_gravedad,
                t_alertas_cups.observaciones,
                t_alertas_distribuidora.des_evento
                FROM core.t_alertas_cups, core.t_alertas_distribuidora
                WHERE
                t_alertas_cups.grp_alerta = t_alertas_distribuidora.grp_alerta
                AND
                t_alertas_cups.cod_alerta = t_alertas_distribuidora.cod_alerta
                AND t_alertas_cups.id_cups LIKE :id_cups
                ORDER BY fec_alerta desc, hor_alerta desc
            ", ['id_cups' => "%$id_cups%"]);


                // dd($resultadosQ7cups);
                return $resultadosQ7cups ?: [];
            }
        } else {
            // Una de las tablas no existe, retornar un mensaje específico
            return ['message' => 'No hay datos'];
        }
    }


    // DOCUMENTO CUPS 2 PARTE
    public function consultaOchoCups($id_cups, $connection, Request $request) // KPI Energia Importada (Kwh +)
    {
        $id_cups = strtoupper($request->input('id_cups'));
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');


        if (Schema::connection($connection)->hasTable('t_consumos_horarios')) {


            if ($id_cups) {
                $query = "
        SELECT
        ROUND(SUM(val_ai_h) / 1000) AS total_curva_imp,
        ROUND(SUM(val_ae_h) / 1000) AS total_curva_exp,
            AVG(val_fp_h) AS fp
        FROM
            core.t_consumos_horarios
        WHERE
            id_cups = :id_cups
        ";


                if ($fecha_inicio && $fecha_fin) {
                    $query .= "
            AND fec_inicio >= :fecha_inicio
            AND fec_fin <= :fecha_fin
            ;";
                    $params = [
                        'id_cups' => $id_cups,
                        'fecha_inicio' => $fecha_inicio,
                        'fecha_fin' => $fecha_fin
                    ];
                } else {
                    $query .= "
                        AND fec_inicio >= (current_date - INTERVAL '30 days');";

                    $params = ['id_cups' => $id_cups];
                }


                $resultadosQ8cups = DB::connection($connection)->select($query, $params);
                // dd($resultadosQ8cups);


                return $resultadosQ8cups ?: [];
            }
        } else {
            // Una de las tablas no existe, retornar un mensaje específico
            return ['message' => 'No hay datos'];
        }
    }


    public function consultaNueveCups($id_cups, $connection, Request $request) // KPI Nro de Horas Leidas
    {
        $id_cups = strtoupper($request->input('id_cups'));
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');


        if (Schema::connection($connection)->hasTable('t_consumos_horarios')) {


            if ($id_cups) {
                $query = "
            SELECT count(hor_fin) as curvas_leidas
            FROM core.t_consumos_horarios
            where id_cups = :id_cups
        ";


                if ($fecha_inicio && $fecha_fin) {
                    $query .= "
            AND fec_inicio >= :fecha_inicio
            AND fec_fin <= :fecha_fin
            ;";
                    $params = [
                        'id_cups' => $id_cups,
                        'fecha_inicio' => $fecha_inicio,
                        'fecha_fin' => $fecha_fin
                    ];
                } else {
                    $query .= "
            AND fec_inicio >= (current_date - INTERVAL '30 days')
            ;";


                    $params = ['id_cups' => $id_cups];
                }


                $resultadosQ9cups = DB::connection($connection)->select($query, $params);
                // dd($resultadosQ9cups);


                return $resultadosQ9cups ?: [];
            }
        } else {
            // Una de las tablas no existe, retornar un mensaje específico
            return ['message' => 'No hay datos'];
        }
    }


    public function consultaDiezCups($id_cups, $connection, Request $request) // KPI Horas sin consumo
    {
        $id_cups = strtoupper($request->input('id_cups'));
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');


        if (Schema::connection($connection)->hasTable('t_consumos_horarios')) {


            if ($id_cups) {
                $query = "
            SELECT count(val_ai_h) as curvas_sin_consumo
            FROM core.t_consumos_horarios
            where id_cups = :id_cups
            and val_ai_h = 0
        ";


                if ($fecha_inicio && $fecha_fin) {
                    $query .= "
            AND fec_inicio >= :fecha_inicio
            AND fec_fin <= :fecha_fin
            ;";
                    $params = [
                        'id_cups' => $id_cups,
                        'fecha_inicio' => $fecha_inicio,
                        'fecha_fin' => $fecha_fin
                    ];
                } else {
                    $query .= "
            AND fec_inicio >= (current_date - INTERVAL '30 days')
            ;";


                    $params = ['id_cups' => $id_cups];
                }


                $resultadosQ10cups = DB::connection($connection)->select($query, $params);
                // dd($resultadosQ10cups);


                return $resultadosQ10cups ?: [];
            }
        } else {
            // Una de las tablas no existe, retornar un mensaje específico
            return ['message' => 'No hay datos'];
        }
    }


    public function consultaOnceCups($id_cups, $connection, Request $request) // Curva horaria
    {
        $id_cups = strtoupper($request->input('id_cups'));
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');


        if (Schema::connection($connection)->hasTable('t_consumos_horarios')) {


            if ($id_cups) {
                $query = "
            SELECT id_cups, id_cnt,
            TO_CHAR(fec_inicio, 'DD/MM/YYYY') as fec_inicio,
            hor_inicio,
            TO_CHAR(fec_fin, 'DD/MM/YYYY') as fec_fin,
            hor_fin, val_ai_h, val_ae_h, val_r1_h, val_r2_h, val_r3_h, val_r4_h
            FROM core.t_consumos_horarios
            where id_cups = :id_cups
            ";


                if ($fecha_inicio && $fecha_fin) {
                    $query .= "
                AND fec_inicio >= :fecha_inicio
                AND fec_fin <= :fecha_fin
                order by 1,3,4;";
                    $params = [
                        'id_cups' => $id_cups,
                        'fecha_inicio' => $fecha_inicio,
                        'fecha_fin' => $fecha_fin
                    ];
                } else {
                    $query .= "
                and fec_inicio >= (current_date - INTERVAL '30 days')
                order by 1,3,4;";


                    $params = ['id_cups' => $id_cups];
                }


                $resultadosQ11cups = DB::connection($connection)->select($query, $params);
                $resultadosQ11cupsCollection = new Collection($resultadosQ11cups);
                $currentPage = LengthAwarePaginator::resolveCurrentPage();
                $perPage = 100; // Número de elementos por página
                $currentItems = $resultadosQ11cupsCollection->slice(($currentPage - 1) * $perPage, $perPage)->all();


                // Crear paginador manualmente
                $resultadosQ11cups = new LengthAwarePaginator($currentItems, count($resultadosQ11cupsCollection), $perPage, $currentPage, [
                    'path' => request()->url(),
                    'query' => request()->query()
                ]);


                return $resultadosQ11cups ?: [];
            }
        } else {
            // Una de las tablas no existe, retornar un mensaje específico
            return ['message' => 'No hay datos'];
        }
    }

    public function exportCurvasHorarias(Request $request) // Curva horaria
    {
        $user = auth()->user();
        $connection = 'pgsql' . '-' . strtolower($user->nom_distribuidora);
        $id_cups = strtoupper($request->input('id_cups'));
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');


        if (Schema::connection($connection)->hasTable('t_consumos_horarios')) {


            if ($id_cups) {
                $query = "
            SELECT id_cups, id_cnt,
            TO_CHAR(fec_inicio, 'DD/MM/YYYY') as fec_inicio,
            hor_inicio,
            TO_CHAR(fec_fin, 'DD/MM/YYYY') as fec_fin,
            hor_fin, val_ai_h, val_ae_h, val_r1_h, val_r2_h, val_r3_h, val_r4_h
            FROM core.t_consumos_horarios
            where id_cups = :id_cups
            ";


                if ($fecha_inicio && $fecha_fin) {
                    $query .= "
                AND fec_inicio >= :fecha_inicio
                AND fec_fin <= :fecha_fin
                order by 1,3,4;";
                    $params = [
                        'id_cups' => $id_cups,
                        'fecha_inicio' => $fecha_inicio,
                        'fecha_fin' => $fecha_fin
                    ];
                } else {
                    $query .= "
                and fec_inicio >= (current_date - INTERVAL '30 days')
                order by 1,3,4;";


                    $params = ['id_cups' => $id_cups];
                }


                $exportCurvasHorarias = DB::connection($connection)->select($query, $params);
                if($exportCurvasHorarias) {
                    return Excel::download(new CurvasHorariasCupsExport($exportCurvasHorarias), 'curvas_horarias_cups.xlsx');                   
                } else {
                    return response()->json(['message' => 'No hay datos'], 404);
                } 
            }
        } else {
            // Una de las tablas no existe, retornar un mensaje específico
            return ['message' => 'No hay datos'];
        }
    }


    public function consultaDoceCups($id_cups, $connection, Request $request) // Consumo Promedio por hora
    {
        $id_cups = strtoupper($request->input('id_cups'));
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');


        if (Schema::connection($connection)->hasTable('t_consumos_horarios')) {


            if ($id_cups) {
                $query = "
            SELECT hor_inicio, ROUND(avg(val_ai_h)/1000, 2)
            FROM core.t_consumos_horarios
            where id_cups = :id_cups
        ";


                if ($fecha_inicio && $fecha_fin) {
                    $query .= "
            AND fec_inicio >= :fecha_inicio
            AND fec_fin <= :fecha_fin
            group by 1
            order by 1;";
                    $params = [
                        'id_cups' => $id_cups,
                        'fecha_inicio' => $fecha_inicio,
                        'fecha_fin' => $fecha_fin
                    ];
                } else {
                    $query .= "
                AND fec_inicio >= (current_date - INTERVAL '30 days')
                group by 1
                order by 1;";
                    $params = ['id_cups' => $id_cups];
                }


                $resultadosQ12cups = DB::connection($connection)->select($query, $params);
                //  dd($resultadosQ12cups);


                return $resultadosQ12cups ?: [];
            }
        } else {
            // Una de las tablas no existe, retornar un mensaje específico
            return ['message' => 'No hay datos'];
        }
    }


    public function consultaTreceCups($id_cups, $connection, Request $request) // Consumo por dia de la semana
    {
        $id_cups = strtoupper($request->input('id_cups'));
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');


        if (Schema::connection($connection)->hasTable('t_consumos_horarios')) {


            if ($id_cups) {
                $query = "
            SELECT extract (dow from fec_inicio), ROUND(avg(val_ai_h)/1000, 2)
            FROM core.t_consumos_horarios
            where id_cups =  :id_cups
        ";


                if ($fecha_inicio && $fecha_fin) {
                    $query .= "
            AND fec_inicio >= :fecha_inicio
            AND fec_fin <= :fecha_fin
            group by 1
            order by 1;";
                    $params = [
                        'id_cups' => $id_cups,
                        'fecha_inicio' => $fecha_inicio,
                        'fecha_fin' => $fecha_fin
                    ];
                } else {
                    $query .= "
                AND fec_inicio >= (current_date - INTERVAL '30 days')
                group by 1
                order by 1;";
                    $params = ['id_cups' => $id_cups];
                }


                $resultadosQ13cups = DB::connection($connection)->select($query, $params);
                // dd($resultadosQ13cups);


                return $resultadosQ13cups ?: [];
            }
        } else {
            // Una de las tablas no existe, retornar un mensaje específico
            return ['message' => 'No hay datos'];
        }
    }


    public function consultaCatorceCups($id_cups, $connection, Request $request) //Nro de Cortes
    {
        $id_cups = strtoupper($request->input('id_cups'));


        if ($id_cups) {
            $resultadosQ14cups = DB::connection($connection)
                ->select("
                SELECT count(*) as cortes
                FROM core.v_apagones
                where id_cups = :id_cups
            ", ['id_cups' => $id_cups]);
            // dd($resultadosQ14cups);
            return $resultadosQ14cups ?: [];
        }
    }


    public function consultaQuinceCups($id_cups, $connection, Request $request) //micro Cortes
    {
        $id_cups = strtoupper($request->input('id_cups'));


        if ($id_cups) {
            $resultadosQ15cups = DB::connection($connection)
                ->select("
                SELECT count(*) as micro_cortes
                FROM core.v_micro_cortes
                where id_cups = :id_cups
            ", ['id_cups' => $id_cups]);
            // dd($resultadosQ15cups);
            return $resultadosQ15cups ?: [];
        }
    }


    public function consultaDieciseisCups($id_cups, $connection, Request $request) //sobretensiones
    {
        $id_cups = strtoupper($request->input('id_cups'));


        if ($id_cups) {
            $resultadosQ16cups = DB::connection($connection)
                ->select("
                SELECT count(*) as sobre_tensiones
                FROM core.v_sobre_voltajes
                where id_cups = :id_cups
            ", ['id_cups' => $id_cups]);
            // dd($resultadosQ16cups);
            return $resultadosQ16cups ?: [];
        }
    }


    public function consultaDiecisieteCups($id_cups, $connection, Request $request) //subtensiones
    {
        $id_cups = strtoupper($request->input('id_cups'));


        if ($id_cups) {
            $resultadosQ17cups = DB::connection($connection)
                ->select("
                SELECT count(*) as sub_tensiones
                FROM core.v_sub_voltajes
                where id_cups = :id_cups
            ", ['id_cups' => $id_cups]);
            // dd($resultadosQ17cups);
            return $resultadosQ17cups ?: [];
        }
    }


    public function consultaDieciochoCups($id_cups, $connection, Request $request) //factor potencia
    {
        $id_cups = strtoupper($request->input('id_cups'));


        if ($id_cups) {
            $resultadosQ18cups = DB::connection($connection)
                ->select("
                SELECT ROUND(avg(val_fp_h), 2) as factor_potencia
                FROM core.t_consumos_horarios
                where id_cups = :id_cups
            ", ['id_cups' => $id_cups]);
            // dd($resultadosQ18cups);
            return $resultadosQ18cups ?: [];
        }
    }


    public function consultaDiecinueveCups($id_cups, $connection, Request $request) //fechas nro cortes
    {
        $id_cups = strtoupper($request->input('id_cups'));


        if ($id_cups) {
            $resultadosQ19cups = DB::connection($connection)
                ->select("
            SELECT TO_CHAR(fec_evento, 'DD/MM/YYYY') as fec_evento, hor_evento
            FROM core.v_apagones
            WHERE id_cups = :id_cups
            ORDER BY fec_evento DESC, hor_evento DESC
        ", ['id_cups' => $id_cups]);


            // Convertir las fechas y horas en objetos DateTime
            foreach ($resultadosQ19cups as $resultado) {
                $resultado->fecha_hora = DateTime::createFromFormat('d/m/Y H:i:s', $resultado->fec_evento . ' ' . $resultado->hor_evento);
            }


            // Ordenar los resultados por fecha y hora
            usort($resultadosQ19cups, function ($a, $b) {
                return $b->fecha_hora <=> $a->fecha_hora;
            });


            // dd($resultadosQ19cups);
            return $resultadosQ19cups ?: [];
        }
    }










    public function consultaVeinteCups($id_cups, $connection, Request $request) //fechas micro cortes
    {
        $id_cups = strtoupper($request->input('id_cups'));


        if ($id_cups) {
            $resultadosQ20cups = DB::connection($connection)
                ->select("
            SELECT TO_CHAR(fec_evento, 'DD/MM/YYYY') as fec_evento, hor_evento
            FROM core.v_micro_cortes
            WHERE id_cups = :id_cups
            ORDER BY fec_evento DESC, hor_evento DESC
        ", ['id_cups' => $id_cups]);


            // Convertir las fechas y horas en objetos DateTime
            foreach ($resultadosQ20cups as $resultado) {
                $resultado->fecha_hora = DateTime::createFromFormat('d/m/Y H:i:s', $resultado->fec_evento . ' ' . $resultado->hor_evento);
            }


            // Ordenar los resultados por fecha y hora
            usort($resultadosQ20cups, function ($a, $b) {
                return $b->fecha_hora <=> $a->fecha_hora;
            });

            // dd($resultadosQ20cups);
            return $resultadosQ20cups ?: [];
        }
    }




    public function consultaVeintiUnoCups($id_cups, $connection, Request $request) //fechas sobre voltajes
    {
        $id_cups = strtoupper($request->input('id_cups'));


        if ($id_cups) {
            $resultadosQ21cups = DB::connection($connection)
                ->select("
            SELECT TO_CHAR(fec_evento, 'DD/MM/YYYY') as fec_evento, hor_evento
            FROM core.v_sobre_voltajes
            WHERE id_cups = :id_cups
            ORDER BY fec_evento DESC, hor_evento DESC
        ", ['id_cups' => $id_cups]);


            // Convertir las fechas y horas en objetos DateTime
            foreach ($resultadosQ21cups as $resultado) {
                $resultado->fecha_hora = DateTime::createFromFormat('d/m/Y H:i:s', $resultado->fec_evento . ' ' . $resultado->hor_evento);
            }


            // Ordenar los resultados por fecha y hora
            usort($resultadosQ21cups, function ($a, $b) {
                return $b->fecha_hora <=> $a->fecha_hora;
            });


            return $resultadosQ21cups ?: [];
        }
    }


    public function consultaVeintiDosCups($id_cups, $connection, Request $request) //fechas sub voltajes
    {
        $id_cups = strtoupper($request->input('id_cups'));


        if ($id_cups) {
            $resultadosQ22cups = DB::connection($connection)
                ->select("
            SELECT TO_CHAR(fec_evento, 'DD/MM/YYYY') as fec_evento, hor_evento
            FROM core.v_sub_voltajes
            WHERE id_cups = :id_cups
            ORDER BY fec_evento DESC, hor_evento DESC
        ", ['id_cups' => $id_cups]);


            // Convertir las fechas y horas en objetos DateTime
            foreach ($resultadosQ22cups as $resultado) {
                $resultado->fecha_hora = DateTime::createFromFormat('d/m/Y H:i:s', $resultado->fec_evento . ' ' . $resultado->hor_evento);
            }


            // Ordenar los resultados por fecha y hora
            usort($resultadosQ22cups, function ($a, $b) {
                return $b->fecha_hora <=> $a->fecha_hora;
            });


            return $resultadosQ22cups ?: [];
        }
    }




    //QUERYS PARA VOLATES PROMEDIO, MIN Y MAX


    public function consultaVeintiTresCups($id_cups, $connection, Request $request) //grafico tension por hora
    {
        $id_cups = strtoupper($request->input('id_cups'));


        if (Schema::connection($connection)->hasTable('t_valores_instantaneos')) {
            if ($id_cups) {
                $resultadosQ23cups = DB::connection($connection)
                    ->select("
                    SELECT 
                        TO_CHAR(fec_lectura, 'DD/MM/YYYY') AS fec_lectura_texto,  -- Formatea la fecha como texto
                        hor_lectura, 
                        l1v AS tension
                    FROM (
                        SELECT 
                            fec_lectura,
                            hor_lectura, 
                            l1v 
                        FROM core.t_valores_instantaneos
                        WHERE id_cups = :id_cups
                            AND fec_lectura <= (SELECT MAX(fec_lectura) FROM core.t_valores_instantaneos)
                        ORDER BY fec_lectura DESC, hor_lectura DESC  -- Limita a los 100 más recientes
                        LIMIT 100
                    ) AS subquery
                    ORDER BY fec_lectura::DATE ASC, hor_lectura ASC;
", ['id_cups' => $id_cups]);
                // dd($resultadosQ23cups);
                return $resultadosQ23cups ?: [];
            }
        } else {
            // Una de las tablas no existe, retornar un mensaje específico
            return ['message' => 'No hay datos'];
        }
    }


    public function consultaVeintiCuatroCups($id_cups, $connection, Request $request) //prom, max y min
    {
        $id_cups = strtoupper($request->input('id_cups'));


        if (Schema::connection($connection)->hasTable('t_valores_instantaneos')) {
            if ($id_cups) {
                $resultadosQ24cups = DB::connection($connection)
                    ->select("
                    SELECT round(max(l1v),0) as maximo, round(min(l1v),0) as minimo, round(avg(l1v), 2) as promedio
                    FROM core.t_valores_instantaneos
                    where id_cups = :id_cups
            ", ['id_cups' => $id_cups]);
                // dd($resultadosQ24cups);
                return $resultadosQ24cups ?: [];
            }
        } else {
            // Una de las tablas no existe, retornar un mensaje específico
            return ['message' => 'No hay datos'];
        }
    }


    public function consultaVeintiCincoCups($id_cups, $connection, Request $request) //prom, max y min
    {
        $id_cups = strtoupper($request->input('id_cups'));


        if (Schema::connection($connection)->hasTable('t_valores_instantaneos')) {
            if ($id_cups) {
                $resultadosQ25cups = DB::connection($connection)
                    ->select("
                    SELECT round(max(l1v),0) as maximo, round(min(l1v),0) as minimo, round(avg(l1v), 2) as promedio
                    FROM core.t_valores_instantaneos
                    where id_cups = :id_cups
            ", ['id_cups' => $id_cups]);
                // dd($resultadosQ24cups);
                return $resultadosQ25cups ?: [];
            }
        } else {
            // Una de las tablas no existe, retornar un mensaje específico
            return ['message' => 'No hay datos'];
        }
    }


    public function consultaVeintiSeisCups($id_cups, $connection, Request $request) //factor potencia max y min
    {
        $id_cups = strtoupper($request->input('id_cups'));


        if ($id_cups) {
            $resultadosQ26cups = DB::connection($connection)
                ->select("
                SELECT max(val_fp_h) as factor_potencia_max, min(val_fp_h) as factor_potencia_min
                FROM core.t_consumos_horarios
                where id_cups =  :id_cups
            ", ['id_cups' => $id_cups]);
            // dd($resultadosQ26cups);
            return $resultadosQ26cups ?: [];
        }
    }


    public function consultaVeintisieteCups($id_cups, $connection, Request $request) //valor maximetro ultimos 12 meses
    {
        $id_cups = strtoupper($request->input('id_cups'));


        if (Schema::connection($connection)->hasTable('t_maximetros')) {


            if ($id_cups) {
                $resultadosQ27cups = DB::connection($connection)
                    ->select("
                    SELECT
                        id_cups,
                        id_cnt,
                        TO_CHAR(fec_maximetro, 'MM/YYYY') AS fecha,
                        hor_maximetro as hora,
                        ROUND(val_maximetro / 1000.0, 2) AS val_maximetro
                    FROM core.t_maximetros
                    WHERE
                        fec_maximetro >= CURRENT_DATE - INTERVAL '12 months'
                        AND id_cups LIKE :id_cups
                    ORDER BY
                        fec_maximetro DESC, hor_maximetro ASC;


            ", ['id_cups' => "%$id_cups%"]);


                // dd($resultadosQ27cups);
                return $resultadosQ27cups ?: [];
            }
        } else {
            // Una de las tablas no existe, retornar un mensaje específico
            return ['message' => 'No hay datos'];
        }
    }

    public function getConsumoDiario($id_cups, $connection, Request $request)
    {
        $id_cups = strtoupper(($request->input('id_cups')));

        if (Schema::connection($connection)->hasTable('t_consumos_totales_diarios')) {
            if ($id_cups) {
                $consumoDiario = DB::connection($connection)->select("
                WITH meses AS (
                    SELECT generate_series(
                        (SELECT MAX(fec_fin) FROM core.t_consumos_diarios) - INTERVAL '1 month',
                        (SELECT MAX(fec_fin) FROM core.t_consumos_diarios),
                        INTERVAL '1 day'
                    )::date AS mes
                )
                SELECT 
					TO_CHAR(c.fec_inicio, 'DD/MM/YYYY') AS fec_inicio,
                    TO_CHAR(m.mes, 'DD/MM/YYYY') AS fec_fin,
                    COALESCE(c.val_ai_d, 0) AS val_ai_d,
                    COALESCE(c.val_ae_d, 0) AS val_ae_d
                FROM meses m
                LEFT JOIN core.t_consumos_diarios c 
                    ON c.fec_fin = m.mes
                    AND c.id_cups LIKE :id_cups
                ORDER BY m.mes ASC;


                ", bindings: ['id_cups' => "%$id_cups%"]);

                return $consumoDiario ?: [];
            } else {
                return ['message' => 'No hay datos'];
            }
        }
    }

    public function getConsumosTotalesDiarios($id_cups, $connection, Request $request) {
        $id_cups = strtoupper($request->input('id_cups'));
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');

        if(Schema::connection($connection)->hasTable('t_consumos_totales_diarios')) {
            if($id_cups) {
                $query = "
                    SELECT id_cups, TO_CHAR(fec_consumo, 'DD/MM/YYYY') as fec_consumo,
                    cod_periodotarifa, val_ai_d, val_ae_d, val_r1_d, val_r2_d, val_r3_d, val_r4_d
                    FROM core.t_consumos_totales_diarios
                    WHERE id_cups LIKE :id_cups";

                    if($fecha_fin) {
                        $query .= "
                            AND fec_consumo::DATE <= :fecha_fin
                            ORDER BY fec_consumo::DATE ASC, hor_consumo ASC";
                            $params = ['id_cups' => "%$id_cups%", 'fecha_fin' => $fecha_fin];
                    } else if($fecha_inicio) {
                        $query .= "
                            AND fec_consumo::DATE >= :fecha_inicio
                            ORDER BY fec_consumo::DATE ASC, hor_consumo ASC";
                        $params = ['id_cups' => "%$id_cups%", 'fecha_inicio' => $fecha_inicio];
                    } else if($fecha_fin && $fecha_inicio) {
                        $query .= "
                        AND fec_consumo::DATE <= :fecha_fin
                        AND fec_consumo::DATE >= :fecha_inicio
                        ORDER BY fec_consumo::DATE ASC, hor_consumo ASC";
                        $params = ['id_cups' => "%$id_cups%", 'fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin];
                    } 
                    else {
                        $query .= "
                        AND fec_consumo >= CURRENT_DATE - INTERVAL '1 month'    
                        ORDER BY fec_consumo::DATE DESC, hor_consumo ASC";
                        $params = ['id_cups' => "%$id_cups%"];
                    }

                    $consumosTotalesDiarios = DB::connection($connection)->select($query, $params);
                    $consumosTotalesDiariosCollection = new Collection($consumosTotalesDiarios);
                    $currentPage = LengthAwarePaginator::resolveCurrentPage();
                    $perPage = 100; // Número de elementos por página
                    $currentItems = $consumosTotalesDiariosCollection->slice(($currentPage - 1) * $perPage, $perPage)->all();


                // Crear paginador manualmente
                    $consumosTotalesDiarios = new LengthAwarePaginator($currentItems, count($consumosTotalesDiariosCollection), $perPage, $currentPage, [
                        'path' => request()->url(),
                        'query' => request()->query()
                    ]);

                    return $consumosTotalesDiarios ?: [];
            } else {
                return ['message' => 'No hay datos'];
            }
        }
    }

    public function exportConsumosTotalesDiarios(Request $request) {
        $user = auth()->user();
        $connection = 'pgsql' . '-' . strtolower($user->nom_distribuidora);
        $id_cups = strtoupper($request->input('id_cups'));
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');

        if(Schema::connection($connection)->hasTable('t_consumos_totales_diarios')) {
            if($id_cups) {
                $query = "
                    SELECT id_cups, TO_CHAR(fec_consumo, 'DD/MM/YYYY') as fec_consumo,
                    cod_periodotarifa, val_ai_d, val_ae_d, val_r1_d, val_r2_d, val_r3_d, val_r4_d
                    FROM core.t_consumos_totales_diarios
                    WHERE id_cups LIKE :id_cups";

                    if($fecha_fin) {
                        $query .= "
                            AND fec_consumo::DATE <= :fecha_fin
                            ORDER BY fec_consumo::DATE ASC, hor_consumo ASC";
                            $params = ['id_cups' => "%$id_cups%", 'fecha_fin' => $fecha_fin];
                    } else if($fecha_inicio) {
                        $query .= "
                            AND fec_consumo::DATE >= :fecha_inicio
                            ORDER BY fec_consumo::DATE ASC, hor_consumo ASC";
                        $params = ['id_cups' => "%$id_cups%", 'fecha_inicio' => $fecha_inicio];
                    } else if($fecha_fin && $fecha_inicio) {
                        $query .= "
                        AND fec_consumo::DATE <= :fecha_fin
                        AND fec_consumo::DATE >= :fecha_inicio
                        ORDER BY fec_consumo::DATE ASC, hor_consumo ASC";
                        $params = ['id_cups' => "%$id_cups%", 'fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin];
                    } 
                    else {
                        $query .= "
                        AND fec_consumo >= CURRENT_DATE - INTERVAL '1 month'    
                        ORDER BY fec_consumo::DATE DESC, hor_consumo ASC";
                        $params = ['id_cups' => "%$id_cups%"];
                    }

                    $exportConsumosTotalesDiarios = DB::connection($connection)->select($query, $params);
                    if($exportConsumosTotalesDiarios) {
                        return Excel::download(new ConsumosTotalesDiariosExport($exportConsumosTotalesDiarios), 'registros_diarios.xlsx');
                    } else {
                        return response()->json(['message' => 'No hay datos'], 404);
                    }
            } else {
                return ['message' => 'No hay datos'];
            }
        }
    }
}




