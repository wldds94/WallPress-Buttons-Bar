<?php
/**
 * @link              walterlaidelli.com
 * @since             1.0.0
 * @package           Wlaiddd
 */
namespace Wlbb\Base;

use Wlbb\Base\BaseController;

/**
* 
*/
class Enqueue extends BaseController
{
	public function register() {
		
		parent::__construct();

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueuePublic' ) );
	}
	
	/**
	 * Enqueue All Default Admin scripts
	 * @since   1.0.0
	 * 
	 * @return
	 */
	public function enqueue() { 
		wp_enqueue_script( 'jquery' );

		wp_enqueue_script( 'media-upload' );
		wp_enqueue_media();

		// DataTables Dependency
		wp_enqueue_style( 'wlbb_datatables_style', $this->plugin_url . 'dist/library/css/jquery.dataTables.min.css' );
		wp_enqueue_script( 'wlbb_datatables_script', $this->plugin_url . 'dist/library/js/jquery.dataTables.min.js' );

		wp_enqueue_style( 'wlbb_style', $this->plugin_url . 'dist/css/style.css' );
		// Admin Script
		$pluginButtons = get_option( 'wlbb_plugin_button' ) ?: array();
		$buttonIDs = array();
		foreach ($pluginButtons as $key => $value) {
			$buttonIDs[] = $key;
		}
		wp_enqueue_script( 'wlbb_admin_script', $this->plugin_url . 'dist/js/admin-script.js' );
		// Localize the keys of the buttons for catch the error in "button_id" input of the form in admin-scripts - Don't touch
		wp_localize_script( 'wlbb_admin_script', 'wlbb_admin_vars', array(
			'author'      => 'Walter Laidelli',
			'buttonIDs'   => $buttonIDs
		) );

		// Options
		// wp_enqueue_script( 'wlbb_color_picker_script', $this->plugin_url . 'dist/js/option.js' );		
	}

	/**
	 * Enqueue All Default Public scripts
	 * @since   1.0.0
	 * 
	 * @return
	 */
	public function enqueuePublic()
	{
		if ( ! $this->activated( 'display_public' ) ) {
			return;
		}

		// Font Awesome Dependencies
		wp_enqueue_style( 'wlbb-load-fa-581', 'https://use.fontawesome.com/releases/v5.8.1/css/all.css' );
		wp_enqueue_style( 'wlbb-load-fa-470', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' );

		$params = array( 'style' => $this->style_ver );
		wp_enqueue_style( 'wlbb_public_style', get_site_url() . '?style=' . $this->style_ver );
	}
}