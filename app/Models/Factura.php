<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $table = 'facturi';
    protected $guarded = [];

    public function path()
    {
        return "/facturi/{$this->id}";
    }

    public function rezervare()
    {
        return $this->belongsTo('App\Models\Rezervare', 'rezervare_id');
    }

    // public function descriere()
    // {
    //     if ($factura->rezervare->retur)
    //                           Bilete de călătorie:
    //                                 <ul style="margin: 0px">
    //                                     <li>
    //                                         {{ $factura->rezervare->bilet_serie ?? '' }} {{ $factura->rezervare->bilet_numar ?? '' }} | Dată transport: {{ \Carbon\Carbon::parse($factura->rezervare->data_cursa)->isoFormat('DD.MM.YYYY') }};
    //                                     </li>
    //                                     <li>
    //                                         @php
    //                                             $rezervare_retur = App\Models\Rezervare::find($factura->rezervare->retur);
    //                                         @endphp
    //                                         {{ $rezervare_retur->bilet_serie ?? '' }} {{ $rezervare_retur->bilet_numar ?? '' }} | Dată transport: {{ \Carbon\Carbon::parse($rezervare_retur->data_cursa)->isoFormat('DD.MM.YYYY') }}. <br>
    //                                     </li>
    //                                 </ul>
    //                             @else
    //                                 Bilet de călătorie: {{ $factura->rezervare->bilet_serie ?? '' }} {{ $factura->rezervare->bilet_numar ?? '' }} | Dată transport: {{ \Carbon\Carbon::parse($factura->rezervare->data_cursa ?? '')->isoFormat('DD.MM.YYYY') }}. <br>
    //                             @endisset
    //                             <br>
    //                             Pasageri:
    //                                 @isset($factura->rezervare->nr_adulti)
    //                                     @foreach ($factura->rezervare->pasageri_relation as $pasager)
    //                                         @if(!$loop->last)
    //                                             {{ $pasager->nume }},
    //                                         @else
    //                                             {{ $pasager->nume }}.
    //                                         @endif
    //                                     @endforeach
    //                                 @endisset
    //                             <br><br>
    //                             Preț în EURO: {{ round($factura->valoare_euro) }}&euro;
    //                             <br><br>
    //                             Curs valutar BNR la data rezervării biletului de călătorie: {{ \Carbon\Carbon::parse($factura->rezervare->created_at)->isoFormat('DD.MM.YYYY') }}: <br>
    //                             1 EURO = {{ $factura->curs_bnr_euro }}
    // }
}
