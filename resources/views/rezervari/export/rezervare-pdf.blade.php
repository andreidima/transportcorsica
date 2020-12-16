<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Bilet</title>
    <style>
        html { 
            margin: 40px 30px;
        }

        body { 
            font-family: DejaVu Sans, sans-serif;
            /* font-family: Arial, Helvetica, sans-serif; */
            font-size: 12px;
            margin: 0px;
        }

        * {
            /* padding: 0; */
            text-indent: 0;
        }

        table{
            border-collapse:collapse;
            margin: 0px;
            padding: 5px;
            margin-top: 0px;
            border-style: solid;
            border-width: 0px;
            width: 100%;
            word-wrap:break-word;
        }
        
        th, td {
            padding: 1px 10px;
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
    <div style="border:dashed #999;
        width:710px; 
        min-height:500px;            
        padding: 0px 8px 0px 8px;
        margin:0px 0px;
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
            border-radius: 10px;">

                <table style="margin:20px 0 20px 0">
                    <tr style="">
                        <td style="border-width:0px; padding:0rem; margin:0rem; width:40%">
                            <img src="{{ asset('images/logo.png') }}" width="300px">
                        </td>
                        <td style="border-width:0px; padding:0rem; margin:0rem; width:60%; text-align:center; font-size:16px">
                            BILET REZERVAT
                            {{-- <br>
                            Cod bilet: RO{{ $rezervare_tur->id }} --}}
                        </td>
                    </tr>
                </table>
            
                            
            <table style="margin-bottom:40px">
                <tr style="text-align:center; font-weight:bold;">
                    <td colspan="3" style="border-width:0px; padding:0rem;">
                        <h3 style="background-color:#e7d790; color:black; margin:0px 0px 5px 0px; padding:5px 0px;">
                        Informații Client
                        </h3>
                    </td>
                </tr>
                <tr>
                    <td width="" style="">
                        {{-- Client: 
                        <br>
                        <b>{{ $rezervare_tur->nume }}</b> --}}
                    </td>
                    <td width="50%" style="text-align:center;">
                        Telefon: 
                        <br>
                        <b>{{ $rezervare_tur->telefon }}</b>
                    </td>
                    <td width="50%" style="text-align:center;">
                        E-mail: 
                        <br>
                        <b>{{ $rezervare_tur->email }}</b>
                    </td>
                </tr>
                @isset ($rezervare_tur->observatii)
                <tr>
                    <td colspan="3" style="height: 10px">

                    </td>
                </tr>
                <tr>
                    <td colspan="3">                    
                        Observații: {{ $rezervare_tur->observatii }}
                    </td>
                </tr>
                @endisset
            </table>

            <table style="margin-bottom:40px">    
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
                        <b>{{ \Carbon\Carbon::parse($rezervare_tur->data_cursa)->isoFormat('DD.MM.YYYY') }}</b>
                    </td>
                    <td style="text-align: center">
                        Oraș plecare:
                        <br>
                        <b>{{ $rezervare_tur->oras_plecare_nume->oras ?? '' }}</b>
                    </td>
                    <td style="text-align: center">
                        <img src="{{ asset('images/sageata dreapta.jpg') }}" width="50px">
                    </td>
                    <td style="text-align: center">
                        Oraș sosire:
                        <br>
                        <b>{{ $rezervare_tur->oras_sosire_nume->oras ?? '' }}</b>
                    </td>
                    {{-- <td style="text-align: right">
                        <img src="data:image/png;base64, {{ base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::size(50)->generate('https://rezervari.transportcorsica.ro/chitanta-descarca/' . $rezervare_tur->cheie_unica . '/export-pdf')) }} ">
                    </td> --}}
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                @if ($rezervare_retur)

                    <tr>
                        <td style="">
                            Data de întoarcere: 
                            <br>
                            <b>{{ \Carbon\Carbon::parse($rezervare_retur->data_cursa)->isoFormat('DD.MM.YYYY') }}</b>
                        </td>
                        <td style="text-align: center">
                            Oraș sosire:
                            <br>
                            <b>{{ $rezervare_retur->oras_sosire_nume->oras ?? '' }}</b>
                        </td>
                        <td style="text-align: center">
                        <img src="{{ asset('images/sageata stanga.jpg') }}" width="50px">
                        </td>
                        <td style="text-align: center">
                            Oraș plecare:
                            <br>
                            <b>{{ $rezervare_retur->oras_plecare_nume->oras ?? '' }}</b>
                        </td>
                        {{-- <td style="text-align: right">
                            <img src="data:image/png;base64, {{ base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::size(50)->generate('https://rezervari.transportcorsica.ro/chitanta-descarca/' . $rezervare_retur->cheie_unica . '/export-pdf')) }} ">
                        </td> --}}
                    </tr>
                @endif
            </table>
                            
            <table style="margin-bottom:20px">
                <tr style="text-align:center; font-weight:bold;">
                    <td colspan="5" style="border-width:0px; padding:0rem;">
                        <h3 style="background-color:#e7d790; color:black; margin:10px 0px 5px 0px; padding:5px 0px">
                        Călătorie | Tarif
                        </h3>
                    </td>
                </tr>
                    @if ($rezervare_tur->nr_adulti > 0)
                        <tr>
                            <td colspan="5" style="text-align: center">
                                <span style="margin-right:50px">
                                    Pasageri: <b>{{ $rezervare_tur->nr_adulti + $rezervare_tur->nr_copii }}</b>
                                </span>
                                @if ($rezervare_retur && ($rezervare_retur->pret_total > 0))
                                    <span style="margin-right:50px">
                                        Preț tur: <b>{{ $rezervare_tur->pret_total }}Euro</b>
                                    </span>
                                    <span>
                                        Preț retur: <b>{{ $rezervare_retur->pret_total }}Euro</b>
                                    </span>
                                @else
                                    <span>
                                        Preț total: <b>{{ $rezervare_tur->pret_total }}Euro</b>
                                    </span>
                                @endif
                                <br>                                
                                ID: {{$rezervare_tur->id}}
                                <br>
                                Plata: {{$rezervare_tur->plata_efectuata}}
                                <br>
                                Newsletter {{$rezervare_tur->acord_newsletter}}
                                @if($rezervare_tur->plata_efectuata == 1)
                                    <span>
                                        Plata a fost deja efectuată online
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="border: solid 1px gray">
                                Nume:
                            </td>
                            {{-- <td style="border: solid 1px gray">
                                Buletin
                            </td> --}}
                            <td style="border: solid 1px gray">
                                Data naștere
                            </td>
                            <td style="border: solid 1px gray">
                                Localitate naștere
                            </td>
                            {{-- <td style="border: solid 1px gray">
                                Localitate domiciliu
                            </td> --}}
                            <td style="border: solid 1px gray">
                                Sex
                            </td>
                            <td style="border: solid 1px gray">
                                Categorie
                            </td>
                        </tr>
                        @foreach ($rezervare_tur->pasageri_relation as $pasager)
                        <tr>
                            <td style="border: solid 1px gray">
                                {{ $pasager->nume }}
                            </td>
                            {{-- <td style="border: solid 1px gray">
                                {{ $pasager->buletin }}
                            </td> --}}
                            <td style="border: solid 1px gray">
                                {{ $pasager->data_nastere }}
                            </td>
                            <td style="border: solid 1px gray">
                                {{ $pasager->localitate_nastere }}
                            </td>
                            {{-- <td style="border: solid 1px gray">
                                {{ $pasager->localitate_domiciliu }}
                            </td> --}}
                            <td style="border: solid 1px gray">
                                {{ $pasager->sex }}
                            </td>
                            <td style="border: solid 1px gray">
                                {{ $pasager->categorie }}
                            </td>
                        </tr> 
                        @endforeach      
                        </tr>
                    @else
                        <tr>
                            <td colspan="4">
                                Descriere bagaj: {{ $rezervare_tur->bagaje_descriere }}
                                <br>
                                <b>Cantitate: {{ $rezervare_tur->bagaje_kg }}Kg</b>
                            </td>
                        </tr>
                    @endif              
            </table>
                            
            {{-- <table style="margin-bottom:20px">
                <tr style="text-align:center; font-weight:bold;">
                    <td colspan="" style="border-width:0px; padding:0rem;">
                        <h3 style="background-color:#e7d790; color:black; margin:10px 0px 5px 0px; padding:5px 0px">
                        Date pentru facturare
                        </h3>
                    </td>
                </tr>
                <tr>
                    <td>
                        Document de călătorie:<b> {{ $rezervare_tur->document_de_calatorie }} </b>
                        <br>
                        Seria buletin / pașaport:<b> {{ $rezervare_tur->serie_document }} </b>
                        <br>
                        Cnp:<b> {{ $rezervare_tur->cnp }} </b>
                        <br>
                    </td>
                </tr>                
            </table> --}}
            
            {{-- * IN PRETUL BILETULUI AVETI INCLUS 40 KG PTR BAGAJUL DVS , CE DEPASESTE SE TAXEAZA CU 1 EURO / KG !!!
            <br><br>
            Ptr rezervari făcute cu mai puțin de 24 ore înainte de plecare sunați la nr de telefon: <b>0755106508</b> sau <b>0742296938</b>
            <br>
            E-mail: <a href="mailto:alsimy_mond_travel@yahoo.com">alsimy_mond_travel@yahoo.com</a> 
                / 
                <a href="mailto:alsimy.mond.travel@gmail.com">alsimy.mond.travel@gmail.com</a>
            <br>
            FACTURA FISCALA O VEȚI PRIMI PE E-MAIL --}}
    </div>
</body>

</html>
    