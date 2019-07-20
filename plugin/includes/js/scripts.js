jQuery(document).ready(function() {

    jQuery('.delete').click(function(event) {
        if (!confirm( 'Are you sure you want to remove the quiz?')) {
            event.preventDefault();
        } else {
            window.location=document.location.href;
        }
    });

});
