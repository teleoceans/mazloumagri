<?php

/*
** WooCommerce shop/product listing page
*/

get_header();

do_action("agrikon_before_wc_shop_page");

$shop_display_mode = woocommerce_get_loop_display_mode();
$shop_layout = agrikon_settings( 'shop_layout', 'right-sidebar' );
$container_width = agrikon_settings( 'shop_container_width', '' );
$column = 'full-width' != $shop_layout && is_active_sidebar( 'shop-page-sidebar' ) ? 'col-lg-9 shop-has-sidebar' : 'col-lg-12';
$pagination = '';
if ( agrikon_settings('shop_paginate_type') == 'loadmore' || agrikon_ft() == 'load-more' ) {
    add_action( 'woocommerce_after_shop_loop', 'agrikon_load_more_button', 15 );
    $pagination = 'pagination-load-more';
}

if ( agrikon_settings('shop_paginate_type') == 'infinite' || agrikon_ft() == 'infinite' ) {
    add_action( 'woocommerce_after_shop_loop', 'agrikon_infinite_scroll', 20 );
    $pagination = 'pagination-infinite';
}
?>

<!-- Woo shop page general div -->
<div id="nt-shop-page" class="nt-shop-page">

    <!-- Hero section - this function using on all inner pages -->
    <?php agrikon_wc_hero_section(); ?>

    <div class="nt-theme-inner-container section-padding">
        <div class="container<?php echo esc_attr( $container_width ); ?>">
            <div class="row">

                <!-- Left sidebar -->
                <?php
                if ( 'left-sidebar' == $shop_layout && is_active_sidebar( 'shop-page-sidebar' ) ) {
                    echo '<div id="nt-sidebar" class="col-lg-3">';
                        echo '<div class="blog-sidebar nt-sidebar-inner">';
                            dynamic_sidebar( 'shop-page-sidebar' );
                        echo '</div>';
                    echo '</div>';
                }
                ?>

                <!-- Content column -->
                <div class="<?php echo esc_attr( $column ); ?>">

                    <?php if ( 'subcategories' == $shop_display_mode || 'both' == $shop_display_mode ) :
                        wp_enqueue_style( 'swiper' );
                        wp_enqueue_script( 'swiper' );
                        ?>
                        <div class="thm-swiper__slider2 swiper-container products-cats-wrapper <?php echo esc_attr( $shop_display_mode ); ?>" data-swiper-options='{"loop": true,"spaceBetween": 0, "slidesPerView": 5, "slidesPerGroup": 1, "autoplay": true, "navigation": {"nextEl": "#products-cats__next","prevEl": "#products-cats__prev"},"breakpoints": {"0": {"spaceBetween": 0,"slidesPerView": 2},"768": {"slidesPerView": 3},"1024": {"slidesPerView": 4}}}'>
                            <div class="swiper-wrapper"></div>
                            <div class="products-cats__nav">
                                <div class="swiper-button-prev" id="products-cats__next"><i class="agrikon-icon-left-arrow"></i></div>
                                <div class="swiper-button-next" id="products-cats__prev"><i class="agrikon-icon-right-arrow"></i></div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="products-wrapper" data-pagination="<?php echo esc_attr( $pagination ); ?>">
                    <?php

                    if ( woocommerce_product_loop() ) {

                        woocommerce_product_loop_start();

                        do_action( 'venam_after_loop_start' );

                        echo '<div class="col product_item notices--wrapper">';
                        /**
                        * Hook: woocommerce_before_shop_loop.
                        *
                        * @hooked woocommerce_output_all_notices - 10
                        * @hooked woocommerce_result_count - 20
                        * @hooked woocommerce_catalog_ordering - 30
                        */
                        do_action( 'woocommerce_before_shop_loop' );
                        echo '</div>';

                        if ( wc_get_loop_prop( 'total' ) ) {
                            while ( have_posts() ) {
                                the_post();

                                wc_get_template_part( 'content', 'product' );
                            }
                        }

                        woocommerce_product_loop_end();

                        /**
                        * Hook: woocommerce_after_shop_loop.
                        *
                        * @hooked woocommerce_pagination
                        */

                        do_action( 'woocommerce_after_shop_loop' );

                    } else {
                        /**
                        * Hook: woocommerce_no_products_found.
                        *
                        * @hooked wc_no_products_found - 10
                        */
                        do_action( 'woocommerce_no_products_found' );
                    }
                    ?>
                    </div>
                    <?php
                        /**
                        * Hook: agrikon_after_shop_loop.
                        *
                        * @hooked agrikon_after_shop_loop
                        */

                        do_action( 'agrikon_after_shop_loop' );

                    ?>
                </div>
                <!-- End sidebar + content -->

                <!-- Right sidebar -->
                <?php
                if ( 'right-sidebar' == $shop_layout && is_active_sidebar( 'shop-page-sidebar' ) ) {
                    echo '<div id="nt-sidebar" class="col-lg-3">';
                        echo '<div class="blog-sidebar nt-sidebar-inner">';
                            dynamic_sidebar( 'shop-page-sidebar' );
                        echo '</div>';
                    echo '</div>';
                }
                ?>

            </div><!-- End row -->
        </div><!-- End container -->
    </div><!-- End #blog -->
</div><!-- End woo shop page general div -->
<?php

do_action("agrikon_after_wc_shop_page");

get_footer();

?>
