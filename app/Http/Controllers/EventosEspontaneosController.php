<?php

namespace App\Http\Controllers;

use App\Exports\EventosEspontaneosExport;
use App\Models\Ct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;




class EventosEspontaneosController extends Controller
{
    public function eventosespontaneos(Request $request)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página de inicio de sesión
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado por inactividad.');
        }

        // Guardar el nombre de la vista actual en la sesión
        Session::put('vista_actual', 'eventosespontaneos');

        // Obtener la conexión dinámica
        $connection = User::conexion();

        if ($connection == 'pgsql') {
            // Si la conexión es la predeterminada, retornar un mensaje de bienvenida para el admin
            return view('admin/admin');
        } else {
            // Obtener los datos de todos los CTs
            $ct_info = Ct::on($connection)->select('id_ct', 'nom_ct', 'lat_ct', 'lon_ct', 'dir_ct')->get();

            // Obtener los resultados de las consultas de eventos
            $resultadosQ1Eventos = $this->consultaUnoEventosEspontaneos($request, $connection);
            $resultadosQ2Eventos = $this->consultaDosEventosEspontaneos($request, $connection);
            $resultadosQ3Eventos = $this->consultaTresEventosEspontaneos($request, $connection);
            $resultadosQ4Eventos = $this->consultaCuatroEventosEspontaneos($request, $connection);
            $resultadosQ5Eventos = $this->consultaCincoEventosEspontaneos($request, $connection);
            $resultadosQ6Eventos = $this->consultaSeisEventosEspontaneos($request, $connection);
            $resultadosQ1EventosPaginate = $this->consultaUnoEventosEspontaneosPaginate($request, $connection);

            // Crear un mapa (array asociativo) de conteos de eventos por ID de CT
            $conteoEventosPorCt = [];

            // Agregar conteo de Q2
            foreach ($resultadosQ2Eventos as $evento) {
                // Verificar que $evento es un objeto y tiene la propiedad 'id_ct'
                if (is_object($evento) && property_exists($evento, 'id_ct')) {
                    if (!isset($conteoEventosPorCt[$evento->id_ct])) {
                        $conteoEventosPorCt[$evento->id_ct] = [
                            'total_eventos_contador' => 0,
                            'total_eventos_concentrador' => 0
                        ];
                    }
                    $conteoEventosPorCt[$evento->id_ct]['total_eventos_contador'] += $evento->total_eventos;
                }
            }
            // Agregar conteo de Q4
            foreach ($resultadosQ4Eventos as $evento) {
                // Verificar que $evento es un objeto y tiene la propiedad 'id_ct'
                if (is_object($evento) && property_exists($evento, 'id_ct')) {
                    if (!isset($conteoEventosPorCt[$evento->id_ct])) {
                        $conteoEventosPorCt[$evento->id_ct] = [
                            'total_eventos_contador' => 0,
                            'total_eventos_concentrador' => 0
                        ];
                    }
                    $conteoEventosPorCt[$evento->id_ct]['total_eventos_concentrador'] += $evento->total_eventos;
                }
            }

            // Añadir el conteo de eventos a los resultados de Q1
            foreach ($resultadosQ1Eventos as &$evento) {
                // Verificar que $evento es un objeto y tiene la propiedad 'id_ct'
                if (is_object($evento) && property_exists($evento, 'id_ct')) {
                    if (isset($conteoEventosPorCt[$evento->id_ct])) {
                        $evento->total_eventos_contador = $conteoEventosPorCt[$evento->id_ct]['total_eventos_contador'];
                        $evento->total_eventos_concentrador = $conteoEventosPorCt[$evento->id_ct]['total_eventos_concentrador'];
                        $evento->total_eventos = $evento->total_eventos_contador + $evento->total_eventos_concentrador;
                    } else {
                        $evento->total_eventos_contador = 0;
                        $evento->total_eventos_concentrador = 0;
                        $evento->total_eventos = 0;
                    }
                }
            }
            // Combinar los resultados finales con el total de eventos para cada CT
            foreach ($ct_info as $ct) {
                $id_ct = $ct->id_ct;

                // Asignar los totales de eventos a los datos del CT
                if (isset($conteoEventosPorCt[$id_ct])) {
                    $ct->total_eventos_contador = $conteoEventosPorCt[$id_ct]['total_eventos_contador'];
                    $ct->total_eventos_concentrador = $conteoEventosPorCt[$id_ct]['total_eventos_concentrador'];
                    $ct->total_eventos = $ct->total_eventos_contador + $ct->total_eventos_concentrador;
                } else {
                    // Si no hay eventos, asignar 0
                    $ct->total_eventos_contador = 0;
                    $ct->total_eventos_concentrador = 0;
                    $ct->total_eventos = 0;
                }
            }

            // Pasar los datos de los CTs a la vista
            return view('eventosespontaneos/eventosespontaneos', [
                'ct_info' => $ct_info,
                'resultadosQ1Eventos' => $resultadosQ1Eventos,
                'resultadosQ2Eventos' => $resultadosQ2Eventos,
                'resultadosQ3Eventos' => $resultadosQ3Eventos,
                'resultadosQ4Eventos' => $resultadosQ4Eventos,
                'resultadosQ5Eventos' => $resultadosQ5Eventos,
                'resultadosQ6Eventos' => $resultadosQ6Eventos,
                'resultadosQ1EventosPaginate' => $resultadosQ1EventosPaginate,


            ]);
        }
    }


    //CONSULTAS ----------------------------
    public function consultaUnoEventosEspontaneos(Request $request, $connection) //Eventos contador
{
    try {
        // Verificar la existencia de las tablas
        if (
            Schema::connection($connection)->hasTable('t_ct') &&
            Schema::connection($connection)->hasTable('s13') &&
            Schema::connection($connection)->hasTable('t_cups') &&
            Schema::connection($connection)->hasTable('t_descripcion_eventos_contador') &&
            Schema::connection($connection)->hasTable('t_eventos_contador')
        ) {
            // Obtener las fechas de inicio y fin del request
            $fecha_inicio = $request->input('fecha_inicio');
            $fecha_fin = $request->input('fecha_fin');

            // Obtener los valores seleccionados de 'et' del request
            $et_values = $request->input('et', []);

            // Construir la consulta SQL base con eliminación de duplicados
            $query = "
                WITH eventos_ordenados AS (
    SELECT 
        s13.id,  -- Seleccionamos solo las columnas necesarias
        s13.et, 
        s13.c, 
        s13.cnt, 
        fecha_hora_legible,  
        t_dec.des_evento_contador,  
        t_cups.id_cups,
        t_cups.nom_cups,
        t_cups.dir_cups,
        t_cups.lat_cups,
        t_cups.lon_cups,
        t_ct.id_ct,
        t_ct.nom_ct,
        t_ct.lat_ct,
        t_ct.lon_ct,
        t_ct.dir_ct,
        t_dec.cod_gravedad_cnt AS cod_gravedad,
        ROW_NUMBER() OVER (
            PARTITION BY fecha_hora_legible, 
                         t_dec.des_evento_contador,  
                         t_cups.id_cups,
                         t_ct.id_ct,
                         t_dec.cod_gravedad_cnt
            ORDER BY s13.id DESC
        ) AS fila_ordenada
    FROM (
        SELECT 
            s13.*,
            TO_CHAR(TO_TIMESTAMP(SUBSTRING(s13.fh, 1, 14), 'YYYYMMDDHH24MISS'), 
                    'DD/MM/YYYY HH24:MI:SS') AS fecha_hora_legible
        FROM core.s13 s13
    ) s13
    JOIN core.t_cups t_cups ON s13.cnt = t_cups.id_cnt  
    JOIN core.t_ct t_ct ON t_cups.id_ct = t_ct.id_ct    
    INNER JOIN core.t_descripcion_eventos_contador t_dec  
        ON s13.et = t_dec.grp_evento 
        AND s13.c = t_dec.cod_evento
";

            // Añadir el filtro de fecha_inicio si está disponible
            if ($fecha_inicio) {
                $query .= " AND TO_TIMESTAMP(SUBSTRING(s13.fh, 1, 14), 'YYYYMMDDHH24MISS') >= TO_TIMESTAMP('$fecha_inicio', 'YYYY-MM-DD')";
            }

            // Añadir el filtro de fecha_fin si está disponible
            if ($fecha_fin) {
                $query .= " AND TO_TIMESTAMP(SUBSTRING(s13.fh, 1, 14), 'YYYYMMDDHH24MISS') <= TO_TIMESTAMP('$fecha_fin', 'YYYY-MM-DD')";
            }

            // Filtrar por los valores de 'et' seleccionados
            if (!empty($et_values)) {
                $et_values = implode(',', array_map('intval', $et_values)); // Convertir a cadena de valores separados por comas
                $query .= " AND s13.et IN ($et_values)";
            }

            // Añadir el filtro de las últimas 24 horas si no se especifica fecha
            if (!$fecha_inicio && !$fecha_fin) {
                $query .= " AND TO_TIMESTAMP(SUBSTRING(s13.fh, 1, 14), 'YYYYMMDDHH24MISS') >= NOW() - INTERVAL '24 hours'";
            }

            // Continuar con la consulta final
            $query .= "
                )
                SELECT * 
                FROM eventos_ordenados
                WHERE fila_ordenada = 1
                ORDER BY id DESC
                ";

            // Ejecutar la consulta
            $resultadosQ1Eventos = DB::connection($connection)->select($query);

            // Retornar los resultados o un mensaje si no hay datos
            return $resultadosQ1Eventos ?: ['message' => 'No hay datos'];
        } else {
            // La tabla no existe, retornar un mensaje específico
            return ['message' => 'No hay datos'];
        }
    } catch (\Exception $e) {
        // Manejo de excepciones con mensaje específico
        return ['message' => 'No hay datos'];
    }
}



