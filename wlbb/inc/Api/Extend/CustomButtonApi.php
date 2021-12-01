<?php 
/**
 * @link              walterlaidelli.com
 * @since             1.0.0
 * @package           wlbb
 */
namespace Wlbb\Api\Extend;

use Wlbb\Api\SettingsApi;
use Wlbb\Base\BaseController;
use Wlbb\Api\Callbacks\AdminCallbacks;
use Wlbb\Api\Callbacks\CustomButtonCallbacks;

class CustomButtonApi extends BaseController 
{
    public $settings;

	public $callbacks;

	public $custom_btn_callbacks;

	public $subpages = array();

	public $option_group = '';
    public $option_name = '';

    public $id_section = '';
    public $title_section = '';
    public $page_section = '';

    public $index;

	public function __construct( $option_group = '', $option_name = '', $id_section = '', $title_section = '', $page_section = '', $index = '' )
	{
		$this->default_title_section = 'Button Manager';

		$this->option_group = $option_group;
        $this->option_name = $option_name;
        $this->id_section = $id_section;
        $this->title_section = $title_section;
        $this->page_section = $page_section;
        $this->index = $index;
	}

	/**
	 * Initialize the core of class
	 * 
	 * Configure the dashboard page and initialize the option settings, the call the parent method
	 * for register all in core of WP.
	 * @return
	 * 
	 */
	public function register()
	{
		if ( ! $this->activated( 'custom_buttons_manager' ) ) {
			return;
		}

		$this->settings = new SettingsApi();
		$this->callbacks = new AdminCallbacks();
		$this->custom_btn_callbacks = new CustomButtonCallbacks(); 

		if ($this->option_group === '' || $this->option_name === '' || $this->id_section === '' || $this->title_section === '' || $this->page_section === '' || $this->index === '') {
			return;
		}

		$this->setSettings();
		$this->setSections();
		$this->setFields();

        $this->settings->register();

	}

	/**
	 * Register the settings for custom button
	 * @since 1.0.0
	 * 
	 * @return
	 */
    public function setSettings()
	{
		$args[] = array(
			'option_group' => $this->option_group, //'wlbb_plugin_custom_button_settings',
			'option_name' =>  $this->option_name, // 'wlbb_plugin_custom_button',
			'callback' => array( $this->custom_btn_callbacks, 'wlbbCustomButtonSanitize' )
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
				'id' => $this->id_section . '_' . $this->index, // 'wlbb_custom_btn_index',
				'title' => $this->title_section . ' ' . $this->default_title_section, // 'Custom Button Manager',
				'callback' => array( $this->custom_btn_callbacks, 'customBtnSectionManager' ),
				'page' => $this->page_section . '_' . $this->index // 'wlbb_custom_button'
			)
		);

