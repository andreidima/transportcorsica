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
                Nr. ord. reg. com./an: J39/570/29.09.2015 <br>
                CIF: RO35059906 <br>
                Sediul: Str. Șoseaua Națională nr. 22, Et:1, Sat Ceardac, com. Golești, Județ Vrancea <br>
                Banca: Transilvania <br>
                Cod IBAN EURO: RO83BTRLEURCRT0319122801 <br>
                Cod IBAN LEI: RO36BTRLRONCRT0319122801 <br>
            </p>

            <h2 style="margin:5px">BILET DE CĂLĂTORIE</h2>
            
            Seria și număr: {{ $rezervare->bilet_serie }} {{ $rezervare->bilet_numar }} <br>
            Ruta: {{ $rezervare->oras_plecare_sofer ?? '' }} - {{ $rezervare->oras_sosire_sofer ?? '' }} <br><br><br>

            <h2 style="margin:5px">PREȚUL {{ $rezervare->valoare_lei + $rezervare->valoare_lei_tva }} lei</h2>
            <br>
            Păstrați biletul pentru control
            
             
        </div>
    </div>
</body>
</html>