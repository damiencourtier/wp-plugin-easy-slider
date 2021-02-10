jQuery( document ).ready( function( $ ) {
	'use strict';

	$('.btn-delete-slider').click(function (event){
		var _this = $(this);
		$.post( params.ajaxurl, { action: 'delete_slider',slider_id: $(this).data('target'), delete_slider_nonce: $(this).data('nonce') }).done(function( obj ) {
			displayAlert(".display-alert",obj.response);
			_this.parent().parent().remove();
		});
	});

	function displayAlert(destination,msg){
		$(destination).prepend(msg);
		$('.alert').slideDown();
		setTimeout(function(){
			$('.alert').slideUp();
			setTimeout(function(){
				$('.alert').remove();
			}, 1000);
		}, 4000);
	}

	// form slider
	$( '#slider_form_ajax' ).submit( function( event ) {

		event.preventDefault(); // Prevent the default form submit.

		$('html, body').animate({ scrollTop: '0px'}, 1000);

		$.ajax({
			url:    params.ajaxurl, // domain/wp-admin/admin-ajax.php
			type:   'post',
			data:   $("#slider_form_ajax").serialize()
		})
			.done( function( obj ) { // response from the PHP action
				$('#slider_id').val(obj.slider_id);
				displayAlert(".display-alert",obj.response);
			});
	});


	$('.maxItems').change(function() {
		if($('.maxItems').val() > 1) {
			$('.content-itemWidth').slideDown();
		}else{
			$('.content-itemWidth').slideUp();
		}
	});

	$('.control-nav-thumbnail').change(function() {
		if( $(this).is(':checked')) {
			$('.maxItemsThumbnail').attr('disabled',false);

			$('.maxItems').val(1);
			$('.maxItems').attr('disabled',true);
			$('.content-itemWidth').slideUp();

			$('.randomize').attr('disabled',true);
			$('.control-nav').attr('disabled',true);
		}else{
			$('.maxItemsThumbnail').attr('disabled',true);

			$('.maxItems').attr('disabled',false);

			$('.randomize').attr('disabled',false);
			$('.control-nav').attr('disabled',false);
		}
	});




	handleAddSlideButtons();
	handleDeleteButtons();

	function handleAddSlideButtons(){
		$('.btn-add-slide').click(function() {
			const index = +$('#widgets-counter').val();
			const nbItem = +$('.slides-list .item').length;

			if(nbItem < 10) {
				const content = $('.witness-code').html().replaceAll('index', index);
				$('.slides-list').append(content);
				$('#widgets-counter').val(index + 1)
				handleDeleteButtons();
				handleReOrderSlides();
			}
		});
	}

	function handleDeleteButtons(){
		$( '.btn-delete-slide' ).unbind().click(function() {
			$('.row.'+$(this).attr('data-target')).remove();
			handleReOrderSlides()
		});
	}

	function handleReOrderSlides(){
		$( '.slides-list .item' ).each(function( index ) {
			$(this).find('label').html(index + 1);
		});
	}

	var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
	var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
		return new bootstrap.Popover(popoverTriggerEl)
	});

	$('.btn-copy').click(function() {
		var copyText = document.getElementById($(this).data('target'));
		copyText.select();
		copyText.setSelectionRange(0, 99999); /* For mobile devices */
		document.execCommand("copy");
		$('.toast').toast({delay:1000});
		$('.toast').toast('show');
	});

});

jQuery(function($){

	// on upload button click
	$('body').on( 'click', '.btn-media', function(e){

		e.preventDefault();

		var button = $(this),
			custom_uploader = wp.media({
				title: 'Insert image',
				library : {
					// uploadedTo : wp.media.view.settings.post.id, // attach to the current post?
					type : 'image'
				},
				button: {
					text: 'Use this image' // button label text
				},
				multiple: false
			}).on('select', function() { // it also has "open" and "close" events
				var attachment = custom_uploader.state().get('selection').first().toJSON();
				button.parent().parent().find('.content-slide').html('<img src="' + attachment.url + '">');
				button.parent().parent().find('.hidden-slide').val(attachment.id);
			}).open();

	});



});


