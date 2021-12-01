<?php 
/**
 * @link              walterlaidelli.com
 * @since             1.0.0
 * @package           Wlbb
 */
namespace Wlbb\Base;

class BaseController
{
	public $version;

	public $style_ver;

	public $plugin_path;

	public $plugin_url;

	public $plugin;

	public $managers = array();

	public function __construct() {
		$this->version = WLBB_VERSION;
		$this->style_ver = str_replace( ".", "", $this->version );
		$this->plugin_path = plugin_dir_path( dirname( __FILE__, 2 ) );
		$this->plugin_url = plugin_dir_url( dirname( __FILE__, 2 ) );
		$this->plugin = plugin_basename( dirname( __FILE__, 3 ) ) . '/wlbb.php';

		$this->managers = array(
			'display_public' => 'Activate Display in Public',
			'custom_buttons_manager' => 'Activate Custom Buttons Manager'
			// ,'active_shortcode' => 'Activate Shortcode'
		);
	}

	public function activated( string $key, string $option_name = 'wlbb_plugin' )
	{
		$option = get_option( $option_name );

		return isset( $option[ $key ] ) ? $option[ $key ] : false;
	}
}
