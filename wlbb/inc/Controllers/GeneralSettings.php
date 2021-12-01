<?php 
/**
 * @link              walterlaidelli.com
 * @since             1.0.0
 * @package           wlbb
 */
namespace Wlbb\Controllers;

use Wlbb\Api\SettingsApi;
use Wlbb\Base\BaseController;
use Wlbb\Api\Callbacks\AdminCallbacks;
use Wlbb\Api\Callbacks\GeneralCallbacks;

class GeneralSettings extends BaseController 
{
    public $settings;

	public $callbacks;

    public $general_callbacks;

	public $subpages = array();

    public function register()
    {

        $this->settings = new SettingsApi();

        $this->callbacks = new AdminCallbacks();

        $this->general_callbacks = new GeneralCallbacks();

        // Set the settings
		$this->setSettings();
		$this->setSections();
		$this->setFields();
        $this->settings->addSubPages( $this->subpages )->register();

		// Ajax Requests
		add_action( 'wp_ajax_wlbb_reset_general', array( $this, 'resetDbButtonGeneral') );
    }

	/**
	 * Ajax Callbacks by Ajax Hook for reset the General Option of Buttons
	 * @since    1.0.0
	 * 
	 * @return
	 */
	public function resetDbButtonGeneral()
	{
		check_ajax_referer( 'ajax-rst-gen-opt-nonce', 'wlbb_custom_general_reset' );

		wp_cache_delete ( 'alloptions', 'options' );
		delete_option( 'wlbb_plugin_general' );
		update_option( 'wlbb_plugin_general', array() );

		echo json_encode(
			array(
				'status' => true,
				'message' => 'Reset Succesfully, redirecting ...'
			)
		);

		die();
	}

	/**
	 * Register the General settings for custom button
	 * @since 1.0.0
	 * 
	 * @return
	 */
    public function setSettings()
	{
		$args[] = array(
			'option_group' => 'wlbb_plugin_general_settings',
			'option_name' => 'wlbb_plugin_general',
			'callback' => array( $this->general_callbacks, 'generalSanitize' )
		);

		$this->settings->setSettings( $args );
	}

	/**
	 * Register the section of the option
	 * @since 1.0.0
	 * 
	 * @return
	 */
    public function setSections()
	{
		$args = array(
			array(
				'id' => 'wlbb_general_index',
				'title' => 'General settings',
				'callback' => array( $this->general_callbacks, 'generalSectionManager' ),
				'page' => 'wlbb_general_settings'
			)
		);

		$this->settings->setSections( $args );
	}

