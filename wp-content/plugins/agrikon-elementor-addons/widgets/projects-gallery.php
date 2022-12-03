<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Agrikon_Projects_Gallery extends Widget_Base {
    use Agrikon_Helper;
    public function get_name() {
        return 'agrikon-projects-gallery';
    }
    public function get_title() {
        return 'Projects Gallery Grid (N)';
    }
    public function get_icon() {
        return 'eicon-gallery-grid';
    }
    public function get_categories() {
        return [ 'agrikon-cpt' ];
    }
    // Registering Controls
    protected function register_controls() {
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section( 'nt_post_query',
            [
                'label' => esc_html__( 'Query', 'agrikon' ),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->agrikon_query_controls('projects');

        $this->add_control( 'collg',
            [
                'label' => esc_html__( 'Column Desktop', 'agrikon' ),
                'type' => Controls_Manager::SELECT,
                'default' => '4',
                'separator' => 'before',
                'options' => [
                    '12' => esc_html__( '1 Column', 'agrikon' ),
                    '6' => esc_html__( '2 Column', 'agrikon' ),
                    '4' => esc_html__( '3 Column', 'agrikon' ),
                    '3' => esc_html__( '4 Column', 'agrikon' ),
                ],
            ]
        );
        $this->add_control( 'colmd',
            [
                'label' => esc_html__( 'Column Tablet', 'agrikon' ),
                'type' => Controls_Manager::SELECT,
                'default' => '6',
                'options' => [
                    '12' => esc_html__( '1 Column', 'agrikon' ),
                    '6' => esc_html__( '2 Column', 'agrikon' ),
                    '4' => esc_html__( '3 Column', 'agrikon' ),
                    '3' => esc_html__( '4 Column', 'agrikon' ),
                ],
            ]
        );
        $this->add_control( 'colsm',
            [
                'label' => esc_html__( 'Column Phone', 'agrikon' ),
                'type' => Controls_Manager::SELECT,
                'default' => '12',
                'options' => [
                    '12' => esc_html__( '1 Column', 'agrikon' ),
                    '6' => esc_html__( '2 Column', 'agrikon' ),
                    '4' => esc_html__( '3 Column', 'agrikon' ),
                    '3' => esc_html__( '4 Column', 'agrikon' ),
                ],
            ]
        );
        $this->add_control( 'thumb_type',
            [
                'label' => esc_html__( 'Thumbnail Type', 'agrikon' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'img',
                'options' => [
                    'img' => esc_html__( 'Image', 'agrikon' ),
                    'bg' => esc_html__( 'Background', 'agrikon' ),
                ],
            ]
        );
        $this->add_responsive_control( 'minh',
            [
                'label' => esc_html__( 'Min Height', 'agrikon' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 1000,
                'default' => 470,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .projects-one__single' => 'min-height: {{SIZE}}px;background-size:cover;background-repeat:no-repeat;background-position:center;'
                ],
                'condition' => [ 'thumb_type' => 'bg' ]
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
            'name' => 'thumbnail',
            'separator' => 'none',
            'default' => 'agrikon-square',
            ]
        );
        $this->add_control( 'box_link',
            [
                'label' => esc_html__( 'Add Link to Box', 'agrikon' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );
        $this->add_control( 'show_author',
            [
                'label' => esc_html__( 'Show Author Name', 'agrikon' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   END CONTROLS SECTION   ******/
        $this->start_controls_section( 'style_section',
            [
                'label' => esc_html__( 'Style', 'agrikon' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control( 'box_heading',
            [
                'label' => esc_html__( 'BOX', 'agrikon' ),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => esc_html__( 'Border', 'agrikon' ),
                'selector' => '{{WRAPPER}} .projects-one__single',
            ]
        );
        $this->add_responsive_control( 'box_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'agrikon' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .projects-one__single' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
            ]
        );
        $this->add_control( 'txtbox_heading',
            [
                'label' => esc_html__( 'TEXT CONTENT', 'agrikon' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control( 'txtbox_bgcolor',
            [
                'label' => esc_html__( 'Overlay Color', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .project-one .projects-one__content' => 'color:{{VALUE}};' ],
            ]
        );
        $this->add_control( 'title_heading',
            [
                'label' => esc_html__( 'TITLE', 'agrikon' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control( 'tag',
            [
                'label' => esc_html__( 'Title Tag', 'agrikon' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'h3',
                'options' => [
                    'h1' => esc_html__( 'H1', 'agrikon' ),
                    'h2' => esc_html__( 'H2', 'agrikon' ),
                    'h3' => esc_html__( 'H3', 'agrikon' ),
                    'h4' => esc_html__( 'H4', 'agrikon' ),
                    'h5' => esc_html__( 'H5', 'agrikon' ),
                    'h6' => esc_html__( 'H6', 'agrikon' ),
                    'div' => esc_html__( 'div', 'agrikon' ),
                    'p' => esc_html__( 'p', 'agrikon' ),
                ]
            ]
        );
        $this->add_control( 'title_color',
            [
                'label' => esc_html__( 'Color', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .project-one .projects-one__content .title' => 'color:{{VALUE}};' ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typo',
                'label' => esc_html__( 'Typography', 'agrikon' ),
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .project-one .projects-one__content .title'
            ]
        );
        $this->add_control( 'author_heading',
            [
                'label' => esc_html__( 'AUTHOR', 'agrikon' ),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_control( 'author_color',
            [
                'label' => esc_html__( 'Color', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .projects-one__content .projects-author__name' => 'color:{{VALUE}};' ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'author_typo',
                'label' => esc_html__( 'Typography', 'agrikon' ),
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .projects-one__content .projects-author__name'
            ]
        );
        $this->add_control( 'btn_heading',
            [
                'label' => esc_html__( 'BUTTON', 'agrikon' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->start_controls_tabs( 'btn_tabs');
        $this->start_controls_tab( 'btn_normal_tab',
            [ 'label'  => esc_html__( 'Normal', 'agrikon' ) ]
        );
        $this->add_control( 'btn_color',
            [
                'label' => esc_html__( 'Color', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .projects-one__button' => 'color:{{VALUE}};' ],
            ]
        );
        $this->add_control( 'btn_bgcolor',
            [
                'label' => esc_html__( 'Background', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .projects-one__button' => 'background-color:{{VALUE}};' ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'btn_border',
                'label' => esc_html__( 'Border', 'agrikon' ),
                'selector' => '{{WRAPPER}} .projects-one__button',
            ]
        );
        $this->add_responsive_control( 'btn_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'agrikon' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .projects-one__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab( 'btn_hover_tab',
            [ 'label' => esc_html__( 'Hover', 'agrikon' ) ]
        );
        $this->add_control( 'btn_hvrcolor',
            [
                'label' => esc_html__( 'Color', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .projects-one__button:hover' => 'color:{{VALUE}};' ],
            ]
        );
        $this->add_control( 'btn_hvrbgcolor',
            [
                'label' => esc_html__( 'Background', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .projects-one__button:hover' => 'background-color:{{VALUE}};' ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'btn_hvrborder',
                'label' => esc_html__( 'Border', 'agrikon' ),
                'selector' => '{{WRAPPER}} .projects-one__button:hover',
            ]
        );
        $this->add_responsive_control( 'btn_hvrborder_radius',
            [
                'label' => esc_html__( 'Border Radius', 'agrikon' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .projects-one__button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   END CONTROLS SECTION   ******/
        $this->start_controls_section( 'pagination_style_section',
            [
                'label' => esc_html__( 'Pagination Style', 'agrikon' ),
                'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [ 'pagination' => 'yes' ]
            ]
        );
        $this->add_responsive_control( 'pagination_alignment',
            [
                'label' => esc_html__( 'Alignment', 'styler' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Left', 'styler' ),
                        'icon' => 'eicon-h-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'styler' ),
                        'icon' => 'eicon-h-align-center'
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Right', 'styler' ),
                        'icon' => 'eicon-h-align-right'
                    ]
                ],
                'toggle' => true,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .agrikon-pagination' => 'justify-content:{{VALUE}};' ]
            ]
        );
        $this->start_controls_tabs( 'pagination_btn_tabs');
        $this->start_controls_tab( 'pagination_btn_normal_tab',
            [ 'label'  => esc_html__( 'Normal', 'agrikon' ) ]
        );
        $this->add_control( 'pagination_btn_color',
            [
                'label' => esc_html__( 'Color', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .agrikon-pagination .page-numbers' => 'color:{{VALUE}};' ],
            ]
        );
        $this->add_control( 'pagination_btn_bgcolor',
            [
                'label' => esc_html__( 'Background', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .agrikon-pagination .page-numbers' => 'background-color:{{VALUE}};' ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'pagination_btn_border',
                'label' => esc_html__( 'Border', 'agrikon' ),
                'selector' => '{{WRAPPER}} .agrikon-pagination .page-numbers',
            ]
        );
        $this->add_responsive_control( 'pagination_btn_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'agrikon' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .agrikon-pagination .page-numbers' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab( 'pagination_btn_hover_tab',
            [ 'label' => esc_html__( 'Hover/Active', 'agrikon' ) ]
        );
        $this->add_control( 'pagination_btn_hvrcolor',
            [
                'label' => esc_html__( 'Color', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .agrikon-pagination .page-numbers:hover,{{WRAPPER}} .agrikon-pagination .page-numbers.current' => 'color:{{VALUE}};' ],
            ]
        );
        $this->add_control( 'pagination_btn_hvrbgcolor',
            [
                'label' => esc_html__( 'Background', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .agrikon-pagination .page-numbers:hover,{{WRAPPER}} .agrikon-pagination .page-numbers.current' => 'background-color:{{VALUE}};' ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'pagination_btn_hvrborder',
                'label' => esc_html__( 'Border', 'agrikon' ),
                'selector' => '{{WRAPPER}} .agrikon-pagination .page-numbers:hover,{{WRAPPER}} .agrikon-pagination .page-numbers.current',
            ]
        );
        $this->add_responsive_control( 'pagination_btn_hvrborder_radius',
            [
                'label' => esc_html__( 'Border Radius', 'agrikon' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => ['{{WRAPPER}} .agrikon-pagination .page-numbers:hover,{{WRAPPER}} .agrikon-pagination .page-numbers.current' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $id = $this->get_id();

        if ( is_home() || is_front_page() ) {
            $paged = get_query_var( 'page') ? get_query_var('page') : 1;
        } else {
            $paged = get_query_var( 'paged') ? get_query_var('paged') : 1;
        }

        $post_type = $settings['post_type'];

        $args['post_type']      = $settings['post_type'];
        $args['posts_per_page'] = $settings['posts_per_page'];
        $args['offset']         = $settings['offset'];
        $args['order']          = $settings['order'];
        $args['orderby']        = $settings['orderby'];
        $args['paged']          = $paged;
        $args[$settings['author_filter_type']] = $settings['author'];

        if ( ! empty( $settings[ $post_type . '_filter' ] ) ) {
            $args[ $settings[ $post_type . '_filter_type' ] ] = $settings[ $post_type . '_filter' ];
        }

        // Taxonomy Filter.
        $taxonomy = $this->get_post_taxonomies( $post_type );

        if ( ! empty( $taxonomy ) && ! is_wp_error( $taxonomy ) ) {

            foreach ( $taxonomy as $index => $tax ) {

                $tax_control_key = $index . '_' . $post_type;

                if ( $post_type == 'post' ) {
                    if ( $index == 'post_tag' ) {
                        $tax_control_key = 'tags';
                    } elseif ( $index == 'category' ) {
                        $tax_control_key = 'categories';
                    }
                }

                if ( ! empty( $settings[ $tax_control_key ] ) ) {

                    $operator = $settings[ $index . '_' . $post_type . '_filter_type' ];

                    $args['tax_query'][] = array(
                        'taxonomy' => $index,
                        'field'    => 'term_id',
                        'terms'    => $settings[ $tax_control_key ],
                        'operator' => $operator,
                    );
                }
            }
        }

        $size = $settings['thumbnail_size'] ? $settings['thumbnail_size'] : 'full';
        if ( 'custom' == $size ) {
            $sizew = $settings['thumbnail_custom_dimension']['width'];
            $sizeh = $settings['thumbnail_custom_dimension']['height'];
            $size = [ $sizew, $sizeh ];
        }

        $the_query = new \WP_Query( $args );
        if ( $the_query->have_posts() ) {
            echo '<div class="project-one">';
                echo '<div class="row">';
                    while ( $the_query->have_posts() ) {
                        $the_query->the_post();
                        if ( has_post_thumbnail() ) {
                            $url = get_the_post_thumbnail_url( get_the_ID(), $size );
                            $bg = 'bg' == $settings['thumb_type'] ? ' style="background-image:url('.$url.');"' : '';
                            echo '<div class="col-sm-'.$settings['colsm'].' col-md-'.$settings['colmd'].' col-lg-'.$settings['collg'].'">';
                                echo '<div class="projects-one__single thumb-'.$settings['thumbnail_size'].'"'.$bg.'>';
                                    if ( 'yes' == $settings['box_link'] ) {
                                        echo '<a href="'.get_permalink().'" class="projects-box__link" title="' . get_the_title() . '"></a>';
                                    }
                                    if ( 'bg' != $settings['thumb_type'] ) {
                                        echo get_the_post_thumbnail( get_the_ID(), $size, array( 'class' => 'post--image' ) );
                                    }
                                    echo '<div class="projects-one__content">';
                                        echo '<'.$settings['tag'].' class="title">' . get_the_title() . '</'.$settings['tag'].'>';
                                        echo '<a href="'.get_permalink().'" class="projects-one__button"><i class="agrikon-icon-right-arrow"></i></a>';
                                        if ( 'yes' == $settings['show_author'] ) {
                                            echo '<span class="projects-author__name">' . get_the_author() . '</span>';
                                        }
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                        }
                    }
                echo '</div>';
                if ( 'yes' == $settings['pagination'] && $the_query->max_num_pages > 1 ) {
                    echo '<div class="agrikon-pagination">';
                        echo paginate_links(array(
                            'base' => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                            'format' => '?paged=%#%',
                            'current' => max(1, $paged ),
                            'total' => $the_query->max_num_pages,
                            'type' => '',
                            'prev_text' => '<i class="fa fa-angle-left"></i>',
                            'next_text' => '<i class="fa fa-angle-right"></i>',
                            'before_page_number' => '<div class="nt-pagination-item">',
                            'after_page_number' => '</div>'
                        ));
                    echo '</div>';
                }
            echo '</div>';

        } else {
            echo '<p class="text">No post found!</p>';
        }
    }
}
