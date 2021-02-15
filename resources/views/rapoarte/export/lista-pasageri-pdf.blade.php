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
                            {{ $rezervare->bilet_serie }}
                        </td>
                        <td style="text-align:center">
                            {{ $rezervare->bilet_numar }}
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
    @endswitch


</body>

</html>
    