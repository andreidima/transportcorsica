<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Rezervare;

class RaportController extends Controller
{
    public function rapoarte(){
        
        $search_data = \Request::get('search_data') ? \Request::get('search_data') : \Carbon\Carbon::today();
        // $search_data ?
        // dd($search_data);

        if ($search_data){
            $rezervari = Rezervare::
                // when($search_data, function ($query, $search_data) {
                //     return $query->whereDate('data_cursa', '=', $search_data);
                // })
                whereDate('data_cursa', '=', $search_data)
                ->latest()
                // ->groupBy('raport_traseu_initial')
                ->get();
        }


        return view('rapoarte.raport', compact('rezervari', 'search_data'));
    }
}
