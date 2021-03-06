<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RezervareController;
use App\Http\Controllers\RaportController;
use App\Http\Controllers\ClientNeseriosController;
use App\Http\Controllers\MesajTrimisSmsController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\PlataOnlineController;
use App\Http\Controllers\VueJSController;
use App\Http\Controllers\SmsBulkController;
use App\Http\Controllers\Test;

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
Route::get('/factura-descarca/{view_type}', [RezervareController::class, 'exportPDFGuest']);
Route::get('/chitanta-descarca/{cheie_unica}/seteaza_orase', [RezervareController::class, 'chitantaSeteazaOraseGuest']);
Route::post('/chitanta-descarca/{cheie_unica}/seteaza_orase', [RezervareController::class, 'postChitantaSeteazaOraseGuest']);
Route::get('/chitanta-descarca/{cheie_unica}/{view_type}', [RezervareController::class, 'chitantaExportPDFGuest'])->name('chitanta-descarca');
// Route::get('/chitanta-descarca/{view_type}', [RezervareController::class, 'chitantaExportPDFGuest']);

// Extras date cu Axios
Route::get('/orase_rezervari', [RezervareController::class, 'orase_rezervari']);

Route::get('/trimitere-catre-plata/{rezervare_tur}', [PlataOnlineController::class, 'trimitereCatrePlata'])->name('trimitere-catre-plata');
Route::post('/confirmare-plata', [PlataOnlineController::class, 'confirmarePlata'])->name('confirmare-plata');

Route::middleware(['role:administrator,sofer'])->group(function () {
    // Route::view('/home', 'home');
    Route::resource('rezervari', RezervareController::class,  ['parameters' => ['rezervari' => 'rezervare']]);
    // Route::resource('rezervari', RezervareController::class,  ['parameters' => ['rezervari' => 'rezervare']])->only([
    //     'index', 'show'
    // ]);
    Route::post('/rapoarte/extrage-rezervari/{view_type}', [RaportController::class, 'extrageRezervari']);
    Route::post('/rapoarte/{tip_transport}/muta-rezervari', [RaportController::class, 'mutaRezervari']);
    Route::post('/rapoarte/{tip_transport}/muta-rezervare/{rezervare}', [RaportController::class, 'mutaRezervare']);
    Route::any('/rapoarte/{tip_transport}/{view_type}', [RaportController::class, 'rapoarte'])->name('rapoarte');
    Route::any('/rapoarte/{raport}/{tara_plecare}/{data}/{lista}/{tip_lista}/{tip_transport}/extrage-rezervari/{view_type}', [RaportController::class, 'extrageRezervariIphone'])->name('rapoarteIphone');

    Route::get('/bilet-rezervat-user-logat/{view_type}/{rezervare_tur}/{rezervare_retur?}', [RezervareController::class, 'pdfExport']);

    Route::get('rezervari/test', [RezervareController::class, 'test']);
    Route::get('rezervari/{rezervare}/duplica', [RezervareController::class, 'duplicaRezervare']);
    Route::post('rezervari/{rezervare}/pasageri-neseriosi', [RezervareController::class, 'insereazaPasageriNeseriosi'])->name('insereaza-pasageri-neseriosi');

    // Route::resource('rezervari', RezervareController::class,  ['parameters' => ['rezervari' => 'rezervare']])->only([
    //     'create', 'store', 'update', 'destroy'
    // ]);


    Route::resource('clienti-neseriosi', ClientNeseriosController::class,  ['parameters' => ['clienti-neseriosi' => 'client_neserios']]);
    

    Route::resource('mesaje-trimise-sms', MesajTrimisSmsController::class,  ['parameters' => ['mesaje_trimise_sms' => 'mesaj_trimis_sms']]);

    Route::resource('facturi', FacturaController::class,  ['parameters' => ['facturi' => 'factura']])
        ->only(['index']);
    Route::any('/facturi/{factura}/anuleaza', [FacturaController::class, 'anuleaza']);
    Route::get('/facturi/{factura}/export/{view_type}', [FacturaController::class, 'exportPDF']);

    Route::get('vuejs/autocomplete', [VueJSController::class, 'autocomplete']);
    Route::get('vuejs/autocomplete/search', [VueJSController::class, 'autocompleteSearch']);

    Route::get('sms-bulk/{rezervari}', [SmsBulkController::class, 'trimiteSmsBulk']);
});