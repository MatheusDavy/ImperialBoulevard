<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="description" content="">
    <meta name="keyword" content="">
    <title>{{ isset($recovery) ? 'Recuperar Senha' : 'Login' }}</title>
    <link rel="shortcut icon" href="{{ asset('adm/img/favicon.png') }}" />

    <link href="{{ asset('adm/plugins/new-theme/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('adm/plugins/new-theme/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('adm/plugins/new-theme/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('adm/plugins/notyf/notyf.min.css') }}" rel="stylesheet">
</head>

<body class="auth-body-bg">
    <input type="text" hidden id="twoFactorUrl" value="{{route('two-factor.login')}}">

    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-lg-4">
                <div class="authentication-page-content p-4 d-flex align-items-center min-vh-100">
                    <div class="w-100">
                        <div class="row justify-content-center">
                            <div class="col-lg-9">
                                <div>
                                    <div class="text-center">
                                        <div>
                                            <a href="index.html" class="">
                                                <img src="assets/images/logo-dark.png" alt="" height="20" class="auth-logo logo-dark mx-auto">
                                                <img src="assets/images/logo-light.png" alt="" height="20" class="auth-logo logo-light mx-auto">
                                            </a>
                                        </div>

                                        <h4 class="font-size-18 mt-4">Bem vindo!</h4>
                                        <p class="text-muted">Entre para continuar.</p>
                                    </div>


                                    @if ($errors->any())
                                    <div class="fail-message">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    <div class="p-2 mt-5">
                                        <form id="login-form" method="post" class="login-form">
                                            @csrf
                                            <div class="mb-3 auth-form-group-custom mb-4">
                                                <i class="ri-mail-fill auti-custom-input-icon"></i>
                                                <label for="username">E-mail</label>
                                                <input type="text" class="form-control" id="email" name="email" value="" placeholder="E-mail">
                                            </div>

                                            <div class="mb-3 auth-form-group-custom mb-4">
                                                <i class="ri-lock-2-line auti-custom-input-icon"></i>
                                                <label for="userpassword">Senha</label>
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Senha">
                                            </div>

                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customControlInline">
                                                <label class="form-check-label" for="customControlInline">Lembre-me</label>
                                            </div>

                                            <div class="mt-4 text-center">
                                                <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Entrar</button>
                                            </div>

                                            <div class="mt-4 text-center">
                                                <a href="{{route('password.request')}}" class="text-muted"><i class="mdi mdi-lock me-1"></i> Esqueceu sua senha?</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="authentication-bg">
                    <div class="bg-overlay"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('adm/plugins/new-theme/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adm/plugins/new-theme/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adm/plugins/new-theme/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('adm/plugins/new-theme/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('adm/plugins/new-theme/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('adm/plugins/notyf/notyf.min.js') }}"></script>
    <script src="{{ asset('adm/js/auth.js') }}"></script>
    <script src="{{ asset('adm/plugins/new-theme/js/app.js') }}"></script>
</body>

</html>
