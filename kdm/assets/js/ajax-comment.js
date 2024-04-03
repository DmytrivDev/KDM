/*
 * Let's begin with validation functions
 */
jQuery.extend(jQuery.fn, {
    /*
     * check if field value lenth more than 3 symbols ( for name and comment )
     */
    validate: function () {
        if (jQuery(this).val().length < 3) {jQuery(this).addClass('error');return false} else {jQuery(this).removeClass('error');return true}
    },
    /*
     * check if email is correct
     * add to your CSS the styles of .error field, for example border-color:red;
     */
    validateEmail: function () {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/,
            emailToValidate = jQuery(this).val();
        if (!emailReg.test( emailToValidate ) || emailToValidate == "") {
            jQuery(this).addClass('error');return false
        } else {
            jQuery(this).removeClass('error');return true
        }
    },
});

jQuery(function($){


    $( '#commentform' ).submit(function(){

        var button = $('#submit'),
            respond = $('#respond'),
            commentform = respond.find('#commentform'),
            commentlist = $('.comment-list');

        // if user is logged in, do not validate author and email fields
        if( $( '#author' ).length )
            $( '#author' ).validate();

        if( $( '#email' ).length )
            $( '#email' ).validateEmail();

        // validate comment in any case
        $( '#comment' ).validate();

        // if comment form isn't in process, submit it
        if ( !button.hasClass( 'loadingform' ) && !$( '#author' ).hasClass( 'error' ) && !$( '#email' ).hasClass( 'error' ) && !$( '#comment' ).hasClass( 'error' ) ){
            $('.alert-warning').remove();
            // ajax request
            $.ajax({
                type : 'POST',
                url : misha_ajax_comment_params.ajaxurl, // admin-ajax.php URL
                data: $(this).serialize() + '&action=ajaxcomments', // send form data + action parameter
                beforeSend: function(xhr){
                    // what to do just after the form has been submitted
                    button.addClass('loadingform').val('Loading...');
                    $('.review__button').text('Відправлення...');
                },
                error: function (request, status, error) {
                    if( status == 500 ){
                        respond.append('<div class="alert alert-warning">Помилка додавання відгуку</div>');
                    } else if( status == 'timeout' ){
                        respond.append('<div class="alert alert-warning">Помилка: Сервер не відповідає</div>');
                    } else {
                        // process WordPress errors
                        var wpErrorHtml = request.responseText.split("<p>"),
                            wpErrorStr = wpErrorHtml[1].split("</p>");

                        respond.append('<div class="alert alert-warning">'+wpErrorStr[0]+'</div>');
                    }
                },
                success: function ( addedCommentHTML ) {

                    if( commentlist.length > 0 ){

                        commentlist.prepend( addedCommentHTML );

                    }else{
                        addedCommentHTML = '<ol class="commentlist comment-list">' + addedCommentHTML + '</ol>';
                        $('#comments').html( $(addedCommentHTML) );
                    }

                    commentform[0].reset();
                    commentform.find('.stars, .stars span').removeClass('star-1');
                    commentform.find('.stars, .stars span').removeClass('star-2');
                    commentform.find('.stars, .stars span').removeClass('star-3');
                    commentform.find('.stars, .stars span').removeClass('star-4');
                    commentform.find('.stars, .stars span').removeClass('star-5');
                    commentform.find('.stars, a').removeClass('active');

                },
                complete: function(){
                    // what to do after a comment has been added
                    button.removeClass( 'loadingform' ).val( 'Post Comment' );
                    $('.review__button').text('Опублікувати');
                    $('.review__button').removeClass('dis');
                }
            });
        }
        return false;
    });
});