<?php 
/**
 * @link              walterlaidelli.com
 * @since             1.0.0
 * @package           Wlbb
 */
namespace Wlbb\Api\Callbacks;

use Wlbb\Api\SanitizeApi;
use Wlbb\Base\BaseCallback;

class CustomButtonCallbacks extends BaseCallback {

	public $option;

	// $args of the field
	public $name;
	public $option_name;
	public $index;
	public $type;
	public $options;
	public $default;
	public $placeholder;
	public $classes;
	public $readonly;
	public $required;
	public $description;
	public $max;

	public $sanitizer;

	/**
	 * Initialize the class with the arguments of the field
	 * @since    1.0.0
	 * 
	 * @param  array $args    the args of the field options
	 * @return
	 */
	public function __contruct( $args = array() )
	{
		$this->setArgs( $args );

	}

	/**
	 * Instanciate the arguments of the field like property of the class
	 * Instaciate the sanitizer
	 * @since    1.0.0
	 * 
	 * @param  array $args    the args of the field options
	 * @return class $this
	 */
	public function setArgs( $args )
	{
		$this->name = isset( $args['label_for'] ) ? $args['label_for'] : '';
		$this->option_name = isset( $args['option_name'] ) ? $args['option_name'] : '';
		$this->index = isset( $args['index'] ) ? $args['index'] : '';
		$this->type = isset( $args['type'] ) ? $args['type'] : '';
		$this->options = isset( $args['options'] ) ? $args['options'] : '';
		$this->default = isset( $args['default'] ) ? $args['default'] : '';
		$this->placeholder = isset( $args['placeholder'] ) ? $args['placeholder'] : '';
		$this->classes = isset( $args['class'] ) ? $args['class'] : '';
		$this->readonly = isset( $args['readonly'] ) ? $args['readonly'] : '';
		$this->required = isset( $args['required'] ) ? $args['required'] : '';
		$this->description = isset( $args['description'] ) ? $args['description'] : '';
		$this->max = isset( $args['max'] ) ? $args['max'] : '';
		
		$this->option = get_option( $this->option_name );

		if( isset($_POST['edit_button']) ) {
			$this->sanitizer = new SanitizeApi();
			$this->value = isset( $this->option[ $this->sanitizer->sanitizeId( $_POST['edit_button'] ) ][$this->name] ) ? $this->option[ $_POST['edit_button'] ][$this->name] : '';
		} else {
			$this->value = isset( $this->option[$this->index][$this->name] ) ? $this->option[$this->index][$this->name] : '';
		}

		return $this;

	}