public function consultaDosEventosEspontaneos(Request $request, $connection) // count de los eventos por ct
{
    try {
        if (
            Schema::connection($connection)->hasTable('t_ct') &&
            Schema::connection($connection)->hasTable('s13') &&
            Schema::connection($connection)->hasTable('t_cups') &&
            Schema::connection($connection)->hasTable('t_descripcion_eventos_contador') &&
            Schema::connection($connection)->hasTable('t_eventos_contador')
        ) {
            // Obtener las fechas de inicio y fin del request
            $fecha_inicio = $request->input('fecha_inicio');
            $fecha_fin = $request->input('fecha_fin');

            // Construir la consulta SQL base con eliminación de duplicados
            $query = "
                WITH eventos_ordenados AS (
                    SELECT 
                        s13.id,
                        t_ct.id_ct,
                        t_ct.nom_ct,
                        t_dec.cod_gravedad_cnt,  -- Agregamos esta columna para el PARTITION BY
                        ROW_NUMBER() OVER (
                            PARTITION BY s13.fh_legible, t_ct.id_ct, t_dec.cod_gravedad_cnt, t_dec.des_evento_contador, t_cups.id_cups
                            ORDER BY s13.id DESC
                        ) AS fila_ordenada
                    FROM (
                        SELECT 
                            id, 
                            et,  -- Se necesita para la unión con t_dec
                            c,   -- Se necesita para la unión con t_dec
                            cnt, 
                            TO_CHAR(TO_TIMESTAMP(SUBSTRING(fh, 1, 14), 'YYYYMMDDHH24MISS'), 'DD/MM/YYYY HH24:MI:SS') AS fh_legible 
                        FROM core.s13
                    ";

            // Añadir el filtro de fecha_inicio si está disponible
            if ($fecha_inicio && !$fecha_fin) {
                $query .= " WHERE TO_TIMESTAMP(SUBSTRING(s13.fh, 1, 14), 'YYYYMMDDHH24MISS') >= TO_TIMESTAMP('$fecha_inicio', 'YYYY-MM-DD')";
            }

            if($fecha_fin && !$fecha_inicio) {
                $query .= " WHERE TO_TIMESTAMP(SUBSTRING(s13.fh, 1, 14), 'YYYYMMDDHH24MISS') <= TO_TIMESTAMP('$fecha_fin', 'YYYY-MM-DD')";
            }

            // Añadir el filtro de fecha_fin si está disponible
            if ($fecha_fin && $fecha_inicio) {
                $query .= " WHERE TO_TIMESTAMP(SUBSTRING(s13.fh, 1, 14), 'YYYYMMDDHH24MISS') >= TO_TIMESTAMP('$fecha_inicio', 'YYYY-MM-DD')
                            AND TO_TIMESTAMP(SUBSTRING(s13.fh, 1, 14), 'YYYYMMDDHH24MISS') <= TO_TIMESTAMP('$fecha_fin', 'YYYY-MM-DD')";
            }

            // Si no se especifica ni fecha_inicio ni fecha_fin, usar las últimas 24 horas por defecto
            if (!$fecha_inicio && !$fecha_fin) {
                $query .= " WHERE TO_TIMESTAMP(SUBSTRING(s13.fh, 1, 14), 'YYYYMMDDHH24MISS') >= NOW() - INTERVAL '24 hours'";
            }

            // Continuar con la consulta final
            $query .= "
                        ) s13
                JOIN core.t_cups t_cups ON s13.cnt = t_cups.id_cnt  
                JOIN core.t_ct t_ct ON t_cups.id_ct = t_ct.id_ct  
                JOIN core.t_descripcion_eventos_contador t_dec  
                    ON s13.et = t_dec.grp_evento  
                    AND s13.c = t_dec.cod_evento
            )    
            SELECT 
                id_ct,
                nom_ct,
                COUNT(id) AS total_eventos
            FROM eventos_ordenados
            WHERE fila_ordenada = 1
            GROUP BY id_ct, nom_ct
            ORDER BY total_eventos DESC";

            // Ejecutar la consulta
            $resultadosQ2Eventos = DB::connection($connection)->select($query);

            // Retornar los resultados o un mensaje si no hay datos
            return $resultadosQ2Eventos ?: ['message' => 'No hay datos'];
        } else {
            return ['message' => 'No hay datos'];
        }
    } catch (\Exception $e) {
        return ['message' => 'No hay datos'];
    }
}


    public function consultaTresEventosEspontaneos(Request $request, $connection) //datos de los eventos s15 (Eventos concentrador)
    {
        try {
            // Verificar la existencia de las tablas
            if (
                Schema::connection($connection)->hasTable('t_ct') &&
                Schema::connection($connection)->hasTable('s15') &&
                Schema::connection($connection)->hasTable('t_concentradores') &&
                Schema::connection($connection)->hasTable('t_descripcion_eventos_concentrador') &&
                Schema::connection($connection)->hasTable('t_eventos_concentrador')
            ) {
                // Obtener las fechas de inicio y fin del request
                $fecha_inicio = $request->input('fecha_inicio');
                $fecha_fin = $request->input('fecha_fin');

                // Construir la consulta SQL base
                $query = "
                    SELECT DISTINCT
                        s15.*,
                        TO_CHAR(TO_TIMESTAMP(SUBSTRING(s15.fh, 1, 14), 'YYYYMMDDHH24MISS'), 'DD/MM/YYYY HH24:MI:SS') AS fecha_hora_legible,
                        t_dec.des_evento_dc,
                        t_ct.id_ct,
                        t_ct.nom_ct,
                        t_ct.lat_ct,
                        t_ct.lon_ct,
                        t_ct.dir_ct,
                        t_dec.cod_gravedad_dc as cod_gravedad
                    FROM core.s15 s15
                    JOIN core.t_concentradores t_concentradores ON s15.cnc = t_concentradores.id_cnc
                    JOIN core.t_ct t_ct ON t_concentradores.id_ct = t_ct.id_ct
                    LEFT JOIN core.t_descripcion_eventos_concentrador t_dec
                        ON s15.et = t_dec.grp_evento_dc
                        AND s15.c = t_dec.cod_evento_dc
                    LEFT JOIN core.t_eventos_concentrador t_ev
                        ON t_dec.grp_evento_dc = t_ev.grp_evento_dc
                        AND t_dec.cod_evento_dc = t_ev.cod_evento_dc
                    WHERE 1=1
                ";

                // Añadir el filtro de fecha_inicio si está disponible
                if ($fecha_inicio) {
                    $query .= " AND TO_TIMESTAMP(SUBSTRING(s15.fh, 1, 14), 'YYYYMMDDHH24MISS') >= TO_TIMESTAMP('$fecha_inicio', 'YYYY-MM-DD')";
                }

                // Añadir el filtro de fecha_fin si está disponible
                if ($fecha_fin) {
                    $query .= " AND TO_TIMESTAMP(SUBSTRING(s15.fh, 1, 14), 'YYYYMMDDHH24MISS') <= TO_TIMESTAMP('$fecha_fin', 'YYYY-MM-DD')";
                }

                // Añadir el filtro de las últimas 100 horas si no se especifica fecha
                if (!$fecha_inicio && !$fecha_fin) {
                    $query .= " AND TO_TIMESTAMP(SUBSTRING(s15.fh, 1, 14), 'YYYYMMDDHH24MISS') >= NOW() - INTERVAL '24 hours'";
                }

                // Añadir el ordenamiento
                $query .= " ORDER BY s15.id DESC
                ";

                // Ejecutar la consulta
                $resultadosQ3Eventos = DB::connection($connection)->select($query);

                $resultadosCollection = collect($resultadosQ3Eventos);

                // Paginar manualmente
                $page = request()->get('cnc_page', 1);
                $perPage = 20;
                $offset = ($page - 1) * $perPage;

                $resultadosQ3Eventos = new LengthAwarePaginator(
                    $resultadosCollection->slice($offset, $perPage)->values(),
                    $resultadosCollection->count(),
                    $perPage,
                    $page,
                    ['path' => request()->url(), 'query' => request()->query()]
                );

                $resultadosQ3Eventos->setPageName('cnc_page');

                // Retornar los resultados o un mensaje si no hay datos
                return $resultadosQ3Eventos ?: ['message' => 'No hay datos'];
            } else {
                // La tabla no existe, retornar un mensaje específico
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }


    public function consultaCuatroEventosEspontaneos(Request $request, $connection) // count de los eventos s15
    {
        try {
            if (
                Schema::connection($connection)->hasTable('t_ct') &&
                Schema::connection($connection)->hasTable('s15') &&
                Schema::connection($connection)->hasTable('t_concentradores') &&
                Schema::connection($connection)->hasTable('t_descripcion_eventos_concentrador') &&
                Schema::connection($connection)->hasTable('t_eventos_concentrador')
            ) {
                // Obtener las fechas de inicio y fin del request
                $fecha_inicio = $request->input('fecha_inicio');
                $fecha_fin = $request->input('fecha_fin');

                // Construir la consulta SQL base con COUNT
                $query = "
                    SELECT 
                        t_ct.id_ct,
                        t_ct.nom_ct,
                        COUNT(s15.id) AS total_eventos
                    FROM core.s15 s15
                    JOIN core.t_concentradores t_concentradores ON s15.cnc = t_concentradores.id_cnc
                    JOIN core.t_ct t_ct ON t_concentradores.id_ct = t_ct.id_ct
                    WHERE 1=1
                ";

                // Añadir el filtro de fecha_inicio si está disponible
                if ($fecha_inicio) {
                    $query .= " AND TO_TIMESTAMP(SUBSTRING(s15.fh, 1, 14), 'YYYYMMDDHH24MISS') >= TO_TIMESTAMP('$fecha_inicio', 'YYYY-MM-DD')";
                }

                // Añadir el filtro de fecha_fin si está disponible
                if ($fecha_fin) {
                    $query .= " AND TO_TIMESTAMP(SUBSTRING(s15.fh, 1, 14), 'YYYYMMDDHH24MISS') <= TO_TIMESTAMP('$fecha_fin', 'YYYY-MM-DD')";
                }

                // Añadir el filtro de las últimas 100 horas si no se especifica fecha
                if (!$fecha_inicio && !$fecha_fin) {
                    $query .= " AND TO_TIMESTAMP(SUBSTRING(s15.fh, 1, 14), 'YYYYMMDDHH24MISS') >= NOW() - INTERVAL '1000 hours'";
                }

                // Agrupar por el centro de transformación y contar los eventos
                $query .= " GROUP BY t_ct.id_ct, t_ct.nom_ct
                            ORDER BY t_ct.id_ct";

                // Ejecutar la consulta
                $resultadosQ4Eventos = DB::connection($connection)->select($query);

                // Mostrar los resultados para depuración
                // dd($resultadosQ4Eventos);

                return $resultadosQ4Eventos ?: ['message' => 'No hay datos'];
            } else {
                return ['message' => 'No hay datos'];
            }
        } catch (\Exception $e) {
            // Manejo de excepciones con mensaje específico
            return ['message' => 'No hay datos'];
        }
    }



    public function actualizarEventos(Request $request) //FUNCION PARA AJAX
    {
        $connection = User::conexion();

        if ($connection != 'pgsql') {
            $resultadosQ1Eventos = $this->consultaUnoEventosEspontaneos($request, $connection);
            $resultadosQ2Eventos = $this->consultaDosEventosEspontaneos($request, $connection);
            $resultadosQ3Eventos = $this->consultaTresEventosEspontaneos($request, $connection);
            $resultadosQ4Eventos = $this->consultaCuatroEventosEspontaneos($request, $connection);
            $resultadosQ5Eventos = $this->consultaCincoEventosEspontaneos($request, $connection);
            $resultadosQ6Eventos = $this->consultaSeisEventosEspontaneos($request, $connection);
            $resultadosQ1EventosPaginate = $this->consultaUnoEventosEspontaneosPaginate($request, $connection);

            // Crear un mapa (array asociativo) de conteos de eventos por ID de CT
            $conteoEventosPorCt = [];

            // Agregar conteo de Q2
            foreach ($resultadosQ2Eventos as $evento) {
                // Verificar que $evento es un objeto y tiene la propiedad 'id_ct'
                if (is_object($evento) && property_exists($evento, 'id_ct')) {
                    if (!isset($conteoEventosPorCt[$evento->id_ct])) {
                        $conteoEventosPorCt[$evento->id_ct] = [
                            'total_eventos_contador' => 0,
                            'total_eventos_concentrador' => 0
                        ];
                    }
                    $conteoEventosPorCt[$evento->id_ct]['total_eventos_contador'] += $evento->total_eventos;
                }
            }
            // Agregar conteo de Q4
            foreach ($resultadosQ4Eventos as $evento) {
                // Verificar que $evento es un objeto y tiene la propiedad 'id_ct'
                if (is_object($evento) && property_exists($evento, 'id_ct')) {
                    if (!isset($conteoEventosPorCt[$evento->id_ct])) {
                        $conteoEventosPorCt[$evento->id_ct] = [
                            'total_eventos_contador' => 0,
                            'total_eventos_concentrador' => 0
                        ];
                    }
                    $conteoEventosPorCt[$evento->id_ct]['total_eventos_concentrador'] += $evento->total_eventos;
                }
            }

            // Añadir el conteo de eventos a los resultados de Q1
            foreach ($resultadosQ1Eventos as &$evento) {
                // Verificar que $evento es un objeto y tiene la propiedad 'id_ct'
                if (is_object($evento) && property_exists($evento, 'id_ct')) {
                    if (isset($conteoEventosPorCt[$evento->id_ct])) {
                        $evento->total_eventos_contador = $conteoEventosPorCt[$evento->id_ct]['total_eventos_contador'];
                        $evento->total_eventos_concentrador = $conteoEventosPorCt[$evento->id_ct]['total_eventos_concentrador'];
                        $evento->total_eventos = $evento->total_eventos_contador + $evento->total_eventos_concentrador;
                    } else {
                        $evento->total_eventos_contador = 0;
                        $evento->total_eventos_concentrador = 0;
                        $evento->total_eventos = 0;
                    }
                }
            }

            // Retorna los datos como JSON
            return response()->json([
                'resultadosQ1Eventos' => $resultadosQ1Eventos,
                'resultadosQ2Eventos' => $resultadosQ2Eventos,
                'resultadosQ3Eventos' => $resultadosQ3Eventos,
                'resultadosQ4Eventos' => $resultadosQ4Eventos,
                'resultadosQ5Eventos' => $resultadosQ5Eventos,
                'resultadosQ6Eventos' => $resultadosQ6Eventos,
                'resultadosQ1EventosPaginate' => $resultadosQ1EventosPaginate,

            ]);
        }

        return response()->json(['message' => 'Conexión inválida']);
    }

    public function consultaCincoEventosEspontaneos(Request $request, $connection) //count eventos contador 24 horas
{
    try {
        // Verificar la existencia de las tablas
        if (
            Schema::connection($connection)->hasTable('t_ct') &&
            Schema::connection($connection)->hasTable('s13') &&
            Schema::connection($connection)->hasTable('t_cups') &&
            Schema::connection($connection)->hasTable('t_descripcion_eventos_contador') &&
            Schema::connection($connection)->hasTable('t_eventos_contador')
        ) {

            // Obtener las fechas de inicio y fin del request
            $fecha_inicio = $request->input('fecha_inicio');
            $fecha_fin = $request->input('fecha_fin');

            // Construir la consulta SQL base
            $query = "
               WITH eventos_ordenados AS (
                SELECT 
                    s13.id,  
                    s13.et,  
                    fecha_hora_legible,  
                    t_ct.id_ct,  
                    t_dec.cod_gravedad_cnt AS cod_gravedad,  
                    ROW_NUMBER() OVER (
                        PARTITION BY fecha_hora_legible,  
                                    t_dec.des_evento_contador,  
                                    t_cups.id_cups,  
                                    t_ct.id_ct,  
                                    t_dec.cod_gravedad_cnt  
                        ORDER BY s13.id DESC  
                    ) AS fila_ordenada  
                FROM (
                    SELECT 
                        s13.id,  
                        s13.et,  
                        s13.c,  
                        s13.cnt,  
                        s13.fh,
                        TO_CHAR(TO_TIMESTAMP(SUBSTRING(s13.fh, 1, 14), 'YYYYMMDDHH24MISS'),  
                                'DD/MM/YYYY HH24:MI:SS') AS fecha_hora_legible  
                    FROM core.s13 s13  
                ) s13  
                JOIN core.t_cups t_cups ON s13.cnt = t_cups.id_cnt  
                JOIN core.t_ct t_ct ON t_cups.id_ct = t_ct.id_ct    
                LEFT JOIN core.t_descripcion_eventos_contador t_dec  
                    ON s13.et = t_dec.grp_evento  
                    AND s13.c = t_dec.cod_evento";

            // Añadir el filtro de fecha_inicio si está disponible
            if ($fecha_inicio && !$fecha_fin) {
                $query .= " WHERE TO_TIMESTAMP(SUBSTRING(s13.fh, 1, 14), 'YYYYMMDDHH24MISS') >= TO_TIMESTAMP('$fecha_inicio', 'YYYY-MM-DD')";
            }

            if($fecha_fin && !$fecha_inicio) {
                $query .= " WHERE TO_TIMESTAMP(SUBSTRING(s13.fh, 1, 14), 'YYYYMMDDHH24MISS') <= TO_TIMESTAMP('$fecha_fin', 'YYYY-MM-DD')";
            }

            // Añadir el filtro de fecha_fin si está disponible
            if ($fecha_fin && $fecha_inicio) {
                $query .= " WHERE TO_TIMESTAMP(SUBSTRING(s13.fh, 1, 14), 'YYYYMMDDHH24MISS') >= TO_TIMESTAMP('$fecha_inicio', 'YYYY-MM-DD')
                            AND TO_TIMESTAMP(SUBSTRING(s13.fh, 1, 14), 'YYYYMMDDHH24MISS') <= TO_TIMESTAMP('$fecha_fin', 'YYYY-MM-DD')";
            }

            // Si no se especifica ni fecha_inicio ni fecha_fin, usar las últimas 24 horas por defecto
            if (!$fecha_inicio && !$fecha_fin) {
                $query .= " WHERE TO_TIMESTAMP(SUBSTRING(s13.fh, 1, 14), 'YYYYMMDDHH24MISS') >= NOW() - INTERVAL '24 hours'";
            }

            // Finalizar la consulta
            $query .= "
                )  
                SELECT 
                    et,  
                    COUNT(*) AS cantidad_eventos_24h  
                FROM eventos_ordenados  
                WHERE fila_ordenada = 1  
                GROUP BY et  
                ORDER BY cantidad_eventos_24h DESC;

            ";

            // Ejecutar la consulta
            $resultadosQ5Eventos = DB::connection($connection)->select($query);

            // Mostrar los resultados para depuración
            // dd($resultadosQ5Eventos);

            // Retornar los resultados o un mensaje si no hay datos
            return $resultadosQ5Eventos ?: ['message' => 'No hay datos'];
        } else {
            // La tabla no existe, retornar un mensaje específico
            return ['message' => 'No hay datos'];
        }
    } catch (\Exception $e) {
        // Manejo de excepciones con mensaje específico
        return ['message' => 'No hay datos'];
    }
}

public function consultaSeisEventosEspontaneos(Request $request, $connection) //count eventos contador historico
{
    try {
        // Verificar la existencia de las tablas
        if (
            Schema::connection($connection)->hasTable('t_ct') &&
            Schema::connection($connection)->hasTable('s13') &&
            Schema::connection($connection)->hasTable('t_cups') &&
            Schema::connection($connection)->hasTable('t_descripcion_eventos_contador') &&
            Schema::connection($connection)->hasTable('t_eventos_contador')
        ) {

            // Construir la consulta SQL base
            $query = "
               WITH eventos_ordenados AS (
                SELECT 
                    s13.id, 
                    s13.et, 
                    s13.c, 
                    s13.cnt, 
                    TO_CHAR(TO_TIMESTAMP(SUBSTRING(s13.fh, 1, 14), 'YYYYMMDDHH24MISS'), 'DD/MM/YYYY HH24:MI:SS') AS fecha_hora_legible,  
                    t_dec.des_evento_contador,  
                    t_cups.id_cups,
                    t_cups.nom_cups,
                    t_cups.dir_cups,
                    t_cups.lat_cups,
                    t_cups.lon_cups,
                    t_ct.id_ct,
                    t_ct.nom_ct,
                    t_ct.lat_ct,
                    t_ct.lon_ct,
                    t_ct.dir_ct,
                    t_dec.cod_gravedad_cnt AS cod_gravedad,
                    ROW_NUMBER() OVER (
                        PARTITION BY TO_CHAR(TO_TIMESTAMP(SUBSTRING(s13.fh, 1, 14), 'YYYYMMDDHH24MISS'), 'DD/MM/YYYY HH24:MI:SS'), 
                                    t_dec.des_evento_contador,  
                                    t_cups.id_cups,
                                    t_ct.id_ct,
                                    t_dec.cod_gravedad_cnt
                        ORDER BY s13.id DESC
                    ) AS fila_ordenada
                FROM core.s13 s13
                JOIN core.t_cups t_cups ON s13.cnt = t_cups.id_cnt  
                JOIN core.t_ct t_ct ON t_cups.id_ct = t_ct.id_ct    
                LEFT JOIN core.t_descripcion_eventos_contador t_dec  
                    ON s13.et = t_dec.grp_evento 
                    AND s13.c = t_dec.cod_evento
            )
            SELECT 
                et,  -- Referenciamos correctamente la columna 'et' del CTE 'eventos_ordenados'
                COUNT(DISTINCT fecha_hora_legible) AS cantidad_eventos_historico  -- Contamos los eventos únicos
            FROM eventos_ordenados
            WHERE fila_ordenada = 1  -- Filtramos solo la primera fila de cada partición
            GROUP BY et  -- Agrupamos por la columna 'et'
            ORDER BY cantidad_eventos_historico DESC;

            ";

            // Ejecutar la consulta
            $resultadosQ6Eventos = DB::connection($connection)->select($query);

            // Mostrar los resultados para depuración
            // dd($resultadosQ6Eventos);

            // Retornar los resultados o un mensaje si no hay datos
            return $resultadosQ6Eventos ?: ['message' => 'No hay datos'];
        } else {
            // La tabla no existe, retornar un mensaje específico
            return ['message' => 'No hay datos'];
        }
    } catch (\Exception $e) {
        // Manejo de excepciones con mensaje específico
        return ['message' => 'No hay datos'];
    }
}

public function consultaUnoEventosEspontaneosPaginate(Request $request, $connection)
{
    try {
        // Verificar la existencia de las tablas
        if (
            Schema::connection($connection)->hasTable('t_ct') &&
            Schema::connection($connection)->hasTable('s13') &&
            Schema::connection($connection)->hasTable('t_cups') &&
            Schema::connection($connection)->hasTable('t_descripcion_eventos_contador') &&
            Schema::connection($connection)->hasTable('t_eventos_contador')
        ) {
            // Obtener las fechas de inicio y fin del request
            $fecha_inicio = $request->input('fecha_inicio');
            $fecha_fin = $request->input('fecha_fin');

            // Obtener los valores seleccionados de 'et' del request
            $et_values = $request->input('et', []);

            // Construir la consulta SQL base con eliminación de duplicados
            $query = "
                WITH eventos_ordenados AS (
    SELECT 
        s13.id,  -- Seleccionamos solo las columnas necesarias
        s13.et, 
        s13.c, 
        s13.cnt, 
        fecha_hora_legible,  
        t_dec.des_evento_contador,  
        t_cups.id_cups,
        t_cups.nom_cups,
        t_cups.dir_cups,
        t_cups.lat_cups,
        t_cups.lon_cups,
        t_ct.id_ct,
        t_ct.nom_ct,
        t_ct.lat_ct,
        t_ct.lon_ct,
        t_ct.dir_ct,
        t_dec.cod_gravedad_cnt AS cod_gravedad,
        ROW_NUMBER() OVER (
            PARTITION BY fecha_hora_legible, 
                         t_dec.des_evento_contador,  
                         t_cups.id_cups,
                         t_ct.id_ct,
                         t_dec.cod_gravedad_cnt
            ORDER BY s13.id DESC
        ) AS fila_ordenada
    FROM (
        SELECT 
            s13.*,
            TO_CHAR(TO_TIMESTAMP(SUBSTRING(s13.fh, 1, 14), 'YYYYMMDDHH24MISS'), 
                    'DD/MM/YYYY HH24:MI:SS') AS fecha_hora_legible
        FROM core.s13 s13
    ) s13
    JOIN core.t_cups t_cups ON s13.cnt = t_cups.id_cnt  
    JOIN core.t_ct t_ct ON t_cups.id_ct = t_ct.id_ct    
    INNER JOIN core.t_descripcion_eventos_contador t_dec  
        ON s13.et = t_dec.grp_evento 
        AND s13.c = t_dec.cod_evento
";

            // Añadir el filtro de fecha_inicio si está disponible
            if ($fecha_inicio) {
                $query .= " AND TO_TIMESTAMP(SUBSTRING(s13.fh, 1, 14), 'YYYYMMDDHH24MISS') >= TO_TIMESTAMP('$fecha_inicio', 'YYYY-MM-DD')";
            }

            // Añadir el filtro de fecha_fin si está disponible
            if ($fecha_fin) {
                $query .= " AND TO_TIMESTAMP(SUBSTRING(s13.fh, 1, 14), 'YYYYMMDDHH24MISS') <= TO_TIMESTAMP('$fecha_fin', 'YYYY-MM-DD')";
            }

            // Filtrar por los valores de 'et' seleccionados
            if (!empty($et_values)) {
                $et_values = implode(',', array_map('intval', $et_values)); // Convertir a cadena de valores separados por comas
                $query .= " AND s13.et IN ($et_values)";
            }

            // Añadir el filtro de las últimas 24 horas si no se especifica fecha
            if (!$fecha_inicio && !$fecha_fin) {
                $query .= " AND TO_TIMESTAMP(SUBSTRING(s13.fh, 1, 14), 'YYYYMMDDHH24MISS') >= NOW() - INTERVAL '24 hours'";
            }

            // Continuar con la consulta final
            $query .= "
                )
                SELECT * 
                FROM eventos_ordenados
                WHERE fila_ordenada = 1
                ORDER BY id DESC";

            // Ejecutar la consulta
            $resultadosQ1Eventos = DB::connection($connection)->select($query);

            $resultadosCollection = new Collection($resultadosQ1Eventos);

            // Obtener la página actual desde la solicitud
            $page = request()->get('cnt_page', 1);
            $perPage = 20;
            $offset = ($page - 1) * $perPage;

            // Paginar manualmente
            $resultadosQ1Eventos = new LengthAwarePaginator(
                $resultadosCollection->slice($offset, $perPage)->values(), // Elementos para esta página
                $resultadosCollection->count(), // Total de elementos
                $perPage, // Elementos por página
                $page, // Página actual
                ['path' => request()->url(), 'query' => request()->query()] // Para mantener parámetros en la URL
            );

            $resultadosQ1Eventos -> setPageName('cnt_page');
            // Retornar los resultados o un mensaje si no hay datos
            return $resultadosQ1Eventos ?: ['message' => 'No hay datos'];
        } else {
            // La tabla no existe, retornar un mensaje específico
            return ['message' => 'No hay datos'];
        }
    } catch (\Exception $e) {
        // Manejo de excepciones con mensaje específico
        return ['message' => 'No hay datos'];
    }
}

public function exportEventosEspontaneos(Request $request)
{
    try {
        // Verificar la existencia de las tablas
        $user = auth()->user();
        $connection = 'pgsql' . '-' . strtolower($user->nom_distribuidora);
        if (
            Schema::connection($connection)->hasTable('t_ct') &&
            Schema::connection($connection)->hasTable('s13') &&
            Schema::connection($connection)->hasTable('t_cups') &&
            Schema::connection($connection)->hasTable('t_descripcion_eventos_contador') &&
            Schema::connection($connection)->hasTable('t_eventos_contador')
        ) {
            // Obtener las fechas de inicio y fin del request
            $fecha_inicio = $request->input('fecha_inicio');
            $fecha_fin = $request->input('fecha_fin');

            // Obtener los valores seleccionados de 'et' del request
            $et_values = $request->input('et', []);

            // Construir la consulta SQL base con eliminación de duplicados
            $query = "
                WITH eventos_ordenados AS (
    SELECT 
        s13.et, 
        s13.c, 
        s13.cnt, 
        fecha_hora_legible,  
        t_dec.des_evento_contador,  
        t_cups.id_cups,
        t_cups.dir_cups,
        t_ct.id_ct,
        t_ct.nom_ct,
        t_dec.cod_gravedad_cnt AS cod_gravedad,
        ROW_NUMBER() OVER (
            PARTITION BY fecha_hora_legible, 
                         t_dec.des_evento_contador,  
                         t_cups.id_cups,
                         t_ct.id_ct,
                         t_dec.cod_gravedad_cnt
            ORDER BY s13.id DESC
        ) AS fila_ordenada
    FROM (
        SELECT 
            s13.*,
            TO_CHAR(TO_TIMESTAMP(SUBSTRING(s13.fh, 1, 14), 'YYYYMMDDHH24MISS'), 
                    'DD/MM/YYYY HH24:MI:SS') AS fecha_hora_legible
        FROM core.s13 s13
    ) s13
    JOIN core.t_cups t_cups ON s13.cnt = t_cups.id_cnt  
    JOIN core.t_ct t_ct ON t_cups.id_ct = t_ct.id_ct    
    INNER JOIN core.t_descripcion_eventos_contador t_dec  
        ON s13.et = t_dec.grp_evento 
        AND s13.c = t_dec.cod_evento
";

            // Añadir el filtro de fecha_inicio si está disponible
            if ($fecha_inicio) {
                $query .= " AND TO_TIMESTAMP(SUBSTRING(s13.fh, 1, 14), 'YYYYMMDDHH24MISS') >= TO_TIMESTAMP('$fecha_inicio', 'YYYY-MM-DD')";
            }

            // Añadir el filtro de fecha_fin si está disponible
            if ($fecha_fin) {
                $query .= " AND TO_TIMESTAMP(SUBSTRING(s13.fh, 1, 14), 'YYYYMMDDHH24MISS') <= TO_TIMESTAMP('$fecha_fin', 'YYYY-MM-DD')";
            }

            // Filtrar por los valores de 'et' seleccionados
            if (!empty($et_values)) {
                $et_values = implode(',', array_map('intval', $et_values)); // Convertir a cadena de valores separados por comas
                $query .= " AND s13.et IN ($et_values)";
            }

            // Añadir el filtro de las últimas 24 horas si no se especifica fecha
            if (!$fecha_inicio && !$fecha_fin) {
                $query .= " AND TO_TIMESTAMP(SUBSTRING(s13.fh, 1, 14), 'YYYYMMDDHH24MISS') >= NOW() - INTERVAL '24 hours'";
            }

            // Continuar con la consulta final
            $query .= "
                )
                SELECT * 
                FROM eventos_ordenados
                WHERE fila_ordenada = 1
                ORDER BY fecha_hora_legible DESC";

            // Ejecutar la consulta
            $exportEventosEspontaneos = DB::connection($connection)->select($query);
            if($exportEventosEspontaneos) {
                return Excel::download(new EventosEspontaneosExport($exportEventosEspontaneos), 'eventos_espontaneos.xlsx');
            } else {
                return response()->json(['message' => 'No hay datos'], 404);
            } 
        } else {
            // La tabla no existe, retornar un mensaje específico
            return ['message' => 'No hay datos'];
        }
    } catch (\Exception $e) {
        // Manejo de excepciones con mensaje específico
        return ['message' => 'No hay datos'];
    }
}

    
}
