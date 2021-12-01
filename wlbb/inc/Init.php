<?php
/**
 * @link              walterlaidelli.com
 * @since             1.0.0
 * @package           Wlbb
 */
namespace Wlbb;

final class Init
{
	/**
	 * Store all the classes inside an array
	 * @since    1.0.0
	 * 
	 * @return array Full list of classes
	 */
	public static function get_services() 
	{
		return [
			Base\Enqueue::class,
            Base\SettingsLinks::class,
            Controllers\Dashboard::class,
            Controllers\CustomButton::class,
			Controllers\GeneralSettings::class,
			Controllers\Style::class
		];
	}

	/**
	 * Loop through the classes, initialize them, 
	 * and call the register() method if it exists
	 * @since    1.0.0
	 * 
	 * @return
	 */
	public static function register_services() 
	{
		foreach ( self::get_services() as $class ) {
			$service = self::instantiate( $class );
			if ( method_exists( $service, 'register' ) ) {
				$service->register();
			}
		}
	}

	/**
	 * Initialize the class
	 * @since    1.0.0
	 * 
	 * @param  class $class    class from the services array
	 * @return class instance  new instance of the class
	 */
	private static function instantiate( $class )
	{
		$service = new $class();

		return $service;
	}
}