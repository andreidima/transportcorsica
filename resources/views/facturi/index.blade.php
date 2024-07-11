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
                            <th>Data</th>
                            <th class="text-center">PDF</th>
                            <th class="text-right">Acțiuni</th>
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
                                    @isset($factura->rezervare)
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
                                                Rezervare colete
                                            @endif
                                        </a>
                                    @endisset
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
                                <td>
                                    {{ \Carbon\Carbon::parse($factura->created_at)->isoFormat('DD.MM.YYYY') ?? ''}}
                                </td>
                                <td class="text-center">
                                    <a href="/facturi/{{ $factura->id }}/export/export-pdf">
                                        <i class="fas fa-file-pdf fa-lg bg-white text-danger"></i>
                                    </a>
                                </td>
                                <td class="text-right">
                                    <div class="justify-content-end">
                                        <a href="/facturi/{{ $factura->id }}/trimite-in-smartbill">
                                            <span class="badge badge-success" title="În paranteză se afișează de câte ori factura a fost trimisă în Smartbill.">
                                                Trimite Smartbill ({{ $factura->nr_trimiteri_in_smartbill }})
                                            </span>
                                        </a>
                                        @if($factura->anulata === 1)
                                            Anulată
                                        @elseif($factura->anulare_factura_id_originala !== null)
                                            Storno
                                        @else
                                            <div style="" class="">
                                                <a
                                                    href="#"
                                                    data-toggle="modal"
                                                    data-target="#activeazaAnuleazaFactura{{ $factura->id }}"
                                                    title="Activeaza Anuleaza Factura"
                                                    >
                                                        @if ($factura->anulata === 1)
                                                            <span class="badge badge-primary">
                                                                Activează
                                                            </span>
                                                        @else
                                                            <span class="badge badge-warning">
                                                                Anulează
                                                            </span>
                                                        @endif
                                                </a>
                                            </div>
                                        @endif
                                        @if ($factura->id === App\Models\Factura::latest()->first()->id)
                                            <div style="" class="">
                                                <a
                                                    href="#"
                                                    data-toggle="modal"
                                                    data-target="#stergeFactura{{ $factura->id }}"
                                                    title="Șterge Factura"
                                                    >
                                                    <span class="badge badge-danger">Șterge</span>
                                                </a>
                                            </div>
                                        @endif
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
                        {{$facturi->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>


    {{-- Modalele --}}
        @forelse ($facturi as $factura)
            {{-- Modal pentru butonul de stergere --}}
            <div class="modal fade text-dark" id="activeazaAnuleazaFactura{{ $factura->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                {{-- data-backdrop="false" --}}
            >
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title text-white" id="exampleModalLabel">
                            Factura pentru
                            <b>
                                {{ $factura->cumparator }}
                            </b>
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form method="POST" action="{{ $factura->path() }}/anuleaza">
                        @method('PATCH')
                        @csrf

                        <div class="modal-body" style="text-align:left;">
                            @if ($factura->anulata === 1)
                                Ești sigur ca vrei să activezi factura?
                            @else
                                Ești sigur ca vrei să anulezi factura?
                                <div class="form-row">
                                    <div class="form-group col-lg-12">
                                        <label for="anulare_motiv" class="mb-0 pl-3">Motiv anulare:</label>
                                        <textarea class="form-control {{ $errors->has('anulare_motiv') ? 'is-invalid' : '' }}"
                                            name="anulare_motiv"
                                            rows="2"
                                        >{{ old('anulare_motiv', ($factura->anulare_motiv ?? '')) }}</textarea>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>

                                <button
                                    type="submit"
                                    class="btn btn-danger"
                                    >
                                    {{ ($factura->anulata === 1) ? 'Activează factura' : 'Anulează factura' }}
                                </button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        @empty
            {{-- <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div> --}}
        @endforelse

    {{-- Modalele pentru stergere factura --}}
    @foreach ($facturi as $factura)
        <div class="modal fade text-dark" id="stergeFactura{{ $factura->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Factură: <b>{{ $factura->numar }}</b></h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="text-align:left;">
                    Ești sigur ca vrei să ștergi Factura?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>

                    <form method="POST" action="{{ $factura->path() }}">
                        @method('DELETE')
                        @csrf
                        <button
                            type="submit"
                            class="btn btn-danger"
                            >
                            Șterge Factura
                        </button>
                    </form>

                </div>
                </div>
            </div>
        </div>
    @endforeach


@endsection
