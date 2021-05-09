@extends ('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                    <h6 class="ml-4 my-0" style="color:white"><i class="fas fa-bus"></i>Mașini / {{ $masina->nume }}</h6>
                </div>

                <div class="card-body py-2 border border-secondary"
                    style="border-radius: 0px 0px 40px 40px;"
                >

            @include ('errors')

                    <div class="table-responsive col-md-12 mx-auto">
                        <table class="table table-sm table-striped table-hover"
                                {{-- style="background-color:#008282" --}}
                        >
                            <tr>
                                <td>
                                    Nume
                                </td>
                                <td>
                                    {{ $masina->nume }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Număr auto
                                </td>
                                <td>
                                    {{ $masina->numar_auto }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    ITP
                                </td>
                                <td>
                                    {{ $masina->itp ? \Carbon\Carbon::parse($masina->itp)->isoFormat('DD.MM.YYYY') : null }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Asigurare RCA
                                </td>
                                <td>
                                    {{ $masina->asigurare_rca ? \Carbon\Carbon::parse($masina->asigurare_rca)->isoFormat('DD.MM.YYYY') : null }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Asigurări pers/colete
                                </td>
                                <td>
                                    {{ $masina->asigurari_persoane_colete ? \Carbon\Carbon::parse($masina->asigurari_persoane_colete)->isoFormat('DD.MM.YYYY') : null }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Licență
                                </td>
                                <td>
                                    {{ $masina->licenta ? \Carbon\Carbon::parse($masina->licenta)->isoFormat('DD.MM.YYYY') : null }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Clasificare
                                </td>
                                <td>
                                    {{ $masina->clasificare ? \Carbon\Carbon::parse($masina->clasificare)->isoFormat('DD.MM.YYYY') : null }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Verificare tahograf
                                </td>
                                <td>
                                    {{ $masina->verificare_tahograf ? \Carbon\Carbon::parse($masina->verificare_tahograf)->isoFormat('DD.MM.YYYY') : null }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Rovinietă România
                                </td>
                                <td>
                                    {{ $masina->rovinieta_romania ? \Carbon\Carbon::parse($masina->rovinieta_romania)->isoFormat('DD.MM.YYYY') : null }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Rovinietă Ungaria
                                </td>
                                <td>
                                    {{ $masina->rovinieta_ungaria ? \Carbon\Carbon::parse($masina->rovinieta_ungaria)->isoFormat('DD.MM.YYYY') : null }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Rovinietă Slovenia
                                </td>
                                <td>
                                    {{ $masina->rovinieta_slovenia ? \Carbon\Carbon::parse($masina->rovinieta_slovenia)->isoFormat('DD.MM.YYYY') : null }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Revizie
                                </td>
                                <td>
                                    {{ $masina->revizie ? \Carbon\Carbon::parse($masina->revizie)->isoFormat('DD.MM.YYYY') : null }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Observații
                                </td>
                                <td>
                                    {{ $masina->observatii }}
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="form-row mb-2 px-2">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <a class="btn btn-primary btn-sm rounded-pill" href="/masini">Pagină Mașini</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
