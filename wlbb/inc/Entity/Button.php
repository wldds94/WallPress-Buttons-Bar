<?php 
/**
 * @link              walterlaidelli.com
 * @since             1.0.0
 * 
 * @package           Wlbb
 */
namespace Wlbb\Entity;

use Wlbb\Base\BaseController;

class Button extends BaseController
{
    private $pluginGeneral;
    private $pluginButton;

    public $postTypesFilter;

    public function __construct()
    {
        $this->pluginGeneral = get_option( 'wlbb_plugin_general' );
        $this->pluginButton = get_option( 'wlbb_plugin_button' );

        $this->postTypesFilter = $this->setFilterPostTypes();

        $this->setGeneralDisplay();
    }

    /**
	 * Set the list of buttons to display in page
	 * @since    1.0.0
	 * 
     * @param    bool         $is_archive
     * @param    int          $post_id
     * @param    string       $post_type
     * 
	 * @return   array        $buttons_list
	 */
    public function setButtonsDisplayList( bool $is_archive, int $post_id, string $post_type )
    {
        $buttons_list = array();

        if( $is_archive ) {
            foreach ($this->pluginButton as $key => $value) {
                if( $this->setSingleDisplay( $key )->display_public ) {
                    $buttons_list[] = $key;
                }
            }
        } else {
            if ( $this->getOptionDisabledMeta( $post_id ) ) {
                foreach ($this->getMetaButton( $post_id ) as $key => $value) {
                    if( $this->existButton($key) ) {
                        $buttons_list[] = $key;
                    }
                }
            } else {
                foreach ($this->getMetaButton( $post_id ) as $key => $value) {
                    if( $this->existButton($key) ) {
                        $buttons_list[] = $key;
                    }
                }
                if( ! $this->isFilterPost( $post_type ) ) {
                    foreach ($this->pluginButton as $key => $value) {
                        if( $this->setSingleDisplay( $key )->display_public && !in_array( $key, $buttons_list ) ) {
                            $buttons_list[] = $key;
                        }
                    }
                }
            }
        }

        return $buttons_list;
    }

