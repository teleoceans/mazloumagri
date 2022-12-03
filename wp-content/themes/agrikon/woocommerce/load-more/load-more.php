<?php

/*************************************************
## agrikon Current Page URL
*************************************************/
add_filter( 'woocommerce_widget_get_current_page_url', 'agrikon_current_page_url', 10, 2 );
function agrikon_current_page_url( $link, $that ) {
    if ( isset( $_GET['filter_cat'] ) ) {
        $link = add_query_arg( 'filter_cat', wc_clean( wp_unslash( $_GET['filter_cat'] ) ), $link );
    }

    if ( isset( $_GET['shop_view'] ) ) {
        $link = add_query_arg( 'shop_view', wc_clean( wp_unslash( $_GET['shop_view'] ) ), $link );
    }

    return $link;
}


/*************************************************
## Load More Button
*************************************************/
function agrikon_load_more_button(){
    echo '<div class="row row-more agrikon-more mt-30">
    <div class="col-12 nt-pagination -align-center">
    <div class="agrikon-btn thm-btn agrikon-load-more" data-title="'.esc_html__('Loading...','agrikon').'">'.esc_html__('Load More','agrikon').'</div>
    </div>
    </div>';
}


/*************************************************
## Infinite Pagination
*************************************************/
function agrikon_infinite_scroll(){
    echo '<div class="row row-infinite agrikon-more mt-30">
    <div class="col-12 nt-pagination -align-center">
    <div class="agrikon-load-more" data-title="'.esc_html__('Loading...','agrikon').'">'.esc_html__('Loading...','agrikon').'</div>
    </div>
    </div>';
}


/*************************************************
## Load More CallBack
*************************************************/
add_action( 'wp_ajax_nopriv_load_more', 'agrikon_load_more_callback' );
add_action( 'wp_ajax_load_more', 'agrikon_load_more_callback' );
function agrikon_load_more_callback() {

    $output = '';

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $_POST['per_page'],
        'paged' => $_POST['current_page'] + 1
    );

    //Loop
    $loop = new WP_Query( $args );
    if ( $loop->have_posts() ) {
        while ( $loop->have_posts() ) : $loop->the_post();
            wc_get_template_part( 'content', 'product' );
        endwhile;
    } else {
        echo esc_html__( 'No products found','agrikon' );
    }
    wp_reset_postdata();

    wp_die();

}
