<?php 
/**
 * @link              walterlaidelli.com
 * @since             1.0.0
 * @package           Wlbb
 */
namespace Wlbb\Api\Callbacks;

use Wlbb\Base\BaseController;

class DashboardCallbacks extends BaseController
{
	/**
	 * Display the checkbox fields
	 * @since    1.0.0
	 * 
	 * @param  array $input    the input of the options
	 * @return  array $output   Inputted Sanitized
	 */
	public function chekboxSanitize( $input )
	{
		$output = array();

		foreach ($this->managers as $key => $value) {
			$output[$key] = isset($input[$key]) ? true : false;
		}
		
		return $output;
	}

	/**
	 * Print the subtitle of the section manager
	 * @since    1.0.0
	 * 
	 * @return
	 */
	public function adminSectionManager()
	{
		echo 'Manage the Features activating the checkboxes from the following list.';
	}

	/**
	 * Display the checkbox fields
	 * @since    1.0.0
	 * 
	 * @param  array $args    args of the field
	 * @return
	 */
	public function checkboxField( $args )
	{
		$name = esc_attr( $args['label_for'] );
		$classes = esc_attr( $args['class'] );
		$option_name = esc_attr( $args['option_name'] );
		$checkbox = get_option( $option_name );
		$checked = isset($checkbox[$name]) ? ($checkbox[$name] ? true : false) : false;
		
		echo '<div class="' . $classes . '">';
			echo '<input type="checkbox" id="' . $name . '" name="' . $option_name. '[' . $name . ']' . '" value="1" ' . esc_attr( $checked ? 'checked' : '' ) . '>';
			echo '<label for="' . $name . '">';
				echo '<div></div>';			
			echo '</label>';
		echo '</div>';
	}
}