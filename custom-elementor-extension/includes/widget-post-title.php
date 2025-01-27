<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Elementor_Post_Title_Widget extends \Elementor\Widget_Base {
    public function get_name() {
        return 'post_title';
    }

    public function get_title() {
        return __( 'Post Title', 'custom-elementor-extension' );
    }

    public function get_icon() {
        return 'eicon-post-title';
    }

    public function get_categories() {
        return [ 'basic' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'custom-elementor-extension' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'html_tag',
            [
                'label'   => __( 'HTML Tag', 'custom-elementor-extension' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'h1',
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                ],
            ]
        );

        $this->add_control(
            'link_field',
            [
                'label'       => __( 'Link URL', 'custom-elementor-extension' ),
                'type'        => \Elementor\Controls_Manager::URL,
                'placeholder' => __( 'https://your-link.com', 'custom-elementor-extension' ),
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
                'selector' => '{{WRAPPER}} .post-title',
            ]
        );

        // Color control
        $this->add_control(
            'text_color',
            [
                'label'     => __( 'Text Color', 'custom-elementor-extension' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .post-title' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .post-title' => 'text-align: {{VALUE}};',
                ],
                'default'   => 'left',
            ]
        );

        $this->end_controls_section();

    }

    // (6) Render the widget content
    protected function render() {
        $settings = $this->get_settings_for_display();
        $html_tag = ! empty( $settings['html_tag'] ) ? $settings['html_tag'] : 'h1';
        $link = $settings['link_field'];
        $post_title = get_the_title();

        // Open link tag if URL is provided
        if ( $link['url'] ) {
            $this->add_link_attributes( 'post_title_link', $link );
            echo '<a ' . $this->get_render_attribute_string( 'post_title_link' ) . '>';
        }

        // Render the post title
        if ( ! empty( $post_title ) ) {
            printf(
                '<%1$s class="post-title">%2$s</%1$s>',
                esc_html( $html_tag ),
                esc_html( $post_title )
            );
        } else {
            echo __( 'No post title found', 'custom-elementor-extension' );
        }

        // Close link tag if URL was opened
        if ( $link['url'] ) {
            echo '</a>';
        }
    }
}

// Register the Post Title Widget
\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Elementor_Post_Title_Widget() );
