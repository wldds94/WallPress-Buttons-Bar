<?php
/**
 * @link              walterlaidelli.com
 * @since             1.0.0
 * @package           Wlaiddd
 */
namespace Wlbb\Base;

class Deactivate
{
	/**
	 * Called by Deactivation Hook
	 * @since   1.0.0
	 * 
	 * @return
	 */
	public function deactivate() {
		flush_rewrite_rules();
	}
}