@csrf

<div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px">
    <div class="form-group col-lg-12 px-2 mb-0">
        <div class="form-row mb-0 px-2 py-2">                                    
            <div class="form-group col-lg-12 mb-0">  
                <label for="nume" class="mb-0 pl-3">Nume Client:*</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nume') ? 'is-invalid' : '' }}" 
                    name="nume" 
                    placeholder="" 
                    value="{{ old('nume') == '' ? $clienti->nume : old('nume') }}"
                    required> 
            </div>           
        </div>
        <div class="form-row px-2 py-2 mb-0">    
            <div class="form-group col-lg-6 mb-0">  
                <label for="nr_ord_reg_com" class="mb-0 pl-3">Nr. ord. reg. com.:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nr_ord_reg_com') ? 'is-invalid' : '' }}" 
                    name="nr_ord_reg_com" 
                    placeholder="" 
                    value="{{ old('nr_ord_reg_com') == '' ? $clienti->nr_ord_reg_com : old('nr_ord_reg_com') }}"
                    required> 
            </div>                               
            <div class="form-group col-lg-6 mb-0">  
                <label for="cui" class="mb-0 pl-3">Cui:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('cui') ? 'is-invalid' : '' }}" 
                    name="cui" 
                    placeholder="" 
                    value="{{ old('cui') == '' ? $clienti->cui : old('cui') }}"
                    required> 
            </div> 
        </div>
        <div class="form-row px-2 py-2 mb-0">                              
            <div class="form-group col-lg-12 mb-0">  
                <label for="adresa" class="mb-0 pl-3">Adresa:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('adresa') ? 'is-invalid' : '' }}" 
                    name="adresa" 
                    placeholder="" 
                    value="{{ old('adresa') == '' ? $clienti->adresa : old('adresa') }}"
                    required> 
            </div>  
        </div>
        <div class="form-row px-2 py-2 mb-4">                          
            <div class="form-group col-lg-6 mb-0">  
                <label for="iban" class="mb-0 pl-3">Iban:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('iban') ? 'is-invalid' : '' }}" 
                    name="iban" 
                    placeholder="" 
                    value="{{ old('iban') == '' ? $clienti->iban : old('iban') }}"
                    required> 
            </div>                            
            <div class="form-group col-lg-6 mb-0">  
                <label for="banca" class="mb-0 pl-3">Banca:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('banca') ? 'is-invalid' : '' }}" 
                    name="banca" 
                    placeholder="" 
                    value="{{ old('banca') == '' ? $clienti->banca : old('banca') }}"
                    required> 
            </div>                           
            {{-- <div class="form-group col-lg-2">  
                <label for="contract_nr" class="mb-0 pl-3">Nr. contract:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('contract_nr') ? 'is-invalid' : '' }}" 
                    name="contract_nr" 
                    placeholder="" 
                    value="{{ old('contract_nr') == '' ? $clienti->contract_nr : old('contract_nr') }}"
                    required> 
            </div>                           
            <div class="form-group col-lg-2">  
                <label for="contract_data" class="mb-0">Data contractului:</label> 
                <vue2-datepicker-buletin
                    data-veche="{{ old('contract_data') == '' ? $clienti->contract_data : old('contract_data') }}"
                    nume-camp-db="contract_data"
                    tip="date"
                    latime="180"
                    not-before="{{ \Carbon\Carbon::today() }}"
                ></vue2-datepicker-buletin>
            </div>                            
            <div class="form-group col-lg-2">  
                <label for="data_incepere" class="mb-0">Data intrării în vigoare:</label> 
                <vue2-datepicker-buletin
                    data-veche="{{ old('data_incepere') == '' ? $clienti->data_incepere : old('data_incepere') }}"
                    nume-camp-db="data_incepere"
                    tip="date"
                    latime="180"
                    not-before="{{ \Carbon\Carbon::today() }}"
                ></vue2-datepicker-buletin>
            </div>         --}}
        </div>      

        <div class="form-row mb-0 px-2 py-2">                         
            <div class="form-group col-lg-6 mb-0">  
                <label for="reprezentant" class="mb-0 pl-3">Reprezentant legal:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('reprezentant') ? 'is-invalid' : '' }}" 
                    name="reprezentant" 
                    placeholder="" 
                    value="{{ old('reprezentant') == '' ? $clienti->reprezentant : old('reprezentant') }}"
                    required> 
            </div>                      
            <div class="form-group col-lg-6 mb-0">  
                <label for="reprezentant_functie" class="mb-0 pl-3">Funcție:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('reprezentant_functie') ? 'is-invalid' : '' }}" 
                    name="reprezentant_functie" 
                    placeholder="" 
                    value="{{ old('reprezentant_functie') == '' ? $clienti->reprezentant_functie : old('reprezentant_functie') }}"
                    required> 
            </div>
        </div>
        <div class="form-row px-2 pt-2 mb-0">
            <div class="form-group col-lg-6 mb-0">  
                <label for="telefon" class="mb-0 pl-3">Telefon:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('telefon') ? 'is-invalid' : '' }}" 
                    name="telefon" 
                    placeholder="Ex: 07xyzzzzzz" 
                    value="{{ old('telefon') == '' ? $clienti->telefon : old('telefon') }}"
                    required> 
            </div>
            <div class="form-group col-lg-6 mb-0">  
                <label for="email" class="mb-0 pl-3">Email:</label>
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('email') ? 'is-invalid' : '' }}" 
                    name="email" 
                    placeholder="" 
                    value="{{ old('email') == '' ? $clienti->email : old('email') }}"
                    aria-describedby="emailHelp"
                    required> 
                <small id="emailHelp" class="form-text text-muted pl-3">Ex: email1@xxx.com, email2@yyy.ro, etc</small>
            </div>
        </div>
        <div class="form-row px-2 pb-2 mb-3">
            <div class="form-group col-lg-12 mb-0">  
                <label for="site_web" class="mb-0 pl-3">Site web:</label>                                      
                <input 
                    type="text" 
                    class="form-control form-control-sm rounded-pill {{ $errors->has('site_web') ? 'is-invalid' : '' }}" 
                    name="site_web" 
                    placeholder="" 
                    value="{{ old('site_web') == '' ? $clienti->site_web : old('site_web') }}"
                    required> 
            </div>
        </div>
        
                                
        <div class="form-row mb-3 px-2 justify-content-center">                                    
            <div class="col-lg-8 d-flex justify-content-center">  
                <button type="submit" class="btn btn-primary btn-sm mr-2 rounded-pill">{{ $buttonText }}</button> 
                {{-- <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="{{ $clienti->path() }}">Renunță</a>  --}}
                <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="/clienti">Renunță</a> 
            </div>
        </div>
    </div>
</div>