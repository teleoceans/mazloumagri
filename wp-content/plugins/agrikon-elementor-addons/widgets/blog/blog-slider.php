<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Agrikon_Blog_Slider extends Widget_Base {
    use Agrikon_Helper;
    public function get_name() {
        return 'agrikon-blog-slider';
    }
    public function get_title() {
        return 'Blog Slider (N)';
    }
    public function get_icon() {
        return 'eicon-slider-push';
    }
    public function get_categories() {
        return [ 'agrikon' ];
    }
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        wp_register_style( 'agrikon-blog-grid', AGRIKON_PLUGIN_URL. 'widgets/blog/grid.css');
        //wp_register_script( 'blog-slider', AGRIKON_PLUGIN_URL. 'widgets/blog/scripts.js');
    }
    public function get_style_depends() {
        return [ 'agrikon-swiper','agrikon-blog-grid' ];
    }
    public function get_script_depends() {
        return [ 'agrikon-swiper' ];
    }
    // Registering Controls
    protected function register_controls() {
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section( 'general_settings',
            [
                'label' => esc_html__( 'General', 'agrikon' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control( 'type',
            [
                'label' => esc_html__( 'Type', 'agrikon' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'classic' => esc_html__( 'Classic', 'agrikon' ),
                    'classic2' => esc_html__( 'Classic 2', 'agrikon' ),
                    'classic3' => esc_html__( 'Classic 3', 'agrikon' ),
                    'minimal1' => esc_html__( 'Minimal', 'agrikon' ),
                    'minimal2' => esc_html__( 'Minimal 2', 'agrikon' ),
                    'minimal3' => esc_html__( 'Minimal 3', 'agrikon' ),
                    'minimal4' => esc_html__( 'Minimal 4', 'agrikon' ),
                    'minimal5' => esc_html__( 'Minimal 5', 'agrikon' ),
                    'minimal6' => esc_html__( 'Minimal 6', 'agrikon' ),
                    'split' => esc_html__( 'Split', 'agrikon' ),
                    'split2' => esc_html__( 'Split 2', 'agrikon' ),
                ],
                'default' => 'classic'
            ]
        );
        $this->add_responsive_control( 'box_splitwidth',
            [
                'label' => esc_html__( 'Image Content Width ( % )', 'agrikon' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'default' => 40,
                'selectors' => [
                    '{{WRAPPER}} .box--split .post--link' => 'width: {{SIZE}}%;',
                    '{{WRAPPER}} .box--split .post--content-wrapper' => 'width: calc( 100% - {{SIZE}}% );',
                    '{{WRAPPER}} .box--split2 .post--link' => 'width: {{SIZE}}%;',
                    '{{WRAPPER}} .box--split2 .post--content-wrapper' => 'width: calc( 100% - {{SIZE}}% );'
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        ['name' => 'type','operator' => '==','value' => 'split'],
                        ['name' => 'type','operator' => '==','value' => 'split2'],
                    ]
                ]
            ]
        );

        $this->add_control( 'general_thumb_heading',
            [
                'label' => esc_html__( 'THUMBNAIL', 'agrikon' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control( 'thumb_type',
            [
                'label' => esc_html__( 'Thumbnail Type', 'agrikon' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'image' => esc_html__( 'Default Image', 'agrikon' ),
                    'bg' => esc_html__( 'Background Image', 'agrikon' ),
                ],
                'default' => 'image',
            ]
        );
        $this->add_responsive_control( 'box_minh',
            [
                'label' => esc_html__( 'Max Height ( % )', 'agrikon' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'default' => 100,
                'selectors' => [
                    '{{WRAPPER}} .item--thumb-bg .post--bg-image' => 'padding-top: {{SIZE}}vh;',
                ],
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        ['name' => 'thumb_type','operator' => '==','value' => 'bg'],
                        [
                            'relation' => 'or',
                            'terms' => [
                                ['name' => 'type','operator' => '==','value' => 'classic'],
                                ['name' => 'type','operator' => '==','value' => 'classic2'],
                                ['name' => 'type','operator' => '==','value' => 'classic3']
                            ]
                        ]
                    ]
                ]
            ]
        );
        $this->add_responsive_control( 'box_minh2',
            [
                'label' => esc_html__( 'Max Height ( vh )', 'agrikon' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .item--thumb-bg .post--bg-image' => 'padding-top: calc( {{SIZE}}vh );',
                ],
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        ['name' => 'thumb_type','operator' => '==','value' => 'bg'],
                        ['name' => 'type','operator' => '!=','value' => 'classic'],
                        ['name' => 'type','operator' => '!=','value' => 'classic2'],
                        ['name' => 'type','operator' => '!=','value' => 'classic3']
                    ]
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'default' => 'large',
            ]
        );
        $this->add_control( 'scale_image',
            [
                'label' => esc_html__( 'Scale Image Type', 'agrikon' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => esc_html__( 'None', 'agrikon' ),
                    'out' => esc_html__( 'Scale Out', 'agrikon' ),
                    'in' => esc_html__( 'Scale In', 'agrikon' ),
                ],
                'default' => 'out',
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        ['name' => 'type','operator' => '!=','value' => 'split'],
                        ['name' => 'type','operator' => '!=','value' => 'split2'],
                    ]
                ]
            ]
        );
        $this->add_control( 'overlay_type',
            [
                'label' => esc_html__( 'Overlay Type', 'agrikon' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => esc_html__( 'None', 'agrikon' ),
                    'always' => esc_html__( 'Always Show', 'agrikon' ),
                    'on-hover' => esc_html__( 'On Hover', 'agrikon' ),
                ],
                'default' => 'on-hover',
            ]
        );
        $this->add_control( 'general_post_count_heading',
            [
                'label' => esc_html__( 'POST COUNT', 'agrikon' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control( 'post_per_page',
            [
                'label' => esc_html__( 'Posts Per Page', 'agrikon' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 1000,
                'default' => 6,
            ]
        );
        $this->add_control( 'general_slider_settings_heading',
            [
                'label' => esc_html__( 'SLIDER SETTINGS', 'agrikon' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control( 'perview',
            [
                'label' => esc_html__( 'Per View', 'agrikon' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 10,
                'step' => 1,
                'default' => 4,
            ]
        );
        $this->add_control( 'mdperview',
            [
                'label' => esc_html__( 'Per View Tablet', 'agrikon' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 10,
                'step' => 1,
                'default' => 2
            ]
        );
        $this->add_control( 'smperview',
            [
                'label' => esc_html__( 'Per View Phone', 'agrikon' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 10,
                'step' => 1,
                'default' => 1
            ]
        );
        $this->add_control( 'speed',
            [
                'label' => esc_html__( 'Speed', 'agrikon' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 10000,
                'step' => 100,
                'default' => 1000,
                'separator' => 'before',
            ]
        );
        $this->add_control( 'navigation',
            [
                'label' => esc_html__( 'Arrows', 'agrikon' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control( 'scrollbar',
            [
                'label' => esc_html__( 'Scrollbar', 'agrikon' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );
        $this->add_control( 'loop',
            [
                'label' => esc_html__( 'Loop', 'agrikon' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control( 'autoplay',
            [
                'label' => esc_html__( 'Autoplay', 'agrikon' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );
        $this->add_control( 'mousewheel',
            [
                'label' => esc_html__( 'Mousewheel', 'agrikon' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );
        $this->add_control( 'hoverstop',
            [
                'label' => esc_html__( 'Stop Hover', 'agrikon' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control( 'coverflow',
            [
                'label' => esc_html__( 'Coverflow Effect', 'agrikon' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );
        $this->add_control( 'rotate',
            [
                'label' => esc_html__( 'Rotate', 'agrikon' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 100,
                'default' => 30,
                'condition' => ['coverflow' => 'yes'],
            ]
        );
        $this->add_control( 'depth',
            [
                'label' => esc_html__( 'Depth', 'agrikon' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 200,
                'default' => 100,
                'condition' => ['coverflow' => 'yes'],
            ]
        );
        $this->add_control( 'centered',
            [
                'label' => esc_html__( 'Centered', 'agrikon' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => ['coverflow' => 'yes'],
            ]
        );
        $this->add_control( 'sgap',
            [
                'label' => esc_html__( 'Gap', 'agrikon' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'default' => 15,
            ]
        );
        $this->add_control( 'overflow_type',
            [
                'label' => esc_html__( 'Overflow', 'agrikon' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'hidden' => esc_html__( 'Hidden', 'agrikon' ),
                    'visible' => esc_html__( 'Visible', 'agrikon' ),
                ],
                'default' => 'visible',
                'condition' => ['coverflow' => 'yes'],
                'selectors' => ['{{WRAPPER}}' => 'overflow:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'general_slider_container_heading',
            [
                'label' => esc_html__( 'SLIDER CONTAINER', 'agrikon' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->agrikon_style_padding( 'slider_container_padding','{{WRAPPER}} .blog--slider-wrapper .swiper-container' );
        $this->add_responsive_control( 'slider_container_minheight',
            [
                'label' => esc_html__( 'Min Height', 'agrikon' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px','%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100
                    ],
                    'px' => [
                        'min' => 100,
                        'max' => 2000
                    ]
                ],
                'selectors' => ['{{WRAPPER}}  .blog--slider-wrapper .swiper-container' => 'min-height: {{SIZE}}{{UNIT}};'],
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/

        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section( 'blog_query_section',
            [
                'label' => esc_html__( 'Query', 'agrikon' ),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );
        $this->add_control( 'author_filter_heading',
            [
                'label' => esc_html__( 'Author Filter', 'agrikon' ),
                'type' => Controls_Manager::HEADING
            ]
        );
        $this->add_control( 'author_include',
            [
                'label' => esc_html__( 'Author', 'agrikon' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->agrikon_get_users(),
                'description' => 'Select Author(s)'
            ]
        );
        $this->add_control( 'author_exclude',
            [
                'label' => esc_html__( 'Exclude Author', 'agrikon' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->agrikon_get_users(),
                'description' => 'Select Author(s) to Exclude',
                'separator' => 'after'
            ]
        );
        $this->add_control( 'category_filter_heading',
            [
                'label' => esc_html__( 'Category Filter', 'agrikon' ),
                'type' => Controls_Manager::HEADING
            ]
        );
        $this->add_control( 'category_include',
            [
                'label' => esc_html__( 'Category', 'agrikon' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->agrikon_get_categories(),
                'description' => 'Select Category(s)'
            ]
        );
        $this->add_control( 'category_exclude',
            [
                'label' => esc_html__( 'Exclude Category', 'agrikon' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->agrikon_get_categories(),
                'description' => 'Select Category(s) to Exclude',
                'separator' => 'after'
            ]
        );
        $this->add_control( 'tag_filter_heading',
            [
                'label' => esc_html__( 'Tag Filter', 'agrikon' ),
                'type' => Controls_Manager::HEADING
            ]
        );
        $this->add_control( 'tag_include',
            [
                'label' => esc_html__( 'Tag', 'agrikon' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->agrikon_get_tags(),
                'description' => 'Select Tag(s)'
            ]
        );
        $this->add_control( 'tag_exclude',
            [
                'label' => esc_html__( 'Exclude Tag', 'agrikon' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->agrikon_get_tags(),
                'description' => 'Select Tag(s) to Exclude',
                'separator' => 'after'
            ]
        );
        $this->add_control( 'post_filter_heading',
            [
                'label' => esc_html__( 'Post Filter', 'agrikon' ),
                'type' => Controls_Manager::HEADING
            ]
        );
        $this->add_control( 'post_include',
            [
                'label' => esc_html__( 'Specific Post(s)', 'agrikon' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->agrikon_get_posts(),
                'description' => 'Select Specific Post(s)'
            ]
        );
        $this->add_control( 'post_exclude',
            [
                'label' => esc_html__( 'Exclude Post', 'agrikon' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->agrikon_get_posts(),
                'description' => 'Select Post(s) to Exclude',
                'separator' => 'after'
            ]
        );
        $this->add_control( 'post_other_heading',
            [
                'label' => esc_html__( 'Other Filter', 'agrikon' ),
                'type' => Controls_Manager::HEADING
            ]
        );
        $this->add_control( 'offset',
            [
                'label' => esc_html__( 'Offset', 'agrikon' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1000
            ]
        );
        $this->add_control( 'order',
            [
                'label' => esc_html__( 'Select Order', 'agrikon' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'ASC' => 'Ascending',
                    'DESC' => 'Descending'
                ],
                'default' => 'ASC'
            ]
        );
        $this->add_control( 'orderby',
            [
                'label' => esc_html__( 'Order By', 'agrikon' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => 'None',
                    'ID' => 'Post ID',
                    'author' => 'Author',
                    'title' => 'Title',
                    'name' => 'Slug',
                    'date' => 'Date',
                    'modified' => 'Last Modified Date',
                    'parent' => 'Post Parent ID',
                    'rand' => 'Random',
                    'comment_count' => 'Number of Comments',
                ],
                'default' => 'none'
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/

        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section( 'post_options_section',
            [
                'label' => esc_html__( 'Post Options', 'agrikon' ),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );
        $this->add_control( 'hidethumb',
            [
                'label' => esc_html__( 'Hide Thumbnail', 'agrikon' ),
                'type' => Controls_Manager::SWITCHER,
            ]
        );
        $this->add_control( 'hidetitle',
            [
                'label' => esc_html__( 'Hide Title', 'agrikon' ),
                'type' => Controls_Manager::SWITCHER,
            ]
        );
        $this->add_control( 'hidechar',
            [
                'label' => esc_html__( 'Hide First Letter', 'agrikon' ),
                'type' => Controls_Manager::SWITCHER,
            ]
        );
        $this->add_control( 'hidecats',
            [
                'label' => esc_html__( 'Hide Category', 'agrikon' ),
                'type' => Controls_Manager::SWITCHER,
            ]
        );
        $this->add_control( 'cats_sep',
            [
                'label' => esc_html__( 'Category Separator', 'agrikon' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
                'condition' => ['hidecats!' => 'yes']
            ]
        );
        $this->add_control( 'hideestimate',
            [
                'label' => esc_html__( 'Hide Estimate', 'agrikon' ),
                'type' => Controls_Manager::SWITCHER,
            ]
        );
        $this->add_control( 'hideavatar',
            [
                'label' => esc_html__( 'Hide Author Avatar', 'agrikon' ),
                'type' => Controls_Manager::SWITCHER,
            ]
        );
        $this->add_control( 'hideauthor',
            [
                'label' => esc_html__( 'Hide Author', 'agrikon' ),
                'type' => Controls_Manager::SWITCHER,
            ]
        );
        $this->add_control( 'before_author',
            [
                'label' => esc_html__( 'Author Before', 'agrikon' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Posted by',
                'label_block' => true,
                'condition' => ['hideauthor!' => 'yes']
            ]
        );
        $this->add_control( 'hidedate',
            [
                'label' => esc_html__( 'Hide Date', 'agrikon' ),
                'type' => Controls_Manager::SWITCHER,
            ]
        );
        $this->add_control( 'hideexcerpt',
            [
                'label' => esc_html__( 'Hide Excerpt', 'agrikon' ),
                'type' => Controls_Manager::SWITCHER,
            ]
        );
        $this->add_control( 'excerpt_limit',
            [
                'label' => esc_html__( 'Excerpt Word Limit', 'agrikon' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'default' => 20,
                'condition' => ['hideexcerpt!' => 'yes']
            ]
        );
        $this->add_control( 'hidebtn',
            [
                'label' => esc_html__( 'Hide Button', 'agrikon' ),
                'type' => Controls_Manager::SWITCHER,
            ]
        );
        $this->add_control( 'btn_title',
            [
                'label' => esc_html__( 'Read More Title', 'agrikon' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Read more',
                'label_block' => true,
                'condition' => ['hidebtn!' => 'yes']
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/

        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section( 'post_fast_style_section',
            [
                'label'=> esc_html__( 'Fast Color', 'agrikon' ),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );
        $this->add_control( 'general_box_item',
            [
                'label' => esc_html__( 'GENERAL', 'agrikon' ),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_control( 'item_box_color',
            [
                'label' => esc_html__( 'Box Background Color', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .box--grid' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'item_overlay_color',
            [
                'label' => esc_html__( 'Overlay Color', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .post--thumb:after' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'hover_link_color',
            [
                'label' => esc_html__( 'Link Hover Color', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .blog--layout-grid a:hover, {{WRAPPER}} .blog--layout-grid .post--btn-more:hover' => 'color:{{VALUE}}!important;' ]
            ]
        );
        $this->add_responsive_control( 'alignment',
            [
                'label' => esc_html__( 'Alignment', 'agrikon' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'agrikon' ),
                        'icon' => 'fa fa-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'agrikon' ),
                        'icon' => 'fa fa-align-center'
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'agrikon' ),
                        'icon' => 'fa fa-align-right'
                    ]
                ],
                'toggle' => true,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .post--content-wrapper' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .post--btn-more' => 'justify-content: {{VALUE}};',
                ]
            ]
        );
        $this->add_responsive_control( 'btn_alignment',
            [
                'label' => esc_html__( 'Button Alignment', 'agrikon' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Left', 'agrikon' ),
                        'icon' => 'fa fa-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'agrikon' ),
                        'icon' => 'fa fa-align-center'
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Right', 'agrikon' ),
                        'icon' => 'fa fa-align-right'
                    ]
                ],
                'toggle' => true,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .post--btn-more' => 'max-width: 100%;justify-content: {{VALUE}};',
                ]
            ]
        );
        $this->start_controls_tabs('item_normal_tabs');
        $this->start_controls_tab( 'item_normal_tab',
            [ 'label' => esc_html__( 'Normal', 'agrikon' ) ]
        );
        $this->add_control( 'item_date_color',
            [
                'label' => esc_html__( 'Date Color', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .post--author-details,{{WRAPPER}} .post--date-stroked' => 'color:{{VALUE}};', ],
                'condition' => ['hidedate!' => 'yes']
            ]
        );
        $this->add_control( 'item_dateday_color',
            [
                'label' => esc_html__( 'Date Day Color ( Minimal )', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .date--day' => '-webkit-text-stroke-color:{{VALUE}};',
                    '{{WRAPPER}} .blog--layout-grid:hover .date--day' => 'color:{{VALUE}};',
                ],
                'condition' => ['hidedate!' => 'yes']
            ]
        );
        $this->add_control( 'item_authname_color',
            [
                'label' => esc_html__( 'Author Name Color', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .post--author-details .post--author b' => 'color:{{VALUE}};', ],
                'condition' => ['hideauthor!' => 'yes']
            ]
        );
        $this->add_control( 'item_char_color',
            [
                'label' => esc_html__( 'Char Color', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .title--char' => '-webkit-text-stroke-color:{{VALUE}};',
                    '{{WRAPPER}} .title--char:before' => 'color:{{VALUE}};',
                ],
                'condition' => ['hidechar!' => 'yes']
            ]
        );
        $this->add_control( 'item_cats_color',
            [
                'label' => esc_html__( 'Category Color', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .post--category' => 'color:{{VALUE}};', ],
                'condition' => ['hidecats!' => 'yes']
            ]
        );
        $this->add_control( 'item_estimate_color',
            [
                'label' => esc_html__( 'Estimate Color', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .post--estimate' => 'color:{{VALUE}};', ],
                'condition' => ['hideestimate!' => 'yes']
            ]
        );
        $this->add_control( 'item_estimate_sep_color',
            [
                'label' => esc_html__( 'Estimate Separator Color', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .post--estimate:before' => 'color:{{VALUE}};', ],
                'condition' => ['hideestimate!' => 'yes']
            ]
        );
        $this->add_control( 'item_title_color',
            [
                'label' => esc_html__( 'Title Color', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .post--heading' => 'color:{{VALUE}};', ],
                'condition' => ['hidetitle!' => 'yes']
            ]
        );
        $this->add_control( 'item_excerpt_color',
            [
                'label' => esc_html__( 'Excerpt Color', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .post--excerpt' => 'color:{{VALUE}};', ],
                'condition' => ['hideexcerpt!' => 'yes']
            ]
        );
        $this->add_control( 'item_btn_color',
            [
                'label' => esc_html__( 'Button Color', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .post--btn-more' => 'color:{{VALUE}};' ],
                'condition' => ['hidebtn!' => 'yes']
            ]
        );
        $this->add_control( 'item_btn_arrow_color',
            [
                'label' => esc_html__( 'Button Arrow Color', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .post--btn-more i' => 'color:{{VALUE}};' ],
                'condition' => ['hidebtn!' => 'yes']
            ]
        );
        $this->add_control( 'btn_point_color',
            [
                'label' => esc_html__( 'Button Point Color', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .post--btn-point:after, {{WRAPPER}} .post--btn-point:before' => 'background-color:{{VALUE}};',
                    '{{WRAPPER}} .blog--layout-grid .post--btn-point:after' => 'opacity:0.3;',
                ],
                'condition' => ['hidebtn!' => 'yes']
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab( 'item_hover_tab',
            [ 'label' => esc_html__( 'Hover', 'agrikon' ) ]
        );
        $this->add_control( 'item_hover_date_color',
            [
                'label' => esc_html__( 'Date Color', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .post--author-details' => 'color:{{VALUE}};', ],
                'condition' => ['hidedate!' => 'yes']
            ]
        );
        $this->add_control( 'item_hover_author_color',
            [
                'label' => esc_html__( 'Author Name Color', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .post--author-details .post--author b' => 'color:{{VALUE}};', ],
                'condition' => ['hideauthor!' => 'yes']
            ]
        );
        $this->add_control( 'item_hover_cats_color',
            [
                'label' => esc_html__( 'Category Color', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .blog--layout-grid:hover .post--category' => 'color:{{VALUE}};', ],
                'condition' => ['hidecats!' => 'yes']
            ]
        );
        $this->add_control( 'item_hover_estimate_color',
            [
                'label' => esc_html__( 'Estimate Color', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .blog--layout-grid:hover .post--estimate' => 'color:{{VALUE}};', ],
                'condition' => ['hideestimate!' => 'yes']
            ]
        );
        $this->add_control( 'item_hover_estimate_sep_color',
            [
                'label' => esc_html__( 'Estimate Separator Color', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .blog--layout-grid:hover .post--estimate:before' => 'color:{{VALUE}};', ],
                'condition' => ['hideestimate!' => 'yes']
            ]
        );
        $this->add_control( 'item_hover_title_color',
            [
                'label' => esc_html__( 'Title Color', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .blog--layout-grid:hover .post--heading' => 'color:{{VALUE}};', ],
                'condition' => ['hidetitle!' => 'yes']
            ]
        );
        $this->add_control( 'item_hover_excerpt_color',
            [
                'label' => esc_html__( 'Excerpt Color', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [ '{{WRAPPER}} .blog--layout-grid:hover .post--excerpt' => 'color:{{VALUE}};', ],
                'condition' => ['hideexcerpt!' => 'yes']
            ]
        );
        $this->add_control( 'item_hover_btn_color',
            [
                'label' => esc_html__( 'Button Color', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .blog--layout-grid:hover .post--btn-more' => 'color:{{VALUE}};' ],
                'condition' => ['hidebtn!' => 'yes']
            ]
        );
        $this->add_control( 'item_hover_btn_arrow_color',
            [
                'label' => esc_html__( 'Button Arrow Color', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .blog--layout-grid .post--btn-more:hover i' => 'color:{{VALUE}};' ],
                'condition' => ['hidebtn!' => 'yes']
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/

        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section( 'post_advanced_style_section',
            [
                'label'=> esc_html__( 'Advanced Style', 'agrikon' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control( 'post_box_heading',
            [
                'label' => esc_html__( 'BOX', 'agrikon' ),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->agrikon_style_border( 'post_box_border','{{WRAPPER}} .blog--layout-grid' );
        $this->agrikon_style_box_shadow( 'post_box_shadow','{{WRAPPER}} .blog--layout-grid' );
        $this->add_control( 'post_text_content_heading',
            [
                'label' => esc_html__( 'TEXT CONTENT', 'agrikon' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->agrikon_style_border( 'post_text_content_border','{{WRAPPER}} .post--content-wrapper' );
        $this->agrikon_style_padding( 'post_text_content_padding','{{WRAPPER}} .post--content-wrapper' );
        $this->agrikon_style_margin( 'post_text_content_margin','{{WRAPPER}} .post--content-wrapper' );
        $this->agrikon_style_box_shadow( 'post_text_content_shadow','{{WRAPPER}} .post--content-wrapper' );
        $this->add_control( 'post_author_heading',
            [
                'label' => esc_html__( 'AUTHOR AVATAR', 'agrikon' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control( 'post_author_size',
            [
                'label' => esc_html__( 'Size', 'agrikon' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100
                    ]
                ],
                'default' => [''],
                'selectors' => ['{{WRAPPER}} .post--meta-author .avatar' => 'width: {{SIZE}};height: {{SIZE}};'],
            ]
        );
        $this->agrikon_style_border( 'post_author_border','{{WRAPPER}} .post--meta-author .avatar' );
        $this->agrikon_style_box_shadow( 'post_author_shadow','{{WRAPPER}} .post--meta-author .avatar' );
        $this->add_control( 'post_author_details_heading',
            [
                'label' => esc_html__( 'AUTHOR DETAILS', 'agrikon' ),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->agrikon_style_typo( 'post_author_typo','{{WRAPPER}} .post--author-details' );
        $this->agrikon_style_margin( 'post_author_margin','{{WRAPPER}} .post--author-details' );
        $this->add_control( 'post_cats_heading',
            [
                'label' => esc_html__( 'CATEGORY', 'agrikon' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->agrikon_style_typo( 'post_cats_typo','{{WRAPPER}} .post--category' );
        $this->agrikon_style_margin( 'post_cats_margin','{{WRAPPER}} .post--category' );
        $this->add_control( 'post_estimate_heading',
            [
                'label' => esc_html__( 'ESTIMATE', 'agrikon' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->agrikon_style_typo( 'post_estimate_typo','{{WRAPPER}} .post--estimate' );
        $this->agrikon_style_margin( 'post_estimate_margin','{{WRAPPER}} .post--estimate' );
        $this->add_control( 'post_title_heading',
            [
                'label' => esc_html__( 'TITLE', 'agrikon' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->agrikon_style_typo( 'post_title_typo','{{WRAPPER}} .blog--layout-grid .post--heading' );
        $this->agrikon_style_margin( 'post_title_margin','{{WRAPPER}} .blog--layout-grid .post--heading' );
        $this->add_control( 'post_excerpt_heading',
            [
                'label' => esc_html__( 'EXCERPT', 'agrikon' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->agrikon_style_typo( 'post_excerpt_typo','{{WRAPPER}} .post--excerpt' );
        $this->agrikon_style_margin( 'post_excerpt_margin','{{WRAPPER}} .post--excerpt' );
        $this->add_control( 'post_btn_heading',
            [
                'label' => esc_html__( 'BUTTON', 'agrikon' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->agrikon_style_typo( 'post_btn_typo','{{WRAPPER}} .post--btn-more' );
        $this->agrikon_style_margin( 'post_btn_margin','{{WRAPPER}} .post--btn-more' );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/

        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('scrollbar_style_section',
            [
                'label'=> esc_html__( 'Scrollbar Style', 'agrikon' ),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => ['scrollbar' => 'yes']
            ]
        );
        $this->add_control( 'hidescrollbar',
            [
                'label' => esc_html__( 'Hide', 'agrikon' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_responsive_control( 'scrollbar_rail_width',
            [
                'label' => esc_html__( 'Scrollbar Max Width', 'agrikon' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px','%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100
                    ],
                    'px' => [
                        'min' => 100,
                        'max' => 2000
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .swiper-scrollbar' => 'width: {{SIZE}}{{UNIT}};'],
            ]
        );
        $this->add_control( 'scrollbar_height',
            [
                'label' => esc_html__( 'Scrollbar Height', 'agrikon' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => 5,
                'selectors' => ['{{WRAPPER}} .swiper-scrollbar' => 'height:{{SIZE}}px;' ],
            ]
        );
        $this->add_control( 'scrollbar_rail_color',
            [
                'label' => esc_html__( 'Scrollbar Rail Color', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .swiper-scrollbar' => 'background-color:{{VALUE}};' ],
            ]
        );
        $this->add_control( 'scrollbar_color',
            [
                'label' => esc_html__( 'Scrollbar Color', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .swiper-scrollbar-drag' => 'background-color:{{VALUE}};' ],
            ]
        );
        $this->agrikon_style_border( 'scrollbar_border','{{WRAPPER}} .swiper-scrollbar' );
        $this->add_control('scrollbar_margin_vertical',
            [
                'label' => esc_html__( 'Margin', 'plugin-domain' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'allowed_dimensions' => 'vertical',
                'selectors' => ['{{WRAPPER}} .swiper-scrollbar' => 'margin: {{TOP}}{{UNIT}} auto {{BOTTOM}}{{UNIT}} auto;'],
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/

        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('arrows_style_section',
            [
                'label'=> esc_html__( 'Arrows Style', 'agrikon' ),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => ['navigation' => 'yes']
            ]
        );

        $this->add_control( 'nav_vert_pos',
            [
                'label' => esc_html__( 'Vertical Position', 'agrikon' ),
                'type' => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => esc_html__( 'Top', 'agrikon' ),
						'icon' => 'eicon-v-align-top'
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'agrikon' ),
						'icon' => 'eicon-v-align-bottom'
					]
				],
				'default' => 'bottom',
				'toggle' => false,
            ]
        );
        $this->add_responsive_control( 'nav_horz_pos',
            [
                'label' => esc_html__( 'Horizontal Position', 'agrikon' ),
                'type' => Controls_Manager::CHOOSE,
                'selectors' => ['{{WRAPPER}} .blog--slider-wrapper .swiper-nav-wrapper' => 'justify-content: {{VALUE}};'],
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'agrikon' ),
						'icon' => 'eicon-h-align-left'
					],
					'center' => [
						'title' => esc_html__( 'Center', 'agrikon' ),
						'icon' => 'eicon-h-align-center'
					],
					'flex-end' => [
						'title' => esc_html__( 'Right', 'agrikon' ),
						'icon' => 'eicon-h-align-right'
					],
				],
				'default' => 'center',
				'toggle' => false,
            ]
        );
        $this->agrikon_style_margin( 'nav_margin','{{WRAPPER}} .blog--slider-wrapper .swiper-nav-wrapper' );
        $this->agrikon_style_padding( 'nav_padding','{{WRAPPER}} .blog--slider-wrapper .swiper-nav-wrapper' );
        $this->add_control( 'arrows_heading',
            [
                'label' => esc_html__( 'ARROWS', 'agrikon' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_responsive_control( 'arrows_width',
            [
                'label' => esc_html__( 'Width', 'agrikon' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 1000
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => ['{{WRAPPER}} .swiper-nav-ctrl' => 'width: {{SIZE}}px;'],
            ]
        );
        $this->add_responsive_control( 'arrows_height',
            [
                'label' => esc_html__( 'Height', 'agrikon' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .swiper-nav-ctrl' => 'height: {{SIZE}}px;'],
            ]
        );
        $this->add_responsive_control( 'arrows_space',
            [
                'label' => esc_html__( 'Space Between', 'agrikon' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .swiper-nav-ctrl.prev-ctrl' => 'margin-right: {{SIZE}}px;'],
            ]
        );
        $this->start_controls_tabs('arrows_tabs');
        $this->start_controls_tab( 'arrows_normal_tab',
            [ 'label' => esc_html__( 'Normal', 'agrikon' ) ]
        );
        $this->agrikon_style_border( 'arrows_border','{{WRAPPER}} .swiper-nav-ctrl' );
        $this->add_control( 'arrows_color',
            [
                'label' => esc_html__( 'Color', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .swiper-nav-ctrl' => 'color: {{VALUE}};']
            ]
        );
        $this->add_control( 'arrows_bgcolor',
            [
                'label' => esc_html__( 'Background', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .swiper-nav-ctrl' => 'background-color: {{VALUE}};']
            ]
        );
        $this->add_responsive_control( 'arrows_size',
            [
                'label' => esc_html__( 'Icon Size', 'agrikon' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .swiper-nav-ctrl i' => 'font-size: {{SIZE}}px;'],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab('arrows_hover_tab',
            [ 'label' => esc_html__( 'Hover', 'agrikon' ) ]
        );
        $this->agrikon_style_border( 'arrows_hvrborder','{{WRAPPER}} .swiper-nav-ctrl:hover' );
        $this->add_control( 'arrows_hvrcolor',
            [
                'label' => esc_html__( 'Color', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .swiper-nav-ctrl:hover' => 'color: {{VALUE}};']
            ]
        );
        $this->add_control( 'arrows_hvrbgcolor',
            [
                'label' => esc_html__( 'Background', 'agrikon' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .swiper-nav-ctrl:hover' => 'background-color: {{VALUE}};']
            ]
        );
        $this->add_responsive_control( 'arrows_hvrsize',
            [
                'label' => esc_html__( 'Icon Size', 'agrikon' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .swiper-nav-ctrl:hover i' => 'font-size: {{SIZE}}px;'],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_control( 'arrows_prev_heading',
            [
                'label' => esc_html__( 'PREV POSITION', 'agrikon' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_responsive_control( 'arrows_prev_top_position',
            [
                'label' => esc_html__( 'Top Offset', 'agrikon' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px','%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 2000
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .swiper-nav-ctrl.prev-ctrl' => 'top: {{SIZE}}{{UNIT}};position:absolute;'],
            ]
        );
        $this->add_responsive_control( 'arrows_prev_bottom_position',
            [
                'label' => esc_html__( 'Bottom Offset', 'agrikon' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px','%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 2000
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .swiper-nav-ctrl.prev-ctrl' => 'bottom: {{SIZE}}{{UNIT}};position:absolute;'],
            ]
        );
        $this->add_responsive_control( 'arrows_prev_left_position',
            [
                'label' => esc_html__( 'Left Offset', 'agrikon' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px','%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 2000
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .swiper-nav-ctrl.prev-ctrl' => 'left: {{SIZE}}{{UNIT}};position:absolute;'],
            ]
        );
        $this->add_responsive_control( 'arrows_prev_right_position',
            [
                'label' => esc_html__( 'Right Offset', 'agrikon' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px','%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 2000
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .swiper-nav-ctrl.prev-ctrl' => 'right: {{SIZE}}{{UNIT}};position:absolute;'],
            ]
        );
        $this->add_control( 'arrows_next_heading',
            [
                'label' => esc_html__( 'NEXT POSITION', 'agrikon' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_responsive_control( 'arrows_next_top_position',
            [
                'label' => esc_html__( 'Top Offset', 'agrikon' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px','%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 2000
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .swiper-nav-ctrl.next-ctrl' => 'top: {{SIZE}}{{UNIT}};position:absolute;'],
            ]
        );
        $this->add_responsive_control( 'arrows_next_bottom_position',
            [
                'label' => esc_html__( 'Bottom Offset', 'agrikon' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px','%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 2000
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .swiper-nav-ctrl.next-ctrl' => 'bottom: {{SIZE}}{{UNIT}};position:absolute;'],
            ]
        );
        $this->add_responsive_control( 'arrows_next_left_position',
            [
                'label' => esc_html__( 'Left Offset', 'agrikon' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px','%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 2000
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .swiper-nav-ctrl.next-ctrl' => 'left: {{SIZE}}{{UNIT}};position:absolute;'],
            ]
        );
        $this->add_responsive_control( 'arrows_next_right_position',
            [
                'label' => esc_html__( 'Right Offset', 'agrikon' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px','%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 2000
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .swiper-nav-ctrl.next-ctrl' => 'right: {{SIZE}}{{UNIT}};position:absolute;'],
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
    }
    //estimated reading time
    public function reading_time( $pid ) {
        $content = get_post_field( 'post_content', $pid );
        $word_count = str_word_count( strip_tags( $content ) );
        $readingtime = ceil( $word_count / 200);
        $timer = " min read";
        $totalreadingtime = $readingtime . $timer;
        return $totalreadingtime;
    }
    //estimated reading time
    public function post_author() {
        $settings = $this->get_settings_for_display();
        $html = '';
        if ( 'yes' != $settings[ 'hideavatar' ] || 'yes' != $settings[ 'hideauthor' ] || 'yes' != $settings[ 'hidedate' ] ) {
            $html .= '<div class="post--meta-author">';
                if ( 'yes' != $settings[ 'hideavatar' ] ) {
                    $html .= get_avatar( get_the_author_meta( 'ID' ), 50 );
                }
                if ( 'yes' != $settings[ 'hideauthor' ] || 'yes' != $settings[ 'hidedate' ] ) {
                    $html .= '<div class="post--author-details">';
                        if ( 'yes' != $settings[ 'hideauthor' ] ) {
                            $before_author = $settings['before_author'] ? $settings['before_author'] : '';
                            $html .= '<div class="post--author">'.$before_author.' <b>'.get_the_author().'</b></div>';
                        }
                        if ( 'minimal2' != $settings[ 'type' ] ) {
                            if ( 'yes' != $settings[ 'hidedate' ] ) {
                                $html .= '<span class="post--date">'.get_the_date().'</span>';
                            }
                        }
                    $html .= '</div>';
                }
            $html .= '</div>';
        }
        return $html;
    }
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $id = $this->get_id();
        $type = $settings[ 'type' ];
        $attrtype = preg_match("/minimal/i", $type ) ? 'minimal '.$type : $type;
        $is_editor = \Elementor\Plugin::$instance->editor->is_edit_mode() ? true : false;
        $html = '';

        $args = array(
            'post_type'        => 'post',
            'author__in'       => $settings['author_include'],
            'author__not_in'   => $settings['author_exclude'],
            'category__in'     => $settings['category_include'],
            'category__not_in' => $settings['category_exclude'],
            'tag__in'          => $settings['tag_include'],
            'tag__not_in'      => $settings['tag_exclude'],
            'post__in'         => $settings['post_include'],
            'post__not_in'     => $settings['post_exclude'],
            'posts_per_page'   => $settings['post_per_page'],
            'offset'           => $settings['offset'],
            'order'            => $settings['order'],
            'orderby'          => $settings['orderby'],
        );

        $size = $settings['thumbnail_size'] ? $settings['thumbnail_size'] : 'full';
        if ( 'custom' == $size ) {
            $sizew = $settings['thumbnail_custom_dimension']['width'];
            $sizeh = $settings['thumbnail_custom_dimension']['height'];
            $size = [ $sizew, $sizeh ];
        }

        $classes[] = 'box--grid box--'.$attrtype;
        $classes[] .= 'swiper-slide item--grid slide--item-'.$attrtype;
        $classes[] .= 'item--thumb-'.$settings[ 'thumb_type' ];
        $classes[] .= 'item--scale-image-'.$settings[ 'scale_image' ];
        $classes[] .= 'item--overlay-'.$settings[ 'overlay_type' ];

        $sattr = array();
        $sattr[] = $settings['speed'] ? '"speed":'.$settings['speed'] : '"speed":1000';
        $sattr[] = $settings['perview'] ? '"perview":'.$settings['perview'] : '"perview":4';
        $sattr[] = $settings['mdperview'] ? '"mdperview":'.$settings['mdperview'] : '"speed":3';
        $sattr[] = $settings['smperview'] ? '"smperview":'.$settings['smperview'] : '"smperview":2';
        $sattr[] = $settings['sgap'] ? '"gap":'.$settings['sgap'] : '"gap":15';
        $sattr[] = 'yes' == $settings['loop'] ? '"loop":true' : '"loop":false';
        $sattr[] = 'yes' == $settings['autoplay'] ? '"autoplay":true' : '"autoplay":false';
        $sattr[] = 'yes' == $settings['mousewheel'] ? '"mousewheel":true' : '"mousewheel":false';
        $sattr[] = 'yes' == $settings['hoverstop'] ? '"hoverstop":true' : '"hoverstop":false';
        $sattr[] = 'yes' == $settings['coverflow'] ? '"coverflow":true' : '"coverflow":false';
        $sattr[] = 'yes' == $settings['centered'] ? '"centered":true' : '"centered":false';
        $sattr[] = 'yes' == $settings['hidescrollbar'] ? '"hidescrollbar":true' : '"hidescrollbar":false';
        $sattr[] = $settings['rotate'] ? '"rotate":'.$settings['rotate'] : '"rotate":30';
        $sattr[] = $settings['depth'] ? '"depth":'.$settings['depth'] : '"depth":100';

        $the_query = new \WP_Query( $args );
        if ( $the_query->have_posts() ) {

            while ($the_query->have_posts()) {
                $the_query->the_post();

                    $postclasses = get_post_class( '', get_the_ID() );
                    $classes = array_merge( $classes, $postclasses );

                    $html .= '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">';

                        $html .= '<div class="blog--layout-grid">';

                            if ( ( 'minimal2' == $type || 'minimal4' == $type ) && 'yes' != $settings[ 'hidedate' ] ) {
                                $html .= '<span class="post--date-stroked">';
                                    $html .= '<span class="date--day">'.get_the_date('d').'</span>';
                                    $html .= '<span class="date--small">';
                                        $html .= '<span class="date--month">'.get_the_date('M').'</span> / ';
                                        $html .= '<span class="date--year">'.get_the_date('Y').'</span>';
                                    $html .= '</span>';
                                $html .= '</span>';
                            }

                            if ( ( 'minimal3' == $type || 'minimal5' == $type ) && 'yes' != $settings[ 'hidechar' ] ) {

                                $html .= '<span class="title--char-wrapper">';
                                    $html .= '<span class="title--char" data-char="'.substr( get_the_title(), 0, 1 ).'">';
                                        $html .= substr( get_the_title(), 0, 1 );
                                    $html .= '</span>';
                                $html .= '</span>';
                            }

                            if ( 'classic2' == $type || 'minimal2' == $type || 'minimal3' == $type ) {
                                $html .= $this->post_author();
                            }

                            if ( has_post_thumbnail() && 'yes' != $settings[ 'hidethumb' ] ) {
                                $bgurl = get_the_post_thumbnail_url( get_the_ID(), $size );
                                $bgimage = $is_editor ? ' style="background-image:url('.$bgurl.')"' : ' data-agrikon-bg-src="'.$bgurl.'"';
                                $html .= '<a class="post--link" href="'.get_permalink().'">';
                                    $html .= '<figure class="post--thumb">';
                                        if ( 'bg' == $settings[ 'thumb_type' ] ) {
                                            $html .= '<div class="post--bg-image"'.$bgimage.'></div>';
                                        } else {
                                            $html .= get_the_post_thumbnail( get_the_ID(), $size, array( 'class' => 'post--image' ) );
                                        }
                                        if ( 'classic' == $type || 'split' == $type || 'minimal' == $type ) {
                                            $html .= $this->post_author();
                                        }
                                    $html .= '</figure>';
                                $html .= '</a>';
                            }

                            $html .= '<div class="post--content-wrapper">';
                                if ( 'classic3' == $type ) {
                                    $html .= $this->post_author();
                                }
                                $html .= '<div class="post--content">';
                                    if ( 'yes' != $settings[ 'hidecats' ] ) {
                                        $cats_sep = $settings[ 'cats_sep' ] ? $settings[ 'cats_sep' ] : ', ';
                                        $html .= '<div class="post--category">';
                                            ob_start();
                                            the_category( $cats_sep );
                                        $html .= ob_get_clean();
                                        if ( 'yes' != $settings[ 'hideestimate' ] ) {
                                            $html .= '<span class="post--estimate">'.$this->reading_time(get_the_ID()).'</span>';
                                        }
                                        $html .= '</div>';
                                    }
                                    if ( 'yes' != $settings[ 'hidetitle' ] ) {
                                        $html .= '<h3 class="post--heading"><a href="'.get_permalink().'">'.get_the_title().' </a></h3>';
                                    }
                                    if ( !preg_match("/minimal/i", $type ) && 'yes' != $settings[ 'hideexcerpt' ] ) {
                                        $html .= '<p class="post--excerpt">'.wp_trim_words( get_the_excerpt(), $settings['excerpt_limit'] ).'</p>';
                                    }

                                    if ( 'yes' != $settings[ 'hidebtn' ] ) {
                                        $btn_title = $settings[ 'btn_title' ] ? $settings[ 'btn_title' ] : esc_html__('Read more', 'agrikon');
                                        $html .= '<a href="'.get_permalink().'" class="post--btn-more type--circle"><span class="post--btn-point"></span>'.$btn_title;
                                            $html .= '<i class="post--btn-icon"><svg class="arrow-icon"
                                            width="16"
                                            height="16"
                                            viewBox="0 0 16 16"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"><path d="M0 8H15M15 8L8.5 1.5M15 8L8.5 14.5"
                                            stroke-width="2"
                                            stroke-linejoin="round"></path></svg></i>';
                                        $html .= '</a>';
                                    }

                                $html .= '</div>';
                            $html .= '</div>';

                        $html .= '</div>';
                    $html .= '</div>'; // column
                }
                wp_reset_postdata();

            // print html
            echo '<div class="blog--slider-wrapper" data-slider-settings=\'{'.implode(',',$sattr).'}\'>';
                echo '<div id="blog--slider-'.$id.'" class="swiper-container">';

                    if ( 'top' == $settings[ 'nav_vert_pos' ] && 'yes' == $settings[ 'navigation' ] ) {
                        echo '<div class="swiper-nav-wrapper">';
                            echo '<div class="swiper-nav-ctrl prev-ctrl"><i class="fas fa-long-arrow-alt-left"></i></div>';
                            echo '<div class="swiper-nav-ctrl next-ctrl"><i class="fas fa-long-arrow-alt-right"></i></div>';
                        echo '</div>';
                    }

                    echo '<div class="swiper-wrapper">'.$html.'</div>';

                    if ( 'yes' == $settings[ 'scrollbar' ] ) {
                        echo '<div class="swiper-scrollbar"></div>';
                    }

                    if ( 'bottom' == $settings[ 'nav_vert_pos' ] && 'yes' == $settings[ 'navigation' ] ) {
                        echo '<div class="swiper-nav-wrapper">';
                            echo '<div class="swiper-nav-ctrl prev-ctrl"><i class="fas fa-long-arrow-alt-left"></i></div>';
                            echo '<div class="swiper-nav-ctrl next-ctrl"><i class="fas fa-long-arrow-alt-right"></i></div>';
                        echo '</div>';
                    }

                echo '</div>';
            echo '</div>';

        } else {
            echo '<p class="text">' . esc_html__( 'No post found!', 'agrikon' ) . '</p>';
        }
    }
}