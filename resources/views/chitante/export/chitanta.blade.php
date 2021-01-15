<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Bilet</title>
    <style>
        html { 
            margin: 5px 5px 0px 5px;
        }

        body { 
            font-family: DejaVu Sans, sans-serif;
            /* font-family: Arial, Helvetica, sans-serif; */
            font-size: 14px;
            margin: 0px;
        }

        * {
            /* padding: 0; */
            text-indent: 0;
        }

        table{
            border-collapse:collapse;
            margin: 0px;
            padding: 0px;
            margin-top: 0px;
            border-style: solid;
            border-width: 0px;
            width: 100%;
            word-wrap:break-word;
        }
        
        th, td {
            padding: 1px 1px;
            border-width: 0px;
            border-style: solid;
            
        }
        tr {
            border-style: solid;
            border-width: 0px;
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
    </style>
</head>

<body>
    {{-- <div style="width:730px; height: 1030px; border-style: dashed ; border-width:2px; border-radius: 15px;">      --}}
    <div style="
        width:400px;
        margin:0px 0px;
            -moz-border-radius: 3px;
            -webkit-border-radius: 3px;
            border-radius: 3px;
        text-align:center
        ">               
            <p style="text-align:left; margin:0px;">
                <b>MRW88 MAXARMONY S.R.L.</b> <br>
                ORC: J39/570/29.09.2015 | CIF: RO35059906 <br>
                Sediul: Str. Șoseaua Națională nr. 22, Et:1, Sat Ceardac, Golești, Vrancea <br>
                Banca: Transilvania <br>
                Cod IBAN EURO: RO83BTRLEURCRT0319122801 <br>
                Cod IBAN LEI: RO36BTRLRONCRT0319122801 <br>
            </p>
   
            <br>

            <h2 style="margin:5px">BILET DE CĂLĂTORIE</h2>
            
            <h2 style="margin:5px">Seria și număr: {{ $rezervare->bilet_serie }} {{ $rezervare->bilet_numar }} </h2>  
               
            <br><br>          
                            
            <table style="margin-bottom:0px">
                <tr style="text-align:center; font-weight:bold;">
                    <td colspan="3" style="border-width:0px; padding:0rem;">
                        <h3 style="background-color:#e7d790; color:black; margin:0px 0px 5px 0px; padding:5px 0px;">
                        Informații Client
                        </h3>
                    </td>
                </tr>
                <tr>
                    <td width="" style="">
                    </td>
                    <td width="50%" style="text-align:center;">
                        Telefon: 
                        <br>
                        <b>{{ $rezervare->telefon }}</b>
                    </td>
                    <td width="50%" style="text-align:center;">
                        E-mail: 
                        <br>
                        <b>{{ $rezervare->email }}</b>
                    </td>
                </tr>
                @isset ($rezervare->observatii)
                <tr>
                    <td colspan="3" style="height: 10px">

                    </td>
                </tr>
                <tr>
                    <td colspan="3">                    
                        Observații: {{ $rezervare->observatii }}
                    </td>
                </tr>
                @endisset
            </table>
   
            <br><br>

            {{-- <table style="margin-bottom:0px">    
                <tr style="text-align:center; font-weight:bold;">
                    <td colspan="4" style="padding:0rem;">
                        <h3 style="background-color:#e7d790; color:black; margin:10px 0px 5px 0px; padding:5px 0px">
                        Informații Rezervare bilet
                        </h3>
                    </td>
                </tr>
                <tr style="">
                    <td style="">
                        Data de plecare: 
                        <br>
                        <b>{{ \Carbon\Carbon::parse($rezervare->data_cursa)->isoFormat('DD.MM.YYYY') }}</b>
                    </td>
                    <td style="text-align: center">
                        Oraș plecare:
                        <br>
                        <b>{{ $rezervare->oras_plecare_nume->oras ?? '' }}</b>
                    </td>
                    <td style="text-align: center">
                        <img src="{{ asset('images/sageata dreapta.jpg') }}" width="50px">
                    </td>
                    <td style="text-align: center">
                        Oraș sosire:
                        <br>
                        <b>{{ $rezervare->oras_sosire_nume->oras ?? '' }}</b>
                    </td>
                </tr>
            </table>
                           
            <br><br>

            <table style="margin-bottom:10px">
                <tr style="text-align:center; font-weight:bold;">
                    <td colspan="3" style="border-width:0px; padding:0rem;">
                        <h3 style="background-color:#e7d790; color:black; margin:10px 0px 5px 0px; padding:5px 0px">
                        Călătorie | Tarif
                        </h3>
                    </td>
                </tr>
                    @if ($rezervare->nr_adulti > 0)
                        <tr>
                            <td colspan="3" style="text-align: center">
                                <span style="margin-right:0px">
                                    Pasageri: <b>{{ $rezervare->nr_adulti + $rezervare->nr_copii }}</b>
                                </span>
                                    <span>
                                        Preț în Euro: <b>{{ $rezervare->pret_total }} Euro</b>
                                        <br/>
                                        Preț în Lei: {{ $rezervare->valoare_lei + $rezervare->valoare_lei_tva }} lei
                                    </span>
                                <br>                          
                                @if($rezervare->plata_efectuata == 1)
                                    <span>
                                        <b>Plata a fost deja efectuată online</b>
                                    </span>
                                @endif
                                <br> 
                            </td>
                        </tr>
                        <tr>
                            <td style="border: solid 1px gray">
                                Nume
                            </td>
                            <td style="border: solid 1px gray">
                                Data naștere
                            </td>
                            <td style="border: solid 1px gray">
                                Localitate naștere
                            </td>
                        </tr>
                        @foreach ($rezervare->pasageri_relation as $pasager)
                        <tr>
                            <td style="border: solid 1px gray">
                                {{ $pasager->nume }}
                            </td>
                            <td style="border: solid 1px gray">
                                {{ $pasager->data_nastere }}
                            </td>
                            <td style="border: solid 1px gray">
                                {{ $pasager->localitate_nastere }}
                            </td>
                        </tr> 
                        @endforeach      
                        </tr>
                    @else
                        <tr>
                            <td colspan="4">
                                Descriere bagaj: {{ $rezervare->bagaje_descriere }}
                                <br>
                                <b>Cantitate: {{ $rezervare->bagaje_kg }}Kg</b>
                            </td>
                        </tr>
                    @endif              
            </table>
            
            <br><br>
            Păstrați biletul pentru control --}}

            {{-- <h2 style="margin:5px">BILET DE CĂLĂTORIE</h2>
            
            Seria și număr: {{ $rezervare->bilet_serie }} {{ $rezervare->bilet_numar }} <br>
            Plecare din : {{ $rezervare->oras_plecare_sofer ?? '' }} - {{ $rezervare->oras_sosire_sofer ?? '' }} <br><br><br>

            Data începerii călătoriei: {{ \Carbon\Carbon::now()->isoFormat('DD.MM.YYYY HH:mm') }} <br><br>

            Preț în Euro: {{ $rezervare->pret_total }} <br>
            <h2 style="margin:5px">
                Preț în Lei: {{ $rezervare->valoare_lei + $rezervare->valoare_lei_tva }} lei 
            </h2>

            <h2 style="margin:5px">PREȚUL {{ $rezervare->valoare_lei + $rezervare->valoare_lei_tva }} lei</h2>
            <br>
            Păstrați biletul pentru control --}}
            
             
        </div>
    </div>
</body>
</html>