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
                <p>{!! $texto->description !!}</p>
            </div>

            <div class="box_folders">
                <h2 class="box_folders--title">ÚLTIMAS OFERTAS</h2>
                <div class='box_folders--grid'>
                    @foreach ($lista as $card)
                    @if ($loop->iteration == 5)
                        @break
                    @endif
                        <a href={{assetJson([$card->folder, $card->file])}} download class='card'>
                            <img src="{{ asset('site/img/Icons/folder.svg') }}" alt="Folder">
                            {{$card->title}}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="section_questions" data-appearBackToTop>
        <div class="section_questions--container">
            @foreach ($lista as $card)
            <div class="section_questions--card">
                <button class="question button-questions">
                    <img src="{{ asset('site/img/Icons/arrow-down.svg') }}" alt="">
                    {{$card->title}}
                </button>
                <div class="response">
                    <a href={{assetJson([$card->folder, $card->file])}} download class="response--folder">
                        <img src="{{ asset('site/img/Icons/folder-download.svg') }}" alt="">
                        <span class="date">{{$card->created}}</span>
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