@csrf

<div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px" id="app1">
    <div class="form-group col-lg-12 px-2 mb-0">
        <div class="form-row">
            <div class="form-group col-lg-12">
                <label for="adult" class="mb-0 pl-3">Adult*:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('adult') ? 'is-invalid' : '' }}"
                    name="adult"
                    placeholder=""
                    value="{{ old('adult', $tarif->adult) }}"
                    required>
            </div>
            <div class="form-group col-lg-12">
                <label for="copil" class="mb-0 pl-3">Copil*:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('copil') ? 'is-invalid' : '' }}"
                    name="copil"
                    placeholder=""
                    value="{{ old('copil', $tarif->copil) }}"
                    required>
            </div>
            <div class="form-group col-lg-12">
                <label for="adult_tur_retur" class="mb-0 pl-3">Adult tur retur*:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('adult_tur_retur') ? 'is-invalid' : '' }}"
                    name="adult_tur_retur"
                    placeholder=""
                    value="{{ old('adult_tur_retur', $tarif->adult_tur_retur) }}"
                    required>
            </div>
            <div class="form-group col-lg-12">
                <label for="copil_tur_retur" class="mb-0 pl-3">Copil tur retur*:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('copil_tur_retur') ? 'is-invalid' : '' }}"
                    name="copil_tur_retur"
                    placeholder=""
                    value="{{ old('copil_tur_retur', $tarif->copil_tur_retur) }}"
                    required>
            </div>
            <div class="form-group col-lg-12">
                <label for="colete_kg" class="mb-0 pl-3">Colete kg*:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('colete_kg') ? 'is-invalid' : '' }}"
                    name="colete_kg"
                    placeholder=""
                    value="{{ old('colete_kg', $tarif->colete_kg) }}"
                    required>
            </div>
            <div class="form-group col-lg-4 text-center">
                <label for="de_la_data" class="mb-0 mr-2">De la data:</label>
                    <vue2-datepicker
                        data-veche="{{ old('de_la_data', ($tarif->de_la_data ?? '')) }}"
                        nume-camp-db="de_la_data"
                        :latime="{ width: '125px' }"
                        tip="date"
                        value-type="YYYY-MM-DD"
                        format="DD-MM-YYYY"
                    ></vue2-datepicker>
            </div>
            <div class="form-group col-lg-4 text-center">
                <label for="pana_la_data" class="mb-0 mr-2">Până la data:</label>
                    <vue2-datepicker
                        data-veche="{{ old('pana_la_data', ($tarif->pana_la_data ?? '')) }}"
                        nume-camp-db="pana_la_data"
                        :latime="{ width: '125px' }"
                        tip="date"
                        value-type="YYYY-MM-DD"
                        format="DD-MM-YYYY"
                    ></vue2-datepicker>
            </div>
        </div>



        <div class="form-row py-2 justify-content-center">
            <div class="col-lg-8 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-sm mr-2 rounded-pill">{{ $buttonText }}</button>
                {{-- <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="{{ $sofer->path() }}">Renunță</a>  --}}
                <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="/tarife">Renunță</a>
            </div>
        </div>
    </div>
</div>
