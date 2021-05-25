<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Sofer;

class SoferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume');
        $soferi = Sofer::
            when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . $search_nume . '%');
            })
            ->latest()
            ->simplePaginate(25);

        return view('soferi.index', compact('soferi', 'search_nume'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('soferi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sofer = Sofer::create($this->validateRequest($request));

        return redirect('/soferi')->with('status', 'Șoferul "' . $sofer->nume . '" a fost adăugat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sofer  $sofer
     * @return \Illuminate\Http\Response
     */
    public function show(Sofer $sofer)
    {
        return view('soferi.show', compact('sofer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sofer  $sofer
     * @return \Illuminate\Http\Response
     */
    public function edit(Sofer $sofer)
    {
        return view('soferi.edit', compact('sofer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sofer  $sofer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sofer $sofer)
    {
        $sofer->update($this->validateRequest($request));

        return redirect('/soferi')->with('status', 'Șoferul "' . $sofer->nume . '" a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sofer  $sofer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sofer $sofer)
    {
        $sofer->delete();
        return redirect('/soferi')->with('status', 'Șoferul "' . $sofer->nume . '" a fost șters cu succes!');
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
            'analize_medicale' => 'nullable',
            'permis' => 'nullable',
            'buletin' => 'nullable',
            'atestat' => 'nullable',
            'card_tahograf' => 'nullable',
            'observatii' => 'nullable',
        ]);
    }
}
