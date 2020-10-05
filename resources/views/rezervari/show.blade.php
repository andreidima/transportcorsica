@extends ('layouts.app')

@section('content')   
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:lightseagreen">
                    <h6 class="ml-4 my-0" style="color:white"><i class="fas fa-address-card mr-1"></i>Rezervări / {{ $rezervare->nume }}</h6>
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
                                <div class="row mb-3 d-flex justify-content-center">
                                    <div class="col-lg-11 px-0 border rounded-lg">
                                        <h5 class="bg-warning p-1 m-0 text-center">
                                            Informații călătorie
                                        </h5>
                                    </div>
                                    <div class="col-lg-11 p-4 mb-4 bg-white border rounded-lg">
                                        <div class="row text-center">
                                            <div class="col-lg-3">
                                                Data de plecare:
                                                <br>
                                                <span class="badge badge-primary" style="font-size:1.1em">
                                                    {{ \Carbon\Carbon::parse($rezervare->data_cursa)->isoFormat('DD.MM.YYYY') }}
                                                </span>
                                            </div>
                                            <div class="col-lg-4">
                                                Oraș plecare:
                                                <br>
                                                <span class="badge badge-primary" style="font-size:1.1em">
                                                    {{ $rezervare->oras_plecare_nume->oras }}
                                                </span>
                                            </div>
                                            <div class="col-lg-1 pt-1 text-primary">
                                                    <i class="fas fa-long-arrow-alt-right fa-4x"></i>
                                            </div>
                                            <div class="col-lg-4">
                                                Oraș sosire:
                                                <br>
                                                <span class="badge badge-primary" style="font-size:1.1em">
                                                    {{ $rezervare->oras_sosire_nume->oras }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @if ($rezervare->nr_adulti)
                                    <div class="col-lg-11 px-0 border rounded-lg">
                                        <h5 class="bg-warning p-1 m-0 text-center">
                                            Informații pasageri
                                        </h5>
                                    </div>
                                    <div class="col-lg-11 px-4 py-2 bg-white border rounded-lg">
                                        <div class="row justify-content-center">
                                            <div class="col-lg-4">
                                                Număr pasageri: 
                                                <span class="badge badge-primary" style="font-size:1em">{{ $rezervare->nr_adulti }}</span>
                                            </div>
                                            <div class="col-lg-4">
                                                Preț total: 
                                                <span class="badge badge-primary" style="font-size:1em">{{ $rezervare->pret_total }}€</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-11 px-4 py-2 mb-4 bg-white border rounded-lg">
                                        <div class="row justify-content-between">
                                            @foreach ($rezervare->pasageri_relation as $pasager)
                                                <div class="col-lg-5 m-2" style="border-bottom: solid 1px #005757">
                                                    Nume: <span class="badge badge-primary" style="font-size:1.1em">{{ $pasager->nume }}</span>
                                                    <br>
                                                    Seria și nr. buletin: {{ $pasager->buletin }}
                                                    <br>
                                                    Data nașterii: {{ $pasager->data_nastere }}
                                                    <br>
                                                    Localitate naștere: {{ $pasager->localitate_nastere }}
                                                    <br>
                                                    Localitate domiciliu: {{ $pasager->localitate_domiciliu }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>        
                                    {{-- @php
                                        if(App\Models\Pasager::find(1)->rezervari->count()){
                                            dd('dada');
                                        }
                                        else {
                                            dd('nunu');
                                        }
                                    @endphp                         --}}
                                @else
                                    <div class="col-lg-11 px-0 border rounded-lg">
                                        <h5 class="bg-warning p-1 m-0 text-center">
                                            Informații bagaj
                                        </h5>
                                    </div>
                                    <div class="col-lg-11 px-4 py-2 bg-white border rounded-lg">
                                        {{ $rezervare->bagaje_descriere }}</span>
                                        {{-- * {{ $tarife->adult }}€ = {{ $rezervare->nr_adulti * $tarife->adult}}€ --}}
                                    </div>
                                    <div class="col-lg-11 px-4 py-2 mb-4 bg-white border rounded-lg">
                                        Catitate: <span class="badge badge-primary" style="font-size:1em">{{ $rezervare->bagaje_kg }} Kg</span>
                                    </div>
                                @endif
                                    <div class="col-lg-11 px-0 border rounded-lg">
                                        <h5 class="bg-warning p-1 m-0 text-center">
                                            Informații client
                                        </h5>
                                    </div>
                                    <div class="col-lg-11 px-4 py-2 mb-4 bg-white border rounded-lg">
                                        Nume: <span class="badge badge-primary" style="font-size:1.1em">{{ $rezervare->nume }}</span>
                                        <br>
                                        Telefon: <b>{{ $rezervare->telefon }}</b>
                                        <br>
                                        Email: <b>{{ $rezervare->email }}</b>
                                        <br>
                                        Observații: {{ $rezervare->observatii }}
                                    </div>

                                    <div class="col-lg-11 px-0 border rounded-lg">
                                        <h5 class="bg-warning p-1 m-0 text-center">
                                            Date pentru facturare
                                        </h5>
                                    </div>
                                    <div class="col-lg-11 px-4 py-2 mb-2 bg-white border rounded-lg">
                                        Document de călătorie: {{ $rezervare->document_de_calatorie }}
                                        <br>
                                        {{-- Data expirării documentului: 
                                            @if ($rezervare->expirare_document !== null)
                                                {{ \Carbon\Carbon::parse($rezervare->expirare_document)->isoFormat('DD.MM.YYYY') }}    
                                            @endif                                        
                                        <br> --}}
                                        Seria buletin / pașaport:: {{ $rezervare->serie_document }}
                                        <br>
                                        Cnp: {{ $rezervare->cnp }}
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