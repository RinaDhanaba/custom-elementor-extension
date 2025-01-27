<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Elementor_Last_Updated_Date_Widget extends \Elementor\Widget_Base {

    // (1) Define the widget name
    public function get_name() {
        return 'last_updated_date';
    }

    // (2) Define the widget title
    public function get_title() {
        return __( 'Last Updated Date', 'custom-elementor-extension' );
    }

    // (3) Define the widget icon
    public function get_icon() {
        return 'eicon-calendar';
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
            'date_format',
            [
                'label'       => __( 'Date Format', 'custom-elementor-extension' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => 'F j, Y', // WordPress date format
                'description' => __( 'Specify a date format (e.g., F j, Y for January 1, 2025).', 'custom-elementor-extension' ),
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
                'selector' => '{{WRAPPER}} .last-updated-date',
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
                    '{{WRAPPER}} .last-updated-date' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .last-updated-date' => 'text-align: {{VALUE}};',
                ],
                'default'   => 'left',
            ]
        );

        $this->end_controls_section();
    }

    // (6) Render the widget content
    protected function render() {
        $settings = $this->get_settings_for_display();
        $date_format = ! empty( $settings['date_format'] ) ? $settings['date_format'] : 'F j, Y';

        // Fetch the last updated date
        $last_updated_date = get_the_modified_date( $date_format );

        if ( $last_updated_date ) {
            echo '<div class="last-updated-date">' . esc_html( $last_updated_date ) . '</div>';
        } else {
            echo '<div class="last-updated-date">' . __( 'Last updated date not available', 'custom-elementor-extension' ) . '</div>';
        }
    }
}

// (7) Register the Last Updated Date Widget
\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Elementor_Last_Updated_Date_Widget() );