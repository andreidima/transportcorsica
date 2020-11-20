<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Factura</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif;
            /* font-family: Arial, Helvetica, sans-serif;  */
            font-size: 10px;
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
    </style>
</head>

<body>
        <div style="
            border:dashed #999;
            width:680px;         
            padding: 10px 15px 10px 15px;
            margin:0px 0px;
                -moz-border-radius: 10px;
                -webkit-border-radius: 10px;
                border-radius: 10px;">

                      
            <table style="">
                <tr style="">
                    <td style="border-width:0px; padding:0rem; width:50%; vertical-align:top;">
                            <p style="background-color:teal; color: white; padding:5px; width:50%">
                                <b>FURNIZOR</b> 
                            </p>                     
                            <b>MRW88 MAXARMONY S.R.L.</b> <br>
                            Nr. ord. reg. com./an: J39/570/29.09.2015 <br>
                            CIF: RO35059906 <br>
                            Sediul: Str. Șoseaua Națională nr. 22, Et:1, Sat Ceardac, com. Golești, Județ Vrancea <br>
                            Banca: Transilvania <br>
                            Cod IBAN EURO: RO83BTRLEURCRT0319122801 <br>
                            Cod IBAN LEI: RO36BTRLRONCRT0319122801 <br>
                    </td>
                    <td style="border-width:0px; padding:0rem; width:10%">

                    </td>
                    <td style="border-width:0px; padding:0rem; width:50%; vertical-align:top;">
                            <p style="background-color:teal; color: white; padding:5px; width:50%">
                                <b>CUMPĂRĂTOR</b> 
                            </p>     
                            <b>{{ $factura->cumparator }}</b> <br>
                            Nr. Reg. com.: {{ $factura->nr_reg_com }} <br>
                            CIF: {{ $factura->cif }} <br>
                            Sediul: {{ $factura->sediul }} <br>
                    </td>
                </tr>
            </table>
        </div>
        
        <div style="
            width:680px;         
            padding: 10px 0px 10px 15px;
            margin:0px 0px;
                -moz-border-radius: 10px;
                -webkit-border-radius: 10px;
                border-radius: 10px;">
            
            
            <h2 style="text-align: center; color:teal; margin-bottom:0px">FACTURĂ</h2>
            <p style="text-align: center; margin-top:0px">
                (de decont)
            </p>

            <p style="text-align: center; ">                        
                        Seria și număr: <b>{{ $factura->seria }} {{ $factura->numar }}</b> 
                        {{-- <br>
                        Nr.: <b>{{ $factura->numar }}</b> --}}
                        <br>
                        Data: <b>{{ \Carbon\Carbon::parse($factura->created_at)->isoFormat('D.MM.YYYY') }}</b>
            </p>
        </div>

            
                    <table style="width:100%;">
                        <tr style="background-color:teal; color:white;">
                            <th style="text-align: center; padding:2px">DESCRIERE</th>
                            <th style="text-align: center; padding:2px">CANT.</th>
                            <th style="text-align: center; padding:2px">PREȚ UNITAR</th>
                            <th style="text-align: center; padding:2px">SUMĂ</th>
                        </tr> 
                        <tr style="height:200px; vertical-align:top;">
                            <td>
                                Servicii Transport Persoane <br><br>
                                @isset ($factura->rezervare->retur)
                                    Bilete de călătorie:
                                    <ul style="margin: 0px">
                                        <li>
                                            MRW {{ $factura->rezervare->id }} | Dată transport: {{ \Carbon\Carbon::parse($factura->rezervare->data_cursa)->isoFormat('DD.MM.YYYY') }};
                                        </li>
                                        <li>
                                            MRW {{ $factura->rezervare->retur }} | Dată transport: {{ \Carbon\Carbon::parse(App\Models\Rezervare::find($factura->rezervare->retur)->data_cursa)->isoFormat('DD.MM.YYYY') }}. <br>
                                        </li>
                                    </ul>
                                @else
                                    Bilet de călătorie: MRW {{ $factura->rezervare->id }} | Dată transport: {{ \Carbon\Carbon::parse($factura->rezervare->data_cursa)->isoFormat('DD.MM.YYYY') }}. <br>                                
                                @endisset
                                <br>
                                Pasageri:                                
                                    @isset($factura->rezervare->nr_adulti)
                                        @foreach ($factura->rezervare->pasageri_relation as $pasager)
                                            @if(!$loop->last)
                                                {{ $pasager->nume }},
                                            @else
                                                {{ $pasager->nume }}.
                                            @endif
                                        @endforeach
                                    @endisset
                                <br><br>
                                Preț în EURO: {{ round($factura->valoare_euro) }}&euro; 
                                <br><br>
                                Curs valutar BNR la data de {{ \Carbon\Carbon::parse($factura->created_at)->isoFormat('DD.MM.YYYY') }}: <br>
                                1 EURO = {{ $factura->curs_bnr_euro }} 
                            </td>
                            <td style="text-align:center">
                                1
                            </td>
                            <td style="text-align:right">
                                {{ $factura->valoare_lei }}
                            </td>
                            <td style="text-align:right">
                                {{ $factura->valoare_lei }}
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center; color:teal">
                                Vă mulțumim pentru colaborare!
                            </td>
                            <td colspan="2" style="background-color:rgb(225, 255, 255)">
                                SUBTOTAL <br>
                                % TVA <br>
                                VALOARE TVA <br>
                                <b>TOTAL</b>
                            </td>
                            <td style="background-color:rgb(225, 255, 255); text-align:right">
                                {{ $factura->valoare_lei }} <br>
                                19% <br>
                                {{ $factura->valoare_lei_tva }} <br>
                                <b>{{ $factura->valoare_lei + $factura->valoare_lei_tva }}</b>
                            </td>
                        </tr>
                    </table>
        
        <br>
        <br>

        <p style="text-align:center">
            Întocmit de: Manolache Viorel, CNP 1781113390675, seria și nr. buletin VN 478829.
        </p>

        <p style="text-align:center">
            Dacă aveți întrebări legate de această factură, trimiteți un email la: 
            <br>
            <b>rezervari@transportcorsica.ro</b>
        </p>
        
 
</body>

</html>
    