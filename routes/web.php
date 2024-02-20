<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\VcEncashmentDebts;
use App\Http\Livewire\VcReportCashReceints;
use App\Http\Livewire\VcEncashment;
use App\Http\Livewire\VcReportDailyCharges;
use App\Http\Livewire\VcReportDebtAnalysis;
use App\Http\Livewire\VcGenericReports;
use App\Http\Livewire\VcAccountStatus;
use App\Http\Livewire\VcPersons;
use App\Http\Livewire\VcCertificados;
use App\Http\Livewire\VcRatingsDetail;
use App\Http\Livewire\VcSolicitudes;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/headquarters/campus',[App\Http\Controllers\TmEmpresasController::class, 'index'])->name('index');
Route::get('/config/generality',[App\Http\Controllers\TmGeneralidadesController::class, 'index'])->name('index');
Route::get('/config/zone',[App\Http\Controllers\TmZonasController::class, 'index'])->name('index');
Route::get('/config/rols',[App\Http\Controllers\RolesController::class, 'index'])->name('index');

Route::get('/academic/course',[App\Http\Controllers\TmCursosController::class, 'course'])->name('course');
Route::get('/academic/students',[App\Http\Controllers\TmPersonasController::class, 'index'])->name('index');
Route::get('/academic/person-add',[App\Http\Controllers\TmPersonasController::class, 'addperson'])->name('addperson');
Route::get('/academic/person-edit/{nui}',[App\Http\Controllers\TmPersonasController::class, 'editperson'])->name('editperson');
Route::get('/academic/representatives',[App\Http\Controllers\TmPersonasController::class, 'agent'])->name('agent');
Route::get('/academic/tuition',[App\Http\Controllers\TmMatriculaController::class, 'index'])->name('index');
Route::get('/academic/student-enrollment/{id}',[App\Http\Controllers\TmMatriculaController::class, 'addtuition'])->name('addtuition');
Route::get('/academic/student-enrollment',[App\Http\Controllers\TmMatriculaController::class, 'newtuition'])->name('newtuition');
Route::get('/headquarters/headquarters-add',[App\Http\Controllers\TmSedesController::class, 'index'])->name('index');
Route::get('/headquarters/pension',[App\Http\Controllers\TmPensionesCabController::class, 'index'])->name('index');
Route::get('/headquarters/educational-services',[App\Http\Controllers\TmServiciosController::class, 'index'])->name('index');
Route::get('/financial/encashment/{id}',[App\Http\Controllers\TrCobrosCabsController::class, 'viewtuition'])->name('viewtuition');
Route::get('/financial/encashment',[App\Http\Controllers\TrCobrosCabsController::class, 'loadtuition'])->name('loadtuition');
Route::get('/financial/encashment-add/{periodoid}/{matriculaid}',[App\Http\Controllers\TrCobrosCabsController::class, 'addencashment'])->name('addescashment');
Route::get('/financial/create-invoice',[App\Http\Controllers\TrFacturasCabsController::class, 'index'])->name('index');
Route::get('/report/box-balance',[App\Http\Controllers\TrCobrosCabsController::class, 'cuadrecaja'])->name('cuadrecaja');
Route::get('/report/daily-charges',[App\Http\Controllers\TrCobrosCabsController::class, 'cobrosdiarios'])->name('cobrosdiarios');
Route::get('/financial/account-status',[App\Http\Controllers\TmMatriculaController::class, 'estadocuenta'])->name('estadocuenta');
Route::get('/report/statistical-graphs',[App\Http\Controllers\TrCobrosCabsController::class, 'graficos'])->name('graficos');
Route::get('/report/debt-analysis',[App\Http\Controllers\TmMatriculaController::class, 'analisisdeuda'])->name('analisisdeuda');
Route::get('/financial/list-income',[App\Http\Controllers\TrCobrosCabsController::class, 'listingresos'])->name('listingresos');
Route::get('/report/generic-reports',[App\Http\Controllers\TmMatriculaController::class, 'reportegenerico'])->name('reportegenerico');
Route::get('/secretary/certificate',[App\Http\Controllers\SecretariaController::class, 'certificados'])->name('certificados');
Route::get('/secretary/documentation',[App\Http\Controllers\SecretariaController::class, 'documentos'])->name('documentos');
Route::get('/headquarters/staff',[App\Http\Controllers\TmPersonasController::class, 'personal'])->name('personal');
Route::get('/headquarters/staff-add',[App\Http\Controllers\TmPersonasController::class, 'addpersonal'])->name('addpersonal');
Route::get('/headquarters/schedules',[App\Http\Controllers\TmHorariosController::class, 'index'])->name('index');
Route::get('/headquarters/schedules-add',[App\Http\Controllers\TmHorariosController::class, 'addhorarios'])->name('addhorarios');
Route::get('/headquarters/schedules-edit/{id}',[App\Http\Controllers\TmHorariosController::class, 'edithorarios'])->name('edithorarios');
Route::get('/headquarters/subjects',[App\Http\Controllers\TmAsignaturasController::class, 'index'])->name('index');
Route::get('/academic/ratings',[App\Http\Controllers\TmCalificaciones::class, 'index'])->name('index');
Route::get('/academic/ratings-add',[App\Http\Controllers\TmCalificaciones::class, 'addCalificacion'])->name('addCalificacion');
Route::get('/secretary/ratings',[App\Http\Controllers\SecretariaController::class, 'ratings'])->name('ratings');
Route::get('/secretary/report-cas',[App\Http\Controllers\SecretariaController::class, 'reportCas'])->name('reportCas');
Route::get('/secretary/titles-file',[App\Http\Controllers\SecretariaController::class, 'titlesFile'])->name('titlesFile');
Route::get('/secretary/requests',[App\Http\Controllers\SecretariaController::class, 'requests'])->name('requests');
Route::get('/secretary/promotion',[App\Http\Controllers\SecretariaController::class, 'promotion'])->name('promotion');


