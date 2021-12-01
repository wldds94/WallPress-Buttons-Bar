<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * @link       walterlaidelli.com
 * @since      1.0.0
 *
 * @package    Wlbb
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

class WlbbUninstall 
{
	private $settingOptions;

	private $post_types;

	private $posts;

	public function __construct()
	{
		$this->settingOptions = array( 'wlbb_version_option', 'wlbb_plugin', 'wlbb_plugin_general', 'wlbb_plugin_button' );

		$this->setPostTypes();

		$this->setPosts();
	}

	/**
	 * Delete all options and meta key stored in DB by the plugin
	 * @since   1.0.0
	 * 
	 * @return
	 */
	public function uninstall()
	{
		// Clear up all Options
		foreach ( $this->settingOptions as $settingName ) {
			delete_option( $settingName );
		}

		// Clear up all Meta Key Value
		foreach( $this->posts as $post ) {
			delete_post_meta( $post->ID, '_wlbb_button_meta_key' );
		}
	}

	/**
	 * Set the all posts I have to check
	 * @since   1.0.0
	 * 
	 * @return
	 */
	private function setPosts()
	{
		$args = array(
			'posts_per_page'   => -1,
			'post_status'      => 'publish',
			'post_type'  	   => $this->post_types
		);
		$this->posts = get_posts( $args );
	}

	/**
	 * Set the post Types friendly for "wp_query"
	 * @since   1.0.0
	 * 
	 * @return
	 */
	private function setPostTypes()
	{
		$all_post_types = get_post_types( array( 'show_ui' => true ) );
		$types = array();
		foreach( $all_post_types as $post_type) {
			$types[] = $post_type;
		}
		$this->post_types = $types;
	}

}

/**
 * Run the uninstaller
 * @since   1.0.0
 */
$uninstaller = new WlbbUninstall();
$uninstaller->uninstall();