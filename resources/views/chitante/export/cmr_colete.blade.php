<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>CMR</title>
    <style>
        html {
            margin: 10px 15px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            /* font-family: Arial, Helvetica, sans-serif; */
            font-size: 9px;
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
            padding: 0px 2px;
            border-width: 1px;
            border-style: solid;
            vertical-align: top;

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
    <div style="
        width:740px;
        min-height:600px;
        padding: 15px 10px 15px 10px;
        margin:0px 0px;
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
            border-radius: 10px;
        ">
        <table>
            <tr>
                <td style="width: 50%">
                    <span style="font-size: 12px; font-weight:bold">1</span>
                    Expeditor (nume, adresa, tara)
                    |
                    Sender (name, address, country)
                    |
                    Expediteur (nom, adresse, pays)
                    <br>
                    <h2 style="text-align:center; margin:0px">
                        {{ $rezervare->nume }},
                        {{ $rezervare->adresa }},
                        {{ $rezervare->oras_plecare_nume}},
                        {{ $rezervare->oras_plecare_tara}}
                    </h2>
                </td>
                <td style="width: 50%">
                    <b>
                        SCRISOARE DE TRANSPORT
                        |
                        CONSIGNMENT NOTE
                        |
                        LETTRE DE VOITURE
                    </b>
                    <h2 style="text-align:center; paddin:0px; margin:0px">
                        (CMR)
                        <br>
                        {{ $rezervare->id }} / {{ $rezervare->data_cursa ? \Carbon\Carbon::parse($rezervare->data_cursa)->isoFormat('DD.MM.YYYY') : '' }}
                    </h2>
                </td>
            </tr>
            <tr>
                <td style="width: 50%">
                    <span style="font-size: 12px; font-weight:bold">2</span>
                    Destinatar (nume, adresa, tara)
                    |
                    Consigner (name, address, country)
                    |
                    Destinataire (nom, adresse, pays)
                    <br>
                    <h2 style="text-align:center; margin:0px">
                        {{ $rezervare->colete_nume_destinatar }},
                        {{ $rezervare->colete_adresa_destinatar }},
                        {{ $rezervare->oras_sosire_nume}},
                        {{ $rezervare->oras_sosire_tara}}
                    </h2>
                </td>
                <td rowspan="2" style="width: 50%">
                    <span style="font-size: 12px; font-weight:bold">16</span>
                    Operator de transport (nume, adresa, tara)
                    <br>
                    Carrier (name, address, country)
                    <br>
                    Transporteur (nom, adresse, pays)
                    <br>

                    <div style="border: 1px solid black; width: 85%; text-align:center; margin:auto">
                        MRW88 MAXARMONY S.R.L., Ceardac - Vrancea, România
                        <br>
                        CIF: RO 35059906, ORC J 39/570/2015
                    </div>

                    <span style="font-size: 12px; font-weight:bold">17</span>
                    Transportatori succesivi (nume, adresa, tara)
                    <br>
                    Succesive carriers (name, address, country)
                    <br>
                    Transporteur successifs (nom, adresse, pays)
                </td>
            </tr>
            <tr>
                <td style="width: 50%">
                    <span style="font-size: 12px; font-weight:bold">3</span>
                    Locul descarcarii (loc, tara)
                    |
                    Place of delivery of the goods (place, country)
                    |
                    Lieu prevu pour la livraison de la merchandise (lieu, pays)
                    <br>
                    <h2 style="text-align:center; margin:0px">
                        {{ $rezervare->colete_adresa_destinatar }},
                        {{ $rezervare->oras_sosire_nume }},
                        {{ $rezervare->oras_sosire_tara }}
                    </h2>
                </td>
            </tr>
            <tr>
                <td style="width: 50%">
                    <span style="font-size: 12px; font-weight:bold">4</span>
                    Locul incarcarii (loc, tara, data)
                    <br>
                    Place and date of taking over the goods (place, country, date)
                    <br>
                    Lieu et date de la prise en charge de la merchandise (lieu, pays, date)
                    <br>
                    <h2 style="text-align:center; margin:0px">
                        {{ $rezervare->adresa }},
                        {{ $rezervare->oras_plecare_nume }},
                        {{ $rezervare->oras_plecare_tara }}
                    </h2>
                </td>
                <td rowspan="2" style="width: 50%">
                    <span style="font-size: 12px; font-weight:bold">18</span>
                    Rezerve si observatii ale transportatorilor
                    |
                    Carrier's reservation and observations
                    |
                    Reserves et observations du transporteur
                    <br>
                    <span style="font-size:12px">
                        AUTO NR.:
                        <br>
                        SEMIREMORCA NR.:
                        <br>
                        CONDUCATOR AUTO 1:
                        <br>
                        CONDUCATOR AUTO 2:
                    </span>
                </td>
            </tr>
            <tr>
                <td style="width: 50%">
                    <span style="font-size: 12px; font-weight:bold">5</span>
                    Documente anexate
                    |
                    Documents attached
                    |
                    Documents annexes
                </td>
            </tr>
        </table>
        <table>
            <tr style="">
                <td style="">
                    <table>
                        <tr>
                            <td style="width:10%; border-width:0px; padding:0px 1px">
                                <span style="font-size: 12px; font-weight:bold">6</span>
                                Marci si numere
                                <br>
                                Marks and Nos
                                <br>
                                Marques et numeros
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                            </td>
                            <td style="width:10%; border-width:0px; padding:0px 1px">
                                <span style="font-size: 12px; font-weight:bold">7</span>
                                Nr. de colete
                                <br>
                                Number of packages
                                <br>
                                Nombre de colis
                                <br>
                                <h2 style="">
                                    {{ $rezervare->colete_numar }}
                                </h2>
                            </td>
                            <td style="width:20%; border-width:0px; padding:0px 1px">
                                <span style="font-size: 12px; font-weight:bold">8</span>
                                Mod de ambalare
                                <br>
                                Method of packing
                                <br>
                                Mode d'emballage
                                <br>
                                <br>
                                {{ $rezervare->colete_mod_ambalare }}
                            </td>
                            <td style="width:20%; border-width:0px; padding:0px 1px">
                                <span style="font-size: 12px; font-weight:bold">9</span>
                                Natura marfii
                                <br>
                                Nature of the goods
                                <br>
                                Nature de la marchandise
                                <br>
                                <br>
                                {{ $rezervare->colete_natura_marfii }}
                            </td>
                            <td rowspan="2" style="width:10%; border-width:0px; border-left:1px; padding:0px 1px">
                                <span style="font-size: 12px; font-weight:bold">10</span>
                                Numar statistic
                                <br>
                                Statistical number
                                <br>
                                No statistique
                                <br>
                                <h2 style="">
                                    {{ $rezervare->id }}
                                </h2>
                            </td>
                            <td rowspan="2" style="width:12%; border-width:0px; border-left:1px; padding:0px 1px">
                                <span style="font-size: 12px; font-weight:bold">11</span>
                                <br>
                                Greutate bruta, kg
                                <br>
                                Gross weight, kg
                                <br>
                                Poids brut, kg
                                <br>
                                <br>
                                <h2 style="">
                                    {{ $rezervare->colete_kg }}
                                </h2>
                            </td>
                            <td rowspan="2" style="width:9%; border-width:0px; border-left:1px; padding:0px 1px">
                                <span style="font-size: 12px; font-weight:bold">12</span>
                                <br>
                                Cubaj, m<sup>3</sup>
                                <br>
                                Volume, m<sup>3</sup>
                                <br>
                                Cubage, m<sup>3</sup>
                                <br>
                                <br>
                                <br>
                                <h2 style="margin:0px; padding:0px">
                                    {{ $rezervare->colete_volum }}
                                </h2>
                            </td>
                        </tr>
                        <tr style="">
                            <td colspan="4">
                                <table>
                                    <tr style="margin:0px; padding:0px">
                                        <td style="border-width:0px; margin:0px; padding:0px">
                                            Clasa
                                            <br>
                                            Classe
                                            <br>
                                            La classe
                                        </td>
                                        <td style="border-width:0px; margin:0px; padding:0px">
                                            Cifra
                                            <br>
                                            Number
                                            <br>
                                            La chifre
                                        </td>
                                        <td style="border-width:0px; margin:0px; padding:0px">
                                            Litera
                                            <br>
                                            Letter
                                            <br>
                                            La lettre
                                        </td>
                                        <td style="border-width:0px;">
                                            (ADR*)
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td rowspan="5">
                    <span style="font-size: 12px; font-weight:bold">13</span>
                    Instructiunile expeditorului
                    <br>
                    Sender's instructions
                    <br>
                    Instructions de l'expediteur
                </td>
                <td colspan="4">
                    <span style="font-size: 12px; font-weight:bold">19</span>
                    Conventii speciale
                    <br>
                    Special agreements
                    <br>
                    Conventions particuliers
                    <br>
                    <br>
                    <br>
                </td>
            </tr>
            <tr>
                <td>
                    <span style="font-size: 12px; font-weight:bold">20</span>
                    Plata prin
                    <br>
                    To be paid by
                    <br>
                    A payer par
                </td>
                <td>
                    Expeditor
                    <br>
                    Sender
                    <br>
                    Expediteur
                </td>
                <td>
                    Moneda
                    <br>
                    Currency
                    <br>
                    Monnaie
                </td>
                <td>
                    Destinatar
                    <br>
                    Consignee
                    <br>
                    Destinataire
                </td>
            </tr>
            <tr>
                <td>
                    Pret transport
                    <br>
                    Carriage changes
                    <br>
                    Prix de transport
                </td>
                <td>

                </td>
                <td>

                </td>
                <td>

                </td>
            </tr>
            <tr>
                <td>
                    Sold/Balance/Solde
                </td>
                <td>

                </td>
                <td>

                </td>
                <td>

                </td>
            </tr>
            <tr>
                <td>
                    Taxe suplimentare
                    <br>
                    Additional charges
                    <br>
                    Supplements
                </td>
                <td>

                </td>
                <td>

                </td>
                <td>

                </td>
            </tr>
            <tr>
                <td rowspan="2">
                    <span style="font-size: 12px; font-weight:bold">14</span>
                    Instructiuni de plata / Payment instructions / Instructions de paiement
                    <br>
                    <br>
                    <label style="display: inline-block">
                        <input style="vertical-align: middle"
                                    type="checkbox" />
                        <span style="vertical-align: middle">
                            Plata la expediere / Payment upon shipment / Paiement à l'expédition
                        </span>
                    </label>
                    <br>
                    <label style="display: inline-block">
                        <input style="vertical-align: middle"
                                    type="checkbox" />
                        <span style="vertical-align: middle">
                            Plata la destinatie / Payment at destination / Paiement à destination
                        </span>
                    </label>
                </td>
                <td>
                    Alte taxe
                    <br>
                    Other charges
                    <br>
                    Autres taxes
                </td>
                <td>

                </td>
                <td>

                </td>
                <td>

                </td>
            </tr>
            <tr>
                <td>
                    Total
                </td>
                <td>

                </td>
                <td>

                </td>
                <td>

                </td>
            </tr>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td style="border-width:0px; width:60%">
                                <span style="font-size: 12px; font-weight:bold">21</span>
                                Intocmit in / Drafted in / Redige en
                                <h2 style="margin:0px">
                                    {{ $rezervare->adresa }},
                                    {{ $rezervare->oras_plecare_nume }},
                                    {{ $rezervare->oras_plecare_tara }}
                                </h2>
                            </td>
                            <td style="border-width:0px">
                                data / on / la
                                <h2 style="margin:0px">
                                    {{ $rezervare->data_cursa ? \Carbon\Carbon::parse($rezervare->data_cursa)->isoFormat('DD.MM.YYYY') : '' }}
                                </h2>
                            </td>
                        </tr>
                    </table>
                </td>
                <td colspan="4">
                    <span style="font-size: 12px; font-weight:bold">15</span>
                        Suma de plata / Payment amount / Montant du paiement
                        <h2 style="margin:0px; text-align:center">
                            {{ $rezervare->pret_total }} Euro
                        </h2>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width:33%">
                    <span style="font-size: 12px; font-weight:bold">22</span>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                    Semnatura si stampila expeditorului
                    <br>
                    Signature and stamp of the sender
                    <br>
                    Signature et timbre de l'expediteur
                </td>
                <td style="width:34%">
                        {{-- <div style="text-align:center; padding-top:1px">
                            <img style=""
                                src="{{ asset('images/stampila_semnatura_mrw.jpg') }}" width="80px">
                        </div>
                        <div style="position: relative; bottom: 15px; left: 0px;">
                            Semnatura si stampila transportatorului
                            <br>
                            Signature and stamp of the carrier
                            <br>
                            Signature et timbre du transporteur
                        </div> --}}

<div style="position: relative; width: 100%; margin: auto; padding-top:1px">
                    <span style="font-size: 12px; font-weight:bold; float:left">23</span>
    <img src="{{ asset('images/stampila_semnatura_mrw.jpg') }}" style="position: absolute; left:120px; width: 120px; z-index: -1000;" />
    <div style="position: absolute; top: 70px; width: 100%;">
        Semnatura si stampila transportatorului
        <br>
        Signature and stamp of the carrier
        <br>
        Signature et timbre du transporteur
    </div>
</div>


                </td>
                <td style="width:33%">
                    <span style="font-size: 12px; font-weight:bold">24</span>
                    Receptia marfii / Receipt of goods / Réception des marchandises
                    <br>
                    <br>
                    <br>
                    Data / On / Le
                    <br>
                    <br>
                    Semnatura si stampila destinatar
                    <br>
                    Signature and stamp of the consignee
                    <br>
                    Signature et timbre du destinataire
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
