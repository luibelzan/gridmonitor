<?php


use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ctController;
use App\Http\Controllers\CupsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventosEspontaneosController;
use App\Http\Controllers\InformacionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PuntoFronteraController;
use App\Http\Controllers\SupervisionAvanzadaController;
use App\Http\Controllers\DashboardSABTController;
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//ERRROR
Route::get('/registro', [RegisteredUserController::class, 'create'])->name('registro')->middleware('role:admin');




//ADMIN
Route::get('/registro', [RegisteredUserController::class, 'create'])->name('registro')->middleware('role:admin');
Route::post('/registro', [RegisteredUserController::class, 'store'])->name('registro')->middleware('role:admin');
Route::get('/admin', [AdminController::class, 'admin'])->name('admin')->middleware('role:admin');
Route::get('/admin', [AdminController::class, 'mostrarusuarios'])->name('admin')->middleware('role:admin');
Route::get('/editarusuario/{id}', [AdminController::class, 'editarusuario'])->name('editarusuario')->middleware('role:admin');
Route::put('/actualizarusuario/{id}', [AdminController::class, 'actualizarUsuario'])->name('actualizarusuario')->middleware('role:admin'); ;
Route::delete('/eliminarusuario/{id}', [AdminController::class, 'eliminarusuario'])->name('eliminarusuario')->middleware('role:admin'); ;


//**********************
//***********CT*********
//**********************
// INFORMACION DEL CT ------------------------------------------------
Route::get('/informacionct', [ctController::class, 'informacionct'])->name('informacionct');


// SEÑAL PLC -------------------------
Route::get('/señalplc', [ctController::class, 'senialplc'])->name('señalplc');


// CALIDAD ENERGIA ----------------------------
Route::get('/energia', [ctController::class, 'energia'])->name('energia');


// EVENTOSCT ----------------------------
Route::get('/eventosct', [ctController::class, 'eventosct'])->name('eventosct');


// BALANCES ----------------------------
Route::get('/balances', [ctController::class, 'balances'])->name('balances');

// REPORTES ------------------------------------------------
Route::get('/reportes', [ctController::class, 'reportes'])->name('reportes');
Route::get('/reportescalidad', [ctController::class, 'reportescalidad'])->name('reportescalidad');
Route::get('/reportesinventario', [ctController::class, 'reportesinventario'])->name('reportesinventario');
Route::get('/reportescurvashorarias', [ctController::class, 'reportescurvashorarias'])->name('reportescurvashorarias');
Route::get('/reporteseventos', [ctController::class, 'reporteseventos'])->name('reporteseventos');
Route::get('/exportar-excel', [ctController::class, 'exportCurvasHorarias'])->name('exportar.excel');
Route::get('/exportar-eventos', [ctController::class, 'exportReportesEventos'])->name('exportar.eventos');
Route::get('/exportar-registros', [CupsController::class, 'exportRegistrosMensuales'])->name('exportar.registros');
Route::get('/exportar-registros-diarios', [CupsController::class, 'exportConsumosTotalesDiarios'])->name('exportar.registros.diarios');
Route::get('/exportar-balances', [CtController::class, 'exportSumBalances'])->name('exportar.balances');
Route::get('/exportar-eventos-ct', [CtController::class, 'exportEventosCT'])->name('exportar.eventos.ct');
Route::get('/exportar-eventos-pf', [PuntoFronteraController::class, 'exportEventsPF'])->name('exportar.eventos.pf');
Route::get('/exportar-eventos-espontaneos', [EventosEspontaneosController::class, 'exportEventosEspontaneos'])->name('exportar.eventosespontaneos');
Route::get('/exportar-curvas-horarias', [CupsController::class, 'exportCurvasHorarias'])->name('exportar.curvas.cups');
Route::get('/exportar-eventos-cups', [CupsController::class, 'exportEventsCups'])->name('exportar.eventos.cups');
Route::get('/exportar-reportes-calidad', [ctController::class, 'exportReportesCalidad'])->name('exportar.reportes.calidad');
Route::get('/exportar-actualizaciones', [ctController::class, 'exportReportesInventarioFW'])->name('exportar.reportes.actualizaciones');
Route::get('/exportar-reportes-inventario', [ctController::class, 'exportReportesInventario'])->name('exportar.reportes.inventario');
Route::get('/exportar-cierres-mensuales', [PuntoFronteraController::class, 'exportCierresMensuales'])->name('exportar.cierres.mensuales.pf');
Route::get('/exportar-curvas-cuartihorarias', [PuntoFronteraController::class, 'exportCurvasCuartihorarias'])->name('exportar.curvas.cuartihorarias.pf');
Route::get('/exportar-diferencia-consumos', [ctController::class, 'exportDiferenciaConsumo'])->name('exportar.diferencia.consumos');


