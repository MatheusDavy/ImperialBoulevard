@extends('site.layout.app')
@section('content')
<section id="page-offers">
    <div class="section_navigation" id="inicio">
        <div class="section_navigation--container">
            <nav class="box_list">
                <a href="{{route('site.home')}}">INÍCIO</a>
                <a href="#">OFERTAS PÚBLICAS</a>
            </nav>

            <h1 class="title">OFERTAS PÚBLICAS</h1>
        </div>
    </div>

    <div class="section_folders">
        <div class="section_folders--container">
            <div class="box_description">
                <p>Aqui você tem acesso a todas as informações para tomar a sua decisão com segurança. Tudo de acordo com a legislação, antes e depois da sua compra.</p>
            </div>

            <div class="box_folders">
                <h2 class="box_folders--title">ÚLTIMAS OFERTAS</h2>
                <div class='box_folders--grid'>
                    <a href='' download class='card'>
                        <img src="{{ asset('site/img/Icons/folder.svg') }}" alt="Folder">
                        B.(ANEXO I)
                        CONTRATO DE VENDA E COMPRA
                    </a>

                    <a href='' download class='card'>
                        <img src="{{ asset('site/img/Icons/folder.svg') }}" alt="Folder">
                        C.(ANEXO I)
                        QUADRO RESUMO
                    </a>

                    <a href='' download class='card'>
                        <img src="{{ asset('site/img/Icons/folder.svg') }}" alt="Folder">
                        C.(ANEXO I)
                        QUADRO RESUMO
                    </a>

                    <a href='' download class='card'>
                        <img src="{{ asset('site/img/Icons/folder.svg') }}" alt="Folder">
                        B.(ANEXO I)
                        CONTRATO DE VENDA E COMPRA
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="section_questions" data-appearBackToTop>
        <div class="section_questions--container">
            <div class="section_questions--card">
                <button class="question button-questions">
                    <img src="{{ asset('site/img/Icons/arrow-down.svg') }}" alt="">
                    A. (ANEXO I) CONTRATO DE LOCAÇÃO
                </button>
                <div class="response">
                    <a href="" download class="response--folder">
                        <img src="{{ asset('site/img/Icons/folder-download.svg') }}" alt="">

                        <span class="date">29/06/2023</span>
                    </a>

                    <p class="response--description">
                        Lorem Ipsum tem sido o texto fictício padrão da indústria desde os anos 1500, quando um impressor desconhecido pegou uma galera de tipos e os embaralhou para fazer um livro de espécimes de tipos.
                    </p>
                </div>
            </div>

            <div class="section_questions--card">
                <button class="question button-questions">
                    <img src="{{ asset('site/img/Icons/arrow-down.svg') }}" alt="">
                    A. (ANEXO I) CONTRATO DE LOCAÇÃO
                </button>
                <div class="response">
                    <a href="" download class="response--folder">
                        <img src="{{ asset('site/img/Icons/folder-download.svg') }}" alt="">

                        <span class="date">29/06/2023</span>
                    </a>

                    <p class="response--description">
                        Lorem Ipsum tem sido o texto fictício padrão da indústria desde os anos 1500, quando um impressor desconhecido pegou uma galera de tipos e os embaralhou para fazer um livro de espécimes de tipos.
                    </p>
                </div>
            </div>

            <div class="section_questions--card">
                <button class="question button-questions">
                    <img src="{{ asset('site/img/Icons/arrow-down.svg') }}" alt="">
                    B.(ANEXO I) CONTRATO DE VENDA E COMPRA
                </button>
                <div class="response">
                    <a href="" download class="response--folder">
                        <img src="{{ asset('site/img/Icons/folder-download.svg') }}" alt="">

                        <span class="date">29/06/2023</span>
                    </a>

                    <p class="response--description">
                        Lorem Ipsum tem sido o texto fictício padrão da indústria desde os anos 1500, quando um impressor desconhecido pegou uma galera de tipos e os embaralhou para fazer um livro de espécimes de tipos.
                    </p>
                </div>
            </div>

            <div class="section_questions--card">
                <button class="question button-questions">
                    <img src="{{ asset('site/img/Icons/arrow-down.svg') }}" alt="">
                    C. (ANEXO I) QUADRO RESUMO
                </button>
                <div class="response">
                    <a href="" download class="response--folder">
                        <img src="{{ asset('site/img/Icons/folder-download.svg') }}" alt="">

                        <span class="date">29/06/2023</span>
                    </a>

                    <p class="response--description">
                        Lorem Ipsum tem sido o texto fictício padrão da indústria desde os anos 1500, quando um impressor desconhecido pegou uma galera de tipos e os embaralhou para fazer um livro de espécimes de tipos.
                    </p>
                </div>
            </div>

            <div class="section_questions--card">
                <button class="question button-questions">
                    <img src="{{ asset('site/img/Icons/arrow-down.svg') }}" alt="">
                    A. (ANEXO I) CONTRATO DE LOCAÇÃO
                </button>
                <div class="response">
                    <a href="" download class="response--folder">
                        <img src="{{ asset('site/img/Icons/folder-download.svg') }}" alt="">

                        <span class="date">29/06/2023</span>
                    </a>

                    <p class="response--description">
                        Lorem Ipsum tem sido o texto fictício padrão da indústria desde os anos 1500, quando um impressor desconhecido pegou uma galera de tipos e os embaralhou para fazer um livro de espécimes de tipos.
                    </p>
                </div>
            </div>
        </div>

        @include('site.components.Fixed.back_to_top')
    </div>
</section>
@endsection

@section('js')
<script src="{{ asset('site/js/pages/page_offers.js') }}"></script>
@endsection