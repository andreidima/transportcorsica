<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RezervareController;
use App\Http\Controllers\RaportController;
use App\Http\Controllers\ClientNeseriosController;

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

Auth::routes(['register' => false, 'password.request' => false, 'reset' => false]);


Route::get('/rezervare-client', function () {
    return view('rezervare-client');
});

Route::redirect('/', 'adauga-rezervare-noua');

// Rute pentru rezervare facuta de guest
Route::any('/adauga-rezervare-noua', [RezervareController::class, 'adaugaRezervareNoua'])->name('adauga-rezervare-noua');
Route::get('/adauga-rezervare-pasul-1', [RezervareController::class, 'adaugaRezervarePasul1']);
Route::post('/adauga-rezervare-pasul-1', [RezervareController::class, 'postadaugaRezervarePasul1']);
Route::get('/adauga-rezervare-pasul-2', [RezervareController::class, 'adaugaRezervarePasul2']);
Route::post('/adauga-rezervare-pasul-2', [RezervareController::class, 'postAdaugaRezervarePasul2']);
Route::get('/adauga-rezervare-pasul-3', [RezervareController::class, 'adaugaRezervarePasul3']);
Route::get('/bilet-rezervat/{view_type}', [RezervareController::class, 'pdfExportGuest']);

// Extras date cu Axios
Route::get('/orase_rezervari', [RezervareController::class, 'orase_rezervari']);


Route::group(['middleware' => 'auth'], function () {
    Route::get('rezervari/test', [RezervareController::class, 'test']);
    Route::get('rezervari/{rezervare}/duplica', [RezervareController::class, 'duplicaRezervare']);
    Route::post('rezervari/{rezervare}/pasageri-neseriosi', [RezervareController::class, 'insereazaPasageriNeseriosi'])->name('insereaza-pasageri-neseriosi');
    Route::resource('rezervari', RezervareController::class,  ['parameters' => ['rezervari' => 'rezervare']]);

    Route::resource('clienti-neseriosi', ClientNeseriosController::class,  ['parameters' => ['clienti-neseriosi' => 'client_neserios']]);
    
    Route::post('/rapoarte/muta-rezervari', [RaportController::class, 'mutaRezervari']);
    Route::post('/rapoarte/extrage-rezervari/{view_type}', [RaportController::class, 'extrageRezervari']);
    Route::post('/rapoarte/excel-nava/{view_type}', [RaportController::class, 'excelNava']);
    Route::any('/rapoarte/{view_type}', [RaportController::class, 'rapoarte'])->name('rapoarte');
});