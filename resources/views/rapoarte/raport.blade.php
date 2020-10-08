@extends ('layouts.app')

@section('content')   
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header justify-content-between py-1" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3 align-self-center mb-2">
                <h4 class=" mb-0">
                    <a href="/rapoarte"><i class="fas fa-book mr-1"></i>Rapoarte</a>
                </h4>
            </div> 
            <div class="col-lg-6" id="app1">
                <form class="needs-validation" novalidate method="GET" action="/rapoarte">
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
                            <a class="btn btn-sm bg-secondary text-white col-md-12 border border-dark rounded-pill" href="/rapoarte" role="button">
                                <i class="far fa-trash-alt text-white mr-1"></i>Resetează căutarea
                            </a>
                        </div>
                    </div>
                </form>
                {{-- <form class="needs-validation" novalidate method="POST" action="/rapoarte/muta-rezervari">
                    @csrf

                    <div class="row input-group custom-search-form justify-content-center">
                                <div class="col-lg-6 px-0 mb-2 d-flex align-items-center">
                                    <label class="mb-0">Mută rezervările traseu inițial:</label> 
                                    <input type="text" class="form-control form-control-sm border rounded-pill mb-0 py-0 mx-2 {{ $errors->has('traseu_vechi') ? 'is-invalid' : '' }}" 
                                        id="traseu_vechi" name="traseu_vechi" placeholder=""
                                            style="width:50px"
                                            value="{{ old('traseu_vechi') }}">
                                </div>
                                <div class="col-lg-3 px-0 mb-2 d-flex align-items-center">
                                    în lista:
                                    <input type="text" class="form-control form-control-sm border rounded-pill mb-0 py-0 mx-2 {{ $errors->has('traseu_nou') ? 'is-invalid' : '' }}" 
                                        id="traseu_nou" name="traseu_nou" placeholder=""
                                            style="width:50px"
                                            value="{{ old('traseu_nou') }}">
                                    <input type="hidden" class="form-control form-control-sm border rounded-pill mb-0 py-0 mx-2 {{ $errors->has('data_traseu') ? 'is-invalid' : '' }}" 
                                        id="data_traseu" name="data_traseu" placeholder=""
                                            style="width:50px"
                                            value="{{ $search_data }}">
                                </div>
                                <div class="col-lg-3 px-0 mb-2">                            
                                    <button class="btn btn-sm btn-primary col-md-12 border border-dark rounded-pill" type="submit">
                                        <i class="fas fa-exchange-alt text-white mr-1"></i>Mută
                                    </button>
                                </div>
                    </div>
                </form> --}}
            </div>
            {{-- <div class="col-lg-3 text-right align-self-center">
                <a class="btn btn-sm bg-success text-white border border-dark rounded-pill col-md-8" href="{{ route('rezervari.create') }}" role="button">
                    <i class="fas fa-plus-square text-white mr-1"></i>Adaugă rezervare
                </a>
            </div>  --}}
        </div>

        <div class="card-body px-0 py-3">

            @include('errors')
            
            @foreach ($rezervari->groupBy('oras_plecare_tara') as $rezervare_pe_tara)

                <div class="table-responsive rounded mb-5">
                    <table class="table table-striped table-hover table-sm rounded"> 
                        <thead class="text-white rounded" style="background-color:#e66800;">
                            <tr>
                                <th colspan="4" class="text-center" style="font-size: 20px">
                                    Liste plecare
                                    {{ $rezervare_pe_tara->first()->oras_plecare_tara }}
                                </th>
                            </tr>
                            <tr class="" style="padding:2rem">
                                <th>Nume</th>
                                <th class="text-center">Traseu inițial</th>
                                <th>Oraș plecare</th>
                                <th class="text-center">Nr. pers.</th>
                            </tr>
                        </thead>
                        <tbody> 
                            @foreach ($rezervare_pe_tara->where('oras_plecare_tara', $rezervare_pe_tara->first()->oras_plecare_tara)->sortBy('lista_plecare')->groupBy('lista_plecare') as $rezervari_pe_trasee)
                                    <tr>
                                        <td colspan="3" class="text-white" style="background-color:lightslategrey">
                                            <b>
                                                Lista {{$rezervari_pe_trasee->first()->lista_plecare}}
                                            </b>
                                        </td>
                                        <td colspan="1" class="text-right" style="background-color:lightslategrey">
                                            <div class="align-right">
                                                <form class="needs-validation" novalidate method="POST" action="/rapoarte/extrage-rezervari/raport-pdf">
                                                    @csrf

                                                        @forelse ($rezervari_pe_trasee->sortByDesc('oras_plecare_traseu')->groupBy('oras_plecare_traseu') as $rezervari_pe_trasee_pe_traseu_initial) 
                                                            @forelse ($rezervari_pe_trasee_pe_traseu_initial->sortBy('oras_plecare_ordine')->groupBy('oras_plecare_ordine') as $rezervari_pe_trasee_pe_traseu_initial_pe_oras) 
                                                                @forelse ($rezervari_pe_trasee_pe_traseu_initial_pe_oras->sortBy('oras_plecare_nume') as $rezervare) 
                                                                    <input type="hidden" name="rezervari[]" value="{{ $rezervare->id }}">
                                                                @endforeach
                                                            @endforeach
                                                        @endforeach
                                                            <input type="hidden" name="tip_lista" value="lista_plecare">  
                                                        <button type="submit" class="btn btn-sm bg-success text-white border border-light rounded-pill">
                                                            <i class="fas fa-file-pdf text-white mr-1"></i>Raport PDF
                                                        </button> 
                                                </form>
                                            </b>
                                        </td>
                                    </tr>             
                                @forelse ($rezervari_pe_trasee->sortByDesc('oras_plecare_traseu')->groupBy('oras_plecare_traseu') as $rezervari_pe_trasee_pe_traseu_initial) 
                                    @forelse ($rezervari_pe_trasee_pe_traseu_initial->sortBy('oras_plecare_ordine')->groupBy('oras_plecare_ordine') as $rezervari_pe_trasee_pe_traseu_initial_pe_oras) 
                                        @forelse ($rezervari_pe_trasee_pe_traseu_initial_pe_oras->sortBy('oras_plecare_nume') as $rezervare) 
                                        <tr>      
                                            <td>
                                                <a href="{{ $rezervare->path() }}">  
                                                    <b>{{ $rezervare->nume }}{{ $rezervare->id }}</b>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                {{ $rezervare->oras_plecare_traseu ?? ''}}
                                            </td>
                                            <td>
                                                {{ $rezervare->oras_plecare_nume ?? ''}} ({{ $rezervare->oras_plecare_ordine ?? ''}})
                                            </td>
                                            <td class="text-center">
                                                {{ $rezervare->nr_adulti }}
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
                                                {{ $rezervari_pe_trasee->sum('nr_adulti') }}
                                            </b>
                                        </td>
                                    </tr>
                                    {{-- <tr>
                                        <td colspan="5" class="text-center">
                                            <a class="btn btn-sm bg-success text-white border border-dark rounded-pill" href="/rapoarte/extrage-pdf/{{ $rezervari_pe_trasee }}" role="button">
                                                <i class="fas fa-file-pdf text-white mr-1"></i>Raport PDF
                                            </a>
                                        </td>
                                    </tr> --}}
                                    <tr>
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
                                    </tr>
                                    <tr class="bg-dark">
                                        <td colspan="5" height="50">
                                            <p></p>
                                        </td>
                                    </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach

            
            
            @foreach ($rezervari->groupBy('oras_sosire_tara') as $rezervare_pe_tara)

                <div class="table-responsive rounded mb-5">
                    <table class="table table-striped table-hover table-sm rounded"> 
                        <thead class="text-white rounded" style="background-color:#e66800;">
                            <tr>
                                <th colspan="4" class="text-center" style="font-size: 20px">
                                    Liste sosire
                                    {{ $rezervare_pe_tara->first()->oras_sosire_tara }}
                                </th>
                            </tr>
                            <tr class="" style="padding:2rem">
                                <th>Nume</th>
                                <th class="text-center">Traseu inițial</th>
                                <th>Oraș sosire</th>
                                <th class="text-center">Nr. pers.</th>
                            </tr>
                        </thead>
                        <tbody> 
                            @foreach ($rezervare_pe_tara->where('oras_sosire_tara', $rezervare_pe_tara->first()->oras_sosire_tara)->sortBy('lista_sosire')->groupBy('lista_sosire') as $rezervari_pe_trasee)
                                    <tr>
                                        <td colspan="3" class="text-white" style="background-color:lightslategrey">
                                            <b>
                                                Lista {{$rezervari_pe_trasee->first()->lista_sosire}}
                                            </b>
                                        </td>
                                        <td colspan="1" class="text-right" style="background-color:lightslategrey">
                                            <div class="align-right">
                                                <form class="needs-validation" novalidate method="POST" action="/rapoarte/extrage-rezervari/raport-pdf">
                                                    @csrf

                                                        @foreach ($rezervari_pe_trasee->sortBy('oras_sosire_traseu')->groupBy('oras_sosire_traseu') as $rezervari_pe_trasee_pe_traseu_initial)
                                                            @forelse ($rezervari_pe_trasee_pe_traseu_initial->sortBy('oras_sosire_ordine')->groupBy('oras_sosire_ordine') as $rezervari_pe_trasee_pe_traseu_initial_pe_oras) 
                                                                @forelse ($rezervari_pe_trasee_pe_traseu_initial_pe_oras->sortBy('oras_plecare_nume') as $rezervare) 
                                                                    <input type="hidden" name="rezervari[]" value="{{ $rezervare->id }}">
                                                                @endforeach
                                                            @endforeach
                                                        @endforeach
                                                            <input type="hidden" name="tip_lista" value="lista_sosire"> 
                                                        <button type="submit" class="btn btn-sm bg-success text-white border border-light rounded-pill">
                                                            <i class="fas fa-file-pdf text-white mr-1"></i>Raport PDF
                                                        </button> 
                                                </form>
                                            </b>
                                        </td>
                                    </tr>  
                                @forelse ($rezervari_pe_trasee->sortBy('oras_sosire_traseu')->groupBy('oras_sosire_traseu') as $rezervari_pe_trasee_pe_traseu_initial) 
                                    @forelse ($rezervari_pe_trasee_pe_traseu_initial->sortBy('oras_sosire_ordine')->groupBy('oras_sosire_ordine') as $rezervari_pe_trasee_pe_traseu_initial_pe_oras) 
                                        @forelse ($rezervari_pe_trasee_pe_traseu_initial_pe_oras->sortBy('oras_plecare_nume') as $rezervare) 
                                    <tr>      
                                        <td>
                                            <a href="{{ $rezervare->path() }}">  
                                                <b>{{ $rezervare->nume }}</b>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            {{ $rezervare->oras_sosire_traseu ?? ''}}
                                        </td>
                                        <td>
                                            {{ $rezervare->oras_sosire_nume ?? ''}} ({{ $rezervare->oras_sosire_ordine ?? ''}})
                                        </td>
                                        <td class="text-center">
                                            {{ $rezervare->nr_adulti }}
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
                                                {{ $rezervari_pe_trasee->sum('nr_adulti') }}
                                            </b>
                                        </td>
                                    </tr>
                                    {{-- <tr>
                                        <td colspan="5" class="text-center">
                                            <a class="btn btn-sm bg-success text-white border border-dark rounded-pill" href="/rapoarte/extrage-pdf/{{ $rezervari_pe_trasee }}" role="button">
                                                <i class="fas fa-file-pdf text-white mr-1"></i>Raport PDF
                                            </a>
                                        </td>
                                    </tr> --}}
                                    <tr>
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
                                    </tr>
                                    <tr class="bg-dark">
                                        <td colspan="5" height="50">
                                            <p></p>
                                        </td>
                                    </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach




        </div>
    </div>
@endsection