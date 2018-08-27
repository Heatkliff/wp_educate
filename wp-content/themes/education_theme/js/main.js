

jQuery(function ($) {
    $('#comment').attr('placeholder', 'Join the discussion');


});



 jQuery(function($){
     /*
     * action when you press the image download button
     */
    $('.upload_image_button').click(function(){
        var send_attachment_bkp = wp.media.editor.send.attachment;
        var button = $(this);
        wp.media.editor.send.attachment = function(props, attachment) {
            $(button).parent().prev().attr('src', attachment.url);
            $(button).prev().val(attachment.id);
            wp.media.editor.send.attachment = send_attachment_bkp;
        };
        wp.media.editor.open(button);
        return false;
    });
    /*
     * remove the value of an arbitrary field
     */
    $('.remove_image_button').click(function(){
        var r = confirm("Shure?");
        if (r == true) {
            var src = $(this).parent().prev().attr('data-src');
            $(this).parent().prev().attr('src', src);
            $(this).prev().prev().val('');
        }
        return false;
    });
});