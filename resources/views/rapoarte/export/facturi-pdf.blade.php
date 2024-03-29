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
        @php
            $total_facturi = 0;
        @endphp
            @foreach($rezervari as $rezervare)
                    @forelse ($rezervare->facturi as $factura)
                        @if (($total_facturi += 1) > 1)
                            <div style="page-break-after: always;">
                            </div>
                        @endif

                            <div style="
                                    width:720px;
                                    padding: 50px 35px 50px 35px;
                                    margin:0px 0px;
                                        -moz-border-radius: 10px;
                                        -webkit-border-radius: 10px;
                                        border-radius: 10px;
                                        ">
                                @include('facturi.export.factura', ['factura' => $factura])
                            </div>
                    @empty
                    @endforelse

            @endforeach

                @if ($total_facturi === 0)
                    <div style="
                            width:720px;
                            padding: 50px 35px 50px 35px;
                            margin:0px 0px;
                                -moz-border-radius: 10px;
                                -webkit-border-radius: 10px;
                                border-radius: 10px;
                                ">
                        <h1>
                            Nu exista facturi generate pentru aceasta cursa!
                        </h1>
                    </div>
                @endif
</body>
</html>
