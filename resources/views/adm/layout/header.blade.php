<header id="page-topbar">
    {{-- URLS --}}
    <input type="text" id="qrUrl" hidden value="{{route('two-factor.qr-code')}}">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{route('adm.dash')}}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('adm/img/logo.png') }}" alt="logo-sm-dark" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('adm/img/logo.png') }}" alt="logo-dark" height="20">
                    </span>
                </a>

                <a href="{{route('adm.dash')}}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('adm/img/logo.png') }}" alt="logo-sm-light" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('adm/img/logo.png') }}" alt="logo-light" height="20">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="ri-menu-2-line align-middle"></i>
            </button>
        </div>

        <div class="d-flex">

            <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ri-search-line"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">

                    <form class="p-3">
                        <div class="mb-3 m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search ...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i class="ri-search-line"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <ul class="nav navbar-nav ml-auto mr-3 justify-content-center">
                @if ($gtm === false)
                <span class="btn btn-warning waves-effect waves-light">GTM Desativado</span>
                @elseif ($gtm === 'error')
                <span class="btn btn-danger waves-effect waves-light">Erro ao Buscar GTM</span>
                @elseif ($gtm === true)
                <span class="btn btn-success waves-effect waves-light">GTM Ativado</span>
                @endif
            </ul>

            {{-- <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                    <i class="ri-fullscreen-line"></i>
                </button>
            </div> --}}

            <div class="dropdown d-inline-block user-dropdown">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ resize(config('app.userfiles_path').'usuarios/'.$user->image,50,50,'crop') }}" alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1">{{ $user->name }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    @if (isset($hasToken) && $hasToken)
                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-change-password" href="">
                        <i class="ri-lock-unlock-line align-middle me-1"></i> Alterar senha
                    </a>
                    <a class="dropdown-item d-none" id="passConfirmButton" data-bs-toggle="modal" data-bs-target="#modal-confirm-password" href="">
                        <i class="fas fa-key"></i> Confirmar Senha
                    </a>
                    @if ($codes && $twoFactorActive)
                    <a class="dropdown-item" url={{route('two-factor.disable')}} id="twoFactorDelete">
                        <i class="fas fa-key"></i> Desativar Autenticação de dois fatores
                    </a>
                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-recovery-codes" href="">
                        <i class="fas fa-key"></i> Ver Códigos de recuperação
                    </a>
                    @else
                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-two-factor" href="">
                        <i class="fas fa-key"></i> Ativar Autenticação de dois fatores
                    </a>
                    @endif
                    @endif
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="{{ route('adm.logout') }}"><i class="ri-shut-down-line align-middle me-1 text-danger"></i> Sair</a>
                </div>
            </div>

            {{-- <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                    <i class="ri-settings-2-line"></i>
                </button>
            </div> --}}

        </div>
    </div>
</header>
@if (isset($hasToken) && $hasToken)
<div class="modal fade" id="modal-change-password" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Alterar Senha</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('adm.password') }}" class="common-form-send no-reset">
                {{ csrf_field() }}
                <div class="modal-body">
                    <p>Preencha os campos abaixo:</p>
                    <div class="input-group mb-4 column">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                        </div>
                        <input type="password" class="form-control required" name="password" placeholder="Senha">
                    </div>
                    <div class="input-group mb-4 column">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                        </div>
                        <input type="password" class="form-control required" name="confirm" placeholder="Confirmar">
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
<div class="modal fade" id="modal-confirm-password" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmar Senha</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form url="{{ route('password.confirm') }}" method="post" id="passConfirm">
                {{ csrf_field() }}
                <div class="modal-body">
                    <p>Preencha o campo abaixo:</p>
                    <div class="input-group mb-4 column">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                        </div>
                        <input type="password" class="form-control required" name="password" placeholder="Senha">
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
<div class="modal fade" id="modal-two-factor" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ativar Autenticação de dois Fatores</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form url="{{ route('two-factor.enable') }}" method="post" id="twoFactor">
                {{ csrf_field() }}
                <div class="modal-body row" id="factorBody">

                </div>
                <div class="modal-footer">
                    <div id="closeFactorButton" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</div>
                    <button type="submit" id="continueFactorButton" class="btn btn-primary">Continuar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@if ($codes && $twoFactorActive)
<div class="modal fade" id="modal-recovery-codes" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Códigos de recuperação</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="display:flex; justify-content: center;">
                <ul>
                    @foreach ($codes as $codes)
                    <li style="list-style-type: disclosure-closed;">{{$codes}}</li>
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer">
                <div id="closeFactorButton" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</div>
            </div>
        </div>
    </div>
</div>
@endif
@endif
@include('adm.components.loader')