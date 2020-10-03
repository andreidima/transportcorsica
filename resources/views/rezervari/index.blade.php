@extends ('layouts.app')

@section('content')   
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header justify-content-between py-1" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3 align-self-center">
                <h4 class=" mb-0">
                    <a href="{{ route('rezervari.index') }}"><i class="fas fa-address-card mr-1"></i>Rezervări</a>
                </h4>
            </div> 
            <div class="col-lg-6" id="app1">
                <form class="needs-validation" novalidate method="GET" action="{{ route('rezervari.index') }}">
                    @csrf                    
                    <div class="row input-group custom-search-form justify-content-center">
                        <div class="col-md-4 px-1">
                            <input type="text" class="form-control form-control-sm border rounded-pill mb-1 py-0" 
                            id="search_nume" name="search_nume" placeholder="Client"
                                    value="{{ $search_nume }}">
                        </div>
                        <div class="col-md-4 px-1">
                            <label for="search_data" class="mb-0 align-self-center mr-1">Data:</label>
                            <vue2-datepicker
                                data-veche="{{ $search_data }}"
                                nume-camp-db="search_data"
                                tip="date"
                                latime="100"
                            ></vue2-datepicker>
                        </div>
                        <div class="col-md-4 px-1">
                            <button class="btn btn-sm btn-primary col-md-12 border border-dark rounded-pill" type="submit">
                                <i class="fas fa-search text-white mr-1"></i>Caută
                            </button>
                        </div>
                        <div class="col-md-4 px-1">
                            <a class="btn btn-sm bg-secondary text-white col-md-12 border border-dark rounded-pill" href="{{ route('rezervari.index') }}" role="button">
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
                            <th>Nr. Crt.</th>
                            <th>Nume</th>
                            <th>Telefon</th>
                            <th>Nr. pers.</th>
                            <th>Oraș plecare</th>
                            <th>Oraș sosire</th>
                            <th class="text-center">Tur retur</th>
                            <th>Data cursă</th>
                            <th>Pret</th>
                            <th class="text-center">Plătit</th>                         
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
                                        <b>{{ $rezervare->nume }}</b>
                                    </a>
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
                                <td class="text-center">
                                    {{ $rezervare->tur_retur ? 'DA' : 'NU' }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($rezervare->data_cursa)->isoFormat('DD.MM.YYYY') }}
                                </td>
                                <td>
                                    {{ $rezervare->pret_total }}
                                </td>
                                <td class="text-center">
                                    @if(isset($rezervare->plata_efectuata))
                                        <span class="text-success">DA</span>
                                    @else
                                        <span class="text-danger">NU</span>
                                    @endif
                                </td>
                                <td class="text-right"> 
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ $rezervare->path() }}"
                                            class="flex mr-1"    
                                        >
                                            <span class="badge badge-success">Vizualizează</span>
                                        </a> 
                                        {{-- <a href="{{ $service_fisa->path() }}/modifica"
                                            class="flex mr-1"    
                                        >
                                            <span class="badge badge-primary">Modifică</span>
                                        </a>      --}}
                                        {{-- <div style="" class="">
                                            <a 
                                                href="#" 
                                                data-toggle="modal" 
                                                data-target="#stergeFișa{{ $service_fisa->id }}"
                                                title="Șterge Fișa"
                                                >
                                                <span class="badge badge-danger">Șterge</span>
                                            </a>
                                                <div class="modal fade text-dark" id="stergeFișa{{ $service_fisa->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header bg-danger">
                                                            <h5 class="modal-title text-white" id="exampleModalLabel">Fișa: <b>{{ $service_fisa->nr_fisa }}</b></h5>
                                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" style="text-align:left;">
                                                            Ești sigur ca vrei să ștergi Fișa?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>
                                                            
                                                            <form method="POST" action="{{ $service_fisa->path() }}">
                                                                @method('DELETE')  
                                                                @csrf   
                                                                <button 
                                                                    type="submit" 
                                                                    class="btn btn-danger"  
                                                                    >
                                                                    Șterge Fișa
                                                                </button>                    
                                                            </form>
                                                        
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>  --}}
                                    </div>
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
                        {{$rezervari->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection