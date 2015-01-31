jQuery(function($) {
	$('body').on('submit', '#feedback-form', function(e){
		var error=false,$this=$(this);
		$this.find('input').each(function(index, element) {
			if($(this).val()==''){
				error=true;
				$(this).closest('div').addClass('error');
			}else{
				$(this).closest('div').removeClass('error');
			}
		});

		if(!error){
			jQuery.ajax({
				'url': $this.attr('action'),
				'cache': false,
				'type': 'POST',
				'data':$this.serialize(),
				'success': function (html) {
					$.fancybox.close();
					$('#message_dialog .b-container').html(html);
					$.fancybox($('#message_dialog'),{
						maxWidth	: 300,
						maxHeight	: 100,
						fitToView	: false,
						//width		: '100%',
						//height		: '70%',
						autoSize	: false,
						closeClick	: false,
						openEffect	: 'elastic',
						closeEffect	: 'fade'
					});
					$('#feedback-form')[0].reset();
				},
			});
		}
		return false;
	});

	$(".feedback_open").fancybox({
		maxWidth	: 800,
		maxHeight	: 380,
		fitToView	: false,
		width		: '100%',
		//height		: '70%',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'elastic',
		closeEffect	: 'elastic'
	});

	$('.b-catalog-swiper').each(function(){
		 var catalog = new Swiper('#'+$(this).attr('id')+' .swiper-container',{
			mode: 'vertical',
			onlyExternal: true,
			slidesPerView:'auto',
			watchActiveIndex: true,
			mousewheelControl: true
		 })
		 $('#'+$(this).attr('id')+' .arrow-up').on('click', function(e){
		   e.preventDefault()
		   catalog.swipePrev()
		 })
		 $('#'+$(this).attr('id')+' .arrow-down').on('click', function(e){
		   e.preventDefault()
		   catalog.swipeNext()
		 })
	});

	$('.b-gallery .b-container').each(function(){
		var GallerySlider = new Swiper('#'+$(this).attr('id')+' .swiper-container', {
			//pagination: '.b-gallery .pagination',
			loop: true,
			//paginationClickable: true,
			slidesPerView: 4,
			//autoplay: 2000
		})

		$('#'+$(this).attr('id')+' .arrow-left').on('click', function (e) {
			e.preventDefault()
			GallerySlider.swipePrev()
		})
		$('#'+$(this).attr('id')+' .arrow-right').on('click', function (e) {
			e.preventDefault()
			GallerySlider.swipeNext()
		})
	});

	$('.about-parents').on('click', '.b-button-about',function (e) {
		e.preventDefault();
		var item;


		$(this).closest('.about-parent').hide();

		var percent=100/$('.about-parents .about-parent:visible').length-0.09;

		$('.about-parents .about-parent:visible').each(function(){
			$(this).css('width',percent+'%');
		});

		if(!$('.about-parent:visible').length){
			$('.about-parents').hide();
			$('.about-parents-div').css('padding-bottom', '1px');
		}
		item=$('.about-parent-div[data-parent="'+$(this).attr('data-parent')+'"]').clone();
		$('.about-parent-div[data-parent="'+$(this).attr('data-parent')+'"]').remove();
		$('.about-parents-div').append(item);
		item.fadeIn();

		$('html, body').animate({
			scrollTop: $('.about-parent-div[data-parent="'+$(this).attr('data-parent')+'"]').offset().top-60
		}, 500);
	});

	$('body').on('click', '.b-about-view:not(.b-search-view) .b-link a',function (e) {
		e.preventDefault();

		$('.b-about-view:not(.b-search-view) .about-img').css({
			'width': $('.b-about-view:not(.b-search-view) .about-img').attr('data-width'),
			'opacity': 1
		});
		$('.b-about-view:not(.b-search-view) .b-link a').show();
		$('.b-about-view:not(.b-search-view) .b-text>p').show();
		$('.b-about-view:not(.b-search-view) .b-text>div').hide();

		$(this).closest('.b-about-view').find('.about-img').animate({
			width: "0%",
			opacity: 0,
		  }, 1000 );
		$(this).hide();
		$(this).closest('.b-about-view').find('.b-text>p').hide();
		$(this).closest('.b-about-view').find('.b-text>div').fadeToggle(1000);


	});
});