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
                        <h1 class="mb-0" style="color:darkcyan">CHITANȚĂ</h1>
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
                                    <div class="col-lg-12 mb-5 h5">
                                        Chitanță pentru biletul pasagerilor: 
                                        @isset($rezervare->nr_adulti)
                                            @foreach ($rezervare->pasageri_relation as $pasager)
                                                {{ $pasager->nume }}{{ (!$loop->last) ? ', ' : '.'}}
                                            @endforeach
                                        @else
                                            Rezervare bagaj
                                        @endif
                                    </div>
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
                                    <div class="col-lg-12 d-flex justify-content-center">  
                                        <button type="submit" class="btn btn-lg btn-primary border border-white btn-block">EMITE CHITANȚA</button>  
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
