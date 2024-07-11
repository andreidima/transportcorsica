<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Rezervare;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $search_nume = \Request::get('search_nume');
        // $search_telefon = \Request::get('search_telefon');
        $facturi = Factura::with('rezervare', 'rezervare.pasageri_relation')
            // when($search_nume, function ($query, $search_nume) {
            //     return $query->where('nume', 'like', '%' . $search_nume . '%');
            // })
            // ->when($search_telefon, function ($query, $search_telefon) {
            //     return $query->where('telefon', 'like', '%' . $search_telefon . '%');
            // })
            ->latest()
            ->simplePaginate(25);

        // return view('facturi.index', compact('facturi', 'search_nume', 'search_telefon'));
        return view('facturi.index', compact('facturi'));
    }

    public function destroy(Factura $factura)
    {
        $factura->delete();
        return back()->with('status', 'Factura „' . $factura->seria . $factura->numar . '” a fost ștearsă cu succes!');
    }

    public function anuleaza(Request $request, Factura $factura = null)
    {
        // dd ($request->anulare_motiv);
        // if ($factura->anulata === 1){
        //     $factura->anulata = 0;
        //     $factura->anulare_motiv = null;
        //     $factura->update();
        //     return back()->with('status', 'Factura pentru ' . $factura->cumparator . ', a fost activată cu success!');
        // } else {
        //     $factura->anulata = 1;
        //     $factura->anulare_motiv = $request->anulare_motiv ?? '';
        //     $factura->update();
        //     return back()->with('status', 'Factura pentru ' . $factura->cumparator . ', a fost anulată cu success!');
        // }

        $factura_storno = $factura->replicate();
        $factura_storno->numar = (Factura::select('numar')->latest()->first()->numar ?? 0) + 1;
        $factura_storno->valoare_euro = $factura->valoare_euro;
        $factura_storno->valoare_lei = -$factura->valoare_lei;
        $factura_storno->valoare_lei_tva = -$factura->valoare_lei_tva;
        $factura_storno->anulare_factura_id_originala = $factura->id;
        $factura_storno->anulare_motiv = $request->anulare_motiv ?? '';
        $factura_storno->save();

        $factura->anulata = 1;
        $factura->update();

        // dd($factura_storno, $factura);

        return back()->with('status', 'Factura pentru „' . $factura->cumparator . '” a fost anulată și a fost generată Factură Storno cu success!');

    }

    public function exportPDF(Request $request, Factura $factura = null, $view_type = null)
    {
        if (!$factura->rezervare()->exists()){
            return back()->with('error', 'Rezervarea acestei facturi a fost stearsa!');
        }

        if ($view_type === 'export-html') {
            return view('facturi.export.factura', compact('factura'));
        } elseif ($view_type === 'export-pdf') {
                $pdf = \PDF::loadView('facturi.export.factura', compact('factura'))
                    ->setPaper('a4', 'portrait');
                return $pdf->download('Factura ' . $factura->cumparator . ' - ' . \Carbon\Carbon::parse($factura->created_at)->isoFormat('DD.MM.YYYY') . '.pdf');
        }
    }

    public function trimiteInSmartbill(Request $request, Factura $factura = null)
    {
        $facturaDescriere = "Bilet de călătorie: " . ($factura->rezervare->bilet_serie ?? '') . ($factura->rezervare->bilet_numar ?? '') . " | Dată transport: " . Carbon::parse($factura->rezervare->data_cursa)->isoFormat('DD.MM.YYYY') . '. '
            . (
                $rezervare_retur = Rezervare::find($factura->rezervare->retur)
                ?
                "Bilet de călătorie: " . ($rezervare_retur->bilet_serie ?? '') . ($rezervare_retur->bilet_numar ?? '') . ' ' . " | Dată transport: " . Carbon::parse($rezervare_retur->data_cursa)->isoFormat('DD.MM.YYYY')
                :
                ''
            );

        $facturaDescriere .= "Pasageri: ";
        if ($factura->rezervare->nr_adulti){
            foreach ($factura->rezervare->pasageri_relation as $pasager) {
                $facturaDescriere .= $pasager->nume . ', ';
            }
            $facturaDescriere = substr_replace($facturaDescriere, '', -2); // delete the last comma and space
            $facturaDescriere .= ". ";
        }

        $facturaDescriere .= "Preț în EURO: " . round($factura->valoare_euro) . " EURO. ";
        $facturaDescriere .= "Curs valutar BNR la data rezervării biletului de călătorie (" . Carbon::parse($factura->rezervare->created_at)->isoFormat('DD.MM.YYYY') . "): 1 EURO = " . $factura->curs_bnr_euro;

        // URL-ul API-ului
        $url = "https://ws.smartbill.ro/SBORO/api/invoice";

        // Datele pentru body-ul cererii
        $data = json_encode([
            "companyVatCode" => "RO35059906",
            "seriesName" => "MRW88",
            "client" => [
                "name" => $factura->cumparator,
                "vatCode" => $factura->cif,
                "isTaxPayer" => true,
                "address" => $factura->sediul,
                "country" => "Romania",
                "saveToDb" => false
            ],
            "issueDate" => Carbon::parse($factura->created_at)->isoFormat('YYYY-MM-DD'),
            "products" => [
                [
                    "code" => "10",
                    "name" => "Servicii transport international persoane",
                    "productDescription" => $facturaDescriere,
                    "measuringUnitName" => "buc",
                    "currency" => "RON",
                    "quantity" => 1,
                    "price" => $factura->valoare_lei + $factura->valoare_lei_tva,
                    "isTaxIncluded" => false,
                    "taxName" => "SDD",
                    "taxPercentage" => 0,
                    "saveToDb" => false
                ]
            ]
        ]);

        // Inițializarea sesiunii cURL
        $ch = curl_init($url);

        // Setarea opțiunilor cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "accept: application/json",
            "authorization: " . \Config::get('variabile.smartbillCurlAuthorization'),
            "content-type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
// dd(curl_getinfo($ch));
        // Executarea cererii și captarea răspunsului
        $response = curl_exec($ch);

        // Verificarea erorilor
        if (curl_errno($ch)) {
            'Eroare cURL: ' . curl_error($ch);

            // Închiderea sesiunii cURL
            curl_close($ch);
        } else {
            // Procesarea răspunsului
            // echo 'Răspuns: ' . $response;

            // Închiderea sesiunii cURL
            curl_close($ch);

            // Return back to page
            return back()->with('status', 'Factura „' . $factura->seria . $factura->numar . '” a fost trimisă în Smartbill cu succes!');
        }

        // Închiderea sesiunii cURL
        // curl_close($ch);
    }
}
