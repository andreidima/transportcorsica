<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\RezervareIstoric;
use App\Models\PasagerIstoric;
use DB;
use Illuminate\Database\Eloquent\Builder;

class RezervareIstoricController extends Controller
{
    public function rezervariSterseSauPasageriStersi()
    {
        $search_nume = \Request::get('search_nume');
        $search_data = \Request::get('search_data');

        $rezervariSterse = RezervareIstoric::with('oras_plecare_nume', 'oras_sosire_nume', 'pasageri_relation', 'user')
            ->when($search_nume, function (Builder $query, $search_nume) {
                if (strlen($search_nume) >= 3){
                    $pasageri = PasagerIstoric::where('nume', 'like', '%' . $search_nume . '%')->pluck('id')->all();
                    $rezervari = DB::table('pasageri_rezervari_istoric')
                        ->whereIn('pasager_id', $pasageri)
                        ->where('operatie', 'Stergere')
                        ->pluck('rezervare_id')
                        ->all();
                    $query->whereIn('id', $rezervari); // rezervarile cu pasageri
                        // ->orwhere('nume', 'like', '%' . $search_nume . '%'); // rezervarile de colete, au fost comentate pentru ca nu reieseau corect rezultatele rezervarilor cand se cauta dupa nume, pentru ca era cu orwhere
                } else {
                    return $query->where('id', 0); // nu va returna nici un rezultat
                }
            })
            ->when($search_data, function ($query, $search_data) {
                return $query->whereDate('data_cursa', '=', $search_data);
            })
            ->where('operatie', 'Stergere')
            ->orderBy('data_operatie', 'desc')
            ->simplePaginate(25);

        return view('rezervariIstoric.rezervariSterseSauPasageriStersi', compact('rezervariSterse', 'search_nume', 'search_data'));
    }
}