	/**
	 * Display the color fields
	 * @since    1.0.0
	 * 
	 * @param  array $args    the args of the field options
	 * @return
	 */
	public function buttonColorField( $args ) 
	{
		$this->setArgs( $args );

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'iris', admin_url( 'js/iris.min.js' ), array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), false, 1 );
		wp_enqueue_script('wp-color-picker', admin_url( 'js/color-picker.min.js' ), array( 'iris' ), false, 1 );

	?>
		<div class="color-picke wl_my_color_picker_container" style="position:relative;">
			<input id="<?php echo esc_attr( $this->name ); ?>" class="wl_my_color_picker" name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->name ) . ']'?>" type="text" value="<?php echo esc_attr( $this->value ); ?>" data-default-color=""/>
	    </div>
	<?php
	}

	/**
	 * Display the number fields
	 * @since    1.0.0
	 * 
	 * @param  array $args    the args of the field options
	 * @return
	 */
	public function buttonNumberField( $args )
	{ 
		$this->setArgs( $args );
	?>
		<input type="number" class="regular-text" name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->name ) . ']'; ?>" id="<?php echo esc_attr( $this->name ); ?>" placeholder="<?php echo esc_attr( $this->placeholder ); ?>" 
			value="<?php echo esc_attr( $this->value ); ?>" max="<?php echo esc_attr( $this->max != '' ? $this->max : 50 ); ?>">
		<label for="<?php echo esc_attr( $this->name ); ?>"><span class="description"><?php echo esc_html( $this->description ); ?></span></label>
	<?php
	}

	/**
	 * Display the media fields
	 * @since    1.0.0
	 * 
	 * @param  array $args    the args of the field options
	 * @return
	 */
	public function buttonMediaField( $args )
	{
		$this->setArgs( $args );
	?>
		<div id="<?php echo esc_attr( $this->classes ); ?>" class="<?php echo esc_attr( $this->classes ); ?>">
			<p>
				<input type="text"  class="widefat wl-image-upload" id="<?php echo esc_attr( $this->name ); ?>" name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->name ) . ']'; ?>" value="<?php echo esc_attr( $this->value ); ?>">
				<button type="button" class="button button-primary wl-js-image-upload">Upload Icon</button>
			</p>
		</div>
	<?php
	}

	/**
	 * Display the radio fields
	 * @since    1.0.0
	 * 
	 * @param  array $args    the args of the field options
	 * @return
	 */
	public function buttonRadioField( $args )
	{
		$this->setArgs( $args );
	?>
		<div class="wlbb-radio-container">
			<?php foreach( $this->options as $k => $v ) :
				$wl_extra_class = '';
				$checked = false;
				if ($this->value != '') {
					if ($k == $this->value) {
						$checked = true;
					} elseif ( $k == '' ) {
						$wl_extra_class = 'unset-radio-button';
					}
				} elseif( $k == '' ) {
					$checked = true;
				}
			?>
			<div id="<?php echo  esc_attr( $this->classes ) . '_' . esc_attr( $k ); ?>" class="wlbb-radio">	
				<input type="radio" <?php echo checked( $checked, true, false ); ?> name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->name ) . ']'; ?>" 
					value="<?php echo esc_attr( $k ); ?>" id="<?php echo esc_attr( $this->name . '_' . $this->index . '_' . $k ); ?>" />
				<label for="<?php echo esc_attr( $this->name ) . '_' . esc_attr( $this->index ) . '_' . esc_attr( $k ); ?>" class="radio-label wlbb-radio-button <?php echo esc_attr( $wl_extra_class ); ?>">
					<?php echo esc_attr( $v ); ?>
				</label>
			</div>
			<?php endforeach; ?>
		</div>
		<label for="<?php echo esc_attr( $this->name ); ?>"><span class="description"><?php echo esc_html( $this->description ); ?></span></label>
	<?php
	}

	/**
	 * Display the select fields
	 * @since    1.0.0
	 * 
	 * @param  array $args    the args of the field options
	 * @return
	 */
	public function buttonSelectField( $args )
	{
		$this->setArgs( $args );

		if( isset($_POST['edit_button']) ) {
			$post = $this->sanitizer->sanitizeId( $_POST['edit_button'] );
			$select = isset( $this->option[ $post ][ $this->name ] ) ? $this->option[ $post ][ $this->name ] : '';
		} else $select = '';
	?>
		<select name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->name ) . ']'; ?>" id="<?php echo esc_attr( $this->name ); ?>" class="regular-text" >
			<option value="">Choose an option</option>
			<?php if ($select != '') : ?>
				<?php foreach( $args['options'] as $k => $v ) : 
					$selected = false;
					if( $k == $select ) {
						$selected = true;
					}
				?>
					<option <?php /* echo */ selected( $selected, true, true ) ?> value="<?php echo esc_attr( $k ); ?>"><?php echo esc_html( $v ); ?></option>
				<?php endforeach; ?>
			<?php else : ?>
				<?php foreach( $args['options'] as $k => $v ) : 
					$selected = false;
				?>
					<option <?php /* echo */ selected( $selected, true, true ) ?> value="<?php echo esc_attr( $k ); ?>"><?php echo esc_html( $v ); ?></option>
				<?php endforeach; ?>
			<?php endif; ?>
		</select>
		<label for="<?php echo esc_attr( $this->name ); ?>"><span class="description"><?php echo esc_html( $this->description ); ?></span></label><br>
	<?php
	}

	/**
	 * Display the ID field
	 * @since    1.0.0
	 * 
	 * @param  array $args    the args of the field options
	 * @return
	 */
	public function buttonIdField( $args )
	{ 	
		$this->setArgs( $args );
		if( isset($_POST['edit_button']) ) $this->readonly = 'readonly';
	?>
		<input type="text" class="regular-text <?php echo $this->classes?> wlbb-button-id-field" id="<?php echo esc_attr( $this->name ); ?>" name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->name ) . ']'; ?>" value="<?php echo esc_attr( $this->value ); ?>" placeholder="<?php echo esc_attr( $this->placeholder ); ?>" 
			<?php echo esc_attr( $this->required ); ?> <?php echo esc_attr( $this->readonly ); ?> >
		<label for="<?php echo esc_attr( $this->name ); ?>"><span class="description"><?php echo esc_html( $this->description ); ?></span></label><br>
	<?php
	}

	/**
	 * Display the general text fields
	 * @since    1.0.0
	 * 
	 * @param  array $args    the args of the field options
	 * @return
	 */
	public function buttonTextField( $args )
	{ 	
		$this->setArgs( $args );
		if( isset($_POST['edit_button']) ) {
			$input = get_option( $this->option_name );
			$post = $this->sanitizer->sanitizeId( $_POST['edit_button'] );
			$this->value = isset( $input[ $post ][$this->name] ) ? $input[ $post ][$this->name] : '';
		}
	?>
		<input type="text" class="regular-text <?php echo $this->classes?>" id="<?php echo esc_attr( $this->name )?>" name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->name ) . ']'; ?>" value="<?php echo esc_attr( $this->value ); ?>" placeholder="<?php echo esc_attr( $this->placeholder ); ?>" 
			<?php echo esc_attr( $this->required ); ?> <?php echo esc_attr( $this->readonly ); ?> >
		<label for="<?php echo esc_attr( $this->name )?>"><span class="description"><?php echo esc_html( $this->description ); ?></span></label><br>
	<?php
	}

	/**
	 * Display the checkbox fields
	 * @since    1.0.0
	 * 
	 * @param  array $args    the args of the field options
	 * @return
	 */
	public function buttonCheckboxField( $args )
	{
		$this->setArgs( $args );
		if( isset($_POST['edit_button']) ) {
			$checkbox = get_option( $this->option_name );
			$post = $this->sanitizer->sanitizeId( $_POST['edit_button'] );
			$checked = isset( $checkbox[ $post ][ $this->name ] ) ? ($checkbox[ $post ][ $this->name ] ? true : false) : false;
		} else $checked = false;
	?>		
		<div class="<?php echo $this->classes?>">
			<input type="checkbox" id="<?php echo esc_attr( $this->name ) . '_' . esc_attr( $this->index ); ?>" name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->name ) . ']'; ?>" value="1" class="" <?php echo esc_attr( $checked ? 'checked' : '' ); ?> >
			<label for="<?php echo esc_attr( $this->name . '_' . $this->index ); ?>">
				<div></div>		
			</label>
		</div>
		<label for="<?php echo esc_attr( $this->name )?>"><span class="description"><?php echo esc_attr( $this->description ); ?></span></label><!-- <br> -->
	<?php
	}

	/**
	 * Display the URL fields
	 * @since    1.0.0
	 * 
	 * @param  array $args    the args of the field options
	 * @return
	 */
	public function buttonUrlField( $args )
	{
		$this->setArgs( $args );
		$select = '';
		if( isset($_POST['edit_button']) ) {
			$input = get_option( $this->option_name );
			$post = $this->sanitizer->sanitizeId( $_POST['edit_button'] );
			$this->value = isset( $input[ $post ][$this->name] ) ? $input[ $post ][$this->name] : '';
			$select = isset( $input[ $post ]['wp_post_id'] ) ? $input[ $post ]['wp_post_id'] : '';
		}

		$post_types = get_post_types( array( 'show_ui' => true ) );
		$types = array();
		foreach( $post_types as $post_type) {
			$types[] = $post_type;
		}

		$args = array(
			'posts_per_page'   => -1,
			'post_status'      => 'publish',
			'post_type'  	   => $types
		);
		$posts = get_posts( $args );
	?>
		<div class="wlbb-grid-col-2_5-3_5">
			<div>
				<input type="text" class="regular-text <?php echo esc_attr( $this->classes ); ?>" id="<?php echo esc_attr( $this->name )?>" name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->name ) . ']'; ?>" 
						value="<?php echo esc_url( $this->value ); ?>" placeholder="<?php echo esc_attr( $this->placeholder ); ?>" <?php echo esc_attr( $this->required ); ?> <?php echo esc_attr( $this->readonly ); ?> >
				<label for="<?php echo esc_attr( $this->name )?>"><span class="description"><?php echo esc_html( $this->description ); ?></span></label> <b>or</b> 
			</div>
				
			<div>
				<select class="regular-text wlbb-select-url" name="<?php echo esc_attr( $this->option_name ) . '[wp_post_id]'; ?>" id="wp_post_id" data-select="url">
					<option value="">Choose custom Post</option>
					<?php foreach( $posts as $index => $post ) : 
						$selected = false;
						if( isset( $post->ID ) ? $post->ID == $select : false ) {
							$selected = true;
						}
					?>
						<option value="<?php echo esc_attr( $post->ID ); ?>" <?php selected( $selected, true, true ) ?> data-url="<?php echo esc_url( get_post_permalink( $post->ID ) ); ?>">
							<?php echo esc_html( $post->post_title ); ?>
						</option>
					<?php endforeach; ?>
				</select>
				<button class="spin" id="wlbb-spin">
					<span>Select</span>
					<span>
						<svg viewBox="0 0 24 24">
						<path d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z" />
						</svg>
					</span>
				</button>

			</div>
		</div>
	<?php
	}

	/** ###############################
	 *  ######## SANITIZATION #########
	 */ ###############################
	/**
	 * Custom Button Callback for sanitization
	 * @since    1.0.0
	 * 
	 * @param  array $input    the inputs of the option
	 * @return array $output   the inputs cleaned and sanitized
	 */
	public function wlbbCustomButtonSanitize( $input )
	{
		$output = get_option('wlbb_plugin_button') ?: array();
		$this->sanitizer = new SanitizeApi();

		if ( isset($_POST["remove_button"]) ) {
			unset($output[ $this->sanitizer->sanitizeId( $_POST["remove_button"] ) ]);
			return $output;
		}

		if ( isset($_POST["save_button"]) ) {
			return $this->buttonSanitize();
		}
		
		return $output;
	}

	/**
	 * Clean the inputs options by the button form
	 * @since    1.0.0
	 * 
	 * @return
	 */
	public function buttonSanitize()
	{
		$my_input = !isset( $_POST['wlbb_plugin_button'] ) ? array() : ( is_array( $_POST['wlbb_plugin_button'] ) ? $_POST['wlbb_plugin_button'] : array() );

		$output = get_option('wlbb_plugin_button') ?: array();

		// Clean input from empty values
		$input_sanitize = parent::generalArraySanitize( $my_input );

		// Sanitization
		$input_sanitized = array();
		foreach($input_sanitize as $key => $val) { // echo $key . '<br>';
			if ( $val != '') {
				if( $key == 'button_id' || $key == 'extra_id' ) $input_sanitized[$key] = $this->sanitizer->sanitizeId( $val );
				elseif( $key == 'title_section' || $key == 'icon' || $key == 'icon_type' || $key == 'target' ) $input_sanitized[$key] = $this->sanitizer->sanitizeText( $val );
				elseif( $key == 'url' || $key == 'icon_upload' ) $input_sanitized[$key] = $this->sanitizer->sanitizeUrl( $val );
				elseif( $key == 'wp_post_id' || $key == 'border_radius' ) $input_sanitized[$key] = $this->sanitizer->sanitizeInteger( $val );
				elseif( $key == 'background_color' || $key == 'background_color_hover' || $key == 'icon_color' || $key == 'icon_color_hover' ) $input_sanitized[$key] = $this->sanitizer->sanitizeHexColor( $val );
				elseif( $key == 'extra_class' ) $input_sanitized[$key] = $this->sanitizer->sanitizeClassId( $val );
				elseif( $key == 'display_public' ) $input_sanitized[$key] = true;
			}
		}
		
		if ( count($output) == 0 ) {
			$output[ $input_sanitized['button_id'] ] = $input_sanitized;
			return $output;
		} else {
			foreach ($output as $key => $value) {
				if ( $input_sanitized['button_id'] === $key ) {
					$output[$key] = $input_sanitized;
				} else {
					$output[$input_sanitized['button_id']] = $input_sanitized;
				}
			}
		}

		die;

		return $output;
	}

	/**
	 * Print the subtitle of the section custom button manager
	 * @since    1.0.0
	 * 
	 * @return
	 */
	public function customBtnSectionManager()
    {
        echo 'Customize your button as you want.';
    }

}
