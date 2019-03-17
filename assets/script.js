var $ = jQuery.noConflict();

$(document).ready(function() {

	// for every moment homepage slider
    if($('.slick')){
      $('.slick').slick({
      arrows: true,
      dots: true,
      infinite: true,
      speed: 500,
      autoplay: true
    });
    }

    //single item page gallery
	$('.popup-gallery').magnificPopup({
		delegate: 'a',
		type: 'image',
		tLoading: 'Loading image #%curr%...',
		mainClass: 'mfp-img-mobile',
		gallery: {
			enabled: true,
			navigateByImgClick: true,
			preload: [0,1] // Will preload 0 - before current, and 1 after the current image
		},
		image: {
			tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
		}
	});

	//toggle shopping cart
	$(".my-cart").click(function(){
		$(".cart-display").slideToggle(150);
	});

	if( $(".cart-display .textwidget").text().length == 9 ) {
		$(".cart-display .textwidget").text('Your shopping cart is empty.');
	}


    
});

