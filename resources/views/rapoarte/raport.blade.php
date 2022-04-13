@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header justify-content-between py-1" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3 align-self-center mb-2">
                <h4 class=" mb-0">
                    {{-- @php
                        dd($view_type);
                    @endphp --}}
                        <a href="/rapoarte/{{ $tip_transport }}/{{ $view_type }}"><i class="fas fa-book mr-1"></i>Rapoarte {{ $view_type }}</a>
                </h4>
            </div>
            <div class="col-lg-7" id="app1">
                @if ($view_type === "plecare")
                    <form class="needs-validation" novalidate method="GET" action="/rapoarte/{{ $tip_transport }}/plecare">
                @elseif ($view_type === "sosire")
                    <form class="needs-validation" novalidate method="GET" action="/rapoarte/{{ $tip_transport }}/sosire">
                @endif
                    @csrf
                    <div class="row mb-2 input-group custom-search-form justify-content-center" style="border-bottom:2px solid black">
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
                                :doar-ziua-a="3"
                                :doar-ziua-b="6"
                            ></vue2-datepicker>
                        </div>
                    {{-- </div>
                    <div class="row input-group custom-search-form justify-content-center"> --}}
                        <div class="col-md-4 mb-2 px-1 d-flex align-items-center">
                            <button class="btn btn-sm btn-primary col-md-12 border border-dark rounded-pill" type="submit">
                                <i class="fas fa-search text-white mr-1"></i>Caută
                            </button>
                        </div>
                        <div class="col-md-4 mb-2 px-1 d-flex align-items-center">
                            <a class="btn btn-sm bg-secondary text-white col-md-12 border border-dark rounded-pill" href="/rapoarte/{{ $tip_transport }}/{{ $view_type }}" role="button">
                                <i class="far fa-trash-alt text-white mr-1"></i>Resetează căutarea
                            </a>
                        </div>
                    </div>
                </form>
            @if ($rezervari->count() > 0)
                <form class="needs-validation" novalidate method="POST" action="/rapoarte/{{ $tip_transport }}/muta-rezervari">
                    @csrf

                    <div class="row input-group custom-search-form justify-content-center">
                                <div class="col-lg-6 px-0 mb-2 d-flex align-items-center">
                                    <label class="mb-0">Mută rezervările traseului:</label>
                                    <input type="text" class="form-control form-control-sm border rounded-pill mb-0 py-0 mx-2 {{ $errors->has('traseu') ? 'is-invalid' : '' }}"
                                        id="traseu" name="traseu" placeholder=""
                                            style="width:50px"
                                            value="{{ old('traseu') }}">
                                </div>
                                <div class="col-lg-3 px-0 mb-2 d-flex align-items-center">
                                    în lista:
                                    <input type="text" class="form-control form-control-sm border rounded-pill mb-0 py-0 mx-2 {{ $errors->has('lista') ? 'is-invalid' : '' }}"
                                        id="lista" name="lista" placeholder=""
                                            style="width:50px"
                                            value="{{ old('lista') }}">
                                    <input type="hidden" name="data_cursa" value="{{ $search_data }}">
                                    @if ($view_type === "plecare")
                                        <input type="hidden" name="tip_lista" value="lista_plecare">
                                    @elseif ($view_type === "sosire")
                                        <input type="hidden" name="tip_lista" value="lista_sosire">
                                    @endif
                                </div>
                                <div class="col-lg-3 px-0 mb-2">
                                    <button class="btn btn-sm btn-primary col-md-12 border border-dark rounded-pill" type="submit">
                                        <i class="fas fa-exchange-alt text-white mr-1"></i>Mută
                                    </button>
                                </div>
                    </div>
                </form>
            @endif
            </div>
            {{-- <div class="col-lg-3 text-right align-self-center">
                <a class="btn btn-sm bg-success text-white border border-dark rounded-pill col-md-8" href="{{ route('rezervari.create') }}" role="button">
                    <i class="fas fa-plus-square text-white mr-1"></i>Adaugă rezervare
                </a>
            </div>  --}}
        </div>

        <div class="card-body px-0 py-3">

            @include('errors')

        @if ($view_type === "plecare")
            @foreach ($rezervari->groupBy('oras_plecare_tara') as $rezervari_pe_tara)

                <div class="table-responsive-sm rounded mb-5">
                    <table class="table table-striped table-hover table-sm rounded">
                        <thead class="text-white rounded" style="background-color:#e66800;">
                            <tr>
                                <th colspan="6" class="text-center" style="font-size: 20px">
                                    Liste plecare
                                    {{ $rezervari_pe_tara->first()->oras_plecare_tara }}
                                </th>
                            </tr>
                            {{-- Lista Nava finala completa - Array pentru scoaterea tuturor rezervarilor pe tara --}}
                            @php
                                $rezervari_toate_pe_tara = [];
                            @endphp

                                @if ( $tip_transport === 'calatori')
                                    <tr>
                                        <td colspan="6" class="py-1">
                                            <div class="d-flex flex-row justify-content-center">
                                                <div class="mr-4">
                                                    <b>
                                                        Total pasageri în toate listele:
                                                        {{ $rezervari_pe_tara->sum('nr_adulti') + $rezervari_pe_tara->sum('nr_copii') }}
                                                    </b>
                                                </div>
                                                <div class="mr-4">
                                                    <a href="/rapoarte/excel-nava/{{ $rezervari_pe_tara->first()->oras_plecare_tara }}/{{ \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') }}/toate/lista_plecare/{{ $tip_transport }}/extrage-rezervari/raport-pdf" class="btn btn-sm bg-success text-white border border-light rounded-pill">
                                                        <i class="fas fa-file-pdf text-white mr-1"></i>Raport Navă
                                                        {{-- Iphone --}}
                                                    </a>
                                                    <a href="/rapoarte/excel-fara-nava/{{ $rezervari_pe_tara->first()->oras_plecare_tara }}/{{ \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') }}/toate/lista_plecare/{{ $tip_transport }}/extrage-rezervari/raport-pdf" class="btn btn-sm bg-success text-white border border-light rounded-pill">
                                                        <i class="fas fa-file-pdf text-white mr-1"></i>Raport fără Navă
                                                        {{-- Iphone --}}
                                                    </a>
                                                @if ((auth()->user()->role === 'administrator') || (auth()->user()->role === 'superadmin'))
                                                    @php
                                                        $lista = "toate";
                                                        $tip_lista = "toate";
                                                    @endphp
                                                    <a
                                                        class="btn btn-sm bg-warning border border-light rounded-pill" style="color: black !important"
                                                        href="#"
                                                        data-toggle="modal"
                                                        data-target="#trimite-sms-toate"
                                                        title="Trimite SMS"
                                                        >
                                                        <i class="fas fa-sms mr-1"></i>Trimite SMS
                                                    </a>
                                                    {{-- <a href="/rapoarte/trimite-sms/{{ $rezervari_pe_tara->first()->oras_plecare_tara }}/{{ \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') }}/toate/lista_plecare/{{ $tip_transport }}/extrage-rezervari/raport-pdf" class="btn btn-sm bg-warning border border-light rounded-pill" style="color: black !important">
                                                        <i class="fas fa-sms mr-1"></i>Trimite SMS

                                                    </a> --}}
                                                @endif
                                                </div>
                                                {{-- <div class="">
                                                    <form class="needs-validation" novalidate method="POST" action="/rapoarte/extrage-rezervari/raport-pdf">
                                                        @csrf

                                                        @foreach ($rezervari_toate_pe_tara as $rezervare_nava)
                                                            <input type="hidden" name="rezervari[]" value="{{ $rezervare_nava }}">
                                                        @endforeach
                                                                <input type="hidden" name="tip_lista" value="lista_plecare">
                                                            <button type="submit" name="action" value="excel_nava" class="btn btn-sm bg-success text-white border border-light rounded-pill">
                                                                <i class="fas fa-file-pdf text-white mr-1"></i>Raport Navă
                                                            </button>
                                                    </form>
                                                </div> --}}
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="6" class="py-1">
                                            <div class="d-flex flex-row justify-content-center">
                                                <div class="">
                                                    <b>
                                                        Total colete în toate listele:
                                                        {{ $rezervari_pe_tara->sum('colete_numar') }}
                                                    </b>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            <tr class="" style="padding:2rem">
                                <th class="w-25">Pasageri</th>
                                <th class="text-center">Traseu</th>
                                <th class="">Oraș plecare/ sosire</th>
                                <th class="text-center">
                                    {{ $tip_transport === 'calatori' ? 'Nr. pers.' : 'Nr. colete' }}
                                </th>
                                <th class="text-center">Mutare</th>
                                <th class="text-right">Acțiuni</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($rezervari_pe_tara->where('oras_plecare_tara', $rezervari_pe_tara->first()->oras_plecare_tara)->sortBy('lista_plecare')->groupBy('lista_plecare') as $rezervari_pe_trasee)
                                    <tr>
                                        <td colspan="2" class="text-white" style="background-color:lightslategrey">
                                            <b>
                                                {{-- <a class="btn btn-sm btn-light" data-toggle="collapse"
                                                    href="#collapseLista{{$rezervari_pe_trasee->first()->lista_plecare}}"
                                                    role="button"
                                                    aria-expanded="false"
                                                    aria-controls="collapseLista{{$rezervari_pe_trasee->first()->lista_plecare}}"> --}}
                                                        Lista {{$rezervari_pe_trasee->first()->lista_plecare}}
                                                {{-- </a> --}}
                                            </b>
                                        </td>
                                        <td colspan="4" class="text-right" style="background-color:lightslategrey">
                                            <div class="align-right">
                                                <form class="needs-validation" novalidate method="POST" action="/rapoarte/extrage-rezervari/raport-pdf">
                                                    @csrf

                                                        @forelse (
                                                                ($rezervari_pe_tara->first()->oras_plecare_tara === 'Romania' ?
                                                                    $rezervari_pe_trasee->sortBy('oras_plecare_traseu')->groupBy('oras_plecare_traseu')
                                                                    :
                                                                    $rezervari_pe_trasee->sortByDesc('oras_plecare_traseu')->groupBy('oras_plecare_traseu')
                                                                )
                                                                as $rezervari_pe_trasee_pe_traseu_initial)
                                                            @forelse (
                                                                    ($rezervari_pe_tara->first()->oras_plecare_tara === 'Romania' ?
                                                                        $rezervari_pe_trasee_pe_traseu_initial->sortBy('oras_plecare_ordine')->groupBy('oras_plecare_ordine')
                                                                        :
                                                                        $rezervari_pe_trasee_pe_traseu_initial->sortByDesc('oras_plecare_ordine')->groupBy('oras_plecare_ordine')
                                                                    )
                                                                    as $rezervari_pe_trasee_pe_traseu_initial_pe_oras)
                                                                @forelse ($rezervari_pe_trasee_pe_traseu_initial_pe_oras->sortBy('oras_plecare_nume') as $rezervare)
                                                                    @php
                                                                        $rezervari_toate_pe_tara[] = $rezervare->id;
                                                                    @endphp
                                                                    <input type="hidden" name="rezervari[]" value="{{ $rezervare->id }}">
                                                                @endforeach
                                                            @endforeach
                                                        @endforeach
                                                            <input type="hidden" name="tip_lista" value="lista_plecare">
                                                            {{-- @php
                                                                dd(auth()->user());
                                                            @endphp --}}
                                                        {{-- @if (auth()->user()->email === "adima@validsoftware.ro") --}}
                                                            <a href="/rapoarte/lista_sofer/{{ $rezervari_pe_tara->first()->oras_plecare_tara }}/{{ \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') }}/{{ $rezervari_pe_trasee->first()->lista_plecare }}/lista_plecare/{{ $tip_transport }}/extrage-rezervari/raport-pdf" class="btn btn-sm bg-success text-white border border-light rounded-pill">
                                                                <i class="fas fa-file-pdf text-white mr-1"></i>Raport PDF
                                                                {{-- Iphone --}}
                                                            </a>
                                                        {{-- @endif --}}
                                                        {{-- <button type="submit" name="action" value="lista_sofer" class="btn btn-sm bg-success text-white border border-light rounded-pill">
                                                            <i class="fas fa-file-pdf text-white mr-1"></i>Raport PDF
                                                        </button>  --}}
                                                    @if ( $tip_transport === 'calatori')
                                                        <a href="/rapoarte/lista_pasageri/{{ $rezervari_pe_tara->first()->oras_plecare_tara }}/{{ \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') }}/{{ $rezervari_pe_trasee->first()->lista_plecare }}/lista_plecare/{{ $tip_transport }}/extrage-rezervari/raport-pdf" class="btn btn-sm bg-success text-white border border-light rounded-pill">
                                                            <i class="fas fa-file-pdf text-white mr-1"></i>Listă pasageri
                                                            {{-- Iphone --}}
                                                        </a>
                                                        {{-- <button type="submit" name="action" value="lista_pasageri" class="btn btn-sm bg-success text-white border border-light rounded-pill">
                                                            <i class="fas fa-file-pdf text-white mr-1"></i>Listă pasageri
                                                        </button>  --}}
                                                        <a href="/rapoarte/excel-nava/{{ $rezervari_pe_tara->first()->oras_plecare_tara }}/{{ \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') }}/{{ $rezervari_pe_trasee->first()->lista_plecare }}/lista_plecare/{{ $tip_transport }}/extrage-rezervari/raport-pdf" class="btn btn-sm bg-success text-white border border-light rounded-pill">
                                                            <i class="fas fa-file-pdf text-white mr-1"></i>Raport Navă
                                                            {{-- Iphone --}}
                                                        </a>
                                                        <a href="/rapoarte/excel-fara-nava/{{ $rezervari_pe_tara->first()->oras_plecare_tara }}/{{ \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') }}/{{ $rezervari_pe_trasee->first()->lista_plecare }}/lista_plecare/{{ $tip_transport }}/extrage-rezervari/raport-pdf" class="btn btn-sm bg-success text-white border border-light rounded-pill">
                                                            <i class="fas fa-file-pdf text-white mr-1"></i>Raport fără Navă
                                                            {{-- Iphone --}}
                                                        </a>
                                                        <a href="/rapoarte/chitante/{{ $rezervari_pe_tara->first()->oras_plecare_tara }}/{{ \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') }}/{{ $rezervari_pe_trasee->first()->lista_plecare }}/lista_plecare/{{ $tip_transport }}/extrage-rezervari/raport-pdf" class="btn btn-sm bg-success text-white border border-light rounded-pill">
                                                            <i class="fas fa-file-pdf text-white mr-1"></i>Raport Bilete
                                                            {{-- Iphone --}}
                                                        </a>
                                                        <a href="/rapoarte/facturi/{{ $rezervari_pe_tara->first()->oras_plecare_tara }}/{{ \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') }}/{{ $rezervari_pe_trasee->first()->lista_plecare }}/lista_plecare/{{ $tip_transport }}/extrage-rezervari/raport-pdf" class="btn btn-sm bg-success text-white border border-light rounded-pill">
                                                            <i class="fas fa-file-pdf text-white mr-1"></i>Raport Facturi
                                                                <span style="background-color:darkgreen; padding: 0px 2px">
                                                                    <b>{{ $rezervari_pe_trasee->sum('factura_count') }}</b>
                                                                </span>
                                                            {{-- Iphone --}}
                                                        </a>
                                                    @else
                                                        <a href="/rapoarte/cmr/{{ $rezervari_pe_tara->first()->oras_plecare_tara }}/{{ \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') }}/{{ $rezervari_pe_trasee->first()->lista_plecare }}/lista_plecare/{{ $tip_transport }}/extrage-rezervari/raport-pdf" class="btn btn-sm bg-success text-white border border-light rounded-pill">
                                                            <i class="fas fa-file-pdf text-white mr-1"></i>Raport CMR
                                                            {{-- Iphone --}}
                                                        </a>
                                                    @endif
                                                    @if ((auth()->user()->role === 'administrator') || (auth()->user()->role === 'superadmin'))
                                                        <a
                                                            class="btn btn-sm bg-warning border border-light rounded-pill" style="color: black !important"
                                                            href="#"
                                                            data-toggle="modal"
                                                            data-target="#trimite-sms-{{ $rezervari_pe_trasee->first()->lista_plecare }}-lista_plecare"
                                                            {{-- data-target="#trimite-sms" --}}
                                                            title="Trimite SMS"
                                                            >
                                                            <i class="fas fa-sms mr-1"></i>Trimite SMS
                                                        </a>
                                                        {{-- <a href="/rapoarte/trimite-sms/{{ $rezervari_pe_tara->first()->oras_plecare_tara }}/{{ \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') }}/{{ $rezervari_pe_trasee->first()->lista_plecare }}/lista_plecare/{{ $tip_transport }}/extrage-rezervari/raport-pdf"  class="btn btn-sm bg-warning border border-light rounded-pill" style="color: black !important">
                                                            <i class="fas fa-sms mr-1"></i>Trimite SMS
                                                        </a>  --}}
                                                    @endif
                                                        {{-- <button type="submit" name="action" value="excel_nava" class="btn btn-sm bg-success text-white border border-light rounded-pill">
                                                            <i class="fas fa-file-pdf text-white mr-1"></i>Raport Navă
                                                        </button> --}}
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @forelse (
                                        ($rezervari_pe_tara->first()->oras_plecare_tara === 'Romania' ?
                                            $rezervari_pe_trasee->sortBy('oras_plecare_traseu')->groupBy('oras_plecare_traseu')
                                            :
                                            $rezervari_pe_trasee->sortByDesc('oras_plecare_traseu')->groupBy('oras_plecare_traseu')
                                        )
                                        as $rezervari_pe_trasee_pe_traseu_initial)
                                    @forelse (
                                            ($rezervari_pe_tara->first()->oras_plecare_tara === 'Romania' ?
                                                $rezervari_pe_trasee_pe_traseu_initial->sortBy('oras_plecare_ordine')->groupBy('oras_plecare_ordine')
                                                :
                                                $rezervari_pe_trasee_pe_traseu_initial->sortByDesc('oras_plecare_ordine')->groupBy('oras_plecare_ordine')
                                            )
                                            as $rezervari_pe_trasee_pe_traseu_initial_pe_oras)
                                        @forelse ($rezervari_pe_trasee_pe_traseu_initial_pe_oras->sortBy('oras_plecare_nume') as $rezervare)
                                        <tr
                                            {{-- class="collapse" id="collapseLista{{$rezervari_pe_trasee->first()->lista_plecare}}" --}}
                                            >
                                            <td>

                                                    {{-- <b>{{ $rezervare->nume ?? $rezervare->pasageri_relation->first()->nume ?? '' }}</b> --}}
                                                    @isset($rezervare->nr_adulti)
                                                        @foreach ($rezervare->pasageri_relation as $pasager)
                                                                <a href="{{ $rezervare->path() }}">
                                                                    {{ $pasager->nume }}
                                                                </a>
                                                                @if (in_array($pasager->nume, $clienti_neseriosi))
                                                                    (client neserios:
                                                                    {{ \App\Models\ClientNeserios::where('nume', $pasager->nume)->first()->observatii ?? '-'}})
                                                                @endif
                                                            @if(!$loop->last)
                                                                ,
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <a href="{{ $rezervare->path() }}">
                                                            {{ $rezervare->nume }} - colete
                                                        </a>
                                                    @endif

                                                    @if ($rezervare->observatii)
                                                        <br>
                                                        Observatii: {{ $rezervare->observatii }}
                                                    @endif
                                            </td>
                                            <td class="text-center">
                                                {{ $rezervare->oras_plecare_traseu ?? ''}}
                                            </td>
                                            <td>
                                                {{ $rezervare->oras_plecare_nume ?? ''}} ({{ $rezervare->oras_plecare_ordine ?? ''}})
                                                /
                                                {{ $rezervare->oras_sosire_nume ?? ''}} ({{ $rezervare->oras_sosire_ordine ?? ''}})
                                            </td>
                                            <td class="text-center">
                                                {{ ($tip_transport === 'calatori') ? ($rezervare->nr_adulti + $rezervare->nr_copii) : $rezervare->colete_numar }}
                                            </td>
                                            <td class="text-center">
                                                <form  class="needs-validation" novalidate method="POST" action="/rapoarte/{{ $tip_transport }}/muta-rezervare/{{ $rezervare->id}}">
                                                    @csrf

                                                    <div class="row input-group justify-content-center">
                                                        <div class="col-lg-12 px-0 mb-2 d-flex align-items-center">

                                                            {{-- <label for="lista">în lista:</label> --}}
                                                            <input type="text" class="form-control form-control-sm border rounded-pill mr-2 {{ $errors->has('lista') ? 'is-invalid' : '' }}"
                                                                id="lista" name="lista" placeholder=""
                                                                    style="width:50px"
                                                                    value="{{ old('lista') }}">
                                                            {{-- <input type="hidden" name="data_cursa" value="{{ $search_data }}">   --}}
                                                            @if ($view_type === "plecare")
                                                                <input type="hidden" name="tip_lista" value="lista_plecare">
                                                            @elseif ($view_type === "sosire")
                                                                <input type="hidden" name="tip_lista" value="lista_sosire">
                                                            @endif
                                                            <button class="btn btn-sm btn-primary border border-dark rounded-pill mr-2" type="submit">
                                                                <i class="fas fa-exchange-alt text-white mr-1"></i>Mută
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </td>
                                            <td class="text-right">
                                                    <a href="{{ $rezervare->path() }}/modifica"
                                                    >
                                                        <span class="badge badge-primary">Modifică</span>
                                                    </a>
                                                    <a
                                                        href="#"
                                                        data-toggle="modal"
                                                        data-target="#neseriosiRezervare{{ $rezervare->id }}"
                                                        title="Clienți neserioși"
                                                        >
                                                        <span class="badge badge-danger">Neserioși</span>
                                                    </a>
                                                    <a
                                                        href="#"
                                                        data-toggle="modal"
                                                        data-target="#stergeRezervare{{ $rezervare->id }}"
                                                        title="Șterge Rezervare"
                                                        >
                                                        <span class="badge badge-danger">Șterge</span>
                                                    </a>
                                            </td>
                                        </tr>
                                        @empty
                                        @endforelse
                                    @empty
                                    @endforelse
                                @empty
                                @endforelse
                                    <tr>
                                        <td colspan="3" class="text-right">
                                            <b>
                                                Total
                                            </b>
                                        </td>
                                        <td class="text-center">
                                            <b>
                                                {{ ($tip_transport === 'calatori') ? ($rezervari_pe_trasee->sum('nr_adulti') + $rezervari_pe_trasee->sum('nr_copii')) : $rezervari_pe_trasee->sum('colete_numar') }}
                                            </b>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    {{-- <tr>
                                        <td colspan="5" class="text-center">
                                            <a class="btn btn-sm bg-success text-white border border-dark rounded-pill" href="/rapoarte/extrage-pdf/{{ $rezervari_pe_trasee }}" role="button">
                                                <i class="fas fa-file-pdf text-white mr-1"></i>Raport PDF
                                            </a>
                                        </td>
                                    </tr> --}}
                                    {{-- <tr>
                                        <td colspan="5">
                                            <form class="needs-validation" novalidate method="POST" action="/rapoarte/muta-rezervari">
                                                @csrf

                                                    @foreach ($rezervari_pe_trasee as $rezervare)
                                                        <input type="hidden" name="rezervari[]" value="{{ $rezervare->id }}">
                                                    @endforeach
                                                    <div class="row justify-content-center mx-0 px-0">
                                                        <div class="col-lg-2">
                                                            <label> Mută rezervările în lista</label>
                                                        </div>
                                                        <div class="col-lg-1 mb-2">
                                                            <input type="text" class="form-control form-control-sm border rounded-pill mb-0 py-0 mx-2 {{ $errors->has('lista_noua') ? 'is-invalid' : '' }}"
                                                                id="lista_noua" name="lista_noua" placeholder=""
                                                                    style="width:50px"
                                                                    value="{{ old('lista_noua') }}">
                                                            <input type="hidden" name="tip_lista" value="lista_plecare">
                                                            <input type="hidden" class="form-control form-control-sm border rounded-pill mb-0 py-0 mx-2 {{ $errors->has('data_traseu') ? 'is-invalid' : '' }}"
                                                                id="data_traseu" name="data_traseu" placeholder=""
                                                                    style="width:50px"
                                                                    value="{{ $search_data }}">
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <button class="btn btn-sm btn-primary col-md-12 border border-dark rounded-pill" type="submit">
                                                                <i class="fas fa-exchange-alt text-white mr-1"></i>Mută
                                                            </button>
                                                        </div>
                                                    </div>
                                            </form>
                                        </td>
                                    </tr> --}}
                                    <tr class="bg-dark">
                                        <td colspan="6" height="50">
                                            <p></p>
                                        </td>
                                    </tr>
                            @endforeach
                                @if ( $tip_transport === 'calatori')
                                    <tr>
                                        {{-- <td colspan="6" class="py-4 text-center">
                                            <b>
                                                Total pasageri în toate listele:
                                                {{ $rezervari_pe_tara->sum('nr_adulti') + $rezervari_pe_tara->sum('nr_copii') }}
                                            </b>
                                            <br>
                                            <a href="/rapoarte/excel-nava/{{ $rezervari_pe_tara->first()->oras_plecare_tara }}/{{ \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') }}/toate/lista_plecare/{{ $tip_transport }}/extrage-rezervari/raport-pdf" class="btn btn-sm bg-success text-white border border-light rounded-pill">
                                                <i class="fas fa-file-pdf text-white mr-1"></i>Raport Navă
                                            </a>
                                                <form class="needs-validation" novalidate method="POST" action="/rapoarte/extrage-rezervari/raport-pdf">
                                                    @csrf

                                                    @foreach ($rezervari_toate_pe_tara as $rezervare_nava)
                                                        <input type="hidden" name="rezervari[]" value="{{ $rezervare_nava }}">
                                                    @endforeach
                                                            <input type="hidden" name="tip_lista" value="lista_plecare">
                                                        <button type="submit" name="action" value="excel_nava" class="btn btn-sm bg-success text-white border border-light rounded-pill">
                                                            <i class="fas fa-file-pdf text-white mr-1"></i>Raport Navă
                                                        </button>
                                                </form>
                                        </td> --}}
                                    </tr>
                                @endif
                        </tbody>
                    </table>
                </div>

            @endforeach

        @elseif ($view_type === "sosire")

            @foreach ($rezervari->groupBy('oras_sosire_tara') as $rezervari_pe_tara)

                <div class="table-responsive rounded mb-5">
                    <table class="table table-striped table-hover table-sm rounded">
                        <thead class="text-white rounded" style="background-color:#e66800;">
                            <tr>
                                <th colspan="6" class="text-center" style="font-size: 20px">
                                    Liste sosire
                                    {{ $rezervari_pe_tara->first()->oras_sosire_tara }}
                                </th>
                            </tr>
                                @if ( $tip_transport === 'calatori')
                                    <tr>
                                        <td colspan="6" class="py-1">
                                            <div class="d-flex flex-row justify-content-center">
                                                <div class="mr-4">
                                                    <b>
                                                        Total pasageri în toate listele:
                                                        {{ $rezervari_pe_tara->sum('nr_adulti') + $rezervari_pe_tara->sum('nr_copii') }}
                                                    </b>
                                                </div>
                                                <div class="mr-4">
                                                    <a href="/rapoarte/excel-nava/{{ $rezervari_pe_tara->first()->oras_plecare_tara }}/{{ \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') }}/toate/lista_sosire/{{ $tip_transport }}/extrage-rezervari/raport-pdf" class="btn btn-sm bg-success text-white border border-light rounded-pill">
                                                        <i class="fas fa-file-pdf text-white mr-1"></i>Raport Navă
                                                        {{-- Iphone --}}
                                                    </a>
                                                    <a href="/rapoarte/excel-fara-nava/{{ $rezervari_pe_tara->first()->oras_plecare_tara }}/{{ \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') }}/toate/lista_sosire/{{ $tip_transport }}/extrage-rezervari/raport-pdf" class="btn btn-sm bg-success text-white border border-light rounded-pill">
                                                        <i class="fas fa-file-pdf text-white mr-1"></i>Raport fără Navă
                                                        {{-- Iphone --}}
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="6" class="py-1">
                                            <div class="d-flex flex-row justify-content-center">
                                                <div class="">
                                                    <b>
                                                        Total colete în toate listele:
                                                        {{ $rezervari_pe_tara->sum('colete_numar') }}
                                                    </b>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            <tr class="" style="padding:2rem">
                                <th class="w-25">Pasageri</th>
                                <th class="text-center">Traseu</th>
                                <th>Oraș sosire/ plecare</th>
                                <th class="text-center">
                                    {{ $tip_transport === 'calatori' ? 'Nr. pers.' : 'Nr. colete' }}
                                </th>
                                <th class="text-center">Mutare</th>
                                <th class="text-right">Acțiuni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rezervari_pe_tara->where('oras_sosire_tara', $rezervari_pe_tara->first()->oras_sosire_tara)->sortBy('lista_sosire')->groupBy('lista_sosire') as $rezervari_pe_trasee)
                                    <tr>
                                        <td colspan="2" class="text-white" style="background-color:lightslategrey">
                                            <b>
                                                {{-- <a class="btn btn-sm btn-light" data-toggle="collapse"
                                                    href="#collapseLista{{$rezervari_pe_trasee->first()->lista_sosire}}"
                                                    role="button"
                                                    aria-expanded="false"
                                                    aria-controls="collapseLista{{$rezervari_pe_trasee->first()->lista_sosire}}"> --}}
                                                        Lista {{$rezervari_pe_trasee->first()->lista_sosire}}
                                                {{-- </a> --}}
                                            </b>
                                        </td>
                                        <td colspan="4" class="text-right" style="background-color:lightslategrey">
                                            <div class="align-right">
                                                <form class="needs-validation" novalidate method="POST" action="/rapoarte/extrage-rezervari/raport-pdf">
                                                    @csrf

                                                        @forelse (
                                                                ($rezervari_pe_tara->first()->oras_plecare_tara === 'Romania' ?
                                                                    $rezervari_pe_trasee->sortBy('oras_sosire_traseu')->groupBy('oras_sosire_traseu')
                                                                    :
                                                                    $rezervari_pe_trasee->sortByDesc('oras_sosire_traseu')->groupBy('oras_sosire_traseu')
                                                                )
                                                                as $rezervari_pe_trasee_pe_traseu_initial)
                                                            @forelse (
                                                                    ($rezervari_pe_tara->first()->oras_plecare_tara === 'Romania' ?
                                                                        $rezervari_pe_trasee_pe_traseu_initial->sortBy('oras_sosire_ordine')->groupBy('oras_sosire_ordine')
                                                                        :
                                                                        $rezervari_pe_trasee_pe_traseu_initial->sortByDesc('oras_sosire_ordine')->groupBy('oras_sosire_ordine')
                                                                    )
                                                                    as $rezervari_pe_trasee_pe_traseu_initial_pe_oras)
                                                                @forelse ($rezervari_pe_trasee_pe_traseu_initial_pe_oras->sortBy('oras_sosire_nume') as $rezervare)
                                                                    <input type="hidden" name="rezervari[]" value="{{ $rezervare->id }}">
                                                                @endforeach
                                                            @endforeach
                                                        @endforeach
                                                            <input type="hidden" name="tip_lista" value="lista_sosire">
                                                        <a href="/rapoarte/lista_sofer/{{ $rezervari_pe_tara->first()->oras_plecare_tara }}/{{ \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') }}/{{ $rezervari_pe_trasee->first()->lista_sosire }}/lista_sosire/{{ $tip_transport }}/extrage-rezervari/raport-pdf" class="btn btn-sm bg-success text-white border border-light rounded-pill">
                                                            <i class="fas fa-file-pdf text-white mr-1"></i>Raport PDF
                                                            {{-- Iphone --}}
                                                        </a>
                                                        {{-- <button type="submit" name="action" value="lista_sofer" class="btn btn-sm bg-success text-white border border-light rounded-pill">
                                                            <i class="fas fa-file-pdf text-white mr-1"></i>Raport PDF
                                                        </button>  --}}
                                                    @if ( $tip_transport === 'calatori')
                                                        <a href="/rapoarte/lista_pasageri/{{ $rezervari_pe_tara->first()->oras_plecare_tara }}/{{ \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') }}/{{ $rezervari_pe_trasee->first()->lista_sosire }}/lista_sosire/{{ $tip_transport }}/extrage-rezervari/raport-pdf" class="btn btn-sm bg-success text-white border border-light rounded-pill">
                                                            <i class="fas fa-file-pdf text-white mr-1"></i>Listă pasageri
                                                            {{-- Iphone --}}
                                                        </a>
                                                        <a href="/rapoarte/excel-nava/{{ $rezervari_pe_tara->first()->oras_plecare_tara }}/{{ \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') }}/{{ $rezervari_pe_trasee->first()->lista_sosire }}/lista_sosire/{{ $tip_transport }}/extrage-rezervari/raport-pdf" class="btn btn-sm bg-success text-white border border-light rounded-pill">
                                                            <i class="fas fa-file-pdf text-white mr-1"></i>Raport Navă
                                                            {{-- Iphone --}}
                                                        </a>
                                                        <a href="/rapoarte/excel-fara-nava/{{ $rezervari_pe_tara->first()->oras_plecare_tara }}/{{ \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') }}/{{ $rezervari_pe_trasee->first()->lista_sosire }}/lista_sosire/{{ $tip_transport }}/extrage-rezervari/raport-pdf" class="btn btn-sm bg-success text-white border border-light rounded-pill">
                                                            <i class="fas fa-file-pdf text-white mr-1"></i>Raport fără Navă
                                                            {{-- Iphone --}}
                                                        </a>
                                                        <a href="/rapoarte/chitante/{{ $rezervari_pe_tara->first()->oras_plecare_tara }}/{{ \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') }}/{{ $rezervari_pe_trasee->first()->lista_sosire }}/lista_sosire/{{ $tip_transport }}/extrage-rezervari/raport-pdf" class="btn btn-sm bg-success text-white border border-light rounded-pill">
                                                            <i class="fas fa-file-pdf text-white mr-1"></i>Raport Bilete
                                                            {{-- Iphone --}}
                                                        </a>
                                                        <a href="/rapoarte/facturi/{{ $rezervari_pe_tara->first()->oras_plecare_tara }}/{{ \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') }}/{{ $rezervari_pe_trasee->first()->lista_sosire }}/lista_sosire/{{ $tip_transport }}/extrage-rezervari/raport-pdf" class="btn btn-sm bg-success text-white border border-light rounded-pill">
                                                            <i class="fas fa-file-pdf text-white mr-1"></i>Raport Facturi
                                                                <span style="background-color:darkgreen; padding: 0px 2px">
                                                                    <b>{{ $rezervari_pe_trasee->sum('factura_count') }}</b>
                                                                </span>
                                                            {{-- Iphone --}}
                                                        </a>
                                                    @else
                                                        <a href="/rapoarte/cmr/{{ $rezervari_pe_tara->first()->oras_plecare_tara }}/{{ \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') }}/{{ $rezervari_pe_trasee->first()->lista_plecare }}/lista_plecare/{{ $tip_transport }}/extrage-rezervari/raport-pdf" class="btn btn-sm bg-success text-white border border-light rounded-pill">
                                                            <i class="fas fa-file-pdf text-white mr-1"></i>Raport CMR
                                                            {{-- Iphone --}}
                                                        </a>
                                                    @endif
                                                    @if ((auth()->user()->role === 'administrator') || (auth()->user()->role === 'superadmin'))
                                                        <a
                                                            class="btn btn-sm bg-warning border border-light rounded-pill" style="color: black !important"
                                                            href="#"
                                                            data-toggle="modal"
                                                            data-target="#trimite-sms-{{ $rezervari_pe_trasee->first()->lista_sosire }}-lista_sosire"
                                                            {{-- data-target="#trimite-sms" --}}
                                                            title="Trimite SMS"
                                                            >
                                                            <i class="fas fa-sms mr-1"></i>Trimite SMS
                                                        </a>
                                                        {{-- <a href="/rapoarte/trimite-sms/{{ $rezervari_pe_tara->first()->oras_plecare_tara }}/{{ \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') }}/{{ $rezervari_pe_trasee->first()->lista_sosire }}/lista_sosire/{{ $tip_transport }}/extrage-rezervari/raport-pdf"  class="btn btn-sm bg-warning border border-light rounded-pill" style="color: black !important">
                                                            <i class="fas fa-sms mr-1"></i>Trimite SMS
                                                        </a>  --}}
                                                    @endif
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @forelse (
                                        ($rezervari_pe_tara->first()->oras_plecare_tara === 'Romania' ?
                                            $rezervari_pe_trasee->sortBy('oras_sosire_traseu')->groupBy('oras_sosire_traseu')
                                            :
                                            $rezervari_pe_trasee->sortByDesc('oras_sosire_traseu')->groupBy('oras_sosire_traseu')
                                        )
                                        as $rezervari_pe_trasee_pe_traseu_initial)
                                    @forelse (
                                            ($rezervari_pe_tara->first()->oras_plecare_tara === 'Romania' ?
                                                $rezervari_pe_trasee_pe_traseu_initial->sortBy('oras_sosire_ordine')->groupBy('oras_sosire_ordine')
                                                :
                                                $rezervari_pe_trasee_pe_traseu_initial->sortByDesc('oras_sosire_ordine')->groupBy('oras_sosire_ordine')
                                            )
                                            as $rezervari_pe_trasee_pe_traseu_initial_pe_oras)
                                        @forelse ($rezervari_pe_trasee_pe_traseu_initial_pe_oras->sortBy('oras_sosire_nume') as $rezervare)
                                        <tr
                                            {{-- class="collapse" id="collapseLista{{$rezervari_pe_trasee->first()->lista_sosire}}" --}}
                                            >
                                            <td>
                                                {{-- <b>{{ $rezervare->nume ?? $rezervare->pasageri_relation->first()->nume ?? '' }}</b> --}}
                                                @isset($rezervare->nr_adulti)
                                                    @foreach ($rezervare->pasageri_relation as $pasager)
                                                            <a href="{{ $rezervare->path() }}">
                                                                {{ $pasager->nume }}
                                                            </a>
                                                            @if (in_array($pasager->nume, $clienti_neseriosi))
                                                                (client neserios:
                                                                {{ \App\Models\ClientNeserios::where('nume', $pasager->nume)->first()->observatii ?? '-'}})
                                                            @endif
                                                        @if(!$loop->last)
                                                            ,
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <a href="{{ $rezervare->path() }}">
                                                        {{ $rezervare->nume }} - colete
                                                    </a>
                                                @endif

                                                @if ($rezervare->observatii)
                                                    <br>
                                                    Observatii: {{ $rezervare->observatii }}
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ $rezervare->oras_sosire_traseu ?? ''}}
                                            </td>
                                            <td>
                                                {{ $rezervare->oras_sosire_nume ?? ''}} ({{ $rezervare->oras_sosire_ordine ?? ''}})
                                                /
                                                {{ $rezervare->oras_plecare_nume ?? ''}} ({{ $rezervare->oras_plecare_ordine ?? ''}})
                                            </td>
                                            <td class="text-center">
                                                {{ ($tip_transport === 'calatori') ? ($rezervare->nr_adulti + $rezervare->nr_copii) : $rezervare->colete_numar }}
                                            </td>
                                            <td class="text-center px-2">
                                                <form  class="needs-validation" novalidate method="POST" action="/rapoarte/{{ $tip_transport }}/muta-rezervare/{{ $rezervare->id}}">
                                                    @csrf

                                                    <div class="row input-group justify-content-center">
                                                        <div class="col-lg-12 d-flex px-0 mb-2 align-items-center">

                                                            {{-- <label for="lista">în lista:</label> --}}
                                                            <input type="text" class="form-control form-control-sm border rounded-pill mr-2 {{ $errors->has('lista') ? 'is-invalid' : '' }}"
                                                                id="lista" name="lista" placeholder=""
                                                                    style="width:50px"
                                                                    value="{{ old('lista') }}">
                                                            {{-- <input type="hidden" name="data_cursa" value="{{ $search_data }}">   --}}
                                                            @if ($view_type === "plecare")
                                                                <input type="hidden" name="tip_lista" value="lista_plecare">
                                                            @elseif ($view_type === "sosire")
                                                                <input type="hidden" name="tip_lista" value="lista_sosire">
                                                            @endif
                                                            <button class="btn btn-sm btn-primary border border-dark rounded-pill mr-2" type="submit">
                                                                <i class="fas fa-exchange-alt text-white mr-1"></i>Mută
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </td>
                                            <td class="text-right">
                                                    <a href="{{ $rezervare->path() }}/modifica"
                                                    >
                                                        <span class="badge badge-primary">Modifică</span>
                                                    </a>
                                                    <a
                                                        href="#"
                                                        data-toggle="modal"
                                                        data-target="#neseriosiRezervare{{ $rezervare->id }}"
                                                        title="Clienți neserioși"
                                                        >
                                                        <span class="badge badge-danger">Neserioși</span>
                                                    </a>
                                                    <a
                                                        href="#"
                                                        data-toggle="modal"
                                                        data-target="#stergeRezervare{{ $rezervare->id }}"
                                                        title="Șterge Rezervare"
                                                        >
                                                        <span class="badge badge-danger">Șterge</span>
                                                    </a>
                                            </td>
                                        </tr>
                                        @empty
                                        @endforelse
                                    @empty
                                    @endforelse
                                @empty
                                @endforelse
                                    <tr>
                                        <td colspan="3" class="text-right">
                                            <b>
                                                Total
                                            </b>
                                        </td>
                                        <td class="text-center">
                                            <b>
                                                {{ ($tip_transport === 'calatori') ? ($rezervari_pe_trasee->sum('nr_adulti') + $rezervari_pe_trasee->sum('nr_copii')) : $rezervari_pe_trasee->sum('colete_numar') }}
                                            </b>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    {{-- <tr>
                                        <td colspan="5" class="text-center">
                                            <a class="btn btn-sm bg-success text-white border border-dark rounded-pill" href="/rapoarte/extrage-pdf/{{ $rezervari_pe_trasee }}" role="button">
                                                <i class="fas fa-file-pdf text-white mr-1"></i>Raport PDF
                                            </a>
                                        </td>
                                    </tr> --}}
                                    {{-- <tr>
                                        <td colspan="5">
                                            <form class="needs-validation" novalidate method="POST" action="/rapoarte/muta-rezervari">
                                                @csrf

                                                    @foreach ($rezervari_pe_trasee as $rezervare)
                                                        <input type="hidden" name="rezervari[]" value="{{ $rezervare->id }}">
                                                    @endforeach
                                                    <div class="row justify-content-center mx-0 px-0">
                                                        <div class="col-lg-2">
                                                            <label> Mută rezervările în lista</label>
                                                        </div>
                                                        <div class="col-lg-1 mb-2">
                                                            <input type="text" class="form-control form-control-sm border rounded-pill mb-0 py-0 mx-2 {{ $errors->has('lista_noua') ? 'is-invalid' : '' }}"
                                                                id="lista_noua" name="lista_noua" placeholder=""
                                                                    style="width:50px"
                                                                    value="{{ old('lista_noua') }}">
                                                            <input type="hidden" name="tip_lista" value="lista_sosire">
                                                            <input type="hidden" class="form-control form-control-sm border rounded-pill mb-0 py-0 mx-2 {{ $errors->has('data_traseu') ? 'is-invalid' : '' }}"
                                                                id="data_traseu" name="data_traseu" placeholder=""
                                                                    style="width:50px"
                                                                    value="{{ $search_data }}">
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <button class="btn btn-sm btn-primary col-md-12 border border-dark rounded-pill" type="submit">
                                                                <i class="fas fa-exchange-alt text-white mr-1"></i>Mută
                                                            </button>
                                                        </div>
                                                    </div>
                                            </form>
                                        </td>
                                    </tr> --}}
                                    <tr class="bg-dark">
                                        <td colspan="6" height="50">
                                            <p></p>
                                        </td>
                                    </tr>
                            @endforeach
                                {{-- @if ( $tip_transport === 'calatori')
                                    <tr>
                                        <td colspan="6" class="py-4 text-center">
                                            <b>
                                                Total pasageri în toate listele:
                                                {{ $rezervari_pe_tara->sum('nr_adulti') + $rezervari_pe_tara->sum('nr_copii') }}
                                            </b>
                                        </td>
                                    </tr>
                                @endif --}}
                        </tbody>
                    </table>
                </div>
            @endforeach

        @endif



        </div>
    </div>


    {{-- Modalele --}}

        {{-- Modale pentru SMS --}}

        <div id="text-sms">
        {{-- Rapoarte plecare --}}
        @foreach ($rezervari->groupBy('oras_plecare_tara') as $rezervari_pe_tara)
        {{-- Modal pentru butonul de trimitere sms la toate cursele de pe o zi --}}
            <div class="modal fade text-dark"
                id="trimite-sms-toate"
                tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Trimite SMS către <b> {{ $rezervari_pe_tara->count() }}</b> rezervări
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                <form method="POST"
                    action="/rapoarte/trimite-sms/{{ $rezervari_pe_tara->first()->oras_plecare_tara }}/{{ \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') }}/toate/lista_plecare/{{ $tip_transport }}/extrage-rezervari/raport-pdf">

                    @csrf

                    <div class="modal-body" style="text-align:left;">
                        <div class="form-row">
                            <div class="form-group col-lg-12">
                                <label for="text_sms" class="mb-0 pl-3">Text SMS:</label>
                                <textarea class="form-control mb-1 {{ $errors->has('text_sms') ? 'is-invalid' : '' }}"
                                    name="text_sms"
                                    rows="4"
                                    v-model="text_sms"
                                ></textarea>
                                <div class="text-right">
                                    <label for="nr_caractere" class="mb-0 pl-3">Nr. caractere:</label>
                                    <input class="text-right"
                                        style="width:40px"
                                        v-model="caractere"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <a class="" data-toggle="collapse" href="#collapse" role="button" aria-expanded="false" aria-controls="collapse">
                                    <i class="fas fa-compress mr-1"></i> Afișează caracterele acceptate in textul SMS-ului
                                </a>
                            </div>
                            <div class="col-lg-12 collapse" id="collapse">
                                @include ('diverse.caracterele_acceptate_in_textul_sms_ului')
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>
                            <button
                                type="submit"
                                class="btn btn-warning"
                                >
                                Trimite SMS
                            </button>
                    </div>
                </form>
                    </div>
                </div>
            </div>

            @foreach ($rezervari_pe_tara->where('oras_plecare_tara', $rezervari_pe_tara->first()->oras_plecare_tara)->sortBy('lista_plecare')->groupBy('lista_plecare') as $rezervari_pe_trasee)
                {{-- Modale pentru butoanele de trimitere sms la fiecare cursa in parte --}}
                <div class="modal fade text-dark"
                    id="trimite-sms-{{ $rezervari_pe_trasee->first()->lista_plecare }}-lista_plecare"
                    tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header bg-warning">
                            <h5 class="modal-title" id="exampleModalLabel">
                                Trimite SMS către <b>{{ $rezervari_pe_trasee->count() }}</b> rezervări
                            </h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                    <form method="POST"
                        action="/rapoarte/trimite-sms/{{ $rezervari_pe_tara->first()->oras_plecare_tara }}/{{ \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') }}/{{ $rezervari_pe_trasee->first()->lista_plecare }}/lista_plecare/{{ $tip_transport }}/extrage-rezervari/raport-pdf">

                        @csrf

                        <div class="modal-body" style="text-align:left;">
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label for="text_sms" class="mb-0 pl-3">Text SMS:</label>
                                    <textarea class="form-control mb-1 {{ $errors->has('text_sms') ? 'is-invalid' : '' }}"
                                        name="text_sms"
                                        rows="4"
                                        v-model="text_sms"
                                    ></textarea>
                                    <div class="text-right">
                                        <label for="nr_caractere" class="mb-0 pl-3">Nr. caractere:</label>
                                        <input class="text-right"
                                            style="width:40px"
                                            v-model="caractere"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <a class="" data-toggle="collapse" href="#collapse" role="button" aria-expanded="false" aria-controls="collapse">
                                        <i class="fas fa-compress mr-1"></i> Afișează caracterele acceptate in textul SMS-ului
                                    </a>
                                </div>
                                <div class="col-lg-12 collapse" id="collapse">
                                    @include ('diverse.caracterele_acceptate_in_textul_sms_ului')
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>
                                <button
                                    type="submit"
                                    class="btn btn-warning"
                                    >
                                    Trimite SMS
                                </button>
                        </div>
                    </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach

        {{-- Rapoarte sosire --}}
        @foreach ($rezervari->groupBy('oras_sosire_tara') as $rezervari_pe_tara)
            @foreach ($rezervari_pe_tara->where('oras_sosire_tara', $rezervari_pe_tara->first()->oras_sosire_tara)->sortBy('lista_sosire')->groupBy('lista_sosire') as $rezervari_pe_trasee)
                {{-- Modale pentru butoanele de trimitere sms la fiecare cursa in parte --}}
                <div class="modal fade text-dark"
                    id="trimite-sms-{{ $rezervari_pe_trasee->first()->lista_sosire }}-lista_sosire"
                    tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header bg-warning">
                            <h5 class="modal-title" id="exampleModalLabel">
                                Trimite SMS către <b>{{ $rezervari_pe_trasee->count() }}</b> rezervări
                            </h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                    <form method="POST"
                        action="/rapoarte/trimite-sms/{{ $rezervari_pe_tara->first()->oras_plecare_tara }}/{{ \Carbon\Carbon::parse($search_data)->isoFormat('YYYY-MM-DD') }}/{{ $rezervari_pe_trasee->first()->lista_sosire }}/lista_sosire/{{ $tip_transport }}/extrage-rezervari/raport-pdf">

                        @csrf

                        <div class="modal-body" style="text-align:left;">
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label for="text_sms" class="mb-0 pl-3">Text SMS:</label>
                                    <textarea class="form-control mb-1 {{ $errors->has('text_sms') ? 'is-invalid' : '' }}"
                                        name="text_sms"
                                        rows="4"
                                        v-model="text_sms"
                                    ></textarea>
                                    <div class="text-right">
                                        <label for="nr_caractere" class="mb-0 pl-3">Nr. caractere:</label>
                                        <input class="text-right"
                                            style="width:40px"
                                            v-model="caractere"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <a class="" data-toggle="collapse" href="#collapse" role="button" aria-expanded="false" aria-controls="collapse">
                                        <i class="fas fa-compress mr-1"></i> Afișează caracterele acceptate in textul SMS-ului
                                    </a>
                                </div>
                                <div class="col-lg-12 collapse" id="collapse">
                                    @include ('diverse.caracterele_acceptate_in_textul_sms_ului')
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>
                                <button
                                    type="submit"
                                    class="btn btn-warning"
                                    >
                                    Trimite SMS
                                </button>
                        </div>
                    </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach
        </div>


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
