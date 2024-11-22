@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="shadow-lg bg-white" style="border-radius: 40px 40px 40px 40px;">
                <div class="p-2 d-flex justify-content-between align-items-end"
                    style="border-radius: 40px 40px 0px 0px; border:2px solid darkcyan">
                    <h3 class="ml-3" style="color:darkcyan"><i class="fas fa-ticket-alt fa-lg mr-1"></i>Rezervare bilet călătorie</h3>
                    <img src="{{ asset('images/logo.png') }}" height="70" class="mr-3">
                </div>

                @include ('errors')

                <div class="card-body py-2"
                    style="
                        color:white;
                        background-color:darkcyan;
                        border-radius: 0px 0px 40px 40px
                    "
                    id="adauga-rezervare"
                >

                @if (!is_null($rezervare->bilet_numar))
                    <div class="alert alert-warning" role="alert">
                        Această călătorie a fost deja efectuată. Are bilet emis!. Nu veți putea modifica detaliile traseului
                    </div>
                @endif


                @if (isset($tip_operatie) && ($tip_operatie === "modificare"))
                    <form  class="needs-validation" novalidate method="POST" action="{{ $rezervare->path() }}">
                        @csrf
                        @method('PATCH')
                @else
                    <form  class="needs-validation" novalidate method="POST" action="/adauga-rezervare-pasul-1">
                        @csrf
                @endif

                        <div class="form-row mb-0 d-flex justify-content-center border-radius: 0px 0px 40px 40px">

                            <div class="form-group col-lg-12 px-2 mb-0">

                                            {{-- Nu se mai ofera posibilitatea de schimbare a cursei --}}
                            {{-- @if (isset($tip_operatie) && ($tip_operatie === "modificare"))
                                <div class="form-row mb-4 d-flex justify-content-center">
                                    <script type="application/javascript">
                                        tipCalatorieVeche={!! json_encode(old('tip_calatorie', ($rezervare->tip_calatorie ?? ''))) !!}
                                    </script>
                                    <div class="col-lg-5 pl-3 text-center">
                                        <span class="px-2 border" style="font-size: 1.5em; background-color:lightseagreen; color:white">
                                            Tip cursă: {{ $rezervare->tip_calatorie }}
                                        </span>
                                    </div>
                                </div>

                                    <input type="hidden" name="tip_calatorie" value="{{  $rezervare->tip_calatorie }}" />
                            @else --}}

                            @auth
                                <script type="application/javascript">
                                    tipCalatorieVeche={!! json_encode(old('tip_calatorie', ($rezervare->tip_calatorie ?? ''))) !!}
                                </script>

                                {{ old('tip_calatorie') }}

                                <div v-if="tip_calatorie === ''" class="form-row mb-4 d-flex justify-content-center">
                                    {{-- Este rezervare noua, si automat este necesarea posibilitarea selectarii tipului de cursa --}}
                                    {{-- Se va ascunde campul de selectare a cursei dupa prima selectie --}}
                                    <div class="col-lg-10 pl-3">
                                        Selectează tip cursă:
                                    </div>
                                    <div class="col-lg-10 btn-group btn-group-toggle">
                                        <label class="col-lg-6 border" v-bind:class="[tip_calatorie=='Calatori' ? 'btn btn-sm btn-success' : 'btn btn-sm btn-secondary']">
                                            <input type="radio" class="btn-group-toggle" name="tip_calatorie" id="tip_calatorie1" autocomplete="off"
                                                v-model="tip_calatorie" value="Calatori"
                                                {{-- v-on:change="setTaraPlecare();getJudetePlecareInitial();getJudeteSosireInitial();setPreturi();" --}}
                                                {{-- v-on:change="setTaraPlecare();getOrasePlecare();getOraseSosire();setPreturi();" --}}
                                                v-on:change="setTaraPlecare();getOrasePlecare();getOraseSosire();"
                                                >
                                                    <i class="fas fa-users" style="font-size: 2em;"></i>
                                                    <span style="font-size: 2em;">
                                                        Transport Călători
                                                    </span>
                                        </label>
                                        <label class="col-lg-6 border" v-bind:class="[tip_calatorie=='Colete' ? 'btn btn-sm btn-success' : 'btn btn-sm btn-secondary']">
                                            <input type="radio" class="btn-group-toggle" name="tip_calatorie" id="tip_calatorie2" autocomplete="off"
                                                v-model="tip_calatorie" value="Colete"
                                                {{-- v-on:change="setTaraPlecare();getJudetePlecareInitial();getJudeteSosireInitial();setPreturi();" --}}
                                                {{-- v-on:change="setTaraPlecare();getOrasePlecare();getOraseSosire();setPreturi();" --}}
                                                v-on:change="setTaraPlecare();getOrasePlecare();getOraseSosire();"
                                                >
                                                    <i class="fas fa-box" style="font-size: 2em;"></i>
                                                    <span style="font-size: 2em;">
                                                        Transport Colete
                                                    </span>
                                        </label>
                                    </div>
                                </div>

                                <div v-else class="form-row mb-4 d-flex justify-content-center">
                                            {{-- Nu se mai ofera posibilitatea de schimbare a cursei --}}
                                    <div class="col-lg-5 pl-3 text-center">
                                        <span class="px-2 border" style="font-size: 1.5em; background-color:lightseagreen; color:white">
                                            Tip cursă: @{{ tip_calatorie }}
                                        </span>
                                    </div>

                                    <input type="hidden" name="tip_calatorie" v-model="tip_calatorie" />

                                </div>

                            @else
                                <script type="application/javascript">
                                    tipCalatorieVeche={!! json_encode(old('tip_calatorie', ($rezervare->tip_calatorie ?? 'Calatori'))) !!}
                                </script>
                                {{-- <div v-if="tip_calatorie === ''" class="form-row mb-4 d-flex justify-content-center"> --}}
                                <div class="form-row mb-4 d-flex justify-content-center">
                                    <input type="hidden" name="tip_calatorie" value="Calatori" />
                                </div>
                            @endauth

                            <div v-cloak v-if="tip_calatorie">
                                <div class="form-row mb-1 d-flex justify-content-center">
                                        <script type="application/javascript">
                                            traseuVechi={!! json_encode(old('traseu', ($rezervare->traseu?? ''))) !!}
                                        </script>
                                    <div class="col-lg-7 pl-3">
                                        Selectează traseu:
                                    </div>
                                    <div class="col-lg-7 mb-4 btn-group btn-group-toggle">
                                        <label class="border {{ is_null($rezervare->bilet_numar) ? '' : 'disabled' }}"
                                                v-bind:class="[traseu=='Romania-Corsica' ? 'btn btn-sm btn-success' : 'btn btn-sm btn-secondary']">
                                            <input type="radio" class="btn-group-toggle" name="traseu" id="traseu1" autocomplete="off"
                                                v-model="traseu" value="Romania-Corsica"
                                                {{-- v-on:change="setTaraPlecare();getOrasePlecare();getOraseSosire();setPreturi()" --}}
                                                v-on:change="setTaraPlecare();getOrasePlecare();getOraseSosire();"
                                                {{ is_null($rezervare->bilet_numar) ? '' : 'disabled' }}
                                                >
                                                    <span style="font-size: 1.2em;">
                                                        România -> Corsica
                                                    </span>
                                        </label>
                                        <label class="border {{ is_null($rezervare->bilet_numar) ? '' : 'disabled' }}"
                                                v-bind:class="[traseu=='Corsica-Romania' ? 'btn btn-sm btn-success' : 'btn btn-sm btn-secondary']">
                                            <input type="radio" class="btn-group-toggle" name="traseu" id="traseu2" autocomplete="off"
                                                v-model="traseu" value="Corsica-Romania"
                                                {{-- v-on:change="setTaraPlecare();getOrasePlecare();getOraseSosire();setPreturi();" --}}
                                                v-on:change="setTaraPlecare();getOrasePlecare();getOraseSosire();"
                                                {{ is_null($rezervare->bilet_numar) ? '' : 'disabled' }}
                                                >
                                                    <span style="font-size: 1.2em;">
                                                        Corsica -> România
                                                    </span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                                <div v-cloak v-if="traseu">
                                    <div class="row mb-2 d-flex justify-content-between">
                                        <div class="col-lg-3">
                                            <div class="form-row">
                                                <div class="col-lg-12">
                                                    Plecare din:*
                                                </div>
                                                {{-- <div class="form-group col-lg-6">
                                                    <script type="application/javascript">
                                                        judetPlecareVechi={!! json_encode(old('judet_plecare', ($rezervare->judet_plecare ?? '0'))) !!}
                                                    </script>
                                                    <select class="custom-select-sm custom-select {{ $errors->has('judet_plecare') ? 'is-invalid' : '' }}"
                                                        name="judet_plecare"
                                                        v-model="judet_plecare"
                                                        @change='getOrasePlecare();'
                                                        >
                                                        <option disabled value="">Selectează o opțiune</option>
                                                        <option
                                                            v-for='judet_plecare in judete_plecare'
                                                            :value='judet_plecare.judet'
                                                            >
                                                                @{{judet_plecare.judet}}
                                                        </option>
                                                    </select>
                                                </div> --}}
                                                <div class="form-group col-lg-12">
                                                    {{-- <label for="oras_plecare" class="mb-0">Oraș:<span class="text-white">*</span></label>  --}}
                                                    <script type="application/javascript">
                                                        orasPlecareVechi={!! json_encode(old('oras_plecare', ($rezervare->oras_plecare ?? '0'))) !!}
                                                    </script>
                                                    <select class="custom-select-sm custom-select {{ $errors->has('oras_plecare') ? 'is-invalid' : '' }}"
                                                        name="oras_plecare"
                                                        v-model="oras_plecare"
                                                        {{-- @change='getPreturi();getPretTotal()' --}}
                                                        {{ is_null($rezervare->bilet_numar) ? '' : 'disabled' }}
                                                        >
                                                        <option disabled value="">Selectează o opțiune</option>
                                                        <option
                                                            v-for='oras_plecare in orase_plecare'
                                                            :value='oras_plecare.id'
                                                            >
                                                                @{{oras_plecare.oras}}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-row">
                                                <div class="col-lg-12">
                                                    Sosire la:*
                                                </div>
                                                {{-- <div class="form-group col-lg-6">
                                                    <script type="application/javascript">
                                                        judetSosireVechi={!! json_encode(old('judet_sosire', ($rezervare->judet_sosire ?? '0'))) !!}
                                                    </script>
                                                    <select class="custom-select-sm custom-select {{ $errors->has('judet_sosire') ? 'is-invalid' : '' }}"
                                                        name="judet_sosire"
                                                        v-model="judet_sosire"
                                                        @change='getOraseSosire();'
                                                    >
                                                            <option disabled value="">Selectează o opțiune</option>
                                                            <option v-for='judet_sosire in judete_sosire'
                                                            :value='judet_sosire.judet'
                                                            >@{{judet_sosire.judet}}</option>
                                                    </select>
                                                </div> --}}
                                                <div class="form-group col-lg-12">
                                                    {{-- <label for="oras_plecare" class="mb-0">Oraș:<span class="text-white">*</span></label>     --}}
                                                    <script type="application/javascript">
                                                        orasSosireVechi={!! json_encode(old('oras_sosire', ($rezervare->oras_sosire ?? '0'))) !!}
                                                    </script>
                                                        <select class="custom-select-sm custom-select {{ $errors->has('oras_sosire') ? 'is-invalid' : '' }}"
                                                            name="oras_sosire"
                                                            v-model="oras_sosire"
                                                            {{-- @change='getPreturi();getPretTotal()' --}}
                                                            {{ is_null($rezervare->bilet_numar) ? '' : 'disabled' }}
                                                            >
                                                            <option disabled value="">Selectează o opțiune</option>
                                                            <option
                                                                v-for='oras_sosire in orase_sosire'
                                                                :value='oras_sosire.id'
                                                                >
                                                                    @{{oras_sosire.oras}}
                                                            </option>
                                                        </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="custom-control custom-switch col-lg-3 text-center d-flex align-items-center justify-content-center">
                                            @if (old('tur_retur', ($rezervare->tur_retur ?? '')) === 'true')
                                                <script type="application/javascript">
                                                    turReturVechi=true
                                                </script>
                                            @else
                                                <script type="application/javascript">
                                                    turReturVechi=false
                                                </script>
                                            @endif

                                            </script>
                                            <input type="hidden" name="tur_retur" value="false" />
                                            <input type="checkbox" class="custom-control-input custom-control-lg" id="customSwitch1"
                                            name="tur_retur" v-model="tur_retur" value="true" required
                                            {{ old('tur_retur') == 'true' ? 'checked' : '' }}
                                            {{-- {{ is_null($rezervare->bilet_numar) ? '' : 'disabled' }} --}}
                                            {{-- @change='setPreturi();getPretTotal()' --}}
                                            {{-- @change='getPretTotal()' --}}
                                            >
                                            <label class="custom-control-label" for="customSwitch1">TUR - RETUR</label>
                                        </div>
                                        <div class="col-lg-3 d-flex align-items-center">
                                            <button class="btn btn-sm btn-warning {{ is_null($rezervare->bilet_numar) ? '' : 'disabled' }}"
                                                type="button" v-on:click="{{ is_null($rezervare->bilet_numar) ? 'inverseaza_orasele()' : '' }}">
                                                Inversează orașele
                                            </button>
                                        </div>
                                    </div>

                                    <div class="form-row mb-4 px-2 py-2 d-flex justify-content-center align-items-center border rounded"
                                        style="background-color:lightseagreen; color:white"
                                    >
                                        <div class="form-group col-lg-12 mb-2 d-flex justify-content-center border-bottom">
                                                <h5 class="mb-1">Plecare în călătorie:</h5>
                                        </div>
                                        <div class="form-group col-lg-12 border-left border-primary" style="border-width:5px !important">
                                            Plecările din România au loc săptămânal, marțea, la ora 21:00, din Focșani.
                                            <br>
                                            Plecările din Corsica au loc săptămânal, vinerea, în funcție de plecările navelor și de locația dumneavoastră .
                                        </div>
                                        <div class="form-group col-lg-12 border-left border-warning" style="border-width:5px !important">
                                            Pentru informații complete, vă rugăm să citiți
                                                    <a href="https://transportcorsica.ro/termeni-si-conditii/" target="_blank">
                                                        <span class="badge badge-primary border border-dark"
                                                            style="background-color:red; color:white"
                                                        >
                                                            Termeni și condiții
                                                        </span>
                                                    </a>
                                            sau apelați telefon
                                                        <span class="badge badge-primary border border-dark"
                                                            style="background-color:blue; color:white"
                                                        >
                                                            <a href="tel:+40791881888" style="color:white"> +40 791 881 888</a>
                                                        </span>
                                        </div>

                                                <script type="application/javascript">
                                                    dataPlecareVeche={!! json_encode(old('data_plecare', ($rezervare->data_plecare ?? ''))) !!}
                                                    dataIntoarcereVeche={!! json_encode(old('data_intoarcere', ($rezervare->data_intoarcere ?? ''))) !!}
                                                </script>
                                        <div class="form-group col-lg-4 mb-2 d-flex justify-content-center align-items-end">
                                            <label for="data_plecare" class="mb-0 mr-2">Dată plecare:*</label>
                                            <div v-if="traseu === 'Romania-Corsica'" class="">
                                                <vue2-datepicker-plecare
                                                    {{-- data-veche="{{ old('data_plecare', ($rezervare->data_plecare ?? '')) }}" --}}
                                                    :data-veche="data_plecare_veche"
                                                    nume-camp-db="data_plecare"
                                                    :latime="{ width: '125px' }"
                                                    tip="date"
                                                    value-type="YYYY-MM-DD"
                                                    format="DD-MM-YYYY"
                                                    {{-- not-before-date="{{ \Carbon\Carbon::today() }}" --}}
                                                    not-before-date="{{ auth()->check() ? \Carbon\Carbon::today()->subYear() : \Carbon\Carbon::today() }}"
                                                    :doar-ziua="3"
                                                    @dataplecare="dataPlecareTrimisa"
                                                    {{-- v-on:dataplecare="dataPlecareTrimisa" --}}
                                                    {{-- {{ is_null($rezervare->bilet_numar) ? '' : 'disabled' }} --}}
                                                ></vue2-datepicker-plecare>
                                            </div>
                                            <div v-if="traseu === 'Corsica-Romania'">
                                                <vue2-datepicker-intoarcere
                                                    {{-- data-veche="{{ old('data_plecare', ($rezervare->data_plecare ?? '')) }}" --}}
                                                    :data-veche="data_plecare_veche"
                                                    nume-camp-db="data_plecare"
                                                    :latime="{ width: '125px' }"
                                                    tip="date"
                                                    value-type="YYYY-MM-DD"
                                                    format="DD-MM-YYYY"
                                                    {{-- not-before-date="{{ \Carbon\Carbon::today() }}" --}}
                                                    not-before-date="{{ auth()->check() ? \Carbon\Carbon::today()->subYear() : \Carbon\Carbon::today() }}"
                                                    :doar-ziua="6"
                                                    @dataintoarcere="dataIntoarcereTrimisa"
                                                    {{-- v-on:dataplecare="dataPlecareTrimisa" --}}
                                                    {{-- {{ is_null($rezervare->bilet_numar) ? '' : 'disabled' }} --}}
                                                ></vue2-datepicker-intoarcere>
                                            </div>
                                        </div>
                                        {{-- <div class="form-group col-lg-4 mb-2 justify-content-center align-items-end">
                                            <br>
                                                <input
                                                    type="text"
                                                    class="form-control form-control-sm"
                                                    style="width:200px"
                                                    name="pret_adult"
                                                    v-model="data1"
                                                >
                                            <br>
                                                <input
                                                    type="text"
                                                    class="form-control form-control-sm"
                                                    style="width:200px"
                                                    name="pret_adult"
                                                    v-model="data2"
                                                >
                                            <br>
                                        </div> --}}
                                        <div v-if="tur_retur" class="form-group col-lg-4 mb-2 d-flex justify-content-center align-items-end">
                                            <label for="data_intoarcere" class="mb-0 mr-2">Dată întoarcere:*</label>
                                            <div v-if="traseu === 'Romania-Corsica'">
                                                <vue2-datepicker-intoarcere
                                                    {{-- data-veche="{{ old('data_intoarcere', ($rezervare->data_intoarcere) ?? '') }}" --}}
                                                    :data-veche="data_intoarcere_veche"
                                                    nume-camp-db="data_intoarcere"
                                                    :latime="{ width: '125px' }"
                                                    tip="date"
                                                    value-type="YYYY-MM-DD"
                                                    format="DD-MM-YYYY"
                                                    {{-- not-before-date="{{ \Carbon\Carbon::today() }}" --}}
                                                    not-before-date="{{ auth()->check() ? \Carbon\Carbon::today()->subYear() : \Carbon\Carbon::today() }}"
                                                    :doar-ziua="6"
                                                    @dataintoarcere="dataIntoarcereTrimisa"
                                                    {{-- {{ is_null($rezervare->bilet_numar) ? '' : 'disabled' }} --}}
                                                ></vue2-datepicker-intoarcere>
                                            </div>
                                            <div v-if="traseu === 'Corsica-Romania'">
                                                <vue2-datepicker-plecare
                                                    {{-- data-veche="{{ old('data_intoarcere', ($rezervare->data_intoarcere ?? '')) }}" --}}
                                                    :data-veche="data_intoarcere_veche"
                                                    nume-camp-db="data_intoarcere"
                                                    :latime="{ width: '125px' }"
                                                    tip="date"
                                                    value-type="YYYY-MM-DD"
                                                    format="DD-MM-YYYY"
                                                    {{-- not-before-date="{{ \Carbon\Carbon::today() }}" --}}
                                                    not-before-date="{{ auth()->check() ? \Carbon\Carbon::today()->subYear() : \Carbon\Carbon::today() }}"
                                                    :doar-ziua="3"
                                                    @dataplecare="dataPlecareTrimisa"
                                                    {{-- {{ is_null($rezervare->bilet_numar) ? '' : 'disabled' }} --}}
                                                ></vue2-datepicker-plecare>
                                            </div>
                                        </div>
                                        {{-- <div v-if="tur_retur" class="form-group col-lg-12 justify-content-center align-items-end text-center"> --}}
                                        <div v-if="tur_retur" class="form-group col-lg-12 mb-0 mt-3 border-left border-warning" style="border-width:5px !important">
                                            Data de intoarcere trebuie sa fie la maxim 15 zile de la data de plecare.
                                        </div>
                                    </div>


                                    {{-- Daca: „Această călătorie a fost deja efectuată. Are bilet emis!. Nu veți putea modifica detaliile traseului” --}}
                                    {{-- Se salveaza campurile disabled in request, necesare pentru update --}}
                                    @if (!is_null($rezervare->bilet_numar))
                                        <input type="hidden" name="traseu" value="{{ $rezervare->traseu }}" />
                                        <input type="hidden" name="oras_plecare" value="{{ $rezervare->oras_plecare }}" />
                                        <input type="hidden" name="oras_sosire" value="{{ $rezervare->oras_sosire }}" />
                                        {{-- <input type="hidden" name="tur_retur" value="{{ $rezervare->tur_retur }}" /> --}}
                                        {{-- <input type="hidden" name="data_plecare" value="{{ $rezervare->data_plecare }}" /> --}}
                                        {{-- <input type="hidden" name="data_intoarcere" value="{{ $rezervare->data_intoarcere }}" /> --}}
                                    @endif


                                    <div v-if="tip_calatorie === 'Calatori'" class="form-row mb-4 px-2 py-2 d-flex justify-content-center align-items-center border rounded"
                                        style="background-color:lightseagreen; color:white"
                                    >
                                        <div class="form-group col-lg-12 mb-2 d-flex justify-content-center border-bottom">
                                                <h5 class="mb-1">Bilet la navă: {{ $rezervare->bilet_nava }}</h5>
                                        </div>
                                        <div class="form-group col-lg-12 justify-content-center text-center" style="">
                                            <script type="application/javascript">
                                                biletNava={!! json_encode(old('bilet_nava', ($rezervare->bilet_nava ?? ''))) !!}
                                            </script>
                                            <div class="form-check form-check-inline mr-4 {{ $errors->has('bilet_nava') ? 'is-invalid' : '' }}">
                                                <input class="form-check-input" type="radio" name="bilet_nava" id="bilet_nava1" value="1" v-model="biletNava"
                                                {{ old('bilet_nava', ($rezervare->bilet_nava ?? '')) == "1" ? 'checked' : '' }}>
                                                <label class="form-check-label" for="bilet_nava1">
                                                    Doresc bilet la navă
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline {{ $errors->has('bilet_nava') ? 'is-invalid' : '' }}">
                                                <input class="form-check-input" type="radio" name="bilet_nava" id="bilet_nava2" value="0" v-model="biletNava"
                                                    {{ old('bilet_nava', ($rezervare->bilet_nava ?? '')) == "0" ? 'checked' : '' }}
                                                data-toggle="modal" data-target="#nuDorescBiletLaNava"
                                                >
                                                <label class="form-check-label" for="bilet_nava2">
                                                    Nu doresc bilet la navă
                                                </label>
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="nuDorescBiletLaNava" tabindex="-1" role="dialog" aria-labelledby="nuDorescBiletLaNavaLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document" style="">
                                                            <div class="modal-content">
                                                            <div class="modal-header" style="background-color:red">
                                                                <h5 class="modal-title" id="nuDorescBiletLaNavaLabel">Atenționare</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white">
                                                                <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body" style="color:black">
                                                                 În cazul in care nu doriți să vă achiziționăm biletul la navă, sunteți obligați sa vi-l Achiziționați singuri și sunteți răspunzători de eventualele erori în procesarea acestuia ( ex. Ruta aleasă de noi și ora plecării navei )
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Închide</button>
                                                                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                                                            </div>
                                                            </div>
                                                        </div>
                                                        </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-if="tip_calatorie === 'Calatori'" class="form-row mb-4 px-2 pt-2 d-flex justify-content-center align-items-center border rounded"
                                        style="background-color:lightseagreen; color:white"
                                    >
                                        <div class="form-group col-lg-12 mb-2 d-flex justify-content-center border-bottom">
                                                <h5 class="mb-1">Prețuri:</h5>
                                        </div>
                                        <div class="form-group col-lg-6 d-flex">
                                            <label for="pret_adult" class="col-form-label mb-0 mr-2">Preț adult: </label>
                                            <div class="px-0">
                                                <input
                                                    type="text"
                                                    class="form-control form-control-sm"
                                                    style="width:50px"
                                                    name="pret_adult"
                                                    v-model="pret_adult"
                                                    required
                                                    disabled>
                                            </div>
                                            <label id="" class="col-form-label pl-1 align-bottom">
                                                Euro
                                            </label>
                                        </div>
                                        <div class="form-group col-lg-6 d-flex align-items-center">
                                            <label for="pret_copil" class="col-form-label mb-0 mr-2">Preț copil (0-12 ani) (inclus Navă): </label>
                                            <div class="px-0">
                                                <input
                                                    type="text"
                                                    class="form-control form-control-sm"
                                                    style="width:50px"
                                                    name="pret_copil"
                                                    v-model="pret_copil"
                                                    required
                                                    disabled>
                                            </div>
                                            <label id="" class="col-form-label pl-1 align-bottom">
                                                Euro
                                            </label>
                                        </div>
                                        <div class="form-group col-lg-6 d-flex">
                                            <label for="pret_adult" class="col-form-label mb-0 mr-2">Preț adult tur retur: </label>
                                            <div class="px-0">
                                                <input
                                                    type="text"
                                                    class="form-control form-control-sm"
                                                    style="width:50px"
                                                    name="pret_adult_tur_retur"
                                                    v-model="pret_adult_tur_retur"
                                                    required
                                                    disabled>
                                            </div>
                                            <label id="" class="col-form-label pl-1 align-bottom">
                                                Euro
                                            </label>
                                        </div>
                                        <div class="form-group col-lg-6 d-flex align-items-center">
                                            <label for="pret_copil_tur_retur" class="col-form-label mb-0 mr-2">Preț copil tur retur (0-12 ani) (inclus Navă): </label>
                                            <div class="px-0">
                                                <input
                                                    type="text"
                                                    class="form-control form-control-sm"
                                                    style="width:50px"
                                                    name="pret_copil_tur_retur"
                                                    v-model="pret_copil_tur_retur"
                                                    required
                                                    disabled>
                                            </div>
                                            <label id="" class="col-form-label pl-1 align-bottom">
                                                Euro
                                            </label>
                                        </div>
                                        <div class="form-group col-lg-12 border-left border-warning" style="border-width:5px !important">
                                            Prețurile tur retur sunt cu discount, dar se aplică doar dacă între tur și retur nu este o diferență mai mare de 14 zile.
                                        </div>
                                        <div v-if="preturi_modificate_la_data_string_de_afisat" class="form-group col-lg-12 pb-0 mb-0 border-left border-warning" style="background-color:rgb(173, 204, 0);">
                                            Prețurile se modifică începând cu data de @{{preturi_modificate_la_data_string_de_afisat}}. Astfel, prețurile retur vor fi:
                                        </div>
                                        <div v-if="preturi_modificate_la_data_string_de_afisat" class="form-group col-lg-6 d-flex" style="background-color:rgb(173, 204, 0);">
                                            <label for="pret_adult_retur" class="col-form-label mb-0 mr-2">Preț adult retur:</label>
                                            <div class="px-0">
                                                <input
                                                    type="text"
                                                    class="form-control form-control-sm"
                                                    style="width:50px"
                                                    name="pret_adult_retur"
                                                    v-model="pret_adult_retur"
                                                    required
                                                    disabled>
                                            </div>
                                            <label id="" class="col-form-label pl-1 align-bottom">
                                                Euro
                                            </label>
                                        </div>
                                        <div v-if="preturi_modificate_la_data_string_de_afisat" class="form-group col-lg-6 d-flex align-items-center" style="background-color:rgb(173, 204, 0);">
                                            <label for="pret_copil_retur" class="col-form-label mb-0 mr-2">Preț copil retur (0-12 ani) (inclus Navă): </label>
                                            <div class="px-0">
                                                <input
                                                    type="text"
                                                    class="form-control form-control-sm"
                                                    style="width:50px"
                                                    name="pret_copil_retur"
                                                    v-model="pret_copil_retur"
                                                    required
                                                    disabled>
                                            </div>
                                            <label id="" class="col-form-label pl-1 align-bottom">
                                                Euro
                                            </label>
                                        </div>
                                    </div>
                                    <div v-else class="form-row mb-4 px-2 pt-2 d-flex justify-content-center align-items-center border rounded"
                                        style="background-color:lightseagreen; color:white"
                                    >
                                        <div class="form-group col-lg-12 mb-2 d-flex justify-content-center border-bottom">
                                                <h5 class="mb-1">Prețuri:</h5>
                                        </div>
                                        <div class="form-group col-lg-6 d-flex">
                                            <label for="pret_colete_kg" class="col-form-label mb-0 mr-2">Preț kg: </label>
                                            <div class="px-0">
                                                <input
                                                    type="text"
                                                    class="form-control form-control-sm"
                                                    style="width:50px"
                                                    name="pret_colete_kg"
                                                    v-model="pret_colete_kg"
                                                    required
                                                    disabled>
                                            </div>
                                            <label id="" class="col-form-label pl-1 align-bottom">
                                                Euro
                                            </label>
                                        </div>
                                        <div class="form-group col-lg-6 d-flex">
                                            <label for="pret_colete_kg" class="col-form-label mb-0 mr-2">Preț volum, 1m<sup>3</sup> : </label>
                                            <div class="px-0">
                                                <input
                                                    type="text"
                                                    class="form-control form-control-sm"
                                                    style="width:50px"
                                                    name="pret_colete_kg"
                                                    v-model="pret_colete_volum"
                                                    required
                                                    disabled>
                                            </div>
                                            <label id="" class="col-form-label pl-1 align-bottom">
                                                Euro
                                            </label>
                                        </div>
                                        <div class="form-group col-lg-12 border-left border-warning" style="border-width:5px !important">
                                            Dacă coletele dumneavoastră sunt peste raportul cantitate/ volum de 166kg / 1m<sup>3</sup>, prețul total se va calcula la prețul per kg. Dacă nu, prețul total se va calcula la prețul pe m<sup>3</sup>.
                                        </div>
                                        <div class="form-group col-lg-12 border-left border-warning" style="border-width:5px !important">
                                            La predarea coletului către șofer, prețul poate suferi modificări dacă dimensiunile sau cantitatea sunt altele decât cele înregistrate în acest formular.
                                        </div>
                                    </div>
                                    <div v-if="tip_calatorie === 'Calatori'" class="form-row mb-4 px-2 pt-2 d-flex justify-content-center align-items-center border rounded"
                                        style="background-color:lightseagreen; color:white"
                                    >
                                        <div class="form-group col-lg-12 mb-2 d-flex justify-content-center border-bottom">
                                                <h5 class="mb-1">Pasageri:</h5>
                                        </div>
                                        <div class="form-group col-lg-4 justify-content-center mb-4 d-flex">

                                            {{-- <div class="col-lg-6 px-0 d-flex align-self-center">                                                  --}}
                                                <label for="nr_adulti" class="col-form-label mb-0 mr-2">Nr. adulți:*</label>
                                            {{-- </div> --}}

                                            {{-- <div class="col-lg-6 px-0 d-flex align-self-center">   --}}
                                                <button type="button" class="btn m-0 p-0 mb-1"
                                                    v-on:click="nr_adulti -= 1;getPretTotal()"
                                                    >
                                                    <i class="far fa-minus-square bg-danger text-white fa-2x"></i>
                                                </button>
                                                <script type="application/javascript">
                                                    nrAdultiVechi={!! json_encode(old('nr_adulti', ($rezervare->nr_adulti ?? '0')), JSON_NUMERIC_CHECK) !!}
                                                </script>
                                                <div class="px-0" style="width:80px">
                                                    <input
                                                        type="text"
                                                        class="form-control form-control-sm {{ $errors->has('nr_adulti') ? 'is-invalid' : '' }}"
                                                        name="nr_adulti"
                                                        v-model="nr_adulti"
                                                        {{-- value="{{ old('nr_adulti') }}" --}}
                                                        required
                                                        readonly>
                                                </div>
                                                <button type="button" class="btn m-0 p-0 mb-1"
                                                    v-on:click="nr_adulti += 1;getPretTotal()">
                                                    <i class="far fa-plus-square bg-success text-white fa-2x">
                                                    </i>
                                                </button>
                                            {{-- </div> --}}
                                        </div>
                                        <div class="form-group col-lg-4 justify-content-center mb-4 d-flex">

                                            {{-- <div class="col-lg-6 px-0 d-flex align-self-center">                                                  --}}
                                                <label for="nr_copii" class="col-form-label mb-0 mr-2">Nr. copii:</label>
                                            {{-- </div> --}}

                                            {{-- <div class="col-lg-6 px-0 d-flex align-self-center">   --}}
                                                <button type="button" class="btn m-0 p-0 mb-1"
                                                    v-on:click="nr_copii -= 1;getPretTotal()"
                                                    >
                                                    <i class="far fa-minus-square bg-danger text-white fa-2x"></i>
                                                </button>
                                                <script type="application/javascript">
                                                    nrCopiiVechi={!! json_encode(old('nr_copii', ($rezervare->nr_copii ?? '0')), JSON_NUMERIC_CHECK) !!}
                                                </script>
                                                <div class="px-0" style="width:80px">
                                                    <input
                                                        type="text"
                                                        class="form-control form-control-sm {{ $errors->has('nr_copii') ? 'is-invalid' : '' }}"
                                                        name="nr_copii"
                                                        v-model="nr_copii"
                                                        {{-- value="{{ old('nr_copii') }}" --}}
                                                        required
                                                        readonly>
                                                </div>
                                                <button type="button" class="btn m-0 p-0 mb-1"
                                                    v-on:click="nr_copii += 1;getPretTotal()">
                                                    <i class="far fa-plus-square bg-success text-white fa-2x">
                                                    </i>
                                                </button>
                                            {{-- </div> --}}
                                        </div>
                                        {{-- <div class="form-group col-lg-4 justify-content-end mb-4 d-flex">
                                            <label for="pret_total" class="col-form-label mb-0 mr-2">Preț total:</label>
                                            <div class="px-0 d-flex" style="width:100px">
                                                <input
                                                    type="text"
                                                    class="form-control form-control-sm {{ $errors->has('pret_total') ? 'is-invalid' : '' }}"
                                                    name="pret_total"
                                                    v-model="pret_total"
                                                    required
                                                    disabled>
                                                <label id="" class="col-form-label pl-1 align-bottom">
                                                    Euro
                                                </label>
                                            </div>
                                        </div>    --}}
                                        {{-- @php
                                            $flattened = \Illuminate\Support\Arr::flatten($rezervare->pasageri['nume']);
                                            $buletin_flattened = \Illuminate\Support\Arr::flatten(old('pasageri.buletin', ($rezervare->pasageri['buletin'] ?? [])))
                                            dd($rezervare->pasageri['nume'], $flattened);
                                            dd(old('pasageri.nume'), ($rezervare->pasageri['nume'] ?? ''));
                                        @endphp --}}
                                        {{-- {{ old('pasageri.nume') ? old('pasageri.nume')->toArray() : '' }} --}}
                                        {{-- {{ $rezervare->pasageri['nume']->toArray() }} --}}
                                        <div class="form-group col-lg-12 justify-content-end m-0">
                                                <script type="application/javascript">
                                                    adultiNumeVechi={!! json_encode(\Illuminate\Support\Arr::flatten(old('adulti.nume', ($rezervare->adulti['nume'] ?? [])))) !!}
                                                    adultiDataNastereVechi={!! json_encode(\Illuminate\Support\Arr::flatten(old('adulti.data_nastere', ($rezervare->adulti['data_nastere'] ?? [])))) !!}
                                                    adultiLocalitateNastereVechi={!! json_encode(\Illuminate\Support\Arr::flatten(old('adulti.localitate_nastere', ($rezervare->adulti['localitate_nastere'] ?? [])))) !!}
                                                    adultiSexVechi={!! json_encode(\Illuminate\Support\Arr::flatten(old('adulti.sex', ($rezervare->adulti['sex'] ?? [])))) !!}
                                                    adultiDocumentVechi={!! json_encode(\Illuminate\Support\Arr::flatten(old('adulti.document', ($rezervare->adulti['document'] ?? [])))) !!}
                                                    adultiDocumentNrVechi={!! json_encode(\Illuminate\Support\Arr::flatten(old('adulti.document_nr', ($rezervare->adulti['document_nr'] ?? [])))) !!}

                                                    copiiNumeVechi={!! json_encode(\Illuminate\Support\Arr::flatten(old('copii.nume', ($rezervare->copii['nume'] ?? [])))) !!}
                                                    copiiDataNastereVechi={!! json_encode(\Illuminate\Support\Arr::flatten(old('copii.data_nastere', ($rezervare->copii['data_nastere'] ?? [])))) !!}
                                                    copiiLocalitateNastereVechi={!! json_encode(\Illuminate\Support\Arr::flatten(old('copii.localitate_nastere', ($rezervare->copii['localitate_nastere'] ?? [])))) !!}
                                                    copiiDocumentVechi={!! json_encode(\Illuminate\Support\Arr::flatten(old('copii.document', ($rezervare->copii['document'] ?? [])))) !!}
                                                    copiiDocumentNrVechi={!! json_encode(\Illuminate\Support\Arr::flatten(old('copii.document_nr', ($rezervare->copii['document_nr'] ?? [])))) !!}

                                                    // buletinVechi={!! json_encode(\Illuminate\Support\Arr::flatten(old('pasageri.buletin', ($rezervare->pasageri['buletin'] ?? [])))) !!}
                                                    // localitateNastereVechi={!! json_encode(\Illuminate\Support\Arr::flatten(old('pasageri.localitate_nastere', ($rezervare->pasageri['localitate_nastere'] ?? [])))) !!}
                                                    // localitateDomiciliuVechi={!! json_encode(\Illuminate\Support\Arr::flatten(old('pasageri.localitate_domiciliu', ($rezervare->pasageri['localitate_domiciliu'] ?? [])))) !!}
                                                </script>
                                            <div>
                                                <div v-for="adult in nr_adulti" :key="adult">
                                                    <div class="form-row align-items-start mb-2" style="background-color:#005757; border-radius: 10px 10px 10px 10px;">
                                                        <div class="col-lg-2">
                                                            <div class="row">
                                                                <div class="form-group col-lg-12 mb-0 pb-0">
                                                                    Adult @{{ adult }}:
                                                                    <br>
                                                                    <button  type="button" class="btn m-0 p-0 mb-1" @click="stergeAdult(adult-1)">
                                                                        <span class="px-1" style="background-color:red; color:white; border-radius:20px">
                                                                            Șterge adultul
                                                                        </span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-10">
                                                            <div class="row">
                                                                <div class="form-group col-lg-3">
                                                                    <label for="adulti_nume" class="col-form-label col-form-label-sm mb-0 py-0 mr-2">Nume și prenume:</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        :name="'adulti[nume][' + adult + ']'"
                                                                        v-model="adulti_nume[adult-1]">
                                                                </div>
                                                                {{-- <div class="form-group col-lg-3">
                                                                    <label for="adulti_buletin" class="col-form-label col-form-label-sm mb-0 py-0 mr-2">Seria si nr. buletin:</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        :name="'adulti[buletin][' + adult + ']'"
                                                                        v-model="adulti_buletin[adult-1]">
                                                                </div> --}}
                                                                <div class="form-group col-lg-3">
                                                                    <label for="adulti_data_nastere" class="col-form-label col-form-label-sm mb-0 py-0 mr-2">Data nașterii:</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="Ex: 01/01/2020"
                                                                        :name="'adulti[data_nastere][' + adult + ']'"
                                                                        v-model="adulti_data_nastere[adult-1]">
                                                                </div>
                                                                <div class="form-group col-lg-3">
                                                                    <label for="adulti_localitate_nastere" class="col-form-label col-form-label-sm mb-0 py-0 mr-2">Localitate naștere:</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        :name="'adulti[localitate_nastere][' + adult + ']'"
                                                                        v-model="adulti_localitate_nastere[adult-1]">
                                                                </div>
                                                                <div class="form-group col-lg-3">
                                                                    <label for="adulti_sex" class="col-form-label col-form-label-sm mb-0 py-0 mr-2">Sex:</label>
                                                                    <select class="custom-select-sm custom-select"
                                                                        :name="'adulti[sex][' + adult + ']'"
                                                                        v-model="adulti_sex[adult-1]">
                                                                        >
                                                                        <option disabled value="">Selectează o opțiune</option>
                                                                        <option
                                                                            v-for='tip_sex in tipuri_sex'
                                                                            :value='tip_sex.nume'
                                                                            >
                                                                                @{{tip_sex.nume}}
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                                {{-- <div class="form-group col-lg-3">
                                                                    <label for="pasageri_localitate_domiciliu" class="col-form-label col-form-label-sm mb-0 py-0 mr-2">Localitate domiciliu:</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        :name="'pasageri[localitate_domiciliu][' + adult + ']'"
                                                                        v-model="localitate_domiciliu[adult-1]">
                                                                </div> --}}
                                                                <div class="form-group col-lg-3">
                                                                    <label for="adulti_document" class="col-form-label col-form-label-sm mb-0 py-0 mr-2">Act de identitate:</label>
                                                                    <select class="custom-select-sm custom-select"
                                                                        :name="'adulti[document][' + adult + ']'"
                                                                        v-model="adulti_document[adult-1]">
                                                                        >
                                                                        <option disabled value="">Selectează o opțiune</option>
                                                                        <option
                                                                            v-for='tip_document in tipuri_documente'
                                                                            :value='tip_document.nume'
                                                                            >
                                                                                @{{tip_document.nume}}
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-lg-3">
                                                                    <label for="adulti_document_nr" class="col-form-label col-form-label-sm mb-0 py-0 mr-2">Număr act identitate:</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        :name="'adulti[document_nr][' + adult + ']'"
                                                                        v-model="adulti_document_nr[adult-1]">
                                                                </div>
                                                                <div class="col-lg-3">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <div v-for="copil in nr_copii" :key="copil">
                                                    <div class="form-row align-items-start mb-2" style="background-color:#005757; border-radius: 10px 10px 10px 10px;">
                                                        <div class="col-lg-2">
                                                            <div class="row">
                                                                <div class="form-group col-lg-12 mb-0 pb-0">
                                                                    Copil @{{ copil }}:
                                                                    <br>
                                                                    <button  type="button" class="btn m-0 p-0 mb-1" @click="stergeCopil(copil-1)">
                                                                        <span class="px-1" style="background-color:red; color:white; border-radius:20px">
                                                                            Șterge copilul
                                                                        </span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-10">
                                                            <div class="row">
                                                                <div class="form-group col-lg-3">
                                                                    <label for="copii_nume" class="col-form-label col-form-label-sm mb-0 py-0 mr-2">Nume și prenume:</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        :name="'copii[nume][' + copil + ']'"
                                                                        v-model="copii_nume[copil-1]">
                                                                </div>
                                                                <div class="form-group col-lg-3">
                                                                    <label for="copii_data_nastere" class="col-form-label col-form-label-sm mb-0 py-0 mr-2">Data nașterii:</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="Ex: 01/01/2020"
                                                                        :name="'copii[data_nastere][' + copil + ']'"
                                                                        v-model="copii_data_nastere[copil-1]">
                                                                </div>
                                                                <div class="form-group col-lg-3">
                                                                    <label for="copii_licalitate_nastere" class="col-form-label col-form-label-sm mb-0 py-0 mr-2">Localitate naștere:</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        :name="'copii[localitate_nastere][' + copil + ']'"
                                                                        v-model="copii_localitate_nastere[copil-1]">
                                                                </div>
                                                                <div class="form-group col-lg-3">
                                                                    <label for="copii_sex" class="col-form-label col-form-label-sm mb-0 py-0 mr-2">Sex:</label>
                                                                    <select class="custom-select-sm custom-select"
                                                                        :name="'copii[sex][' + copil + ']'"
                                                                        v-model="copii_sex[copil-1]">
                                                                        >
                                                                        <option disabled value="">Selectează o opțiune</option>
                                                                        <option
                                                                            v-for='tip_sex in tipuri_sex'
                                                                            :value='tip_sex.nume'
                                                                            >
                                                                                @{{tip_sex.nume}}
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-lg-3">
                                                                    <label for="copii_document" class="col-form-label col-form-label-sm mb-0 py-0 mr-2">Act de identitate:</label>
                                                                    <select class="custom-select-sm custom-select"
                                                                        :name="'copii[document][' + copil + ']'"
                                                                        v-model="copii_document[copil-1]">
                                                                        >
                                                                        <option disabled value="">Selectează o opțiune</option>
                                                                        <option
                                                                            v-for='tip_document in tipuri_documente'
                                                                            :value='tip_document.nume'
                                                                            >
                                                                                @{{tip_document.nume}}
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-lg-3">
                                                                    <label for="copii_document_nr" class="col-form-label col-form-label-sm mb-0 py-0 mr-2">Număr act identitate:</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        :name="'copii[document_nr][' + copil + ']'"
                                                                        v-model="copii_document_nr[copil-1]">
                                                                </div>
                                                                <div class="col-lg-3">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="form-group col-lg-12 mb-2 justify-content-center">
                                            <label for="pasageri" class="mb-0">Pasageri(numele si seria de buletin pentru fiecare pasager):*</label>
                                            <textarea class="form-control {{ $errors->has('pasageri') ? 'is-invalid' : '' }}"
                                                name="pasageri" id="pasageri" rows="2">{{ old('pasageri') }}</textarea>
                                        </div>  --}}
                                    </div>
                                    <div v-if="tip_calatorie === 'Colete'" class="form-row mb-4 px-2 py-2 d-flex justify-content-between align-items-center border rounded"
                                        style="background-color:lightseagreen; color:white"
                                    >
                                        <div class="form-group col-lg-12 mb-0 d-flex">
                                            <small id="colete_kg" class="form-text border-left border-warning pl-1" style="border-width:5px !important">Folosiți punctul(<b>.</b>) pentru a delimita zecimalele.</small>
                                        </div>
                                        <div class="form-group col-lg-3 mb-0 d-flex">
                                            <label for="colete_numar" class="col-form-label mb-0 mr-2">Număr de colete:* </label>
                                            <div class="px-0" style="width:50px">
                                                <input
                                                    type="text"
                                                    class="form-control form-control-sm {{ $errors->has('colete_numar') ? 'is-invalid' : '' }}"
                                                    name="colete_numar"
                                                    placeholder=""
                                                    value="{{ old('colete_numar', ($rezervare->colete_numar ?? '')) }}"
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-3 mb-0 d-flex">
                                            <script type="application/javascript">
                                                coleteKgVechi={!! json_encode(old('colete_kg', ($rezervare->colete_kg ?? '0')), JSON_NUMERIC_CHECK) !!}
                                            </script>
                                            <label for="colete_kg" class="col-form-label mb-0 mr-2">Cantitate:* </label>
                                            <div class="px-0" style="width:100px">
                                                <input
                                                    type="text"
                                                    class="form-control form-control-sm {{ $errors->has('colete_kg') ? 'is-invalid' : '' }}"
                                                    name="colete_kg"
                                                    v-model="colete_kg"
                                                    placeholder=""
                                                    value="{{ old('colete_kg', ($rezervare->colete_kg ?? '')) }}"
                                                >
                                            </div>
                                            <label id="" class="col-form-label pl-1 align-bottom">
                                                Kg
                                            </label>
                                        </div>
                                        <div class="form-group col-lg-3 mb-0 d-flex">
                                            <script type="application/javascript">
                                                coleteVolumVechi={!! json_encode(old('colete_volum', ($rezervare->colete_volum ?? '0')), JSON_NUMERIC_CHECK) !!}
                                            </script>
                                            <label for="colete_volum" class="col-form-label mb-0 mr-2">Volum:</label>
                                            <div class="px-0" style="width:100px">
                                                <input
                                                    type="text"
                                                    class="form-control form-control-sm {{ $errors->has('colete_volum') ? 'is-invalid' : '' }}"
                                                    name="colete_volum"
                                                    v-model="colete_volum"
                                                    placeholder=""
                                                    value="{{ old('colete_volum', ($rezervare->colete_volum ?? '')) }}"
                                                >
                                            </div>
                                            <label id="" class="col-form-label pl-1 align-bottom">
                                                m<sup>3</sup>
                                            </label>
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label for="colete_natura_marfii" class="mb-0">Natura mărfii:*</label>
                                            <input
                                                type="text"
                                                class="form-control form-control-sm {{ $errors->has('colete_natura_marfii') ? 'is-invalid' : '' }}"
                                                name="colete_natura_marfii"
                                                placeholder=""
                                                value="{{ old('colete_natura_marfii', ($rezervare->colete_natura_marfii ?? '')) }}"
                                                required>
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label for="colete_mod_ambalare" class="mb-0">Mod de ambalare:*</label>
                                            <input
                                                type="text"
                                                class="form-control form-control-sm {{ $errors->has('colete_mod_ambalare') ? 'is-invalid' : '' }}"
                                                name="colete_mod_ambalare"
                                                placeholder=""
                                                value="{{ old('colete_mod_ambalare', ($rezervare->colete_mod_ambalare ?? '')) }}"
                                                required>
                                        </div>
                                        {{-- <div class="form-group col-lg-12 mb-0 justify-content-center">
                                            <label for="colete_descriere" class="mb-0">Descriere colete:*</label>
                                            <textarea class="form-control {{ $errors->has('colete_descriere') ? 'is-invalid' : '' }}"
                                                name="colete_descriere" id="colete_descriere" rows="2">{{ old('colete_descriere', ($rezervare->colete_descriere ?? '')) }}</textarea>
                                        </div> --}}
                                    </div>
                                    <div class="form-row mb-4 px-2 pt-2 d-flex justify-content-center align-items-center border rounded"
                                        style="background-color:lightseagreen; color:white"
                                    >
                                        <div v-if="tur_retur" class="col-lg-12">
                                            {{-- <div class="form-group col-lg-12 mb-1"> --}}
                                                <div class="row justify-content-center">
                                                    <div class="col-lg-5 d-flex justify-content-center">
                                                        <h5 class="mb-0 d-flex align-items-center">
                                                            Preț tur:
                                                                <input
                                                                    type="text"
                                                                    class="form-control form-control-sm mx-1 {{ $errors->has('pret_total') ? 'is-invalid' : '' }}"
                                                                    style="width:70px"
                                                                    name="pret_total_tur"
                                                                    {{
                                                                        (isset($tip_operatie) && ($tip_operatie === "modificare")) ?
                                                                            'value=' . old('pret_total_tur', ($rezervare->pret_total_tur ?? ''))
                                                                            :
                                                                            'v-model=pret_total_tur'
                                                                    }}
                                                                    required
                                                                    {{ auth()->check() ? '' : 'disabled' }}
                                                                >
                                                            <label id="" class="col-form-label pl-1 align-bottom">
                                                                Euro
                                                            </label>
                                                        </h5>
                                                    </div>
                                                    <div class="col-lg-5 d-flex justify-content-center">
                                                        <h5 class="mb-0 d-flex align-items-center">
                                                            Preț retur:
                                                            <input
                                                                type="text"
                                                                class="form-control form-control-sm mx-1 {{ $errors->has('pret_total') ? 'is-invalid' : '' }}"
                                                                style="width:70px"
                                                                name="pret_total_retur"
                                                                {{
                                                                    (isset($tip_operatie) && ($tip_operatie === "modificare")) ?
                                                                        'value=' . old('pret_total_retur', ($rezervare->pret_total_retur ?? ''))
                                                                        :
                                                                        'v-model=pret_total_retur'
                                                                }}
                                                                required
                                                                {{ auth()->check() ? '' : 'disabled' }}
                                                            >
                                                            <label id="" class="col-form-label pl-1 align-bottom">
                                                                Euro
                                                            </label>
                                                        </h5>
                                                    </div>
                                                </div>
                                            {{-- </div> --}}
                                        </div>
                                        <div v-else>
                                            <div class="form-group col-lg-12 mb-1 d-flex justify-content-center">
                                                <div>
                                                    <h5 class="mb-0 d-flex align-items-center">
                                                        Preț total:
                                                        <input
                                                            type="text"
                                                            class="form-control form-control-sm mx-1 {{ $errors->has('pret_total') ? 'is-invalid' : '' }}"
                                                            style="width:70px"
                                                            name="pret_total_tur"
                                                            {{
                                                                (isset($tip_operatie) && ($tip_operatie === "modificare")) ?
                                                                    'value=' . old('pret_total_tur', ($rezervare->pret_total_tur ?? ''))
                                                                    :
                                                                    'v-model=pret_total_tur'
                                                            }}
                                                            required
                                                            {{ auth()->check() ? '' : 'disabled' }}
                                                        >
                                                        <label id="" class="col-form-label pl-1 align-bottom">
                                                            Euro
                                                        </label>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-if="tip_calatorie === 'Calatori'" class="form-row mb-4 px-2 py-2 justify-content-between align-items-center border rounded"
                                        style="background-color:lightseagreen; color:white"
                                    >
                                        <div class="form-group col-lg-4">
                                            <label for="telefon" class="mb-0">Telefon:*</label>
                                            <input
                                                type="text"
                                                class="form-control form-control-sm {{ $errors->has('telefon') ? 'is-invalid' : '' }}"
                                                name="telefon"
                                                placeholder=""
                                                value="{{ old('telefon', ($rezervare->telefon ?? '')) }}"
                                                required>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="email" class="mb-0">Email:</label>
                                            <input
                                                type="text"
                                                class="form-control form-control-sm {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                                name="email"
                                                placeholder=""
                                                value="{{ old('email', ($rezervare->email ?? '')) }}"
                                                required>
                                        </div>
                                        <div class="form-group col-lg-12 mb-1 justify-content-center">
                                            <label for="observatii" class="mb-0">Observații:</label>
                                            <textarea class="form-control {{ $errors->has('observatii') ? 'is-invalid' : '' }}"
                                                name="observatii" id="observatii" rows="2">{{ old('observatii', ($rezervare->observatii ?? '')) }}</textarea>
                                        </div>
                                    </div>
                                    <div v-if="tip_calatorie === 'Colete'" class="form-row mb-4 px-2 py-2 justify-content-between align-items-center border rounded"
                                        style="background-color:lightseagreen; color:white"
                                    >
                                        <div class="form-group col-lg-4">
                                            <label for="nume" class="mb-0">Nume și prenume Expeditor:*</label>
                                            <input
                                                type="text"
                                                class="form-control form-control-sm {{ $errors->has('nume') ? 'is-invalid' : '' }}"
                                                name="nume"
                                                placeholder=""
                                                value="{{ old('nume', ($rezervare->nume ?? '')) }}"
                                                required>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="telefon" class="mb-0">Telefon Expeditor:*</label>
                                            <input
                                                type="text"
                                                class="form-control form-control-sm {{ $errors->has('telefon') ? 'is-invalid' : '' }}"
                                                name="telefon"
                                                placeholder=""
                                                value="{{ old('telefon', ($rezervare->telefon ?? '')) }}"
                                                required>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="email" class="mb-0">Email Expeditor:</label>
                                            <input
                                                type="text"
                                                class="form-control form-control-sm {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                                name="email"
                                                placeholder=""
                                                value="{{ old('email', ($rezervare->email ?? '')) }}"
                                                required>
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label for="adresa" class="mb-0">Adresă Expeditor:*</label>
                                            <input
                                                type="text"
                                                class="form-control form-control-sm {{ $errors->has('adresa') ? 'is-invalid' : '' }}"
                                                name="adresa"
                                                placeholder=""
                                                value="{{ old('adresa', ($rezervare->adresa ?? '')) }}"
                                                required>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="colete_nume_destinatar" class="mb-0">Nume și prenume Destinatar:*</label>
                                            <input
                                                type="text"
                                                class="form-control form-control-sm {{ $errors->has('colete_nume_destinatar') ? 'is-invalid' : '' }}"
                                                name="colete_nume_destinatar"
                                                placeholder=""
                                                value="{{ old('colete_nume_destinatar', ($rezervare->colete_nume_destinatar ?? '')) }}"
                                                required>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="colete_telefon_destinatar" class="mb-0">Telefon Destinatar:*</label>
                                            <input
                                                type="text"
                                                class="form-control form-control-sm {{ $errors->has('colete_telefon_destinatar') ? 'is-invalid' : '' }}"
                                                name="colete_telefon_destinatar"
                                                placeholder=""
                                                value="{{ old('colete_telefon_destinatar', ($rezervare->colete_telefon_destinatar ?? '')) }}"
                                                required>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="colete_email_destinatar" class="mb-0">Email Destinatar:</label>
                                            <input
                                                type="text"
                                                class="form-control form-control-sm {{ $errors->has('colete_email_destinatar') ? 'is-invalid' : '' }}"
                                                name="colete_email_destinatar"
                                                placeholder=""
                                                value="{{ old('colete_email_destinatar', ($rezervare->colete_email_destinatar ?? '')) }}"
                                                required>
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label for="colete_adresa_destinatar" class="mb-0">Adresă Destinatar:*</label>
                                            <input
                                                type="text"
                                                class="form-control form-control-sm {{ $errors->has('colete_adresa_destinatar') ? 'is-invalid' : '' }}"
                                                name="colete_adresa_destinatar"
                                                placeholder=""
                                                value="{{ old('colete_adresa_destinatar', ($rezervare->colete_adresa_destinatar ?? '')) }}"
                                                required>
                                        </div>
                                        <div class="form-group col-lg-12 mb-1 justify-content-center">
                                            <label for="observatii" class="mb-0">Observații:</label>
                                            <textarea class="form-control {{ $errors->has('observatii') ? 'is-invalid' : '' }}"
                                                name="observatii" id="observatii" rows="2">{{ old('observatii', ($rezervare->observatii ?? '')) }}</textarea>
                                        </div>
                                    </div>



                                    {{-- Facturare --}}
                                                    <script type="application/javascript">
                                                        cumparatorVechi={!! json_encode(old('cumparator', ($rezervare->cumparator ?? ''))) !!}
                                                        nr_reg_comVechi={!! json_encode(old('nr_reg_com', ($rezervare->nr_reg_com ?? ''))) !!}
                                                        cifVechi={!! json_encode(old('cif', ($rezervare->cif ?? ''))) !!}
                                                        judetVechi={!! json_encode(old('judet', ($rezervare->judet ?? ''))) !!}
                                                        sediulVechi={!! json_encode(old('sediul', ($rezervare->sediul ?? ''))) !!}
                                                    </script>
                                @auth
                                    <div  v-if="tip_calatorie === 'Calatori'"
                                        class="form-row mb-4 px-2 pt-2 d-flex justify-content-between align-items-center border rounded"
                                        style="background-color:lightseagreen; color:white"
                                    >
                                        <div class="form-group col-lg-12 mb-2 d-flex justify-content-center border-bottom">
                                                <h5 class="mb-1">Date pentru facturare:</h5>
                                        </div>
                                        <div class="form-group col-lg-12 mb-2">
                                                <span>*Completați aceste câmpuri doar dacă doriți factură.</h5>
                                        </div>
                                        <div class="form-group col-lg-4 mb-2">
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    <label for="cumparator" class="mb-0">Cumpărător:</label>
                                                    <input
                                                        type="text"
                                                        v-model="cumparator"
                                                        v-on:keyup="autoComplete()"
                                                        class="form-control form-control-sm {{ $errors->has('cumparator') ? 'is-invalid' : '' }}"
                                                        name="cumparator"
                                                        placeholder=""
                                                        value="{{ old('cumparator', ($rezervare->cumparator ?? '')) }}"
                                                        autocomplete="off"
                                                        required>
                                                    <div class="panel-footer" v-if="cumparatori.length">
                                                        <ul class="list-group">
                                                            <li class="list-group-item button"
                                                                v-for="client in cumparatori">
                                                                <button type="button"
                                                                    v-on:click="
                                                                        cumparator = client.cumparator;
                                                                        nr_reg_com = client.nr_reg_com;
                                                                        cif = client.cif;
                                                                        judet = client.judet;
                                                                        sediul = client.sediul;
                                                                        cumparatori = ''
                                                                    ">
                                                                        @{{ client.cumparator }}
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 mb-2">
                                            <label for="nr_reg_com" class="mb-0">Nr. Reg. Com.:</label>
                                            <input
                                                type="text"
                                                v-model="nr_reg_com"
                                                class="form-control form-control-sm {{ $errors->has('nr_reg_com') ? 'is-invalid' : '' }}"
                                                name="nr_reg_com"
                                                placeholder=""
                                                value="{{ old('nr_reg_com', ($rezervare->nr_reg_com ?? '')) }}"
                                                required>
                                        </div>
                                        <div class="form-group col-lg-4 mb-2">
                                            <label for="cif" class="mb-0">CIF:</label>
                                            <input
                                                type="text"
                                                v-model="cif"
                                                class="form-control form-control-sm {{ $errors->has('cif') ? 'is-invalid' : '' }}"
                                                name="cif"
                                                placeholder=""
                                                value="{{ old('cif', ($rezervare->cif ?? '')) }}"
                                                required>
                                        </div>
                                        <div class="form-group col-lg-4 mb-2">
                                            <label for="judet" class="mb-0">Județul:</label>
                                            <input
                                                type="text"
                                                v-model="judet"
                                                class="form-control form-control-sm {{ $errors->has('judet') ? 'is-invalid' : '' }}"
                                                name="judet"
                                                placeholder=""
                                                value="{{ old('judet', ($rezervare->judet ?? '')) }}"
                                                required>
                                        </div>
                                        <div class="form-group col-lg-8 mb-2">
                                            <label for="sediul" class="mb-0">Sediul:</label>
                                            <input
                                                type="text"
                                                v-model="sediul"
                                                class="form-control form-control-sm {{ $errors->has('sediul') ? 'is-invalid' : '' }}"
                                                name="sediul"
                                                placeholder=""
                                                value="{{ old('sediul', ($rezervare->sediul ?? '')) }}"
                                                required>
                                        </div>
                                    </div>
                                @endauth
                                    <div v-if="tip_calatorie === 'Calatori'" class="form-row px-2 py-2 justify-content-between">
                                        <div class="form-group col-lg-12 border-left border-info" style="border-width:5px !important">
                                            * În prețul biletului aveți inclus 60 kg ptr bagajul dvs. Excedentul se tarifează cu 1 Euro / kg.
                                            {{-- * IN PRETUL BILETULUI AVETI INCLUS 40 KG PTR BAGAJUL DVS , CE DEPASESTE SE TAXEAZA CU 1 EURO / KG !!! --}}
                                        </div>
                                    </div>
                                    <div class="form-row px-2 py-2 justify-content-between">
                                        <div class="form-group col-lg-12 border-left border-warning" style="border-width:5px !important">
                                            <label for="" class="mr-4">Acord de confidențialitate:</label>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="acord_de_confidentialitate" value="1" required
                                                {{ old('acord_de_confidentialitate', ($rezervare->acord_de_confidentialitate ?? "0")) === "1" ? 'checked' : '' }}>
                                                <label class="form-check-label" for="acord_de_confidentialitate">
                                                    *Sunt de acord cu colectarea și prelucrarea datelor cu caracter personal -
                                                    <a href="https://transportcorsica.ro/termeni-si-conditii#politica-de-confidentialitate" target="_blank">
                                                        <span class="badge badge-primary border border-dark"
                                                            style="background-color:yellow; color:black"
                                                        >
                                                            nota de informare
                                                        </span>
                                                    </a>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row px-2 py-2 justify-content-between">
                                        <div class="form-group col-lg-12 border-left border-warning" style="border-width:5px !important">
                                            <label for="" class="mr-4">Termeni și condiții:</label>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="termeni_si_conditii" value="1" required
                                                {{ old('termeni_si_conditii', ($rezervare->termeni_si_conditii ?? "0")) === "1" ? 'checked' : '' }}>
                                                <label class="form-check-label" for="termeni_si_conditii">
                                                    *Sunt de acord cu condițiile generale de transport persoane -
                                                    <a href="https://transportcorsica.ro/termeni-si-conditii/" target="_blank">
                                                        <span class="badge badge-primary border border-dark"
                                                            style="background-color:red; color:white"
                                                        >
                                                            Termeni și condiții
                                                        </span>
                                                    </a>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row px-2 py-2 justify-content-between">
                                        <div class="form-group col-lg-12 border-left border-warning" style="border-width:5px !important">
                                            <label for="" class="mr-4">Newsletter:</label>
                                            <input type="hidden" name="acord_newsletter" value="0" />
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="acord_newsletter" value="1"
                                                {{ old('acord_newsletter', ($rezervare->acord_newsletter ?? "0")) == "1" ? 'checked' : '' }}>
                                                <label class="form-check-label" for="acord_newsletter">
                                                    Abonează-te la newsletter pentru a primi cele mai bune oferte!
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @if (isset($tip_operatie) && ($tip_operatie === "modificare"))
                                    @method('PATCH')

                                    {{-- salvarea ultimului URL, pentru intoarcerea la Rapoarte daca de acolo s-a initiat modificarea --}}
                                    <input type="hidden" id="last_url" name="last_url" value="{{ $last_url }}">

                                    <div class="form-row mb-1 px-2 justify-content-center align-items-center">
                                        <div class="col-lg-8 d-flex justify-content-center">
                                            <button type="submit" class="btn btn-lg btn-warning btn-block mr-4">Modifică Rezervarea</button>
                                        </div>
                                    </div>
                                @else
                                    <div class="form-row mb-1 px-2 justify-content-center align-items-center">
                                        <div class="col-lg-8 d-flex justify-content-center">
                                            <button type="submit" class="btn btn-lg btn-warning btn-block mr-4">Verifică Rezervarea</button>
                                        </div>
                                    </div>
                                @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
