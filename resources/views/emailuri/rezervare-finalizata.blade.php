@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            MRW Transport
        @endcomponent
    @endslot

{{-- Body --}}
{{-- # Bună, {{ $rezervare_tur->pasageri_relation_adulti->first()->nume ?? '' }}, --}}
# Bună ziua,
<br>
Vă trimitem atașat biletul rezervării.
<br><br>
Vă mulțumim că folosiți serviciile noastre.

{{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

{{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            Contact:
            <br>
            +40 761 329 420
            <br>
            office@transportcorsica.ro
            <br>
            <br>
            © {{ date('Y') }} MRW Transport
        @endcomponent
    @endslot
@endcomponent