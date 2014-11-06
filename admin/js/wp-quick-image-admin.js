(function( $ ) {
	'use strict';

	/**
	 * All of the code for your Dashboard-specific JavaScript source
	 * should reside in this file.
	 *
	 * Note that this assume you're going to use jQuery, so it prepares
	 * the $ function reference to be used within the scope of this
	 * function.
	 *
	 * From here, you're able to define handlers for when the DOM is
	 * ready:
	 *
	 * $(function() {
	 * 
	 * });
	 *
	 * Or when the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and so on.
	 *
	 * Remember that ideally, we should not attach any more than a single DOM-ready or window-load handler
	 * for any particular page. Though other scripts in WordPress core, other plugins, and other themes may
	 * be doing this, we should try to minimize doing that in our own work.
	 */
	
	$(function() {
		$('#wp-quick-image-choose').click( function (e) {
			e.preventDefault();
			var uploader = wp.media( {
				title: 'Choose image...',
				button: {
					text: 'Post this image',
				},
				multiple: false
			});
			uploader.on( 'select', function () {
				var selection = uploader.state().get('selection');
				var attachments = [];
				var image = selection.pop();
				console.log(image);
				var mediumImage = image.attributes.sizes.medium;

				// Update selected ID
				var selectedId = $('#wp-quick-image-id');
				selectedId.val(image.attributes.id);

				// Check if a preview already exists - update or create as necessary.
				var preview = $('#wp-quick-image-preview img');
				if (preview.length) {
					preview.attr('src', mediumImage.url);
				} else {
					var imageTag = '<img src="' + mediumImage.url + '" title="' + '">';
					$('#wp-quick-image-preview').append(imageTag);
					$('#wp-quick-image-choose').html('Change image');
				}
			});
			uploader.open();
		});
		// This does the submit
		$('form#quick-press').submit( function (e) {
			e.preventDefault();
			// Disable buttons until we're done.
			$('.wpqi-disable-on-submit').attr('disabled', 'true');
			// Set text on the submit button.
			$('#wpqi-save-post').val('Publishing');
			// Post the data
			$.post( ajaxurl, $(this).serialize(), function( data, textStatus ) {
				console.log('Success');
				console.log('Data: ');
				console.log(data);
				console.log('textStatus: ');
				console.log(textStatus);
				console.log('editUrl: ');
				console.log(data.editUrl);
				$('form#quick-press').append('<a href="' + data.editUrl + '">Edit post</a> | <a href="' + data.permalink + '">View post</a>');
				$('#wpqi-save-post').val('Done!');
			});
		});
		// Make placeholders work - this is AWFUL but is based on the non-reusable, un-semantic code in
		// wp-admin/js/dashboard.js that power the quick draft widget.
		$('#wp-quick-image-title, #wp-quick-image-content').each( function() {
			var input = $(this), prompt = $('#' + this.id + '-prompt-text');

			if ( '' === this.value ) {
				prompt.removeClass('screen-reader-text');
			}

			prompt.click( function() {
				$(this).addClass('screen-reader-text');
				input.focus();
			});

			input.blur( function() {
				if ( '' === this.value ) {
					prompt.removeClass('screen-reader-text');
				}
			});

			input.focus( function() {
				prompt.addClass('screen-reader-text');
			});
		}); 
	});

})( jQuery );
