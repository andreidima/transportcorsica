@extends ('layouts.app')

@section('content')   
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3">
                <h4 class=" mb-0"><a href="{{ route('facturi.index') }}"><i class="fas fa-file-invoice mr-1"></i>Facturi</a></h4>
            </div> 
            {{-- <div class="col-lg-6">
                <form class="needs-validation" novalidate method="GET" action="{{ route('facturi.index') }}">
                    @csrf
                    <div class="row mb-1 input-group custom-search-form justify-content-center">
                        <input type="text" class="form-control form-control-sm col-md-4 mr-1 border rounded-pill" id="search_nume" name="search_nume" placeholder="Nume" autofocus
                                value="{{ $search_nume }}">
                        <input type="text" class="form-control form-control-sm col-md-4 mr-1 border rounded-pill" id="search_telefon" name="search_telefon" placeholder="Telefon" autofocus
                                value="{{ $search_telefon }}">
                    </div>
                    <div class="row input-group custom-search-form justify-content-center">
                        <button class="btn btn-sm btn-primary col-md-4 mr-1 border border-dark rounded-pill" type="submit">
                            <i class="fas fa-search text-white mr-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-pill" href="{{ route('facturi.index') }}" role="button">
                            <i class="far fa-trash-alt text-white mr-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 text-right">
                <a class="btn btn-sm bg-success text-white border border-dark rounded-pill col-md-8" href="{{ route('facturi.create') }}" role="button">
                    <i class="fas fa-plus-square text-white mr-1"></i>Adaugă client
                </a>
            </div>  --}}
        </div>

        <div class="card-body px-0 py-3">

            @include ('errors')

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-sm rounded"> 
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th>Nr. Crt.</th>
                            <th>Factura</th>
                            <th>Rezervare</th>
                            <th>Cumpărător</th>
                            <th>Nr. Reg. Com.</th>
                            <th>CIF</th>
                            <th>Sediul</th>
                            <th>PDF</th>
                            {{-- <th class="text-center">Acțiuni</th> --}}
                        </tr>
                    </thead>
                    <tbody>               
                        @forelse ($facturi as $factura) 
                            <tr>                  
                                <td align="">
                                    {{ ($facturi ->currentpage()-1) * $facturi ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    {{ $factura->seria }}{{ $factura->numar }}
                                </td>
                                <td>
                                    <a href="{{ $factura->rezervare->path() }}">
                                        @isset($factura->rezervare->nr_adulti)
                                            @foreach ($factura->rezervare->pasageri_relation as $pasager)
                                                @if(!$loop->last)
                                                    {{ $pasager->nume }},
                                                @else
                                                    {{ $pasager->nume }}
                                                @endif
                                            @endforeach
                                        @else
                                            Rezervare bagaj
                                        @endif
                                    </a>
                                </td>
                                <td>
                                    {{ $factura->cumparator }}
                                </td>
                                <td>
                                    {{ $factura->nr_reg_com }}
                                </td>
                                <td>
                                    {{ $factura->cif }}
                                </td>
                                <td>
                                    {{ $factura->sediul }}
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
                        {{$facturi->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>

@endsection