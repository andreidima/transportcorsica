@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header justify-content-between py-1" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3 align-self-center">
                <h4 class=" mb-0">
                    <a href="{{ route('mesaje-trimise-sms.index') }}"><i class="fas fa-sms mr-1"></i>SMS trimise</a>
                </h4>
            </div>
            {{-- <div class="col-lg-8" id="app1">
                <form class="needs-validation" novalidate method="GET" action="{{ route('sms-trimise.index') }}">
                    @csrf
                    <div class="row input-group custom-search-form justify-content-end align-self-end">
                        <div class="col-md-3">
                            <input type="text" class="form-control form-control-sm border rounded-pill mb-1 py-0"
                            id="search_nume" name="search_nume" placeholder="Nume" autofocus
                                    value="{{ $search_nume }}">
                        </div>
                        <div class="col-md-6 d-flex mb-1">
                            <label for="search_date" class="mb-0 align-self-center mr-1">Interval:</label>
                            <vue2-datepicker
                                data-veche="{{ $search_data_inceput }}"
                                nume-camp-db="search_data_inceput"
                                tip="date"
                                latime="145"
                            ></vue2-datepicker>
                            <vue2-datepicker
                                data-veche="{{ $search_data_sfarsit }}"
                                nume-camp-db="search_data_sfarsit"
                                tip="date"
                                latime="145"
                            ></vue2-datepicker>
                        </div>
                        <button class="btn btn-sm btn-primary col-md-4 mr-1 border border-dark rounded-pill" type="submit">
                            <i class="fas fa-search text-white mr-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-pill" href="{{ route('sms-trimise.index') }}" role="button">
                            <i class="far fa-trash-alt text-white mr-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form>
            </div> --}}
            {{-- <div class="col-lg-3 text-right"> --}}
                {{-- <a class="btn btn-sm bg-success text-white border border-dark rounded-pill col-md-8" href="{{ route('clienti.create') }}" role="button">
                    <i class="fas fa-plus-square text-white mr-1"></i>Adaugă client
                </a> --}}
            {{-- </div>  --}}
        </div>

        <div class="card-body px-0 py-3">

            @include ('errors')

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-sm rounded">
                    <thead class="text-white rounded" style="background-color:#408080;">
                        <tr class="" style="padding:2rem">
                            <th style="font-size:0.8rem">Nr. Crt.</th>
                            <th class="" style="">Rezervare</th>
                            <th style="font-size:0.8rem">Telefon SMS</th>
                            <th class="text-center">Mesaj</th>
                            <th class="text-center">Trimis</th>
                            <th class="text-center">Mesaj success/ eroare</th>
                            <th class="text-right">Data trimitere</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mesaje_sms as $mesaj_sms)
                            <tr>
                                <td align="">
                                    {{ ($mesaje_sms ->currentpage()-1) * $mesaje_sms ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    @isset($mesaj_sms->rezervare)
                                        <a href="{{ $mesaj_sms->rezervare->path() ?? ''}}">
                                            {{-- <b>{{ $rezervare->nume ?? $rezervare->pasageri_relation->first()->nume ?? '' }}</b> --}}
                                            @isset($mesaj_sms->rezervare->nr_adulti)
                                                @foreach ($mesaj_sms->rezervare->pasageri_relation as $pasager)
                                                    @if(!$loop->last)
                                                        {{ $pasager->nume }},
                                                    @else
                                                        {{ $pasager->nume }}
                                                    @endif
                                                @endforeach
                                            @else
                                                Rezervare colete
                                            @endif
                                        </a>
                                    @endisset
                                </td>
                                <td class="">
                                    {{ $mesaj_sms->telefon }}
                                </td>
                                <td class="">
                                    {{ $mesaj_sms->mesaj }}
                                </td>
                                <td class="text-center">
                                    @if ($mesaj_sms->trimis === 1)
                                        <span class="text-success">DA</span>
                                    @else
                                        <span class="text-danger">NU</span>
                                    @endif
                                </td>
                                <td class="">
                                    {{ $mesaj_sms->raspuns }}
                                </td>
                                <td class="text-right">
                                    {{ \Carbon\Carbon::parse($mesaj_sms->created_at)->isoFormat('HH:mm - DD.MM.YYYY') ?? '' }}
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
                        {{-- {{$produse_vandute->links()}} --}}
                        {{$mesaje_sms->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection
