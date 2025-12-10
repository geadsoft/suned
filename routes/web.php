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
use App\Http\Livewire\VcGeneraXML;
use App\Http\Livewire\VcInventaryRegister;
use App\Http\Livewire\VcInventaryReports;
use App\Http\Livewire\VcReportCostoGastos;
use App\Http\Livewire\VcReportProductoVendido;
use App\Http\Livewire\VcReportExamsQualify;
use App\Http\Livewire\VcReportDetailQualify;
use App\Http\Livewire\VcReportPartialTeacher;
use App\Http\Livewire\VcStudents;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ArchivoController;
use App\Http\Livewire\VcReportCard;
use App\Http\Livewire\VcReportTQualify;
use App\Http\Livewire\VcReportQuarterlyTeacher;
use App\Http\Livewire\VcPartialBulletin;
use App\Http\Livewire\VcFinalBulletin;
use App\Http\Controllers\DocumentDownloadController;


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
Route::get('/phpinfo', function () {
    phpinfo();
});
Route::get('/cambia/modalidad',[App\Http\Controllers\HomeController::class, 'cambiaModalida'])->name('cambiaModalida');

Route::get('/headquarters/campus',[App\Http\Controllers\TmEmpresasController::class, 'index'])->name('index');
Route::get('/config/generality',[App\Http\Controllers\TmGeneralidadesController::class, 'index'])->name('index');
Route::get('/config/zone',[App\Http\Controllers\TmZonasController::class, 'index'])->name('index');
Route::get('/config/rols',[App\Http\Controllers\RolesController::class, 'index'])->name('index');
Route::get('/config/users',[App\Http\Controllers\RolesController::class, 'users'])->name('users');
Route::get('/config/profile',[App\Http\Controllers\TmPersonasController::class, 'perfil'])->name('perfil');


Route::get('/academic/periods',[App\Http\Controllers\TmSedesController::class, 'periodos'])->name('periodos');
Route::get('/academic/course',[App\Http\Controllers\TmCursosController::class, 'course'])->name('course');
Route::get('/academic/students',[App\Http\Controllers\TmPersonasController::class, 'index'])->name('index');
Route::get('/academic/person-add',[App\Http\Controllers\TmPersonasController::class, 'addperson'])->name('addperson');
Route::get('/academic/person-edit/{nui}',[App\Http\Controllers\TmPersonasController::class, 'editperson'])->name('editperson');
Route::get('/academic/representatives',[App\Http\Controllers\TmPersonasController::class, 'agent'])->name('agent');
Route::get('/academic/tuition',[App\Http\Controllers\TmMatriculaController::class, 'index'])->name('index');
Route::get('/academic/student-enrollment/{id}',[App\Http\Controllers\TmMatriculaController::class, 'addtuition'])->name('addtuition');
Route::get('/academic/student-enrollment',[App\Http\Controllers\TmMatriculaController::class, 'newtuition'])->name('newtuition');
Route::get('/academic/calendario',[App\Http\Controllers\TmSedesController::class, 'calendario'])->name('calendario');
Route::get('/academic/calendario-view',[App\Http\Controllers\TmSedesController::class, 'calendario_view'])->name('calendario_view');
Route::get('/academic/qualify-activity',[App\Http\Controllers\DocentesController::class, 'calificar_actividad'])->name('calificar_actividad');
Route::get('/academic/qualify-exams',[App\Http\Controllers\DocentesController::class, 'calificar_examen'])->name('calificar_examen');
Route::get('/academic/qualify-suppletory',[App\Http\Controllers\DocentesController::class, 'calificar_supletorio'])->name('calificar_supletorio');
Route::get('/academic/qualify-suppletory',[App\Http\Controllers\DocentesController::class, 'calificar_supletorio'])->name('calificar_supletorio');
Route::get('/academic/daily-attendance',[App\Http\Controllers\DocentesController::class, 'asistencia_diaria'])->name('asistencia_diaria');
Route::get('/academic/justify-faults',[App\Http\Controllers\DocentesController::class, 'justificar_faltas'])->name('justificar_faltas');
Route::get('/academic/information-student',[App\Http\Controllers\DocentesController::class, 'estudiantes'])->name('estudiantes');
Route::get('/academic/pass-course',[App\Http\Controllers\TmSedesController::class, 'pasecurso'])->name('pasecurso');
Route::get('/academic/calendar-events',[App\Http\Controllers\DocentesController::class, 'calendario_view'])->name('calendario_view');
Route::get('/academic/suggestion-box',[App\Http\Controllers\TmSedesController::class, 'buzon'])->name('buzon');
Route::get('/academic/mailbox-opinions',[App\Http\Controllers\TmSedesController::class, 'buzon_opiniones'])->name('buzon_opiniones');
Route::get('/academic/ppe',[App\Http\Controllers\TmSedesController::class, 'ppe'])->name('ppe');
Route::get('/academic/online-registration',[App\Http\Controllers\EstudiantesController::class, 'prematricula'])->name('prematricula');