Route::get('/download-pdf/{data}',[VcReportCashReceints::class, 'downloadPDF']);
Route::get('/liveWire-pdf/{data}',[VcReportCashReceints::class, 'liveWirePDF']);
Route::get('/preview-pdf/comprobante/{id}',[VcEncashment::class, 'liveWirePDF']);
Route::get('/download-pdf/comprobante/{id}',[VcEncashment::class, 'downloadPDF']);
Route::get('/download-pdf/cobros/{data}',[VcReportDailyCharges::class, 'downloadPDF']);
Route::get('/preview-pdf/cobros/{data}',[VcReportDailyCharges::class, 'liveWirePDF']);
Route::get('/preview-pdf/account-status-det/{id}',[VcAccountStatus::class, 'liveWireDetPDF']);
Route::get('/preview-pdf/account-status-gen/{id}',[VcAccountStatus::class, 'liveWireGenPDF']);
Route::get('/download-pdf/account-status-gen/{id}',[VcAccountStatus::class, 'downloadGenPDF']);
Route::get('/preview-pdf/student-file/{data}',[VcPersons::class, 'printFichaPDF']);
Route::get('/preview-pdf/list-student/{report},{data}',[VcPersons::class, 'listEstudiantesPDF']);
Route::get('/preview-pdf/report-tuitions/{report},{data}',[VcPersons::class, 'listEstudiantesPDF']);
Route::get('/preview-pdf/list-familys/{data}',[VcPersons::class, 'listFamiliarPDF']);
Route::get('/download-pdf/student-file/{data}',[VcPersons::class, 'downloadFichaPDF']);
Route::get('/download-pdf/list-student/{report},{data}',[VcPersons::class, 'downloadEstudiantesPDF']);
Route::get('/download-pdf/report-tuitions/{report},{data}',[VcPersons::class, 'downloadEstudiantesPDF']);
Route::get('/download-pdf/list-familys/{data}',[VcPersons::class, 'downloadFamiliarPDF']);
Route::get('/preview-pdf/debt-analysis/{report},{data}',[VcReportDebtAnalysis::class, 'liveWirePDF']);
Route::get('/download-pdf/debt-analysis/{report},{data}',[VcReportDebtAnalysis::class, 'liveWirePDF']);
Route::get('/preview-pdf/generic-report/{report},{data}',[VcGenericReports::class, 'liveWirePDF']);
Route::get('/download-pdf/generic-report/{report},{data}',[VcGenericReports::class, 'liveWirePDF']);
Route::get('/preview-pdf/certificados/{data}',[VcCertificados::class, 'liveWirePDF']);
Route::get('/download-pdf/certificados/{data}',[VcCertificados::class, 'downloadPDF']);
Route::get('/preview-pdf/ratings/{data}',[VcRatingsDetail::class, 'printPDF']);
Route::get('/download-pdf/ratings/{data}',[VcRatingsDetail::class, 'downloadPDF']);
Route::get('/preview-pdf/requests',[VcSolicitudes::class, 'printPDF']);

Auth::routes();
//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');


//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');


Route::post('/areas',[App\Http\Controllers\TmAreaController::class, 'store']);

