<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RezervareController;
use App\Http\Controllers\RaportController;
use App\Http\Controllers\ClientNeseriosController;
use App\Http\Controllers\MesajTrimisSmsController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\PlataOnlineController;
use App\Http\Controllers\VueJSController;

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

// Route::get('/test-sum-model', function () {
//     $rezervare_tur = \App\Models\Rezervare::find(740);

    
//             $paymentRequest    = 
//                 (stripos($rezervare_tur->pasageri_relation->first()->nume ?? '', 'Andrei Dima test') !== false) ?
//                         0.05
//                         :
//                         ( 
//                             $rezervare_tur->valoare_lei + $rezervare_tur->valoare_lei_tva + 
//                             (($rezervare_tur->retur) ? (\App\Models\Rezervare::find($rezervare_tur->retur)->valoare_lei + \App\Models\Rezervare::find($rezervare_tur->retur)->valoare_lei_tva) : 0 )
//                         );
            
        
//     return($paymentRequest);

// });

// Route::get('/teste-modale', [App\Http\Controllers\TesteController::class, 'testeModale']);
// Route::post('/teste-modale-apasa-buton', [App\Http\Controllers\TesteController::class, 'testeModaleApasaButon']);
// Route::post('/teste-modale-apasa-buton-2', [App\Http\Controllers\TesteController::class, 'testeModaleApasaButon2']);
// Route::get('/test-bnr-curs-euro', function () {

//     // $context  = stream_context_create(array('https' => array('header' => 'Accept: application/xml')));
//     // // $url = 'https://www.bnr.ro/nbrfxrates.xml ';
//     // $url = 'https://bjvrancea.ro/temp/nbrfxrates.xml';

//     // $xml = file_get_contents($url, false, $context);
//     // $xml = simplexml_load_string($xml);

//     $curs_bnr_euro = \App\Models\Variabila::where('nume', 'curs_bnr_euro')->first();

//     // dd(\Carbon\Carbon::parse($curs_bnr_euro->updated_at)->hour);
//     // dd(\Carbon\Carbon::today()->hour = 9);
//     // Cursul EURO se actualizeaza pe site-ul BNR in fiecare zi imediat dupa ora 13:00
//     if (\Carbon\Carbon::now()->hour >= 14) {
//         if (\Carbon\Carbon::parse($curs_bnr_euro->updated_at) < (\Carbon\Carbon::today()->hour(14))){
//             $xml=simplexml_load_file("https://www.bnr.ro/nbrfxrates.xml") or die("Error: Cannot create object");            
//             foreach($xml->Body->Cube->children() as $curs_bnr) {
//                 if ((string) $curs_bnr['currency'] === 'EUR'){
//                     $curs_bnr_euro->valoare = $curs_bnr[0];
//                     $curs_bnr_euro->save();
//                 }
//             }
//         }
//     } else {
//         if (\Carbon\Carbon::parse($curs_bnr_euro->updated_at) < (\Carbon\Carbon::yesterday()->hour(14))){
//             $xml=simplexml_load_file("https://www.bnr.ro/nbrfxrates.xml") or die("Error: Cannot create object");            
//             foreach($xml->Body->Cube->children() as $curs_bnr) {
//                 if ((string) $curs_bnr['currency'] === 'EUR'){
//                     $curs_bnr_euro->valoare = $curs_bnr[0];
//                     $curs_bnr_euro->save();
//                 }
//             }        
//         }
//     }

    
    
//     // $xml1=simplexml_load_file("https://bjvrancea.ro/temp/books.xml") or die("Error: Cannot create object");
//     // $xml=simplexml_load_file("https://bjvrancea.ro/temp/nbrfxrates.xml") or die("Error: Cannot create object");
//     // echo $xml->book[0]->title . "<br>";
//     // echo $xml->book[1]->title;
    

//     // $curs_bnr_euro = 0;
//     // foreach($xml->Body->Cube->children() as $curs_bnr) {
//     //     if ((string) $curs_bnr['currency'] === 'EUR'){
//     //         $curs_bnr_euro = $curs_bnr[0];
//     //     }
//     // }
//     // echo $curs_bnr_euro;

//     // echo $curs_bnr['currency'];
//     // echo $books[0];
//     // print_r($books);
//     // echo "<br>";
//     // echo $curs_bnr['currency'];
//     // echo $books[0];
//     // echo "<br><br>";
//     // print_r($books['currency']);
//     // echo "<br>";
//     // print_r($books[0]);
//     // echo "<br>";
//     // print_r($books->attributes->currency[0]);
//     // echo "<br>";
//     // print_r($books['@attributes']);
//     // echo "<br>";
//     // echo $books->attributes . ", ";
//     // echo $books->Rate . ", ";
//     // echo $books->year . ", ";
//     // echo $books->price . "<br><br>";

