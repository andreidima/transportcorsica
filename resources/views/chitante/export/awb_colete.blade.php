<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>AWB</title>
    <style>
        html {
            margin: 10px 40px;
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
            padding: 5px 15px;
            border-width: 1px;
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
    <div style="border:dashed #999;
        width:690px;
        min-height:600px;
        padding: 15px 10px 15px 10px;
        margin:0px 0px;
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
            border-radius: 10px;
        ">
        <table style="margin-bottom: 10px">
            <tr style="">
                <td style="border-width:0px; padding:0rem; width:30%">
                        <img src="{{ public_path('images/logo.png') }}" width="270px">
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

        <h1 style="text-align: center; padding:0; margin:0">
            AWB {{ $rezervare->id }}
        </h1>

        <br>

        <table style="margin-bottom:0px">
            {{-- <tr style="text-align:center; font-weight:bold;">
                <td colspan="2" style="border-width:0px; padding:0rem;">
                    <h3 style="background-color:#ece7cf; color:black; margin:0px 0px 5px 0px; padding:5px 0px;">
                    Informații Client
                    </h3>
                </td>
            </tr> --}}
            <tr>
                <td colspan="1">
                    Expeditor: <span style="font-size: 150%; font-weight:bold">{{ $rezervare->nume }}</span>
                    <br>
                    Telefon: <span style="font-size: 150%; font-weight:bold">{{ $rezervare->telefon }}</span>
                    <br>
                    Email: {{ $rezervare->email }}
                </td>
                <td colspan="1">
                    Destinatar: <span style="font-size: 150%; font-weight:bold">{{ $rezervare->colete_nume_destinatar }}</span>
                    <br>
                    Telefon: <span style="font-size: 150%; font-weight:bold">{{ $rezervare->colete_telefon_destinatar }}</span>
                    <br>
                    Email: {{ $rezervare->colete_email_destinatar }}
                </td>
            </tr>
        </table>

        <br>

        <table style="margin-bottom:0px">
            {{-- <tr style="text-align:center; font-weight:bold;">
                <td colspan="4" style="border-width:0px; padding:0rem;">
                    <h3 style="background-color:#ece7cf; color:black; margin:10px 0px 5px 0px; padding:5px 0px">
                    Informații Rezervare Colete
                    </h3>
                </td>
            </tr> --}}
            <tr style="">
                <td style="">
                    Data de plecare:
                    <br>
                    <b>{{ \Carbon\Carbon::parse($rezervare->data_cursa)->isoFormat('DD.MM.YYYY') }}</b>
                </td>
                <td style="text-align: center">
                    Oraș plecare:
                    <br>
                    <b>{{ $rezervare->oras_plecare_nume->oras ?? null }}</b>
                </td>
                <td style="text-align: center">
                    <img src="{{ public_path('images/sageata dreapta.jpg') }}" width="50px">
                </td>
                <td style="text-align: center">
                    Oraș sosire:
                    <br>
                    <b>{{ $rezervare->oras_sosire_nume->oras ?? null }}</b>
                </td>
            </tr>
        </table>

        <br>

        <table style="margin-bottom:0px">
            {{-- <tr style="text-align:center; font-weight:bold;">
                <td colspan="3" style="border-width:0px; padding:0rem;">
                    <h3 style="background-color:#ece7cf; color:black; margin:10px 0px 5px 0px; padding:5px 0px">
                    Informații Colete
                    </h3>
                </td>
            </tr> --}}
            <tr>
                <td>
                    Număr colete: {{ $rezervare->colete_numar }}
                </td>
                <td>
                    Cantitate: {{ $rezervare->colete_kg }} kg
                </td>
                <td>
                    Volum: {{ $rezervare->colete_volum }} m<sup>3</sup>
                </td>
                <td>
                    Preț: {{ $rezervare->pret_total }} EURO
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    Descriere: {{ $rezervare->colete_descriere }}
                </td>
            </tr>
        </table>

        <br>

        <table style="margin-bottom:0px">
            <tr style="font-weight:bold;">
                {{-- <td colspan="3" style="border-width:0px; padding:0rem;">
                    <h3 style="background-color:#ece7cf; color:black; margin:10px 0px 5px 0px; padding:5px 0px">
                    Confirmare - Am primit expediția intactă ({{ $rezervare->colete_numar }} buc)
                    </h3>
                </td> --}}
                <td colspan="3">
                    Confirmare - Am primit expediția intactă ({{ $rezervare->colete_numar }} buc)
                </td>
            </tr>
            <tr>
                <td style="width: 50%; padding-bottom: 30px">
                    Nume în clar:
                </td>
                <td style="width: 30%; padding-bottom: 30px">
                    Data  / Ora:
                </td>
                <td style="width: 20%; padding-bottom: 30px">
                    Semnătură:
                </td>
            </tr>
        </table>

        </div>
    </div>

    <br><br>

    {{-- Duplicare AWB --}}
    <div style="border:dashed #999;
        width:690px;
        min-height:600px;
        padding: 15px 10px 15px 10px;
        margin:0px 0px;
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
            border-radius: 10px;
        ">
        <table style="margin-bottom: 10px">
            <tr style="">
                <td style="border-width:0px; padding:0rem; width:30%">
                        <img src="{{ public_path('images/logo.png') }}" width="270px">
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

        <h1 style="text-align: center; padding:0; margin:0">
            AWB {{ $rezervare->id }}
        </h1>

        <br>

        <table style="margin-bottom:0px">
            {{-- <tr style="text-align:center; font-weight:bold;">
                <td colspan="2" style="border-width:0px; padding:0rem;">
                    <h3 style="background-color:#ece7cf; color:black; margin:0px 0px 5px 0px; padding:5px 0px;">
                    Informații Client
                    </h3>
                </td>
            </tr> --}}
            <tr>
                <td colspan="1">
                    Expeditor: <span style="font-size: 150%; font-weight:bold">{{ $rezervare->nume }}</span>
                    <br>
                    Telefon: <span style="font-size: 150%; font-weight:bold">{{ $rezervare->telefon }}</span>
                    <br>
                    Email: {{ $rezervare->email }}
                </td>
                <td colspan="1">
                    Destinatar: <span style="font-size: 150%; font-weight:bold">{{ $rezervare->colete_nume_destinatar }}</span>
                    <br>
                    Telefon: <span style="font-size: 150%; font-weight:bold">{{ $rezervare->colete_telefon_destinatar }}</span>
                    <br>
                    Email: {{ $rezervare->colete_email_destinatar }}
                </td>
            </tr>
        </table>

        <br>

        <table style="margin-bottom:0px">
            {{-- <tr style="text-align:center; font-weight:bold;">
                <td colspan="4" style="border-width:0px; padding:0rem;">
                    <h3 style="background-color:#ece7cf; color:black; margin:10px 0px 5px 0px; padding:5px 0px">
                    Informații Rezervare Colete
                    </h3>
                </td>
            </tr> --}}
            {{-- @php
                dd($rezervare->oras_plecare_nume);
            @endphp --}}
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
                    <img src="{{ public_path('images/sageata dreapta.jpg') }}" width="50px">
                </td>
                <td style="text-align: center">
                    Oraș sosire:
                    <br>
                    <b>{{ $rezervare->oras_sosire_nume->oras ?? '' }}</b>
                </td>
            </tr>
        </table>

        <br>

        <table style="margin-bottom:0px">
            {{-- <tr style="text-align:center; font-weight:bold;">
                <td colspan="3" style="border-width:0px; padding:0rem;">
                    <h3 style="background-color:#ece7cf; color:black; margin:10px 0px 5px 0px; padding:5px 0px">
                    Informații Colete
                    </h3>
                </td>
            </tr> --}}
            <tr>
                <td>
                    Număr colete: {{ $rezervare->colete_numar }}
                </td>
                <td>
                    Cantitate: {{ $rezervare->colete_kg }} kg
                </td>
                <td>
                    Volum: {{ $rezervare->colete_volum }} m<sup>3</sup>
                </td>
                <td>
                    Preț: {{ $rezervare->pret_total }} EURO
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    Descriere: {{ $rezervare->colete_descriere }}
                </td>
            </tr>
        </table>

        <br>

        <table style="margin-bottom:0px">
            <tr style="font-weight:bold;">
                {{-- <td colspan="3" style="border-width:0px; padding:0rem;">
                    <h3 style="background-color:#ece7cf; color:black; margin:10px 0px 5px 0px; padding:5px 0px">
                    Confirmare - Am primit expediția intactă ({{ $rezervare->colete_numar }} buc)
                    </h3>
                </td> --}}
                <td colspan="3">
                    Confirmare - Am primit expediția intactă ({{ $rezervare->colete_numar }} buc)
                </td>
            </tr>
            <tr>
                <td style="width: 50%; padding-bottom: 30px">
                    Nume în clar:
                </td>
                <td style="width: 30%; padding-bottom: 30px">
                    Data  / Ora:
                </td>
                <td style="width: 20%; padding-bottom: 30px">
                    Semnătură:
                </td>
            </tr>
        </table>

        </div>
    </div>
</body>
</html>
