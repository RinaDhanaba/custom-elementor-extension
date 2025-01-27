<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Elementor_Author_Widget extends \Elementor\Widget_Base {

    // (1) Define the widget name
    public function get_name() {
        return 'author';
    }

    // (2) Define the widget title
    public function get_title() {
        return __( 'Author', 'custom-elementor-extension' );
    }

    // (3) Define the widget icon
    public function get_icon() {
        return 'eicon-user';
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

        // Show Author Name toggle
        $this->add_control(
            'show_author_name',
            [
                'label'        => __( 'Show Author Name', 'custom-elementor-extension' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => __( 'Yes', 'custom-elementor-extension' ),
                'label_off'    => __( 'No', 'custom-elementor-extension' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        // Author Name Link toggle (whether to link to the author's page)
        $this->add_control(
            'author_name_link',
            [
                'label'        => __( 'Link to Author\'s Page', 'custom-elementor-extension' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => __( 'Yes', 'custom-elementor-extension' ),
                'label_off'    => __( 'No', 'custom-elementor-extension' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        // Full Name or Short Name toggle
        $this->add_control(
            'show_full_name',
            [
                'label'        => __( 'Display Full Name', 'custom-elementor-extension' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => __( 'Yes', 'custom-elementor-extension' ),
                'label_off'    => __( 'No', 'custom-elementor-extension' ),
                'return_value' => 'yes',
                'default'      => 'yes',
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

        // Typography control for author name
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'author_typography',
                'label'    => __( 'Typography', 'custom-elementor-extension' ),
                'selector' => '{{WRAPPER}} .author-name',
            ]
        );

        // Color control for author name
        $this->add_control(
            'author_color',
            [
                'label'     => __( 'Author Name Color', 'custom-elementor-extension' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .author-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Alignment control
        $this->add_responsive_control(
            'author_alignment',
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
                    '{{WRAPPER}} .author-name' => 'text-align: {{VALUE}};',
                ],
                'default'   => 'left',
            ]
        );

        $this->end_controls_section();
    }

    // (6) Render the widget content
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        if ( 'yes' === $settings['show_author_name'] ) {
            // Decide whether to show full name or short name
            $author_name = ( 'yes' === $settings['show_full_name'] ) ? get_the_author() : get_the_author_meta( 'nickname' );

            if ( $author_name ) {
                // Link to the author's page if enabled
                if ( 'yes' === $settings['author_name_link'] ) {
                    $author_url = get_author_posts_url( get_the_author_meta( 'ID' ) );
                    echo '<div class="author-name"><a href="' . esc_url( $author_url ) . '" target="_blank">' . esc_html( $author_name ) . '</a></div>';
                } else {
                    echo '<div class="author-name">' . esc_html( $author_name ) . '</div>';
                }
            } else {
                echo '<div class="author-name">' . __( 'Author not found', 'custom-elementor-extension' ) . '</div>';
            }
        }
    }
}

// (7) Register the Author Widget
\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Elementor_Author_Widget() );