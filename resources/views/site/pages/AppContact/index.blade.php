@extends('site.layout.app')
@section('content')
<section id="home">
	<p>Contato</p>
	<div class="contact-page">
        <form class="form-contact" id="contact-form" role="form" action={{route('site.contactForm')}} method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <input id="ct-name" type="text" autocomplete="off" placeholder="Name">
            <input id="ct-phone" type="text" autocomplete="off" placeholder="Telefone">
            <input id="ct-subject" type="text" autocomplete="off" placeholder="Assunto">
            <textarea id="ct-message" type="text" autocomplete="off" value="Mensagem"></textarea>
            <div class="box_email">
                <input id="ct-email" type="text" autocomplete="off" placeholder="Email">
                <button class="border border-dark" type="submit" id="btn-send">Submit</button>
            </div>
        </form>
    </div>

</section>
@endsection
@section('js')
<script src="{{ asset('site/js/pages/contactPage.js') }}"></script>
@endsection
