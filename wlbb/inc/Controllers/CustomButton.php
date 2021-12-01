<?php 
/**
 * @link              walterlaidelli.com
 * @since             1.0.0
 * @package           wlbb
 */
namespace Wlbb\Controllers;

use Wlbb\Api\SettingsApi;
use Wlbb\Api\Extend\CustomButtonApi;
use Wlbb\Base\BaseController;
use Wlbb\Api\Callbacks\AdminCallbacks;
use Wlbb\Api\Callbacks\CustomButtonCallbacks;

class CustomButton extends BaseController 
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

	public function register( $option_group = '', $option_name = '', $id_section = '', $title_section = '', $page_section = '', $index = '' )
	{
		if ( ! $this->activated( 'custom_buttons_manager' ) ) {
			return;
		}

		$this->settings = new SettingsApi();
		$this->settings_pages = new SettingsApi();
		$this->callbacks = new AdminCallbacks();
		$this->custom_btn_callbacks = new CustomButtonCallbacks(); 

		$this->setSubpages();
        $this->settings_pages->addSubPages( $this->subpages )->register();		

		$general_configuration = get_option('wlbb_version_option');

		$buttons_config = isset($general_configuration['button_settings_default']) ? $general_configuration['button_settings_default'] : false;

		$buttonApi = array();
		foreach ($buttons_config as $button) {
			$buttonApi[$button['index']] = new CustomButtonApi( $button['option_group'], $button['option_name'], $button['id_section'], $button['title_section'], $button['page_section'], $button['index'] );
			$buttonApi[$button['index']]->register();
		}
		
		if ( $this->activated( 'display_public' ) ) {

			// View Buttons in front-end
			add_action('wp_body_open', array( $this, 'add_button_template' ) );

			// Add Meta Box for post to match the buttons and save
			add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
			add_action( 'save_post', array( $this, 'save_meta_boxes' ) );

			// Ajax Requests
			add_action( 'wp_ajax_wlbb_reset_button', array( $this, 'resetDbButton') );
		}
	}

	/**
	 * Ajax Callbacks by Ajax Hook for reset the option of custom Button
	 * @since    1.0.0
	 * 
	 * @return
	 */
	public function resetDbButton()
	{
		check_ajax_referer( 'ajax-rst-btn-nonce', 'wlbb_custom_button_reset' );

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
		$posts = get_posts( $args ); // echo '<pre>'; var_dump($posts);
		
		foreach( $posts as $post ) {
			delete_post_meta( $post->ID, '_wlbb_button_meta_key' );
		}

		wp_cache_delete ( 'alloptions', 'options' );
		delete_option( 'wlbb_plugin_button' );
		update_option( 'wlbb_plugin_button', array() );

		echo json_encode(
			array(
				'status' => true,
				'message' => 'Reset Succesfully, redirecting ...'
			)
		);

		die();
	}

	/**
	 * Filter Callbacks by WP Hook for add Button-Template in content
	 * @since    1.0.0
	 * 
	 * @return
	 */
	public function add_button_template()
	{
		global $post;
		
		// $option = get_option( 'wlbb_plugin_general' );

		// $posts_filtered = array();
		// if( isset( $option['post_objects'] ) ) {
		// 	foreach ($option['post_objects'] as $key => $value) {
		// 		$posts_filtered[] = $key;
		// 	}
		// }

		// if( in_array( $post->post_type, $posts_filtered ) ) { // echo 'Devo filtrare';
		// 	return;
		// }

		$file = $this->plugin_path . 'templates/public/btn-board.php';

		if ( file_exists( $file ) ) {
			load_template( $file, true );
		}
	}

	/**
	 * Callbacks by WP Hook for register meta box to manage the single posts, page, CPT ecc
	 * @since    1.0.0
	 * 
	 * @return
	 */
	public function add_meta_boxes()
	{
		$screens = $this->getPostTypes();

		add_meta_box(
			'wlbb_buttons_post',
			'WLBB Buttons',
			array( $this, 'render_features_box' ),
			$screens,
			'side',
			'default'
		);
	}

	/**
	 * Callbacks by WP Hook for rendering meta box to manage the single posts, page, CPT ecc
	 * @since    1.0.0
	 * 
	 * @return
	 */
	public function render_features_box( $post )
	{
		echo ''; //

		$meta = get_post_meta( $post->ID, '_wlbb_button_meta_key', true );
		$checkbox = isset( $meta['button'] ) ? $meta['button'] : array();
		$buttonsKeys = $this->getButtonKeys();

		$disabled = $this->getOptionDisabledMeta($post->ID) ?: false;
	?>

		<input type="hidden" name="wlbb_testimonial_button_nonce" value="<?php echo wp_create_nonce('wlbb_testimonial_button_nonce'); ?>"/> <!-- wp_nonce_field( 'wlaiddd_testimonial', 'wlaiddd_testimonial_nonce' ); -->

		<div class="wlbb-buttons-meta-container">
			<div class="scrollbar small-scroll">
				<div class="force-overflow">

				<?php foreach ($buttonsKeys as $index => $button_key) : 
					$checked = isset( $checkbox[ $button_key ] ) ?: false; ?>

					<div class="wlbb-button-key-container">
						<div class="ui-toggle">
							<input type="checkbox" id="<?php echo esc_attr( $button_key) ; ?>" name="<?php echo 'wlbb_button_meta[' . esc_attr( $button_key ) . ']'; ?>" value="1" class="" <?php echo esc_attr( $checked ? 'checked' : '' ); ?> >
							<label for="<?php echo esc_attr( $button_key) ; ?>">
								<div></div>		
							</label>
						</div>
						<label for="<?php echo esc_attr( $button_key) ?>"><span class="description"></span><?php echo esc_attr( $button_key) ; ?></label>
					</div>

				<?php endforeach; ?>

				</div>
			</div>
		</div>

		<div>
			<label for="button_disabled" style="margin-bottom:10px;"><span class="description"></span><b>Display only Meta Buttons or Disabled</b></label>
			<div class="ui-toggle">
				<input type="checkbox" id="button_disabled" name="<?php echo 'wlbb_page_options_meta[button_disabled]'; ?>" value="1" class="" <?php echo esc_attr( $disabled ? 'checked' : '' ); ?> >
				<label for="button_disabled">
					<div></div>		
				</label>
			</div>
		</div>

	<?php
	}

	/**
	 * Callbacks by WP Hook 'save_post' for save and sanitize the input of meta box
	 * @since    1.0.0
	 * 
	 * @return
	 */
	public function save_meta_boxes($post_id)
	{
		if( !isset($_POST['wlbb_testimonial_button_nonce']) ) {
			return $post_id;
		}

		$nonce = $_POST['wlbb_testimonial_button_nonce'];
		if( !wp_verify_nonce( $nonce, 'wlbb_testimonial_button_nonce') ) {
			return $post_id;
		}

		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		if( !current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		$post = isset( $_POST['wlbb_button_meta'] ) ? $_POST['wlbb_button_meta'] : array();
		$disabled = isset( $_POST['wlbb_page_options_meta']['button_disabled'] ) ? 1 : false;

		$sanitize = array();
		foreach ($post as $key => $value) {
			if ( isset( $value ) ) $sanitize['button'][ $key ] = 1; 
		}

		if( $disabled ) $sanitize['options']['button_disabled'] = 1; 

		update_post_meta( $post_id, '_wlbb_button_meta_key', $sanitize ); // $_POST['wlbb_button_meta'] ); 
	}

	/**
	 * Register the settings
	 * @since    1.0.0
	 * 
	 * @return
	 */
	public function setSubpages()
	{
		$this->subpages = array(
			array(
				'parent_slug' => 'wlbb_plugin', 
				'page_title' => 'Custom Button', 
				'menu_title' => 'Custom Buttons', 
				'capability' => 'manage_options', 
				'menu_slug' => 'wlbb_custom_button_page', 
				'callback' => array( $this->callbacks, 'adminCustomButton' )
			)
		);
	}
	

	/* ---------------------------------------------------- *
	*  -------------- CRUD UTILS
	*  ---------------------------------------------------- */
	/**
	 * Find all post_types with show_ui = true
	 * @since    1.0.0
	 * 
	 * @return $types   array()
	 */
	public function getPostTypes()
	{
		$post_types = get_post_types( array( 'show_ui' => true ) );
		$types = array();
		foreach( $post_types as $post_type) {
			$types[] = $post_type;
		}
		return $types;
	}

	/**
	 * Find all id of custom button created 
	 * @since    1.0.0
	 * 
	 * @return $IDs   array()
	 */
	public function getButtonKeys()
	{
		$buttons = get_option( 'wlbb_plugin_button' );
		
		$IDs = array();
		foreach( $buttons as $key => $value) {
			$IDs[] = $key;
		}
		return $IDs;
	}

	/**
	 * Get the ids-button meta-data associated to the page
	 * @since    1.0.0
	 * 
	 * @param  int $post_id    the id of post
	 * @return $IDs   array() of the button
	 */
	public function getButtonKeysMeta( $post_id )
	{
		$meta = get_post_meta( $post_id, '_wlbb_button_meta_key', true );
		$buttons = isset( $meta['button'] ) ? $meta['button'] : array();

		$IDs = array();
		foreach( $buttons as $key => $value) {
			$IDs[] = $key;
		}
		return $IDs;
	}

	/**
	 * Get the ids-button meta-data associated to the page
	 * @since    1.0.0
	 * 
	 * @param  int $post_id    the id of post
	 * @return $IDs   array() of the button
	 */
	public function getOptionDisabledMeta( $post_id )
	{
		$meta = get_post_meta( $post_id, '_wlbb_button_meta_key', true );
		$meta_options = isset( $meta['options'] ) ? $meta['options'] : array();
		$disabled = isset( $meta_options['button_disabled'] ) ? true : false;

		return $disabled;
	}

}