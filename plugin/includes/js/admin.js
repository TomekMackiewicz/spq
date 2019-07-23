jQuery(document).ready(function() {

//------------------------------------------------------------------------------
// QUIZ FORM
// -----------------------------------------------------------------------------
    
    // Hide required / regex warning on startup
    jQuery('.spq-required-field').next().hide();
    jQuery('.spq-regex-integer').next().hide();

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
    jQuery('.spq-required-field').on('input', function() {
        var input = jQuery(this);
        if (input.val()) {
            input.next().hide();
        } else{
            input.next().show();
        }
    });

    // Toogle regex against integers warning
    jQuery('.spq-regex-integer').on('input', function() {
        var input = jQuery(this);
        if (input.val().match(/[^0-9]/g, '')) {
            input.next().show();
        } else{
            input.next().hide();
        }
    });
    
    // Show per page field only if paginate heckbox is checked
    jQuery('#spq-paginate').click(function() {
        jQuery("#spq-questions-per-page").toggle(this.checked);
    });
    
//------------------------------------------------------------------------------
// SAVE QUIZ
// -----------------------------------------------------------------------------

    jQuery('.spq-quiz-form').submit(function(e) {
        e.preventDefault();
        var data = JSON.stringify(jQuery('.spq-quiz-form').serializeArray());

        jQuery.ajax({
            url         : 'http://localhost/wp/wp-json/quiz/v1/quiz/',
            method      : 'post',
            contentType : 'application/json; charset=UTF-8',
            dataType    : 'json',
            data        : data
        })
        .done(function(response) {
            jQuery('#wpbody-content').prepend('<div class="notice notice-success is-dismissible"><p>'+response+'</p></div>');
        })
        .fail(function(response) {
            jQuery('#wpbody-content').prepend(response.responseText);
        });        
    });


});
