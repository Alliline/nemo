/* Captcha */
function captcha() {	
	document.getElementById('captcha').innerHTML = '<img src="/ajax.php?action=captcha&id='+ new Date().getTime() +'" width="100" height="44" alt="" />';
	return false;
};

/* Form get data */
function FieldsForm( obj )
{
	var data = {};

    $.each( $(obj).serializeArray(), function(i, field) {
        data[field.name] = ''+field.value+'';
    });

    return data;
}

/* Update counter */
function counter( action )
{
	var counter = parseInt( $('#counter').html() );

	if( action === '+' ) {
		counter = counter + 1;
	} else if ( action === '-' ) {
		counter = counter - 1;
	}

	$('#counter').html( counter );
}

/* Remove comments */
function CommentsRemove( id )
{
	if( isNaN(id) ) return false;

	$.get(
		'/ajax.php', 
		{
			id: id, 
			action: 'remove'
		}, 
		function(cid) {
			var comm = $('#comm-id-'+cid);

			/* $("html,body").stop().animate({
				scrollTop: comm.offset().top - 80
			}, 700); */

			setTimeout(function() { 
				comm.slideUp( 1200 );
			}, 100);

			counter('-');

		}
	, 'html');
}

/* Added new comments */
function CommentsAdd( form )
{
	$.post(
		'/ajax.php',
		form,
		function( data ) {

			captcha();

			if( data === 'error' ) {
				$('#comment_captcha').addClass('errno').val('').attr('placeholder', 'Код безопасности введен неверно!');
				return false;
			} else $('#comment_captcha').removeClass('errno');

			$('#list-comments').prepend(data);
			$('#comments-animate:first').hide();

			if( document.getElementById('comments-animate') ) {

				$("html,body").stop().animate({
					scrollTop: $("#list-comments").offset().top - 100
				}, 600);
		
				setTimeout(function() { 
					$('#comments-animate:first').slideDown( 1200 );
				}, 400);

				counter('+');

			}
		}
	, 'html');
}

/**
 * JQUERY READY
 */
jQuery(document).ready( function($) 
{
	// Captcha loading
	if( $('#captcha').length > 0 ) {
		captcha();
	}

	/* --- Events --- */
	$(document)
		// Reload raptcha
		.on( 'click', '.captcha', captcha )
		// Remove comments
		.on( 'click', '.commentsRemove', function() {
			var id = $(this).data('id');
			CommentsRemove( id );
			return false;
		})
		// Add comments
		.on( 'submit', '#add-comments', function(e) {

			e.preventDefault();

			var form = FieldsForm('#add-comments'), errno = false;

			if( !form.name ) {
				errno = true;
				$('#comment_name').addClass('errno').attr('placeholder', 'Укажите Ваше имя!');
			} else $('#comment_name').removeClass('errno');

			if( !form.text ) {
				errno = true;
				$('.tox-tinymce').addClass('errno');
				$('#comment_text').addClass('errno');
			} else {
				$('.tox-tinymce').removeClass('errno');
				$('#comment_text').removeClass('errno');
			}

			if( !form.captcha ) {
				errno = true;
				$('#comment_captcha').addClass('errno').val('').attr('placeholder', 'Введите код с картинки!');
			} else $('#comment_captcha').removeClass('errno');

			if( errno === false ) CommentsAdd(form);

			return false;
		});

	// TinyMCE Editor
	tinymce.init({
		selector : '#comment_text',
		language: 'ru',
		language_url: '/themes/scripts/ru.js',
		plugins : ['image paste autoresize'],
		toolbar : 'image',
		menubar: false,				
		paste_data_images: true,
		images_upload_url : '/ajax.php?action=upload',
		automatic_uploads : true,
		image_advtab: true,
		images_reuse_filename: true,

		file_picker_callback: function(callback, value, meta) {
			if (meta.filetype == 'image') {
				$('#upload').trigger('click');
				$('#upload').on('change', function() {
					var file = this.files[0];
					var reader = new FileReader();
					reader.onload = function(e) {
						callback(e.target.result, {
							alt: ''
						});
					};
					reader.readAsDataURL(file);
				});
			}
		},

		images_upload_handler: function (blobInfo, success, failure) {
			var xhr, formData;

			xhr = new XMLHttpRequest();
			xhr.withCredentials = false;
			xhr.open('POST', '/ajax.php?action=upload');

			xhr.onload = function() {
				var json;

				if( xhr.status != 200 ) {
					failure('Ошибка: ' + xhr.responseText);
					return;
				}

				json = JSON.parse(xhr.responseText);

				if (!json || typeof json.location != 'string') {
					failure('Invalid JSON: ' + xhr.responseText);
					return;
				}

				success(json.location);
			};

			formData = new FormData();
			formData.append('file', blobInfo.blob(), blobInfo.filename());

			xhr.send(formData);
		},

	});

});