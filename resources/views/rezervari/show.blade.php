@extends ('layouts.app')

@section('content')   
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:lightseagreen">
                    <h6 class="ml-4 my-0" style="color:white"><i class="fas fa-address-card mr-1"></i>
                        Rezervări / 
                        @foreach ($rezervare_tur->pasageri_relation as $pasager)
                            {{ $pasager->nume }}
                        @endforeach
                    </h6>
                </div>

                <div class="card-body py-2" 
                    style="
                        /* color:ivory;  */
                        background-color:darkcyan; 
                        border-radius: 0px 0px 40px 40px
                    "
                >

                        <div class="row mb-0 d-flex justify-content-center border-radius: 0px 0px 40px 40px">
                            <div class="col-lg-12 p-4 mb-0">
                                <div class="row mb-0 d-flex justify-content-center">
                                    <div class="col-lg-11 px-0 border rounded-lg">
                                        <h5 class="bg-success p-1 m-0 text-center">
                                            Informații călătorie
                                        </h5>
                                    </div>
                                    <div class="col-lg-11 p-4 mb-4 bg-white border rounded-lg">
                                        <div class="row text-center">
                                            <div class="col-lg-3">
                                                Data de plecare:
                                                <br>
                                                <span class="badge badge-primary" style="font-size:1.1em">
                                                    {{ \Carbon\Carbon::parse($rezervare_tur->data_cursa)->isoFormat('DD.MM.YYYY') }}
                                                </span>
                                            </div>
                                            <div class="col-lg-4">
                                                Oraș plecare:
                                                <br>
                                                <span class="badge badge-primary" style="font-size:1.1em">
                                                    {{ $rezervare_tur->oras_plecare_nume->oras ?? '' }}
                                                </span>
                                            </div>
                                            <div class="col-lg-1 pt-1 text-primary">
                                                    <i class="fas fa-long-arrow-alt-right fa-4x"></i>
                                            </div>
                                            <div class="col-lg-4">
                                                Oraș sosire:
                                                <br>
                                                <span class="badge badge-primary" style="font-size:1.1em">
                                                    {{ $rezervare_tur->oras_sosire_nume->oras ?? '' }}
                                                </span>
                                            </div>
                                        </div>
                                        @if ($rezervare_retur)
                                            <div class="row text-center">
                                                <div class="col-lg-12 text-primary">
                                                    <hr class="bg-primary">
                                                </div>
                                                <div class="col-lg-3">
                                                    Data de întoarcere:
                                                    <br>
                                                    <span class="badge badge-primary" style="font-size:1.1em">
                                                        {{ \Carbon\Carbon::parse($rezervare_retur->data_cursa)->isoFormat('DD.MM.YYYY') }}
                                                    </span>
                                                </div>
                                                <div class="col-lg-4">
                                                    Oraș sosire:
                                                    <br>
                                                    <span class="badge badge-primary" style="font-size:1.1em">
                                                        {{ $rezervare_retur->oras_sosire_nume->oras ?? '' }}
                                                    </span>
                                                </div>
                                                <div class="col-lg-1 pt-1 text-primary">
                                                        <i class="fas fa-long-arrow-alt-left fa-4x"></i>
                                                </div>
                                                <div class="col-lg-4">
                                                    Oraș plecare:
                                                    <br>
                                                    <span class="badge badge-primary" style="font-size:1.1em">
                                                        {{ $rezervare_retur->oras_plecare_nume->oras ?? '' }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @if ($rezervare_tur->nr_adulti)
                                    <div class="col-lg-11 px-0 border rounded-lg">
                                        <h5 class="bg-success p-1 m-0 text-center">
                                            Informații pasageri
                                        </h5>
                                    </div>
                                    <div class="col-lg-11 px-4 py-2 bg-white border rounded-lg">
                                        <div class="row justify-content-center">
                                            <div class="col-lg-4">
                                                Număr pasageri: 
                                                <span class="badge badge-primary" style="font-size:1em">{{ $rezervare_tur->nr_adulti + $rezervare_tur->nr_copii }}</span>
                                            </div>
                                            <div class="col-lg-4">
                                                {{-- Preț total: 
                                                <span class="badge badge-primary" style="font-size:1em">{{ $rezervare_tur->pret_total }}€</span> --}}
                                                @if ($rezervare_retur && ($rezervare_retur->pret_total > 0))
                                                    <span style="margin-right:50px">
                                                        Preț tur: <b>{{ $rezervare_tur->pret_total }}Euro</b>
                                                    </span>
                                                    <span>
                                                        Preț retur: <b>{{ $rezervare_retur->pret_total }}Euro</b>
                                                    </span>
                                                @else
                                                    <span>
                                                        Preț total: <b>{{ $rezervare_tur->pret_total }}Euro</b>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-11 px-4 py-2 mb-4 bg-white border rounded-lg">
                                        <div class="row justify-content-between">
                                            @foreach ($rezervare_tur->pasageri_relation as $pasager)
                                                <div class="col-lg-5 m-2" style="border-bottom: solid 1px #005757">
                                                    Nume: <span class="badge badge-primary" style="font-size:1.1em">{{ $pasager->nume }}</span>
                                                    {{-- <br>
                                                    Seria și nr. buletin: {{ $pasager->buletin }} --}}
                                                    <br>
                                                    Data nașterii: {{ $pasager->data_nastere }}
                                                    <br>
                                                    Localitate naștere: {{ $pasager->localitate_nastere }}
                                                    {{-- <br>
                                                    Localitate domiciliu: {{ $pasager->localitate_domiciliu }} --}}
                                                    <br>
                                                    Sex: {{ $pasager->sex }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>        
                                @else
                                    <div class="col-lg-11 px-0 border rounded-lg">
                                        <h5 class="bg-success p-1 m-0 text-center">
                                            Informații bagaj
                                        </h5>
                                    </div>
                                    <div class="col-lg-11 px-4 py-2 bg-white border rounded-lg">
                                        {{ $rezervare_tur->bagaje_descriere }}</span>
                                        {{-- * {{ $tarife->adult }}€ = {{ $rezervare_tur->nr_adulti * $tarife->adult}}€ --}}
                                    </div>
                                    <div class="col-lg-11 px-4 py-2 mb-4 bg-white border rounded-lg">
                                        Catitate: <span class="badge badge-primary" style="font-size:1em">{{ $rezervare_tur->bagaje_kg }} Kg</span>
                                    </div>
                                @endif
                                    <div class="col-lg-11 px-0 border rounded-lg">
                                        <h5 class="bg-success p-1 m-0 text-center">
                                            Informații client
                                        </h5>
                                    </div>
                                    <div class="col-lg-11 px-4 py-2 mb-4 bg-white border rounded-lg">
                                        {{-- Nume: <span class="badge badge-primary" style="font-size:1.1em">{{ $rezervare_tur->nume }}</span>
                                        <br> --}}
                                        Telefon: <b>{{ $rezervare_tur->telefon }}</b>
                                        <br>
                                        Email: <b>{{ $rezervare_tur->email }}</b>
                                        <br>
                                        Observații: {{ $rezervare_tur->observatii }}
                                    </div>

                                @if ($rezervare_tur->factura)
                                    <div class="col-lg-11 px-0 border rounded-lg">
                                        <h5 class="bg-success text-white p-1 m-0 text-center">
                                            Date pentru facturare
                                        </h5>
                                    </div>
                                    <div class="col-lg-11 px-4 py-2 mb-2 bg-white border rounded-lg">
                                        Cumpărător: {{ $rezervare_tur->factura->cumparator }}
                                        <br>
                                        Nr. Reg. Com.: {{ $rezervare_tur->factura->nr_reg_com }}
                                        <br>
                                        CIF: {{ $rezervare_tur->factura->cif }}
                                        <br>
                                        Sediul: {{ $rezervare_tur->factura->sediul }}
                                    </div>
                                @endif

                                    <div class="col-lg-12 mb-0 d-flex justify-content-center">   
                                        <a class="btn bg-success text-white border border-dark rounded-pill mr-1" href="/chitanta-descarca/{{ $rezervare_tur->cheie_unica }}/export-pdf" target="_target" role="button">
                                            Descarcă bilet
                                        </a> 
                                        <a class="btn bg-success text-white border border-dark rounded-pill mr-1" href="/bilet-rezervat-user-logat/rezervare-pdf/{{ $rezervare_tur->id }}/{{ $rezervare_retur->id ?? ''}}" role="button">
                                            Descarcă rezervare
                                        </a>
                                        <a class="btn bg-primary text-white border border-dark rounded-pill" href="{{ route('rezervari.index') }}" role="button">
                                            Înapoi la Rezervări
                                        </a> 
                                    </div>

                                </div>  
                                

                            </div>
                        </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection