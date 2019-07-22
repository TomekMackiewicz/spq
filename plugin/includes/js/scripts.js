jQuery(document).ready(function() {
    
    // Hide required warning on startup
    jQuery('.spq_required_field').next().hide();

    // Confirm delete
    jQuery('.delete').click(function(event) {
        if (!confirm( 'Are you sure you want to remove the quiz?')) {
            event.preventDefault();
        }
    });
    
    // Activate save button on form change
    jQuery('.spq-quiz-form').on('input change', function() {
        jQuery('.spq-quiz-form :submit').attr('disabled', false);
    });
    
    // Toogle required warning
    jQuery('.spq_required_field').on('input', function() {
        var input = jQuery(this);
        var is_name = input.val();
        if(is_name) {
            input.next().hide();
        } else{
            input.next().show();
        }
    });
    
    // Save quiz
    jQuery('.spq-quiz-form').submit(function(e) {
        e.preventDefault();
        var data = JSON.stringify(jQuery('.spq-quiz-form').serializeArray());

        jQuery.ajax({
            url         : 'http://localhost/wp/wp-json/quiz/v1/quiz/',
            method      : 'post',
            contentType : 'application/json',
            dataType    : 'json',
            data        : data
        })
        .done(function(res) {
            console.log('done');
            console.log(res);
        })
        .fail(function(res) {
            console.log('fail');
            console.log(res);
        })
        .always(function() {
            console.log('always');
        });        
    });


});
