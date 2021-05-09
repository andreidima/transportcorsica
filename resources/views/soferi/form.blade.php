@csrf

<div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px" id="app1">
    <div class="form-group col-lg-12 px-2 mb-0">
        <div class="form-row">
            <div class="form-group col-lg-12">
                <label for="nume" class="mb-0 pl-3">Nume șofer*:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nume') ? 'is-invalid' : '' }}"
                    name="nume"
                    placeholder=""
                    value="{{ old('nume', $sofer->nume) }}"
                    required>
            </div>
            <div class="form-group col-lg-4 text-center">
                <label for="analize_medicale" class="mb-0 mr-2">Analize medicale:</label>
                    <vue2-datepicker
                        data-veche="{{ old('analize_medicale', ($sofer->analize_medicale ?? '')) }}"
                        nume-camp-db="analize_medicale"
                        :latime="{ width: '125px' }"
                        tip="date"
                        value-type="YYYY-MM-DD"
                        format="DD-MM-YYYY"
                    ></vue2-datepicker>
            </div>
            <div class="form-group col-lg-4 text-center">
                <label for="permis" class="mb-0 mr-2">Permis:</label>
                    <vue2-datepicker
                        data-veche="{{ old('permis', ($sofer->permis ?? '')) }}"
                        nume-camp-db="permis"
                        :latime="{ width: '125px' }"
                        tip="date"
                        value-type="YYYY-MM-DD"
                        format="DD-MM-YYYY"
                    ></vue2-datepicker>
            </div>
            <div class="form-group col-lg-4 text-center">
                <label for="buletin" class="mb-0 mr-2">Buletin:</label>
                    <vue2-datepicker
                        data-veche="{{ old('buletin', ($sofer->buletin ?? '')) }}"
                        nume-camp-db="buletin"
                        :latime="{ width: '125px' }"
                        tip="date"
                        value-type="YYYY-MM-DD"
                        format="DD-MM-YYYY"
                    ></vue2-datepicker>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-lg-12">
                <label for="observatii" class="mb-0 pl-3">Observații:</label>
                <textarea class="form-control {{ $errors->has('observatii') ? 'is-invalid' : '' }}"
                    name="observatii"
                    rows="2"
                >{{ old('observatii', ($sofer->observatii ?? '')) }}</textarea>
            </div>
        </div>

        <div class="form-row py-2 justify-content-center">
            <div class="col-lg-8 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-sm mr-2 rounded-pill">{{ $buttonText }}</button>
                {{-- <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="{{ $sofer->path() }}">Renunță</a>  --}}
                <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="/soferi">Renunță</a>
            </div>
        </div>
    </div>
</div>
