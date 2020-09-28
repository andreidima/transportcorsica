@extends ('layouts.app')

@section('content')   
<div class="container card">
        <div class="row card-header align-items-center">
            <div class="col-lg-4">
                <h4 class=" mb-0"><a href="{{ route('rezervari.index') }}"><i class="fas fa-list-ul mr-1"></i>Rezervări</a></h4>
            </div> 
            <div class="col-lg-8">
                <form class="needs-validation" novalidate method="GET" action="{{ route('rezervari.index') }}">
                    @csrf                    
                    <div class=" row input-group custom-search-form">
                        <input type="text" class="form-control form-control-sm col-md-3 mr-1 border rounded-pill" id="search_nume" name="search_nume" placeholder="Nume" autofocus
                                value="{{ $search_nume }}">
                        <button class="btn btn-sm btn-primary col-md-3 mr-4 border border-dark rounded-pill" type="submit">
                            <i class="fas fa-search text-white mr-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-3 border border-dark rounded-pill" href="{{ route('rezervari.index') }}" role="button">
                            <i class="far fa-trash-alt text-white mr-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card-body px-0 py-3">

            @if (session()->has('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-hover table-sm"> 
                    <thead class="text-white" style="background-color:brown">
                        <tr class="">
                            <th>Nr. Crt.</th>
                            <th>Nume</th>
                            <th>Telefon</th>
                            <th>Nr. pers.</th>
                            <th>Oraș plecare</th>
                            <th>Oraș sosire</th>
                            <th>Tur retur</th>
                            <th>Data plecare</th>
                            <th>Data intoarcere</th>
                            <th>Pret</th>
                            <th>Plătit</th>
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
                                    {{ $rezervare->oras_plecare_nume->nume }}
                                </td>
                                <td>
                                    {{ $rezervare->oras_sosire_nume->nume }}
                                </td>
                                <td>
                                    {{ $rezervare->tur_retur ? 'DA' : 'NU' }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($rezervare->data_plecare)->isoFormat('D.MM.YYYY') }}
                                </td>
                                <td>
                                    {{ $rezervare->data_intoarcere ? \Carbon\Carbon::parse($rezervare->data_intoarcere)->isoFormat('D.MM.YYYY') : '-' }}
                                </td>
                                <td>
                                    {{ $rezervare->pret_total }}
                                </td>
                                <td>
                                    @if(isset($rezervare->plata_efectuata))
                                        <span class="text-success">DA</span>
                                    @else
                                        <span class="text-danger">NU</span>
                                    @endif
                                </td>
                            </tr>                                          
                        @empty
                            {{-- <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div> --}}
                        @endforelse
                        </tbody>
                </table>
            </div>

                <nav>
                    <ul class="pagination justify-content-center">
                        {{$rezervari->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection