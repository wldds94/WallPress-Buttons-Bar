<?php 
/**
 * @link              walterlaidelli.com
 * @since             1.0.0
 * @package           Wlbb
 */
namespace Wlbb\Api;

class SanitizeApi {

    /* ---------------------------------------------------- *
	*  -------------- SANITIZE CALLBACKS
	*  ---------------------------------------------------- */

	/**
	 * General sanitizazion
	 */

    /**
	 * Validate ID settings field
	 * @param  string $data Inputted value
	 * @return string       Validated value
	 */
    public function sanitizeId( $data )
    {
        if( $data && strlen( $data ) > 0 && $data != '' ) {
			$value = urlencode( strtolower( str_replace( ' ' , '-' , $data ) ) );
		}
		return $value;
    }

	/**
	 * Validate TEXT settings field
	 * @param  string $data Inputted value
	 * @return string       Validated value
	 */
    public function sanitizeText( $data )
    {
        if( $data && strlen( $data ) > 0 && $data != '' ) {
			$value = sanitize_text_field( $data );
		}
		return $value;
    }

    /**
	 * Validate URL settings field
	 * @param  string $data Inputted value
	 * @return string       Validated value
	 */
	public function sanitizeUrl( $data ) {
		if( $data && strlen( $data ) > 0 && $data != '' ) {
			$value = esc_url_raw( strip_tags( stripslashes( $data ) ) );
		}
		return $value;
	}

    /**
	 * Validate EXTRA-CLASS &&& EXTRA-ID settings field
	 * @param  string $data Inputted value
	 * @return string       Validated value
	 */
	public function sanitizeClassId( $data )
	{
		$classes = explode(" ", $data);
		$value = '';
		foreach ($classes as $index => $class ) {
			$value .= sanitize_text_field( sanitize_html_class( $class ) ) . ' ';
		}
		
		return rtrim( $value, ' ' );	
	}

    /**
	 * Validate COLOR settings field
	 * @param  string $data Inputted value
	 * @return string       Validated value
	 */
	public function sanitizeHexColor( $data )
	{
		$value = sanitize_hex_color( $data );
		return $value;	
	}

	/**
	 * Validate INTEGER settings field
	 * @param  string $data Inputted value
	 * @return string       Validated value
	 */
	public function sanitizeInteger( $data )
	{
		$value = absint( abs( intval( $data ) ) );
		return $value;	
	}

	/**
	 * Validate BOOLEAN settings field
	 * @param  string $data Inputted value
	 * @return string       Validated value
	 */
	public function sanitizeBoolean( $data )
	{
		return isset( $data ) ? true : false;	
	}

	public function sanitizeBooleanArray( $data )
	{
		$output = array();

		foreach ($data as $key => $value) {
			$output[$key] = $this->sanitizeBoolean( $value );
		}
		
		return $output;
	}

	/* *
	 * PARTICULAR SANITIZATION
	 */

	/**
	 * Validate single_display_button general settings field
	 * @param  string $data Inputted value
	 * @return string       Validated value
	 */
	public function sanitizeSingleDisplay( $data )
	{
		$value = array();

		if( isset( $data['single_display_button'] ) ) $value['single_display_button'] = true;
		if( isset( $data['single_display_interval'] ) ) $value['single_display_interval'] = $this->sanitizeInteger( $data['single_display_interval'] );

		return $value;
	}

	public function sanitizeAnimationStyle( $data )
	{
		$value = array();

		if( isset( $data['animation_name'] ) ) $value['animation_name'] = $this->sanitizeText( $data['animation_name'] );
		if( isset( $data['animation_duration'] ) ) $value['animation_duration'] = $this->sanitizeInteger( $data['animation_duration'] );
		if( isset( $data['animation_iteration'] ) ) $value['animation_iteration'] = $this->sanitizeInteger( $data['animation_iteration'] );

		return $value;
	}

}