Route::get('/ppe/phases/{fase}',[App\Http\Controllers\TmSedesController::class, 'ppe_fases'])->name('ppe_fases');
Route::get('/ppe/students/',[App\Http\Controllers\TmSedesController::class, 'ppe_estudiantes'])->name('ppe_estudiantes');
Route::get('/ppe/program/',[App\Http\Controllers\TmSedesController::class, 'ppe_programa'])->name('ppe_programa');

Route::get('/report/total-rating',[App\Http\Controllers\DocentesController::class, 'calificacion_total'])->name('calificacion_total');
Route::get('/report/exams-qualify',[App\Http\Controllers\DocentesController::class, 'calificacion_examen'])->name('calificacion_examen');
Route::get('/report/detailed-rating',[App\Http\Controllers\DocentesController::class, 'calificacion_detallada'])->name('calificacion_detallada');
Route::get('/report/partial-teacher',[App\Http\Controllers\DocentesController::class, 'informe_parcial'])->name('informe_parcial');
Route::get('/report/quarterly-teacher',[App\Http\Controllers\DocentesController::class, 'informe_trimestral'])->name('informe_trimestral');
Route::get('/report/partial-student',[App\Http\Controllers\DocentesController::class, 'estudiante_notas_parcial'])->name('estudiante_notas_parcial');
Route::get('/report/quarterly-student',[App\Http\Controllers\DocentesController::class, 'estudiante_notas_trimestral'])->name('estudiante_notas_trimestral');
Route::get('/report/partial-subject',[App\Http\Controllers\DocentesController::class, 'asignatura_parcial'])->name('asignatura_parcial');
Route::get('/report/quarterly-subject',[App\Http\Controllers\DocentesController::class, 'asignatura_trimestral'])->name('asignatura_trimestral');

Route::get('/report/student-grades',[App\Http\Controllers\EstudiantesController::class, 'student_grades'])->name('student_grades');
Route::get('/report/note-activity',[App\Http\Controllers\EstudiantesController::class, 'note_activity'])->name('note_activity');

Route::get('/headquarters/headquarters-add',[App\Http\Controllers\TmSedesController::class, 'index'])->name('index');
Route::get('/headquarters/pension',[App\Http\Controllers\TmPensionesCabController::class, 'index'])->name('index');
Route::get('/headquarters/educational-services',[App\Http\Controllers\TmServiciosController::class, 'index'])->name('index');
Route::get('/headquarters/educational-system',[App\Http\Controllers\TmSedesController::class, 'system'])->name('system');
Route::get('/headquarters/staff',[App\Http\Controllers\TmPersonasController::class, 'personal'])->name('personal');
Route::get('/headquarters/staff-add',[App\Http\Controllers\TmPersonasController::class, 'addpersonal'])->name('addpersonal');
Route::get('/headquarters/staff-edit/{id}',[App\Http\Controllers\TmPersonasController::class, 'editpersonal'])->name('editpersonal');
Route::get('/headquarters/staff-view/{id}',[App\Http\Controllers\TmPersonasController::class, 'viewpersonal'])->name('viewpersonal');
Route::get('/headquarters/schedules',[App\Http\Controllers\TmHorariosController::class, 'index'])->name('index');
Route::get('/headquarters/schedules-add',[App\Http\Controllers\TmHorariosController::class, 'addhorarios'])->name('addhorarios');
Route::get('/headquarters/schedules-edit/{id}',[App\Http\Controllers\TmHorariosController::class, 'edithorarios'])->name('edithorarios');
Route::get('/headquarters/subjects',[App\Http\Controllers\TmAsignaturasController::class, 'index'])->name('index');
Route::get('/headquarters/remove-teacher/{id}',[App\Http\Controllers\TmPersonasController::class, 'retirar'])->name('retirar');
Route::get('/subjects/personalize',[App\Http\Controllers\TmAsignaturasController::class, 'personalizar'])->name('personalizar');

