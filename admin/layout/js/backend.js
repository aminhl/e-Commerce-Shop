$(function (){
    'use strict';

   /* Hide Placeholder on focus state */
    $('[placeholder]').focus(function () {

        $(this).attr('data-text', $(this).attr('placeholder'));

        $(this).attr('placeholder', '');

    }).blur(function () {

        $(this).attr('placeholder', $(this).attr('data-text'));

    });


    $('input').each(function () {

        if ($(this).attr('required') === 'required') {

            $(this).after('<span class="asterisk">*</span>');

        }

    });

    // Convert Password Field To Text Field On Hover

    var passField = $('.password');

    $('.show-pass').hover(function () {

        passField.attr('type', 'text');

    }, function () {

        passField.attr('type', 'password');

    });

});