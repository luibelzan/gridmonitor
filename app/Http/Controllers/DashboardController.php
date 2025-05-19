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
            $resultadosQ9dashboard = $this->consultaNueveDashboard($connection);
            $resultadosQ10dashboard = $this->consultaDiezDashboard($connection);
            $resultadosQ11dashboard = $this->consultaOnceDashboard($connection);
            $resultadosQ12dashboard = $this->consultaDoceDashboard($connection);
            $resultadosQ22dashboard = $this->consultaVeintiDosDashboard($connection);



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
                'resultadosQ9dashboard' => $resultadosQ9dashboard,
                'resultadosQ10dashboard' => $resultadosQ10dashboard,
                'resultadosQ11dashboard' => $resultadosQ11dashboard,
                'resultadosQ12dashboard' => $resultadosQ12dashboard,
                'resultadosQ22dashboard' => $resultadosQ22dashboard,

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
                            
                            -- Contamos el total de lecturas S02, S05 y S04, tanto las exitosas (S) como las no exitosas (N)
                            COUNT(CASE WHEN t_indices_lectura.fec_lectura = CURRENT_DATE AND ind_s02 = 'S' THEN 1 END) AS Lec_s02_hoy,
                            COUNT(CASE WHEN t_indices_lectura.fec_lectura = CURRENT_DATE AND ind_s02 = 'N' THEN 1 END) AS No_Lec_s02_hoy,
                            COUNT(CASE WHEN t_indices_lectura.fec_lectura = CURRENT_DATE AND ind_s05 = 'S' THEN 1 END) AS Lec_s05_hoy,
                            COUNT(CASE WHEN t_indices_lectura.fec_lectura = CURRENT_DATE AND ind_s05 = 'N' THEN 1 END) AS No_Lec_s05_hoy,
                            COUNT(CASE WHEN t_indices_lectura.fec_lectura = CURRENT_DATE AND ind_s04 = 'S' THEN 1 END) AS Lec_s04_hoy,
                            COUNT(CASE WHEN t_indices_lectura.fec_lectura = CURRENT_DATE AND ind_s04 = 'N' THEN 1 END) AS No_Lec_s04_hoy,
                            -- Calculamos el total de lecturas (exitosas y no exitosas) para cada tipo de reporte (S02, S05, S04)
                            COUNT(CASE WHEN t_indices_lectura.fec_lectura = CURRENT_DATE AND (ind_s02 = 'S' OR ind_s02 = 'N') THEN 1 END) AS total_s02,
                            COUNT(CASE WHEN t_indices_lectura.fec_lectura = CURRENT_DATE AND (ind_s05 = 'S' OR ind_s05 = 'N') THEN 1 END) AS total_s05,
                            COUNT(CASE WHEN t_indices_lectura.fec_lectura = CURRENT_DATE AND (ind_s04 = 'S' OR ind_s04 = 'N') THEN 1 END) AS total_s04,


                            -- Calculamos el porcentaje basado solo en las lecturas exitosas (S) / total de centros con lectura
                            CASE 
                                WHEN COUNT(CASE WHEN t_indices_lectura.fec_lectura = CURRENT_DATE AND ind_s02 = 'S' THEN 1 END) = 0 THEN 0
                                ELSE TRUNC(
                                    (COUNT(CASE WHEN t_indices_lectura.fec_lectura = CURRENT_DATE AND ind_s02 = 'S' THEN 1 END)::numeric / 
                                    COUNT(CASE WHEN t_indices_lectura.fec_lectura = CURRENT_DATE AND (ind_s02 = 'S' OR ind_s02 = 'N') THEN 1 END)) * 100, 2
                                )
                            END AS porcentaje_s02,

                            CASE 
                                WHEN COUNT(CASE WHEN t_indices_lectura.fec_lectura = CURRENT_DATE AND ind_s05 = 'S' THEN 1 END) = 0 THEN 0
                                ELSE TRUNC(
                                    (COUNT(CASE WHEN t_indices_lectura.fec_lectura = CURRENT_DATE AND ind_s05 = 'S' THEN 1 END)::numeric / 
                                    COUNT(CASE WHEN t_indices_lectura.fec_lectura = CURRENT_DATE AND (ind_s05 = 'S' OR ind_s05 = 'N') THEN 1 END)) * 100, 2
                                )
                            END AS porcentaje_s05,

                            CASE 
                                WHEN COUNT(CASE WHEN t_indices_lectura.fec_lectura = CURRENT_DATE AND ind_s04 = 'S' THEN 1 END) = 0 THEN 0
                                ELSE TRUNC(
                                    (COUNT(CASE WHEN t_indices_lectura.fec_lectura = CURRENT_DATE AND ind_s04 = 'S' THEN 1 END)::numeric / 
                                    COUNT(CASE WHEN t_indices_lectura.fec_lectura = CURRENT_DATE AND (ind_s04 = 'S' OR ind_s04 = 'N') THEN 1 END)) * 100, 2
                                )
                            END AS porcentaje_s04

                        FROM 
                            core.t_ct
                        LEFT JOIN core.t_cups ON core.t_ct.id_ct = core.t_cups.id_ct 
                            AND core.t_cups.cups_estado = 'A'
                            AND core.t_cups.ind_repetidor = 'N'
                            AND core.t_cups.tip_equipo = 'SMT'
                        LEFT JOIN core.t_indices_lectura ON core.t_indices_lectura.id_cups = core.t_cups.id_cups

                        GROUP BY 
                            core.t_ct.nom_ct
                        ORDER BY 
                            core.t_ct.nom_ct;

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

        try {
            $resultadosQ13dashboard = DB::connection($connectionpf)
                ->select("
                   SELECT count(id_cnt) as num_contadores
                    FROM reader.t_meter_params_iec870
                    Where cod_id_group = $cod_id_group;
                    ");

            // dd($cod_id_group);
            // dd($resultadosQ13dashboard);
            return $resultadosQ13dashboard ?: ['message' => 'No hay datos'];
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }

    public function consultaCatorceDashboard($connectionpf) //Interrupciones de Servicio (Cortes)
    {
        $user = Auth::user(); //obtenemos los datos del usuario autenticado
        $cod_id_group = $user->cod_id_group; //metemos el codigo del grupo del usuario autentiado en la variable

        try {
            $resultadosQ14dashboard = DB::connection($connectionpf)
                ->select("
                 SELECT count(t_dat_iec870_eventos.fh) AS cortes
                    FROM
                        t_dat_iec870_eventos,t_meter_params_iec870
                    WHERE
                        t_dat_iec870_eventos.DR = '52'
                        AND t_dat_iec870_eventos.SPA = '3'
                        AND t_dat_iec870_eventos.SPQ = '0'
                        AND t_dat_iec870_eventos.SPI = '1'
                        AND t_dat_iec870_eventos.id_cnt = t_meter_params_iec870.id_cnt
                        AND t_meter_params_iec870.cod_id_group = $cod_id_group
                        AND month(t_dat_iec870_eventos.fh) = month (current_date);
                    ");

            // dd($cod_id_group);
            // dd($resultadosQ14dashboard);
            return $resultadosQ14dashboard ?: ['message' => 'No hay datos'];
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }

    public function consultaQuinceDashboard($connectionpf) //Curvas Horarias Leidas (Mes Actual)
    {
        $user = Auth::user(); //obtenemos los datos del usuario autenticado
        $cod_id_group = $user->cod_id_group; //metemos el codigo del grupo del usuario autentiado en la variable

        try {
            $resultadosQ15dashboard = DB::connection($connectionpf)
                ->select("
                 SELECT count(t_dat_iec870_load_profile_1.fh) as leidas
                FROM reader.t_dat_iec870_load_profile_1, t_meter_params_iec870
                Where t_dat_iec870_load_profile_1.id_cnt = t_meter_params_iec870.id_cnt and
                t_meter_params_iec870.cod_id_group = $cod_id_group
                and month(t_dat_iec870_load_profile_1.fh) = month(current_date)
                    ");

            // dd($cod_id_group);
            // dd($resultadosQ15dashboard);
            return $resultadosQ15dashboard ?: ['message' => 'No hay datos'];
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }

    public function consultaDieciseisDashboard($connectionpf) //Curvas Horarias Invalidas (Mes Actual)
    {
        $user = Auth::user(); //obtenemos los datos del usuario autenticado
        $cod_id_group = $user->cod_id_group; //metemos el codigo del grupo del usuario autentiado en la variable

        try {
            $resultadosQ16dashboard = DB::connection($connectionpf)
                ->select("
                 SELECT count(t_dat_iec870_load_profile_1.fh)  as invalidas
                FROM reader.t_dat_iec870_load_profile_1,t_meter_params_iec870
                Where t_dat_iec870_load_profile_1.id_cnt = t_meter_params_iec870.id_cnt and
                t_meter_params_iec870.cod_id_group = $cod_id_group
                and month(t_dat_iec870_load_profile_1.fh) = month(current_date) and
                t_dat_iec870_load_profile_1.e_act_imp_cualif > 0
                    ");

            // dd($cod_id_group);
            // dd($resultadosQ16dashboard);
            return $resultadosQ16dashboard ?: ['message' => 'No hay datos'];
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
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
                FROM reader.t_dat_iec870_monthly_billing,t_meter_params_iec870
                Where t_dat_iec870_monthly_billing.id_cnt = t_meter_params_iec870.id_cnt and
                t_meter_params_iec870.cod_id_group = $cod_id_group 
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

    public function consultaDieciochoDashboard($connectionpf) //PUNTOS de medida
    {
        $user = Auth::user(); //obtenemos los datos del usuario autenticado
        $cod_id_group = $user->cod_id_group; //metemos el codigo del grupo del usuario autentiado en la variable

        try {
            $resultadosQ18dashboard = DB::connection($connectionpf)
                ->select("
                    SELECT 
    t_meter_params_iec870.id_cnt AS Contador,
    t_meter_params_iec870.cups AS CUPS,
    t_meter_params_iec870.description AS Descripcion,
    t_meter_params_iec870.password AS Clave,
    t_reader_meter_data.rel_trafos_intensidad AS Trafos_Intensidad,
    t_reader_meter_data.rel_trafos_tension AS Trafos_Tension,
    t_reader_meter_data.tip_punto_medida AS Tipo_Punto_Medida,      
    t_reader_connections.conx_name AS Tipo_Conexion,
    uc.fecha_ultima_curva,
    uc2.fecha_ultima_curva_15,
    ulc.fecha_ultima_cierre,
    ue.fecha_ultimo_evento
FROM 
    t_meter_params_iec870
    JOIN t_reader_meter_data ON t_meter_params_iec870.id_cnt = t_reader_meter_data.id_cnt
    JOIN t_reader_connections ON t_meter_params_iec870.cod_id_conx = t_reader_connections.cod_id_conx
    LEFT JOIN (
        SELECT 
            id_cnt,
            DATE_FORMAT(fh, '%d/%m/%Y %H:%i:%s') AS fecha_ultima_curva
        FROM 
            t_dat_iec870_load_profile_2
        WHERE id IN (
            SELECT MAX(id)
            FROM t_dat_iec870_load_profile_2
            GROUP BY id_cnt
        )
    ) uc ON t_meter_params_iec870.id_cnt = uc.id_cnt
    LEFT JOIN (
        SELECT 
            id_cnt,
            DATE_FORMAT(fh, '%d/%m/%Y %H:%i:%s') AS fecha_ultima_curva_15
        FROM 
            t_dat_iec870_load_profile_1
        WHERE id IN (
            SELECT MAX(id)
            FROM t_dat_iec870_load_profile_1
            GROUP BY id_cnt
        )
    ) uc2 ON t_meter_params_iec870.id_cnt = uc2.id_cnt
    LEFT JOIN (
        SELECT 
            id_cnt,
            DATE_FORMAT(fhf, '%d/%m/%Y %H:%i:%s') AS fecha_ultima_cierre
        FROM 
            t_dat_iec870_monthly_billing
        WHERE id IN (
            SELECT MAX(id)
            FROM t_dat_iec870_monthly_billing
            GROUP BY id_cnt
        )
    ) ulc ON t_meter_params_iec870.id_cnt = ulc.id_cnt
    LEFT JOIN (
        SELECT 
            id_cnt,
            fh AS fecha_ultimo_evento
        FROM 
            t_dat_iec870_eventos
        WHERE id IN (
            SELECT MAX(id)
            FROM t_dat_iec870_eventos
            GROUP BY id_cnt
        )
    ) ue ON t_meter_params_iec870.id_cnt = ue.id_cnt
WHERE 
    t_meter_params_iec870.cod_id_group = " . $cod_id_group . "
LIMIT 0, 100;
                    ");

            // dd($cod_id_group);
            // dd($resultadosQ18dashboard);
            return $resultadosQ18dashboard ?: ['message' => 'No hay datos'];
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
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
}
