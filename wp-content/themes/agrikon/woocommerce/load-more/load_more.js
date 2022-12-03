jQuery(document).ready(function($) {
    "use strict";

    var perpage;
    $('.agrikon-load-more').on('click ready', function(e){
        perpage = -1;
    });

    $(document).on('click', '.agrikon-load-more', function(event){
        event.preventDefault();
        var loading = $('.agrikon-load-more').data('title');
        var more = $('.agrikon-load-more').text();
        var data = {
            cache: false,
            action: 'load_more',
            beforeSend: function() {
                $('.agrikon-load-more').html(loading).addClass('loading');
            },
            'current_page': loadmore.current_page,
            'per_page': loadmore.per_page,
            'shop_view': loadmore.shop_view
        };

        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        $.post(loadmore.ajaxurl, data, function(response) {
            $('div.products.woocommerce--row').append(response);
            loadmore.current_page++;

            $('.agrikon-load-more').html(more).removeClass('loading');

            if ( loadmore.current_page == loadmore.max_page ){
                $('.agrikon-more').remove();
            }
        });
    });
});