		$this->settings->setSections( $args );
	}

	/**
	 * Register the fields of the option
	 * @since 1.0.0
	 * 
	 * @return
	 */
    public function setFields()
	{
		$index = '';
		$args = array(
			array(
				'id' => 'button_id',
				'title' => 'Custom Id',
				'callback' => array( $this->custom_btn_callbacks, 'buttonIdField' ),
				'page' => $this->page_section . '_' . $this->index, // 'wlbb_custom_button', // wlbb_button
				'section' => $this->id_section . '_' . $this->index, // 'wlbb_custom_btn_index',
				'args' => array(
					'option_name' => $this->option_name, // 'wlbb_plugin_custom_button',
					'label_for' => 'button_id',
					'placeholder' => 'eg. my-id-button',
					'type' => 'text',
					'class' => 'wlbb-form',
					'required' => 'required'
				)
			),
			array(
				'id' => 'title_section',
				'title' => 'Title Section',
				'callback' => array( $this->custom_btn_callbacks, 'buttonTextField' ),
				'page' => $this->page_section . '_' . $this->index, // 'wlbb_custom_button', // wlbb_button
				'section' => $this->id_section . '_' . $this->index, // 'wlbb_custom_btn_index',
				'args' => array(
					'option_name' => $this->option_name, // 'wlbb_plugin_custom_button',
					'label_for' => 'title_section',
					'placeholder' => 'eg. Instagram',
					'type' => 'text',
					'class' => 'wlbb-form'
				)
			),	
			array(
				'id' => 'display_public',
				'title' => 'Display in public',
				'callback' => array( $this->custom_btn_callbacks, 'buttonCheckboxField' ),
				'page' => $this->page_section . '_' . $this->index, // 'wlbb_custom_button',
				'section' => $this->id_section . '_' . $this->index,
				'args' => array(
					'option_name' => $this->option_name, // 'wlbb_plugin_custom_button',
					'label_for' => 'display_public',
					'class' => 'ui-toggle wlbb-form',
					'type' => 'checkbox'
				)
			),
			array(
				'id' => 'url',
				'title' => 'URL',
				'callback' => array( $this->custom_btn_callbacks, 'buttonUrlField' ),
				'page' => $this->page_section . '_' . $this->index, // 'wlbb_custom_button',
				'section' => $this->id_section . '_' . $this->index,
				'args' => array(
					'option_name' => $this->option_name, // 'wlbb_plugin_custom_button',
					'label_for' => 'url',
					'class' => 'ui-toggle wlbb-form',
					'type' => 'text',
					'placeholder' => 'https://wa.me....',
					'extra_input' => 'wp_post_id' // Remember me that it is not a lonely input
				)
			),
            array(
				'id' => 'target',
				'title' => 'Target',
				'callback' => array( $this->custom_btn_callbacks, 'buttonSelectField' ),
				'page' => $this->page_section . '_' . $this->index,
				'section' => $this->id_section . '_' . $this->index,
				'args' => array(
					'option_name' => $this->option_name,
					'label_for' => 'target',
					'array' => '',
                    'type' => 'select',
                    'description' => 'The target of Link - Default: "blank".',
                    'options' => array( '_blank' => '_blank', '_self' => '_self' ),
					'type' => 'select',
					'class' => 'wlbb-form'
				)
			),
			array(
				'id' => 'extra_class',
				'title' => 'Extra Class',
				'callback' => array( $this->custom_btn_callbacks, 'buttonTextField' ),
				'page' => $this->page_section . '_' . $this->index,
				'section' => $this->id_section . '_' . $this->index,
				'args' => array(
					'option_name' => $this->option_name,
					'label_for' => 'extra_class',
					'placeholder' => 'eg. my-unique-class',
					'array' => '',
					'type' => 'text',
					'description'	=> 'Add Extra Class for Customize yours Button.',
					'class' => 'wlbb-form'	
				)
			),
			array(
				'id' => 'extra_id',
				'title' => 'Extra ID',
				'callback' => array( $this->custom_btn_callbacks, 'buttonTextField' ),
				'page' => $this->page_section . '_' . $this->index,
				'section' => $this->id_section . '_' . $this->index,
				'args' => array(
					'option_name' => $this->option_name,
					'label_for' => 'extra_id',
					'description'	=> 'Add ID for Customize yours Button.', 'plugin_textdomain',
					'placeholder' => 'eg. my-unique-identifier',
					'array' => '',
					'type' => 'text',
					'class' => 'wlbb-form'
				)
			),
			array(
				'id' => 'icon_type',
				'title' => 'Icon Media Type',
				'callback' => array( $this->custom_btn_callbacks, 'buttonRadioField' ),
				'page' => $this->page_section . '_' . $this->index,
				'section' => $this->id_section . '_' . $this->index,
				'args' => array(
					'option_name' => $this->option_name,
					'label_for' => 'icon_type',
					'description'	=> 'Select the type of Icon.',
					'array' => $index,
					'type' => 'radio',
                    'options' => array( '' => 'Unset', 'dash' => 'Dashicons', 'upload' => 'Custom' ),
					'class' => 'wlbb_icon_type_index wlbb-form',
				)
			),
			array(
				'id' => 'icon',
				'title' => 'Icon',
				'callback' => array( $this->custom_btn_callbacks, 'buttonTextField' ),
				'page' => $this->page_section . '_' . $this->index,
				'section' => $this->id_section . '_' . $this->index,
				'args' => array(
					'option_name' => $this->option_name,
					'label_for' => 'icon',
					'placeholder' => 'fa fa-star',
					'array' => $index,
					'type' => 'text',
					'description'	=> 'Select your custom Icon for this button. Link: https://fontawesome.com/v5.15/icons',
					'data-attribute' => 'dash',
					'class' => 'wlbb-tr-switch wlbb_icon_switch_dash wlbb-form'
				)
			),
			array(
				'id' => 'icon_upload',
				'title' => 'Icon Upload',
				'callback' => array( $this->custom_btn_callbacks, 'buttonMediaField' ),
				'page' => $this->page_section . '_' . $this->index,
				'section' => $this->id_section . '_' . $this->index,
				'args' => array(
					'option_name' => $this->option_name,
					'label_for' => 'icon_upload',
					'placeholder' => 'fa fa-star',
					'array' => $index,
					'type' => 'text',
					'description'	=> 'Upload your custom Icon.',
					'data-attribute' => 'upload',
					'class' => 'wlbb-tr-switch wlbb_icon_switch_upload wlbb-form'
				)
			),
			array(
				'id' => 'border_radius',
				'title' => 'Custom Border Radius',
				'callback' => array( $this->custom_btn_callbacks, 'buttonNumberField' ),
				'page' => $this->page_section . '_' . $this->index,
				'section' => $this->id_section . '_' . $this->index,
				'args' => array(
					'option_name' => $this->option_name,
					'label_for' => 'border_radius',
					'array' => $index,
					'type' => 'number',
					'max' => 50,
					'description'	=> '% - Set your custom border radius for this button. - Blank for DEFAULT & MAX: Rounded ( 50% )',
					'class' => 'wlbb-form'
				)
			),
			// array(
			// 	'id' => 'text_link',
			// 	'title' => 'Text Link',
			// 	'callback' => array( $this->custom_btn_callbacks, 'buttonTextField' ),
			// 	'page' => $this->page_section . '_' . $this->index,
			// 	'section' => $this->id_section . '_' . $this->index,
			// 	'args' => array(
			// 		'option_name' => $this->option_name,
			// 		'label_for' => 'text_link',
			// 		'placeholder' => 'e.g. My text',
			// 		'array' => $index,
			// 		'type' => 'text',
			// 		'description'	=> 'Insert text to dispay.',
			// 		'class' => 'wlbb-form'
			// 	)
			// ),
            // array(
			// 	'id' => 'text_display',
			// 	'title' => 'Text Display Mode',
			// 	'callback' => array( $this->custom_btn_callbacks, 'buttonSelectField' ),
			// 	'page' => $this->page_section . '_' . $this->index,
			// 	'section' => $this->id_section . '_' . $this->index,
			// 	'args' => array(
			// 		'option_name' => $this->option_name,
			// 		'label_for' => 'text_display',
			// 		'array' => $index,
            //         'type' => 'select',
            //         'description' => 'Select the display mode - Default: "On hover".',
            //         'options' => array( 'fixed' => 'Fixed', 'hover' => 'Hover' ),
			// 		'type' => 'select',
			// 		'class' => 'wlbb-form'
			// 	)
			// ),
			array(
				'id' => 'background_color',
				'title' => 'Background Color',
				'callback' => array( $this->custom_btn_callbacks, 'buttonColorField' ),
				'page' => $this->page_section . '_' . $this->index,
				'section' => $this->id_section . '_' . $this->index,
				'args' => array(
					'option_name' => $this->option_name,
					'label_for' => 'background_color',
					'placeholder' => 'e.g. #25d366',
					'array' => $index,
					'type' => 'color',
					'description'	=> 'Select color for the backgorund.',
					'class' => 'wlbb-form'
				)
			),
			array(
				'id' => 'background_color_hover',
				'title' => 'Background Hover-Color',
				'callback' => array( $this->custom_btn_callbacks, 'buttonColorField' ),
				'page' => $this->page_section . '_' . $this->index,
				'section' => $this->id_section . '_' . $this->index,
				'args' => array(
					'option_name' => $this->option_name,
					'label_for' => 'background_color_hover',
					'placeholder' => 'e.g. #25d366',
					'array' => $index,
					'type' => 'color',
					'description'	=> 'Select color for the backgorund on mouse Hover.',
					'class' => 'wlbb-form'
				)
			),
			array(
				'id' => 'icon_color',
				'title' => 'Icon Color',
				'callback' => array( $this->custom_btn_callbacks, 'buttonColorField' ),
				'page' => $this->page_section . '_' . $this->index,
				'section' => $this->id_section . '_' . $this->index,
				'args' => array(
					'option_name' => $this->option_name,
					'label_for' => 'icon_color',
					'placeholder' => 'e.g. #ffffff',
					'array' => $index,
					'type' => 'color',
					'description'	=> 'Select color for the Icon.',
					'class' => 'wlbb-form'
				)
			),
			array(
				'id' => 'icon_color_hover',
				'title' => 'Icon Hover-Color',
				'callback' => array( $this->custom_btn_callbacks, 'buttonColorField' ),
				'page' => $this->page_section . '_' . $this->index,
				'section' => $this->id_section . '_' . $this->index,
				'args' => array(
					'option_name' => $this->option_name,
					'label_for' => 'icon_color_hover',
					'placeholder' => 'e.g. #ffffff',
					'array' => $index,
					'type' => 'color',
					'description'	=> 'Select color for the Icon on mouse Hover.',
					'class' => 'wlbb-form'
				)
			)
		);

		// var_dump($args); die;

		$this->settings->setFields( $args );
	}

	public function setSubpages()
	{
		$this->subpages = array(
			array(
				'parent_slug' => 'wlbb_plugin', 
				'page_title' => 'Custom Button', 
				'menu_title' => 'Custom Button Manager', 
				'capability' => 'manage_options', 
				'menu_slug' => 'wlbb_custom_button_page', 
				'callback' => array( $this->callbacks, 'adminCustomButton' )
			)
		);
	}

}