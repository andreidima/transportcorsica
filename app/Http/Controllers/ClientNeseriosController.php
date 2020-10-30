<?php

namespace App\Http\Controllers;

use App\Models\ClientNeserios;
use Illuminate\Http\Request;

class ClientNeseriosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume');
        $search_telefon = \Request::get('search_telefon');
        $clienti_neseriosi = ClientNeserios::
            when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . $search_nume . '%');
            })
            ->when($search_telefon, function ($query, $search_telefon) {
                return $query->where('telefon', 'like', '%' . $search_telefon . '%');
            })
            ->latest()
            ->simplePaginate(25);
            
        return view('clienti-neseriosi.index', compact('clienti_neseriosi', 'search_nume', 'search_telefon'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clienti-neseriosi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $client = ServiceClient::create(array_merge($this->validateRequest($request),['tip' => 'service']));
        $client = ClientNeserios::create($this->validateRequest($request));

        return redirect('/clienti-neseriosi')->with('status', 'Clientul "' . $client->nume . '" a fost adăugat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClientNeserios  $clientNeserios
     * @return \Illuminate\Http\Response
     */
    public function show(ClientNeserios $clientNeserios)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClientNeserios  $clientNeserios
     * @return \Illuminate\Http\Response
     */
    public function edit(ClientNeserios $client_neserios)
    {
        return view('clienti-neseriosi.edit', compact('client_neserios'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClientNeserios  $clientNeserios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClientNeserios $client_neserios)
    {
        // $this->validateRequest($request, $clienti);
        $client_neserios->update($this->validateRequest($request));

        return redirect('/clienti-neseriosi')->with('status', 'Clientul "' . $client_neserios->nume . '" a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClientNeserios  $clientNeserios
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClientNeserios $client_neserios)
    {
        $client_neserios->delete();
        return redirect('/clienti-neseriosi')->with('status', 'Clientul "' . $client_neserios->nume . '" a fost șters cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest(Request $request)
    {
        return request()->validate([
            'nume' => ['nullable', 'max:250'],
            'telefon' => ['nullable', 'max:250'],
            'oras_plecare' => ['nullable', 'max:30'],
            'oras_sosire' => ['nullable', 'max:30'],
            'data_cursa' => ['nullable'],
            'observatii' => ['nullable', 'max:2000'],
        ]);
    }
}
