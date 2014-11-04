<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
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
 * @author     Your Name <email@example.com>
 */
class WP_Quick_Image_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
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
	 * @since    1.0.0
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
	 * @since    1.0.0
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

	}

	/**
	 * [init_widget description]
	 * @return [type] [description]
	 */
	public function init_widget() {
		wp_add_dashboard_widget( 'wp-quick-image', 'Quick Image Post', array($this, 'display_widget') );
	}

	/**
	 * [display_widget description]
	 * @return [type] [description]
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

			<div class="textarea-wrap" id="wp-quick-image-description-wrap">
				<label class="prompt" for="wp-quick-image-content" id="wp-quick-image-content-prompt-text">What’s on your mind?</label>
				<textarea name="wp-quick-image-content" id="wp-quick-image-content" class="mceEditor" rows="3" cols="15" autocomplete="off"></textarea>
			</div>

			<p class="submit">
				<input type="hidden" name="action" id="wp-quick-image-action" value="post-quickdraft-save">
				<input type="hidden" name="post_type" value="post">
				<input type="hidden" id="_wpnonce" name="_wpnonce" value="61a6274e55">
				<input type="hidden" name="_wp_http_referer" value="/wp-admin/index.php">
				<input type="submit" name="save" id="save-post" class="button button-primary" value="Save Draft">
				<br class="clear">
			</p>

		</form>
<?php
	}
}
