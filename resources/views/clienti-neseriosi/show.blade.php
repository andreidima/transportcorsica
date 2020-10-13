@extends ('layouts.app')

@section('content')   
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                    <h6 class="ml-4 my-0" style="color:white"><i class="fas fa-building mr-1"></i>Clienți / {{ $clienti->nume }}</h6>
                </div>

                <div class="card-body py-2 border border-secondary" 
                    style="border-radius: 0px 0px 40px 40px;"
                    id="app1"
                >

            @if (session()->has('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif

                    <div class="table-responsive col-md-12 mx-auto">
                        <table class="table table-sm table-striped table-hover"
                                {{-- style="background-color:#008282" --}}
                        > 
                            <tr>
                                <td>
                                    Nume
                                </td>
                                <td>
                                    {{ $clienti->nume }}
                                </td>
                            </tr>
                            {{-- <tr>
                                <td>
                                    Nume scurt
                                </td>
                                <td>
                                    {{ $clienti->nume_scurt }}
                                </td>
                            </tr> --}}
                            <tr>
                                <td>
                                    Nr. ord. reg. com.
                                </td>
                                <td>
                                    {{ $clienti->nr_ord_reg_com }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Cui
                                </td>
                                <td>
                                    {{ $clienti->cui }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Adresa
                                </td>
                                <td>
                                    {{ $clienti->adresa }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Iban
                                </td>
                                <td>
                                    {{ $clienti->iban }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Banca
                                </td>
                                <td>
                                    {{ $clienti->banca }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Reprezentant
                                </td>
                                <td>
                                    {{ $clienti->reprezentant }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Functie
                                </td>
                                <td>
                                    {{ $clienti->reprezentant_functie }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Telefon
                                </td>
                                <td>
                                    {{ $clienti->telefon }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Email
                                </td>
                                <td>
                                    {{ $clienti->email }}
                                </td>
                            </tr>
                            {{-- <tr>
                                <td>
                                    Email DPO
                                </td>
                                <td>
                                    {{ $clienti->email_dpo }}
                                </td>
                            </tr> --}}
                            <tr>
                                <td>
                                    Site web
                                </td>
                                <td>
                                    {{ $clienti->site_web }}
                                </td>
                            </tr>
                        </table>
                    </div>
                                       
                    <div class="form-row mb-2 px-2">                                    
                        <div class="col-lg-12 d-flex justify-content-center">  
                            <a class="btn btn-primary btn-sm rounded-pill" href="/service/clienti">Pagină Clienți</a> 
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection