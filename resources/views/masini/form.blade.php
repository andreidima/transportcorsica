@csrf

<div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px" id="app1">
    <div class="form-group col-lg-12 px-2 mb-0">
        <div class="form-row">
            <div class="form-group col-lg-8">
                <label for="nume" class="mb-0 pl-3">Nume mașină*:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nume') ? 'is-invalid' : '' }}"
                    name="nume"
                    placeholder=""
                    value="{{ old('nume', $masina->nume) }}"
                    required>
            </div>
            <div class="form-group col-lg-4">
                <label for="numar_auto" class="mb-0 pl-3">Număr auto:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('numar_auto') ? 'is-invalid' : '' }}"
                    name="numar_auto"
                    placeholder=""
                    value="{{ old('numar_auto', $masina->numar_auto ) }}"
                    required>
            </div>
            <div class="form-group col-lg-4 text-center">
                <label for="itp" class="mb-0 mr-2">ITP:</label>
                    <vue2-datepicker
                        data-veche="{{ old('itp', ($masina->itp ?? '')) }}"
                        nume-camp-db="itp"
                        :latime="{ width: '125px' }"
                        tip="date"
                        value-type="YYYY-MM-DD"
                        format="DD-MM-YYYY"
                    ></vue2-datepicker>
            </div>
            <div class="form-group col-lg-4 text-center">
                <label for="asigurare_rca" class="mb-0 mr-2">Asigurare RCA:</label>
                    <vue2-datepicker
                        data-veche="{{ old('asigurare_rca', ($masina->asigurare_rca ?? '')) }}"
                        nume-camp-db="asigurare_rca"
                        :latime="{ width: '125px' }"
                        tip="date"
                        value-type="YYYY-MM-DD"
                        format="DD-MM-YYYY"
                    ></vue2-datepicker>
            </div>
            <div class="form-group col-lg-4 text-center">
                <label for="asigurari_persoane_colete" class="mb-0 mr-2">Asigurări pers/colete:</label>
                    <vue2-datepicker
                        data-veche="{{ old('asigurari_persoane_colete', ($masina->asigurari_persoane_colete ?? '')) }}"
                        nume-camp-db="asigurari_persoane_colete"
                        :latime="{ width: '125px' }"
                        tip="date"
                        value-type="YYYY-MM-DD"
                        format="DD-MM-YYYY"
                    ></vue2-datepicker>
            </div>
            <div class="form-group col-lg-4 text-center">
                <label for="licenta" class="mb-0 mr-2">Licență:</label>
                    <vue2-datepicker
                        data-veche="{{ old('licenta', ($masina->licenta ?? '')) }}"
                        nume-camp-db="licenta"
                        :latime="{ width: '125px' }"
                        tip="date"
                        value-type="YYYY-MM-DD"
                        format="DD-MM-YYYY"
                    ></vue2-datepicker>
            </div>
            <div class="form-group col-lg-4 text-center">
                <label for="clasificare" class="mb-0 mr-2">Clasificare:</label>
                    <vue2-datepicker
                        data-veche="{{ old('clasificare', ($masina->clasificare ?? '')) }}"
                        nume-camp-db="clasificare"
                        :latime="{ width: '125px' }"
                        tip="date"
                        value-type="YYYY-MM-DD"
                        format="DD-MM-YYYY"
                    ></vue2-datepicker>
            </div>
            <div class="form-group col-lg-4 text-center">
                <label for="verificare_tahograf" class="mb-0 mr-2">Verificare tahograf:</label>
                    <vue2-datepicker
                        data-veche="{{ old('verificare_tahograf', ($masina->verificare_tahograf ?? '')) }}"
                        nume-camp-db="verificare_tahograf"
                        :latime="{ width: '125px' }"
                        tip="date"
                        value-type="YYYY-MM-DD"
                        format="DD-MM-YYYY"
                    ></vue2-datepicker>
            </div>
            <div class="form-group col-lg-4 text-center">
                <label for="rovinieta_romania" class="mb-0 mr-2">Rovinieta România:</label>
                    <vue2-datepicker
                        data-veche="{{ old('rovinieta_romania', ($masina->rovinieta_romania ?? '')) }}"
                        nume-camp-db="rovinieta_romania"
                        :latime="{ width: '125px' }"
                        tip="date"
                        value-type="YYYY-MM-DD"
                        format="DD-MM-YYYY"
                    ></vue2-datepicker>
            </div>
            <div class="form-group col-lg-4 text-center">
                <label for="rovinieta_ungaria" class="mb-0 mr-2">Rovinieta Ungaria:</label>
                    <vue2-datepicker
                        data-veche="{{ old('rovinieta_ungaria', ($masina->rovinieta_ungaria ?? '')) }}"
                        nume-camp-db="rovinieta_ungaria"
                        :latime="{ width: '125px' }"
                        tip="date"
                        value-type="YYYY-MM-DD"
                        format="DD-MM-YYYY"
                    ></vue2-datepicker>
            </div>
            <div class="form-group col-lg-4 text-center">
                <label for="rovinieta_slovenia" class="mb-0 mr-2">Rovinieta Slovenia:</label>
                    <vue2-datepicker
                        data-veche="{{ old('rovinieta_slovenia', ($masina->rovinieta_slovenia ?? '')) }}"
                        nume-camp-db="rovinieta_slovenia"
                        :latime="{ width: '125px' }"
                        tip="date"
                        value-type="YYYY-MM-DD"
                        format="DD-MM-YYYY"
                    ></vue2-datepicker>
            </div>
            <div class="form-group col-lg-4 text-center">
                <label for="revizie" class="mb-0 mr-2">Revizie:</label>
                    <vue2-datepicker
                        data-veche="{{ old('revizie', ($masina->revizie ?? '')) }}"
                        nume-camp-db="revizie"
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
                >{{ old('observatii', ($masina->observatii ?? '')) }}</textarea>
            </div>
        </div>

        <div class="form-row py-2 justify-content-center">
            <div class="col-lg-8 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-sm mr-2 rounded-pill">{{ $buttonText }}</button>
                {{-- <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="{{ $masina->path() }}">Renunță</a>  --}}
                <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="/masini">Renunță</a>
            </div>
        </div>
    </div>
</div>
