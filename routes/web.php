<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RezervareController;
use App\Http\Controllers\RaportController;
use App\Http\Controllers\ClientNeseriosController;
use App\Http\Controllers\MesajTrimisSmsController;
use App\Http\Controllers\FacturaController;

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

Route::get('/teste-modale', [App\Http\Controllers\TesteController::class, 'testeModale']);
Route::post('/teste-modale-apasa-buton', [App\Http\Controllers\TesteController::class, 'testeModaleApasaButon']);
Route::post('/teste-modale-apasa-buton-2', [App\Http\Controllers\TesteController::class, 'testeModaleApasaButon2']);
Route::get('/test', function () {

    // $context  = stream_context_create(array('https' => array('header' => 'Accept: application/xml')));
    // // $url = 'https://www.bnr.ro/nbrfxrates.xml ';
    // $url = 'https://bjvrancea.ro/temp/nbrfxrates.xml';

    // $xml = file_get_contents($url, false, $context);
    // $xml = simplexml_load_string($xml);


    // $xml1=simplexml_load_file("https://bjvrancea.ro/temp/books.xml") or die("Error: Cannot create object");
    $xml=simplexml_load_file("https://bjvrancea.ro/temp/nbrfxrates.xml") or die("Error: Cannot create object");
    // echo $xml->book[0]->title . "<br>";
    // echo $xml->book[1]->title;
    
    $curs_bnr_euro = 0;
    foreach($xml->Body->Cube->children() as $curs_bnr) {
        if ((string) $curs_bnr['currency'] === 'EUR'){
            $curs_bnr_euro = $curs_bnr[0];
        }
    }
    echo $curs_bnr_euro;

    // echo $curs_bnr['currency'];
    // echo $books[0];
    // print_r($books);
    // echo "<br>";
    // echo $curs_bnr['currency'];
    // echo $books[0];
    // echo "<br><br>";
    // print_r($books['currency']);
    // echo "<br>";
    // print_r($books[0]);
    // echo "<br>";
    // print_r($books->attributes->currency[0]);
    // echo "<br>";
    // print_r($books['@attributes']);
    // echo "<br>";
    // echo $books->attributes . ", ";
    // echo $books->Rate . ", ";
    // echo $books->year . ", ";
    // echo $books->price . "<br><br>";

    // dd($xml, $xml1, $xml1->book, $xml2->Body->Cube->Rate);
    // print_r($xml, $xml['SimpleXMLElement']['cube']['rate']['10']);
    // print_r($xml['Subject']);
    
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('rezervari/test', [RezervareController::class, 'test']);
    Route::get('rezervari/{rezervare}/duplica', [RezervareController::class, 'duplicaRezervare']);
    Route::post('rezervari/{rezervare}/pasageri-neseriosi', [RezervareController::class, 'insereazaPasageriNeseriosi'])->name('insereaza-pasageri-neseriosi');
    Route::resource('rezervari', RezervareController::class,  ['parameters' => ['rezervari' => 'rezervare']]);

    Route::resource('clienti-neseriosi', ClientNeseriosController::class,  ['parameters' => ['clienti-neseriosi' => 'client_neserios']]);
    
    Route::post('/rapoarte/{tip_transport}/muta-rezervari', [RaportController::class, 'mutaRezervari']);
    Route::post('/rapoarte/extrage-rezervari/{view_type}', [RaportController::class, 'extrageRezervari']);
    Route::any('/rapoarte/{tip_transport}/{view_type}', [RaportController::class, 'rapoarte'])->name('rapoarte');

    Route::resource('mesaje-trimise-sms', MesajTrimisSmsController::class,  ['parameters' => ['mesaje_trimise_sms' => 'mesaj_trimis_sms']]);

    Route::resource('facturi', FacturaController::class,  ['parameters' => ['facturi' => 'factura']])
        ->only(['index']);
});