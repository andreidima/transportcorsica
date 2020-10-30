@csrf

<div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px" id="app1">
    <div class="form-group col-lg-12 px-2 mb-0">
        <div class="form-row">                                    
            <div class="form-group col-lg-6">  
                <label for="nume" class="mb-0 pl-3">Nume Client:*</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nume') ? 'is-invalid' : '' }}" 
                    name="nume" 
                    placeholder="" 
                    value="{{ old('nume') == '' ? $client_neserios->nume : old('nume') }}"
                    required> 
            </div>   
            <div class="form-group col-lg-6 ">  
                <label for="telefon" class="mb-0 pl-3">Telefon:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('telefon') ? 'is-invalid' : '' }}" 
                    name="telefon" 
                    placeholder="" 
                    value="{{ old('telefon') == '' ? $client_neserios->telefon : old('telefon') }}"
                    required> 
            </div>                                  
            <div class="form-group col-lg-4 ">  
                <label for="oras_plecare" class="mb-0 pl-3">Oras plecare:*</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('oras_plecare') ? 'is-invalid' : '' }}" 
                    name="oras_plecare" 
                    placeholder="" 
                    value="{{ old('oras_plecare') == '' ? $client_neserios->oras_plecare : old('oras_plecare') }}"
                    required> 
            </div>                                   
            <div class="form-group col-lg-4">  
                <label for="oras_sosire" class="mb-0 pl-3">Oraș sosire:*</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('oras_sosire') ? 'is-invalid' : '' }}" 
                    name="oras_sosire" 
                    placeholder="" 
                    value="{{ old('oras_sosire') == '' ? $client_neserios->oras_sosire : old('oras_sosire') }}"
                    required> 
            </div>  
                    <script type="application/javascript"> 
                        dataVeche={!! json_encode(old('data_plecare', ($rezervare->data_plecare ?? ''))) !!} 
                    </script>
            <div class="form-group col-lg-4 text-center">
                <label for="data_plecare" class="mb-0 mr-2">Dată cursă:*</label> 
                    <vue2-datepicker
                        data-veche="{{ old('data_cursa', ($client_neserios->data_cursa ?? '')) }}"
                        nume-camp-db="data_cursa"
                        :latime="{ width: '125px' }"
                        tip="date"
                        value-type="YYYY-MM-DD"
                        format="DD-MM-YYYY"
                        not-before-date="{{ auth()->check() ? \Carbon\Carbon::today()->subYear() : \Carbon\Carbon::today() }}"
                    ></vue2-datepicker>
            </div>    
        </div>
        <div class="form-row">                              
            <div class="form-group col-lg-12">  
                <label for="observatii" class="mb-0 pl-3">Observații:</label>  
                <textarea class="form-control {{ $errors->has('observatii') ? 'is-invalid' : '' }}" 
                    name="observatii"
                    rows="2"
                >{{ old('observatii', ($client_neserios->observatii ?? '')) }}</textarea>
            </div>  
        </div>        
                                
        <div class="form-row py-2 justify-content-center">                                    
            <div class="col-lg-8 d-flex justify-content-center">  
                <button type="submit" class="btn btn-primary btn-sm mr-2 rounded-pill">{{ $buttonText }}</button> 
                {{-- <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="{{ $client_neserios->path() }}">Renunță</a>  --}}
                <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="/clienti-neseriosi">Renunță</a> 
            </div>
        </div>
    </div>
</div>