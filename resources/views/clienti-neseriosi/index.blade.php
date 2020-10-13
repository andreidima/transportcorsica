@extends ('layouts.app')

@section('content')   
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3">
                <h4 class=" mb-0"><a href="{{ route('clienti-neseriosi.index') }}"><i class="fas fa-building mr-1"></i>Clienți neserioși</a></h4>
            </div> 
            <div class="col-lg-6">
                <form class="needs-validation" novalidate method="GET" action="{{ route('clienti-neseriosi.index') }}">
                    @csrf
                    <div class="row input-group custom-search-form">
                        <input type="text" class="form-control form-control-sm col-md-4 mr-1 border rounded-pill" id="search_nume" name="search_nume" placeholder="Nume" autofocus
                                value="{{ $search_nume }}">
                        <input type="text" class="form-control form-control-sm col-md-4 mr-1 border rounded-pill" id="search_nume" name="search_nume" placeholder="Telefon" autofocus
                                value="{{ $search_telefon }}">
                        <button class="btn btn-sm btn-primary col-md-4 mr-1 border border-dark rounded-pill" type="submit">
                            <i class="fas fa-search text-white mr-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-pill" href="{{ route('clienti-neseriosi.index') }}" role="button">
                            <i class="far fa-trash-alt text-white mr-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 text-right">
                <a class="btn btn-sm bg-success text-white border border-dark rounded-pill col-md-8" href="{{ route('service.clienti.create') }}" role="button">
                    <i class="fas fa-plus-square text-white mr-1"></i>Adaugă client
                </a>
            </div> 
        </div>

        <div class="card-body px-0 py-3">

            @if (session()->has('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-sm rounded"> 
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th>Nr. Crt.</th>
                            <th>Nume</th>
                            <th>Reprezentant</th>
                            <th>Telefon</th>
                            <th>Email</th>
                            <th class="text-center">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>               
                        @forelse ($clienti as $client) 
                            <tr>                  
                                <td align="">
                                    {{ ($clienti ->currentpage()-1) * $clienti ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    {{-- <a href="{{ $client->path() }}">  
                                        <b>{{ $client->nume }}</b>
                                    </a> --}}
                                    <a class="" data-toggle="collapse" href="#collapse{{ $client->id }}" role="button" 
                                        aria-expanded="false" aria-controls="collapse{{ $client->id }}">
                                        <b>{{ $client->nume }}</b>
                                    </a>
                                </td>
                                <td>
                                    {{ $client->reprezentant }}
                                </td>
                                <td>
                                    {{ $client->telefon }}
                                </td>
                                <td>
                                    {{ $client->email }}
                                </td>
                                <td class="d-flex justify-content-end">
                                    <a href="{{ $client->path() }}/modifica"
                                        class="flex"    
                                    >
                                        <span class="badge badge-primary">Modifică</span>
                                    </a>                                   
                                    <div style="flex" class="">
                                        <a 
                                            {{-- class="btn btn-danger btn-sm"  --}}
                                            href="#" 
                                            {{-- role="button" --}}
                                            data-toggle="modal" 
                                            data-target="#stergeClient{{ $client->id }}"
                                            title="Șterge Client"
                                            >
                                            {{-- <i class="far fa-trash-alt"></i> --}}
                                            <span class="badge badge-danger">Șterge</span>
                                        </a>
                                            <div class="modal fade text-dark" id="stergeClient{{ $client->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title text-white" id="exampleModalLabel">Client: <b>{{ $client->nume }}</b></h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body" style="text-align:left;">
                                                        Ești sigur ca vrei să ștergi Clientul?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>
                                                        
                                                        <form method="POST" action="{{ $client->path() }}">
                                                            @method('DELETE')  
                                                            @csrf   
                                                            <button 
                                                                type="submit" 
                                                                class="btn btn-danger"  
                                                                >
                                                                Șterge Client
                                                            </button>                    
                                                        </form>
                                                    
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div> 
                                </td>
                            </tr>  
                            <tr class="collapse bg-white" id="collapse{{ $client->id }}" 
                                {{-- style="background-color:cornsilk" --}}
                            >
                                <td colspan="6">
                                    <table class="table table-sm table-striped table-hover col-lg-6 mx-auto border"
                                {{-- style="background-color:#008282" --}}
                                    > 
                                        <tr>
                                            <td class="py-0">
                                                Nume
                                            </td>
                                            <td class="py-0">
                                                {{ $client->nume }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-0">
                                                Nr. ord. reg. com.
                                            </td>
                                            <td class="py-0">
                                                {{ $client->nr_ord_reg_com }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-0">
                                                Cui
                                            </td>
                                            <td class="py-0">
                                                {{ $client->cui }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-0">
                                                Adresa
                                            </td>
                                            <td class="py-0">
                                                {{ $client->adresa }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-0">
                                                Iban
                                            </td>
                                            <td class="py-0">
                                                {{ $client->iban }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-0">
                                                Banca
                                            </td>
                                            <td class="py-0">
                                                {{ $client->banca }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-0">
                                                Reprezentant
                                            </td>
                                            <td class="py-0">
                                                {{ $client->reprezentant }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-0">
                                                Functie
                                            </td>
                                            <td class="py-0">
                                                {{ $client->reprezentant_functie }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-0">
                                                Telefon
                                            </td>
                                            <td class="py-0">
                                                {{ $client->telefon }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-0">
                                                Email
                                            </td>
                                            <td class="py-0">
                                                {{ $client->email }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-0">
                                                Site web
                                            </td>
                                            <td class="py-0">
                                                {{ $client->site_web }}
                                            </td>
                                        </tr>
                                    </table>
                                    {{-- <div class="row">
                                        <div class="col-lg-3">
                                            Adresa: 
                                            <br>
                                            {{ $client->adresa }}
                                        </div>
                                        <div class="col-lg-3">
                                            Funcție reprezentant: 
                                            {{ $client->reprezentant_functie }}
                                        </div>
                                        <div class="col-lg-3">
                                            Nr.ord.reg.com.: {{ $client->nr_ord_reg_com }}
                                            <br>
                                            Cui: {{ $client->cui }}
                                        </div>
                                        <div class="col-lg-3">
                                            Banca: {{ $client->banca }}
                                            <br>
                                            Iban: {{ $client->iban }}                                            
                                        </div>
                                    </div> --}}
                                </td>
                            </tr> 
                            <tr class="collapse">
                                <td colspan="6">

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
                        {{$clienti->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection