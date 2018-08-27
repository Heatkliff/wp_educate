jQuery(function ($) {
    $('#comment').attr('placeholder', 'Join the discussion');
});

jQuery(function ($) {
    var openBtn = $('#btn'),
        slideMenu = $('#menu')
        ;
    openBtn.on("click", function () {
        if (slideMenu.is(':hidden')) {
            slideMenu.slideDown(300);
        } else {
            slideMenu.slideUp(300);
        }
    });
});

jQuery(function ($) {
    $('#submit-subscribe').click(function () {
        console.log($('#subscribe-form .subscribe-email').val());
        // console.log('<?php get_user_by("email",'+ $('#subscribe-form .subscribe-email').val() + ') ?>');
    })
    }
);

jQuery(function ($) {

    // if ($(window).width() <= 800) {
        // $('.sub-menu').addClass('hide-element');}
        $('.header div ul li').click(function () {
                if ($(window).width() <= 800) {
                    if ( !$(this).hasClass('li-active') ) {
                        $(this).addClass('li-active');
                        $(this).find('.sub-menu').addClass('sub-menu-active');
                    }else {
                        console.log("remove");
                        $(this).removeClass('li-active');
                        $(this).find('.sub-menu').removeClass('sub-menu-active');

                    }
                }
            }
        );
    }
);


jQuery(function ($) {
    /*
     * action when you press the image download button
     */
    $('.upload_image_button').click(function () {
        var send_attachment_bkp = wp.media.editor.send.attachment;
        var button = $(this);
        wp.media.editor.send.attachment = function (props, attachment) {
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
    $('.remove_image_button').click(function () {
        var r = confirm("Shure?");
        if (r == true) {
            var src = $(this).parent().prev().attr('data-src');
            $(this).parent().prev().attr('src', src);
            $(this).prev().prev().val('');
        }
        return false;
    });
});