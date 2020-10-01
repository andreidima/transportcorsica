@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="shadow-lg bg-white" style="border-radius: 40px 40px 40px 40px;">
                <div class="p-2 d-flex justify-content-between align-items-end" 
                    style="border-radius: 40px 40px 0px 0px; border:2px solid darkcyan">                     
                    <h3 class="ml-3" style="color:darkcyan"><i class="fas fa-ticket-alt fa-lg mr-1"></i>Rezervare bilet</h3>
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
                    <form  class="needs-validation" novalidate method="POST" action="/adauga-rezervare-pasul-1">
                        @csrf

                        <div class="form-row mb-0 d-flex justify-content-center border-radius: 0px 0px 40px 40px">
                            <div class="form-group col-lg-12 px-2 mb-0">
                                
                                <div class="form-row mb-4 d-flex justify-content-center">
                                        <script type="application/javascript"> 
                                            tipCalatorieVeche={!! json_encode(old('tip_calatorie', "")) !!} 
                                        </script>
                                    <div class="col-lg-10 pl-3">
                                        Selectează tip cursă:
                                    </div>
                                    <div class="col-lg-10 btn-group btn-group-toggle">
                                        <label class="btn btn-sm btn-success col-lg-6 border" v-bind:class="[tip_calatorie=='Calatori' ? active : '']">
                                            <input type="radio" class="btn-group-toggle" name="tip_calatorie" id="tip_calatorie1" autocomplete="off"
                                                v-model="tip_calatorie" value="Calatori"
                                                v-on:change="setTaraPlecare();getJudetePlecareInitial();getJudeteSosireInitial();setPreturi();"
                                                >
                                                    <i class="fas fa-users" style="font-size: 2em;"></i>
                                                    <span style="font-size: 2em;">
                                                        Transport Călători
                                                    </span>
                                        </label>
                                        <label class="btn btn-sm btn-success col-lg-6 border" v-bind:class="[tip_calatorie=='Bagaje' ? active : '']">
                                            <input type="radio" class="btn-group-toggle" name="tip_calatorie" id="tip_calatorie2" autocomplete="off"
                                                v-model="tip_calatorie" value="Bagaje"
                                                v-on:change="setTaraPlecare();getJudetePlecareInitial();getJudeteSosireInitial();setPreturi();"
                                                >
                                                    <i class="fas fa-box" style="font-size: 2em;"></i>
                                                    <span style="font-size: 2em;">
                                                        Transport Bagaje
                                                    </span>
                                        </label>
                                    </div>
                                </div>
                            <div v-cloak v-if="tip_calatorie">
                                <div class="form-row mb-4 d-flex justify-content-center">
                                        <script type="application/javascript"> 
                                            traseuVechi={!! json_encode(old('traseu', "")) !!} 
                                        </script>
                                    <div class="col-lg-7 pl-3">
                                        Selectează traseu:
                                    </div>
                                    <div class="col-lg-7 mb-4 btn-group btn-group-toggle">
                                        <label class="btn btn-success btn-sm border" v-bind:class="[traseu=='Romania-Corsica' ? active : '']">
                                            <input type="radio" class="btn-group-toggle" name="traseu" id="traseu1" autocomplete="off"
                                                v-model="traseu" value="Romania-Corsica"
                                                v-on:change="setTaraPlecare();getJudetePlecare();getJudeteSosire();setPreturi()"
                                                >
                                                    <span style="font-size: 1.2em;">
                                                        România -> Corsica
                                                    </span>
                                        </label>
                                        <label class="btn btn-success btn-sm border" v-bind:class="[traseu=='Corsica-Romania' ? active : '']">
                                            <input type="radio" class="btn-group-toggle" name="traseu" id="traseu2" autocomplete="off"
                                                v-model="traseu" value="Corsica-Romania"
                                                v-on:change="setTaraPlecare();getJudetePlecare();getJudeteSosire();setPreturi();"
                                                >
                                                    <span style="font-size: 1.2em;">
                                                        Corsica -> România
                                                    </span>
                                        </label>
                                    </div>
                                    <div class="custom-control custom-switch col-lg-12 text-center py-1">
                                        @if (old('tur_retur') === 'true')
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
                                        @change='setPreturi();getPretTotal()'
                                        >
                                        <label class="custom-control-label" for="customSwitch1">TUR - RETUR</label>                                        
                                    </div>
                                </div>
                            </div>


                    {{-- <div v-if="tur_retur">                --}}
                        {{-- <span  v-for="index in nr_adulti" :key="index">
                            <input type="text" class="form-control" name="pasagerit[nume][]" v-model="nume[index-1]"><br/>
                            <input type="text" class="form-control" name="pasagerit[buletin][]" v-model="buletin[index-1]"><br/>
                        </span> --}}
                    {{-- </div> --}}

            {{-- :value="type.tags"
            :key="type.index" 
            :id="type.id" > --}}
                            <label >@{{judet_plecare.judet}}</label>

      
                                <div v-cloak v-if="traseu">                        
                                    <div class="row mb-2">
                                        <div class="col-lg-6">
                                            <div class="form-row">
                                                <div class="col-lg-12">
                                                    Plecare din:*
                                                </div>
                                                <div class="form-group col-lg-6">                                        
                                                    {{-- <label for="judet_plecare" class="mb-0">Județ:<span class="text-white">*</span></label>   --}}
                                                    <script type="application/javascript"> 
                                                        judetPlecareVechi={!! json_encode(old('judet_plecare', "0")) !!} 
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
                                                </div>
                                                <div class="form-group col-lg-6">   
                                                    {{-- <label for="oras_plecare" class="mb-0">Oraș:<span class="text-white">*</span></label>  --}}
                                                    <script type="application/javascript"> 
                                                        orasPlecareVechi={!! json_encode(old('oras_plecare', "0")) !!} 
                                                    </script>
                                                    <select class="custom-select-sm custom-select {{ $errors->has('oras_plecare') ? 'is-invalid' : '' }}"
                                                        name="oras_plecare"
                                                        v-model="oras_plecare"
                                                        {{-- @change='getPreturi();getPretTotal()' --}}
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
                                        <div class="col-lg-6">
                                            <div class="form-row">
                                                <div class="col-lg-12">
                                                    Sosire la:*
                                                </div>
                                                <div class="form-group col-lg-6"> 
                                                    {{-- <label for="judet_plecare" class="mb-0">Județ:<span class="text-white">*</span></label>   --}}
                                                    <script type="application/javascript"> 
                                                        judetSosireVechi={!! json_encode(old('judet_sosire', "0")) !!}
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
                                                </div>
                                                <div class="form-group col-lg-6">   
                                                    {{-- <label for="oras_plecare" class="mb-0">Oraș:<span class="text-white">*</span></label>     --}}
                                                    <script type="application/javascript"> 
                                                        orasSosireVechi={!! json_encode(old('oras_sosire', "0")) !!} 
                                                    </script>
                                                        <select class="custom-select-sm custom-select {{ $errors->has('oras_sosire') ? 'is-invalid' : '' }}"
                                                            name="oras_sosire"
                                                            v-model="oras_sosire"
                                                            {{-- @change='getPreturi();getPretTotal()' --}}
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
                                    </div>
                                    <div class="form-row mb-4 px-2 py-2 d-flex justify-content-center align-items-center border rounded"
                                        style="background-color:lightseagreen; color:white"
                                    >
                                        <div class="form-group col-lg-12 mb-2 d-flex justify-content-center border-bottom">
                                                <h5 class="mb-1">Plecare în călătorie:</h5>
                                        </div>
                                        <div class="form-group col-lg-12 border-left border-warning" style="border-width:5px !important">
                                            Plecarile din România au loc săptămânal, miercurea, la ora 20:00, din Focșani.
                                            <br>
                                            Plecarile din Corsica au loc săptămânal, vinerea, la ora 18:00, din Corsica.
                                        </div>
                                        <div class="form-group col-lg-4 mb-0 d-flex justify-content-center align-items-end">
                                            <label for="data_plecare" class="mb-0 mr-2">Dată plecare:*</label>
                                            <div v-if="traseu === 'Romania-Corsica'" class=""> 
                                                <vue2-datepicker-plecare
                                                    data-veche="{{ old('data_plecare') == '' ? '' : old('data_plecare') }}"
                                                    nume-camp-db="data_plecare"
                                                    :latime="{ width: '125px' }"
                                                    tip="date"
                                                    value-type="YYYY-MM-DD"
                                                    format="DD-MM-YYYY"
                                                    not-before-date="{{ \Carbon\Carbon::today() }}"
                                                    :doar-ziua="3"
                                                ></vue2-datepicker-plecare>
                                            </div> 
                                            <div v-if="traseu === 'Corsica-Romania'">
                                                <vue2-datepicker-intoarcere
                                                    data-veche="{{ old('data_plecare') == '' ? '' : old('data_plecare') }}"
                                                    nume-camp-db="data_plecare"
                                                    :latime="{ width: '125px' }"
                                                    tip="date"
                                                    value-type="YYYY-MM-DD"
                                                    format="DD-MM-YYYY"
                                                    not-before-date="{{ \Carbon\Carbon::today() }}"
                                                    :doar-ziua="5"
                                                ></vue2-datepicker-intoarcere> 
                                            </div>
                                        </div>
                                        <div v-if="tur_retur" class="form-group col-lg-4 mb-0 d-flex justify-content-center align-items-end">
                                            <label for="data_intoarcere" class="mb-0 mr-2">Dată întoarcere:*</label>
                                            <div v-if="traseu === 'Romania-Corsica'">
                                                <vue2-datepicker-intoarcere
                                                    data-veche="{{ old('data_intoarcere') == '' ? '' : old('data_intoarcere') }}"
                                                    nume-camp-db="data_intoarcere"
                                                    :latime="{ width: '125px' }"
                                                    tip="date"
                                                    value-type="YYYY-MM-DD"
                                                    format="DD-MM-YYYY"
                                                    not-before-date="{{ \Carbon\Carbon::today() }}"
                                                    :doar-ziua="5"
                                                ></vue2-datepicker-intoarcere> 
                                            </div>
                                            <div v-if="traseu === 'Corsica-Romania'"> 
                                                <vue2-datepicker-plecare
                                                    data-veche="{{ old('data_intoarcere') == '' ? '' : old('data_intoarcere') }}"
                                                    nume-camp-db="data_intoarcere"
                                                    :latime="{ width: '125px' }"
                                                    tip="date"
                                                    value-type="YYYY-MM-DD"
                                                    format="DD-MM-YYYY"
                                                    not-before-date="{{ \Carbon\Carbon::today() }}"
                                                    :doar-ziua="3"
                                                ></vue2-datepicker-plecare>
                                            </div> 
                                        </div>
                                        {{-- <div v-if="tur_retur" class="form-group col-lg-12 justify-content-center align-items-end text-center"> --}}
                                        <div v-if="tur_retur" class="form-group col-lg-12 mb-0 mt-3 border-left border-warning" style="border-width:5px !important">
                                            Data de intoarcere trebuie sa fie la maxim 15 zile de la data de plecare.
                                        </div>
                                    </div> 
                                    <div v-if="tip_calatorie === 'Calatori'" class="form-row mb-4 px-2 pt-2 d-flex justify-content-center align-items-center border rounded"
                                        style="background-color:lightseagreen; color:white"
                                    >
                                        <div class="form-group col-lg-12 mb-2 d-flex justify-content-center border-bottom">
                                                <h5 class="mb-1">Pasageri și costuri:</h5>
                                        </div>
                                        <div class="form-group col-lg-4 mb-2 d-flex">
                                            <label for="pret_adult" class="col-form-label mb-0 mr-2">Preț per pasager: </label>
                                            <div class="px-0" style="width:50px">
                                                <input 
                                                    type="text" 
                                                    class="form-control form-control-sm {{ $errors->has('pret_adult') ? 'is-invalid' : '' }}" 
                                                    name="pret_adult"
                                                    v-model="pret_adult" 
                                                    {{-- value="{{ old('pret_adult') }}" --}}
                                                    value="{{ 120 }}"
                                                    required
                                                    disabled>
                                            </div>
                                            <label id="" class="col-form-label pl-1 align-bottom">
                                                Euro
                                            </label>
                                        </div>
                                        <div class="form-group col-lg-4  justify-content-center m-0 d-flex">
                                                
                                            <label for="nr_adulti" class="col-form-label mb-0 mr-2">Nr. pasageri:*</label>
                                            
                                            <div class="col-lg-6 px-0 d-flex align-self-center">  
                                                <button type="button" class="btn m-0 p-0"
                                                    v-on:click="nr_adulti -= 1;getPretTotal()"
                                                    >
                                                    <i class="far fa-minus-square bg-danger text-white fa-2x"></i>
                                                </button>  
                                                <script type="application/javascript"> 
                                                    nrAdultiVechi={!! json_encode(old('nr_adulti', '0'), JSON_NUMERIC_CHECK) !!}
                                                </script>                                    
                                                <input 
                                                    type="text" 
                                                    class="form-control form-control-sm {{ $errors->has('nr_adulti') ? 'is-invalid' : '' }}" 
                                                    name="nr_adulti"
                                                    v-model="nr_adulti" 
                                                    value="{{ old('nr_adulti') }}"
                                                    required
                                                    readonly>
                                                <button type="button" class="btn m-0 p-0" 
                                                    v-on:click="nr_adulti += 1;getPretTotal()">
                                                    <i class="far fa-plus-square bg-success text-white fa-2x">
                                                    </i>
                                                </button>  
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 justify-content-end m-0 d-flex">
                                            <label for="pret_total" class="col-form-label mb-0 mr-2">Preț total:</label>
                                            <div class="px-0 d-flex" style="width:100px">
                                                <input 
                                                    type="text" 
                                                    class="form-control form-control-sm {{ $errors->has('pret_total') ? 'is-invalid' : '' }}" 
                                                    name="pret_total"
                                                    v-model="pret_total" 
                                                    value="{{ old('pret_total') }}"
                                                    required
                                                    disabled>
                                                <label id="" class="col-form-label pl-1 align-bottom">
                                                    Euro
                                                </label>
                                            </div>
                                        </div>   
                                        <div class="form-group col-lg-12 justify-content-end m-0">  
                                                <script type="application/javascript"> 
                                                    numeVechi={!! json_encode(old('pasageri.nume', [])) !!}
                                                </script>  
                                                @php
                                                    $nr_pasager = 1;
                                                @endphp   
                                            <div v-for="index in nr_adulti" :key="index">
                                                @php
                                                    $nr_pasager = $nr_pasager + 1;
                                                @endphp
                                                <div class="form-row">
                                                    <div class="col-lg-2">
                                                        <input type="text" class="form-control" name="pasageri[nume][]" v-model="nume[index-1]"><br/
                                                        {{-- value="{{ old('pasageri[nume][1]') }}" --}}
                                                        >
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <input type="text" class="form-control" name="pasageri[buletin][]" v-model="buletin[index]"><br/>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        {{ $nr_pasager }}
                                                        @{{ index }}
                                                        {{ old('pasageri.nume.1') }}
                                                    </div>

                                                @php
                                                    $nr_pasager = $nr_pasager + 1;
                                                @endphp
                                                </div>
                                            </div>     
                                        </div>      
                                                        @php
                                                            // dd(old('pasageri.nume'))
                                                        @endphp              
                                        {{-- <div class="form-group col-lg-12 mb-2 justify-content-center"> 
                                            <label for="pasageri" class="mb-0">Pasageri(numele si seria de buletin pentru fiecare pasager):*</label>
                                            <textarea class="form-control {{ $errors->has('pasageri') ? 'is-invalid' : '' }}" 
                                                name="pasageri" id="pasageri" rows="2">{{ old('pasageri') }}</textarea>
                                        </div>  --}}
                                    </div>  
                                    <div v-else class="form-row mb-4 px-2 py-3 d-flex justify-content-center align-items-center border rounded"
                                        style="background-color:lightseagreen; color:white"
                                    >                       
                                        <div class="form-group col-lg-12 mb-0 d-flex"> 
                                            <label for="bagaje_kg" class="col-form-label mb-0 mr-2">Cantitate:* </label>
                                            <div class="px-0" style="width:100px">
                                                <input 
                                                    type="text" 
                                                    class="form-control form-control-sm {{ $errors->has('bagaje_kg') ? 'is-invalid' : '' }}" 
                                                    name="bagaje_kg"
                                                    placeholder="Ex: 2.5" 
                                                    value="{{ old('bagaje_kg') }}"
                                                >
                                            </div>
                                            <label id="" class="col-form-label pl-1 align-bottom">
                                                Kg
                                            </label>
                                        </div>                             
                                        <div class="form-group col-lg-12 mb-0 justify-content-center"> 
                                            <label for="bagaje_descriere" class="mb-0">Descriere bagaj:*</label>
                                            <textarea class="form-control {{ $errors->has('bagaje_descriere') ? 'is-invalid' : '' }}" 
                                                name="bagaje_descriere" id="bagaje_descriere" rows="2">{{ old('bagaje_descriere') }}</textarea>
                                        </div> 
                                    </div>
                                    <div class="form-row mb-4 px-2 py-2 justify-content-between align-items-center border rounded"
                                        style="background-color:lightseagreen; color:white"
                                    >                                    
                                        <div class="form-group col-lg-4">  
                                            <label for="nume" class="mb-0">Nume și prenume Client:*</label>                                      
                                            <input 
                                                type="text" 
                                                class="form-control form-control-sm {{ $errors->has('nume') ? 'is-invalid' : '' }}" 
                                                name="nume" 
                                                placeholder="" 
                                                value="{{ old('nume') }}"
                                                required> 
                                        </div>                                   
                                        <div class="form-group col-lg-4">   
                                            <label for="nume" class="mb-0">Telefon:*</label>                                      
                                            <input 
                                                type="text" 
                                                class="form-control form-control-sm {{ $errors->has('nume') ? 'is-invalid' : '' }}" 
                                                name="telefon" 
                                                placeholder="" 
                                                value="{{ old('telefon') }}"
                                                required> 
                                        </div>                                
                                        <div class="form-group col-lg-4">  
                                            <label for="nume" class="mb-0">Email:</label>                                        
                                            <input 
                                                type="text" 
                                                class="form-control form-control-sm {{ $errors->has('email') ? 'is-invalid' : '' }}" 
                                                name="email" 
                                                placeholder="" 
                                                value="{{ old('email') }}"
                                                required> 
                                        </div>                                  
                                        <div class="form-group col-lg-12 mb-1 justify-content-center"> 
                                            <label for="observatii" class="mb-0">Observații:</label>
                                            <textarea class="form-control {{ $errors->has('observatii') ? 'is-invalid' : '' }}" 
                                                name="observatii" id="observatii" rows="2">{{ old('observatii') }}</textarea>
                                        </div> 
                                    </div>                              
                                    <div class="form-row mb-4 px-2 pt-2 d-flex justify-content-between align-items-center border rounded" 
                                        style="background-color:lightseagreen; color:white"
                                    >
                                        <div class="form-group col-lg-12 mb-2 d-flex justify-content-center border-bottom">
                                                <h5 class="mb-1">Date pentru facturare:</h5>
                                        </div>
                                        <div class="form-group col-lg-12 mb-2">
                                                <span>*Completați aceste câmpuri doar dacă doriți factură.</h5>
                                        </div>
                                        <div class="form-group col-lg-3 mb-2">
                                            <label for="document_de_calatorie" class="mb-0">Document de călătorie:</label>                                        
                                            <input 
                                                type="text" 
                                                class="form-control form-control-sm {{ $errors->has('document_de_calatorie') ? 'is-invalid' : '' }}" 
                                                name="document_de_calatorie" 
                                                placeholder="" 
                                                value="{{ old('document_de_calatorie') }}"
                                                required> 
                                        </div>
                                        {{-- <div class="form-group col-lg-3 mb-2">
                                            <label for="expirare_document" class="mb-0"><small> Data expirării documentului:</small></label>
                                                <vue2-datepicker-buletin
                                                    data-veche="{{ old('expirare_document') == '' ? '' : old('expirare_document') }}"
                                                    nume-camp-db="expirare_document"
                                                    tip="date"
                                                    latime="150"
                                                    not-before="{{ \Carbon\Carbon::today() }}"
                                                ></vue2-datepicker-buletin>
                                        </div> --}}
                                        <div class="form-group col-lg-3 mb-2">
                                            <label for="serie_document" class="mb-0">Seria buletin / pașaport:</label>                                        
                                            <input 
                                                type="text" 
                                                class="form-control form-control-sm {{ $errors->has('serie_document') ? 'is-invalid' : '' }}" 
                                                name="serie_document" 
                                                placeholder="" 
                                                value="{{ old('serie_document') }}"
                                                required> 
                                        </div>
                                        <div class="form-group col-lg-3 mb-2">
                                            <label for="cnp" class="mb-0">Cnp:</label>                                        
                                            <input 
                                                type="text" 
                                                class="form-control form-control-sm {{ $errors->has('cnp') ? 'is-invalid' : '' }}" 
                                                name="cnp" 
                                                placeholder="" 
                                                value="{{ old('cnp') }}"
                                                required> 
                                        </div>
                                    </div>  
                                    <div class="form-row px-2 py-2 justify-content-between">                                  
                                        <div class="form-group col-lg-12 border-left border-info" style="border-width:5px !important">
                                            * IN PRETUL BILETULUI AVETI INCLUS 40 KG PTR BAGAJUL DVS , CE DEPASESTE SE TAXEAZA CU 1 EURO / KG !!!
                                        </div>
                                    </div>
                                    <div class="form-row px-2 py-2 justify-content-between">                                
                                        <div class="form-group col-lg-12 border-left border-warning" style="border-width:5px !important">
                                            <label for="" class="mr-4">Acord de confidențialitate:</label>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="acord_de_confidentialitate" value="1" required
                                                {{ old('acord_de_confidentialitate') == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="acord_de_confidentialitate">
                                                    Sunt de acord cu colectarea și prelucrarea datelor cu caracter personal - 
                                                    <a href="#" target="_blank">
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
                                                {{ old('termeni_si_conditii') == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="termeni_si_conditii">Sunt de acord cu condițiile de transport persoane</label> 
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="form-row mb-1 px-2 justify-content-center align-items-center">                                    
                                        <div class="col-lg-8 d-flex justify-content-center">  
                                            <button type="submit" class="btn btn-lg btn-warning btn-block mr-4">Verifică Rezervarea</button>  
                                        </div>
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
   
@endsection