@csrf

<div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px">
    <div class="form-group col-lg-12 px-2 mb-0">
        <div class="form-row">                                    
            <div class="form-group col-lg-6 ">  
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