<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Raport</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
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
            <div style="border:dashed #999;
                width:690px; 
                min-height:600px;            
                padding: 15px 10px 15px 10px;
                margin:0px 0px;
                    -moz-border-radius: 10px;
                    -webkit-border-radius: 10px;
                    border-radius: 10px;">
                <table style="background-color:darkcyan; color:white">
                    <tr style="background-color:darkcyan; color:white">
                        <td style="border-width:0px; padding:0rem; width:30%">
                                <img src="{{ asset('images/logo.png') }}" width="270px">
                        </td>
                        <td style="border-width:0px; padding:0rem; width:40%; font-size:11px; text-align:left">
                            MRW88 MAXARMONY S.R.L., Ceardac - Vrancea, România
                            <br>
                            CIF: RO 35059906, ORC J 39/570/2015
                            <br>
                            Cont EUR: RO83BTRLEURCRT0319122801, BANCA TRANSILVANIA
                            <br>
                            Cont LEI: RO36BTRLRONCRT0319122801, BANCA TRANSILVANIA
                            <br>
                            Tel. mobil +40 761 329 420; +40 760 904 748
                        </td>
                    </tr>
                </table>

                <h3 style="text-align:center">
                    LISTĂ PASAGERI - SERVICIU REGULAT
                </h3>

                <br><br>

                <table>
                    <tr>
                        <td style="border-width: 0px">
                            RUTA: ____________________________________________________
                            <br>
                            <br>
                            <br>
                            NUME ȘI PRENUME CONDUCĂTORI AUTO (DRIVERS)
                            <br><br>
                            1. ___________________________________________________
                            <br><br>
                            2. ___________________________________________________
                            <br><br>
                            3. ___________________________________________________
                            <br><br>
                            4. ___________________________________________________
                            <br><br>

                        </td>
                        <td style="border-width: 0px; text-align:right; vertical-align:top">
                            AUTO NR: _______________________
                            <br>
                            <br>
                            DATA: 
                            <b>
                                {{\Carbon\Carbon::parse($rezervari->first()->data_cursa)->isoFormat('DD.MM.YYYY')}}
                            </b>
                            <br>
                            L.S., SEMNĂTURA
                        </td>



                <table style="">
                    <tr style="background-color:darkcyan; color:white">
                        <th style="width: 25px">NR. CRT.</th>
                        <th style="width: 300px; text-align:center">
                            NUME ȘI PRENUME
                            <br>
                            NAME AND SURNAME
                        </th>
                        <th style="width: 70px; text-align:center">
                            SERIE BILET
                            <br>
                            SERIES TIKETS
                        </th>
                        <th style="width: 100px; text-align:center">
                            NUMĂR BILET
                            <br>
                            NUMBER TIKETS
                        </th>

                    </tr>
                @php
                    $nr_crt = 1;
                @endphp
                @foreach ($rezervari as $rezervare)
                    @foreach ($rezervare->pasageri_relation as $pasager)
                    <tr>
                        <td style="text-align:center">
                            {{ $nr_crt++ }}
                        </td>
                        <td colspan="">
                            {{ $pasager->nume }}
                        </td>
                        <td style="text-align:center">
                            MRW
                        </td>
                        <td style="text-align:center">
                            {{ $rezervare->id }}
                        </td>
                    </tr>
                    @endforeach
                @endforeach

                </table>
            </div>
        @break
        @case ("lista_sosire")
            <div style="border:dashed #999;
                width:690px; 
                min-height:600px;            
                padding: 15px 10px 15px 10px;
                margin:0px 0px;
                    -moz-border-radius: 10px;
                    -webkit-border-radius: 10px;
                    border-radius: 10px;">
                <table style="">
                    <tr style="">
                        <td style="border-width:0px; padding:0rem; width:30%">
                                <img src="{{ asset('images/logo.png') }}" width="150px">
                        </td>
                        <td style="border-width:0px; padding:0rem; width:40%; font-size:16px; text-align:center">
                            Listă sosire
                            {{ $rezervari->first()->oras_sosire_tara }}
                        </td>
                        <td style="border-width:0px; padding:0rem; width:30%; font-size:16px; text-align:right">
                            {{-- Traseu {{ $rezervari->first()->oras_plecare_traseu }}
                            <br> --}}
                            {{\Carbon\Carbon::parse($rezervari->first()->data_cursa)->isoFormat('DD.MM.YYYY')}}

                        </td>
                    </tr>
                </table>

                <br><br><br>


                <table style="">
                    <tr style="background-color:#302700; color:#ffffff">
                        <th style="width: 20px">Nr crt</th>
                        <th>Destinație</th>
                        <th>Nume si prenume</th>
                        <th>Telefon</th>
                        <th>Plecare</th>
                        <th>Preț</th>
                        <th>Nr. pers</th>
                        <th>Kg. bagaj</th>
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
                            {{ $rezervare->pret_total }}
                        </td>
                        <td style="text-align:center">
                            {{ $rezervare->nr_adulti + $rezervare->nr_copii }}
                        </td>
                        <td>
                            
                        </td>
                        <td>
                            <img src="data:image/png;base64, {{ base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::size(50)->generate('https://rezervari.transportcorsica.ro/chitanta-descarca/' . $rezervare->cheie_unica . '/export-pdf')) }} ">
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
                                Rezervare Bagaj {{ $rezervare->bagaje_kg ? ':' . $rezervare->bagaje_kg . 'kg' : '' }}
                                @isset ($rezervare->bagaje_descriere)
                                    <br>
                                    Descriere bagaj: {{ $rezervare->bagaje_descriere }}
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
                            <b>{{ $rezervari->sum('pret_total') }}</b>
                        </td>
                        <td style="text-align:center">
                            <b>{{ $rezervari->sum('nr_adulti') + $rezervari->sum('nr_copii') }}</b>
                        </td>
                        <td>

                        </td>
                        <td>

                        </td>
                    </tr>

                </table>
            </div>
        @break
    @endswitch


</body>

</html>
    