<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{csrf_token()}}">
	<meta name="description" content="">
	<meta name="keyword" content="">
	<title>Confirme sua senha</title>
	<link rel="shortcut icon" href="{{ asset('adm/img/favicon.png') }}" />

	<link href="{{ asset('adm/plugins/coreui/coreui.min.css') }}" rel="stylesheet">
	<link href="{{ asset('adm/plugins/fontawesome/css/all.min.css') }}" rel="stylesheet">
	<link href="{{ asset('adm/plugins/notyf/notyf.min.css') }}" rel="stylesheet">
	<link href="{{ asset('adm/css/main.css') }}" rel="stylesheet">
</head>
<body>
	<section id="login">
        <div class='fail-message' style="display: none;"></div>
        <div class='success-message' style="display: none;"></div>
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-8">
					<div class="card-group">
						<div class="card p-4">
							<div class="card-body" id="rowLogin">
                                <h2>Confirme sua senha</h2>
                                <p class="text-muted" style="margin-bottom: 0.5rem">Preencha o campo abaixo:</p>
                                @if ($errors->any())
                                    <div class="fail-message">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form url="{{ route('password.confirm') }}" method="post" confirmPage="true" id="passConfirm" class="login-form">
                                    @csrf
                                    <div class="input-group mb-4 column">
                                        <div class="input-group-prepend">
												<span class="input-group-text">
													<i class="fas fa-lock"></i>
												</span>
                                        </div>
                                        <input id="password" type="password" class="form-control required"
                                               name="password" placeholder="Senha">
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <button class="btn btn-primary px-4" type="submit">Entrar</button>
                                        </div>
                                        <div class="col-6 text-right">
                                            <a href="/adm/forgot-password">
                                                <button name="forgotPass" class="btn btn-link px-0" type="button">
                                                    Esqueceu sua senha?
                                                </button>
                                            </a>
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
    <script src="{{ asset('adm/js/auth.js') }}"></script>
	<script src="{{ asset('adm/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
</body>
</html>
