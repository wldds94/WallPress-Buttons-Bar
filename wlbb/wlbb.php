<?php

/**
 * @link              walterlaidelli.com
 * @since             1.0.0
 * @package           Wlbb
 *
 * @wordpress-plugin
 * Plugin Name:       WallPress Buttons Bar
 * Description:       A Buttons Board Plugin customizable for WordPress
 * Version:           1.0.0
 * Author:            Walter Laidelli
 * Author URI:        walterlaidelli.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

 /*
	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

	Copyright 2005-2015 Automattic, Inc.
*/
// If this file is called directly, abort.
defined( 'ABSPATH' ) or die( 'Hey, what are you doing here? You silly human!' );
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WLBB_VERSION', '1.0.0' );

if ( ! defined( 'WLBB_PLUGIN_PATH' ) ) {
	define( 'WLBB_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'WLBB_PLUGIN_URL' ) ) {
	define( 'WLBB_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'WLBB_PLUGIN' ) ) {
	define( 'WLBB_PLUGIN', plugin_basename( __FILE__ ) );
}

// Require once the Composer Autoload
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

/**
 * The code that runs during plugin activation.
 * This action is documented in Inc\Base\Activate.php
 */
function activate_wlbb() {
	$activator = new Wlbb\Base\Activate();
	$activator->activate();
}
register_activation_hook( __FILE__, 'activate_wlbb' );

/**
 * The code that runs during plugin deactivation.
 * This action is documented in Inc\Base\Deactivate.php
 */
function deactivate_wlbb() {
	$deactivator = new Wlbb\Base\Deactivate();
	$deactivator->deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_wlbb' );

/**
 * Begins execution of the plugin.
 *
 * Initialize all the core classes of the plugin.
 * 
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 * 
 * @since    1.0.0
 */
if ( class_exists( 'Wlbb\\Init' ) ) {
	Wlbb\Init::register_services();
}
