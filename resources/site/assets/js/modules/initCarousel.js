import slick from 'slick-carousel';

export default function initCarousel(){
	const carousel = document.querySelectorAll('[data-carousel]');
	if (carousel.length > 0) {
		carousel.forEach( (el) => {
			let show = $(el).data('show');
			let showsm = $(el).data('showsm');
			let showxs = $(el).data('showxs');
			let slide = $(el).data('slide');
			let arrows = $(el).data('arrows');
			let arrowsxs = $(el).data('arrowsxs');
			let dots = $(el).data('dots');
			let dotsxs = $(el).data('dotsxs');
			let center = $(el).data('center');
			let centerxs = $(el).data('centerxs');
			let centerPadding = $(el).data('centerPadding');
			let infinite = $(el).data('infinite');
			let speed = $(el).data('speed');
			let drag = $(el).data('drag');
			let autoplay = $(el).data('autoplay');
			let autoplaySpeed = $(el).data('autoplaySpeed');

			$(el).slick({
				slidesToShow: (show !== '') ? show : 1,
				slidesToScroll: (slide !== '') ? slide : 1,
				arrows: (arrows === false) ? arrows : true,
				dots: (dots === true) ? dots : false,
				centerMode: (center === true) ? center : false,
				centerPadding: (centerPadding !== '') ? centerPadding : '0px',
				infinite: (infinite === false) ? infinite : true,
				speed: (speed !== '') ? speed : 300,
				prevArrow: '<button class="slick-prev"><i class="fas fa-angle-left"></i></button>',
				nextArrow: '<button class="slick-next"><i class="fas fa-angle-right"></i></button>',
				draggable: (drag !== '') ? drag : true,
				autoplay: (autoplay !== '') ? autoplay : true,
				autoplaySpeed: (autoplaySpeed !== '') ? autoplaySpeed : 2000,
				responsive: [
				{
					breakpoint: 992,
					settings: {
						slidesToShow: (showsm !== '') ? showsm : 1
					}
				},
				{
					breakpoint: 768,
					settings: {
						slidesToShow: (showxs !== '') ? showxs : 1,
						dots: (dotsxs === true) ? dotsxs : false,
						arrows: (arrowsxs === true) ? arrowsxs : false,
						centerMode: (centerxs === true) ? centerxs : false,
					}
				}
				]
			});
		});
	}

	function btnArrow (next, prev, carousel) {
		$(next).click( () => carousel.slick('slickNext') );
		$(prev).click( () => carousel.slick('slickPrev') );
	}
	// btnArrow('.banner .slick-next', '.banner .slick-prev', '.banner [data-carousel]');
	// btnArrow('.blog .slick-next', '.blog .slick-prev', '.blog [data-carousel]');
}