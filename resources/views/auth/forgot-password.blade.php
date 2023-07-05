<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="description" content="">
    <meta name="keyword" content="">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('adm/img/favicon.ico') }}" />
    <link rel="icon" type="image/x-icon" href="{{ asset('adm/img/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('adm/img/favicon180.png') }}">

    <link href="{{ asset('adm/plugins/notyf/notyf.min.css') }}" rel="stylesheet">
    <link href="{{ asset('adm/plugins/new-theme/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('adm/plugins/new-theme/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('adm/plugins/new-theme/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
</head>

<body class="auth-body-bg">
    <div>
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

                                            <h4 class="font-size-18 mt-4">Redefinir senha</h4>
                                        </div>

                                        <div class="p-2 mt-5">
                                            <div class="alert alert-success mb-4" role="alert">
                                                Digite seu e-mail e as instruções serão enviadas para você!
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
                                            <form class="" action="{{route('password.request')}}" method="POST">
                                                {{ csrf_field() }}
                                                <div class="auth-form-group-custom mb-4">
                                                    <i class="ri-mail-line auti-custom-input-icon"></i>
                                                    <label for="useremail">Email</label>
                                                    <input type="email" class="form-control" id="email" name="email" placeholder="Digite o e-mail">
                                                </div>

                                                <div class="mt-4 text-center">
                                                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Enviar</button>
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
    </div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('adm/plugins/new-theme/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adm/plugins/new-theme/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adm/plugins/new-theme/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('adm/plugins/new-theme/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('adm/plugins/new-theme/libs/node-waves/waves.min.js') }}"></script>

    <script src="{{ asset('adm/new-theme/js/app.js') }}"></script>
</body>

</html>
