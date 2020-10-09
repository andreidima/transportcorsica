<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Rezervare;

class RaportController extends Controller
{
    public function rapoarte(){
        // $search_data = \Request::get('search_data');
        $search_data = \Request::get('search_data') ? \Request::get('search_data') : \Carbon\Carbon::today();
        // $search_data ?
        // dd($search_data);

        $rezervari = Rezervare::
            join('orase as orase_plecare', 'rezervari.oras_plecare', '=', 'orase_plecare.id')
            ->join('orase as orase_sosire', 'rezervari.oras_sosire', '=', 'orase_sosire.id')
            // with('oras_plecare_nume', 'oras_sosire_nume')
            ->select(
                'rezervari.*', 
                'orase_plecare.tara as oras_plecare_tara',
                'orase_plecare.oras as oras_plecare_nume',
                'orase_plecare.traseu as oras_plecare_traseu',
                'orase_plecare.ordine as oras_plecare_ordine',
                'orase_sosire.tara as oras_sosire_tara',
                'orase_sosire.oras as oras_sosire_nume',
                'orase_sosire.traseu as oras_sosire_traseu',
                'orase_sosire.ordine as oras_sosire_ordine',
            )
            // ->when($search_data, function ($query, $search_data) {
            //     return $query->whereDate('data_cursa', '=', $search_data);
            // })
            // when($search_data, function ($query, $search_data) {
            //     return $query->whereDate('data_cursa', '=', $search_data);
            // })
            ->whereDate('data_cursa', '=', $search_data)
            // ->latest()
            // ->orderBy('traseu_raport')
            // ->orderBy('oras_plecare_traseu')
            // ->orderBy('oras_plecare_ordine')
            ->get();

        // dd($rezervari);


        return view('rapoarte.raport', compact('rezervari', 'search_data'));
    }


    public function mutaRezervari(Request $request){
        // $request->validate(
        //     [
        //         'traseu_vechi' => ['required', 'numeric'],
        //         'traseu_nou' => ['required', 'numeric'],
        //         'data_traseu' => ['required']
        //     ],
        // );

        // $rezervari = Rezervare::
        //     join('orase as orase_plecare', 'rezervari.oras_plecare', '=', 'orase_plecare.id')
        //     ->join('orase as orase_sosire', 'rezervari.oras_sosire', '=', 'orase_sosire.id')
        //     ->select(
        //         'rezervari.*', 
        //         'orase_plecare.traseu as oras_plecare_traseu'
        //     )
            // ->whereDate('data_cursa', '=', $request->data_traseu);
            // ->where('orase_plecare.traseu', $request->traseu_vechi)
            // ->update(['traseu_raport' => $request->traseu_nou]);

        // return redirect()->route('rapoarte', ['search_data' => $request->data_traseu]);
        $request->validate(
            [
                'lista_noua' => ['required', 'numeric']
            ],
        );

        if($request->tip_lista === "lista_plecare"){
            $rezervari = Rezervare::whereIn('id', $request->rezervari)
                ->update(['lista_plecare' => $request->lista_noua]);
        } elseif ($request->tip_lista === "lista_sosire"){
            $rezervari = Rezervare::whereIn('id', $request->rezervari)
                ->update(['lista_sosire' => $request->lista_noua]);
        }
        
            // dd($rezervari);

        return redirect()->route('rapoarte', ['search_data' => $request->data_traseu]);
    }

    public function extrageRezervari(Request $request){
        // cautarea rezervarilor dupa array-ul de id-uri primit din request
        $rezervari = Rezervare::
            join('orase as orase_plecare', 'rezervari.oras_plecare', '=', 'orase_plecare.id')
            ->join('orase as orase_sosire', 'rezervari.oras_sosire', '=', 'orase_sosire.id')
            ->with('pasageri_relation')
            ->select(
                'rezervari.*', 
                'orase_plecare.tara as oras_plecare_tara',
                'orase_plecare.oras as oras_plecare_nume',
                'orase_plecare.traseu as oras_plecare_traseu',
                'orase_sosire.tara as oras_sosire_tara',
                'orase_sosire.oras as oras_sosire_nume',
                'orase_sosire.traseu as oras_sosire_traseu'
            )
            ->find($request->rezervari);
        
        // asezare rezervarilor in aceeasi ordine ca id-urile primite din request
        $ids = $request->rezervari;
        $rezervari = $rezervari->sortBy(function($model) use ($ids) {
            return array_search($model->getKey(), $ids);
        });

        $tip_lista = $request->tip_lista;

        if ($request->view_type === 'raport-html') {
            return view('rapoarte.export.raport-pdf', compact('rezervari', 'tip_lista'));
        } elseif ($request->view_type === 'raport-pdf') {
            $pdf = \PDF::loadView('rapoarte.export.raport-pdf', compact('rezervari', 'tip_lista'))
                ->setPaper('a4');
                    // return $pdf->stream('Rezervare ' . $rezervari->nume . '.pdf');
                    return $pdf->download('Raport ' . 
                        ($tip_lista === "lista_plecare" ? 'lista plecare ' : 'lista sosire ') . 
                        \Carbon\Carbon::parse($rezervari->first()->data_cursa)->isoFormat('DD.MM.YYYY') . 
                        '.pdf');
        }
    
    }
}
