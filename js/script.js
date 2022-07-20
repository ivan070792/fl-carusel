(function ($) {
	$(document).ready(function () {
		$('.fl_switch_stock').click(function(){
			$(this).addClass('active');
			$('.fl_switch_new').removeClass('active');
			$('#fl_carusel_stock').fadeTo(500, 1).css('display','flex');
			$('#fl_carusel_new').fadeTo(500, 0).css('display','none');
			$('#fl_nav_stock').css('display','block');
			$('#fl_nav_new').css('display','none');
			
		});
		$('.fl_switch_new').click(function(){
			$(this).addClass('active');
			$('.fl_switch_stock').removeClass('active');
			$('#fl_carusel_stock').fadeTo(500, 0).css('display','none');
			$('#fl_carusel_new').fadeTo(500, 1).css('display','flex');
			$('#fl_nav_stock').css('display','none');
			$('#fl_nav_new').css('display','block');
			
		});
		
		$('#fl_nav_new > .fl_nav_right, #fl_nav_stock > .fl_nav_right').click(function(){
			clearInterval(window.fl_time);
			nextSlide();
			window.fl_time = setInterval(function(){
				nextSlide();
			},5000)
		});
		$('#fl_nav_new > .fl_nav_left, #fl_nav_stock > .fl_nav_left').click(function(){
			clearInterval(window.fl_time);
			prevSlide();
			window.fl_time = setInterval(function(){
				nextSlide();
			},5000)
		});
		
		let fl_stock_object = $('#fl_carusel_stock');
		let fl_new_object = $('#fl_carusel_new');
		fl_time = '';
		let fl_card_width = $('.fl_carusel_card_item').outerWidth();
		
		function nextSlide(){
				fl_new_object.animate({'margin-left':'-=321'},1000,function(){
					fl_new_object.css({'margin-left':'7px'});
					$('#fl_carusel_new').append($('#fl_carusel_new').children().first().clone());
					$('#fl_carusel_new').children().first().remove();
				});

				fl_stock_object.animate({'margin-left':'-=321'},1000,function(){
					fl_stock_object.css({'margin-left':'7px'});
					$('#fl_carusel_stock').append($('#fl_carusel_stock').children().first().clone());
					$('#fl_carusel_stock').children().first().remove();
				});
		}
		window.fl_time = setInterval(function(){
			nextSlide();
		},5000)

		function prevSlide(){
				fl_new_object.css({'margin-left':'-314px'});
				$('#fl_carusel_new').prepend($('#fl_carusel_new').children().last().clone());
			    fl_new_object.animate({'margin-left':'+=321'},1000,function(){
					fl_new_object.css({'margin-left':'7px'});
					$('#fl_carusel_new').children().last().remove();
				});
				fl_stock_object.css({'margin-left':'-314px'});
				$('#fl_carusel_stock').prepend($('#fl_carusel_stock').children().last().clone());
				fl_stock_object.animate({'margin-left':'+=321'},1000,function(){
					fl_stock_object.css({'margin-left':'7px'});
					$('#fl_carusel_stock').children().last().remove();
				});
		}
		
		
	})
	
})(jQuery);