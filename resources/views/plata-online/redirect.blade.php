@php
    dd($paymentUrl, $EnvKey, $data);
@endphp

{{-- <meta http-equiv="refresh" content="5; URL={{ $paymentUrl }} "> --}}

{{-- <p>
    <form name="frmPaymentRedirect" method="post" action="' . $this->paymentUrl . ' ">
    <input type="hidden" name="env_key" value="' . $EnvKey . '"/>
    <input type="hidden" name="data" value="' . $data . '"/>
    <p>
        Vei redirectat catre pagina de plati securizata a mobilpay.ro
    </p>
    <p>
        Pentru a continua apasa <input type="image" src="images/mobilpay.gif" />
    </p>
    </form>
</p> --}}

<form name='fr' action='{{ $paymentUrl }}' method='POST'>
    <input type="hidden" name="env_key" value="{{ $EnvKey }}"/>
    <input type="hidden" name="data" value="{{ $data }}"/>
</form>
<script type='text/javascript'>
document.fr.submit();
</script>