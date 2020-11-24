<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Bilet</title>
    <style>
        html { 
            margin: 5px 12px 0px 12px;
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
        width:250px;
        margin:0px 0px;
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
            border-radius: 10px;
        text-align:center
        ">
            MRW88 MAXARMONY S.R.L. <br>
            <h2 style="margin:5px">BILET DE CĂLĂTORIE</h2>
            
            Seria: MRW <br>
            Nr. {{ $rezervare->id }} <br>
            Ruta: {{ $rezervare->oras_plecare ?? '' }} - {{ $rezervare->oras_sosire ?? '' }} <br><br><br>

            <h2 style="margin:5px">PREȚUL {{ $rezervare->valoare_lei + $rezervare->valoare_lei_tva }} lei</h2>
            <br>
            Păstrați biletul pentru control
            
             
        </div>
    </div>
</body>
</html>