@extends('site.layout.app')
@section('content')
<section id="page-offers">
    <div class="section_navigation" id="inicio">
        <div class="section_navigation--container">
            <nav class="box_nav" data-animation>
                <a href="{{route('site.home')}}">INÍCIO</a>
                <a href="#">OFERTAS PÚBLICAS</a>
            </nav>

            <h1 class="title" data-animation='right'>OFERTAS PÚBLICAS</h1>
        </div>
    </div>

    <div class="section_folders">
        <div class="section_folders--container">
            <div class="box_description" data-animation>
                <p>{!! $texto->description !!}</p>
            </div>

            <div class="box_folders">
                <h2 class="box_folders--title" data-animation='left'>ÚLTIMAS OFERTAS</h2>
                <div class='box_folders--grid' data-animation='left'>
                    @foreach ($lista as $card)
                    @if ($loop->iteration == 5)
                    @break
                    @endif
                    <a href={{assetJson([$card->folder, $card->file])}} download class='card'>
                        <svg xmlns="http://www.w3.org/2000/svg" width="57" height="50" viewBox="0 0 57 50" fill="none">
                            <path opacity="0.3" d="M7.125 50H49.875C53.8049 50 57 46.7969 57 42.8571V14.2857C57 10.346 53.8049 7.14286 49.875 7.14286H32.0625C30.9381 7.14286 29.8805 6.6183 29.2125 5.71429L27.075 2.85714C25.7279 1.06027 23.6127 0 21.375 0H7.125C3.19512 0 0 3.20312 0 7.14286V42.8571C0 46.7969 3.19512 50 7.125 50Z" fill="#F1F1F1" />
                        </svg>
                        {{$card->title}}
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="section_questions" data-appearBackToTop data-sequencial>
        <div class="section_questions--container">
            @foreach ($lista as $card)
            <div class="section_questions--card" data-sequencial-stagger="right">
                <button class="question button-questions">
                    <img src="{{ asset('site/img/Icons/arrow-down.svg') }}" alt="">
                    {{$card->title}}
                </button>
                <div class="response">
                    <a href={{assetJson([$card->folder, $card->file])}} download class="response--folder">
                        <img src="{{ asset('site/img/Icons/folder-download.svg') }}" alt="">
                        <span class="date">{{formatDateDiaMes($card->created)}}</span>
                    </a>
                    <p class="response--description">
                        {{$card->description}}
                    </p>
                </div>
            </div>
            @endforeach
        </div>

        @include('site.components.Fixed.back_to_top')
    </div>
</section>
@endsection

@section('js')
<script src="{{ asset('site/js/pages/page_offers.js') }}"></script>
@endsection