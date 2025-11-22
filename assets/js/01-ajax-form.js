$(function() {

    var form = $('#contact-form');

    $(form).submit(function(e) {
        e.preventDefault();

        var formData = $(form).serialize();

		// Submit the form using AJAX.
		$.ajax({
			type: 'POST',
			url: $(form).attr('action'),
			data: formData,
			dataType: 'json'
		})
		.done(function(response) {
			if (response.status === 'success') {
				alert(response.message);
				// Clear the form.
				$('#contact-form input,#contact-form textarea').val('');
			} else {
				alert('Error: ' + response.message);
			}
		})
		.fail(function(data) {
			// Make sure that the formMessages div has the 'error' class.
			$(formMessages).removeClass('success');
			$(formMessages).addClass('error');

			// Set the message text.
			if (data.responseText !== '') {
				$(formMessages).text(data.responseText);
			} else {
				$(formMessages).text('Oops! An error occured and your message could not be sent.');
			}
		});
	});

});
