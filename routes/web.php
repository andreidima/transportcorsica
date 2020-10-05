<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RezervareController;
use App\Http\Controllers\RaportController;

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
Route::any('/adauga-rezervare-noua', [RezervareController::class, 'adaugaRezervareNoua']);
Route::get('/adauga-rezervare-pasul-1', [RezervareController::class, 'adaugaRezervarePasul1']);
Route::post('/adauga-rezervare-pasul-1', [RezervareController::class, 'postadaugaRezervarePasul1']);
Route::get('/adauga-rezervare-pasul-2', [RezervareController::class, 'adaugaRezervarePasul2']);
Route::post('/adauga-rezervare-pasul-2', [RezervareController::class, 'postAdaugaRezervarePasul2']);
Route::get('/adauga-rezervare-pasul-3', [RezervareController::class, 'adaugaRezervarePasul3']);
Route::get('/bilet-rezervat/{view_type}', [RezervareController::class, 'pdfExportGuest']);

// Extras date cu Axios
Route::get('/orase_rezervari', [RezervareController::class, 'orase_rezervari']);


Route::group(['middleware' => 'auth'], function () {
    Route::resource('rezervari', RezervareController::class,  ['parameters' => ['rezervari' => 'rezervare']]);
    
    Route::any('/rapoarte', [RaportController::class, 'rapoarte']);
});