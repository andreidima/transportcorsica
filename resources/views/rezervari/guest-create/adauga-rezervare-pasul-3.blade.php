@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="shadow-lg bg-white" style="border-radius: 40px 40px 40px 40px;">
                <div class="p-2 d-flex justify-content-between align-items-end"
                    style="border-radius: 40px 40px 0px 0px; border:2px solid darkcyan">
                    <h3 class="ml-3" style="color:darkcyan"><i class="fas fa-ticket-alt fa-lg mr-1"></i>Rezervare finalizată</h3>
                    <img src="{{ public_path('images/logo.png') }}" height="70" class="mr-3">
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
                                    {{-- @php
                                        dd($rezervare_tur);
                                    @endphp --}}
                                    @isset ($rezervare_tur)
                                        <div class="col-lg-11 px-0 border rounded-lg">
                                            <h5 class="bg-warning p-1 m-0 text-center">
                                                Rezervarea a fost înregistrată cu codul <b>RO{{ $rezervare_tur->id }}</b>
                                                @isset($rezervare_tur->plata_efectuata)
                                                    <br><br>
                                                    Mesajul tranzacției plății online este: <b>{{ $rezervare_tur->plataOnlineUltima->mesaj_personalizat ?? '' }}</b>
                                                    <br>
                                                @endisset
                                                <br>
                                                @isset($rezervare_tur->nr_adulti)
                                                    Pasageri:
                                                    @foreach ($rezervare_tur->pasageri_relation as $pasager)
                                                        @if(!$loop->last)
                                                            {{ $pasager->nume }},
                                                        @else
                                                            {{ $pasager->nume }}
                                                        @endif
                                                    @endforeach
                                                @else
                                                    Rezervare colete
                                                @endif
                                            </h5>
                                        </div>
                                        <div class="col-lg-11 p-4 bg-white border rounded-lg">
                                            <div class="row">
                                                    <div class="col-sm-12 text-center">
                                                            <a href="/bilet-rezervat/rezervare-pdf"
                                                                class="btn btn-success border border-white rounded-lg mb-0"
                                                                role="button"
                                                                target="_blank"
                                                                title="Descarcă bilet"
                                                                >
                                                                <h5 class="p-0 m-0">Descărcați și tipăriți biletul de rezervare</h5>
                                                            </a>
                                                    </div>

                                                @isset($rezervare_tur->factura)
                                                    <div class="col-sm-12 text-center my-4">
                                                            <a href="/factura-descarca/export-pdf"
                                                                class="btn btn-success border border-white rounded-lg mb-0"
                                                                role="button"
                                                                target="_blank"
                                                                title="Descarcă factura"
                                                                >
                                                                <h5 class="p-0 m-0">Descărcați și tipăriți factura</h5>
                                                            </a>
                                                    </div>
                                                @endisset
                                            </div>
                                        </div>

                                    @else
                                        <div class="col-lg-11 px-0 border rounded-lg">
                                            <h5 class="bg-warning p-1 m-0 text-center">
                                                Nu există rezervare salvată
                                            </h5>
                                        </div>
                                    @endisset

                                                {{-- @isset($plata_online)
                                                    <br>
                                                    @if ($plata_online->error_code == 0 )
                                                        <a href="/bilet-rezervat/rezervare-pdf"
                                                            class="btn btn-success border border-white rounded-lg mb-3"
                                                            role="button"
                                                            target="_blank"
                                                            title="Descarcă bilet"
                                                            >
                                                            <h5 class="p-0 m-0">Descărcați și tipăriți biletul de rezervare</h5>
                                                        </a>
                                                    @else
                                                        Plata rezervării <span class="text-danger">NU</span> s-a efectuat cu succes!
                                                        <br>
                                                        <a href="/adauga-rezervare-pasul-1"
                                                            class="btn btn-primary border border-white rounded-lg mb-3"
                                                            role="button"
                                                            target="_blank"
                                                            title="Creare Rezervare"
                                                            >
                                                            <h5 class="p-0 m-0">Vă rugăm să reîncercați</h5>
                                                        </a>
                                                    @endif
                                                    <br>
                                                @endisset --}}
                                        <div class="col-lg-11 p-4 bg-white border rounded-lg">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    În dimineața zilei de plecare, veți fi contactat telefonic pentru stabilirea detaliilor călătoriei.
                                                    <br><br>
                                                    Pentru orice detalii legate de această rezervare, ne puteți contacta la:
                                                    <ul>
                                                        <li>
                                                            Telefon: 0761 329 420
                                                        </li>
                                                        <li>
                                                            Email: <a href="mailto:office@transportcorsica.ro">office@transportcorsica.ro</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-sm-12 text-center">
                                                    <a
                                                        href="https://transportcorsica.ro/"
                                                        class="btn btn-primary border border-white rounded-lg text-center"
                                                        role="button"
                                                        title="Înapoi la pagina principală">
                                                        <h5 class="p-0 m-0">Înapoi la pagina principală</h5>
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
    </div>
</div>
@endsection
