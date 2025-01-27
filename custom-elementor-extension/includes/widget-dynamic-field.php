<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Elementor_Dynamic_Field_Widget extends \Elementor\Widget_Base {
    public function get_name() {
        return 'dynamic_field';
    }

    public function get_title() {
        return __( 'Dynamic Field', 'custom-elementor-extension' );
    }

    public function get_icon() {
        return 'eicon-database';
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
            'acf_field_name',
            [
                'label'       => __( 'ACF Field Name', 'custom-elementor-extension' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __( 'Enter ACF field name', 'custom-elementor-extension' ),
            ]
        );

		$this->add_control(
            'html_tag',
            [
                'label'   => __( 'HTML Tag', 'custom-elementor-extension' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'div',
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
					'p' => 'p',
					'div' => 'div',
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

    protected function render() {
        $settings = $this->get_settings_for_display();
        $acf_field_name = $settings['acf_field_name'];

        if ( ! empty( $acf_field_name ) ) {
            $field_value = get_field( $acf_field_name );

            if ( $field_value ) {
                echo esc_html( $field_value );
            } else {
                echo __( 'Field not found or empty', 'custom-elementor-extension' );
            }
        } else {
            echo __( 'No field name provided', 'custom-elementor-extension' );
        }
    }
}

// Register the Dynamic Field Widget
\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Elementor_Dynamic_Field_Widget() );
