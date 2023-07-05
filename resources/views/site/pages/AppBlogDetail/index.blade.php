@extends('site.layout.app')
@section('content')
<section id="blog">
	<h1>{{$post->title}}</h1>
    <img src={{ resize('userfiles/noticias/' . $post->image, 500, 500, 'resize') }}>
</section>
@endsection
