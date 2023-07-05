@extends('site.layout.app')
@section('content')
<section id="home">
	<p>Home</p>
	<p><b>Exemplo resize</b> <i class="fas fa-arrow-down"></i></p>
    <img class="images--zoom" src="{{ resize('temp/naruto.jpg', 300, 300) }}">
	<input type="text" id='ct-phone' placeholder="Telefone">
	<input type="text" id='ct-cpf_cnpf' placeholder="CPF OU CNPJ">
	@include('site/components/newsletter')
</section>
@endsection

@section('js')
<script src="{{ asset('site/js/pages/page_home.js') }}"></script>
@endsection