    /**
	 * Give istance to the the general Options
	 * @since   1.0.0
     * 
	 * @return  class \Wlbb\Entity\Button    $this
	 */
    public function setGeneralDisplay()
    {
        if( isset( $this->pluginGeneral['single_display_button'] ) ) {
            $single_display = isset( $this->pluginGeneral['single_display_button']['single_display_button'] ) ? true : false;
            $switchInterval = isset( $this->pluginGeneral['single_display_button']['single_display_interval'] ) ? $this->pluginGeneral['single_display_button']['single_display_interval'] : 6000;
        }
        
        $this->single_display = isset( $this->pluginGeneral['single_display_button'] ) ? (isset( $this->pluginGeneral['single_display_button']['single_display_button'] ) ? true : false) : false;
        $this->switchInterval = $this->single_display ? ( isset( $this->pluginGeneral['single_display_button']['single_display_interval'] ) ? $this->pluginGeneral['single_display_button']['single_display_interval'] : 6000 ) : 6000;
        
        $this->size = isset( $this->pluginGeneral['size'] ) ? $this->pluginGeneral['size'] : 30; // STYLE
        $this->padding = $this->size == 20 ? $this->size : ( ( $this->size == 40 ) ? 30 : 25 ); // STYLE
        $this->margin = 4;
        $this->height = $this->padding * 2; // STYLE
        $this->maxWidth = $this->height + $this->margin; // STYLE
        $this->max_width_image = $this->size - 3; // STYLE
        // $this->left = $this->size === 20 || $this->size === 30 ? 11 : 12.5;

        $this->position = isset( $this->pluginGeneral['position'] ) ? $this->pluginGeneral['position'] : 'right';

        $this->default_style = isset( $this->pluginGeneral['default_style'] ) ? $this->pluginGeneral['default_style'] : 'black';
        if ( $this->default_style === 'black' ) {
            $this->default_background_color = '#6d6e71';
            $this->default_background_color_hover = '#262626';
            $this->default_icon_color = '#262626';
            $this->default_icon_color_hover = '#6d6e71';
            $this->default_shadow = 'drop-shadow(0 1px 6px rgba(0,0,0,.8))';
        } elseif ( $this->default_style === 'white' ) {
            $this->default_background_color = '#fff';
            $this->default_background_color_hover = '#fff';
            $this->default_icon_color = '#0091f0';
            $this->default_icon_color_hover = '#0091f0';
            $this->default_shadow = 'drop-shadow(0 0 8px rgba(0, 0, 0, 0.3))';
        } elseif ( $this->default_style === 'whiteTransparent' ) {
            $this->default_background_color = 'rgba(201, 190, 190, 0.2)';
            $this->default_background_color_hover = 'rgba(201, 190, 190, 0.2)';
            $this->default_icon_color = '#262626';
            $this->default_icon_color_hover = '#262626';
            $this->default_shadow = 'drop-shadow(0 1px 6px rgba(0,0,0,.8))';
        }
        
        // I have to set the black_background_color for animation CSS -> FUTURE choice_option - don't touch
        $this->black_background_color = '#6d6e71'; 
                
        $this->defaultBorder = isset( $this->pluginGeneral['border_radius'] ) && $this->pluginGeneral['border_radius'] > 0 ? $this->pluginGeneral['border_radius'] : 50;
        $this->borderRadius = $this->height * ($this->defaultBorder/100);
        
        // $shadowBox = isset( $this->pluginGeneral['box_button_style'] ) ? ( $this->pluginGeneral['box_button_style'] === 'shadow_box' ? '' : $this->pluginGeneral['box_button_style'] )  : '';
        $this->shadowBox = isset( $this->pluginGeneral['box_button_style'] ) ? $this->pluginGeneral['box_button_style'] : ''; // STYLE
        
        $this->delay = isset( $this->pluginGeneral['delay'] ) ? $this->pluginGeneral['delay'] : 0;
        $this->appereanceMode = isset( $this->pluginGeneral['show_mode'] ) ? $this->pluginGeneral['show_mode'] : 'fixed';
        $this->hideClass = $this->appereanceMode == 'fixed' ? '' : 'hide';
        $this->timingAppereanceMode = isset( $this->pluginGeneral['timing_show_mode'] ) ? $this->pluginGeneral['timing_show_mode'] : 600;
        
        $this->overflow_hidden = ( $this->appereanceMode != 'fixed' && $this->appereanceMode != 'fadeIn' ) ? 'overflow-hidden' : '';
        
        $this->animation = isset( $this->pluginGeneral['animation_style'] ) ? $this->pluginGeneral['animation_style'] : '';
        $this->animation_class = isset( $this->animation['animation_name'] ) ? 'wlbb-' . $this->animation['animation_name'] : '';
        $this->animation_duration = isset( $this->animation['animation_duration'] ) ? $this->animation['animation_duration'] / 1000 : false;
        $this->animation_iteration = isset( $this->animation['animation_iteration'] ) ? $this->animation['animation_iteration'] : 'infinite';
        
        $this->mobileOnly = isset( $this->pluginGeneral['mobile_only'] ) ? $this->pluginGeneral['mobile_only'] : false;
        $this->mobileSwitch = isset( $this->pluginGeneral['mobile_switch'] ) ? $this->pluginGeneral['mobile_switch'] : '480';

        return $this;
    }

