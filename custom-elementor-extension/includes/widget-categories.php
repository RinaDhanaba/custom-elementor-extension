<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Elementor_Categories_Widget extends \Elementor\Widget_Base {
    
    // (1) Define the widget name
    public function get_name() {
        return 'post_categories';
    }

    // (2) Define the widget title
    public function get_title() {
        return __( 'Post Categories', 'custom-elementor-extension' );
    }

    // (3) Define the widget icon
    public function get_icon() {
        return 'eicon-post-list';
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
            'separator',
            [
                'label'       => __( 'Separator', 'custom-elementor-extension' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => ', ',
                'placeholder' => __( 'Enter separator (e.g., comma, pipe)', 'custom-elementor-extension' ),
            ]
        );

        $this->add_control(
            'link_categories',
            [
                'label'   => __( 'Link Categories', 'custom-elementor-extension' ),
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
                'selector' => '{{WRAPPER}} .post-categories',
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
                    '{{WRAPPER}} .post-categories' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .post-categories a' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .post-categories' => 'text-align: {{VALUE}};',
                ],
                'default'   => 'left',
            ]
        );

        $this->end_controls_section();
    }

    // (6) Render the widget content
    protected function render() {
        $settings = $this->get_settings_for_display();
        $separator = $settings['separator'];
        $link_categories = $settings['link_categories'];
        $categories = get_the_category();

        if ( ! empty( $categories ) ) {
            $output = [];

            foreach ( $categories as $category ) {
                if ( 'yes' === $link_categories ) {
                    $output[] = sprintf(
                        '<a href="%1$s" class="category-link">%2$s</a>',
                        esc_url( get_category_link( $category->term_id ) ),
                        esc_html( $category->name )
                    );
                } else {
                    $output[] = esc_html( $category->name );
                }
            }

            echo '<div class="post-categories">' . implode( esc_html( $separator ), $output ) . '</div>';
        } else {
            echo '<div class="post-categories">' . __( 'No categories assigned', 'custom-elementor-extension' ) . '</div>';
        }
    }
}

// (7) Register the Categories Widget
\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Elementor_Categories_Widget() );
