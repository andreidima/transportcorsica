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
        return back()->with('status', 'Butonul 1 a fost apasat cu succes!');
    }

    public function testeModaleApasaButon2()
    {
        return back()->with('status', 'Butonul 2 a fost apasat cu succes!');
    }
}
