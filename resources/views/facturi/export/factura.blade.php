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
            padding: 0px 5px;
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
                    <td style="border-width:0px; padding:0rem; width:45%">
                            <b>Furnizor</b> <br>
                            <b>MRW88 MAXARMONY SRL</b> <br>
                            Nr. Reg. com.: J39/570/2015 <br>
                            CIF: RO35059906 <br>
                            Sediul: Str. Soseaua Nationala 22 Et:1 -, Ceardac, Judet: Vrancea <br>
                    </td>
                    <td style="border-width:0px; padding:0rem; width:10%">

                    </td>
                    <td style="border-width:0px; padding:0rem; width:45%">
                            <b>Cumparator</b> <br>
                            <b>{{ $factura->cumparator }}</b> <br>
                            Nr. Reg. com.: {{ $factura->nr_reg_com }} <br>
                            CIF: {{ $factura->cif }} <br>
                            Adresa: {{ $factura->adresa }} <br>
                    </td>
                </tr>
            </table>
        </div>

            <p>
                        Factura seria: <b>{{ $factura->seria }}</b> 
                        Nr.: <b>{{ $factura->numar }}</b>
                        Data: {{ \Carbon\Carbon::parse($factura->created_at)->isoFormat('D.MM.YYYY') }}
                        Cota TVA: 19%
            </p>

            
                    <table style="width:100%;">
                        <tr style="background-color:#e7d790;">
                            <th style="text-align: center">Denumire</th>
                            <th style="text-align: center">U.M.</th>
                            <th style="text-align: center">Cant.</th>
                            <th style="text-align: center">Pret unitar</th>
                            <th style="text-align: center">Valoare</th>
                            <th style="text-align: center">Valoare TVA</th>
                        </tr>  
                        @forelse ($factura->produse as $produs)
                            <tr>
                                <td>
                                    {{ $produs->nume }}
                                </td>
                                <td style="text-align: center">
                                    {{ $produs->um }}
                                </td>
                                <td style="text-align: right">
                                    {{ $produs->cantitate }}
                                </td>
                                <td style="text-align: right">
                                    {{ $produs->pret_unitar }}
                                </td>
                                <td style="text-align: right">
                                    {{ $produs->valoare }}
                                </td>
                                <td style="text-align: right">
                                    {{ $produs->valoare_tva }}
                                </td>
                            </tr>
                            @if (!is_null($produs->observatii))
                                <tr>
                                    <td colspan="6" style="padding-left: 30px;">
                                        Observații: {{ $produs->observatii }}
                                    </td>
                                </tr>
                            @endif
                        @empty
                        @endforelse
                    </table>

                    <p></p>

                    <table style="width:100%;">
                        <tr style="">
                            <td style="border-width:0px; padding:0rem;">
                                Semnătură și ștampilă furnizor
                            </td>
                            <td style="border-width:0px; padding:0rem;">
                                DELEGAT - {{ $factura->delegat }}
                                <BR>
                                {{ $factura->seria_nr_buletin }}
                            </td>
                            <td style="border-width:0px; text-align:center;">
                                TOTAL DE PLATĂ
                                <br>
                                <b>{{ $factura->produse->sum('valoare') + $factura->produse->sum('valoare_tva') }} lei</b>
                            </td>
                        </tr>
                    </table>

                    <p style="margin-top:40px; margin-bottom:{{ 260 - $factura->produse->count() * 20 }}px">&nbsp;</p>
        
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
                    <td style="border-width:0px; padding:0rem; width:45%;">
                            {{-- <img src="{{ asset('images/cropped-gsmobile-logo-red.jpg') }}" width="150px"> --}}
                            <b>Furnizor</b> <br>
                            <b>G.S.MOBILE 2001 SRL</b> <br>
                            Nr. Reg. com.: J39/13/2001 <br>
                            CIF: RO13648994 <br>
                            Adresa: Golesti, Str. Pasunii, Nr. 30A, Vrancea <br>
                            Pct.de lucru: Focsani, Str. Stefan cel Mare, Nr. 5, Vrancea <br>
                            Telefon: 0722873217	<br>
                            {{-- Banca: BRD FOCSANI <br> --}}
                            Cont BRD: RO60BRDE400SV19069964000 <br>
                            Cont TREZ: RO40TREZ6915069XXX001749
                    </td>
                    <td style="border-width:0px; padding:0rem; width:10%">

                    </td>
                    <td style="border-width:0px; padding:0rem; width:45%">
                            <b></b> <br>
                            <b>{{ $factura->firma }}</b> <br>
                            Nr. Reg. com.: {{ $factura->nr_reg_com }} <br>
                            CIF: {{ $factura->cif_cnp }} <br>
                            Adresa: {{ $factura->adresa }} <br>
                            
                            Telefon: {{ $factura->telefon }} <br>
                            <br>
                            <br>
                    </td>
                </tr>
            </table>
        </div>

            <p>
                        Factura seria: <b>{{ $factura->seria }}</b> 
                        Nr.: <b>{{ $factura->numar }}</b>
                        Data: {{ \Carbon\Carbon::parse($factura->created_at)->isoFormat('D.MM.YYYY') }}
                        Cota TVA: 19%
            </p>

            
                    <table style="width:100%;">
                        <tr style="background-color:#e7d790;">
                            <th style="text-align: center">Denumire</th>
                            <th style="text-align: center">U.M.</th>
                            <th style="text-align: center">Cant.</th>
                            <th style="text-align: center">Pret unitar</th>
                            <th style="text-align: center">Valoare</th>
                            <th style="text-align: center">Valoare TVA</th>
                        </tr>  
                        @forelse ($factura->produse as $produs)
                            <tr>
                                <td>
                                    {{ $produs->nume }}
                                </td>
                                <td style="text-align: center">
                                    {{ $produs->um }}
                                </td>
                                <td style="text-align: right">
                                    {{ $produs->cantitate }}
                                </td>
                                <td style="text-align: right">
                                    {{ $produs->pret_unitar }}
                                </td>
                                <td style="text-align: right">
                                    {{ $produs->valoare }}
                                </td>
                                <td style="text-align: right">
                                    {{ $produs->valoare_tva }}
                                </td>
                            </tr>
                            @if (!is_null($produs->observatii))
                                <tr>
                                    <td colspan="6" style="padding-left: 30px;">
                                        Observații: {{ $produs->observatii }}
                                    </td>
                                </tr>
                            @endif
                        @empty
                        @endforelse
                    </table>

                    <p></p>

                    <table style="width:100%;">
                        <tr style="">
                            <td style="border-width:0px; padding:0rem;">
                                Semnătură și ștampilă furnizor
                            </td>
                            <td style="border-width:0px; padding:0rem;">
                                DELEGAT - {{ $factura->delegat }}
                                <BR>
                                {{ $factura->seria_nr_buletin }}
                            </td>
                            <td style="border-width:0px; text-align:center;">
                                TOTAL DE PLATĂ
                                <br>
                                <b>{{ $factura->produse->sum('valoare') + $factura->produse->sum('valoare_tva') }} lei</b>
                            </td>
                        </tr>
                    </table>
 
</body>

</html>
    