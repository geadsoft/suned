<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\VcEncashmentDebts;
use App\Http\Livewire\VcReportCashReceints;

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
Route::get('/academic/course',[App\Http\Controllers\TmCursosController::class, 'course'])->name('course');
Route::get('/academic/person',[App\Http\Controllers\TmPersonasController::class, 'index'])->name('index');
Route::get('/academic/person-add',[App\Http\Controllers\TmPersonasController::class, 'addperson'])->name('addperson');
Route::get('/academic/person-edit/{nui}',[App\Http\Controllers\TmPersonasController::class, 'editperson'])->name('editperson');
Route::get('/academic/tuition',[App\Http\Controllers\TmMatriculaController::class, 'index'])->name('index');
Route::get('/academic/student-enrollment/{id}',[App\Http\Controllers\TmMatriculaController::class, 'addtuition'])->name('addtuition');
Route::get('/academic/student-enrollment',[App\Http\Controllers\TmMatriculaController::class, 'newtuition'])->name('newtuition');
Route::get('/headquarters/headquarters-add',[App\Http\Controllers\TmSedesController::class, 'index'])->name('index');
Route::get('/headquarters/pension',[App\Http\Controllers\TmPensionesCabController::class, 'index'])->name('index');
Route::get('/headquarters/educational-services',[App\Http\Controllers\TmServiciosController::class, 'index'])->name('index');
Route::get('/financial/encashment',[App\Http\Controllers\TrCobrosCabsController::class, 'index'])->name('index');
Route::get('/financial/encashment-add',[App\Http\Controllers\TrCobrosCabsController::class, 'addencashment'])->name('addescashment');
Route::get('/financial/create-invoice',[App\Http\Controllers\TrFacturasCabsController::class, 'index'])->name('index');
Route::get('/report/box-balance',[App\Http\Controllers\TrCobrosCabsController::class, 'cuadrecaja'])->name('cuadrecaja');
Route::get('/download-pdf',[VcReportCashReceints::class, 'downloadPDF']);

Auth::routes();
//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');


//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');


Route::post('/areas',[App\Http\Controllers\TmAreaController::class, 'store']);

