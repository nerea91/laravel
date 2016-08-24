$( "form" ).submit(function( event ) {

    if($('#formatxls:checked').val() || $('#formatpdf:checked').val())
    {
        $('input[type="submit"]').prop('disabled', false);
        $(window).on('blur', function() {
    		$('span.spinner').remove();
    	});

    }

});
