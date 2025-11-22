$(function() {

    var form = $('#contact-form');

    $(form).submit(function(e) {
        e.preventDefault();

        var formData = $(form).serialize();

        $.ajax({
            type: 'POST',
            url: $(form).attr('action'),
            data: formData
        })
        .done(function () {
            alert("Form submitted successfully!");
            form[0].reset();
        })
        .fail(function () {
            alert("There was an error submitting the form. Please try again.");
        });
    });

});
