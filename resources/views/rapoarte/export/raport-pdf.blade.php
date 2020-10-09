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
                <table style="">
                    <tr style="">
                        <td style="border-width:0px; padding:0rem; width:30%">
                                <img src="{{ asset('images/logo.png') }}" width="150px">
                        </td>
                        <td style="border-width:0px; padding:0rem; width:40%; font-size:16px; text-align:center">
                            Listă plecare
                            {{ $rezervari->first()->oras_plecare_tara }}
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
                        <th>Nr crt</th>
                        <th>Plecare</th>
                        <th>Nume si prenume</th>
                        <th>Telefon</th>
                        <th>Destinație</th>
                        <th>Preț</th>
                        <th>Nr. pers</th>
                    </tr>
                @forelse ($rezervari as $rezervare)
                    <tr style="background-color:#e7d790; color:black">
                        <td style="text-align:center; border-bottom:0rem">
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            <b>{{ $rezervare->oras_plecare_nume }}</b>
                        </td>
                        <td>
                            {{ $rezervare->nume }}
                        </td>
                        <td>
                            {{ $rezervare->telefon }}
                        </td>
                        <td>
                            {{ $rezervare->oras_sosire_nume }}
                        </td>
                        <td style="text-align:center">
                            {{ $rezervare->pret_total }}
                        </td>
                        <td style="text-align:center">
                            {{ $rezervare->nr_adulti }}
                        </td>
                    </tr>
                    <tr>
                        <td style="border-top:0rem; border-bottom:0rem"></td>
                        <td colspan="6" style="border-left:0rem">
                            Pasageri:
                    @forelse ($rezervare->pasageri_relation as $pasager)
                        {{ $pasager->nume }},
                    @empty
                    @endforelse
                            </div>
                        </td>
                    </tr>
                    @if ($rezervare->observatii)
                    <tr>
                        <td style="border-top:0rem; border-bottom:0rem"></td>
                        <td colspan="6">
                            Observații: {{ $rezervare->observatii }}
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
                            <b>{{ $rezervari->sum('pret_total') }}</b>
                        </td>
                        <td style="text-align:center">
                            <b>{{ $rezervari->sum('nr_adulti') }}</b>
                        </td>
                    </tr>

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
                    <tr style="background-color:#e7d790;">
                        <th>Nr. crt.</th>
                        <th>Plecare</th>
                        <th>Nume si prenume</th>
                        <th>Telefon</th>
                        <th>Destinație</th>
                        <th>Preț</th>
                        <th>Nr. pers</th>
                    </tr>
                @forelse ($rezervari as $rezervare)
                    <tr>
                        <td style="text-align:center">
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            {{ $rezervare->oras_plecare_nume }}
                        </td>
                        <td>
                            {{ $rezervare->nume }}
                        </td>
                        <td>
                            {{ $rezervare->telefon }}
                        </td>
                        <td>
                            {{ $rezervare->oras_sosire_nume }}
                        </td>
                        <td style="text-align:center">
                            {{ $rezervare->pret_total }}
                        </td>
                        <td style="text-align:center">
                            {{ $rezervare->nr_adulti }}
                        </td>
                    </tr>
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
                            <b>{{ $rezervari->sum('nr_adulti') }}</b>
                        </td>
                    </tr>

                </table>
            </div>
        @break
    @endswitch


</body>

</html>
    