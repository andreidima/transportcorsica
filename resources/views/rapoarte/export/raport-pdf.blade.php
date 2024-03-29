<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Raport</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            /* font-family: Verdana, Tahoma, "DejaVu Sans", sans-serif; */
            font-size: 12px;
        }
        * {
            /* padding: 0;
            text-indent: 0; */
        }
        table{
            border-collapse:collapse;
            /* margin: 0px 0px; */
            /* margin-left: 5px; */
            margin-top: 0px;
            border-style: solid;
            border-width:0px;
            width: 100%;
            word-wrap:break-word;
            /* word-break: break-all; */
            /* table-layout: fixed; */
            page-break-inside:auto;
        }

        th, td {
            padding: 5px 5px;
            border-width:1px;
            border-style: solid;
            table-layout:fixed;
            font-weight: normal;

        }
        tr {
            /* text-align:; */
            /* border-style: solid;
            border-width:1px; */
            page-break-after:auto
        }
        hr {
            display: block;
            margin-top: 0.5em;
            margin-bottom: 0.5em;
            margin-left: auto;
            margin-right: auto;
            border-style: inset;
            border-width: 0.5px;
        }
        /* tr:nth-child(even) {background-color:lightgray;} */
    </style>
</head>

<body>
    @switch($tip_lista)
        @case ("lista_plecare")
            {{-- Rezervari pasageri --}}
            @isset($rezervari->first()->nr_adulti)

            {{-- <div style="
                width:680px;
                min-height:600px;
                padding: 0px;
                margin:0px 0px;
                    -moz-border-radius: 10px;
                    -webkit-border-radius: 10px;
                    border-radius: 10px;"> --}}
                <table>
                    <tr style="background-color:darkcyan; color:white">
                        <td colspan="3" style="border-width:0px; padding:0rem;">
                                <img src="{{ public_path('images/logo.png') }}" width="170px" style="margin-left:5px">
                        </td>
                        <td colspan="4" style="border-width:0px; padding:0rem; font-size:16px; text-align:left">
                            <br>
                            Listă plecare
                            {{ $rezervari->first()->oras_plecare_tara }}
                            <br><br>
                        </td>
                        <td colspan="2" style="border-width:0px; padding:0rem; font-size:16px; text-align:right">
                            {{-- Traseu {{ $rezervari->first()->oras_plecare_traseu }}
                            <br> --}}
                            <br>
                            {{\Carbon\Carbon::parse($rezervari->first()->data_cursa)->isoFormat('DD.MM.YYYY')}}
                            <br><br>
                        </td>
                    </tr>

                    <tr style="background-color:darkcyan; color:white">
                        <th style="width: 20px">Nr crt</th>
                        <th style="">Plecare</th>
                        <th style="width: 100px">Nume si prenume</th>
                        <th style="">Telefon</th>
                        <th style="">Destinație</th>
                        <th style="width: 30px">Nr. pers</th>
                        <th style="width: 40px">Preț</th>
                        <th style="width: 67px">Kg. colete</th>
                        <th style="width: 50px">Bilet</th>
                    </tr>
                @forelse ($rezervari as $rezervare)
                    <tr style="background-color:rgb(209, 253, 251); color:black">
                        <td style="text-align:center; border-bottom:0rem">
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            <b>{{ $rezervare->oras_plecare_nume }}</b>
                        </td>
                        <td>
                            {{ $rezervare->nume ?? $rezervare->pasageri_relation->first()->nume ?? '' }}
                        </td>
                        <td>
                            {{ $rezervare->telefon }}&nbsp;
                            {{-- {!! $rezervare->telefon !!} --}}
                        </td>
                        <td>
                            {{ $rezervare->oras_sosire_nume }}
                        </td>
                        <td style="text-align:center">
                            {{ $rezervare->nr_adulti + $rezervare->nr_copii }}
                        </td>
                        <td style="text-align:center">
                            {!! ($rezervare->plata_efectuata === 1) ? '0 <br> platit online' : $rezervare->pret_total !!}
                        </td>
                        <td>

                        </td>
                        <td>
                            <img src="data:image/png;base64, {{ base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::size(50)->generate('https://rezervari.transportcorsica.ro/chitanta-descarca/' . $rezervare->cheie_unica . '/seteaza_orase')) }} ">
                        </td>
                    </tr>
                    <tr>
                        <td style="border-top:0rem; border-bottom:0rem"></td>
                        <td colspan="8" style="border-left:0rem">
                            {{-- Pasageri: --}}
                    @forelse ($rezervare->pasageri_relation as $pasager)
                        @if ($loop->index === 1)
                            Plus pasageri:
                        @endif
                        @if ($loop->first)
                        @elseif ($loop->last)
                            {{ $pasager->nume }}.
                        @else
                            {{ $pasager->nume }},
                        @endif
                    @empty
                    @endforelse
                            </div>
                        </td>
                    </tr>
                    @if ($rezervare->observatii)
                    <tr>
                        <td style="border-top:0rem; border-bottom:0rem"></td>
                        <td colspan="8">
                            Observații: {{ str_replace('€', 'E', $rezervare->observatii) }}
                        </td>
                    </tr>
                    @endif

                    @php
                        $nr_crt = 0;
                    @endphp
                    @foreach ($rezervare->pasageri_relation as $pasager)
                        @if (in_array($pasager->nume, $clienti_neseriosi))
                            @php
                                $nr_crt++;
                            @endphp
                            @if ($nr_crt === 1)
                    <tr>
                        <td style="border-top:0rem; border-bottom:0rem"></td>
                        <td colspan="8">
                                Clienți neserioși:
                            @endif
                            {{ \App\Models\ClientNeserios::where('nume', $pasager->nume)->first()->nume }} -
                            {{ \App\Models\ClientNeserios::where('nume', $pasager->nume)->first()->observatii }};
                        @endif
                    @endforeach
                        </td>
                    </tr>


                    @isset($rezervare->nr_adulti)
                    @else
                        <tr>
                            <td style="border-top:0rem; border-bottom:0rem"></td>
                            <td colspan="8">
                                Rezervare colete {{ $rezervare->colete_kg ? ':' . $rezervare->colete_kg . 'kg' : '' }}
                                @isset ($rezervare->colete_descriere)
                                    <br>
                                    Descriere colete: {{ $rezervare->colete_descriere }}
                                @endisset
                            </td>
                        </tr>
                    @endisset

                @empty
                @endforelse
                    <tr>
                        <td colspan="5" style="text-align:right">
                            <b>Total</b>
                        </td>
                        <td style="text-align:center">
                            <b>{{ $rezervari->sum('nr_adulti') + $rezervari->sum('nr_copii') }}</b>
                        </td>
                        <td style="text-align:center">
                            <b>{{ $rezervari->where('plata_efectuata', '<>', 1)->sum('pret_total') }}</b>
                        </td>
                        <td>

                        </td>
                        <td>

                        </td>
                    </tr>

            {{-- Rezervari colete --}}
            @else
            {{-- <div style="

                width:680px;
                min-height:600px;
                padding: 0px;
                margin:0px 0px;
                    -moz-border-radius: 10px;
                    -webkit-border-radius: 10px;
                    border-radius: 10px;"> --}}
                <table>
                    <tr style="background-color:darkcyan; color:white">
                        <td colspan="3" style="border-width:0px; padding:0rem;">
                                <img src="{{ public_path('images/logo.png') }}" width="170px" style="margin-left:5px">
                        </td>
                        <td colspan="4" style="border-width:0px; padding:0rem; font-size:16px; text-align:left">
                            <br>
                            Listă plecare
                            {{ $rezervari->first()->oras_plecare_tara }}
                            <br><br>
                        </td>
                        <td colspan="3" style="border-width:0px; padding:0rem; font-size:16px; text-align:right">
                            {{-- Traseu {{ $rezervari->first()->oras_plecare_traseu }}
                            <br> --}}
                            <br>
                            {{\Carbon\Carbon::parse($rezervari->first()->data_cursa)->isoFormat('DD.MM.YYYY')}}
                            <br><br>
                        </td>
                    </tr>

                    <tr style="background-color:darkcyan; color:white">
                        <th style="width: 20px">Nr crt</th>
                        <th style="">Plecare</th>
                        <th style="">Destinație</th>
                        <th style="">Expeditor</th>
                        <th style="">Destinatar</th>
                        <th style="width: 30px">Nr.</th>
                        <th style="width: 30px">Kg.</th>
                        <th style="width: 30px">Volum</th>
                        <th style="width: 40px">Preț</th>
                        <th style="width: 50px">AWB</th>
                    </tr>
                @forelse ($rezervari as $rezervare)
                    <tr style="background-color:rgb(209, 253, 251); color:black">
                        <td style="text-align:center; border-bottom:0rem">
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            <b>{{ $rezervare->oras_plecare_nume }}</b>
                        </td>
                        <td>
                            <b>{{ $rezervare->oras_sosire_nume }}</b>
                        </td>
                        <td>
                            {{ $rezervare->nume }}
                            <br>
                            {{ $rezervare->telefon }}&nbsp;
                        </td>
                        <td>
                            {{ $rezervare->colete_nume_destinatar }}
                            <br>
                            {{ $rezervare->colete_telefon_destinatar }}&nbsp;
                        </td>
                        <td style="text-align:center">
                            {{ $rezervare->colete_numar }}
                        </td>
                        <td style="text-align:center">
                            {{ $rezervare->colete_kg }}
                        </td>
                        <td style="text-align:center">
                            {{ $rezervare->colete_volum }}
                        </td>
                        <td style="text-align:center">
                            {!! ($rezervare->plata_efectuata === 1) ? '0 <br> platit online' : $rezervare->pret_total !!}
                        </td>
                        <td>
                            <img src="data:image/png;base64, {{ base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::size(50)->generate('https://rezervari.transportcorsica.ro/chitanta-descarca/' . $rezervare->cheie_unica . '/seteaza_orase')) }} ">
                        </td>
                    </tr>
                    @if ($rezervare->colete_descriere)
                    <tr>
                        <td style="border-top:0rem; border-bottom:0rem"></td>
                        <td colspan="9">
                            Descriere: {{ str_replace('€', 'E', $rezervare->colete_descriere) }}
                        </td>
                    </tr>
                    @endif
                    @if ($rezervare->observatii)
                    <tr>
                        <td style="border-top:0rem; border-bottom:0rem"></td>
                        <td colspan="9">
                            Observații: {{ str_replace('€', 'E', $rezervare->observatii) }}
                        </td>
                    </tr>
                    @endif

                @if (in_array($rezervare->nume, $clienti_neseriosi))
                    <tr>
                        <td style="border-top:0rem; border-bottom:0rem"></td>
                        <td colspan="9">
                                Client neserios:
                            {{ \App\Models\ClientNeserios::where('nume', $rezervare->nume)->first()->nume }} -
                            {{ \App\Models\ClientNeserios::where('nume', $rezervare->nume)->first()->observatii }};
                        </td>
                    </tr>
                @endif
                @empty
                @endforelse
                    <tr>
                        <td colspan="5" style="text-align:right">
                            <b>Total</b>
                        </td>
                        <td style="text-align:center">
                            <b>{{ $rezervari->sum('colete_numar') }}</b>
                        </td>
                        <td style="text-align:center">
                            <b>{{ $rezervari->sum('colete_kg') }}</b>
                        </td>
                        <td style="text-align:center">
                            <b>{{ $rezervari->sum('colete_volum') }}</b>
                        </td>
                        <td style="text-align:center">
                            <b>{{ $rezervari->where('plata_efectuata', '<>', 1)->sum('pret_total') }}</b>
                        </td>
                        <td>

                        </td>
                    </tr>


                </table>
            {{-- </div> --}}
            @endisset


        @break
        @case ("lista_sosire")
            {{-- Rezervari pasageri --}}
            @isset($rezervari->first()->nr_adulti)


            {{-- <div style="border:dashed #999;
                width:690px;
                min-height:600px;
                padding: 15px 10px 15px 10px;
                margin:0px 0px;
                    -moz-border-radius: 10px;
                    -webkit-border-radius: 10px;
                    border-radius: 10px;"> --}}
                <table style="">
                    <tr style="">
                        <td colspan="3" style="border-width:0px; padding:0rem; width:30%">
                                <img src="{{ public_path('images/logo.png') }}" width="150px">
                        </td>
                        <td colspan="4" style="border-width:0px; padding:0rem; width:40%; font-size:16px; text-align:center">
                            Listă sosire
                            {{ $rezervari->first()->oras_sosire_tara ?? '' }}
                        </td>
                        <td colspan="2" style="border-width:0px; padding:0rem; width:30%; font-size:16px; text-align:right">
                            {{-- Traseu {{ $rezervari->first()->oras_plecare_traseu }}
                            <br> --}}
                            {{isset($rezervari->first()->data_cursa) ? \Carbon\Carbon::parse($rezervari->first()->data_cursa)->isoFormat('DD.MM.YYYY') : ''}}

                        </td>
                    </tr>
                    <tr style="background-color:#302700; color:#ffffff">
                        <th style="width: 20px">Nr crt</th>
                        <th>Destinație</th>
                        <th style="width: 100px">Nume si prenume</th>
                        <th>Telefon</th>
                        <th>Plecare</th>
                        <th style="width: 30px">Nr. pers</th>
                        <th style="width: 40px">Preț</th>
                        <th style="width: 67px">Kg. colete</th>
                        <th style="width: 50px">Bilet</th>
                    </tr>
                @forelse ($rezervari as $rezervare)
                    <tr style="background-color:#e7d790; color:black">
                        <td style="text-align:center; border-bottom:0rem">
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            <b>{{ $rezervare->oras_sosire_nume }}</b>
                        </td>
                        <td>
                            {{ $rezervare->nume ?? $rezervare->pasageri_relation->first()->nume ?? '' }}
                        </td>
                        <td>
                            {{ $rezervare->telefon }}
                        </td>
                        <td>
                            {{ $rezervare->oras_plecare_nume }}
                        </td>
                        <td style="text-align:center">
                            {{ $rezervare->nr_adulti + $rezervare->nr_copii }}
                        </td>
                        <td style="text-align:center">
                            {!! ($rezervare->plata_efectuata === 1) ? '0 <br> platit online' : $rezervare->pret_total !!}
                        </td>
                        <td>

                        </td>
                        <td>
                            <img src="data:image/png;base64, {{ base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::size(50)->generate('https://rezervari.transportcorsica.ro/chitanta-descarca/' . $rezervare->cheie_unica . '/seteaza_orase')) }} ">
                        </td>
                    </tr>
                    <tr>
                        <td style="border-top:0rem; border-bottom:0rem"></td>
                        <td colspan="8" style="border-left:0rem">
                            {{-- Pasageri: --}}
                    @forelse ($rezervare->pasageri_relation as $pasager)
                        @if ($loop->index === 1)
                            Plus pasageri:
                        @endif
                        @if ($loop->first)
                        @elseif ($loop->last)
                            {{ $pasager->nume }}.
                        @else
                            {{ $pasager->nume }},
                        @endif
                    @empty
                    @endforelse
                            </div>
                        </td>
                    </tr>
                    @if ($rezervare->observatii)
                    <tr>
                        <td style="border-top:0rem; border-bottom:0rem"></td>
                        <td colspan="8">
                            Observații: {{ $rezervare->observatii }}
                        </td>
                    </tr>
                    @endif

                    @isset($rezervare->nr_adulti)
                    @else
                        <tr>
                            <td style="border-top:0rem; border-bottom:0rem"></td>
                            <td colspan="8">
                                Rezervare Colete {{ $rezervare->colete_kg ? ':' . $rezervare->colete_kg . 'kg' : '' }}
                                @isset ($rezervare->colete_descriere)
                                    <br>
                                    Descriere colete: {{ $rezervare->colete_descriere }}
                                @endisset
                            </td>
                        </tr>
                    @endisset

                @empty
                @endforelse
                    <tr>
                        <td colspan="5" style="text-align:right">
                            <b>Total</b>
                        </td>
                        <td style="text-align:center">
                            <b>{{ $rezervari->sum('nr_adulti') + $rezervari->sum('nr_copii') }}</b>
                        </td>
                        <td style="text-align:center">
                            <b>{{ $rezervari->where('plata_efectuata', '<>', 1)->sum('pret_total') }}</b>
                        </td>
                        <td>

                        </td>
                        <td>

                        </td>
                    </tr>

                </table>
            {{-- </div> --}}

            {{-- Rezervari colete --}}
            @else
            {{-- <div style="

                width:680px;
                min-height:600px;
                padding: 0px;
                margin:0px 0px;
                    -moz-border-radius: 10px;
                    -webkit-border-radius: 10px;
                    border-radius: 10px;"> --}}
                <table>
                    <tr style="background-color:darkcyan; color:white">
                        <td colspan="3" style="border-width:0px; padding:0rem;">
                                <img src="{{ public_path('images/logo.png') }}" width="170px" style="margin-left:5px">
                        </td>
                        <td colspan="4" style="border-width:0px; padding:0rem; font-size:16px; text-align:left">
                            <br>
                            Listă plecare
                            {{ $rezervari->first()->oras_plecare_tara }}
                            <br><br>
                        </td>
                        <td colspan="3" style="border-width:0px; padding:0rem; font-size:16px; text-align:right">
                            {{-- Traseu {{ $rezervari->first()->oras_plecare_traseu }}
                            <br> --}}
                            <br>
                            {{\Carbon\Carbon::parse($rezervari->first()->data_cursa)->isoFormat('DD.MM.YYYY')}}
                            <br><br>
                        </td>
                    </tr>

                    <tr style="background-color:darkcyan; color:white">
                        <th style="width: 20px">Nr crt</th>
                        <th style="">Plecare</th>
                        <th style="">Destinație</th>
                        <th style="">Expeditor</th>
                        <th style="">Destinatar</th>
                        <th style="width: 30px">Nr.</th>
                        <th style="width: 30px">Kg.</th>
                        <th style="width: 30px">Volum</th>
                        <th style="width: 40px">Preț</th>
                        <th style="width: 50px">AWB</th>
                    </tr>
                @forelse ($rezervari as $rezervare)
                    <tr style="background-color:rgb(209, 253, 251); color:black">
                        <td style="text-align:center; border-bottom:0rem">
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            <b>{{ $rezervare->oras_plecare_nume }}</b>
                        </td>
                        <td>
                            <b>{{ $rezervare->oras_sosire_nume }}</b>
                        </td>
                        <td>
                            {{ $rezervare->nume }}
                            <br>
                            {{ $rezervare->telefon }}&nbsp;
                        </td>
                        <td>
                            {{ $rezervare->colete_nume_destinatar }}
                            <br>
                            {{ $rezervare->colete_telefon_destinatar }}&nbsp;
                        </td>
                        <td style="text-align:center">
                            {{ $rezervare->colete_numar }}
                        </td>
                        <td style="text-align:center">
                            {{ $rezervare->colete_kg }}
                        </td>
                        <td style="text-align:center">
                            {{ $rezervare->colete_volum }}
                        </td>
                        <td style="text-align:center">
                            {!! ($rezervare->plata_efectuata === 1) ? '0 <br> platit online' : $rezervare->pret_total !!}
                        </td>
                        <td>
                            <img src="data:image/png;base64, {{ base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::size(50)->generate('https://rezervari.transportcorsica.ro/chitanta-descarca/' . $rezervare->cheie_unica . '/seteaza_orase')) }} ">
                        </td>
                    </tr>
                    @if ($rezervare->colete_descriere)
                    <tr>
                        <td style="border-top:0rem; border-bottom:0rem"></td>
                        <td colspan="9">
                            Descriere: {{ str_replace('€', 'E', $rezervare->colete_descriere) }}
                        </td>
                    </tr>
                    @endif
                    @if ($rezervare->observatii)
                    <tr>
                        <td style="border-top:0rem; border-bottom:0rem"></td>
                        <td colspan="9">
                            Observații: {{ str_replace('€', 'E', $rezervare->observatii) }}
                        </td>
                    </tr>
                    @endif

                @if (in_array($rezervare->nume, $clienti_neseriosi))
                    <tr>
                        <td style="border-top:0rem; border-bottom:0rem"></td>
                        <td colspan="9">
                                Client neserios:
                            {{ \App\Models\ClientNeserios::where('nume', $rezervare->nume)->first()->nume }} -
                            {{ \App\Models\ClientNeserios::where('nume', $rezervare->nume)->first()->observatii }};
                        </td>
                    </tr>
                @endif
                @empty
                @endforelse
                    <tr>
                        <td colspan="5" style="text-align:right">
                            <b>Total</b>
                        </td>
                        <td style="text-align:center">
                            <b>{{ $rezervari->sum('colete_numar') }}</b>
                        </td>
                        <td style="text-align:center">
                            <b>{{ $rezervari->sum('colete_kg') }}</b>
                        </td>
                        <td style="text-align:center">
                            <b>{{ $rezervari->sum('colete_volum') }}</b>
                        </td>
                        <td style="text-align:center">
                            <b>{{ $rezervari->where('plata_efectuata', '<>', 1)->sum('pret_total') }}</b>
                        </td>
                        <td>

                        </td>
                    </tr>


                </table>
            {{-- </div> --}}
            @endisset
        @break
    @endswitch


</body>

</html>
