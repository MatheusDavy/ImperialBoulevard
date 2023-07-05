<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="description" content="">
    <meta name="keyword" content="">
    <title>{{ isset($recovery) ? 'Recuperar Senha' : 'Soprano' }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('adm/img/favicon.ico') }}"/>
    <link rel="icon" type="image/x-icon" href="{{ asset('adm/img/favicon.ico') }}"/>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('adm/img/favicon180.png') }}">

    <link href="{{ asset('adm/plugins/coreui/coreui.min.css') }}" rel="stylesheet">
    <link href="{{ asset('adm/plugins/fontawesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('adm/plugins/notyf/notyf.min.css') }}" rel="stylesheet">
    <link href="{{ asset('adm/plugins/slick/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('adm/css/main.css') }}" rel="stylesheet">
</head>
<body>

<section id="login">
    <div class="container">
        <div class="row justify-content-center" id="rowLogin">
            <div class="col-md-4">
                <div class="card-group">
                    <div class="card">
                        <div class="card-header ">
                            <h4 style="text-align: center;">Atenção!</h4>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title" style="text-align: center">É preciso cadastrar uma senha forte.</h5>
                            <div class="card-text">
                                <ul class="list-group">
                                    <li class="list-group-item">No mínimo 8 caracteres;</li>
                                    <li class="list-group-item">Pelo menos uma letra maiúscula;</li>
                                    <li class="list-group-item">Pelo menos um número (0-9);</li>
                                    <li class="list-group-item">Pelo menos um caractere especial (!@#$%^&*).</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card-group">
                    <div class="card p-4">
                        <div class="card-body">
                                <h2>Recuperar senha</h2>
                                <p class="text-muted">Entre com a nova senha</p>
                                @if ($errors->any())
                                    <div class="fail-message">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form action="{{route('password.update')}}" method="POST"
                                      class="login-form">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="token" value="{{ request()->route('token') }}">
                                    <div class="input-group mb-3 column">
                                        <div class="input-group-prepend">
												<span class="input-group-text">
													<i class="fas fa-envelope"></i>
												</span>
                                        </div>
                                        <input id="email" type="text" class="form-control required" name="email" value=""
                                               placeholder="E-mail" autofocus>
                                    </div>
                                    <div class="input-group mb-4 column">
                                        <div class="input-group-prepend">
												<span class="input-group-text">
													<i class="fas fa-lock"></i>
												</span>
                                        </div>
                                        <input id="password" type="password" class="form-control required"
                                               name="password" placeholder="Senha">
                                    </div>
                                    <div class="input-group mb-4 column">
                                        <div class="input-group-prepend">
												<span class="input-group-text">
													<i class="fas fa-lock"></i>
												</span>
                                        </div>
                                        <input id="password_confirmation" type="password" class="form-control required"
                                               name="password_confirmation" placeholder="Confirmar Senha">
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <button class="btn btn-primary px-4" type="submit">Enviar</button>
                                        </div>
                                    </div>
                                </form>
                        </div>
                    </div>
                    <div class="card text-white bg-primary py-5 d-md-down-none login-img"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{ asset('adm/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('adm/plugins/coreui/coreui.min.js') }}"></script>
<script src="{{ asset('adm/plugins/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ asset('adm/plugins/notyf/notyf.min.js') }}"></script>
<script src="{{ asset('adm/plugins/slick/slick.js') }}"></script>
<script src="{{ asset('adm/js/main.js') }}"></script>
<script src="{{ asset('adm/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
</body>