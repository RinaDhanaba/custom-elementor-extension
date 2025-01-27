<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Elementor_Excerpt_Widget extends \Elementor\Widget_Base {

    // (1) Define the widget name
    public function get_name() {
        return 'post_excerpt';
    }

    // (2) Define the widget title
    public function get_title() {
        return __( 'Post Excerpt', 'custom-elementor-extension' );
    }

    // (3) Define the widget icon
    public function get_icon() {
        return 'eicon-editor-paragraph';
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
            'excerpt_length',
            [
                'label'       => __( 'Excerpt Length (words)', 'custom-elementor-extension' ),
                'type'        => \Elementor\Controls_Manager::NUMBER,
                'default'     => 20,
                'min'         => 1,
                'description' => __( 'Number of words to show in the excerpt.', 'custom-elementor-extension' ),
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label'       => __( 'Read More Text', 'custom-elementor-extension' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => __( 'Read More', 'custom-elementor-extension' ),
                'placeholder' => __( 'Enter "Read More" text', 'custom-elementor-extension' ),
            ]
        );

        $this->add_control(
            'read_more_link',
            [
                'label'   => __( 'Link "Read More" to Post', 'custom-elementor-extension' ),
                'type'    => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
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

        // Typography control
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'typography',
                'label'    => __( 'Typography', 'custom-elementor-extension' ),
                'selector' => '{{WRAPPER}} .post-excerpt',
            ]
        );

        // Text color control
        $this->add_control(
            'text_color',
            [
                'label'     => __( 'Text Color', 'custom-elementor-extension' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .post-excerpt' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Read More color control
        $this->add_control(
            'read_more_color',
            [
                'label'     => __( 'Read More Color', 'custom-elementor-extension' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#0073aa',
                'selectors' => [
                    '{{WRAPPER}} .read-more' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Alignment control
        $this->add_responsive_control(
            'text_alignment',
            [
                'label'     => __( 'Alignment', 'custom-elementor-extension' ),
                'type'      => \Elementor\Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => __( 'Left', 'custom-elementor-extension' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'custom-elementor-extension' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => __( 'Right', 'custom-elementor-extension' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-excerpt' => 'text-align: {{VALUE}};',
                ],
                'default'   => 'left',
            ]
        );

        $this->end_controls_section();
    }

    // (6) Render the widget content
    protected function render() {
        $settings = $this->get_settings_for_display();
        $excerpt_length = ! empty( $settings['excerpt_length'] ) ? $settings['excerpt_length'] : 20;
        $read_more_text = $settings['read_more_text'];
        $read_more_link = $settings['read_more_link'];

        $excerpt = wp_trim_words( get_the_excerpt(), $excerpt_length );

        echo '<div class="post-excerpt">' . esc_html( $excerpt );

        if ( 'yes' === $read_more_link && $read_more_text ) {
            $post_url = get_permalink();
            echo ' <a href="' . esc_url( $post_url ) . '" class="read-more">' . esc_html( $read_more_text ) . '</a>';
        }

        echo '</div>';
    }
}

// (7) Register the Excerpt Widget
\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Elementor_Excerpt_Widget() );
