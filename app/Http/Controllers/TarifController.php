<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Tarif;

class TarifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume');
        $tarife = Tarif::
            // when($search_nume, function ($query, $search_nume) {
            //     return $query->where('nume', 'like', '%' . $search_nume . '%');
            // })
            // ->latest()
            simplePaginate(25);

        return view('tarife.index', compact('tarife', 'search_nume'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tarife.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tarif = Tarif::create($this->validateRequest($request));

        return redirect('/tarife')->with('status', 'Tariful a fost adăugat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tarif  $tarif
     * @return \Illuminate\Http\Response
     */
    public function show(Tarif $tarif)
    {
        return view('tarife.show', compact('tarif'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tarif  $tarif
     * @return \Illuminate\Http\Response
     */
    public function edit(Tarif $tarif)
    {
        return view('tarife.edit', compact('tarif'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tarif  $tarif
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tarif $tarif)
    {
        $tarif->update($this->validateRequest($request));

        return redirect('/tarife')->with('status', 'Tariful a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tarif  $tarif
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tarif $tarif)
    {
        $tarif->delete();
        return redirect('/tarife')->with('status', 'Tariful a fost șters cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest(Request $request)
    {
        return request()->validate([
            'adult' => 'required',
            'copil' => 'required',
            'adult_tur_retur' => 'required',
            'copil_tur_retur' => 'required',
            'colete_kg' => 'required',
            'de_la_data' => 'required',
            'pana_la_data' => 'required',
        ]);
    }
}