//*********************************
//***********PUNTO FRONTERA*********
//*********************************
//INFORMACION DEL PUNTO FRONTERA ----------------------------
Route::get('/informacionpf', [PuntoFronteraController::class, 'informacionpf'])->name('informacionpf');


//CURVAS HORARIAS ----------------------------
Route::get('/curvashorariaspf', [PuntoFronteraController::class, 'curvashorariaspf'])->name('curvashorariaspf');


//EVENTOS DEL PUNTO FRONTERA ----------------------------
Route::get('/eventospf', [PuntoFronteraController::class, 'eventospf'])->name('eventospf');

//CURVAS CUARTIHORARIAS ----------------------------
Route::get('/curvascuartihorariaspf', [PuntoFronteraController::class, 'curvascuartihorariaspf'])->name('curvascuartihorariaspf');


//REPORTES PF ----------------------------
Route::get('/reportespf', [PuntoFronteraController::class, 'reportespf'])->name('reportespf');


//************************
//***********CUPS*********
//************************
// INFORMACION CUPS ------------------------------------------------
Route::get('/informacioncups', [CupsController::class, 'informacioncups'])->name('informacioncups');
Route::get('/detallesinformacioncups', [CupsController::class, 'detallesinformacioncups'])->name('detallesinformacioncups');


// EVENTOS CUPS ------------------------------------------------
Route::get('/eventoscups', [CupsController::class, 'eventoscups'])->name('eventoscups');
Route::get('/detalleseventoscups', [CupsController::class, 'detalleseventoscups'])->name('detalleseventoscups');


// CURVAS HORARIAS CUPS ------------------------------
Route::get('/curvashorariascups', [CupsController::class, 'curvashorariascups'])->name('curvashorariascups');
Route::get('/detallescurvashorariascups', [CupsController::class, 'detallescurvashorariascups'])->name('detallescurvashorariascups');
Route::get('/consumodiariocups', [CupsController::class, 'consumodiariocups'])->name('consumodiariocups');
Route::get('/detallesconsumodiariocups', [CupsController::class, 'detallesconsumodiariocups'])->name('detallesconsumodiariocups');


// ENERGIA CUPS -------------------------------
Route::get('/energiacups', [CupsController::class, 'energiacups'])->name('energiacups');
Route::get('/detallesenergiacups', [CupsController::class, 'detallesenergiacups'])->name('detallesenergiacups');




//*****************************
//***********DASHBOARD*********
//*****************************
Route::get('/dashboardct', [DashboardController::class, 'dashboardct'])->name('dashboardct');
Route::get('/dashboardpf', [DashboardController::class, 'dashboardpf'])->name('dashboardpf');
Route::get('/contacto', [DashboardController::class, 'contacto'])->name('contacto');
Route::get('/dashboardsabt', [SupervisionAvanzadaController::class, 'dashboardsabt'])->name('dashboardsabt');

//********************************
//******EVENTOS ESPONTANEOS*******
//********************************
//INFORMACION DEL PUNTO FRONTERA ----------------------------
Route::get('/eventosespontaneos', [EventosEspontaneosController::class, 'eventosespontaneos'])->name('eventosespontaneos');
Route::get('/eventos/actualizar', [EventosEspontaneosController::class, 'actualizarEventos']);


//SUPERVISION AVANZADA ----------------------------
Route::get('/supervisionavanzada', [SupervisionAvanzadaController::class, 'supervisionavanzada'])->name('supervisionavanzada');
Route::get('/fasessabt', [SupervisionAvanzadaController::class, 'fasessabt'])->name('fasessabt');
Route::get('/indicadoressabt', [SupervisionAvanzadaController::class, 'indicadoressabt'])->name('indicadoressabt');
Route::get('/balancessabt', [SupervisionAvanzadaController::class, 'balancessabt'])->name('balancessabt');




Route::middleware(['auth', 'session.expired'])->group(function () {
    // Tus rutas protegidas
    Route::post('/login', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

require __DIR__ . '/auth.php';






