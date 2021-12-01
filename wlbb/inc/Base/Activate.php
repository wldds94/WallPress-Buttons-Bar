<?php
/**
 * @link              walterlaidelli.com
 * @since             1.0.0
 * @package           Wlbb
 */
namespace Wlbb\Base;

class Activate
{
	public $wlbb_version_option = array();

	public $buttons = array();

	/**
	 * Called by Activation Hook
	 * @since   1.0.0
	 * 
	 * @return
	 */
	public function activate() {
		flush_rewrite_rules();

		$version = WLBB_VERSION;

		if ( get_option('wlbb_version_option') && isset(get_option('wlbb_version_option')['version']) === $version ) {
			return;
		} elseif ( ! get_option('wlbb_version_option') ) {
			$this->intializeVersion();
		}
		
	}

	/**
	 * Initialize the all options of plugin
	 * @since   1.0.0
	 * 
	 * @return
	 */
	public function intializeVersion()
	{
		$default = array();

		$this->wlbb_version_option = array(
			'version' => WLBB_VERSION,
			'button_settings_default' => array( // Register the information about the options key used By SettingsApi ! ! ! DON'T TOUCH !
				'custom' => array(
					'option_group' => 'wlbb_plugin_button_settings',
					'option_name' => 'wlbb_plugin_button',
					'id_section' => 'wlbb_btn_index',
					'title_section' => 'Custom',
					'page_section' => 'wlbb_button',
					'index' => 'custom',
					'status' => 'custom'
				)				
			)
		);

		$this->setButtons();

		update_option( 'wlbb_version_option', $this->wlbb_version_option );

		if ( ! get_option('wlbb_plugin') ) { // Option for activate Manager Controller
			update_option( 'wlbb_plugin', $default );
		}

		if ( ! get_option('wlbb_plugin_general') ) { // General Option for the button
			update_option( 'wlbb_plugin_general', $default );
		}

		if ( ! get_option('wlbb_plugin_button') ) {
			update_option( 'wlbb_plugin_button', $default );
		}
		
	}

	/**
	 * Set the data for saving default core option of plugin
	 * @since   1.0.0
	 * 
	 * @return
	 */
	public function setButtons()
	{
		foreach ($this->wlbb_version_option['button_settings_default'] as $key => $value) {
			$this->buttons[$key] = $value['title_section'];
		}

		return $this->buttons;
	}

	// Activate Version

}