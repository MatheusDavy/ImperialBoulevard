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
                            <h2>Autenticação de Dois Fatores</h2>
                            <p class="text-muted" id="textFields" style="margin-bottom: 0.5rem">Informe o código de acesso (QrCode)</p>
                            @if ($errors->any())
                                <div class="fail-message">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ trans($error, [], 'en') }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form id="factorChallenge-form" action="{{route('two-factor.login')}}" method="post" class="login-form">
                                @csrf
                                <div id="codeFields">
                                    <div class="input-group mb-4 column">
                                        <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-lock"></i>
                                                </span>
                                        </div>
                                        <input id="code" type="password" class="form-control required"
                                                name="code" placeholder="Código de acesso">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <button class="btn btn-link px-0" type="button" data-bs-toggle="modal" data-bs-target="#modal-forgot-code">
                                            Perdeu o código?
                                        </button>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button class="btn btn-primary px-4" type="submit">Entrar</button>
                                    </div>
                                </div>
                            </form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
    <div class="modal fade" id="modal-forgot-code" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Informe seu email</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form url="{{route('adm.forgotCode')}}" id="forgotCode" class="common-form-send no-reset">
                {{ csrf_field() }}
                <div class="modal-body">
                    <p>Informe seu email para enviarmos o código</p>
                    <div class="input-group mb-4 column">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control required" name="email" placeholder="Email">
                    </div>
                </div>
                    <div class="modal-footer">
                    <div class="btn btn-secondary" data-bs-dismiss="modal">Fechar</div>
                    <button class="btn btn-primary">Enviar</button>
                </div>
            </form>
          </div>
        </div>
      </div>
	<script src="{{ asset('adm/plugins/jquery/jquery.min.js') }}"></script>
	<script src="{{ asset('adm/plugins/coreui/coreui.min.js') }}"></script>
	<script src="{{ asset('adm/plugins/bootstrap/bootstrap.min.js') }}"></script>
	<script src="{{ asset('adm/plugins/notyf/notyf.min.js') }}"></script>
    <script src="{{ asset('adm/js/auth.js') }}"></script>
	<script src="{{ asset('adm/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
</body>
</html>
