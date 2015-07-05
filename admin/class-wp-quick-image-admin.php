<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://oikos.org.uk/wp-quick-image
 * @since      0.1.0
 *
 * @package    WP_Quick_Image
 * @subpackage WP_Quick_Image/admin
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    WP_Quick_Image
 * @subpackage WP_Quick_Image/admin
 */
class WP_Quick_Image_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1.0
	 * @var      string    $plugin_name       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Admin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Admin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-quick-image-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Admin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Admin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-quick-image-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_media();

	}

	/**
	 * Add the settings menu
	 * 
	 * @since 0.2.0
	 */
	public function init_settings_menu() {
		
		add_options_page(
				__('WP Quick Image', 'wp-quick-image'),
		 		__('WP Quick Image', 'wp-quick-image'),
		 		'manage_options',
		 		'wp_quick_image',
		 		array($this, 'settings_page') );
	}

	/**
	 * Initialise settings
	 * 
	 * @since 0.2.0
	 */
	public function init_settings() {
		
		// Register a single setting - we'll store stuff within this in serialized form
		register_setting( 'wp_quick_image', 'wpqi_settings' );

		add_settings_section(
			'wpqi_settings_general', 
			__( 'General settings', 'wp-quick-image' ), 
			array($this, 'wpqi_settings_general_callback'), 
			'wp_quick_image'
		);	

		add_settings_field( 
			'wpqi_post_type', 
			__( 'Post type', 'wp-quick-image' ), 
			array($this, 'wpqi_post_type_field_render'), 
			'wp_quick_image', 
			'wpqi_settings_general' 
		);
	
		add_settings_field( 
			'wpqi_category', 
			__( 'Category', 'wp-quick-image' ), 
			array($this, 'wpqi_category_field_render'), 
			'wp_quick_image', 
			'wpqi_settings_general' 
		);

		add_settings_field( 
			'wpqi_tag', 
			__( 'Tag', 'wp-quick-image' ), 
			array($this, 'wpqi_tag_field_render'), 
			'wp_quick_image', 
			'wpqi_settings_general' 
		);

		add_settings_field( 
			'wpqi_add_excerpt', 
			__( 'Add excerpt', 'wp-quick-image' ), 
			array($this, 'wpqi_add_excerpt_field_render'), 
			'wp_quick_image', 
			'wpqi_settings_general' 
		);

		add_settings_field( 
			'wpqi_add_content', 
			__( 'Add content', 'wp-quick-image' ), 
			array($this, 'wpqi_add_content_field_render'), 
			'wp_quick_image', 
			'wpqi_settings_general' 
		);

		add_settings_field( 
			'wpqi_set_featured_image', 
			__( 'Set featured image', 'wp-quick-image' ), 
			array($this, 'wpqi_set_featured_image_field_render'), 
			'wp_quick_image', 
			'wpqi_settings_general' 
		);

	}

	/**
	 * Render the settings page
	 * 
	 * @since 0.2.0
	 */
	public function settings_page() {
		
	?>
		<form action='options.php' method='post'>
		
			<h2>WP Quick Image</h2>

			<?php
				// Hidden fields and security
				settings_fields( 'wp_quick_image' );
				do_settings_sections( 'wp_quick_image' );
				submit_button();
			?>
		</form>
	<?php
	}

	/**
	 * Output the content for the general settings section
	 * 
	 * @since 0.2.0
	 */
	public function wpqi_settings_general_callback() {
		_e('General settings for WP Quick Image', 'wp-quick-image');
	}

	/**
	 * Output the content for the post type option
	 * 
	 * @since 0.2.0
	 */
	public function wpqi_post_type_field_render() {
		$options = get_option( 'wpqi_settings' );
		if (isset($options['post_type'])) {
			$current_val = $options['post_type'];
		} else {
			$current_val = 'post';
		}
		
	?>
		<select name='wpqi_settings[post_type]'>
			<?php foreach (get_post_types() as $this_type) : ?>
				<option value='<?php echo $this_type ?>' <?php selected( $current_val, $this_type ); ?>><?php echo $this_type; ?></option>
			<?php endforeach; ?>
		</select>
		<p><em><?php _e('Select a post type to create when creating a quick image. This will normally be "post", but change it if you need to.', 'wp-quick-image'); ?></em></p>

	<?php
	}

	/**
	 * Output the content for the category option
	 * 
	 * @since 0.2.0
	 */
	public function wpqi_category_field_render() {
		$options = get_option( 'wpqi_settings' );
		if (isset($options['category'])) {
			$current_val = $options['category'];
		} else {
			$current_val = 0;
		}
	?>
		<select name='wpqi_settings[category]'>
			<option value="0" <?php selected( $current_val, 0 ); ?>><?php _e("No category", 'wp-quick-image'); ?></option>
			<?php foreach (get_categories(array('hide_empty' => 0)) as $this_cat) : ?>
				<option value='<?php echo $this_cat->term_id ?>' <?php selected( $current_val, $this_cat->term_id ); ?>><?php echo $this_cat->name; ?></option>
			<?php endforeach; ?>
		</select>
		<p><em><?php _e('Please select a category to assign new quick images to. This only applies if the post type is "Post". Note that the WordPress default category applies if this is not set.', 'wp-quick-image'); ?></em></p>

	<?php
	}

	/**
	 * Output the content for the tag option
	 * 
	 * @since 0.2.0
	 */
	public function wpqi_tag_field_render() {
		$options = get_option( 'wpqi_settings' );
		if (isset($options['tag'])) {
			$current_val = $options['tag'];
		} else {
			$current_val = 0;
		}

	?>
		<select name='wpqi_settings[tag]'>
			<option value="0" <?php selected( $current_val, 0 ); ?>><?php _e('No tag', 'wp-quick-image'); ?></option>
			<?php foreach (get_tags(array('hide_empty' => false)) as $this_tag) : ?>
				<option value='<?php echo $this_tag->term_id; ?>' <?php selected( $current_val, $this_tag->term_id ); ?>><?php echo $this_tag->name; ?></option>
			<?php endforeach; ?>
		</select>
		<p><em><?php _e('Select a tag to assign new posts to. This only applies if the post type is "Post".', 'wp-quick-image'); ?></em></p>

	<?php
	}

	/**
	 * Output the content for the add excerpt option
	 * 
	 * @since 0.2.0
	 */
	public function wpqi_add_excerpt_field_render() {
		$options = get_option( 'wpqi_settings' );
		if (isset($options['add_excerpt'])) {
			$current_val = $options['add_excerpt'];
		} else {
			$current_val = 1;
		}
		
	?>
		<input name='wpqi_settings[add_excerpt]' type="radio" value="0" <?php checked($current_val, 0); ?>><?php _e('No', 'wp-quick-image'); ?></input>
		<input name='wpqi_settings[add_excerpt]' type="radio" value="1" <?php checked($current_val, 1); ?>><?php _e('Yes', 'wp-quick-image'); ?></input>
		<p><em><?php _e('If this is turned on, the content added in quick image will also be added to the excerpt field. This can be useful for populating OpenGraph data for social media to use.', 'wp-quick-image'); ?></em></p>
	<?php
	}

	/**
	 * Output the content for the add content option
	 * 
	 * @since 0.2.0
	 */
	public function wpqi_add_content_field_render() {
		$options = get_option( 'wpqi_settings' );
		if (isset($options['add_content'])) {
			$current_val = $options['add_content'];
		} else {
			$current_val = 0;
		}
		
	?>
		<input name='wpqi_settings[add_content]' type="radio" value="0" <?php checked($current_val, 0); ?>><?php _e('No', 'wp-quick-image'); ?></input>
		<input name='wpqi_settings[add_content]' type="radio" value="1" <?php checked($current_val, 1); ?>><?php _e('Yes', 'wp-quick-image'); ?></input>
		<p><em><?php _e('If this is turned on, the image will be added to the content of the post.', 'wp-quick-image'); ?></em></p>
	<?php
	}

	/**
	 * Output the content for the set featured image option
	 * 
	 * @since 0.2.0
	 */
	public function wpqi_set_featured_image_field_render() {
		$options = get_option( 'wpqi_settings' );
		if (isset($options['set_featured_image'])) {
			$current_val = $options['set_featured_image'];
		} else {
			$current_val = 1;
		}
		
	?>
		<input name='wpqi_settings[set_featured_image]' type="radio" value="0" <?php checked($current_val, 0); ?>><?php _e('No', 'wp-quick-image'); ?></input>
		<input name='wpqi_settings[set_featured_image]' type="radio" value="1" <?php checked($current_val, 1); ?>><?php _e('Yes', 'wp-quick-image'); ?></input>
		<p><em><?php _e('If this is turned on, the image will be used as the featured image of the post.', 'wp-quick-image'); ?></em></p>
	<?php
	}

	/**
	 * Adds the dashboard widget
	 * 
	 * @since 0.1.0
	 */
	public function init_widget() {
		wp_add_dashboard_widget( 'wp-quick-image', __('Quick Image Post', 'wp-quick-image'), array($this, 'display_widget') );
	}

	/**
	 * Display the dashboard widget
	 * 
	 * @since 0.1.0
	 */
	public function display_widget() {
?>
		<form name="post" action="http://plugindev.localnet/wp-admin/post.php" method="post" id="quick-press" class="initial-form hide-if-no-js">

		
			<div class="input-text-wrap" id="wp-quick-image-title-wrap">
				<label class="prompt" for="wp-quick-image-title" id="wp-quick-image-title-prompt-text">
					<?php _e('Title', 'wp-quick-image'); ?>
				</label>
				<input type="text" name="wp-quick-image-title" id="wp-quick-image-title" autocomplete="off">
			</div>

			<button class="button button-secondary wpqi-disable-on-submit" id="wp-quick-image-choose"><?php _e('Add image', 'wp-quick-image'); ?></button>

			<div id="wp-quick-image-preview">
				<input name="wp-quick-image-id" id="wp-quick-image-id" type="hidden" value="0">
			</div>

			<div class="textarea-wrap" id="wp-quick-image-description-wrap">
				<label class="prompt" for="wp-quick-image-content" id="wp-quick-image-content-prompt-text"><?php _e('Post content', 'wp-quick-image'); ?></label>
				<textarea name="wp-quick-image-content" id="wp-quick-image-content" class="mceEditor" rows="3" cols="15" autocomplete="off"></textarea>
			</div>

			<p class="submit">
				<input type="hidden" name="action" id="wp-quick-image-action" value="wp-quick-image-save">
				<input type="hidden" name="post_type" value="post">
				<?php wp_nonce_field('wp-quick-image'); ?>
				<input type="submit" name="save" id="wpqi-save-post" class="button button-primary wpqi-disable-on-submit" value="<?php _e('Publish this', 'wp-quick-image'); ?>">
				<br class="clear">
			</p>

		</form>
<?php
	}

	/**
	 * Handle the AJAX submission.  Prints 0 for failure or a json_encoded
	 * array of useful info for success. Be sure to die() in both cases
	 * and when sending JSON, set the Content-Type.
	 * 
	 * @since 0.1.0
	 */
	public function handle_ajax_submit() {
		// Check nonce
		if (check_admin_referer('wp-quick-image')) {
			$attachment_id = $_REQUEST['wp-quick-image-id'];
			$post_title = $_REQUEST['wp-quick-image-title'];
			$post_content = $_REQUEST['wp-quick-image-content'];

			// Set the post details with defaults. We'll modify these as per the options if necessary.
			$post_details = array(
									'post_content' => $post_content,
									'post_title' => $post_title,
									'post_status' => 'publish',
									'post_type' => 'post',
								);

			// Process the options and build the post details
			$options = get_option( 'wpqi_settings' );

			// post_type is always set - 'post' is the default, set above
			if (isset($options['post_type'])) {
				$post_details['post_type'] = $options['post_type'];
			}

			// Zero if not set - only do this for posts
			if ('post' == $post_details['post_type'] && isset($options['category'])) {
				if ($options['category'] > 0) {
					$post_details['post_category'] = array( $options['category'] );
				}
			}
			
			// Zero if not set - only do this for posts
			if ('post' == $post_details['post_type'] && isset($options['tag'])) {
				if ($options['tag'] > 0) {
					// tags_input take a name, not an ID!
					$tag_details = get_tag($options['tag']);
					$post_details['tags_input'] = array( $tag_details->name );
				}
			}

			// This is 0 or 1
			if (isset($options['add_excerpt'])) {
				if (1 == $options['add_excerpt']) {
					$post_details['post_excerpt'] = $post_content;
				}
			} else {
				// There's no options set - default is to add the excerpt
				$post_details['post_excerpt'] = $post_content;
			}

			// This is a 0 or 1
			if (isset($options['add_content'])) {
				if (1 == $options['add_content']) {
					$post_details['post_content'] = wp_get_attachment_image( $attachment_id, 'full' ) . $post_details['post_content'];
				}
			} else {
				// No option set - default is to do nothing.
			}

			$post_id = wp_insert_post( $post_details );

			if ($post_id > 0) {
	
				// Check the featured image setting - this is a 0 or 1
				if (isset($options['set_featured_image'])) {
					if (1 == $options['set_featured_image']) {
						update_post_meta($post_id, '_thumbnail_id', $attachment_id);
					}
				} else {
					// No option is set - default is to add thumbnail
					update_post_meta($post_id, '_thumbnail_id', $attachment_id);
				}
				header('Content-Type: application/json');
				echo json_encode( array( 
									'postId' => $post_id,
									'editUrl' => get_edit_post_link($post_id, 'attr'),
									'permalink' => get_permalink($post_id),
					));
			} else {
				echo '0';
			}

			die();
		}
	}
}
