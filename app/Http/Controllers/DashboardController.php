<?php


namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{


    //FUNCION REDIRIGIR A DASHBOARCT-----------------------------------------------
    public function dashboardCt()
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }

        // Obtener la conexión dinámica
        $connection = User::conexion();


        if ($connection == 'pgsql') {
            // Si la conexión es la predeterminada, retornar un mensaje de bienvenida para el admin
            return view('admin');
        } else {

            $resultadosQ1dashboard = $this->consultaUnoDashboard($connection);
            $resultadosQ2dashboard = $this->consultaDosDashboard($connection);
            $resultadosQ3dashboard = $this->consultaTresDashboard($connection);
            $resultadosQ4dashboard = $this->consultaCuatroDashboard($connection);
            $resultadosQ5dashboard = $this->consultaCincoDashboard($connection);
            $resultadosQ6dashboard = $this->consultaSeisDashboard($connection);
            $resultadosQ7dashboard = $this->consultaSieteDashboard($connection);
            $resultadosQ8dashboard = $this->consultaOchoDashboard($connection);
            //$resultadosQ9dashboard = $this->consultaNueveDashboard($connection);
            //$resultadosQ10dashboard = $this->consultaDiezDashboard($connection);
            $resultadosQ11dashboard = $this->consultaOnceDashboard($connection);
            //$resultadosQ12dashboard = $this->consultaDoceDashboard($connection);
            $resultadosQ22dashboard = $this->consultaVeintiDosDashboard($connection);
            $dashboardInfo = $this->getDashboardInfo($connection);



            // dd($resultadosQ1dashboard);
            // Pasar los datos a la vista
            return view('dashboardct', [
                'resultadosQ1dashboard' => $resultadosQ1dashboard,
                'resultadosQ2dashboard' => $resultadosQ2dashboard,
                'resultadosQ3dashboard' => $resultadosQ3dashboard,
                'resultadosQ4dashboard' => $resultadosQ4dashboard,
                'resultadosQ5dashboard' => $resultadosQ5dashboard,
                'resultadosQ6dashboard' => $resultadosQ6dashboard,
                'resultadosQ7dashboard' => $resultadosQ7dashboard,
                'resultadosQ8dashboard' => $resultadosQ8dashboard,
                //'resultadosQ9dashboard' => $resultadosQ9dashboard,
                //'resultadosQ10dashboard' => $resultadosQ10dashboard,
                'resultadosQ11dashboard' => $resultadosQ11dashboard,
                //'resultadosQ12dashboard' => $resultadosQ12dashboard,
                'resultadosQ22dashboard' => $resultadosQ22dashboard,
                'dashboardInfo' => $dashboardInfo,

            ]);
        }
    }




    //FUNCION REDIRIGIR A DASHBOARPF--------------------------------------------
    public function dashboardPf()
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }


        // Obtener la conexión dinámica con la base de datos MYSQL
        $connectionpf = User::conexionPuntoFrontera();

        $resultadosQ13dashboard = $this->consultaTreceDashboard($connectionpf);
        $resultadosQ14dashboard = $this->consultaCatorceDashboard($connectionpf);
        $resultadosQ15dashboard = $this->consultaQuinceDashboard($connectionpf);
        $resultadosQ16dashboard = $this->consultaDieciseisDashboard($connectionpf);
        $resultadosQ17dashboard = $this->consultaDiecisieteDashboard($connectionpf);
        $resultadosQ18dashboard = $this->consultaDieciochoDashboard($connectionpf);
        // $resultadosQ19dashboard = $this->consultaDiecinueveDashboard($connectionpf);
        // $resultadosQ20dashboard = $this->consultaVeinteDashboard($connectionpf);
        // $resultadosQ21dashboard = $this->consultaVeintiUnoDashboard($connectionpf);



        // Pasar los datos a la vista
        return view('dashboardpf', [
            'resultadosQ13dashboard' => $resultadosQ13dashboard,
            'resultadosQ14dashboard' => $resultadosQ14dashboard,
            'resultadosQ15dashboard' => $resultadosQ15dashboard,
            'resultadosQ16dashboard' => $resultadosQ16dashboard,
            'resultadosQ17dashboard' => $resultadosQ17dashboard,
            'resultadosQ18dashboard' => $resultadosQ18dashboard,
            // 'resultadosQ19dashboard' => $resultadosQ19dashboard,
            // 'resultadosQ20dashboard' => $resultadosQ20dashboard,
            // 'resultadosQ21dashboard' => $resultadosQ21dashboard,

        ]);
    }

    //FUNCION REDIRIGIR A CONTACTO--------------------------------------------
    public function contacto()
    {


        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }

        // Guardar el nombre de la vista actual en la sesión
        Session::put('vista_actual', 'contacto');

        // Pasar los datos a la vista
        return view('contacto', []);
    }

    public function statsCtModal()
    {
        $connection = User::conexion();

        if ($connection == 'pgsql') {
            // Si la conexión es la predeterminada, retornar un mensaje de bienvenida para el admin
            return view('admin');
        } else {
            $resultadosQ9dashboard = $this->consultaNueveDashboard($connection);

            return view('components.stats-ct', compact('resultadosQ9dashboard'));
        }
    }

    public function recuperacionLecturasModal()
    {
        $connection = User::conexion();

        if ($connection == 'pgsql') {
            // Si la conexión es la predeterminada, retornar un mensaje de bienvenida para el admin
            return view('admin');
        } else {
            $resultadosQ12dashboard = $this->consultaDoceDashboard($connection);
            $resultadosQ10dashboard = $this->consultaDiezDashboard($connection);

            return view('components.recuperacion-lecturas', [
                'resultadosQ12dashboard' => $resultadosQ12dashboard,
                'resultadosQ10dashboard' => $resultadosQ10dashboard,
            ]);
        }
    }

    public function desequilibriosVoltajeModal($id_ct, Request $request)
    {
        $connection = User::conexion();

        if ($connection == 'pgsql') {
            return view('admin');
        } else {
            $desequilibrios = $this->getDesequilibrios($id_ct, $connection, $request);

            return view('components.desequilibrios-voltaje', [
                'desequilibrios' => $desequilibrios,
            ]);
        }
    }

    public function desequilibriosCorrienteModal($id_ct, Request $request)
    {
        $connection = User::conexion();

        if ($connection == 'pgsql') {
            return view('admin');
        } else {
            $desequilibrios = $this->getDesequilibrios($id_ct, $connection, $request);

            return view('components.desequilibrios-corriente', [
                'desequilibrios' => $desequilibrios,
            ]);
        }
    }

    public function promedioFaseRModal($id_ct, Request $request)
    {
        $connection = User::conexion();

        if ($connection == 'pgsql') {
            return view('admin');
        } else {
            $promedioFase = $this->getPromedioFase($id_ct, $connection, $request);
            $tensiones = $this -> getTensiones($id_ct, $connection, $request);

            return view('components.promedio-fase-r', [
                'promedioFase' => $promedioFase,
                'tensiones' => $tensiones
            ]);
        }
    }

    public function promedioFaseSModal($id_ct, Request $request)
    {
        $connection = User::conexion();

        if ($connection == 'pgsql') {
            return view('admin');
        } else {
            $promedioFase = $this->getPromedioFase($id_ct, $connection, $request);
            $tensiones = $this -> getTensiones($id_ct, $connection, $request);

            return view('components.promedio-fase-s', [
                'promedioFase' => $promedioFase,
                'tensiones' => $tensiones
            ]);
        }
    }

    public function promedioFaseTModal($id_ct, Request $request)
    {
        $connection = User::conexion();

        if ($connection == 'pgsql') {
            return view('admin');
        } else {
            $promedioFase = $this->getPromedioFase($id_ct, $connection, $request);
            $tensiones = $this -> getTensiones($id_ct, $connection, $request);

            return view('components.promedio-fase-t', [
                'promedioFase' => $promedioFase,
                'tensiones' => $tensiones
            ]);
        }
    }

    public function capacidadUltimoAnioModal($id_ct, Request $request)
    {
        $connection = User::conexion();

        if ($connection == 'pgsql') {
            return view('admin');
        } else {
            $capacidadUltimoAnio = $this->getCapacidadUltimoAnio($id_ct, $connection, $request);
        
            return view('components.capacidad-ultimo-anio', [
                'capacidadUltimoAnio' => $capacidadUltimoAnio,
            ]);
        }
    }


    //CONSULTAS para DASHBOARD CT--------------------------

    public function consultaUnoDashboard($connection) //consulta 50 del documento
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_trafos')
            ) {
                $resultadosQ1dashboard = DB::connection($connection)
                    ->select("
                    SELECT sum(t_trafos.val_kva) as cap_kva,
                    count(id_trafo) as nro_trafos
                    FROM core.t_trafos;");
                return $resultadosQ1dashboard ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }


    public function consultaDosDashboard($connection) //consulta 51 del documento
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_cups')
            ) {
                $resultadosQ2dashboard = DB::connection($connection)
                    ->select("
                    SELECT count(*) as nro_cups
                    FROM core.t_cups
                    Where cups_estado = 'A'
                    AND ind_repetidor = 'N'");
                return $resultadosQ2dashboard ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }


    public function consultaTresDashboard($connection) //consulta 52 del documento
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_cups')
            ) {
                $resultadosQ3dashboard = DB::connection($connection)
                    ->select("
                    SELECT count(*)  as contadores_prime
                    FROM core.t_cups
                    Where cups_estado = 'A'
                    AND ind_repetidor = 'N'
                        AND tip_equipo =  'SMT'");
                return $resultadosQ3dashboard ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }


    public function consultaCuatroDashboard($connection) //consulta 53 del documento
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_cups')
            ) {
                $resultadosQ4dashboard = DB::connection($connection)
                    ->select("
                    SELECT COUNT(*) AS contadores_otros 
                    FROM core.t_cups 
                    WHERE cups_estado = 'A'
                    AND ind_repetidor = 'N'
                    AND (tip_equipo <> 'SMT' OR tip_equipo IS NULL);");
                return $resultadosQ4dashboard ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }


    public function consultaCincoDashboard($connection) //consulta 54 del documento
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_g02_estadisticas_contadores')
            ) {
                $resultadosQ5dashboard = DB::connection($connection)
                    ->select("
                    SELECT CAST(TRUNC(avg(por_minutos_contador) * 100) / 100 AS DECIMAL(10,2)) as por_contadores_activos
                    FROM core.t_g02_estadisticas_contadores
                    WHERE fec_fin >= (SELECT MAX(fec_fin) FROM core.t_g02_estadisticas_contadores) - INTERVAL '7 days';   ");
                return $resultadosQ5dashboard ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }


    public function consultaSeisDashboard($connection) //consulta 55 del documento
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_indices_lectura')
            ) {
                $resultadosQ6dashboard = DB::connection($connection)
                    ->select("
                    SELECT 
                        count(core.t_indices_lectura.ind_s05) as lect_s05_hoy,
                        TO_CHAR(current_date, 'DD/MM/YYYY') as fecha
                    FROM core.t_indices_lectura
                    JOIN core.t_cups ON core.t_indices_lectura.id_cups = core.t_cups.id_cups
                    JOIN core.t_ct ON core.t_cups.id_ct = core.t_ct.id_ct
                    WHERE ind_s05 = 'S'
                    and core.t_cups.cups_estado = 'A' 
	                and core.t_cups.ind_repetidor = 'N'
                        AND fec_lectura = current_date
                        AND ori_s05 is not null");
                return $resultadosQ6dashboard ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }


    public function consultaSieteDashboard($connection) //consulta 56 del documento
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_indices_lectura')
            ) {
                $resultadosQ7dashboard = DB::connection($connection)
                    ->select("
                     SELECT  count(core.t_indices_lectura.ind_s04) as lect_s04_mes,
                        TO_CHAR(core.t_indices_lectura.fec_lectura, 'DD/MM/YYYY') AS fec_lectura
                    FROM core.t_indices_lectura, core.t_cups, core.t_ct
                        Where core.t_indices_lectura.ind_s04 = 'S'
                        and core.t_cups.cups_estado = 'A' 
                        and core.t_cups.ind_repetidor = 'N'
                        and core.t_indices_lectura .ori_s04 is not null
                        and extract (year from core.t_indices_lectura.fec_lectura) = extract(year from current_date)
                        and extract (month from core.t_indices_lectura.fec_lectura) = extract(month from current_date   )
                        and core.t_indices_lectura.id_cups = core.t_cups.id_cups
                        and core.t_cups.id_ct = core.t_ct.id_ct
                    GROUP BY fec_lectura
                    ");
                return $resultadosQ7dashboard ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }


    public function consultaOchoDashboard($connection) //consulta 57 del documento
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_indices_lectura')
            ) {
                $resultadosQ8dashboard = DB::connection($connection)
                    ->select("
                    SELECT count(core.t_indices_lectura.ind_s02) as lect_s02_hoy
                    FROM core.t_indices_lectura, core.t_cups, core.t_ct
                    Where ind_s02 = 'S'   
                    and core.t_cups.cups_estado = 'A' 
	                and core.t_cups.ind_repetidor = 'N'   
                    and ori_s02 is not null
                            and fec_lectura = current_date  
                            and core.t_indices_lectura.id_cups = core.t_cups.id_cups
                    and core.t_cups.id_ct = core.t_ct.id_ct");
                return $resultadosQ8dashboard ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }


    public function consultaNueveDashboard($connection) //consulta 58 del documento
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_indices_lectura')
            ) {
                $resultadosQ9dashboard = DB::connection($connection)
                    ->select("
                    SELECT 
                        core.t_ct.nom_ct,
                        TO_CHAR(CURRENT_DATE, 'DD/MM/YYYY') AS fec_lectura,

                        COUNT(DISTINCT core.t_cups.id_cups) AS total_cups_ct, -- TOTAL CONTADORES

                        COUNT(CASE WHEN t_indices_lectura.fec_lectura = CURRENT_DATE AND ind_s02 = 'S' THEN 1 END) AS lec_s02_hoy,
                        COUNT(CASE WHEN t_indices_lectura.fec_lectura = CURRENT_DATE AND ind_s05 = 'S' THEN 1 END) AS lec_s05_hoy,
                        COUNT(CASE WHEN t_indices_lectura.fec_lectura = CURRENT_DATE AND ind_s04 = 'S' THEN 1 END) AS lec_s04_hoy,

                        -- Porcentajes
                        CASE 
                            WHEN COUNT(DISTINCT core.t_cups.id_cups) = 0 THEN 0
                            ELSE TRUNC(
                                COUNT(CASE WHEN t_indices_lectura.fec_lectura = CURRENT_DATE AND ind_s02 = 'S' THEN 1 END)::numeric
                                / COUNT(DISTINCT core.t_cups.id_cups) * 100, 2)
                        END AS porcentaje_s02,

                        CASE 
                            WHEN COUNT(DISTINCT core.t_cups.id_cups) = 0 THEN 0
                            ELSE TRUNC(
                                COUNT(CASE WHEN t_indices_lectura.fec_lectura = CURRENT_DATE AND ind_s05 = 'S' THEN 1 END)::numeric
                                / COUNT(DISTINCT core.t_cups.id_cups) * 100, 2)
                        END AS porcentaje_s05,

                        CASE 
                            WHEN COUNT(DISTINCT core.t_cups.id_cups) = 0 THEN 0
                            ELSE TRUNC(
                                COUNT(CASE WHEN t_indices_lectura.fec_lectura = CURRENT_DATE AND ind_s04 = 'S' THEN 1 END)::numeric
                                / COUNT(DISTINCT core.t_cups.id_cups) * 100, 2)
                        END AS porcentaje_s04

                    FROM 
                        core.t_ct
                    LEFT JOIN core.t_cups 
                        ON core.t_ct.id_ct = core.t_cups.id_ct 
                        AND core.t_cups.cups_estado = 'A'
                        AND core.t_cups.ind_repetidor = 'N'
                        AND core.t_cups.tip_equipo = 'SMT'
                    LEFT JOIN core.t_indices_lectura 
                        ON core.t_indices_lectura.id_cups = core.t_cups.id_cups

                    GROUP BY core.t_ct.nom_ct
                    ORDER BY core.t_ct.nom_ct;
                ");

                return $resultadosQ9dashboard ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }

    public function consultaDiezDashboard($connection) //consulta 59 del documento
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_indices_lectura')
            ) {
                $resultadosQ10dashboard = DB::connection($connection)
                    ->select("
                    WITH tp_counts AS (
                        SELECT fec_lectura, COUNT(ind_s05) AS tp_count
                        FROM core.t_indices_lectura
                        WHERE ori_s05 = 'TP' 
                        AND fec_lectura >= CURRENT_DATE - INTERVAL '7 days' AND fec_lectura < CURRENT_DATE
                        GROUP BY fec_lectura
                    ),
                    stg_counts AS (
                        SELECT fec_lectura, COUNT(ind_s05) AS stg_count
                        FROM core.t_indices_lectura
                        WHERE ori_s05 = 'STG' 
                        AND fec_lectura >= CURRENT_DATE - INTERVAL '7 days' AND fec_lectura < CURRENT_DATE
                        GROUP BY fec_lectura
                    )
                    SELECT 
                        COALESCE(tp.fec_lectura, stg.fec_lectura) AS fec_lectura,
                        COALESCE(tp.tp_count, 0) AS tp_count,
                        COALESCE(stg.stg_count, 0) AS stg_count
                    FROM 
                        tp_counts tp
                    FULL JOIN 
                        stg_counts stg
                    ON 
                        tp.fec_lectura = stg.fec_lectura
                    ORDER BY fec_lectura;
                    
                    
                    ");
                // dd($resultadosQ10dashboard);
                return $resultadosQ10dashboard ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }

    public function consultaOnceDashboard($connection) //consulta 60 del documento
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_indices_lectura')
            ) {
                $resultadosQ11dashboard = DB::connection($connection)
                    ->select("
                    SELECT  fec_lectura, count(ind_s04), ori_s04
                    FROM core.t_indices_lectura
                    where ori_s04 is not null and
                        fec_lectura  >= current_date - INTERVAL '6 days'
                    Group by 1,3
                    ORder by 1");
                return $resultadosQ11dashboard ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }

    public function consultaDoceDashboard($connection) //consulta 61 del documento
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_indices_lectura')
            ) {
                $resultadosQ12dashboard = DB::connection($connection)
                    ->select("
                    WITH tp_counts AS (
                        SELECT fec_lectura, COUNT(ind_s02) AS tp_count
                        FROM core.t_indices_lectura
                        WHERE ori_s02 = 'TP' 
                        AND fec_lectura >= CURRENT_DATE - INTERVAL '7 days' AND fec_lectura < CURRENT_DATE
                        GROUP BY fec_lectura
                    ),
                    stg_counts AS (
                        SELECT fec_lectura, COUNT(ind_s02) AS stg_count
                        FROM core.t_indices_lectura
                        WHERE ori_s02 = 'STG' 
                        AND fec_lectura >= CURRENT_DATE - INTERVAL '7 days' AND fec_lectura < CURRENT_DATE
                        GROUP BY fec_lectura
                    )
                    SELECT 
                        COALESCE(tp.fec_lectura, stg.fec_lectura) AS fec_lectura,
                        COALESCE(tp.tp_count, 0) AS tp_count,
                        COALESCE(stg.stg_count, 0) AS stg_count
                    FROM 
                        tp_counts tp
                    FULL JOIN 
                        stg_counts stg
                    ON 
                        tp.fec_lectura = stg.fec_lectura
                    ORDER BY fec_lectura;
                    
                    ");
                // dd($resultadosQ12dashboard);
                return $resultadosQ12dashboard ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }

    //CONSULTAS para DASHBOARD PF--------------------------
    public function consultaTreceDashboard($connectionpf) //KPI Numero de Contadores por Distribuidora.
    {
        $user = Auth::user(); //obtenemos los datos del usuario autenticado
        $cod_id_group = $user->cod_id_group; //metemos el codigo del grupo del usuario autentiado en la variable
        $nombre = DB::connection($connectionpf)->getDatabaseName();
        try {
            $resultadosQ13dashboard = DB::connection($connectionpf)
                ->select("
                   SELECT count(id_cnt) as num_contadores
                    FROM t_meter_params_iec870
                    Where dso_id = $cod_id_group;
                    ");

            // dd($cod_id_group);
            // dd($resultadosQ13dashboard);
            return $resultadosQ13dashboard ?: ['message' => 'No hay datos'];
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }

    public function consultaCatorceDashboard($connectionpf) // Interrupciones de Servicio (Cortes)
{
    $user = Auth::user();
    $cod_id_group = $user->cod_id_group;

    try {
        $resultadosQ14dashboard = DB::connection($connectionpf)->select("
            SELECT
                COUNT(e.fh) AS cortes
            FROM t_dat_iec870_events e
            JOIN t_meter_params_iec870 mp
                ON e.id_cnt = mp.id_cnt
            WHERE
                e.dr = '52'
                AND e.spa = '3'
                AND e.spq = '0'
                AND e.spi = '1'
                AND mp.dso_id = :cod_id_group
                AND EXTRACT(MONTH FROM e.fh) = EXTRACT(MONTH FROM CURRENT_DATE)
        ", [
            'cod_id_group' => $cod_id_group
        ]);

        return $resultadosQ14dashboard ?: ['message' => 'No hay datos'];

    } catch (\Exception $e) {
        return ['message' => 'No hay datos'];
    }
}


    public function consultaQuinceDashboard($connectionpf) // Curvas Horarias Leídas (Mes Actual)
{
    $user = Auth::user();
    $cod_id_group = $user->cod_id_group;

    try {
        $resultadosQ15dashboard = DB::connection($connectionpf)->select("
            SELECT
                COUNT(lp.fh) AS leidas
            FROM t_dat_iec870_load_profile_2 lp
            JOIN t_meter_params_iec870 mp
                ON lp.id_cnt = mp.id_cnt
            WHERE
                mp.dso_id = :cod_id_group
                AND lp.fh >= date_trunc('month', CURRENT_DATE)
                AND lp.fh <  date_trunc('month', CURRENT_DATE) + INTERVAL '1 month'
        ", [
            'cod_id_group' => $cod_id_group
        ]);

        return $resultadosQ15dashboard ?: ['message' => 'No hay datos'];

    } catch (\Exception $e) {
        return ['message' => 'No hay datos'];
    }
}


    public function consultaDieciseisDashboard($connectionpf) // Curvas Horarias Inválidas (Mes Actual)
{
    $user = Auth::user();
    $cod_id_group = $user->cod_id_group;

    try {
        $resultadosQ16dashboard = DB::connection($connectionpf)->select("
            SELECT
                COUNT(lp2.fh) AS invalidas
            FROM t_dat_iec870_load_profile_2 lp2
            JOIN t_dat_iec870_load_profile_1 lp1
                ON lp2.id_cnt = lp1.id_cnt
               AND lp2.fh = lp1.fh
            JOIN t_meter_params_iec870 mp
                ON lp2.id_cnt = mp.id_cnt
            WHERE
                mp.dso_id = :cod_id_group
                AND lp1.ai_bc = 128
                AND lp2.fh >= date_trunc('month', CURRENT_DATE)
                AND lp2.fh <  date_trunc('month', CURRENT_DATE) + INTERVAL '1 month'
        ", [
            'cod_id_group' => $cod_id_group
        ]);

        return $resultadosQ16dashboard ?: ['message' => 'No hay datos'];

    } catch (\Exception $e) {
        return ['message' => 'No hay datos'];
    }
}


    public function consultaDiecisieteDashboard($connectionpf) //Excesos de Potencia 
    {
        $user = Auth::user(); //obtenemos los datos del usuario autenticado
        $cod_id_group = $user->cod_id_group; //metemos el codigo del grupo del usuario autentiado en la variable

        try {
            $resultadosQ17dashboard = DB::connection($connectionpf)
                ->select("
                 SELECT count(t_dat_iec870_monthly_billing.fhi) excesos_potencia
                FROM t_dat_iec870_monthly_billing,t_meter_params_iec870
                Where t_dat_iec870_monthly_billing.id_cnt = t_meter_params_iec870.id_cnt and
                t_meter_params_iec870.dso_id = $cod_id_group 
                and t_dat_iec870_monthly_billing.e_act_exceso > 0
                    ");

            // dd($cod_id_group);
            // dd($resultadosQ17dashboard);
            return $resultadosQ17dashboard ?: ['message' => 'No hay datos'];
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }

    public function consultaDieciochoDashboard($connectionpf) // PUNTOS de medida
{
    $user = Auth::user();
    $cod_id_group = $user->cod_id_group;

    try {
        $resultadosQ18dashboard = DB::connection($connectionpf)->select("
            SELECT 
                t_meter_params_iec870.id_cnt AS contador,
                t_meter_params_iec870.id_cups AS cups,
                t_meter_params_iec870.cnt_password AS clave,
                t_reader_meter_data.voltage_primary AS trafos_intensidad1,
                t_reader_meter_data.voltage_secondary AS trafos_intensidad2,
                t_reader_meter_data.current_primary AS trafos_tension1,
                t_reader_meter_data.current_secondary AS trafos_tension2,
                t_reader_meter_data.tip_cups AS tipo_punto_medida,
                t_reader_connections.conx_name AS tipo_conexion,
                uc.fecha_ultima_curva,
                uc2.fecha_ultima_curva_15,
                ulc.fecha_ultima_cierre,
                ue.fecha_ultimo_evento
            FROM t_meter_params_iec870
            JOIN t_reader_meter_data 
                ON t_meter_params_iec870.id_cnt = t_reader_meter_data.id_cnt
            JOIN t_reader_connections 
                ON t_meter_params_iec870.conx_id = t_reader_connections.conx_id
            LEFT JOIN (
                SELECT DISTINCT ON (id_cnt) 
                    id_cnt, 
                    TO_CHAR(fh, 'DD/MM/YYYY HH24:MI:SS') AS fecha_ultima_curva
                FROM t_dat_iec870_load_profile_2
                ORDER BY id_cnt, fh DESC
            ) uc ON t_meter_params_iec870.id_cnt = uc.id_cnt
            LEFT JOIN (
                SELECT DISTINCT ON (id_cnt) 
                    id_cnt, 
                    TO_CHAR(fh, 'DD/MM/YYYY HH24:MI:SS') AS fecha_ultima_curva_15
                FROM t_dat_iec870_load_profile_2
                ORDER BY id_cnt, fh DESC
            ) uc2 ON t_meter_params_iec870.id_cnt = uc2.id_cnt
            LEFT JOIN (
                SELECT DISTINCT ON (id_cnt) 
                    id_cnt, 
                    TO_CHAR(fhf, 'DD/MM/YYYY HH24:MI:SS') AS fecha_ultima_cierre
                FROM t_dat_iec870_monthly_billing
                ORDER BY id_cnt, fhf DESC
            ) ulc ON t_meter_params_iec870.id_cnt = ulc.id_cnt
            LEFT JOIN (
                SELECT DISTINCT ON (id_cnt) 
                    id_cnt, 
                    fh AS fecha_ultimo_evento
                FROM t_dat_iec870_events
                ORDER BY id_cnt, fh DESC
            ) ue ON t_meter_params_iec870.id_cnt = ue.id_cnt
            WHERE t_meter_params_iec870.dso_id = :cod_id_group
            LIMIT 100;
        ", [
            'cod_id_group' => $cod_id_group
        ]);

        return $resultadosQ18dashboard ?: ['message' => 'No hay datos'];

    } catch (\Exception $e) {
        return ['message' => 'No hay datos'];
    }
}


    public function consultaDiecinueveDashboard($connectionpf) //fecha ultimo cierre
    {
        $user = Auth::user(); //obtenemos los datos del usuario autenticado
        $cod_id_group = $user->cod_id_group; //metemos el codigo del grupo del usuario autentiado en la variable

        try {
            $query = '
            SELECT MAX(id) as max_id, DATE_FORMAT(t_dat_iec870_monthly_billing.fhf, "%d/%m/%Y %H:%i:%s") as fecha_ultima_cierre
            FROM t_dat_iec870_monthly_billing, t_meter_params_iec870
            WHERE t_meter_params_iec870.cod_id_group = ' . $cod_id_group . '
            AND t_dat_iec870_monthly_billing.id_cnt = t_meter_params_iec870.id_cnt
            GROUP BY 2
            ORDER BY 1 DESC
            LIMIT 1
        ';

            $resultadosQ19dashboard = DB::connection($connectionpf)->select($query);

            // dd($cod_id_group);
            // dd($resultadosQ19dashboard);
            return $resultadosQ19dashboard ?: ['message' => 'No hay datos'];
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }

    public function consultaVeinteDashboard($connectionpf) //fecha ultima curva
    {
        $user = Auth::user(); //obtenemos los datos del usuario autenticado
        $cod_id_group = $user->cod_id_group; //metemos el codigo del grupo del usuario autentiado en la variable

        try {
            $query = '
            SELECT MAX(id) as max_id, DATE_FORMAT(t_dat_iec870_load_profile_2.fh, "%d/%m/%Y %H:%i:%s") as fecha_ultima_curva
                FROM t_dat_iec870_load_profile_2, t_meter_params_iec870
                WHERE t_meter_params_iec870.cod_id_group = ' . $cod_id_group . '
                AND t_dat_iec870_load_profile_2.id_cnt = t_meter_params_iec870.id_cnt
                GROUP BY 2
                ORDER BY 1 DESC
                LIMIT 1
                ';

            $resultadosQ20dashboard = DB::connection($connectionpf)->select($query);

            // dd($cod_id_group);
            // dd($resultadosQ20dashboard);
            return $resultadosQ20dashboard ?: ['message' => 'No hay datos'];
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }

    public function consultaVeintiUnoDashboard($connectionpf) //fecha ultimo evento
    {
        $user = Auth::user(); //obtenemos los datos del usuario autenticado
        $cod_id_group = $user->cod_id_group; //metemos el codigo del grupo del usuario autentiado en la variable

        try {
            $query = '
            SELECT MAX(id) as max_id, t_dat_iec870_eventos.fh as fecha_ultimo_evento
                FROM t_dat_iec870_eventos,t_meter_params_iec870
                WHERE t_meter_params_iec870.cod_id_group = ' . $cod_id_group . '
                AND t_dat_iec870_eventos.id_cnt = t_meter_params_iec870.id_cnt
                group by 2
                order by 1 desc
                limit 1
                ';

            $resultadosQ21dashboard = DB::connection($connectionpf)->select($query);

            // dd($cod_id_group);
            // dd($resultadosQ21dashboard);
            return $resultadosQ21dashboard ?: ['message' => 'No hay datos'];
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }

    public function consultaVeintiDosDashboard($connection)
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_cups')
            ) {
                $resultadosQ22dashboard = DB::connection($connection)
                    ->select("
                    SELECT count(*) as nro_cups
                    FROM core.t_cups
                    Where cups_estado = 'A'
                    AND ind_autoconsumo = 'S'");
                return $resultadosQ22dashboard ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }

    public function getDashboardInfo($connection)
    {
        try {
            if (Schema::connection($connection)->hasTable('t_ct')) {
                $query = "
                    WITH trafos_por_ct AS (
                        SELECT 
                            c.id_ct,
                            COUNT(DISTINCT t.id_trafo) AS nro_trafos,
                            SUM(t.val_kva) AS capacidad_kva,
                            AVG(t.val_kva) AS val_kva_promedio
                        FROM core.t_concentradores c
                        JOIN core.t_trafos t ON t.id_cnc = c.id_cnc
                        GROUP BY c.id_ct
                    ),
                    lineas_por_ct AS (
					    SELECT 
					        c.id_ct,
					        COUNT(DISTINCT l.id_linea) AS nro_lineas
					    FROM core.t_lineas l
					    JOIN core.t_trafos t ON t.id_trafo = l.id_trafo
					    JOIN core.t_concentradores c ON c.id_cnc = t.id_cnc
					    GROUP BY c.id_ct
					),
                    cups_por_ct AS (
                        SELECT id_ct,
                            COUNT(DISTINCT id_cups) AS nro_cups
                        FROM core.t_cups
                        GROUP BY id_ct
                    ),
                    voltajes_por_ct AS (
                        SELECT 
                            c.id_ct,
                            AVG(((sv.val_kva_t)/1000)*100) AS val_kva_t_prom
                        FROM core.t_concentradores c
                        JOIN core.t_supervisores_voltajes sv ON sv.id_cnc = c.id_cnc
                        GROUP BY c.id_ct
                    ),
                    balance_ct AS (
                        SELECT
                            id_ct,
                            (val_ai_d_sum_svr + val_ae_d_sum_cnt - val_ai_d_sum_cnt - val_ae_d_sum_svr) AS perdida,
                            ROUND(
			            	((val_ai_d_sum_svr + val_ae_d_sum_cnt - val_ai_d_sum_cnt - val_ae_d_sum_svr)* 100.0) 
			      			/ (val_ai_d_sum_svr + val_ae_d_sum_cnt),1) as porcentaje_perdida 
                        FROM core.t_balances_diarios
                        WHERE tip_calculo = 1
                        AND val_ai_d_sum_svr > 0
                        AND fec_inicio = (
                                SELECT MAX(fec_inicio)
                                FROM core.t_balances_diarios b2
                                WHERE b2.id_ct = core.t_balances_diarios.id_ct
                                AND b2.tip_calculo = 1
                        )
                    ),
                    desbalance_ct AS (
                        SELECT 
                            tc.id_ct,
                            ROUND(AVG(tsv.pct_deseq_voltaje)::numeric, 2) AS avg_pct_deseq_voltaje,
                            ROUND(AVG(tsv.pct_deseq_corriente)::numeric, 2) AS avg_pct_deseq_corriente
                        FROM core.t_supervisores_voltajes tsv
                        JOIN core.t_concentradores tc ON tsv.id_cnc = tc.id_cnc
                        WHERE tsv.fec_registro >= (
                                (SELECT MAX(fec_registro) FROM core.t_supervisores_voltajes) - INTERVAL '48 hours'
                            )
                        GROUP BY tc.id_ct
                    ),
                    prom_voltajes_ct AS (
                        SELECT
                            tc.id_ct,
                            CEIL(AVG(tsv.val_voltaje_1)) AS prom_volt1,
                            CEIL(AVG(tsv.val_voltaje_2)) AS prom_volt2,
                            CEIL(AVG(tsv.val_voltaje_3)) AS prom_volt3
                        FROM core.t_supervisores_voltajes tsv
                        JOIN core.t_concentradores tc ON tsv.id_cnc = tc.id_cnc
                        WHERE tsv.fec_registro >= (
                                (SELECT MAX(fec_registro) FROM core.t_supervisores_voltajes) - INTERVAL '48 hours'
                            )
                        GROUP BY tc.id_ct
                    )
                    SELECT
                        ct.id_ct,
                        ct.nom_ct AS nombre_ct,
                        COALESCE(t.nro_trafos,0) AS nro_trafos,
                        COALESCE(t.capacidad_kva,0) AS capacidad_kva,
                        COALESCE(l.nro_lineas,0) AS nro_lineas,
                        COALESCE(c.nro_cups,0) AS nro_cups,
                        COALESCE(v.val_kva_t_prom / t.val_kva_promedio,0) AS cap_instalada,
                        COALESCE(b.perdida,0) AS perdida,
                        COALESCE(b.porcentaje_perdida,0) AS porcentaje_perdida,
                        COALESCE(d.avg_pct_deseq_voltaje, 0) AS avg_pct_deseq_voltaje,
                        COALESCE(d.avg_pct_deseq_corriente, 0) AS avg_pct_deseq_corriente,
                        COALESCE(p.prom_volt1, 0) AS prom_volt1,
                        COALESCE(p.prom_volt2, 0) AS prom_volt2,
                        COALESCE(p.prom_volt3, 0) AS prom_volt3
                    FROM core.t_ct ct
                    LEFT JOIN trafos_por_ct t ON t.id_ct = ct.id_ct
                    LEFT JOIN lineas_por_ct l ON l.id_ct = ct.id_ct
                    LEFT JOIN cups_por_ct c ON c.id_ct = ct.id_ct
                    LEFT JOIN voltajes_por_ct v ON v.id_ct = ct.id_ct
                    LEFT JOIN balance_ct b ON b.id_ct = ct.id_ct
                    LEFT JOIN desbalance_ct d ON d.id_ct = ct.id_ct
                    LEFT JOIN prom_voltajes_ct p ON p.id_ct = ct.id_ct
                    ORDER BY ct.nom_ct
                ";

                $dashboardInfo = DB::connection($connection)->select($query);

                return $dashboardInfo ?: ['message' => 'No hay datos'];
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            return ['message' => 'No hay datos error', $e];
        }
    }

    public function getDesequilibrios($id_ct, $connection, Request $request) //porcentaje desequilibrio
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
                tc.id_ct = :id_ct 
                AND 
                        tsv.fec_registro >= (
                            SELECT 
                                MAX(fec_registro) 
                            FROM 
                                core.t_supervisores_voltajes
                        ) - INTERVAL '48 hours'
                    GROUP BY tc.id_ct";
            $params = ['id_ct' => $id_ct];

            $resultadosQ47 = DB::connection($connection)->select($query, $params);

            return $resultadosQ47 ?: [];
        }
    }

    public function getPromedioFase($id_ct, $connection, Request $request)
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_supervisores_voltajes') &&
                Schema::connection($connection)->hasTable('t_concentradores')
            ) {
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
                        AND core.t_supervisores_voltajes.fec_registro >= (
                            SELECT MAX(core.t_supervisores_voltajes.fec_registro) 
                            FROM core.t_supervisores_voltajes
                        ) - INTERVAL '48 hours'
                    ";

                $params = ['id_ct' => $id_ct];     

                // Agregar el ordenamiento
                $query .= " GROUP BY 
                            t_supervisores_voltajes.id_cnc, 
                            t_supervisores_voltajes.id_svr, 
                            t_concentradores.id_ct;";

                $promedioFase = DB::connection($connection)->select($query, $params);

                return $promedioFase ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico 
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }

    public function getTensiones($id_ct, $connection, Request $request)
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_supervisores_voltajes') &&
                Schema::connection($connection)->hasTable('t_concentradores')
            ) {
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
                    AND core.t_supervisores_voltajes.fec_registro >= (
                        SELECT MAX(core.t_supervisores_voltajes.fec_registro) 
                        FROM core.t_supervisores_voltajes
                    ) - INTERVAL '48 hours'
                ";
                    $params = ['id_ct' => $id_ct];

                // Agregar el ordenamiento
                $query .= " ORDER BY core.t_supervisores_voltajes.fec_registro ASC";

                // Ejecutar la consulta con los parámetros adecuados
                $tensiones = DB::connection($connection)->select($query, $params);

                return $tensiones ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico 
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }

    public function getCapacidadUltimoAnio($id_ct, $connection)
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_supervisores_voltajes') &&
                Schema::connection($connection)->hasTable('t_trafos') &&
                Schema::connection($connection)->hasTable('t_concentradores') &&
                Schema::connection($connection)->hasTable('t_ct')
            ) {
                $capacidadUltimoAnio = DB::connection($connection)
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

                return $capacidadUltimoAnio ?: ['message' => 'No hay datos'];
            } else {
                // Una de las tablas no existe, retornar un mensaje específico 
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }


}
