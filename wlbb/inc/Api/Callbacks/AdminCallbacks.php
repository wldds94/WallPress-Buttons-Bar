<?php 
/**
 * @link              walterlaidelli.com
 * @since             1.0.0
 * @package           Wlbb
 */
namespace Wlbb\Api\Callbacks;

use Wlbb\Base\BaseController;

class AdminCallbacks extends BaseController
{
	/**
	 * Return the page templates fo Dashboard Page
	 * @since    1.0.0
	 * 
	 * @return
	 */
	public function adminDashboard()
	{
		return require_once( "$this->plugin_path/templates/dashboard.php" );
	}

	/**
	 * Return the page templates fo Buttons Page
	 * @since    1.0.0
	 * 
	 * @return
	 */
	public function adminCustomButton()
	{
		return require_once( "$this->plugin_path/templates/button.php" );
	}

}