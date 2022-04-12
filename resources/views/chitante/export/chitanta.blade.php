<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    @if ($rezervare->nr_adulti > 0)
        <title>Bilet</title>
    @else
        <title>AWB</title>
    @endif
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
    {{-- Chitanta pentru calatori --}}
    @if ($rezervare->nr_adulti > 0)
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
                        {{-- <img src="{{ public_path('images/sageata dreapta.jpg') }}" width="50px"> --}}
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
            </table>

            <br>
            Păstrați biletul pentru control
        </div>

    {{-- Chitanta pentru colete --}}
    @else
        {{-- De printat cate un AWB pentru fiecare colet in parte, si inca 3 AWB-uri duplicat --}}
        @for ($i = 0; $i < $rezervare->colete_numar + 3; $i++)
            <div style="
                width:360px;
                margin:0px 0px;
                    -moz-border-radius: 3px;
                    -webkit-border-radius: 3px;
                    border-radius: 3px;
                ">

                <p style="text-align:left; margin:0px;">
                    <b>MRW88 MAXARMONY S.R.L.</b> <br>
                    ORC: J39/570/29.09.2015 | CIF: RO35059906 <br>
                    Sediul: Str. Șoseaua Națională nr. 22, Et:1, Sat Ceardac, Golești, Vrancea <br>
                    Banca: Transilvania <br>
                    Cod IBAN EURO: RO83BTRLEURCRT0319122801 <br>
                    Cod IBAN LEI: RO36BTRLRONCRT0319122801 <br>
                </p>

                <h2 style="margin:5 0 5 0px; text-align:center">
                    @if ($i < $rezervare->colete_numar)
                        AWB {{ $rezervare->id }} ({{ $i+1 }} din {{ $rezervare->colete_numar }})
                    @else
                        AWB ({{ $rezervare->colete_numar }} colete)
                    @endif
                </h2>

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
                            Expeditor: <span style="font-size: 120%; font-weight:bold">{{ $rezervare->nume }}</span>
                            <br>
                            Telefon: <span style="font-size: 120%; font-weight:bold">{{ $rezervare->telefon }}</span>
                            {{-- <br>
                            Email: {{ $rezervare->email }} --}}
                        </td>
                        <td colspan="1">
                            Destinatar: <span style="font-size: 120%; font-weight:bold">{{ $rezervare->colete_nume_destinatar }}</span>
                            <br>
                            Telefon: <span style="font-size: 120%; font-weight:bold">{{ $rezervare->colete_telefon_destinatar }}</span>
                            {{-- <br>
                            Email: {{ $rezervare->colete_email_destinatar }} --}}
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
                            <img src="{{ asset('images/sageata dreapta.jpg') }}" width="30px">
                        </td>
                        <td style="text-align: center">
                            Oraș sosire:
                            <br>
                            <b>{{ $rezervare->oras_sosire_nume->oras ?? null }}</b>
                        </td>
                    </tr>
                </table>

                {{-- <br> --}}

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
                            Natura mărfii: {{ $rezervare->colete_natura_marfii }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            Mod ambalare: {{ $rezervare->colete_mod_ambalare }}
                        </td>
                    </tr>
                </table>

                {{-- <br> --}}

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

            <br><br>
            {{-- <br><br> --}}
        @endfor

    @endif
</body>
</html>
