@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="shadow-lg bg-white" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-danger p-2 d-flex justify-content-between align-items-end" style="border-radius: 40px 40px 0px 0px;">                     
                    <h3 class="ml-3" style="color:brown"><i class="fas fa-ticket-alt fa-lg mr-1"></i>Verificare bilet</h3>
                    <img src="{{ asset('images/Alsimy Mond Travel Galati - logo.png') }}" height="70" class="mr-3">
                </div>
                
                @include ('errors')                

                <div class="card-body py-2" 
                    style="
                        /* color:ivory;  */
                        background-color:crimson; 
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
                                                    {{ \Carbon\Carbon::parse($rezervare->data_plecare)->isoFormat('D.MM.YYYY') }}
                                                </span>
                                            </div>
                                            <div class="col-lg-4">
                                                Oraș plecare:
                                                <br>
                                                <span class="badge badge-primary" style="font-size:1.1em">
                                                    {{ $rezervare->oras_plecare_nume->nume }}
                                                </span>
                                            </div>
                                            <div class="col-lg-1 pt-1 text-primary">
                                                {{-- <span class="badge badge-primary" style="font-size:1.1em"> --}}
                                                    <i class="fas fa-long-arrow-alt-right fa-4x"></i>
                                                {{-- </span> --}}
                                            </div>
                                            <div class="col-lg-4">
                                                Oraș sosire:
                                                <br>
                                                <span class="badge badge-primary" style="font-size:1.1em">
                                                    {{ $rezervare->oras_sosire_nume->nume }}
                                                </span>
                                            </div>
                                        </div>
                                        @if (($rezervare->tur_retur === "true") || ($rezervare->tur_retur === 1))
                                            <div class="row text-center">
                                                <div class="col-lg-12 text-primary">
                                                    <hr class="bg-primary">
                                                    {{-- <i class="fas fa-chevron-down fa-7x"></i> --}}
                                                </div>
                                                <div class="col-lg-3">
                                                    Data de întoarcere:
                                                    <br>
                                                    {{-- {{ \Carbon\Carbon::parse($rezervare->data_intoarcere)->isoFormat('dddd') }}
                                                    <br> --}}
                                                    <span class="badge badge-primary" style="font-size:1.1em">
                                                        {{ \Carbon\Carbon::parse($rezervare->data_intoarcere)->isoFormat('D.MM.YYYY') }}
                                                    </span>
                                                </div>
                                                <div class="col-lg-4">
                                                    Oraș sosire:
                                                    <br>
                                                    <span class="badge badge-primary" style="font-size:1.1em">
                                                        {{ $rezervare->oras_plecare_nume->nume }}
                                                    </span>
                                                </div>
                                                <div class="col-lg-1 pt-1 text-primary">
                                                    {{-- <span class="badge badge-primary" style="font-size:1.1em"> --}}
                                                        <i class="fas fa-long-arrow-alt-left fa-4x"></i>
                                                    {{-- </span> --}}
                                                </div>
                                                <div class="col-lg-4">
                                                    Oraș plecare:
                                                    <br>
                                                    <span class="badge badge-primary" style="font-size:1.1em">
                                                        {{ $rezervare->oras_sosire_nume->nume }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-lg-11 px-0 border rounded-lg">
                                        <h5 class="bg-warning p-1 m-0 text-center">
                                            Informații pasageri
                                        </h5>
                                    </div>
                                    <div class="col-lg-11 px-4 py-2 bg-white border rounded-lg">
                                        Număr adulți: 
                                        <span class="badge badge-primary" style="font-size:1em">{{ $rezervare->nr_adulti }}</span>
                                        * {{ $tarife->adult }}€ = {{ $rezervare->nr_adulti * $tarife->adult}}€
                                        {{-- - 10% =
                                        {{ $rezervare->nr_adulti * floor((string) ($tarife->adult * 90)) / 100}}€ --}}
                                        @if ($rezervare->nr_copii > 0)
                                            <br>
                                            Număr copii: 
                                            <span class="badge badge-primary" style="font-size:1em">{{ $rezervare->nr_copii }}</span>
                                            * {{ $tarife->copil }}€ = {{ $rezervare->nr_copii * $tarife->copil}}€
                                            {{-- - 10% =
                                            {{ $rezervare->nr_copii * floor((string) ($tarife->copil * 90)) / 100}}€ --}}
                                        @endif
                                        @if ($rezervare->nr_animale_mici > 0)
                                            <br>
                                            Număr animale de companie de talie mică (< 10 kg): 
                                            <span class="badge badge-primary" style="font-size:1em">{{ $rezervare->nr_animale_mici }}</span>
                                            * {{ $tarife->animal_mic }}€ = {{ $rezervare->nr_animale_mici * $tarife->animal_mic}}€
                                        @endif
                                        @if ($rezervare->nr_animale_mari > 0)
                                            <br>
                                            Număr animale de companie de talie mare (> 10 kg): 
                                            <span class="badge badge-primary" style="font-size:1em">{{ $rezervare->nr_animale_mari }}</span>
                                            * {{ $tarife->animal_mare }}€ = {{ $rezervare->nr_animale_mari * $tarife->animal_mare}}€
                                        @endif
                                    </div>
                                    <div class="col-lg-11 px-4 py-2 mb-4 bg-white border rounded-lg text-right">
                                        {{-- Preț total: 
                                        {{ $rezervare->pret_total }}€
                                        - 10% =
                                        <span class="badge badge-primary" style="font-size:1em">{{ $rezervare->pret_total_cu_reducere_10_procente }}€</span> --}}
                                        Preț total: <span class="badge badge-primary" style="font-size:1em">{{ $rezervare->pret_total }}€</span>
                                    </div>
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
                                        Adresa: {{ $rezervare->adresa }}
                                        <br>
                                        Animale de companie: {{ $rezervare->animale_companie }}
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
                                        Data expirării documentului: 
                                            @if ($rezervare->expirare_document !== null)
                                                {{ \Carbon\Carbon::parse($rezervare->expirare_document)->isoFormat('D.MM.YYYY') }}    
                                            @endif                                        
                                        <br>
                                        Seria buletin / pașaport:: {{ $rezervare->serie_document }}
                                        <br>
                                        Cnp: {{ $rezervare->cnp }}
                                    </div>

                                </div>  
                                
                                
                                
                                <div class="row">
                                    <div class="col-lg-12 d-flex justify-content-center mb-4">  
                                        <form  class="needs-validation" novalidate method="POST" action="/adauga-rezervare-pasul-2">
                                            @csrf                                                 
                                            {{-- @if ($rezervare->plata_online == "1") --}}
                                            {{-- @if ((auth()->user()->id ?? null) === 2) --}}
                                                @php
                                                    $rezervare->plata_online = 1;
                                                @endphp
                                                <button type="submit" class="btn btn-primary mr-4 rounded-pill border border-white" style="border-width:3px !important;">Plătește rezervarea</button>
                                            {{-- @else
                                                @php
                                                    $rezervare->plata_online = 0;
                                                @endphp
                                                <button type="submit" class="btn btn-primary mr-4 rounded-pill border border-white" style="border-width:3px !important;">Salvează rezervarea</button> 
                                            @endif --}}
                                        </form>
                                        <img src="{{ asset('images/banner-no-operators.jpg') }}" height="43" class="mr-3 bg-white rounded-pill border border-white">
                                    </div>
                                    <div class="col-lg-12 d-flex justify-content-center">  
                                        <a class="btn btn-secondary rounded-pill border border-white" style="border-width:3px !important;" 
                                        {{-- href="/rezervare-client"  --}}
                                        href="https://www.alsimymondtravel.ro/"
                                        role="button">
                                            Anulează rezervarea
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