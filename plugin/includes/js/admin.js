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
    
    // Set controls
    jQuery(document).on('mouseenter', '#spq-preview .spq-control-icon', function() {
        jQuery(this).addClass('ui-state-hover');
    });
    jQuery(document).on('mouseleave', '#spq-preview .spq-control-icon', function() {
        jQuery(this).removeClass('ui-state-hover');
    });

    // Make questions list items sortable
    jQuery(function() {
        jQuery("#spq-preview").sortable({
            placeholder: "ui-state-highlight",
            update: function(event, ui) {
                var lis = jQuery(this).children('li');
                lis.each(function() {
                    var newVal = jQuery(this).index() + 1;
                    jQuery(this).children().children('.sortable-number').html(newVal);
                });
            }
        });
        jQuery("#spq-preview").disableSelection();
    });

    // Add question
    jQuery("#spq-add-question").click(function() {
        var question_title = jQuery('#spq-question-title').val();
        var question_description = jQuery('#spq-question-description').val();
        var question_type = jQuery('#spq-question-type').val();
        var question_hint = jQuery('#spq-question-hint').val();
        var question_obligatory = jQuery('#spq-question-obligatory').val();

        var question = {
            id: jQuery("#spq-preview li").length+1,
            title: question_title,
            description: question_description,
            type: question_type,
            hint: question_hint,
            obligatory: question_obligatory
        };
        
        var questionHtml = '<li class="draggable">';
        questionHtml += '<h3><span class="sortable-number">'+question.id+'</span> '+question.title;
        questionHtml += '<span id="spq-qe_'+question.id+'" class="spq-control-icon spq-edit-icon"><i class="fas fa-cogs"></i></span>';
        questionHtml += '<span id="spq-qd_'+question.id+'" class="spq-control-icon spq-delete-icon"><i class="fas fa-trash-alt"></i></span>';
        questionHtml += '</h3>';
        questionHtml += question.description;
        questionHtml += '</li>';

        jQuery('#spq-preview').append(questionHtml);
    });

    // Edit question
    jQuery(document).on('click', '#spq-preview .spq-edit-icon', function() {
        var id = jQuery(this).attr('id').replace(/[^0-9]/gi, '');
        editQuestion(parseInt(id));
    });
    
    // Delete question
    jQuery(document).on('click', '#spq-preview .spq-delete-icon', function() {
        jQuery(this).parent().parent().remove();
        var lis = jQuery('#spq-preview').children('li');
        lis.each(function() {
            var newVal = jQuery(this).index() + 1;
            jQuery(this).children().children('.sortable-number').html(newVal);
        });        
        
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