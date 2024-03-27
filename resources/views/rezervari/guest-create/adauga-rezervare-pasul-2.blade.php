@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="shadow-lg bg-white" style="border-radius: 40px 40px 40px 40px;">
                <div class="p-2 d-flex justify-content-between align-items-end"
                    style="border-radius: 40px 40px 0px 0px; border:2px solid darkcyan">
                    <h3 class="ml-3" style="color:darkcyan"><i class="fas fa-ticket-alt fa-lg mr-1"></i>Verificare bilet călătorie</h3>
                    <img src="{{ asset('images/logo.png') }}" height="70" class="mr-3">
                </div>

                @include ('errors')

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
                                        <h5 class="bg-success text-white p-1 m-0 text-center">
                                            Informații călătorie
                                        </h5>
                                    </div>
                                    <div class="col-lg-11 p-4 mb-4 bg-white border rounded-lg">
                                        <div class="row text-center">
                                            <div class="col-lg-3">
                                                Data de plecare:
                                                <br>
                                                <span class="badge badge-primary" style="font-size:1.1em">
                                                    {{ $rezervare->data_plecare ? \Carbon\Carbon::parse($rezervare->data_plecare)->isoFormat('DD.MM.YYYY') : ''}}
                                                </span>
                                            </div>
                                            <div class="col-lg-4">
                                                Oraș plecare:
                                                <br>
                                                <span class="badge badge-primary" style="font-size:1.1em">
                                                    {{ $rezervare->oras_plecare_nume->oras ?? '' }}
                                                </span>
                                            </div>
                                            <div class="col-lg-1 pt-1 text-primary">
                                                    <i class="fas fa-long-arrow-alt-right fa-4x"></i>
                                            </div>
                                            <div class="col-lg-4">
                                                Oraș sosire:
                                                <br>
                                                <span class="badge badge-primary" style="font-size:1.1em">
                                                    {{ $rezervare->oras_sosire_nume->oras ?? '' }}
                                                </span>
                                            </div>
                                        </div>
                                        @if (($rezervare->tur_retur === "true") || ($rezervare->tur_retur === 1))
                                            <div class="row text-center">
                                                <div class="col-lg-12 text-primary">
                                                    <hr class="bg-primary">
                                                </div>
                                                <div class="col-lg-3">
                                                    Data de întoarcere:
                                                    <br>
                                                    <span class="badge badge-primary" style="font-size:1.1em">
                                                        {{ $rezervare->data_intoarcere ? \Carbon\Carbon::parse($rezervare->data_intoarcere)->isoFormat('DD.MM.YYYY') : '' }}
                                                    </span>
                                                </div>
                                                <div class="col-lg-4">
                                                    Oraș sosire:
                                                    <br>
                                                    <span class="badge badge-primary" style="font-size:1.1em">
                                                        {{ $rezervare->oras_plecare_nume->oras ?? '' }}
                                                    </span>
                                                </div>
                                                <div class="col-lg-1 pt-1 text-primary">
                                                        <i class="fas fa-long-arrow-alt-left fa-4x"></i>
                                                </div>
                                                <div class="col-lg-4">
                                                    Oraș plecare:
                                                    <br>
                                                    <span class="badge badge-primary" style="font-size:1.1em">
                                                        {{ $rezervare->oras_sosire_nume->oras ?? '' }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @if ($rezervare->tip_calatorie === "Calatori")
                                    <div class="col-lg-11 px-0 border rounded-lg">
                                        <h5 class="bg-success text-white p-1 m-0 text-center">
                                            Informații pasageri
                                        </h5>
                                    </div>
                                    <div class="col-lg-11 px-4 py-2 bg-white border rounded-lg">
                                        <div class="row justify-content-center">
                                            <div class="col-lg-4">
                                                Număr pasageri:
                                                <span class="badge badge-primary" style="font-size:1em">{{ $rezervare->nr_adulti + $rezervare->nr_copii }}</span>
                                            </div>
                                            <div class="col-lg-4">
                                                Preț total:
                                                <span class="badge badge-primary" style="font-size:1em">{{ $rezervare->pret_total_tur + $rezervare->pret_total_retur }}€</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-11 px-4 py-2 mb-4 bg-white border rounded-lg">
                                        <div class="row justify-content-between">
                                            @for ($i = 1 ; $i <= $rezervare->nr_adulti ; $i++)
                                                <div class="col-lg-5 m-2" style="border-bottom: solid 1px #005757">
                                                    Nume: <span class="badge badge-primary" style="font-size:1.1em">{{ $rezervare->adulti['nume'][$i] }}</span>
                                                    {{-- <br>
                                                    Seria și nr. buletin: {{ $rezervare->adulti['buletin'][$i] }} --}}
                                                    <br>
                                                    Data nașterii: {{ $rezervare->adulti['data_nastere'][$i] }}
                                                    <br>
                                                    Localitate naștere: {{ $rezervare->adulti['localitate_nastere'][$i] }}
                                                    {{-- <br>
                                                    Localitate domiciliu: {{ $rezervare->adulti['localitate_domiciliu'][$i] }} --}}
                                                    <br>
                                                    Sex: {{ $rezervare->adulti['sex'][$i] ?? ''}}
                                                    <br>
                                                    Act de identitate: {{ $rezervare->adulti['document'][$i] ?? ''}}
                                                    <br>
                                                    Număr act de identitate: {{ $rezervare->adulti['document_nr'][$i] ?? ''}}
                                                </div>
                                            @endfor
                                            @for ($i = 1 ; $i <= $rezervare->nr_copii ; $i++)
                                                <div class="col-lg-5 m-2" style="border-bottom: solid 1px #005757">
                                                    Nume: <span class="badge badge-primary" style="font-size:1.1em">{{ $rezervare->copii['nume'][$i] }}</span>
                                                    {{-- <br>
                                                    Seria și nr. buletin: {{ $rezervare->copii['buletin'][$i] }} --}}
                                                    <br>
                                                    Data nașterii: {{ $rezervare->copii['data_nastere'][$i] }}
                                                    <br>
                                                    Localitate naștere: {{ $rezervare->copii['localitate_nastere'][$i] }}
                                                    {{-- <br>
                                                    Localitate domiciliu: {{ $rezervare->copii['localitate_domiciliu'][$i] }} --}}
                                                    <br>
                                                    Sex: {{ $rezervare->copii['sex'][$i] ?? ''}}
                                                    <br>
                                                    Act de identitate: {{ $rezervare->copii['document'][$i] ?? ''}}
                                                    <br>
                                                    Număr act de identitate: {{ $rezervare->copii['document_nr'][$i] ?? ''}}
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="col-lg-11 px-0 border rounded-lg">
                                        <h5 class="bg-success text-white p-1 m-0 text-center">
                                            Informații client
                                        </h5>
                                    </div>
                                    <div class="col-lg-11 px-4 py-2 mb-4 bg-white border rounded-lg">
                                        {{-- Nume: <span class="badge badge-primary" style="font-size:1.1em">{{ $rezervare->nume }}</span>
                                        <br> --}}
                                        Telefon: <b>{{ $rezervare->telefon }}</b>
                                        <br>
                                        Email: <b>{{ $rezervare->email }}</b>
                                        <br>
                                        {{-- Pasageri: {{ $rezervare->pasageri }} --}}
                                        <br>
                                        Observații: {{ $rezervare->observatii }}
                                    </div>
                                @elseif ($rezervare->tip_calatorie === "Colete")
                                    <div class="col-lg-11 px-0 border rounded-lg">
                                        <h5 class="bg-success text-white p-1 m-0 text-center">
                                            Informații colete
                                        </h5>
                                    </div>
                                    <div class="col-lg-11 px-4 py-2 mb-4 bg-white border rounded-lg">
                                        Număr: <span class="badge badge-primary" style="font-size:1em">{{ $rezervare->colete_numar }}</span>
                                        <br>
                                        Cantitate: <span class="badge badge-primary" style="font-size:1em">{{ $rezervare->colete_kg }} Kg</span>
                                        <br>
                                        Volum: <span class="badge badge-primary" style="font-size:1em">{{ $rezervare->colete_volum }} m<sup>3</sup></span>
                                        <br>
                                        Descriere: {{ $rezervare->colete_descriere }}
                                        <br>
                                        Preț total:
                                        <span class="badge badge-primary" style="font-size:1em">{{ $rezervare->pret_total_tur + $rezervare->pret_total_retur }}€</span>
                                    </div>

                                    <div class="col-lg-11 px-0 border rounded-lg">
                                        <h5 class="bg-success text-white p-1 m-0 text-center">
                                            Informații Expeditor
                                        </h5>
                                    </div>
                                    <div class="col-lg-11 px-4 py-2 mb-4 bg-white border rounded-lg">
                                        Nume: <span class="badge badge-primary" style="font-size:1.1em">{{ $rezervare->nume }}</span>
                                        <br>
                                        Telefon: <b>{{ $rezervare->telefon }}</b>
                                        <br>
                                        Email: <b>{{ $rezervare->email }}</b>
                                    </div>

                                    <div class="col-lg-11 px-0 border rounded-lg">
                                        <h5 class="bg-success text-white p-1 m-0 text-center">
                                            Informații Destinatar
                                        </h5>
                                    </div>
                                    <div class="col-lg-11 px-4 py-2 mb-4 bg-white border rounded-lg">
                                        Nume: <span class="badge badge-primary" style="font-size:1.1em">{{ $rezervare->colete_nume_destinatar }}</span>
                                        <br>
                                        Telefon: <b>{{ $rezervare->colete_telefon_destinatar }}</b>
                                        <br>
                                        Email: <b>{{ $rezervare->colete_email_destinatar }}</b>
                                    </div>

                                    @if ($rezervare->observatii)
                                        <div class="col-lg-11 px-0 border rounded-lg">
                                            <h5 class="bg-success text-white p-1 m-0 text-center">
                                                Observații
                                            </h5>
                                        </div>
                                        <div class="col-lg-11 px-4 py-2 mb-4 bg-white border rounded-lg">
                                            {{ $rezervare->observatii }}
                                        </div>
                                    @endif

                                @endif

                                @if ($rezervare->cumparator)
                                    <div class="col-lg-11 px-0 border rounded-lg">
                                        <h5 class="bg-success text-white p-1 m-0 text-center">
                                            Date pentru facturare
                                        </h5>
                                    </div>
                                    <div class="col-lg-11 px-4 py-2 mb-2 bg-white border rounded-lg">
                                        Cumpărător: {{ $rezervare->cumparator }}
                                        <br>
                                        Nr. Reg. Com.: {{ $rezervare->nr_reg_com }}
                                        <br>
                                        CIF: {{ $rezervare->cif }}
                                        <br>
                                        Sediul: {{ $rezervare->sediul }}
                                    </div>
                                @endif

                                </div>



                                <div class="row">
                                    <div class="col-lg-12 d-flex justify-content-center mb-4">
                                    <form class="needs-validation" novalidate method="POST" action="/adauga-rezervare-pasul-2">
                                        @csrf
                                        <div class="row">
                                            @if ($rezervare->nr_adulti > 0)
                                            <div class="col-lg-12 d-flex justify-content-center mb-4">
                                                <button type="submit" name="action" value="cu_plata_online"
                                                    class="btn btn-primary btn-lg mr-2 rounded-pill border border-white" style="border-width:3px !important;">
                                                    Plătește rezervarea
                                                    <img src="{{ asset('images/netopia_banner_blue.jpg') }}" height="49" class="mr-3 bg-white rounded-pill border border-white">
                                                </button>
                                            </div>
                                            @endif
                                            <div class="col-lg-12 d-flex justify-content-center mb-4">
                                                <button type="submit" name="action" value="fara_plata_online"
                                                    class="btn btn-primary btn-lg mr-4 rounded-pill border border-white" style="border-width:3px !important;">
                                                    Salvează rezervarea
                                                    și plătește la șofer
                                                </button>
                                            </div>
                                            <div class="col-lg-12 d-flex justify-content-center">
                                                <a class="btn btn-warning btn-lg rounded-pill border border-white mr-2" style="border-width:3px !important;"
                                                href="/adauga-rezervare-pasul-1"
                                                role="button">
                                                    Modifică rezervarea
                                                <a class="btn btn-secondary btn-lg rounded-pill border border-white" style="border-width:3px !important;"
                                                href="https://transportcorsica.ro/"
                                                role="button">
                                                    Anulează rezervarea
                                                </a>
                                            </div>
                                        </div>
                                    </form>

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
