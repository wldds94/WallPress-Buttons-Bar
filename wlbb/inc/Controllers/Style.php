<?php 
/**
 * @link              walterlaidelli.com
 * @since             1.0.0
 * @package           Wlaiddd
 */
namespace Wlbb\Controllers;

use Wlbb\Base\BaseController;

class Style extends BaseController
{
	/**
	 * Initialize the core of class
	 * 
	 * Configure the style service page registering the query vars.
	 * @return
	 * 
	 */
	public function register()
	{
        parent::__construct();

        add_filter( 'query_vars', array( $this, 'registerStyleQueryVars' ) );

        add_action('init', array( $this, 'rewriteTagStyleQueryVars'), 10, 0);

        add_action( 'template_redirect', array( $this, 'apiStyle' ) );
	}

    /**
     * Register the service for style.php
     *
     * @param array $vars The array of available query variables
     * @return 
     */
    public function apiStyle() {

        $call = isset( $_GET['style'] ) ? abs( intval( $_GET['style'] ) ) : '';

        if( $call == abs( intval( $this->style_ver ) ) ){
            require_once( $this->plugin_path . 'dist/assets/css/style.php' );
            exit;
        }

    }

    /**
     * Register custom query vars
     *
     * @param array $vars The array of available query variables
     * @return 
     */
    public function registerStyleQueryVars( $vars ) {
        $vars[] = 'style';
        return $vars;
    }

    public function rewriteTagStyleQueryVars() {
        add_rewrite_tag( '%style%', '([^&]+)' );
        add_rewrite_rule( '^style/([^/]*)/?', 'index.php?style=$matches[1]','top' );
    }

	
}