	/**
	 * Register the fields of the General Option
	 * @since 1.0.0
	 * 
	 * @return
	 */
    public function setFields()
	{
		$args = array(
			array(
				'id' => 'single_display_button',
				'title' => 'Display Mode',
				'callback' => array( $this->general_callbacks, 'displayModeFields' ),
				'page' => 'wlbb_general_settings',
				'section' => 'wlbb_general_index',
				'args' => array(
					'option_name' => 'wlbb_plugin_general', // 'wlbb_plugin_custom_button',
					'label_for' => 'single_display_button',
					'class' => 'ui-toggle wlbb-form',
					'type' => 'checkbox',
					'description' => 'Check if you want a single button.',
					'fields_name' => array( 'single_display_button', 'single_display_interval' )
				)
			),
			array(
				'id' => 'size',
				'title' => 'Size',
				'callback' => array( $this->general_callbacks, 'displayOptionsField' ),
				'page' => 'wlbb_general_settings',
				'section' => 'wlbb_general_index',
				'args' => array(
					'option_name' => 'wlbb_plugin_general',
					'label_for' => 'size',
					'array' => 'general',
                    'type' => 'select',
                    'description' => 'The size of plugin - Default 30px (3x)',
                    'options' => array( '20' => '2x', '30' => '3x', '40' => '4x' ),
                    'default' => '',
					'class' => 'wlbb-form'
				)
            ),
            array(
				'id' => 'position',
				'title' => 'Position',
				'callback' => array( $this->general_callbacks, 'displayOptionsField' ),
				'page' => 'wlbb_general_settings',
				'section' => 'wlbb_general_index',
				'args' => array(
					'option_name' => 'wlbb_plugin_general',
					'label_for' => 'position',
					'array' => 'general',
                    'type' => 'select',
                    'description' => 'The position of ButtonsBorad - Default Right.',
                    'options' => array( 'right' => 'Right', 'left' => 'Left' ),
					'default' => '',
					'class' => 'wlbb-form'
				)
			),
			array(
				'id' => 'default_style',
				'title' => 'Default Style',
				'callback' => array( $this->general_callbacks, 'displayOptionsField' ),
				'page' => 'wlbb_general_settings',
				'section' => 'wlbb_general_index',
				'args' => array(
					'option_name' => 'wlbb_plugin_general',
					'label_for' => 'default_style',
					'array' => 'general',
                    'type' => 'select',
                    'description' => 'The Default Style By Wlbb - Default: Dark',
                    'options' => array( 'black' => 'Dark', 'white' => 'White', 'whiteTransparent' => 'whiteTransparent' ),
                    'default' => '',
					'class' => 'wlbb-form'
				)
            ),
            array(
				'id' => 'border_radius',
				'title' => 'Default Border Radius',
				'callback' => array( $this->general_callbacks, 'displayOptionsField' ),
				'page' => 'wlbb_general_settings',
				'section' => 'wlbb_general_index',
				'args' => array(
					'option_name' => 'wlbb_plugin_general',
					'label_for' => 'border_radius',
					'array' => 'general',
                    'type' => 'number',
                    'description' => '% - Set the default border radius of icons buttons. - Default: Rounded ( 50% )',
                    'max' => 50,
					'default' => '',
					'class' => 'wlbb-form'
				)
			),
            array(
				'id' => 'box_button_style',
				'title' => 'Shadow Box',
				'callback' => array( $this->general_callbacks, 'displayOptionsField' ),
				'page' => 'wlbb_general_settings',
				'section' => 'wlbb_general_index',
				'args' => array(
					'option_name' => 'wlbb_plugin_general',
					'label_for' => 'box_button_style',
					'array' => 'general',
                    'type' => 'select',
                    'description' => '',
                    'options' => array( 'shadow_box' => 'ShadowBox', 'hover_shadow_box' => 'HoverShadowBox' ),
					'default' => '',
					'class' => 'wlbb-form'
				)
            ),
            array(
				'id' => 'delay',
				'title' => 'Delay',
				'callback' => array( $this->general_callbacks, 'displayOptionsField' ),
				'page' => 'wlbb_general_settings',
				'section' => 'wlbb_general_index',
				'args' => array(
					'option_name' => 'wlbb_plugin_general',
					'label_for' => 'delay',
					'array' => 'general',
                    'type' => 'text',
                    'description' => 'MilliSeconds - Insert the delay you wish view the buttons.',
                    'default' => '',
					'placeholder'	=> '',
					'class' => 'wlbb-form'
				)
            ),
            array(
				'id' => 'show_mode',
				'title' => 'Appearance Mode',
				'callback' => array( $this->general_callbacks, 'displayOptionsField' ),
				'page' => 'wlbb_general_settings',
				'section' => 'wlbb_general_index',
				'args' => array(
					'option_name' => 'wlbb_plugin_general',
					'label_for' => 'show_mode',
					'array' => 'general',
                    'type' => 'select',
                    'description' => '',
                    'options' => array( 'fixed' => 'Default', 'fadeIn' => 'fadeIn', 'slideUp' => 'slideUp' ),
					'default' => '',
					'class' => 'wlbb-form'
				)
			),
            array(
				'id' => 'timing_show_mode',
				'title' => 'Timing Appearance Mode',
				'callback' => array( $this->general_callbacks, 'displayOptionsField' ),
				'page' => 'wlbb_general_settings',
				'section' => 'wlbb_general_index',
				'args' => array(
					'option_name' => 'wlbb_plugin_general',
					'label_for' => 'timing_show_mode',
					'array' => 'general',
                    'type' => 'text',
                    'description' => 'Milliseconds. Default 600 - ( SLOW => 600, NORMAL => 400, FAST => 200 )',
                    'default' => '',
					'placeholder'	=> 'e.g. 600',
					'class' => 'wlbb-form'
				)
            ),
			array(
				'id' => 'animation_style',
				'title' => 'Static Animation',
				'callback' => array( $this->general_callbacks, 'generalAnimationStyleField' ),
				'page' => 'wlbb_general_settings',
				'section' => 'wlbb_general_index',
				'args' => array(
					'option_name' => 'wlbb_plugin_general',
					'label_for' => 'animation_style',
					'class' => 'ui-toggle wlbb-form',
					'options' => array( 'pulse' => 'BorderPulse', 'zoom' => 'Zoom', 'rotate' => 'Rotate360', 'double_rotate' => 'Rotate&back', 'pulse_rotate' => 'Pulse&Rotate', 'zoom_rotate' => 'Zoom&Rotate', 'zoom_rotate_pulse' => 'Zoom&Rotate&Pulse' ),
					'fields_name' => array( 'animation_name', 'animation_duration', 'animation_iteration' )
				)
			),
            array(
				'id' => 'mobile_only',
				'title' => 'Mobile Only',
				'callback' => array( $this->general_callbacks, 'displayOptionsField' ),
				'page' => 'wlbb_general_settings',
				'section' => 'wlbb_general_index',
				'args' => array(
					'option_name' => 'wlbb_plugin_general',
					'label_for' => 'mobile_only',
					'class' => 'ui-toggle wlbb-form',
					'array' => 'general',
                    'type' => 'checkbox',
                    'description' => ''
				)
            ),
            array(
				'id' => 'mobile_switch',
				'title' => 'Mobile Switch',
				'callback' => array( $this->general_callbacks, 'displayOptionsField' ),
				'page' => 'wlbb_general_settings',
				'section' => 'wlbb_general_index',
				'args' => array(
					'option_name' => 'wlbb_plugin_general',
					'label_for' => 'mobile_switch',
					'array' => 'general',
                    'type' => 'text',
                    'description' => 'Set pixel you desire switch, il "Mobile Only id Active. - Default 480px;"',
                    'default' => '',
					'placeholder'	=> 'e.g. 480',
					'class' => 'wlbb-form'
				)
            ),
			array(
				'id' => 'post_objects',
				'title' => 'Post Types',
				'callback' => array( $this->general_callbacks, 'checkboxPostTypesField' ),
				'page' => 'wlbb_general_settings',
				'section' => 'wlbb_general_index',
				'args' => array(
					'option_name' => 'wlbb_plugin_general',
					'label_for' => 'post_objects',
					'class' => 'ui-toggle wlbb-form',
					'array' => 'general',
					'description' => 'Check if you want hide the button for each post_type.'
				)
			)

            /**
             * 
             * 
             */
		);

		$this->settings->setFields( $args );
	}

}
