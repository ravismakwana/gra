// import './clock';
// import './carousel';
import './menu';
import './woo';
// import './posts/loadmore';

// Styles
import '../sass/main.scss';

// Images
// import '../img/patterns/bg.jpeg';
// import '../img/patterns/c1-150x150.jpeg';
// import '../img/patterns/c2-150x150.jpeg';
// import '../img/patterns/c3-150x150.jpeg';
// import '../img/email.webp';
// import '../img/payment.webp';

import '../img/secure-with-macfee.webp';

jQuery(document).ready(function ( $ ) {
	/* Trust Pilot Review Slider */
	$('.review_slider').slick({
		infinite: true,
		slidesToShow: 2,
		slidesToScroll: 1,
		responsive: [
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
				},
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				},
			},
		],
	});

	$('.is-layout-flex').removeClass('is-layout-flex');

	// Function to get URL parameter by name
	function getUrlParameter(name) {
		name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
		var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
		var results = regex.exec(location.search);
		return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
	}

	// Use setTimeout to delay execution by 3 seconds
	setTimeout(function() {
			// Get the 'param' value from the URL
			var paramValue = getUrlParameter('productName');

			// Set the value of the input field
			$('#ff_2005_input_text').val(paramValue);
	}, 1000);
});
