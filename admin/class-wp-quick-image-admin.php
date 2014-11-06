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
	 * Adds the dashboard widget
	 * 
	 * @since 0.1.0
	 */
	public function init_widget() {
		wp_add_dashboard_widget( 'wp-quick-image', 'Quick Image Post', array($this, 'display_widget') );
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
					Title
				</label>
				<input type="text" name="wp-quick-image-title" id="wp-quick-image-title" autocomplete="off">
			</div>

			<button class="button button-secondary wpqi-disable-on-submit" id="wp-quick-image-choose">Add image</button>

			<div id="wp-quick-image-preview">
				<input name="wp-quick-image-id" id="wp-quick-image-id" type="hidden" value="0">
			</div>

			<div class="textarea-wrap" id="wp-quick-image-description-wrap">
				<label class="prompt" for="wp-quick-image-content" id="wp-quick-image-content-prompt-text">Post content</label>
				<textarea name="wp-quick-image-content" id="wp-quick-image-content" class="mceEditor" rows="3" cols="15" autocomplete="off"></textarea>
			</div>

			<p class="submit">
				<input type="hidden" name="action" id="wp-quick-image-action" value="wp-quick-image-save">
				<input type="hidden" name="post_type" value="post">
				<?php wp_nonce_field('wp-quick-image'); ?>
				<input type="submit" name="save" id="wpqi-save-post" class="button button-primary wpqi-disable-on-submit" value="Publish this">
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

			$post_details = array(
									'post_content' => $post_content,
									'post_title' => $post_title,
									'post_status' => 'publish',
									'post_type' => 'post',
									'post_excerpt' => $post_title,
								);

			$post_id = wp_insert_post( $post_details );

			if ($post_id > 0) {
				update_post_meta($post_id, '_thumbnail_id', $attachment_id);
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
