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
                            <img src="{{ asset('images/Alsimy Mond Travel Galati - logo.png') }}" width="300px">
                        </td>
                        <td style="border-width:0px; padding:0rem; margin:0rem; width:60%; text-align:center; font-size:16px">
                            BILET REZERVAT
                            <br>
                            Cod bilet: RO{{ $rezervare->id }}
                        </td>
                    </tr>
                </table>
            
                            
            <table style="margin-bottom:40px">
                <tr style="text-align:center; font-weight:bold;">
                    <td colspan="3" style="border-width:0px; padding:0rem;">
                        <h3 style="background-color:#e7d790; color:black; margin:0px 0px 5px 0px; padding:5px 0px;">
                        Informatii Calator
                        </h3>
                    </td>
                </tr>
                <tr>
                    <td width="35%" style="">
                        Calator: 
                        <br>
                        <b>{{ $rezervare->nume }}</b>
                    </td>
                    <td width="25%" style="text-align:center;">
                        Telefon: 
                        <br>
                        <b>{{ $rezervare->telefon }}</b>
                    </td>
                    <td width="40%" style="text-align:right;">
                        E-mail: 
                        <br>
                        <b>{{ $rezervare->email }}</b>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">                        
                        Adresa: {{ $rezervare->adresa }}
                    </td>
                </tr>
                <tr>
                    <td colspan="3">                    
                        Animale de companie: {{ $rezervare->animale_companie }}
                    </td>
                </tr>
                <tr>
                    <td colspan="3">                    
                        Observatii: {{ $rezervare->observatii }}
                    </td>
                </tr>
            </table>

            <table style="margin-bottom:40px">    
                <tr style="text-align:center; font-weight:bold;">
                    <td colspan="5" style="padding:0rem;">
                        <h3 style="background-color:#e7d790; color:black; margin:10px 0px 5px 0px; padding:5px 0px">
                        Informatii Rezervare bilet
                        </h3>
                    </td>
                </tr>
                <tr style="">
                    <td style="">
                        Data de plecare: 
                        <br>
                        <b>{{ \Carbon\Carbon::parse($rezervare->data_plecare)->isoFormat('D.MM.YYYY') }}</b>
                    </td>
                    <td style="">
                        Oraș plecare:
                        <br>
                        <b>{{ $rezervare->oras_plecare_nume->nume }}</b>
                    </td>
                    <td>
                        <img src="{{ asset('images/sageata dreapta.jpg') }}" width="50px">
                    </td>
                    <td style="">
                        Oraș sosire:
                        <br>
                        <b>{{ $rezervare->oras_sosire_nume->nume }}</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                @if (($rezervare->tur_retur === "true") || ($rezervare->tur_retur === 1))

                    <tr>
                        <td style="">
                            Data de întoarcere: 
                            <br>
                            <b>{{ \Carbon\Carbon::parse($rezervare->data_intoarcere)->isoFormat('D.MM.YYYY') }}</b>
                        </td>
                        <td style="">
                            Oraș sosire:
                            <br>
                            <b>{{ $rezervare->oras_plecare_nume->nume }}</b>
                        </td>
                        <td>
                        <img src="{{ asset('images/sageata stanga.jpg') }}" width="50px">
                        </td>
                        <td style="">
                            Oraș plecare:
                            <br>
                            <b>{{ $rezervare->oras_sosire_nume->nume }}</b>
                        </td>
                    </tr>
                @endif
            </table>
                            
            <table style="margin-bottom:20px">
                <tr style="text-align:center; font-weight:bold;">
                    <td colspan="6" style="border-width:0px; padding:0rem;">
                        <h3 style="background-color:#e7d790; color:black; margin:10px 0px 5px 0px; padding:5px 0px">
                        Calatorie | Tarif
                        </h3>
                    </td>
                </tr>
                <tr>
                    <td>
                        Număr adulți: {{ $rezervare->nr_adulti }} * {{ $tarife->adult }}Euro = {{ $rezervare->nr_adulti * $tarife->adult}}Euro
                                        {{-- - 10% =
                                        {{ $rezervare->nr_adulti * floor((string) ($tarife->adult * 90)) / 100}}Euro --}}
                        @if ($rezervare->nr_copii > 0)
                            <br>
                            Număr copii: {{ $rezervare->nr_copii }} * {{ $tarife->copil }}Euro = {{ $rezervare->nr_copii * $tarife->copil}}Euro
                                            {{-- - 10% =
                                            {{ $rezervare->nr_copii * floor((string) ($tarife->copil * 90)) / 100}}Euro --}}
                        @endif
                        @if ($rezervare->nr_animale_mici > 0)
                            <br>
                            Număr animale de companie de talie mică, mai mici de 10 kg: {{ $rezervare->nr_animale_mici }} * {{ $tarife->animal_mic }}Euro = {{ $rezervare->nr_animale_mici * $tarife->animal_mic}}Euro
                        @endif
                        @if ($rezervare->nr_animale_mari > 0)
                            <br>
                            Număr animale de companie de talie mare, mai mari de 10 kg: {{ $rezervare->nr_animale_mari }} * {{ $tarife->animal_mare }}Euro = {{ $rezervare->nr_animale_mari * $tarife->animal_mare}}Euro
                        @endif
                        <br>
                        <br>
                        <b>Preț total: {{ $rezervare->pret_total }}Euro</b>

                    </td>
                </tr>                
            </table>
                            
            <table style="margin-bottom:20px">
                <tr style="text-align:center; font-weight:bold;">
                    <td colspan="6" style="border-width:0px; padding:0rem;">
                        <h3 style="background-color:#e7d790; color:black; margin:10px 0px 5px 0px; padding:5px 0px">
                        Date pentru facturare
                        </h3>
                    </td>
                </tr>
                <tr>
                    <td>
                        Document de călătorie:<b> {{ $rezervare->document_de_calatorie }} </b>
                        <br>
                        Data expirării documentului:
                            <b>
                                @if ($rezervare->expirare_document !== null)
                                    {{ \Carbon\Carbon::parse($rezervare->expirare_document)->isoFormat('D.MM.YYYY') }}    
                                @endif 
                            </b>
                        <br>
                        Seria buletin / pașaport:<b> {{ $rezervare->serie_document }} </b>
                        <br>
                        Cnp:<b> {{ $rezervare->cnp }} </b>
                        <br>
                    </td>
                </tr>                
            </table>
            
            * IN PRETUL BILETULUI AVETI INCLUS 40 KG PTR BAGAJUL DVS , CE DEPASESTE SE TAXEAZA CU 1 EURO / KG !!!
            <br><br>
            Ptr rezervari făcute cu mai puțin de 24 ore înainte de plecare sunați la nr de telefon: <b>0755106508</b> sau <b>0742296938</b>
            <br>
            E-mail: <a href="mailto:alsimy_mond_travel@yahoo.com">alsimy_mond_travel@yahoo.com</a> 
                / 
                <a href="mailto:alsimy.mond.travel@gmail.com">alsimy.mond.travel@gmail.com</a>
            <br>
            FACTURA FISCALA O VEȚI PRIMI PE E-MAIL
    </div>
</body>

</html>
    