<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use Illuminate\Support\Facades\DB;

class VueJSController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function autocomplete()
    {
        return view('vuejsAutocomplete');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function autocompleteSearch(Request $request)
    {
        $cumparator = $request->cumparator;
        // $data = Factura::select('cumparator', 'nr_reg_com', 'cif', 'judet', 'sediul')->groupBy('cumparator')->where('cumparator','like','%'.$cumparator.'%')->get();

        // get the last id for each cumparator -> to get the most recent info about him
        $subQuery = Factura::select('cumparator', DB::raw('MAX(id) as maxID'))
            ->where('cumparator','like','%'.$cumparator.'%')
            ->groupBy('cumparator');

        // Join the subquery with the main table and select only the desired columns.
        $data = Factura::
                joinSub($subQuery, 'sub', function ($join) {
                    $join->on('facturi.id', '=', 'sub.maxID');
                })
                ->select('facturi.cumparator', 'facturi.nr_reg_com', 'facturi.cif', 'facturi.judet', 'facturi.sediul')
                ->get();

        return response()->json($data);
    }
}
