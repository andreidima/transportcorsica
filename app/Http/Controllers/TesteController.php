<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TesteController extends Controller
{
    public function testeModale()
    {
        return view('teste.teste-modale');
    }

    public function testeModaleApasaButon()
    {
        return back()->with('status', 'Butonul a fost apasat cu succes!');
    }
}
