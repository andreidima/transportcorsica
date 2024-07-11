<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;

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
        $data = Factura::select('cumparator', 'nr_reg_com', 'cif', 'judet', 'sediul')->groupBy('cumparator')->where('cumparator','like','%'.$cumparator.'%')->get();

        return response()->json($data);
    }
}
