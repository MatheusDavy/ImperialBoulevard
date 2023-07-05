<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="description" content="">
    <meta name="keyword" content="">
    <title>{{ isset($title) && $title ? $title . ' - ' : '' }}{{ $main_title }}</title>
    <link rel="shortcut icon" href="{{ asset('adm/img/favicon.png') }}" />

    <link async href="{{ asset('adm/plugins/notyf/notyf.min.css') }}" rel="stylesheet">
    <link async href="{{ asset('site/css/vendor.css') }}" rel="stylesheet">
    <link async href="{{ asset('adm/css/main.css') }}" rel="stylesheet">
    <link async href="{{ asset(mix('site/css/plugins/cropper.css')) }}" rel="stylesheet">

    <!-- NEW THEME -->
    {{-- <link href="{{ asset('adm/plugins/new-theme/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" /> --}}
    <link async href="{{ asset('adm/plugins/new-theme/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link async href="{{ asset('adm/plugins/new-theme/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link async href="{{ asset('adm/plugins/new-theme/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link async href="{{ asset('adm/plugins/new-theme/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link async href="{{ asset('adm/plugins/new-theme/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link async href="{{ asset('adm/plugins/select2/select2.css') }}" rel="stylesheet">
    @yield('css')
</head>

<body data-sidebar="dark">
    <div class="app-body">
        <div class='fail-message' style="display: none;"></div>
        <div class='success-message' style="display: none;"></div>
        <input type="text" hidden id="baseLogin" value="{{route('login')}}">
        <input type="text" hidden id="baseDash" value="{{route('adm.dash')}}">
        <input type="text" hidden id="baseTwoFactor" value="{{route('two-factor.confirm')}}">
        @if (isset($hasToken) && !$hasToken)
        <div class='fail-message'>
            <form url="{{route('user.create.token')}}" method="post" id="createToken">
                @csrf
                <p>Usuário sem Token de Autenticação! <br>Clique em criar Token para ter acesso ao painel.</p>
                <button class="dropdown-item btn" type="submit" style="background-color: #fff">
                    <i class="fas fa-key"></i> Criar Token
                </button>
            </form>
        </div>

        @endif
        @include('adm.layout.sidebar')
        <div class="main-content">
            <div class="page-content">
                @yield('content')
            </div>
        </div>
    </div>

    <div id="layout-wrapper">
        @include('adm.layout.header')
    </div>
    @include('adm.layout.footer')


    <!-- Right Sidebar -->
    <div class="right-bar">
        <div data-simplebar class="h-100">
            <div class="rightbar-title d-flex align-items-center px-3 py-4">

                <h5 class="m-0 me-2">Settings</h5>

                <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                    <i class="mdi mdi-close noti-icon"></i>
                </a>
            </div>

            <!-- Settings -->
            <hr class="mt-0" />
            <h6 class="text-center mb-0">Choose Layouts</h6>

            <div class="p-4">
                <div class="mb-2">
                    <img src="{{ asset('adm/plugins/new-theme/images/layouts/layout-1.jpg') }}" class="img-fluid img-thumbnail" alt="layout-1">
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" checked>
                    <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                </div>

                <div class="mb-2">
                    <img src="{{ asset('adm/plugins/new-theme/images/layouts/layout-2.jpg') }}" class="img-fluid img-thumbnail" alt="layout-2">
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox">
                    <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                </div>

                <div class="mb-2">
                    <img src="{{ asset('adm/plugins/new-theme/images/layouts/layout-3.jpg') }}" class="img-fluid img-thumbnail" alt="layout-3">
                </div>
                <div class="form-check form-switch mb-5">
                    <input class="form-check-input theme-choice" type="checkbox">
                    <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                </div>


            </div>

        </div> <!-- end slimscroll-menu-->
    </div>
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    @yield('js')
    <!-- NEW THEME -->
    <script src="{{ asset('adm/plugins/new-theme/libs/jquery/jquery.min.js') }}"></script>
    <script defer src="https://cdn.ckeditor.com/ckeditor5/37.1.0/super-build/ckeditor.js"></script>
    <script defer src="{{ asset('adm/plugins/new-theme/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script defer src="{{ asset('adm/plugins/new-theme/libs/metismenu/metisMenu.min.js') }}"></script>
    <script defer src="{{ asset('adm/plugins/new-theme/libs/simplebar/simplebar.min.js') }}"></script>
    <script defer src="{{ asset('adm/plugins/new-theme/libs/node-waves/waves.min.js') }}"></script>
    {{-- <script src="{{ asset('adm/plugins/new-theme/libs/apexcharts/apexcharts.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('adm/plugins/new-theme/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('adm/plugins/new-theme/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}"></script> --}}
    <script defer src="{{ asset('adm/plugins/new-theme/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script defer src="{{ asset('adm/plugins/new-theme/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script defer src="{{ asset('adm/plugins/new-theme/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script defer src="{{ asset('adm/plugins/new-theme/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    {{-- <script src="{{ asset('adm/plugins/new-theme/js/pages/dashboard.init.js') }}"></script> --}}
    <script defer src="{{ asset('adm/plugins/new-theme/js/app.js') }}"></script>
    {{-- <script src="{{ asset('adm/plugins/new-theme/libs/tinymce/tinymce.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('adm/plugins/new-theme/js/pages/form-editor.init.js') }}"></script> --}}


    <!-- PLUGINS -->
    {{-- <script defer src="{{ asset('adm/plugins/bootstrap/popper.min.js') }}"></script> --}}
    <script defer src="{{ asset('adm/plugins/notyf/notyf.min.js') }}"></script>
    <script defer src="{{ asset('adm/js/main.js') }}"></script>
    <script async src="{{ asset('adm/js/auth.js') }}"></script>
    <script defer src="{{ asset('adm/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script defer src="{{ asset('adm/plugins/datepicker/datepicker.js') }}"></script>
    <script defer src="{{ asset('adm/plugins/jscolor/jscolor.js') }}"></script>
    <script async src="{{ asset('site/js/pages/cropper.js') }}"></script>
    <script async src="{{ asset('site/js/pages/jquery-cropper.js') }}"></script>
    <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDW3K7whEjNxFrR1u8RTv9HYbkg_f9b630&libraries=places" type="text/javascript"></script>
    <script async src="{{ asset('adm/js/inputs.js') }}"></script>
    <script defer src="{{ asset('adm/plugins/select2/select2.js') }}"></script>
    <script async src="{{asset('adm/js/backup.js')}}"></script>
    <script defer src="{{asset('adm/js/ckEditorHandler.js')}}"></script>
    @yield('js')
</body>

</html>
