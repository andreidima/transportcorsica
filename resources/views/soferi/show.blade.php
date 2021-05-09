@extends ('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                    <h6 class="ml-4 my-0" style="color:white"><i class="fas fa-users"></i>Șoferi / {{ $sofer->nume }}</h6>
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
                                    {{ $sofer->nume }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Analize medicale
                                </td>
                                <td>
                                    {{ $sofer->analize_medicale ? \Carbon\Carbon::parse($sofer->analize_medicale)->isoFormat('DD.MM.YYYY') : null }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Permis
                                </td>
                                <td>
                                    {{ $sofer->permis ? \Carbon\Carbon::parse($sofer->permis)->isoFormat('DD.MM.YYYY') : null }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Buletin
                                </td>
                                <td>
                                    {{ $sofer->buletin ? \Carbon\Carbon::parse($sofer->buletin)->isoFormat('DD.MM.YYYY') : null }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Observații
                                </td>
                                <td>
                                    {{ $sofer->observatii }}
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="form-row mb-2 px-2">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <a class="btn btn-primary btn-sm rounded-pill" href="/soferi">Pagină Șoferi</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
