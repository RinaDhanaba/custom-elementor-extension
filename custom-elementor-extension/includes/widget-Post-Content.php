<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Elementor_Post_Content_Widget extends \Elementor\Widget_Base {
    public function get_name() {
        return 'post_content';
    }

    public function get_title() {
        return __( 'Post Content', 'custom-elementor-extension' );
    }

    public function get_icon() {
        return 'eicon-post-content';
    }

    public function get_categories() {
        return [ 'basic' ];
    }

    protected function register_controls() {
        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'custom-elementor-extension' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'content_alignment',
            [
                'label'     => __( 'Content Alignment', 'custom-elementor-extension' ),
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
                    '{{WRAPPER}} .post-content' => 'text-align: {{VALUE}};',
                ],
                'default'   => 'left',
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => __( 'Styles', 'custom-elementor-extension' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Headings Style
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'heading_typography',
                'label'    => __( 'Headings Typography', 'custom-elementor-extension' ),
                'selector' => '{{WRAPPER}} .post-content h1, 
                               {{WRAPPER}} .post-content h2, 
                               {{WRAPPER}} .post-content h3, 
                               {{WRAPPER}} .post-content h4, 
                               {{WRAPPER}} .post-content h5, 
                               {{WRAPPER}} .post-content h6',
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label'     => __( 'Headings Color', 'custom-elementor-extension' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .post-content h1, 
                     {{WRAPPER}} .post-content h2, 
                     {{WRAPPER}} .post-content h3, 
                     {{WRAPPER}} .post-content h4, 
                     {{WRAPPER}} .post-content h5, 
                     {{WRAPPER}} .post-content h6' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Paragraph Style
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'paragraph_typography',
                'label'    => __( 'Paragraph Typography', 'custom-elementor-extension' ),
                'selector' => '{{WRAPPER}} .post-content p',
            ]
        );

        $this->add_control(
            'paragraph_color',
            [
                'label'     => __( 'Paragraph Color', 'custom-elementor-extension' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .post-content p' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Images Style
        $this->add_control(
            'image_border_radius',
            [
                'label'     => __( 'Image Border Radius', 'custom-elementor-extension' ),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-content img' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Links Style
        $this->add_control(
            'link_color',
            [
                'label'     => __( 'Link Color', 'custom-elementor-extension' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#0073e6',
                'selectors' => [
                    '{{WRAPPER}} .post-content a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'link_hover_color',
            [
                'label'     => __( 'Link Hover Color', 'custom-elementor-extension' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#0056b3',
                'selectors' => [
                    '{{WRAPPER}} .post-content a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Code Style
        $this->add_control(
            'code_background_color',
            [
                'label'     => __( 'Code Background Color', 'custom-elementor-extension' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#f5f5f5',
                'selectors' => [
                    '{{WRAPPER}} .post-content code' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'code_text_color',
            [
                'label'     => __( 'Code Text Color', 'custom-elementor-extension' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#d63384',
                'selectors' => [
                    '{{WRAPPER}} .post-content code' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Button Style
        $this->add_control(
            'button_color',
            [
                'label'     => __( 'Button Color', 'custom-elementor-extension' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .post-content button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label'     => __( 'Button Background Color', 'custom-elementor-extension' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#0073e6',
                'selectors' => [
                    '{{WRAPPER}} .post-content button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $content = apply_filters( 'the_content', get_the_content() );

        if ( ! empty( $content ) ) {
            echo '<div class="post-content">' . $content . '</div>';
        } else {
            echo __( 'No post content found', 'custom-elementor-extension' );
        }
    }
}

// Register the Post Content Widget
\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Elementor_Post_Content_Widget() );