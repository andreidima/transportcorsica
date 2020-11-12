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
