//= '../libs/optimaX/optimaX.min.js'
//= '../libs/slick/slick.min.js'
//= '../libs/jQueryUI/jquery-ui.min.js'
//= '../libs/jQueryUI/jquery-ui-touch-punch.js'
//= '../libs/selectric/jquery.selectric.js'
//= '../libs/selectric/jquery.selectric.placeholder.js'
//= '../libs/sticky-kit/sticky-kit.min.js'

$(document).ready(function() {

	/* changing rating star color */
	$(".rating__star__item").click(function() {
		$(this).addClass('active');
		$(this).prevAll('.rating__star__item').addClass('active');
		$(this).nextAll('.rating__star__item').removeClass('active');
	});

	/* stepper */
	var stepper = function () {
		var stepperNumber,
		minusButton;

		return {

			allSteppers: $( '.input-stepper' ),

			/*check to see if the input is at '0'...*/
			checkStepperNumber: function ( thisStepper ) {
				stepperInput = $( thisStepper ).find( 'input' );
				stepperNumber = stepperInput.val();
				decrementButton = $( thisStepper ).find( 'button.minus' );

				if ( stepperNumber === '1' || stepperNumber <= 1 ) {
					/*if so, disable the minus button. */
					decrementButton.prop( 'disabled', true );
					stepperInput.val( 1 );
				} else {
					/*if number is positive, enable the minus button*/
					decrementButton.prop( 'disabled', false );
				}

			},

			init: function () {
				stepper.allSteppers.each( function ( index, element ) {
					var thisStepperInput = $( element ).find( 'input' );
					var thisMinusButton = $( element ).find( 'button.minus' );

					if ( thisStepperInput.val() === '1' || thisStepperInput.val() <= 1 ) {
						thisMinusButton.prop( 'disabled', true );
						thisStepperInput.val( 1 );
					} else {
						/*if number is positive, enable the minus button*/
						thisMinusButton.prop( 'disabled', false );
					}
				});
			}

		}
	}();

	/*on button.plus click ...*/
	$( '.input-stepper button.plus' ).on( 'click', function ( e ) {
		thisStepper = $( e.target ).closest( '.input-stepper' );
		stepperInput = thisStepper.find( 'input' );

		/*check the input value*/
		stepperNumber = stepperInput.val();

		/*increment the input value*/
		stepperNumber++;
		stepperInput.val( stepperNumber );

		/*then check the stepper number*/
		stepper.checkStepperNumber( thisStepper );
	});

	/*on button.minus click ...*/
	$( '.input-stepper button.minus' ).on( 'click', function ( e ) {
		thisStepper = $( e.target ).closest( '.input-stepper' );
		stepperInput = thisStepper.find( 'input' );

		/*check the input value*/
		stepperNumber = stepperInput.val();

		/*decrement the input value*/
		stepperNumber--;
		stepperInput.val( stepperNumber );

		/*then check the stepper number*/
		stepper.checkStepperNumber( thisStepper );
	});

	/*on input field blur ...*/
	$( '.input-stepper input' ).on( 'blur', function ( e ) {
		thisStepper = $( e.target ).closest( '.input-stepper' );
		/*check the stepper number*/
		stepper.checkStepperNumber( thisStepper );
	});

	/*check the stepper number on load*/
	if ( $( '.input-stepper' ).length ) {
		stepper.init();
	}

	/* password show toggle */
	$('.password-show').mousedown(function() {
		$(this).siblings('input').attr('type', 'text')
	});
	$('.password-show').mouseup(function() {
		$(this).siblings('input').attr('type', 'password')
	});

	/* hiding banner on product page */
	$('.product__added__remove').click(function() {
		$('.product__added').slideUp()
	})

	/* tabs on product page */
	$('.product__details__tab').click(function(){
		$('.product__details__block').hide();
		var i = $(this).index();
		$('.product__details__block').eq(i).show();
		$('.product__details__tab').removeClass('active');
		$(this).addClass('active');
	});

	/* product page photo slider */
	$('.product__main__slider_for').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		asNavFor: $('.product__main__slider_nav')
	});
	$('.product__main__slider_nav').slick({
		slidesToShow: 5,
		slidesToScroll: 1,
		asNavFor: $('.product__main__slider_for'),
		arrows: false,
		focusOnSelect: true,
		// centerMode: true,
	});

	$('.filter__toggler').click(function() {
		$('.filter').slideToggle();
		$(this).toggleClass('active')
	})

	$(window).resize(function() {
		if ($(window).width() >= 992 ) {
			$('.filter').show()
		}
	})

	/* custom select */
	$(function() {
		$('select').selectric();
	});

	/* subcategory toggle in filter block */
	$('.filter__item__title .accordeon__button').click(function() {
		$(this).parent().siblings('.accordeon__content').slideToggle();
	})
	
	/*.mobile control buttons */
	$('.control__item').click(function() {
		$('html').addClass('fixed')
	})
	$(document).click(function (e){
		var div = $(".control__item");
		if (!div.is(e.target) && div.has(e.target).length === 0) {
			$('html').removeClass('fixed');
		}
	});

	/* mobile search */
	$('.search__mobile-btn').click(function() {
		$('.search_mobile').slideToggle()
	})

	/* mobile menu */
	$('.menu-button').click(function() {
		$('.menu').slideToggle()
	})

	/* price range slider */
	$( function() {
		$( "#price-range" ).slider({
			range: true,
			min: 1000,
			max: 800000,
			values: [ 1000, 800000 ],
			step: 1000,
			animate: true,
			slide: function( event, ui ) {
				$( "#price-min" ).val( ui.values[0]);
				$( "#price-max" ).val( ui.values[1]);
			}
		});
		$( "#price-min" ).val( $( "#price-range" ).slider( "values", 0 ) );
		$( "#price-max" ).val( $( "#price-range" ).slider( "values", 1 ) );
	} );
	$("#price-min").change(function() {
		$("#price-range").slider("values", 0, $(this).val());
	});
	$("#price-max").change(function() {
		$("#price-range").slider("values", 1, $(this).val());
	});

	$('.accordeon__button').click(function() {
		$(this).toggleClass('active')
	})
	
	/* auto hiding header */
	var header = $(".header");
	var scrollPrev = 0 // prev scroll value
	
	$(window).scroll(function() {
		var scrolled = $(window).scrollTop(); // scroll height in px
		var firstScrollUp = false; // scroll up start parameter
		var firstScrollDown = false; // scroll down start parameter
		
		if ( scrolled > 0 ) {
			if ( scrolled > scrollPrev ) {
				firstScrollUp = false;
				if ( scrolled < header.height() + header.offset().top ) {
					if ( firstScrollDown === false ) {
						var topPosition = header.offset().top;
						header.css({
							"top": topPosition + "px"
						});
						firstScrollDown = true;
					}
					header.css({
						"position": "absolute"
					});
				} else {
					header.css({
						"position": "fixed",
						"top": "-" + header.height() + "px"
					});
				}
			} else {
				firstScrollDown = false;
				if ( scrolled > header.offset().top ) {
					if ( firstScrollUp === false ) {
						var topPosition = header.offset().top;
						header.css({
							"top": topPosition + "px"
						});
						firstScrollUp = true;
					}
					header.css({
						"position": "absolute"
					});
				} else {
					header.removeAttr("style");
				}
			}
			scrollPrev = scrolled;
		}	
	});			
});

$(window).on("load resize", function() {
	if($(window).width() < 992){
		$('.product__sidebar_mobile').append($('.product__sidebar'));
	} else {
		$('.product__sidebar_desktop').append($('.product__sidebar'));
	}

	if( $(window).width() >= 992 ) {
		$('.filter__accordeon').stick_in_parent();
	} else {
		$('.filter__accordeon').trigger("sticky_kit:detach")

	}
})