Route::get('/financial/encashment/{id}',[App\Http\Controllers\TrCobrosCabsController::class, 'viewtuition'])->name('viewtuition');
Route::get('/financial/encashment',[App\Http\Controllers\TrCobrosCabsController::class, 'loadtuition'])->name('loadtuition');
Route::get('/financial/encashment-add/{periodoid}/{matriculaid}',[App\Http\Controllers\TrCobrosCabsController::class, 'addencashment'])->name('addescashment');
Route::get('/report/box-balance',[App\Http\Controllers\TrCobrosCabsController::class, 'cuadrecaja'])->name('cuadrecaja');
Route::get('/report/daily-charges',[App\Http\Controllers\TrCobrosCabsController::class, 'cobrosdiarios'])->name('cobrosdiarios');
Route::get('/financial/account-status',[App\Http\Controllers\TmMatriculaController::class, 'estadocuenta'])->name('estadocuenta');
Route::get('/report/statistical-graphs',[App\Http\Controllers\TrCobrosCabsController::class, 'graficos'])->name('graficos');
Route::get('/report/debt-analysis',[App\Http\Controllers\TmMatriculaController::class, 'analisisdeuda'])->name('analisisdeuda');
Route::get('/financial/list-income',[App\Http\Controllers\TrCobrosCabsController::class, 'listingresos'])->name('listingresos');
Route::get('/report/generic-reports',[App\Http\Controllers\TmMatriculaController::class, 'reportegenerico'])->name('reportegenerico');
Route::get('/secretary/certificate',[App\Http\Controllers\SecretariaController::class, 'certificados'])->name('certificados');
Route::get('/secretary/documentation',[App\Http\Controllers\SecretariaController::class, 'documentos'])->name('documentos');

Route::get('/academic/ratings',[App\Http\Controllers\TmCalificaciones::class, 'index'])->name('index');
Route::get('/academic/ratings-add',[App\Http\Controllers\TmCalificaciones::class, 'addCalificacion'])->name('addCalificacion');
Route::get('/secretary/ratings',[App\Http\Controllers\SecretariaController::class, 'ratings'])->name('ratings');
Route::get('/secretary/report-cas',[App\Http\Controllers\SecretariaController::class, 'reportCas'])->name('reportCas');
Route::get('/secretary/titles-file',[App\Http\Controllers\SecretariaController::class, 'titlesFile'])->name('titlesFile');
Route::get('/secretary/requests',[App\Http\Controllers\SecretariaController::class, 'requests'])->name('requests');
Route::get('/secretary/promotion',[App\Http\Controllers\SecretariaController::class, 'promotion'])->name('promotion');
Route::get('/sri/create-invoice',[App\Http\Controllers\TrFacturasCabsController::class, 'index'])->name('index');
Route::get('/sri/invoices/{tipo}',[App\Http\Controllers\TrFacturasCabsController::class, 'documents'])->name('documents');
Route::get('/invoice/view/{id}',[App\Http\Controllers\TrFacturasCabsController::class, 'viewfe'])->name('viewfe');
Route::get('/credits/view/{id}',[App\Http\Controllers\TrFacturasCabsController::class, 'viewne'])->name('viewne');
Route::get('/report/utility',[App\Http\Controllers\TmProductosController::class, 'utilidad'])->name('utilidad');
Route::get('/report/sold-products',[App\Http\Controllers\TmProductosController::class, 'productosVendidos'])->name('productosVendidos');

