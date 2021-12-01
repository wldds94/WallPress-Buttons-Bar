<?php 
/**
 * @link              walterlaidelli.com
 * @since             1.0.0
 * @package           Wlbb
 */
namespace Wlbb\Base;

use Wlbb\Base\BaseController;

class SettingsLinks extends BaseController {

    public function register()
    {
        add_filter( 'plugin_action_links_' . $this->plugin, array($this, 'settings_links' ) );
    }

    /**
	 * Add settings link to plugin list table
	 * @param  array $links Existing links
	 * @return array $links Modified links
	 */
    public function settings_links( $links )
    {
        $settings_link = '<a href="admin.php?page=wlbb_plugin">Settings</a>';
		array_push( $links, $settings_link );
		return $links;
    }
}