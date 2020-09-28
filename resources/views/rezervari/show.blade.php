@extends ('layouts.app')

@section('content')   
    <div class="container card">
        <div class="row card-header">
                <h4 class="mb-0"><a href="{{ route('rezervari.index') }}"><i class="fas fa-list-ul mr-1"></i>Rezervari</a> / {{ $rezervari->nume }}</h4>
        </div>

        <div class="card-body d-flex">

            @if (session()->has('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif

            <div class="table-responsive col-md-5 mx-auto">
                <table class="table table-striped table-hover table-dark table-sm" style="background-color:#008282"> 
                    <tr>
                        <td>
                            Nume
                        </td>
                        <td>
                            {{ $rezervari->nume }}
                        </td>
                    </tr>
                    </tr>
                        <td>
                            Telefon
                        </td>
                        <td>
                            {{ $rezervari->telefon }}
                        </td>
                    </tr>
                    </tr>
                        <td>
                            Email
                        </td>
                        <td>
                            {{ $rezervari->email }}
                        </td>
                    </tr>
                    </tr>
                        <td>
                            Adresa
                        </td>
                        <td>
                            {{ $rezervari->adresa }}
                        </td>
                    </tr>
                    </tr>
                        <td>
                            Observatii
                        </td>
                        <td>
                            {{ $rezervari->observatii }}
                        </td>
                    </tr>
                    </tr>
                        <td>
                            Document de călătorie
                        </td>
                        <td>
                            {{ $rezervari->document_de_calatorie }}
                        </td>
                    </tr>
                    </tr>
                        <td>
                            <small> Data expirării documentului</small>
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($rezervari->expirare_document)->isoFormat('D.MM.YYYY') }}
                        </td>
                    </tr>
                    </tr>
                        <td>
                            Seria buletin / pașaport
                        </td>
                        <td>
                            {{ $rezervari->serie_document }}
                        </td>
                    </tr>
                    </tr>
                        <td>
                            Cnp
                        </td>
                        <td>
                            {{ $rezervari->cnp }}
                        </td>
                    </tr>
                    </tr>
                        <td>
                            Data rezervarii
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($rezervari->created_at)->isoFormat('D.MM.YYYY') }}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="table-responsive col-md-3 mx-auto">
                <table class="table table-striped table-hover table-dark table-sm" style="background-color:#008282"> 
                    <tr>
                        <td>
                            Oras plecare
                        </td>
                        <td>
                            {{ $rezervari->oras_plecare_nume->nume }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Oras sosire
                        </td>
                        <td>
                            {{ $rezervari->oras_sosire_nume->nume }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Tur - retur
                        </td>
                        <td>
                            {{ $rezervari->tur_retur ? 'DA' : 'NU' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Data_plecare
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($rezervari->data_plecare)->isoFormat('D.MM.YYYY') }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Data_intoarcere
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($rezervari->data_intoarcere)->isoFormat('D.MM.YYYY') }}
                        </td>
                    </tr>
                        <td>
                            Nr. adulți
                        </td>
                        <td>
                            {{ $rezervari->nr_adulti }}
                        </td>
                    </tr>
                    </tr>
                        <td>
                            Nr. copii
                        </td>
                        <td>
                            {{ $rezervari->nr_copii }}
                        </td>
                    </tr>
                    {{-- </tr>
                        <td>
                            Nr. animale mici
                        </td>
                        <td>
                            {{ $rezervari->nr_animale_mici }}
                        </td>
                    </tr>
                    </tr>
                        <td>
                            Nr. animale mari
                        </td>
                        <td>
                            {{ $rezervari->nr_animale_mari }}
                        </td>
                    </tr> --}}
                    </tr>
                        <td>
                            Preț total
                        </td>
                        <td>
                            {{ $rezervari->pret_total }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection