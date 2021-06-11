<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Bilet</title>
    <style>
        html {
            margin: 30px 30px 30px 30px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            /* font-family: Arial, Helvetica, sans-serif; */
            font-size: 8px;
            /* margin: 0px; */
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
        width:730px;
        min-height:600px;
        padding: 3px 3px 3px 3px;
        margin:0px 0px;
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
            border-radius: 10px;">
        <table style="border:1px black solid;">
            @foreach($rezervari as $rezervare)
                @if($loop->index %3 === 0)
                    </tr>
                    <tr style="border:1px black solid;">
                @endif
                        <td style="width:33%; vertical-align: baseline; padding:5px; border:1px black solid;">
            <p style="text-align:left; margin:0px;">
                <b>MRW88 MAXARMONY S.R.L.</b> <br>
                ORC: J39/570/29.09.2015 | CIF: RO35059906 <br>
                Sediul: Str. Șoseaua Națională nr. 22, Et:1, Sat Ceardac, Golești, Vrancea <br>
                Banca: Transilvania <br>
                Cod IBAN EURO: RO83BTRLEURCRT0319122801 <br>
                Cod IBAN LEI: RO36BTRLRONCRT0319122801 <br>
            </p>


            <h2 style="margin:0px; text-align:center">BILET DE CĂLĂTORIE</h2>

            <h2 style="margin:0px; text-align:center">Seria și număr: {{ $rezervare->bilet_serie }} {{ $rezervare->bilet_numar }} </h2>

            <h2 style="margin:0px; text-align:center">DUPLICAT</h2>


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
            </table>

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
                        <img src="{{ public_path('images/sageata dreapta.jpg') }}" width="50px">
                    </td>
                    <td style="text-align: center">
                        Oraș sosire:
                        <br>
                        <b>{{ $rezervare->oras_sosire_sofer ?? '' }}</b>
                    </td>
                </tr>
            </table>

            <table style="margin-bottom:0px">
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
                    @if ($rezervare->pret_total == 0)
                        <tr>
                            <td colspan="3" style="text-align: center">
                                <h3 style="margin:0px">REDUCERE 100%</h3>
                            </td>
                        </tr>
                    @endif
                        <tr>
                            <td colspan="3" style="text-align: center">
                                        {{-- <br> --}}
                                        Curs valutar BNR la data rezervării biletului de călătorie {{ \Carbon\Carbon::parse($rezervare->created_at)->isoFormat('DD.MM.YYYY') }}:
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
                            <td style="border: solid 2px black">
                                Nume
                            </td>
                            <td style="border: solid 2px black">
                                Data naștere
                            </td>
                            <td style="border: solid 2px black">
                                Localitate naștere
                            </td>
                        </tr>
                        @foreach ($rezervare->pasageri_relation as $pasager)
                        <tr>
                            <td style="border: solid 2px black">
                                {{ $pasager->nume }}
                            </td>
                            <td style="border: solid 2px black">
                                {{ $pasager->data_nastere }}
                            </td>
                            <td style="border: solid 2px black">
                                {{ $pasager->localitate_nastere }}
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3">
                                Descriere colete: {{ $rezervare->colete_descriere }}
                                <br>
                                <b>Cantitate: {{ $rezervare->colete_kg }}Kg</b>
                            </td>
                        </tr>
                    @endif
            </table>
            <p style="text-align:center; margin:0rem">
                Păstrați biletul pentru control
            </p>

        {{-- </div>
    </div> --}}
                        </td>

                @if($loop->last)
                    @if($rezervari->count() == 1)
                            <td style="width:33%;"></td>
                            <td style="width:33%;"></td>
                    @elseif($rezervari->count() == 2)
                            <td style="width:33%;"></td>
                    @endif
                    </tr>
                @endif

            @endforeach
        </table>
    </div>
</body>
</html>
