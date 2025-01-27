<?php
/**
 * Plugin Name: Custom Elementor Extension
 * Description: Adds custom widgets to Elementor, including dynamic field and post title widgets.
 * Version: 1.0
 * Author: Your Name
 * Text Domain: custom-elementor-extension
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Define plugin constants
define( 'CUSTOM_ELEMENTOR_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

// Load widget files
function custom_elementor_extension_load_widgets() {
    // Check if Elementor is active
    if ( did_action( 'elementor/loaded' ) ) {
        // Include widget files
        require_once CUSTOM_ELEMENTOR_PLUGIN_DIR . 'includes/widget-dynamic-field.php';
        require_once CUSTOM_ELEMENTOR_PLUGIN_DIR . 'includes/widget-post-title.php';
        require_once CUSTOM_ELEMENTOR_PLUGIN_DIR . 'includes/widget-categories.php';
        require_once CUSTOM_ELEMENTOR_PLUGIN_DIR . 'includes/widget-excerpt.php';
		require_once CUSTOM_ELEMENTOR_PLUGIN_DIR . 'includes/widget-publish-date.php';
		require_once CUSTOM_ELEMENTOR_PLUGIN_DIR . 'includes/widget-last-updated-date.php';
		require_once CUSTOM_ELEMENTOR_PLUGIN_DIR . 'includes/widget-featured-image.php';
		require_once CUSTOM_ELEMENTOR_PLUGIN_DIR . 'includes/widget-author.php';
		require_once CUSTOM_ELEMENTOR_PLUGIN_DIR . 'includes/widget-Post-Content.php';
        require_once CUSTOM_ELEMENTOR_PLUGIN_DIR . 'includes/collection/widget-blog-posts.php';

        // You can include more widget files here as you add them
    }
}
add_action( 'elementor/widgets/widgets_registered', 'custom_elementor_extension_load_widgets' );
