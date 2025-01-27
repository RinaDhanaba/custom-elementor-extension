<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Elementor_Blog_Posts_Widget extends \Elementor\Widget_Base {

    // (1) Define the widget name
    public function get_name() {
        return 'blog_posts'; // Unique name for the widget
    }

    // (2) Define the widget title
    public function get_title() {
        return __( 'Blog Posts', 'custom-elementor-extension' );
    }

    // (3) Define the widget icon
    public function get_icon() {
        return 'eicon-post-list'; // Icon for the widget
    }

    // (4) Define the widget category
    public function get_categories() {
        return [ 'basic' ]; // Add this widget to Elementor's "Basic" category
    }

    // (5) Register controls for the widget
    protected function register_controls() {
        // Content Controls
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'custom-elementor-extension' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Post Type Selection
        $this->add_control(
            'post_type',
            [
                'label'   => __( 'Post Type', 'custom-elementor-extension' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'options' => $this->get_custom_post_types(), // Use the dynamic method to get post types
                'default' => 'post', // Default to standard posts
            ]
        );

        // Number of Posts
        $this->add_control(
            'posts_per_page',
            [
                'label'       => __( 'Number of Posts', 'custom-elementor-extension' ),
                'type'        => \Elementor\Controls_Manager::NUMBER,
                'default'     => 5,
                'min'         => 1,
                'max'         => 20,
                'step'        => 1,
            ]
        );

        // Columns for Grid Layout
        $this->add_control(
            'grid_columns',
            [
                'label'       => __( 'Columns', 'custom-elementor-extension' ),
                'type'        => \Elementor\Controls_Manager::NUMBER,
                'default'     => 3,
                'min'         => 1,
                'max'         => 4,
                'step'        => 1,
            ]
        );

        // Other settings like Publish Date, Author, etc.
        $this->add_control(
            'show_publish_date',
            [
                'label'     => __( 'Show Publish Date', 'custom-elementor-extension' ),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'label_on'  => __( 'Show', 'custom-elementor-extension' ),
                'label_off' => __( 'Hide', 'custom-elementor-extension' ),
                'return_value' => 'yes',
                'default'   => 'yes',
            ]
        );

        // End content section
        $this->end_controls_section();

    }

    // Method to fetch and return custom post types
    private function get_custom_post_types() {
        // Get all public post types
        $post_types = get_post_types( ['public' => true], 'names' );

        // Filter out unwanted post types (e.g., 'attachment')
        unset( $post_types['attachment'] );

        // Return an associative array of post types with their labels
        $options = [];
        foreach ( $post_types as $post_type ) {
            $options[$post_type] = get_post_type_object( $post_type )->label;
        }

        return $options;
    }

	// (7) Render the widget content
	protected function render() {
		$settings = $this->get_settings_for_display();
		$posts_per_page = $settings['posts_per_page'];
		$grid_columns = $settings['grid_columns'];
		$post_type = $settings['post_type']; // Get selected post type

		// Get the current page number (default is 1)
		$paged = max( 1, get_query_var('paged') );

		// WP Query to fetch the posts
		$args = [
			'post_type'      => $post_type, // Use the selected post type here
			'posts_per_page' => $posts_per_page,
			'paged'          => $paged, // Set the paged argument to handle pagination
		];

		$query = new WP_Query( $args );

		if ( $query->have_posts() ) :
			echo '<div class="blog-posts-wrapper" style="display: grid; grid-template-columns: repeat(' . $grid_columns . ', 1fr); gap: 20px;">';

			while ( $query->have_posts() ) : $query->the_post();
				?>

				<div class="blog-post" style="border: 1px solid #ddd; padding: 15px; transition: background-color 0.3s;">
				<?php
				// Display Post Image
				if ( has_post_thumbnail() ) : ?>
					<div class="blog-post-thumbnail" style="position: relative; width: 100%; padding-top: 75%; overflow: hidden;">
						<?php the_post_thumbnail( 'medium', [
							'style' => 'position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain;',
						] ); ?>
					</div>
				<?php endif; ?>


					<h3 class="blog-post-title"><?php the_title(); ?></h3>
					<p class="blog-post-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></p>

					<?php if ( 'yes' === $settings['show_publish_date'] ) : ?>
						<span class="blog-post-date"><?php echo get_the_date(); ?></span>
					<?php endif; ?>

					<?php if ( 'yes' === $settings['show_last_updated'] && get_the_modified_date() != get_the_date() ) : ?>
						<span class="blog-post-last-updated"><?php echo __( 'Last Updated: ', 'custom-elementor-extension' ) . get_the_modified_date(); ?></span>
					<?php endif; ?>

					<?php if ( 'yes' === $settings['show_categories'] ) : ?>
						<span class="blog-post-categories"><?php echo get_the_category_list( ', ' ); ?></span>
					<?php endif; ?>

					<?php if ( 'yes' === $settings['show_tags'] ) : ?>
						<span class="blog-post-tags"><?php echo get_the_tag_list( '', ', ' ); ?></span>
					<?php endif; ?>

					<?php if ( 'yes' === $settings['show_author'] ) : ?>
						<span class="blog-post-author"><?php echo __( 'By: ', 'custom-elementor-extension' ) . get_the_author(); ?></span>
					<?php endif; ?>

					<!-- Read More Button -->
					<a href="<?php the_permalink(); ?>" class="read-more-button" style="display:block; margin-top: 10px; padding: 10px 20px; background-color: #014421; color: #fff; text-decoration: none; border-radius: 5px;">
						<?php _e( 'Read More', 'custom-elementor-extension' ); ?>
					</a>
				</div>

				<?php
			endwhile;

			// Pagination
			$big = 999999999; // Unique number to replace with pagination links
			echo '<div class="pagination">';
			echo paginate_links( [
				'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'  => '?paged=%#%',
				'current' => $paged,
				'total'   => $query->max_num_pages,
			] );
			echo '</div>';

			wp_reset_postdata();

			echo '</div>';
		else :
			echo '<p>' . __( 'No posts found', 'custom-elementor-extension' ) . '</p>';
		endif;
	}
}

// Register the widget
\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Elementor_Blog_Posts_Widget() );
?>
