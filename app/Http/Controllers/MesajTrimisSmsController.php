<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MesajTrimisSms;

class MesajTrimisSmsController extends Controller
{
    public function index()
    {
        $mesaje_sms = MesajTrimisSms::with('rezervare', 'rezervare.pasageri_relation')
            ->latest()
            ->simplePaginate(25);

        return view('mesaje-trimise-sms.index', compact('mesaje_sms'));
    }
}
