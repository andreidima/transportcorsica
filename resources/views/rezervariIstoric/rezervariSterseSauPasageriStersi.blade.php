@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header justify-content-between py-1" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3 align-self-center mb-2">
                <h4 class=" mb-0">
                    {{-- Rezervări șterse sau pasageri șterși --}}
                    Rezervări șterse
                </h4>
            </div>
            <div class="col-lg-9" id="app1">
                <form class="needs-validation" novalidate method="GET" action="{{ url()->current() }}">
                    @csrf
                    <div class="row input-group custom-search-form justify-content-center">
                        <div class="col-md-4 mb-2 px-1 d-flex align-items-center">
                            <input type="text" class="form-control form-control-sm border rounded-pill mb-0 py-0"
                            id="search_nume" name="search_nume" placeholder="Pasager"
                                    value="{{ $search_nume }}">
                        </div>
                        <div class="col-md-4 mb-2 px-1 d-flex align-items-center">
                            <label for="search_data" class="mb-0 align-self-center mr-1">Data cursă:</label>
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
                            <a class="btn btn-sm bg-secondary text-white col-md-12 border border-dark rounded-pill" href="{{ url()->current() }}" role="button">
                                <i class="far fa-trash-alt text-white mr-1"></i>Resetează căutarea
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card-body px-0 py-3">

            @include('errors')

            <div class="table-responsive rounded mb-2">
                <table class="table table-striped table-hover table-sm rounded">
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th>#</th>
                            <th>Nume</th>
                            <th>Telefon</th>
                            <th>Nr. pers.</th>
                            <th>Oraș plecare</th>
                            <th>Oraș sosire</th>
                            <th>Data cursă</th>
                            <th class="">Utilizator</th>
                            <th>Data ștergere</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rezervariSterse as $rezervare)
                            <tr>
                                <td align="">
                                    {{ ($rezervariSterse ->currentpage()-1) * $rezervariSterse ->perpage() + $loop->index + 1 }}
                                    {{-- {{ $rezervare->id }} --}}
                                    {{-- {{ $rezervare->operatie }} --}}
                                </td>
                                <td>
                                    @isset($rezervare->nr_adulti)
                                        @php
                                            $pasageri = [];
                                        @endphp
                                        @foreach ($rezervare->pasageri_relation as $pasager)
                                            @php
                                                array_push($pasageri, $pasager->nume);
                                            @endphp
                                        @endforeach

                                        @foreach (array_unique($pasageri) as $pasager)
                                            {{ $pasager }}@if (!$loop->last),@endif
                                        @endforeach
                                    @else
                                        {{ $rezervare->nume }} - colete
                                    @endisset
                                </td>
                                <td>
                                    {{ $rezervare->telefon }}
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
                                <td>
                                    {{ $rezervare->user->name ?? 'SITE'}}
                                </td>
                                <td>
                                    {{ $rezervare->data_operatie ? \Carbon\Carbon::parse($rezervare->data_operatie)->isoFormat('DD.MM.YYYY') : '' }}
                                </td>
                            </tr>
                        @empty
                            {{-- <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div> --}}
                        @endforelse
                        </tbody>
                </table>
            </div>

                <nav>
                    <ul class="pagination pagination-sm justify-content-center">
                        {{ $rezervariSterse->appends(Request::except('page'))->links() }}
                    </ul>
                </nav>

        </div>
    </div>


@endsection
