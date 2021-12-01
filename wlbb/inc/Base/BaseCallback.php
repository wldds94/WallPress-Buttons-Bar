<?php 
/**
 * @link              walterlaidelli.com
 * @since             1.0.0
 * @package           Wlbb
 */
namespace Wlbb\Base;

class BaseCallback {

	public $option;

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

	public function __contruct( $args = array() )
	{
		$this->setArgs( $args );
	}

	public function setData( $args )
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

		$this->value = isset( $this->option[$this->name] ) ? $this->option[$this->name] : '';

		return $this;

	}

    /* ------------------------------------------------------------------------ *
	* ######## DISPLAY FIELDS CALLBACKS
	* ------------------------------------------------------------------------ */
    /**
	 * Generate HTML for displaying fields
	 * @since  1.0.0
	 * 
	 * @param  array $args Field data
	 * @return
	 */
	public function displayOptionsField( $args )
	{
		$this->setData( $args );

		$html = '';
		switch ( $this->type ) {
			case 'hidden':
				$html .= '<input id="' . esc_attr( $this->name ) . '" type="' . esc_attr( $this->type ) . '" name="' . esc_attr( $this->option_name ) . '[' . esc_attr( $this->name ) . ']" value="' . esc_attr( $this->value ) . '"/>' . "\n";
				break;

			case 'text':
				$html .= '<input id="' . esc_attr( $this->name ) . '" class="regular-text" type="' . esc_attr( $this->type ) . '" name="' . esc_attr( $this->option_name ) . '[' . esc_attr( $this->name ) . ']" placeholder="' . esc_attr( $this->placeholder ) . '" value="' . esc_attr( $this->value ) . '"/>' . "\n";
				break;

			case 'password':
				echo 'Not Provided Yet.';
				break;

			case 'number':
				$html .= '<input id="' . esc_attr( $this->name ) . '" class="regular-text" type="' . esc_attr( $this->type ) . '" name="' . esc_attr( $this->option_name ) . '[' . esc_attr( $this->name ) . ']" placeholder="' . esc_attr( $this->placeholder ) . '" value="' . esc_attr( $this->value ) . '" max="' . esc_attr( $this->max ) . '"/>' . "\n";
				break;

			case 'text_secret':
				$html .= '<input id="' . esc_attr( $this->name ) . '" type="text" name="' . esc_attr( $this->option_name ) . '[' . esc_attr( $this->name ) . ']" placeholder="' . ( isset( $args['placeholder'] ) ? esc_attr( $args['placeholder'] ) : '' ) . '" value=""/>' . "\n";
				break;

			case 'textarea':
				$html .= '<textarea id="' . esc_attr( $this->name ) . '" rows="5" cols="50" name="' . esc_attr( $this->option_name ) . '[' . esc_attr( $this->name ) . ']" placeholder="' . ( isset( $args['placeholder'] ) ? esc_attr( $args['placeholder'] ) : '' ) . '">' . esc_textarea( $this->value ) . '</textarea><br/>'. "\n";
				break;

			case 'checkbox':
				$checked = isset($this->option[$this->name]) ? ($this->option[$this->name] ? true : false) : false;
		
				$html .= '<div class="' . esc_attr( $this->classes ) . '">';
					$html .= '<input type="checkbox" id="' . esc_attr( $this->name ) . '" name="' . esc_attr( $this->option_name ) . '[' . esc_attr( $this->name ) . ']' . '" value="1" 
								class="" ' . esc_attr( $checked ? 'checked' : '' ) . '>';
					$html .= '<label for="' . esc_attr( $this->name ) . '">';
						$html .= '<div></div>';			
					$html .= '</label>';
				$html .= '</div>';
				break;

			case 'checkbox_multi':
				foreach( $this->options as $k => $v ) {
					$checked = false;
					if( in_array( $k, $this->value ) ) {
						$checked = true;
					}
					$html .= '<label for="' . esc_attr( $this->name ) . '_' .  esc_attr( $k ) . '"><input type="checkbox" ' . checked( $checked, true, false ) . ' name="' . esc_attr( $this->option_name ) . '[' . esc_attr( $this->name ) . '][]" value="' . esc_attr( $k ) . '" id="' . esc_attr( $this->name . '_' . $k ) . '" /> ' . esc_html( $v ) . '</label> ';
				}
				break;

			case 'radio':
				foreach( $this->options as $k => $v ) {
					$checked = false;
					if( $k == $this->value ) {
						$checked = true;
					}
					$html .= '<label for="' . esc_attr( $this->name ) . '_' .  esc_attr( $k ) . '"><input type="radio" ' . checked( $checked, true, false ) . ' name="' . esc_attr( $this->option_name ) . '[' . esc_attr( $this->name ) . ']" value="' . esc_attr( $k ) . '" id="' . esc_attr( $this->name . '_' . $k ) . '" /> ' . esc_html( $v ) . '</label> ';
				}
				break;

			case 'select':				
				$html .= '<select name="' . esc_attr( $this->option_name ) . '[' . esc_attr( $this->name ) . ']" id="' . esc_attr( $this->name ) . '" class="regular-text">';
					$html .= '<option value="" selected>Choose an option</option>';
				if ( $this->value != '' ) {
					foreach( $this->options as $k => $v ) {
						$selected = false;
						if( $k == $this->value ) {
							$selected = true;
						}
						$html .= '<option ' . selected( $selected, true, false ) . ' value="' . esc_attr( $k ) . '">' . esc_html( $v ) . '</option>';
					}
				} else {
					foreach( $this->options as $k => $v ) {
						$selected = '';
						/*if( $k == $data ) {
							$selected = true;
						}*/
						$html .= '<option ' . esc_attr( $selected ) . ' value="' . esc_attr( $k ) . '">' . $v . '</option>';
					}
				}
				
				$html .= '</select> ';
				break;

			case 'select_multi':
				$html .= '<select name="' . esc_attr( $this->option_name ) . '[' . esc_attr( $this->name ) . '][]" id="' . esc_attr( $this->name ) . '" multiple="multiple">';
				foreach( $this->options as $k => $v ) {
					$selected = false;
					if( in_array( $k, $this->value ) ) {
						$selected = true;
					}
					$html .= '<option ' . selected( $selected, true, false ) . ' value="' . esc_attr( $k ) . '" />' .  esc_html( $v ) . '</label> ';
				}
				$html .= '</select> ';
				break;

			case 'image':
				$image_thumb = '';
				if( $this->value ) {
					$image_thumb = wp_get_attachment_thumb_url( $this->value );
				}
				$html .= '<img id="' . esc_attr( $this->option_name ) . '_preview" class="image_preview" src="' . esc_url( $image_thumb ) . '" /><br/>' . "\n";
				$html .= '<input id="' . esc_attr( $this->option_name ) . '_button" type="button" data-uploader_title="' . __( 'Upload an image' , 'plugin_textdomain' ) . '" data-uploader_button_text="' . __( 'Use image' , 'plugin_textdomain' ) . '" class="image_upload_button button" value="'. __( 'Upload new image' , 'plugin_textdomain' ) . '" />' . "\n";
				$html .= '<input id="' . esc_attr( $this->option_name ) . '_delete" type="button" class="image_delete_button button" value="'. __( 'Remove image' , 'plugin_textdomain' ) . '" />' . "\n";
				$html .= '<input id="' . esc_attr( $this->option_name ) . '" class="image_data_field" type="hidden" name="' . esc_attr( $this->option_name ) . '" value="' . esc_attr( $this->value ) . '"/><br/>' . "\n";
				break;

			case 'color': ?>
				<div class="color-picker" style="position:relative;">
			        <input type="color" name="<?php echo esc_attr( $this->option_name ) . '[' . esc_attr( $this->name ) . ']'?>" class="color" value="<?php //echo $value; ?>" />
			        <div style="position:absolute;background:#FFF;z-index:99;border-radius:100%;" class="colorpicker"></div>
			    </div>
			    <?php
				break;

			default:
    			echo "Not Find!";
				break;

		}

		switch( $args['type'] ) {

			case 'checkbox_multi':
			case 'radio':
			case 'select_multi':
				$html .= '<br/><span class="description">' . esc_attr( $this->description ) . '</span>';
				break;

			case 'checkbox':
				$html .= '';
				break;

			default:
				$html .= '<label for="' . esc_attr( $this->name ) . '"><span class="description">' . esc_attr( $this->description ) . '</span></label>' . "\n";
				break;
		}

		echo $html;
	}

	/**
	 * Singular Checkbox field
	 * @since    1.0.0
	 * 
     * @param    array     $args
	 * @return
	 */
	public function checkboxField( $args )
	{
		$name = esc_attr( $args['label_for'] );
		$classes = esc_attr( $args['class'] );
		$option_name = esc_attr( $args['option_name'] );
		$checkbox = get_option( $option_name );
		$checked = isset($checkbox[$name]) ? ($checkbox[$name] ? true : false) : false;

		//echo $checked;
		
		echo '<div class="' . $classes . '">';
			echo '<input type="checkbox" id="' . $name . '" name="' . $option_name . '[' . $name . ']' . '" value="1" 
						class="" ' . esc_attr( $checked ? 'checked' : '' ) . '>';
			echo '<label for="' . $name . '">';
				echo '<div></div>';			
			echo '</label>';
		echo '</div>';
	}

	/**
	 * Post_Types Checkbox fields
	 * @since    1.0.0
	 * 
     * @param    array     $args
	 * @return
	 */
	public function checkboxPostTypesField( $args )
	{
		$output = '';
		$name = esc_attr( $args['label_for'] );
		$classes = esc_attr( $args['class'] );
		$option_name = esc_attr( $args['option_name'] );
		// $checked = false;

		$checkbox = get_option( $option_name );

		$post_types = get_post_types( array( 'show_ui' => true ) );

		foreach ($post_types as $post_type) {

			$checked = isset( $checkbox[ $name ][ $post_type ] ) ?: false;
	
			echo '<div class="' . $classes . ' mb-10">';
				echo '<input type="checkbox" id="' . esc_attr( $post_type ) . '" name="' . $option_name . '[' . $name . '][' . esc_attr( $post_type ) . ']" value="1" class="" ' . esc_attr( $checked ? 'checked' : '' ) . '>';
				echo '<label for="' . esc_attr( $post_type ) . '">';
					echo '<div></div>';			
				echo '</label>';
				echo ' <strong>' . esc_html( $post_type ) . '</strong>';
			echo '</div>';			
		}

		echo $output;
	}

	/* ------------------------------------------------------------------------ *
	* ######## SANITIZE CALLBACKS
	* ------------------------------------------------------------------------ */
	/**
	 * Clean array
	 * Remove all key that is not inputted by value - acceot array of array
	 * @since  1.0.0
	 * 
	 * @param  array/array    $input Inputted value
	 * @return array          $output Validated value    
	 */
	public function generalArraySanitize( $input )
    {		
        $output = array();
        foreach ($input as $key => $value) {
			if( is_array( $value ) ) {
				$value = $this->cleanArray( $value );
			}
            if ( $value != '' && $value != null && ! empty( $value ) ) {
                $output[$key] = $value;
            }
        }

		return $output;
    }
	
	/**
	 * Clean array
	 * Remove all key that is not inputted by value
	 * @since   1.0.0
	 * 
	 * @param   array    $array Inputted value
	 * @return  array    $output Validated value    
	 */
	public function cleanArray( $array )
	{
		$output = array();
        foreach ($array as $key => $value) {
            if ( $value != '' || $value != null ) {
                $output[$key] = $value;
            }
        }

		return $output;
	}

    /**
	 * Validate general text settings field
	 * @since  1.0.0
	 * 
	 * @param  string   $data    Inputted value
	 * @return string   $value   Validated value
	 */
	public function wlb_validate_field( $data ) {
		if( $data && strlen( $data ) > 0 && $data != '' ) {
			$data = urlencode( strtolower( str_replace( ' ' , '-' , $data ) ) );
		}
		return $data;
	}

    /**
	 * Validate url settings field
	 * @since  1.0.0
	 * 
	 * @param  string   $data    Inputted value
	 * @return string   $value   Validated value
	 */
	public function wlb_validate_url_field( $data ) {
		if( $data && strlen( $data ) > 0 && $data != '' ) {
			$data = esc_url_raw( strip_tags( stripslashes( $data ) ) );
		}
		return $data;
	}

	/**
	 * Validate class & id settings field
	 * @since  1.0.0
	 * 
	 * @param  string   $data    Inputted value
	 * @return string   $value   Validated value
	 */
	public function wlb_validate_classes_field( $data )
	{
		$classes = explode(" ", $data);
		$value = '';
		foreach ($classes as $index => $class ) {
			$value .= sanitize_text_field( sanitize_html_class( $class ) ) . ' ';
		}
		return $value;	
	}

	/**
	 * Validate color settings field
	 * @since  1.0.0
	 * 
	 * @param  string   $data    Inputted value
	 * @return string   $value   Validated value
	 */
	public function wlb_validate_color_field( $data )
	{
		$value = sanitize_hex_color( $data );
		return $value;	
	}

}