    /**
	 * Give istance to the the single custom button Options
	 * @since   1.0.0
     * 
     * @param   string                       $key
	 * @return  class \Wlbb\Entity\Button    $this
	 */
    public function setSingleDisplay( string $key )
    {
        // if( !isset( $this->pluginButton[$key] ) ) return;
        $this->button = $this->pluginButton[$key];
        
        $this->button_id = isset($this->button['button_id']) ? $this->button['button_id'] : '';
        $this->display_public = isset($this->button['display_public']) ? true : false;
        $this->url = isset($this->button['url']) ? $this->button['url'] : ( isset($this->button['wp_post_id']) ? get_post_permalink( $this->button['wp_post_id'] ) : '');// '#';
        $this->target = isset($this->button['target']) ? $this->button['target'] : '_blank';
        $this->extra_class = isset($this->button['extra_class']) ? $this->button['extra_class'] : '';
        $this->extra_id = isset($this->button['extra_id']) ? $this->button['extra_id'] : '';
        $this->icon_type = isset($this->button['icon_type']) ? $this->button['icon_type'] : 'dash';
        $this->upload = false;
        if( $this->icon_type === 'dash' ) {
            $this->icon = isset($this->button['icon']) ? $this->button['icon'] : 'fab fa-wordpress-simple';
        }
        if ( $this->icon_type === 'upload' ) {
            $this->upload_url = isset($this->button['icon_upload']) ? $this->button['icon_upload'] : 'https://www.fismliguria.it/wp-content/uploads/2021/09/question.png';
            $this->icon = '';
            $this->upload = true;
        }

        return $this;
    }


    /* * * * * * * * * * * *
     * * * * CRUD * * * * *
     * * * * * * * * * * * */
    /**
	 * Get istance to the the general Options
	 * @since   1.0.0
     * 
	 * @return  array    $this->pluginGeneral
	 */
    public function getGeneralOptions()
    {
        return $this->pluginGeneral;
    }

    /**
	 * Get istance to the the general Options
	 * @since   1.0.0
     * 
	 * @return  array    $this->pluginGeneral
	 */
    public function getButtonsOption()
    {
        return $this->pluginButton;
    }

    /**
	 * Get istance to the the custom button Options
	 * @since   1.0.0
     * 
     * @param   string        $key
	 * @return  array/bool    $this->pluginGeneral or FALSE
	 */
    public function getButton( string $key )
    {
        return isset( $this->buttons[ $key ] ) ? $this->buttons[ $key ] : false;
    }

    /**
	 * Get post meta buttons list
	 * @since   1.0.0
     * 
     * @param   int      $post_id
	 * @return  array    $buttons
	 */
    public function getMetaButton( int $post_id )
    {
        $meta = get_post_meta( $post_id, '_wlbb_button_meta_key', true );
		$buttons = isset( $meta['button'] ) ? $meta['button'] : array();

		return $buttons;
    }

    /**
	 * Check if a post has the buttons default display off
	 * @since   1.0.0
     * 
     * @param   int      $post_id
	 * @return  bool     $disabled
	 */
    public function getOptionDisabledMeta( int $post_id )
	{
		$meta = get_post_meta( $post_id, '_wlbb_button_meta_key', true );
		$meta_options = isset( $meta['options'] ) ? $meta['options'] : array();
		$disabled = isset( $meta_options['button_disabled'] ) ? true : false;

		return $disabled;
	}

    /**
	 * Set istance of the filter_post_object for the buttons except "META_custom_button_key"
	 * @since   1.0.0
     * 
	 * @return  array    $this->pluginGeneral
	 */
    public function setFilterPostTypes()
    {
		$posts_filtered = array();
		if( isset( $this->pluginGeneral['post_objects'] ) ) {
			foreach ($this->pluginGeneral['post_objects'] as $key => $value) {
				$posts_filtered[] = $key;
			}
		}

        return $posts_filtered;
    }

    /* * * * * * * * * * * *
     * * * * UTILS * * * * *
     * * * * * * * * * * * */
    /**
	 * Check if exist a button
	 * @since   1.0.0
     * 
     * @param   string   $key
	 * @return  bool
	 */
    public function existButton( string $key )
    {
		return isset( $this->pluginButton[$key] ) ? true : false;
    }

    /**
	 * Check if post is subjected to filter the buttons except "META_custom_button_key"
	 * @since   1.0.0
     * 
     * @param   string   $post_type
	 * @return  bool
	 */
    public function isFilterPost( string $post_type )
    {
        if( in_array( $post_type, $this->postTypesFilter ) ) { // echo 'Devo filtrare';
			return true;
		}
        return false;
    }

}