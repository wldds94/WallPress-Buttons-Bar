<?php 
/**
 * @link              walterlaidelli.com
 * @since             1.0.0
 * @package           Wlbb
 */
namespace Wlbb\Api\Callbacks;

use Wlbb\Base\BaseCallback;
use Wlbb\Api\SanitizeApi;

class GeneralCallbacks extends BaseCallback {

    public function generalSectionManager()
	{
		echo 'Set the General settings for Buttons.';
	}

	public function textField ( $args )
	{
		//var_dump( $args );
		$name = $args['label_for'];
		$option_name = $args['option_name'];
		$value = '';
		//$readonly = '';
		
		if( isset($_POST['edit_taxonomy']) ) {
			$input = get_option( $option_name );
			$value = $input[ $_POST['edit_taxonomy'] ][ $name ];
			//$readonly = ( $name == 'post_type' ) ? 'readonly' : '';
		}
		?>

		<input type="text" class="regular-text" id="<?php echo esc_attr( $name ); ?>" name="<?php echo esc_attr( $option_name ) . '[' . esc_attr( $name ) . ']'; ?>" value="<?php echo esc_attr( $value ); ?>" placeholder="<?php echo esc_attr( $args['placeholder'] ); ?>" required>

		<?php
	}

	public function generalAnimationStyleField( $args )
	{
		$name = $args['label_for'];
		$classes = isset( $args['class'] ) ? $args['class'] : '';
		$index = isset( $args['array'] ) ? $args['array'] : '';
		
		$option_name = $args['option_name'];
		$option = get_option( $option_name );

		$animation = isset( get_option( $option_name )[$name] ) ? $option[$name] : '';

		$animation_name = isset(  $animation['animation_name'] ) ? $animation['animation_name'] : '';
		$animation_duration = isset(  $animation['animation_duration'] ) ? $animation['animation_duration'] : '';
		$animation_iteration = isset(  $animation['animation_iteration'] ) ? $animation['animation_iteration'] : '';

		?>

		<select name="<?php echo esc_attr( $option_name . '[' . $name . '][animation_name]' ); ?>" id="animation_name" class="regular-text" >
			<option value="">Choose an option</option>
			<?php
				foreach( $args['options'] as $k => $v ) {
					$selected = false;
					if( $animation_name ) {
						if( $k == $animation_name ) {
							$selected = true;
						}
					} ?>
						<option <?php selected( $selected, true, true ) ?>value="<?php echo esc_attr( $k ); ?>"><?php echo esc_attr( $v ); ?></option>
					<?php
				} ?>
		</select>
		<label for="<?php echo esc_attr( $name ); ?>"><span class="description">Select the Animation Name</span></label><br><br>

		<input type="number" name="<?php echo esc_attr( $option_name . '[' . $name . '][animation_duration]' ); ?>" id="animation_duration" class="regular-text" 
				value="<?php echo esc_attr( $animation_duration ); ?>" max="" />
		<label for="<?php echo esc_attr( $name ); ?>"><span class="description">Insert the duration of Animation in Milliseconds - Default 3000ms (3s)</span></label><br><br>
	
		<input type="number" name="<?php echo esc_attr( $option_name . '[' . $name . '][animation_iteration]' ); ?>" id="animation_iteration" class="regular-text" 
				value="<?php echo esc_attr( $animation_iteration ); ?>" max="" />
		<label for="<?php echo esc_attr( $name ); ?>"><span class="description">Insert the iteration-count of Animation - Blanck for "infinite"</span></label>

		<?php
	}

	public function displayModeFields( $args )
	{
		$this->setData( $args );
		$checked = isset($this->option[$this->name][$this->name]) ? ($this->option[$this->name][$this->name] ? true : false) : false;
		$interval = isset($this->option[$this->name]['single_display_interval']) ? $this->option[$this->name]['single_display_interval'] : '';

		?>
		<div class="<?php echo esc_attr( $this->classes ); ?>">
			<input type="checkbox" id="<?php echo esc_attr( $this->name ); ?>" name="<?php echo esc_attr( $this->option_name . '[' . $this->name . ']'  . '[' . $this->name . ']' )?>" value="1" 
						class="" <?php echo esc_attr( $checked ? 'checked' : '' ); ?>>
			<label for="<?php echo esc_attr( $this->name ); ?>">
				<div></div>		
			</label>
		</div><br>

		<input type="number" name="<?php echo esc_attr( $this->option_name . '[' . $this->name . '][single_display_interval]' ); ?>" id="single_display_interval" class="regular-text" 
				value="<?php echo esc_attr( $interval ); ?>" max="" />
		<label for="<?php echo esc_attr( $this->name ); ?>"><span class="description">Set the interval for switch icons</span></label>
	
	<?php
	}

	/** ###############################
	 *  ######## SANITIZATION #########
	 */ ###############################
	/**
	 * General Options Callback for sanitization
	 * @since    1.0.0
	 * 
	 * @param  array $input    the inputs of the option
	 * @return array $output   the inputs cleaned and sanitized
	 */
	public function generalSanitize( $input )
	{
		$output = array();
        
		$input = parent::generalArraySanitize( $input );

		// Sanitization
		$sanitize = new SanitizeApi();

		foreach($input as $key => $value) { // echo $key . '<br>';
			if ($value != '') {
				if( $key == 'single_display_button' ) $input_sanitized[$key] = $sanitize->sanitizeSingleDisplay( $value );
				elseif( $key == 'size' || $key == 'border_radius' || $key == 'delay' || $key == 'timing_show_mode' || $key == 'mobile_switch' ) $input_sanitized[$key] = $sanitize->sanitizeInteger( $value );
				elseif( $key == 'position' || $key == 'default_style' || $key == 'box_button_style' || $key == 'show_mode' ) $input_sanitized[$key] = $sanitize->sanitizeText( $value );
				elseif( $key == 'mobile_only' ) $input_sanitized[$key] = $sanitize->sanitizeBoolean( $value );
				elseif( $key == 'post_objects' ) $input_sanitized[$key] = $sanitize->sanitizeBooleanArray( $value );
				elseif( $key == 'animation_style' ) $input_sanitized[$key] = $sanitize->sanitizeAnimationStyle( $value );
			}
		}

		return $input_sanitized;
	}
}