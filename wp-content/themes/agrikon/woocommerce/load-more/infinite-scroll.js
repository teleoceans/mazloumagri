
jQuery(document).ready(function ($) {
    var count = 2;
    var total = loadmore.max_page;

    $(window).data('ajaxready', true).scroll(function(e) {
        if ($(window).data('ajaxready') === false) return;

        if($(window).scrollTop() >= $('div.products').offset().top + $('div.products.woocommerce--row').outerHeight() - window.innerHeight) {
            $(window).data('ajaxready', false);

            if (count > total) {
                return false;
            } else {
                agrikon_infinite_pagination(count);
            }
            count++;
        }
    });

    function agrikon_infinite_pagination() {
        var data = {
            cache: false,
            action: 'load_more',
            beforeSend: function() {
                $('.agrikon-load-more').addClass('loading');
            },
            'current_page': loadmore.current_page,
            'per_page': loadmore.per_page,
            'shop_view': loadmore.shop_view
        };

        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        $.post(loadmore.ajaxurl, data, function(response) {
            $('div.products.woocommerce--row').append(response);
            loadmore.current_page++;

            if ( loadmore.current_page == loadmore.max_page ){
                $('.agrikon-load-more').remove();
            }

            $(window).data('ajaxready', true);
        });

        return false;
    }
});
