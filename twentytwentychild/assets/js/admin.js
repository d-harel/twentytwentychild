var meta_gallery_frame;
jQuery(document).ready(function () {
	// Runs when the image button is clicked.
	jQuery('#ttc_gallery_button').click(function (e) {
		//Attachment.sizes.thumbnail.url/ Prevents the default action from occuring.
		e.preventDefault();

		// If the frame already exists, re-open it.
		if (meta_gallery_frame) {
			meta_gallery_frame.open();
			return;
		}

		// Sets up the media library frame
		meta_gallery_frame = wp.media.frames.meta_gallery_frame = wp.media({
			title: 'Select Images',
			button: { text: 'Select Images' },
			library: { type: 'image' },
			multiple: true,
		});

		// Create Featured Gallery state. This is essentially the Gallery state, but selection behavior is altered.
		meta_gallery_frame.states.add([
			new wp.media.controller.Library({
				id: 'ttc-gallery',
				title: 'Select Images for Gallery',
				priority: 20,
				toolbar: 'main-gallery',
				filterable: 'uploaded',
				library: wp.media.query(meta_gallery_frame.options.library),
				multiple: meta_gallery_frame.options.multiple ? 'reset' : false,
				editable: true,
				allowLocalEdits: true,
				displaySettings: true,
				displayUserSettings: true,
			}),
		]);

		meta_gallery_frame.on('open', function () {
			var selection = meta_gallery_frame.state().get('selection');
			var library = meta_gallery_frame
				.state('gallery-edit')
				.get('library');
			var ids = jQuery('#ttc-gallery').val();
			if (ids) {
				idsArray = ids.split(',');
				idsArray.forEach(function (id) {
					attachment = wp.media.attachment(id);
					attachment.fetch();
					selection.add(attachment ? [attachment] : []);
				});
			}
		});

		meta_gallery_frame.on('ready', function () {
			jQuery('.media-modal').addClass('no-sidebar');
		});

		// When an image is selected, run a callback.
		//meta_gallery_frame.on('update', function() {
		meta_gallery_frame.on('select', function () {
			var imageIDArray = [];
			var imageHTML = '';
			var metadataString = '';
			images = meta_gallery_frame.state().get('selection');
			imageHTML += '<ul class="ttc_gallery_list">';
			images.each(function (attachment) {
				imageIDArray.push(attachment.attributes.id);
				imageHTML +=
					'<li><div class="ttc_gallery_container"><img id="' +
					attachment.attributes.id +
					'" src="' +
					attachment.attributes.sizes.thumbnail.url +
					'"></div></li>';
			});
			imageHTML += '</ul>';
			metadataString = imageIDArray.join(',');
			if (metadataString) {
				jQuery('#ttc-gallery').val(metadataString);
				jQuery('#ttc_gallery_src').html(imageHTML);
				setTimeout(function () {
					ajaxUpdateTempMetaData();
				}, 0);
			}
		});

		// open the modal
		meta_gallery_frame.open();
	});
});
