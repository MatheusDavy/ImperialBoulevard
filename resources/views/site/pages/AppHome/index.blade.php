@extends('site.layout.app')
@section('content')
<section id="page-home">
	<!-- Home Banner -->
	<div class="section_herobanner">
		<div class="section_herobanner--container">
			<div class="box_slider swiper heroBannerSlider">
				<div class="swiper-wrapper">
					<div class="swiper-slide box_slider--content">
						<img src="{{ asset('site/img/Home/Banner/roof.png') }}" alt="">
					</div>
					<div class="swiper-slide box_slider--content">
						<img src="{{ asset('site/img/Home/Banner/reception.png') }}" alt="">
					</div>
					<div class="swiper-slide box_slider--content">
						<img src="{{ asset('site/img/Home/Banner/meeting-room.png') }}" alt="">
					</div>
					<div class="swiper-slide box_slider--content">
						<img src="{{ asset('site/img/Home/Banner/coffee-space.png') }}" alt="">
					</div>
				</div>
			</div>

			<div class="box_text">
				<span class="box_text--text">CONHEÇA O</span>
				<div class="style style_one">

				</div>
				<img class="box_text--logo" src="{{ asset('site/img/Home/Banner/logo-text.png') }}" />
				<p class="box_text--description">
					UM SÁBIO INVESTIMENTO <br>
					<span>AGORA EM EVENTOS</span>
				</p>
				<a href="#" class="box_text--link" aria-label="Ir para a sessão de Saiba Mais">SAIBA MAIS</a>

				<a href="" class="box_text--locale">
					<img src="{{ asset('site/img/Icons/pinner.svg') }}" alt="">
					<span style="opacity: 0.6;">Vale dos Vinhedos</span>
				</a>
				<div class="style style_two"></div>

				<canvas class="section_herobanner--background"></canvas>
			</div>
		</div>
	</div>
	


</section>
@endsection

@section('js')
<script src="{{ asset('site/js/pages/page_home.js') }}"></script>
@endsection