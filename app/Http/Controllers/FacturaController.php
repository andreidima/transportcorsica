<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use Illuminate\Http\Request;

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
        $facturi = Factura::
            // when($search_nume, function ($query, $search_nume) {
            //     return $query->where('nume', 'like', '%' . $search_nume . '%');
            // })
            // ->when($search_telefon, function ($query, $search_telefon) {
            //     return $query->where('telefon', 'like', '%' . $search_telefon . '%');
            // })
            latest()
            ->simplePaginate(25);
            
        // return view('facturi.index', compact('facturi', 'search_nume', 'search_telefon'));
        return view('facturi.index', compact('facturi'));
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
        if ($view_type === 'export-html') {
            return view('facturi.export.factura', compact('factura'));
        } elseif ($view_type === 'export-pdf') {
                $pdf = \PDF::loadView('facturi.export.factura', compact('factura'))
                    ->setPaper('a4', 'portrait');
                return $pdf->download('Factura ' . $factura->cumparator . ' - ' . \Carbon\Carbon::parse($factura->created_at)->isoFormat('DD.MM.YYYY') . '.pdf');
        }
    }
}
