<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Bilet</title>
    <style>
        html { 
            margin: 0px 0px 0px 0px;
        }

        body { 
            font-family: DejaVu Sans, sans-serif;
            /* font-family: Arial, Helvetica, sans-serif; */
            font-size: 10px;
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
        width:360px;
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
               
            <br>
            <br>          
                            
            <table style="margin-bottom:0px">
                <tr style="text-align:center; font-weight:bold;">
                    <td colspan="3" style="border-width:0px; padding:0rem;">
                        <h3 style="background-color:#ece7cf; color:black; margin:0px 0px 5px 0px; padding:5px 0px;">
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
   
            <br>

            <table style="margin-bottom:0px">    
                <tr style="text-align:center; font-weight:bold;">
                    <td colspan="4" style="padding:0rem;">
                        <h3 style="background-color:#ece7cf; color:black; margin:10px 0px 5px 0px; padding:5px 0px">
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
                        <b>{{ $rezervare->oras_plecare_sofer ?? '' }}</b>
                    </td>
                    <td style="text-align: center">
                        <img src="{{ asset('images/sageata dreapta.jpg') }}" width="50px">
                    </td>
                    <td style="text-align: center">
                        Oraș sosire:
                        <br>
                        <b>{{ $rezervare->oras_sosire_sofer ?? '' }}</b>
                    </td>
                </tr>
            </table>
                           
            <br>

            <table style="margin-bottom:10px">
                <tr style="text-align:center; font-weight:bold;">
                    <td colspan="3" style="border-width:0px; padding:0rem;">
                        <h3 style="background-color:#ece7cf; color:black; margin:10px 0px 5px 0px; padding:5px 0px">
                        Călătorie | Tarif
                        </h3>
                    </td>
                </tr>
                    @if ($rezervare->nr_adulti > 0)
                        <tr>
                            <td style="width:33%">
                                <b style="font-size:larger">Pasageri: {{ $rezervare->nr_adulti + $rezervare->nr_copii }}</b>
                            </td>
                            <td style="width:33%; text-align: center">
                                Preț în Euro: <b style="font-size:larger">{{ $rezervare->pret_total }} Euro</b>
                            </td>
                            <td style="width:33%; text-align: right">
                                Preț în Lei: <b style="font-size:larger">{{ $rezervare->valoare_lei + $rezervare->valoare_lei_tva }} lei</b>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align: center">
                                        <br>
                                        Curs valutar BNR la data rezervării biletului de călătorie {{ \Carbon\Carbon::parse($rezervare->created_at)->isoFormat('DD.MM.YYYY') }}: 
                                        <br>
                                        1 EURO = {{ $rezervare->curs_bnr_euro }}
                                <br>                          
                                @if($rezervare->plata_efectuata == 1)
                                    <span>
                                        <b>Plata a fost efectuată online</b>
                                    </span>
                                @endif
                                <br> 
                            </td>
                        </tr>
                        <tr>
                            <td style="border: solid 3px black">
                                Nume
                            </td>
                            <td style="border: solid 3px black">
                                Data naștere
                            </td>
                            <td style="border: solid 3px black">
                                Localitate naștere
                            </td>
                        </tr>
                        @foreach ($rezervare->pasageri_relation as $pasager)
                        <tr>
                            <td style="border: solid 3px black">
                                {{ $pasager->nume }}
                            </td>
                            <td style="border: solid 3px black">
                                {{ $pasager->data_nastere }}
                            </td>
                            <td style="border: solid 3px black">
                                {{ $pasager->localitate_nastere }}
                            </td>
                        </tr> 
                        @endforeach    
                    @else
                        <tr>
                            <td colspan="3">
                                Descriere bagaj: {{ $rezervare->bagaje_descriere }}
                                <br>
                                <b>Cantitate: {{ $rezervare->bagaje_kg }}Kg</b>
                            </td>
                        </tr>
                    @endif   
            </table>   
            
            @php
                $html = '    <div style="
        width:360px;
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
            </div>';
            @endphp

            <br>
            Păstrați biletul pentru control
            <br>
            <a class="btn btn-primary btn-cta" onclick="return checkAndroid();" 
                {{-- href="intent://www.google.com/ --}}
                {{-- href="rawbt:<div>sdf</div> --}}
                href="rawbt:url:https://rezervari.transportcorsica.ro/chitanta-descarca/{{ $rezervare->cheie_unica }}/export-html
                {{-- href="rawbt:url:https://www.google.com/ --}}
                {{-- {!! $html !!} --}}
                    {{-- #Intent;scheme=rawbt;package=ru.a402d.rawbtprinter;end; --}}
                    ">
                {{-- <svg class="svg-inline--fa fa-print fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="print" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                    <path fill="currentColor" d="M464 192h-16V81.941a24 24 0 0 0-7.029-16.97L383.029 7.029A24 24 0 0 0 366.059 0H88C74.745 0 64 10.745 64 24v168H48c-26.51 0-48 21.49-48 48v132c0 6.627 5.373 12 12 12h52v104c0 13.255 10.745 24 24 24h336c13.255 0 24-10.745 24-24V384h52c6.627 0 12-5.373 12-12V240c0-26.51-21.49-48-48-48zm-80 256H128v-96h256v96zM128 224V64h192v40c0 13.2 10.8 24 24 24h40v96H128zm304 72c-13.254 0-24-10.746-24-24s10.746-24 24-24 24 10.746 24 24-10.746 24-24 24z" data-darkreader-inline-fill="" style="--darkreader-inline-fill:currentColor;">
                    </path></svg> --}}
                    <!-- <i class="fas fa-print"></i> --> 
                    Print Now
            </a>
            {{-- <a href="print://escpos.org/escpos/bt/print?srcTp=uri
   &srcObj=html
   &numCopies=1 //added in version 2.3.2
   &src='https://rezervari.transportcorsica.ro/chitanta-descarca/tur600825b6d3542/export-pdf'">Print Me !</a> --}}
             
        </div>
    </div>
</body>
</html>