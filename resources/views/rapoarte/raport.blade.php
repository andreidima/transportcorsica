@extends ('layouts.app')

@section('content')   
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header justify-content-between py-1" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3 align-self-center mb-2">
                <h4 class=" mb-0">
                    <a href="/rapoarte"><i class="fas fa-book mr-1"></i>Rapoarte</a>
                </h4>
            </div> 
            <div class="col-lg-8" id="app1">
                <form class="needs-validation" novalidate method="GET" action="/rapoarte">
                    @csrf                    
                    <div class="row input-group custom-search-form justify-content-center">
                        <div class="col-md-3 mb-2 px-1 d-flex align-items-center">
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
                        <div class="col-md-3 mb-2 px-1 d-flex align-items-center">
                            <button class="btn btn-sm btn-primary col-md-12 border border-dark rounded-pill" type="submit">
                                <i class="fas fa-search text-white mr-1"></i>Caută
                            </button>
                        </div>
                        <div class="col-md-3 mb-2 px-1 d-flex align-items-center">
                            <a class="btn btn-sm bg-secondary text-white col-md-12 border border-dark rounded-pill" href="/rapoarte" role="button">
                                <i class="far fa-trash-alt text-white mr-1"></i>Resetează căutarea
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            {{-- <div class="col-lg-3 text-right align-self-center">
                <a class="btn btn-sm bg-success text-white border border-dark rounded-pill col-md-8" href="{{ route('rezervari.create') }}" role="button">
                    <i class="fas fa-plus-square text-white mr-1"></i>Adaugă rezervare
                </a>
            </div>  --}}
        </div>

        <div class="card-body px-0 py-3">

            @include('errors')
            
            <div class="table-responsive rounded mb-2">
                <table class="table table-striped table-hover table-sm rounded"> 
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th>Nume</th>
                            <th class="text-center">Traseu</th>
                            <th>Oraș plecare</th>
                            <th>Oraș sosire</th>
                            <th class="text-center">Nr. pers.</th>
                        </tr>
                    </thead>
                    <tbody> 
                        {{-- @php
                            dd(App\Models\Oras::select('traseu')->get());
                        @endphp --}}
                        @foreach (App\Models\Oras::select('traseu')->where('tara', 'Romania')->distinct()->orderBy('traseu')->get() as $oras)
                            @if ($rezervari->where('oras_plecare_nume.traseu', $oras->traseu)->count())              
                                @forelse ($rezervari->where('oras_plecare_nume.traseu', $oras->traseu) as $rezervare) 
                                    <tr>      
                                        <td>
                                            <a href="{{ $rezervare->path() }}">  
                                                <b>{{ $rezervare->nume }}</b>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            {{ $rezervare->oras_plecare_nume->traseu ?? ''}}
                                        </td>
                                        <td>
                                            {{ $rezervare->oras_plecare_nume->oras ?? ''}}
                                        </td>
                                        <td>
                                            {{ $rezervare->oras_sosire_nume->oras ?? ''}}
                                        </td>
                                        <td class="text-center">
                                            {{ $rezervare->nr_adulti + $rezervare->nr_copii }}
                                        </td>
                                    </tr>                                          
                                @empty
                                    {{-- <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div> --}}
                                @endforelse
                                    <tr>
                                        <td colspan="4" class="text-right">
                                            <b>
                                                Total
                                            </b>
                                        </td>
                                        <td class="text-center">
                                            <b>
                                                {{ $rezervari->where('oras_plecare_nume.traseu', $oras->traseu)->sum('nr_adulti') }}
                                            </b>
                                        </td>
                                    </tr>
                                    <tr class="bg-dark">
                                        <td colspan="5">
                                            <p></p>
                                        </td>
                                    </tr>
                            @endif
                        @endforeach
                        </tbody>
                </table>
            </div>




        </div>
    </div>
@endsection