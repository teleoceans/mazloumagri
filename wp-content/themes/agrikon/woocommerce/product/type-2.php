<?php

/*
** Product type 2
*/

defined( 'ABSPATH' ) || exit;

global $product;

?>

<div class="row">

    <div class="col-lg-5">
        <div class="product-header">
            <?php do_action( 'agrikon_loop_product_thumb' ); ?>
            <?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="product-details"><?php echo do_action( 'agrikon_loop_product_details' ); ?></div>
        <?php do_action( 'agrikon_loop_product_title' ); ?>
        <div class="product-actions">
            <div class="shop-cart_button">
                <?php woocommerce_template_loop_add_to_cart(); ?>
            </div>
            <?php
            if ( wp_doing_ajax() ) {

                agrikon_wc_quick_view();

                if ( class_exists( 'YITH_WCWL_Shortcode' ) ) {
                    echo do_shortcode('[yith_wcwl_add_to_wishlist product_id="'.$product_id.'"]');
                }
                if ( defined( 'YITH_WOOCOMPARE' ) ) {
                    echo'<a href="'.esc_url(home_url()).'?action=yith-woocompare-add-product&amp;id='.$product_id.'" class="compare button" data-product_id="'.$product_id.'" rel="nofollow"></a>';
                }
            } else {
                do_action( 'woocommerce_after_shop_loop_item' );
            }
            ?>
        </div>
    </div>

</div>