Route::get('/inventary/products',[App\Http\Controllers\TmProductosController::class, 'index'])->name('index');
Route::get('/inventary/products-add',[App\Http\Controllers\TmProductosController::class, 'add'])->name('add');
Route::get('/inventary/products-edit/{id}',[App\Http\Controllers\TmProductosController::class, 'edit'])->name('edit');
Route::get('/inventary/register',[App\Http\Controllers\TmProductosController::class, 'register'])->name('register');
Route::get('/inventary/register-edit/{id}',[App\Http\Controllers\TmProductosController::class, 'editregister'])->name('editregister');
Route::get('/inventary/movements',[App\Http\Controllers\TmProductosController::class, 'movements'])->name('movements');
Route::get('/products/kardex',[App\Http\Controllers\TmProductosController::class, 'kardex'])->name('kardex');
Route::get('/inventary/stock',[App\Http\Controllers\TmProductosController::class, 'stock'])->name('stock');
Route::get('/inventary/detail-products',[App\Http\Controllers\TmProductosController::class, 'report'])->name('report');
Route::get('/sri/create-credits',[App\Http\Controllers\TrFacturasCabsController::class, 'ncredits'])->name('ncredits');
Route::get('/inventary/detail-movements',[App\Http\Controllers\TmProductosController::class, 'details'])->name('details');
Route::get('/activities/activity',[App\Http\Controllers\DocentesController::class, 'activity_index'])->name('activity_index');
Route::get('/activities/activity-add',[App\Http\Controllers\DocentesController::class, 'activity_add'])->name('activity_add');
Route::get('/activities/activity-edit/{id}',[App\Http\Controllers\DocentesController::class, 'activity_edit'])->name('activity_edit');
Route::get('/activities/activity-view/{id}',[App\Http\Controllers\DocentesController::class, 'activity_view'])->name('activity_view');
Route::get('/activities/virtual-classes',[App\Http\Controllers\DocentesController::class, 'classes_index'])->name('classes_index');
Route::get('/virtual-classes/join',[App\Http\Controllers\DocentesController::class, 'classes_join'])->name('classes_join');
Route::get('/activities/exams',[App\Http\Controllers\DocentesController::class, 'exams_index'])->name('exams_index');
Route::get('/activities/exam-add',[App\Http\Controllers\DocentesController::class, 'exams_add'])->name('exams_add');
Route::get('/activities/exam-edit/{id}',[App\Http\Controllers\DocentesController::class, 'exams_edit'])->name('exams_edit');
Route::get('/activities/exam-view/{id}',[App\Http\Controllers\DocentesController::class, 'exams_view'])->name('exams_view');
Route::get('/teachers/courses',[App\Http\Controllers\DocentesController::class, 'courses_index'])->name('courses_index');
Route::get('/courses/course-view/{id}',[App\Http\Controllers\DocentesController::class, 'courses_view'])->name('courses_view');
Route::get('/activities/suppletory',[App\Http\Controllers\DocentesController::class, 'suppletory_index'])->name('suppletory_index');
Route::get('/activities/suppletory-add',[App\Http\Controllers\DocentesController::class, 'suppletory_add'])->name('suppletory_add');
Route::get('/activities/suppletory-edit/{id}',[App\Http\Controllers\DocentesController::class, 'suppletory_edit'])->name('suppletory_edit');
Route::get('/activities/suppletory-view/{id}',[App\Http\Controllers\DocentesController::class, 'suppletory_view'])->name('suppletory_view');
Route::get('/subject/resources',[App\Http\Controllers\DocentesController::class, 'resources'])->name('resources');
Route::get('/subject/resource-add',[App\Http\Controllers\DocentesController::class, 'resources_add'])->name('resources_add');
Route::get('/subject/resource-view/{id}',[App\Http\Controllers\DocentesController::class, 'resources_view'])->name('resources_view');
Route::get('/subject/resource-edit/{id}',[App\Http\Controllers\DocentesController::class, 'resources_edit'])->name('resources_edit');
Route::get('/subject/flipbook-viewer/{id}',[App\Http\Controllers\DocentesController::class, 'flipbook_viewer'])->name('flipbook_viewer');
Route::get('/teachers/library',[App\Http\Controllers\DocentesController::class, 'library'])->name('library');
Route::get('/student/library',[App\Http\Controllers\EstudiantesController::class, 'library'])->name('library');