//     // dd($xml, $xml1, $xml1->book, $xml2->Body->Cube->Rate);
//     // print_r($xml, $xml['SimpleXMLElement']['cube']['rate']['10']);
//     // print_r($xml['Subject']);    
// });
// Route::get('/test-file-download', function () {
//     $clienti_neseriosi = \App\Models\ClientNeserios::pluck('nume')->all();
//     $tip_lista = 'lista_plecare';
//     $rezervari = \App\Models\Rezervare::join('orase as orase_plecare', 'rezervari.oras_plecare', '=', 'orase_plecare.id')
//         ->join('orase as orase_sosire', 'rezervari.oras_sosire', '=', 'orase_sosire.id')
//         ->with('pasageri_relation')
//         ->select(
//             'rezervari.*',
//             'orase_plecare.tara as oras_plecare_tara',
//             'orase_plecare.oras as oras_plecare_nume',
//             'orase_plecare.traseu as oras_plecare_traseu',
//             'orase_sosire.tara as oras_sosire_tara',
//             'orase_sosire.oras as oras_sosire_nume',
//             'orase_sosire.traseu as oras_sosire_traseu'
//         )
//         ->take(10)
//         ->get();
//     $pdf = \PDF::loadView('rapoarte.export.raport-pdf', compact('rezervari', 'clienti_neseriosi', 'tip_lista'))
//         ->setPaper('a4');
//     // return $pdf->stream('Rezervare ' . $rezervari->nume . '.pdf');
//     return $pdf->download('Raport ' . ($tip_lista === "lista_plecare" ? 'lista plecare ' : 'lista sosire ') .
//         \Carbon\Carbon::parse($rezervari->first()->data_cursa)->isoFormat('DD.MM.YYYY') .
//         '.pdf');
// });

// Route::get('/test', function () {
//     $rezervare = App\Models\Rezervare::find(471);
//     dd($rezervare, $rezervare->pasageri_relation->first()->nume);
//     echo $rezervare->pasageri_relation->first->nume;
// });



    // Route::post('/rapoarte/extrage-rezervari/{view_type}', [RaportController::class, 'extrageRezervari']);
    // Route::any('/rapoarte/{tip_transport}/{view_type}', [RaportController::class, 'rapoarte'])->name('rapoarte');


Route::group(['middleware' => 'auth'], function () {
    Route::get('rezervari/test', [RezervareController::class, 'test']);
    Route::get('rezervari/{rezervare}/duplica', [RezervareController::class, 'duplicaRezervare']);
    Route::post('rezervari/{rezervare}/pasageri-neseriosi', [RezervareController::class, 'insereazaPasageriNeseriosi'])->name('insereaza-pasageri-neseriosi');
    Route::resource('rezervari', RezervareController::class,  ['parameters' => ['rezervari' => 'rezervare']]);

    Route::get('/bilet-rezervat-user-logat/{view_type}/{rezervare_tur}/{rezervare_retur?}', [RezervareController::class, 'pdfExport']);

    Route::resource('clienti-neseriosi', ClientNeseriosController::class,  ['parameters' => ['clienti-neseriosi' => 'client_neserios']]);
    
    Route::post('/rapoarte/{tip_transport}/muta-rezervari', [RaportController::class, 'mutaRezervari']);
    Route::post('/rapoarte/extrage-rezervari/{view_type}', [RaportController::class, 'extrageRezervari']);
    Route::any('/rapoarte/{tip_transport}/{view_type}', [RaportController::class, 'rapoarte'])->name('rapoarte');
    Route::any('/rapoarte/{raport}/{tara_plecare}/{data}/{lista}/{tip_lista}/{tip_transport}/extrage-rezervari/{view_type}', [RaportController::class, 'extrageRezervariIphone'])->name('rapoarteIphone');

    Route::resource('mesaje-trimise-sms', MesajTrimisSmsController::class,  ['parameters' => ['mesaje_trimise_sms' => 'mesaj_trimis_sms']]);

    Route::resource('facturi', FacturaController::class,  ['parameters' => ['facturi' => 'factura']])
        ->only(['index']);
    Route::any('/facturi/{factura}/anuleaza', [FacturaController::class, 'anuleaza']);
    Route::get('/facturi/{factura}/export/{view_type}', [FacturaController::class, 'exportPDF']);

    Route::get('vuejs/autocomplete', [VueJSController::class, 'autocomplete']);
    Route::get('vuejs/autocomplete/search', [VueJSController::class, 'autocompleteSearch']);
});