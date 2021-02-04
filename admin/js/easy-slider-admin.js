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

	handleAddSlideButtons();
	handleDeleteButtons();

	function handleAddSlideButtons(){
		$('.btn-add-slide').click(function() {
			const index = +$('#widgets-counter').val();
			const content = $('.witness-code').html().replaceAll('index',index);
			$( '.slides-list' ).append( content );
			$('#widgets-counter').val(index + 1)
			handleDeleteButtons();
			handleReOrderSlides()
		});
	}

	function handleDeleteButtons(){
		$( '.btn-delete-slide' ).unbind().click(function() {
			$('.form-group.'+$(this).attr('data-target')).remove();
			handleReOrderSlides()
		});
	}

	function handleReOrderSlides(){
		$( '.slides-list .form-group' ).each(function( index ) {
			$(this).find('label').html(index + 1);
		});
	}

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
				button.parent().find('.content-slide').html('<img width="300" src="' + attachment.url + '">');
				button.parent().find('.hidden-slide').val(attachment.id);
			}).open();

	});

});


