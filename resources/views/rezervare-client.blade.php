@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="shadow-lg bg-white" style="border-radius: 0px 0px 0px 0px;">
                <div class="text-center border border-danger p-0" style="border-radius: 0px 0px 0px 0px;"> 
                    <img src="{{ asset('images/logo.png') }}" class="" style="max-width:100%">
                </div>

                <div class="card-body text-center" 
                    style="
                        color:ivory; 
                        background-color:#E66800; 
                        border-radius: 0px 0px 40px 40px
                    "
                >
                    <div class="row pb-2">
                        <a href="/adauga-rezervare-pasul-1" class="text-white">
                            <div class="col-md-6">
                                    <h5 class="mb-0">România - Corsica</h5>
                                <i class="fas fa-bus-alt m-4" style="font-size: 12em;"></i>
                                <a class="btn btn-primary btn-lg" href="/adauga-rezervare-pasul-1" role="button" 
                                    style="border-radius: 40px; border: 5px solid white;">
                                    Rezervări bilete
                                </a>
                            </div>
                        </a>
                        <div class="col-md-6 border-left">
                            <h5 class="mb-0">România - Corsica</h5>
                            <i class="fas fa-box m-4" style="font-size: 12em;"></i>
                                <a class="btn btn-primary btn-lg" href="/adauga-colet-pasul-1" role="button" 
                                    style="border-radius: 40px; border: 5px solid white;">
                                    Rezervări colete
                                </a>
                        </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
