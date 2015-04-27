$('.call').click(function() {
				if($(this).parents('.appRow').find('.phone').hasClass('hidden')) {
					$(this).parents('.appRow').find('.phone').removeClass('hidden');
				} else {
					$(this).parents('.appRow').find('.phone').addClass('hidden');
				}
			});
			$('.print').click(function() {
				if($('#print').hasClass('hidden')) {
					$('#print').removeClass('hidden');
				} else {
					$('#print').addClass('hidden');
				}
			});
			$('.change').click(function() {
				if($(this).parents('.appRow').find('.changediv').hasClass('hidden')) {
					$(this).parents('.appRow').find('.changediv').removeClass('hidden');
					$(this).addClass('hidden');
				}
			});
			$('.showed:checked').parents('.appRow').css("background-color", "blue");
			$('.late:checked').parents('.appRow').css("background-color", "yellow");
			$('.noshow:checked').parents('.appRow').css("background-color", "pink");
			$('.canceled:checked').parents('.appRow').css("background-color", "red");