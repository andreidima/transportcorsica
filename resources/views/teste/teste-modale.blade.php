<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ public_path('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ public_path('css/app.css') }}" rel="stylesheet">
    <!-- Font Awesome links -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</head>
<body style="height:100%">
 <div class="justify-content-center align-items-center" style="height:100%">
    @include ('errors')
                                        <div style="" class="">
                                            <a
                                                href="#"
                                                data-toggle="modal"
                                                data-target="#testeModala"
                                                title="Teste Modala"
                                                >
                                                <h1>Testeaza Modala 1</h1>
                                            </a>
                                        </div>

                                        <div style="" class="">
                                            <a
                                                href="#"
                                                data-toggle="modal"
                                                data-target="#testeModala2"
                                                title="Teste Modala"
                                                >
                                                <h1>Testeaza Modala 2</h1>
                                            </a>
                                        </div>

                                                {{-- Modal pentru butonul de stergere --}}
                                                <div class="modal fade text-dark" id="testeModala" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                                                    {{-- data-backdrop="false" --}}
                                                >
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header bg-danger">
                                                            <h5 class="modal-title text-white" id="exampleModalLabel">Testeaza Modala 1</b></h5>
                                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" style="text-align:left;">
                                                            Apasa butonul
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Nu</button>

                                                            <form method="POST" action="teste-modale-apasa-buton">
                                                                {{-- @method('DELETE')   --}}
                                                                @csrf
                                                                <button
                                                                    type="submit"
                                                                    class="btn btn-danger"
                                                                    >
                                                                    Da
                                                                </button>
                                                            </form>

                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>

    </div>
                                                {{-- Modal pentru butonul de stergere --}}
                                                <div class="modal fade text-dark" id="testeModala2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                                                    {{-- data-backdrop="false" --}}
                                                >
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header bg-danger">
                                                            <h5 class="modal-title text-white" id="exampleModalLabel">Testeaza Modala 2</b></h5>
                                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" style="text-align:left;">
                                                            Apasa butonul
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Nu</button>

                                                            <form method="POST" action="teste-modale-apasa-buton-2">
                                                                {{-- @method('DELETE')   --}}
                                                                @csrf
                                                                <button
                                                                    type="submit"
                                                                    class="btn btn-danger"
                                                                    >
                                                                    Da
                                                                </button>
                                                            </form>

                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
</body>
</html>
