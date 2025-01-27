<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Elementor_Featured_Image_Widget extends \Elementor\Widget_Base {

    // (1) Define the widget name
    public function get_name() {
        return 'featured_image';
    }

    // (2) Define the widget title
    public function get_title() {
        return __( 'Featured Image', 'custom-elementor-extension' );
    }

    // (3) Define the widget icon
    public function get_icon() {
        return 'eicon-image';
    }

    // (4) Define the widget category
    public function get_categories() {
        return [ 'basic' ];
    }

    // (5) Register controls for the widget
    protected function register_controls() {
        // Add content controls
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'custom-elementor-extension' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'image_size',
            [
                'label'       => __( 'Image Size', 'custom-elementor-extension' ),
                'type'        => \Elementor\Controls_Manager::SELECT,
                'default'     => 'large',
                'options'     => [
                    'thumbnail' => __( 'Thumbnail', 'custom-elementor-extension' ),
                    'medium'    => __( 'Medium', 'custom-elementor-extension' ),
                    'large'     => __( 'Large', 'custom-elementor-extension' ),
                    'full'      => __( 'Full', 'custom-elementor-extension' ),
                ],
            ]
        );

        $this->end_controls_section();

        // Add style controls
        $this->start_controls_section(
            'style_section',
            [
                'label' => __( 'Style', 'custom-elementor-extension' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Image Border Radius control
        $this->add_control(
            'border_radius',
            [
                'label'      => __( 'Image Border Radius', 'custom-elementor-extension' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'top'    => 0,
                    'right'  => 0,
                    'bottom' => 0,
                    'left'   => 0,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .featured-image img' => 'border-radius: {{TOP}} {{RIGHT}} {{BOTTOM}} {{LEFT}};',
                ],
            ]
        );

        // Image Alignment control
        $this->add_responsive_control(
            'image_alignment',
            [
                'label'     => __( 'Alignment', 'custom-elementor-extension' ),
                'type'      => \Elementor\Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => __( 'Left', 'custom-elementor-extension' ),
                        'icon'  => 'eicon-image-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'custom-elementor-extension' ),
                        'icon'  => 'eicon-image-align-center',
                    ],
                    'right'  => [
                        'title' => __( 'Right', 'custom-elementor-extension' ),
                        'icon'  => 'eicon-image-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .featured-image' => 'text-align: {{VALUE}};',
                ],
                'default'   => 'center',
            ]
        );

        $this->end_controls_section();
    }

    // (6) Render the widget content
    protected function render() {
        $settings = $this->get_settings_for_display();
        $image_size = $settings['image_size'];

        // Fetch the featured image URL
        $featured_image = get_the_post_thumbnail_url( get_the_ID(), $image_size );

        if ( $featured_image ) {
            echo '<div class="featured-image">';
            echo '<img src="' . esc_url( $featured_image ) . '" alt="' . esc_attr__( 'Featured Image', 'custom-elementor-extension' ) . '" />';
            echo '</div>';
        } else {
            echo '<div class="featured-image">' . __( 'No featured image available', 'custom-elementor-extension' ) . '</div>';
        }
    }
}

// (7) Register the Featured Image Widget
\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Elementor_Featured_Image_Widget() );