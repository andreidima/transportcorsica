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
                <a class="btn btn-sm bg-success text-white border border-dark rounded-pill col-md-8" href="{{ route('clienti-neseriosi.create') }}" role="button">
                    <i class="fas fa-plus-square text-white mr-1"></i>Adaugă client
                </a>
            </div> 
        </div>

        <div class="card-body px-0 py-3">

            @include ('errors')

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-sm rounded"> 
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th>Nr. Crt.</th>
                            <th>Nume</th>
                            <th>Telefon</th>
                            <th>Observații</th>
                            <th class="text-center">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>               
                        @forelse ($clienti_neseriosi as $client) 
                            <tr>                  
                                <td align="">
                                    {{ ($clienti_neseriosi ->currentpage()-1) * $clienti_neseriosi ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    {{-- <a href="{{ $client->path() }}">  
                                        <b>{{ $client->nume }}</b>
                                    </a> --}}
                                    {{-- <a class="" data-toggle="collapse" href="#collapse{{ $client->id }}" role="button" 
                                        aria-expanded="false" aria-controls="collapse{{ $client->id }}"> --}}
                                        <b>{{ $client->nume }}</b>
                                    {{-- </a> --}}
                                </td>
                                <td>
                                    {{ $client->telefon }}
                                </td>
                                <td>
                                    {{ $client->observatii }}
                                </td>
                                <td class="d-flex justify-content-end">
                                    <a href="{{ $client->path() }}/modifica"
                                        class="flex"    
                                    >
                                        <span class="badge badge-primary">Modifică</span>
                                    </a>                                   
                                    <div style="flex" class="">
                                        <a 
                                            href="#" 
                                            data-toggle="modal" 
                                            data-target="#stergeClient{{ $client->id }}"
                                            title="Șterge Client"
                                            >
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
                        @empty
                            {{-- <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div> --}}
                        @endforelse
                        </tbody>
                </table>
            </div>

                <nav>
                    <ul class="pagination pagination-sm justify-content-center">
                        {{$clienti_neseriosi->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection