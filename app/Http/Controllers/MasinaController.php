<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Masina;

class MasinaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume');
        $search_numar = \Request::get('search_numar');
        $masini = Masina::
            when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . $search_nume . '%');
            })
            ->when($search_numar, function ($query, $search_numar) {
                return $query->where('numar', 'like', '%' . $search_numar . '%');
            })
            ->latest()
            ->simplePaginate(25);

        return view('masini.index', compact('masini', 'search_nume', 'search_numar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('masini.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $masina = Masina::create($this->validateRequest($request));

        return redirect('/masini')->with('status', 'Mașina "' . $masina->nume . '" a fost adăugată cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Masina  $masina
     * @return \Illuminate\Http\Response
     */
    public function show(Masina $masina)
    {
        return view('masini.show', compact('masina'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Masina  $masina
     * @return \Illuminate\Http\Response
     */
    public function edit(Masina $masina)
    {
        return view('masini.edit', compact('masina'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Masina  $masina
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Masina $masina)
    {
        $masina->update($this->validateRequest($request));

        return redirect('/masini')->with('status', 'Mașina "' . $masina->nume . '" a fost modificată cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Masina  $masina
     * @return \Illuminate\Http\Response
     */
    public function destroy(Masina $masina)
    {
        $masina->delete();
        return redirect('/masini')->with('status', 'Mașina "' . $masina->nume . '" a fost ștearsă cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest(Request $request)
    {
        return request()->validate([
            'nume' => 'required|max:100',
            'numar_auto' => 'nullable|max:50',
            'itp' => 'nullable',
            'asigurare_rca' => 'nullable',
            'asigurari_persoane_colete' => 'nullable',
            'licenta' => 'nullable',
            'clasificare' => 'nullable',
            'verificare_tahograf' => 'nullable',
            'rovinieta_romania' => 'nullable',
            'rovinieta_ungaria' => 'nullable',
            'rovinieta_slovenia' => 'nullable',
            'revizie' => 'nullable',
            'observatii' => 'nullable',
        ]);
    }
}
