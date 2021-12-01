<?php 
/**
 * @link              walterlaidelli.com
 * @since             1.0.0
 * @package           Wlaiddd
 */
namespace Wlbb\Controllers;

use Wlbb\Api\SettingsApi;
use Wlbb\Base\BaseController;
use Wlbb\Api\Callbacks\AdminCallbacks;
use Wlbb\Api\Callbacks\DashboardCallbacks;

class Dashboard extends BaseController
{
    public $settings;

	public $callbacks;

	public $callbacks_mngr;

	public $pages = array();
    
	/**
	 * Initialize the core of class
	 * 
	 * Configure the dashboard page and initialize the option settings, the call the parent method
	 * for register all in core of WP.
	 * @return
	 * 
	 */
	public function register()
	{
		$this->settings = new SettingsApi();

		$this->callbacks = new AdminCallbacks();

		$this->callbacks_mngr = new DashboardCallbacks();

		$this->setPages(); // Add Page

		// Initialize settings
		$this->setSettings();
		$this->setSections();
		$this->setFields();

		$this->settings->addPages( $this->pages )->withSubPage( 'Dashboard' )->register();
	}

	/**
	 * Set the array for register the General Settings Page
	 * @return
	 */
    public function setPages() 
	{
		$this->pages = array(
			array(
				'page_title' => 'Wlbb Dashboard', 
				'menu_title' => 'Button Manager', 
				'capability' => 'manage_options', 
				'menu_slug' => 'wlbb_plugin', 
				'callback' => array( $this->callbacks, 'adminDashboard' ), 
				'icon_url' => 'dashicons-admin-links', 
				'position' => 110
			)
		);
	}

	/**
	 * Register the settings
	 * @return
	 */
	public function setSettings()
	{
		$args = array(
			array(
				'option_group' => 'wlbb_plugin_settings',
				'option_name' => 'wlbb_plugin',
				'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
			)
		);

		$this->settings->setSettings( $args );
	}

	/**
	 * Register the section of the option
	 * @return
	 */
	public function setSections()
	{
		$args = array(
			array(
				'id' => 'wlbb_admin_index',
				'title' => 'Wlbb Settings Manager',
				'callback' => array( $this->callbacks_mngr, 'adminSectionManager' ),
				'page' => 'wlbb_plugin'
			)
		);

		$this->settings->setSections( $args );
	}

	/**
	 * Register the fields of the option
	 * @return
	 */
	public function setFields()
	{
		$args = array();

		foreach ( $this->managers as $key => $value ) {
			$args[] = array(
				'id' => $key,
				'title' => $value,
				'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
				'page' => 'wlbb_plugin',
				'section' => 'wlbb_admin_index',
				'args' => array(
					'option_name' => 'wlbb_plugin',
					'label_for' => $key,
					'class' => 'ui-toggle'
				)
			);
		}

		$this->settings->setFields( $args );
	}
}