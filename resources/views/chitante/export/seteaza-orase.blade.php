@extends('layouts.app')

@section('content')
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="shadow-lg bg-white" style="border-radius: 40px 40px 40px 40px;">
                <div class="p-4 justify-content-center align-items-end" style="border-radius: 40px 40px 0px 0px; border:2px solid darkcyan">
                    <div class="col-lg-12 mb-4 d-flex justify-content-center">
                        <img src="{{ asset('images/logo.png') }}" height="100" class="">
                    </div>
                    <div class="col-lg-12 mb-0 d-flex justify-content-center">
                        <h1 class="mb-0" style="color:darkcyan">
                            @isset($rezervare->nr_adulti)
                                CHITANȚĂ
                            @else
                                AWB
                            @endisset
                        </h1>
                    </div>
                </div>

                @include ('errors')

                <div class="card-body py-2"
                    style="
                        color:white;
                        background-color:darkcyan;
                        border-radius: 0px 0px 40px 40px
                    "
                >

                    <form  class="needs-validation" novalidate method="POST" action="/chitanta-descarca/{{ $cheie_unica }}/seteaza_orase">
                        @csrf


                        <div class="form-row mb-0 d-flex justify-content-center border-radius: 0px 0px 40px 40px">
                            <div class="form-group col-lg-12 px-2 mb-0">

                                <div class="form-row mb-4 d-flex justify-content-center">
                                    @isset($rezervare->nr_adulti)
                                        <div class="col-lg-12 mb-5 h5">
                                            Chitanță pentru biletul pasagerilor:
                                            @foreach ($rezervare->pasageri_relation as $pasager)
                                                {{ $pasager->nume }}{{ (!$loop->last) ? ', ' : '.'}}
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="col-lg-12 mb-4 h5 text-center">
                                            <span class="px-2 border" style="font-size: 1.5em; background-color:lightseagreen; color:white">
                                                {{ $rezervare->oras_plecare_nume->oras }} -> {{ $rezervare->oras_sosire_nume->oras }}
                                            </span>
                                            <br>
                                            <br>
                                            <span class="px-2 border" style="font-size: 1.5em; background-color:lightseagreen; color:white">
                                                {{ $rezervare->colete_numar }} colete
                                            </span>
                                        </div>
                                    @endif


                                    @isset($rezervare->nr_adulti)
                                        <div class="col-lg-2 mb-4">
                                            <label for="oras_plecare" class="mb-1 h5">Oraș plecare:*</label>
                                            <input
                                                type="text"
                                                class="form-control form-control-lg {{ $errors->has('oras_plecare') ? 'is-invalid' : '' }}"
                                                name="oras_plecare"
                                                placeholder=""
                                                value="{{ old('oras_plecare', ($rezervare->oras_plecare_nume->oras ?? '')) }}"
                                                required>
                                        </div>
                                        <div class="col-lg-2 mb-5">
                                            <label for="oras_sosire" class="mb-1 h5">Oraș sosire:*</label>
                                            <input
                                                type="text"
                                                class="form-control form-control-lg {{ $errors->has('oras_sosire') ? 'is-invalid' : '' }}"
                                                name="oras_sosire"
                                                placeholder=""
                                                value="{{ old('oras_sosire', ($rezervare->oras_sosire_nume->oras ?? '')) }}"
                                                required>
                                        </div>
                                    @else
                                        <div class="col-lg-2 mb-5">
                                            <label for="pret_total" class="mb-1 h5">Preț:*</label>
                                            <input
                                                type="text"
                                                class="form-control form-control-lg {{ $errors->has('pret_total') ? 'is-invalid' : '' }}"
                                                name="pret_total"
                                                placeholder=""
                                                value="{{ old('pret_total', ($rezervare->pret_total ?? '')) }}"
                                                required>
                                        </div>
                                    @endisset

                                    <div class="col-lg-12 d-flex justify-content-center">
                                        <button type="submit" class="btn btn-lg btn-primary border border-white btn-block">
                                            @isset($rezervare->nr_adulti)
                                                EMITE CHITANȚA
                                            @else
                                                EMITE AWB
                                            @endif
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
