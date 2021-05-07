@csrf

<div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px" id="app1">
    <div class="form-group col-lg-12 px-2 mb-0">
        <div class="form-row">
            <div class="form-group col-lg-8">
                <label for="nume" class="mb-0 pl-3">Nume mașină:*</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nume') ? 'is-invalid' : '' }}"
                    name="nume"
                    placeholder=""
                    value="{{ old('nume', $masina->nume) }}"
                    required>
            </div>
            <div class="form-group col-lg-4">
                <label for="numar_auto" class="mb-0 pl-3">Număr auto:*</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('numar_auto') ? 'is-invalid' : '' }}"
                    name="numar_auto"
                    placeholder=""
                    value="{{ old('numar_auto', $masina->numar_auto ) }}"
                    required>
            </div>
            <div class="form-group col-lg-4 text-center">
                <label for="itp" class="mb-0 mr-2">ITP:*</label>
                    <script type="application/javascript">
                        asigurareRcaVeche={!! json_encode(old('itp', ($rezervare->itp ?? ''))) !!}
                    </script>
                    <vue2-datepicker
                        data-veche="{{ old('itp', ($masina->itp ?? '')) }}"
                        nume-camp-db="itp"
                        :latime="{ width: '125px' }"
                        tip="date"
                        value-type="YYYY-MM-DD"
                        format="DD-MM-YYYY"
                        not-before-date="{{ auth()->check() ? \Carbon\Carbon::today()->subYear() : \Carbon\Carbon::today() }}"
                    ></vue2-datepicker>
            </div>
            <div class="form-group col-lg-4 text-center">
                <label for="asigurare_rca" class="mb-0 mr-2">Asigurare RCA:*</label>
                    <script type="application/javascript">
                        asigurareRcaVeche={!! json_encode(old('asigurare_rca', ($rezervare->asigurare_rca ?? ''))) !!}
                    </script>
                    <vue2-datepicker
                        data-veche="{{ old('asigurare_rca', ($masina->asigurare_rca ?? '')) }}"
                        nume-camp-db="asigurare_rca"
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
                >{{ old('observatii', ($masina->observatii ?? '')) }}</textarea>
            </div>
        </div>

        <div class="form-row py-2 justify-content-center">
            <div class="col-lg-8 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-sm mr-2 rounded-pill">{{ $buttonText }}</button>
                {{-- <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="{{ $masina->path() }}">Renunță</a>  --}}
                <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="/clienti-neseriosi">Renunță</a>
            </div>
        </div>
    </div>
</div>
