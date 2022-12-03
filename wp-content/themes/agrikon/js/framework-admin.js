( function ($) {

    "use strict";

    // remove ads on theme options panel
    jQuery( window ).on('load', function() {
        jQuery('#redux-header .rAds').hide();
    });

    /*----------------------------------------------------------------------------------*/
    /*	displaying page custom color
    /*----------------------------------------------------------------------------------*/
    jQuery( document ).ready( function($) {

        $(".et-color-field").wpColorPicker();
        var badgecolor = $('#agrikon_badge_color');
        var badge_custom_color = $('.agrikon_custom_badge_color_field');
        badgecolor.val() == 'custom' ? badge_custom_color.slideDown() : badge_custom_color.slideUp();

        badgecolor.on('change', function(){
            badgecolor.val() == 'custom' ? badge_custom_color.slideDown() : badge_custom_color.slideUp();
        });

        var badgestyle = $('#agrikon_badge');
        var badgecustom = $('.agrikon_custom_badge_field');
        badgestyle.val() == 'custom' ? badgecustom.slideDown() : badgecustom.slideUp();

        badgestyle.on('change', function(){
            badgestyle.val() == 'custom' ? badgecustom.slideDown() : badgecustom.slideUp();
        });

    });

})(jQuery);