Route::get('/student/subject',[App\Http\Controllers\EstudiantesController::class, 'subject'])->name('subject');
Route::get('/student/subject-view/{data}',[App\Http\Controllers\EstudiantesController::class, 'subject_view'])->name('subject_view');
Route::get('/student/school-schedule',[App\Http\Controllers\EstudiantesController::class, 'school_schedule'])->name('school_schedule');
Route::get('/student/deliver-activity/{id},{data}',[App\Http\Controllers\EstudiantesController::class, 'deliver_activity'])->name('deliver_activity');
Route::get('/student/activities',[App\Http\Controllers\EstudiantesController::class, 'student_activities'])->name('student_activities');
Route::get('/student/resources',[App\Http\Controllers\EstudiantesController::class, 'student_resources'])->name('student_resources');
Route::get('/student/resource-view/{id}',[App\Http\Controllers\EstudiantesController::class, 'resources_view'])->name('resources_view');
Route::get('/student/show-assistance',[App\Http\Controllers\EstudiantesController::class, 'assistance'])->name('assistance');
Route::get('/student/teacher-assistance',[App\Http\Controllers\DocentesController::class, 'asistencia_materia'])->name('asistencia_materia');
Route::get('/student/report-card',[App\Http\Controllers\EstudiantesController::class, 'report_card'])->name('report_card');
Route::get('/student/qualify-conduct',[App\Http\Controllers\EstudiantesController::class, 'qualify_conduct'])->name('qualify_conduct');
Route::get('/student/partial-bulletin',[App\Http\Controllers\EstudiantesController::class, 'partial_bulletin'])->name('partial_bulletin');
Route::get('/student/final-bulletin',[App\Http\Controllers\EstudiantesController::class, 'final_bulletin'])->name('final_bulletin');
Route::get('/descargar-archivo/{id}', [ArchivoController::class, 'descargar'])->name('archivo.descargar');

Route::get('/view-pdf/{fileId}/download', [\App\Http\Controllers\DocumentDownloadController::class, 'downloadById'])
    ->name('pdf.download')
    ->middleware('auth'); // opcional

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
Route::get('/preview-pdf/record-inv/{id}',[VcInventaryRegister::class, 'liveWirePDF']);
Route::get('/preview-pdf/detail-products/{data}',[VcInventaryReports::class, 'printPDF']);
Route::get('/download-pdf/detail-products/{data}',[VcInventaryReports::class, 'downloadPDF']);
Route::get('/preview-pdf/report-utilitys/{data}',[VcReportCostoGastos::class, 'printPDF']);
Route::get('/download-pdf/report-utilitys/{data}',[VcReportCostoGastos::class, 'downloadPDF']);
Route::get('/preview-pdf/report-soldproductos/{data},"PRD"',[VcReportProductoVendido::class, 'printPDF']);
Route::get('/download-pdf/report-soldproductos/{data},"PRD"',[VcReportProductoVendido::class, 'downloadPDF']);
Route::get('/preview-pdf/calificacion_examen/{data}',[VcReportExamsQualify::class, 'printPDF']);
Route::get('/preview-pdf/detailed-rating/{data}',[VcReportDetailQualify::class, 'printPDF']);
Route::get('/preview-pdf/total-rating/{data}',[VcReportTQualify::class, 'printPDF']);
Route::get('/preview-pdf/partial-teacher/{data}',[VcReportPartialTeacher::class, 'printPDF']);
//Route::get('/preview-pdf/quarterly-teacher/{data}',[VcReportQuarterlyTeacher::class, 'printPDF']);
Route::get('/preview-pdf/informacion-student/{id}',[VcStudents::class, 'printFichaPDF']);
Route::get('/preview-pdf/report-card/{data}',[VcReportCard::class, 'printPDF']);
Route::get('/preview-pdf/partial-bulletin/{data}',[VcPartialBulletin::class, 'printPDF']);
Route::get('/preview-pdf/final-bulletin/{data}',[VcFinalBulletin::class, 'printPDF']);


Route::get('/invoice/genera/{id}',[VcGeneraXML::class, 'setGeneraXML']);
Route::get('/invoice/ride-pdf/{id}',[VcGeneraXML::class, 'imprimeRide']);

Route::get('/preview-pdf/detail-movements/{report},{data}',[VcInventaryReports::class, 'printPDF']);
Route::get('/download-pdf/detail-movements/{report},{data}',[VcInventaryReports::class, 'downloadPDF']);

Route::get('pdf/{report},{data}', [PdfController::class, 'index']);
Route::get('/preview-pdf/quarterly-teacher/{data}', [PdfController::class, 'informe_docente_trimestral'])->name('pdf.informe_docente_trimestral');

/*Route::middleware(['auth'],['roles:D'])->group(function(){
    Route::get('/teachers/login', [App\Http\Controllers\DocentesController::class, 'index'])->name('login');
});*/
Route::get('/teachers/login', [App\Http\Controllers\DocentesController::class, 'index'])->name('login');
Route::post('/teachers/login', 'App\Http\Controllers\LoginController@login');
Auth::Routes();



//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);
Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');

//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');


Route::post('/areas',[App\Http\Controllers\TmAreaController::class, 'store']);

