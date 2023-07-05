@extends('site.layout.app')
@section('content')
    <section id="home">
        <p>Blog</p>
        <div class="container">
            <div class="row row-cols-1 row-cols-md-4">
                @foreach ($posts as $post)
				<div class="col pt-4 w-auto">
					<a href="{{route('site.blogDetalhe', $post->slug)}}" style="text-decoration: unset;">
                        <div class="card">
                            <img src="{{ resize('userfiles/noticias/' . $post->image, 300, 300) }}" class="card-img-top h-3"
                                alt="{{ imgAltJson($post->image) }}" title="{{ imgTitleJson($post->image) }}"
                                style="width: 50vh; height: 30vh; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $post->title }}</h5>
								<p class="card-text">{{ formatDate($post->date) }}</p>
                                <p class="card-text">{!! character_limiter($post->text, 130) !!}</p>
                            </div>
                        </div>
					</a>
				</div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@section('js')
    {{-- <script src="{{ asset('site/js/pages/home.js') }}"></script> --}}
@endsection
