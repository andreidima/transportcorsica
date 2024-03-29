@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header justify-content-between py-1" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3 align-self-center mb-2">
                <h4 class=" mb-0">
                    <a href="{{ route('rezervari.index') }}"><i class="fas fa-address-card mr-1"></i>Rezervări</a>
                </h4>
            </div>
            <div class="col-lg-6" id="app1">
                <form class="needs-validation" novalidate method="GET" action="{{ route('rezervari.index') }}">
                    @csrf
                    <div class="row input-group custom-search-form justify-content-center">
                        <div class="col-md-4 mb-2 px-1 d-flex align-items-center">
                            <input type="text" class="form-control form-control-sm border rounded-pill mb-0 py-0"
                            id="search_nume" name="search_nume" placeholder="Client"
                                    value="{{ $search_nume }}">
                        </div>
                        <div class="col-md-2 mb-2 px-1 d-flex align-items-center">
                            <input type="text" class="form-control form-control-sm border rounded-pill mb-0 py-0"
                            id="search_bilet_numar" name="search_bilet_numar" placeholder="Nr. bilet"
                                    value="{{ $search_bilet_numar }}">
                        </div>
                        <div class="col-md-4 mb-2 px-1 d-flex align-items-center">
                            <label for="search_data" class="mb-0 align-self-center mr-1">Data:</label>
                            <vue2-datepicker
                                data-veche="{{ $search_data }}"
                                nume-camp-db="search_data"
                                :latime="{ width: '125px' }"
                                tip="date"
                                value-type="YYYY-MM-DD"
                                format="DD-MM-YYYY"
                                {{-- not-before-date="{{ \Carbon\Carbon::today() }}" --}}
                                {{-- :doar-ziua-a="2"
                                :doar-ziua-b="5" --}}
                            ></vue2-datepicker>
                        </div>
                    </div>
                    <div class="row input-group custom-search-form justify-content-center">
                        <div class="col-md-4 mb-2 px-1 d-flex align-items-center">
                            <button class="btn btn-sm btn-primary col-md-12 border border-dark rounded-pill" type="submit">
                                <i class="fas fa-search text-white mr-1"></i>Caută
                            </button>
                        </div>
                        <div class="col-md-4 mb-2 px-1 d-flex align-items-center">
                            <a class="btn btn-sm bg-secondary text-white col-md-12 border border-dark rounded-pill" href="{{ route('rezervari.index') }}" role="button">
                                <i class="far fa-trash-alt text-white mr-1"></i>Resetează căutarea
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 text-right align-self-center">
                <a class="btn btn-sm bg-success text-white border border-dark rounded-pill col-md-8" href="{{ route('adauga-rezervare-noua') }}" role="button">
                    <i class="fas fa-plus-square text-white mr-1"></i>Adaugă rezervare
                </a>
            </div>
        </div>

        <div class="card-body px-0 py-3">

            @include('errors')

            <div class="table-responsive rounded mb-2">
                <table class="table table-striped table-hover table-sm rounded">
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th>Nr. Crt.</th>
                            <th>Nume</th>
                            <th>Telefon</th>
                            <th>Nr. pers.</th>
                            <th>Oraș plecare</th>
                            <th>Oraș sosire</th>
                            <th>Data cursă</th>
                            <th class="text-center">Tur retur</th>
                            {{-- <th>Pret</th> --}}
                            <th class="text-center">Plătit</th>
                            <th class="">Utilizator</th>
                            <th class="text-center">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rezervari as $rezervare)
                            <tr>
                                <td align="">
                                    {{ ($rezervari ->currentpage()-1) * $rezervari ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    <a href="{{ $rezervare->path() }}">
                                        {{-- <b>{{ $rezervare->nume ?? $rezervare->pasageri_relation->first()->nume ?? '' }}</b> --}}
                                        @isset($rezervare->nr_adulti)
                                            @foreach ($rezervare->pasageri_relation as $pasager)
                                                @if(!$loop->last)
                                                    @if (in_array($pasager->nume, $clienti_neseriosi))
                                                        <span class="text-danger">
                                                            {{ $pasager->nume }}
                                                            (client neserios:
                                                            {{ \App\Models\ClientNeserios::where('nume', $pasager->nume)->first()->observatii ?? '-'}}),
                                                        </span>
                                                    @else
                                                        {{ $pasager->nume }},
                                                    @endif
                                                @else
                                                    @if (in_array($pasager->nume, $clienti_neseriosi))
                                                        <span class="text-danger">
                                                            {{ $pasager->nume }}
                                                            (client neserios:
                                                            {{ \App\Models\ClientNeserios::where('nume', $pasager->nume)->first()->observatii ?? '-'}})
                                                        </span>
                                                    @else
                                                        {{ $pasager->nume }}
                                                    @endif
                                                @endif
                                            @endforeach
                                        @else
                                            {{ $rezervare->nume }} - colete
                                        @endif
                                    </a>
                                </td>
                                <td>
                                    {{ $rezervare->telefon }}
                                    {{-- {{ $rezervare->factura()->count() }}
                                    <br>
                                    {{ $rezervare->factura_valida()->count() }} --}}
                                    {{-- @if (count($rezervare->factura()))
                                        sunt facturi
                                    @else
                                        nu exista facturi
                                    @endif --}}
                                </td>
                                <td>
                                    {{ $rezervare->nr_adulti + $rezervare->nr_copii }}
                                </td>
                                <td>
                                    {{ $rezervare->oras_plecare_nume->oras ?? ''}}
                                </td>
                                <td>
                                    {{ $rezervare->oras_sosire_nume->oras ?? ''}}
                                </td>
                                <td>
                                    {{ $rezervare->data_cursa ? \Carbon\Carbon::parse($rezervare->data_cursa)->isoFormat('DD.MM.YYYY') : '' }}
                                </td>
                                <td class="text-center">
                                    {{ $rezervare->retur_relation ? \Carbon\Carbon::parse($rezervare->retur_relation->data_cursa)->isoFormat('DD.MM.YYYY') : 'NU' }}
                                    {{-- @if ($rezervare->retur)
                                        @if (\App\Models\Rezervare::find($rezervare->retur)->data_cursa ?? false)
                                            {{ \Carbon\Carbon::parse(\App\Models\Rezervare::find($rezervare->retur)->data_cursa)->isoFormat('DD.MM.YYYY') }}
                                        @endif
                                    @else
                                        NU
                                    @endif                                     --}}
                                </td>
                                {{-- <td>
                                    {{ $rezervare->pret_total }}
                                </td> --}}
                                <td class="text-center">
                                    @if($rezervare->plata_efectuata === 1)
                                        <span class="text-success"
                                            title="{{ $rezervare->plataOnlineUltima->mesaj_personalizat ?? '' }}"
                                        >
                                            DA
                                        </span>
                                    @else
                                        <span class="text-danger">NU</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $rezervare->user->name ?? 'SITE'}}
                                </td>
                                <td class="text-right">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ $rezervare->path() }}/modifica"
                                            class="flex mr-1"
                                        >
                                            <span class="badge badge-primary">Modifică</span>
                                        </a>
                                        <a href="{{ $rezervare->path() }}"
                                            class="flex mr-1"
                                        >
                                            <span class="badge badge-success">Vizualizează</span>
                                        </a>
                                    {{-- @if ((auth()->user()->role === 'administrator') || (auth()->user()->role === 'superadmin')) --}}
                                        <a href="{{ $rezervare->path() }}/duplica"
                                            class="flex mr-1"
                                        >
                                            <span class="badge badge-secondary">Duplică</span>
                                        </a>
                                    {{-- @endif --}}
                                        <div style="" class="mr-1">
                                            <a
                                                href="#"
                                                data-toggle="modal"
                                                data-target="#neseriosiRezervare{{ $rezervare->id }}"
                                                title="Clienți neserioși"
                                                >
                                                <span class="badge badge-danger">Neserioși</span>
                                            </a>
                                        </div>
                                        <div style="" class="">
                                            <a
                                                href="#"
                                                data-toggle="modal"
                                                data-target="#stergeRezervare{{ $rezervare->id }}"
                                                title="Șterge Rezervare"
                                                >
                                                <span class="badge badge-danger">Șterge</span>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            {{-- @foreach ($rezervare->pasageri_relation as $pasager)
                                @if (in_array($pasager->nume, $clienti_neseriosi))
                                    <tr>
                                        <td colspan="11" class="text-danger">
                                            Client neserios:
                                            {{ \App\Models\ClientNeserios::where('nume', $pasager->nume)->first()->observatii ?? '-'}})
                                        </td>
                                    </tr>
                                @endif
                            @endforeach --}}
                        @empty
                            {{-- <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div> --}}
                        @endforelse
                        </tbody>
                </table>
            </div>

                <nav>
                    <ul class="pagination pagination-sm justify-content-center">
                        {{$rezervari->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>


    {{-- Modalele --}}
                        @forelse ($rezervari as $rezervare)
                                                {{-- Modal pentru butonul de neseriosi --}}
                                                <div class="modal fade text-dark" id="neseriosiRezervare{{ $rezervare->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header bg-danger">
                                                            <h5 class="modal-title text-white" id="exampleModalLabel">
                                                                Rezervare:
                                                                <b>
                                                                    @isset($rezervare->nr_adulti)
                                                                        @foreach ($rezervare->pasageri_relation as $pasager)
                                                                            @if(!$loop->last)
                                                                                {{ $pasager->nume }},
                                                                            @else
                                                                                {{ $pasager->nume }}
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        {{ $rezervare->nume }} - colete
                                                                    @endif
                                                                </b>
                                                            </h5>
                                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                    <form method="POST" action="{{ route('insereaza-pasageri-neseriosi', ['rezervare' => $rezervare->id]) }}">
                                                        {{-- @method('DELETE')   --}}
                                                        @csrf

                                                        <div class="modal-body" style="text-align:left;">
                                                            <p>
                                                                Ești sigur ca vrei să adaugi pasagerii în lista de Clienți neserioși?
                                                            </p>

                                                            <div class="form-row">
                                                                <div class="form-group col-lg-12">
                                                                    <label for="observatii" class="mb-0 pl-3">Observații:</label>
                                                                    <textarea class="form-control {{ $errors->has('observatii') ? 'is-invalid' : '' }}"
                                                                        name="observatii"
                                                                        rows="2"
                                                                    >{{ old('observatii') }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>
                                                                <button
                                                                    type="submit"
                                                                    class="btn btn-danger"
                                                                    >
                                                                    Adaugă
                                                                </button>
                                                        </div>
                                                    </form>
                                                        </div>
                                                    </div>
                                                </div>


                                                {{-- Modal pentru butonul de stergere --}}
                                                <div class="modal fade text-dark" id="stergeRezervare{{ $rezervare->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                                                    {{-- data-backdrop="false" --}}
                                                >
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header bg-danger">
                                                            <h5 class="modal-title text-white" id="exampleModalLabel">
                                                                Rezervare:
                                                                <b>
                                                                    @isset($rezervare->nr_adulti)
                                                                        @foreach ($rezervare->pasageri_relation as $pasager)
                                                                            @if(!$loop->last)
                                                                                {{ $pasager->nume }},
                                                                            @else
                                                                                {{ $pasager->nume }}
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        {{ $rezervare->nume }} - colete
                                                                    @endif
                                                                </b>
                                                            </h5>
                                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" style="text-align:left;">
                                                            Ești sigur ca vrei să ștergi Rezervarea?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>

                                                            <form method="POST" action="{{ $rezervare->path() }}">
                                                                @method('DELETE')
                                                                @csrf
                                                                <button
                                                                    type="submit"
                                                                    class="btn btn-danger"
                                                                    >
                                                                    Șterge Rezervarea
                                                                </button>
                                                            </form>

                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                        @empty
                            {{-- <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div> --}}
                        @endforelse
@endsection
