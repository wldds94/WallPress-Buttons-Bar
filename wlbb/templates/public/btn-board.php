<?php
/* *
 * Name: btn-board-template
 * 
 * Call by Class CustomButton for filter the content with 'wp_body_open' hook
 * 
 * Use for display the Buttons Board
 * */

/* *
 * Store variables and instanciate the Button Entity Class
 */
$button_entity = new Wlbb\Entity\Button();
global $post;
$buttonsList = $button_entity->setButtonsDisplayList( is_archive(), $post->ID, $post->post_type );

if( count( $buttonsList) < 1 ) return;

wp_enqueue_script( 'wlbb_button_script', WLBB_PLUGIN_URL . 'dist/js/button-script.js' );
// Localize the variables for the JS script
wp_localize_script( 'wlbb_button_script', 'wlbb_buttons_vars', array(
    'timing_show' => esc_attr( $button_entity->timingAppereanceMode ),
    'delay'       => esc_attr( $button_entity->delay ),
    'interval_switch' => esc_attr( $button_entity->switchInterval ),
    'author'      => 'Walter Laidelli'
) );

$count = 0; // Initialize index for start active button
?>

<div class="wlbb-btn-board-wrap" id="wlbb-btn-board-wrap">
    <div class="wlbb-btns-container <?php echo esc_attr( $button_entity->hideClass );?> <?php echo esc_attr($button_entity->appereanceMode); ?> <?php echo esc_attr($button_entity->overflow_hidden); ?>">

        <?php 
        foreach( $buttonsList as $button => $values ) : 
            $button_entity->setSingleDisplay( $values ); 
            if( $button_entity->single_display ) : 
                $active = $count > 0 ? '' : 'active'; ?>
                <div class="wlbb-icon-pane wlbb-icon-pane-<?php echo esc_attr($count); ?> <?php echo esc_attr($active); ?>" data-count="<?php echo esc_attr($count); ?>">
            <?php 
            endif; ?>
                    <!-- <div style="height:15px;"></div> -->
                    <div class="<?php echo esc_attr($button_entity->extra_class); ?> pointer-none" id="<?php echo esc_attr($button_entity->extra_id); ?>">
                        <?php if( $count == 0) : ?><div class="wlbb-height"></div><?php endif; ?> <?php // Print the div that delete with JS ?>
                        <div class='wlbb-icon wlbb-button wlbb-<?php echo esc_attr($button_entity->button_id); ?> <?php echo esc_attr($button_entity->shadowBox); ?> <?php echo esc_attr($button_entity->extra_class); ?> <?php echo $button_entity->animation_class?>'>
                            <a href="<?php echo esc_url( $button_entity->url ); ?>" class="pointer-none" target="<?php echo esc_attr($button_entity->target); ?>" rel="noopener">
                                <i class='<?php echo esc_attr($button_entity->icon); ?> wlbb-<?php echo esc_attr($button_entity->button_id); ?>' aria-hidden="true">
                                    <?php if( $button_entity->upload ) : ?>
                                        <img src="<?php echo esc_url( $button_entity->upload_url ); ?>" class="wlbb-image-icon" />
                                    <?php endif; ?>
                                </i>  
                            </a>                  
                        </div>
                    </div>
            <?php 
            if( $button_entity->single_display ) : ?>
                </div> <?php // Close .wlbb-icon-pane.wlbb-icon-pane-* ?>
            <?php 
            endif;
            $count++;

        endforeach; ?>

    </div>
</div>


<?php
    /**
     * TESTING
     */
    // if (is_singular()) { echo 'Singular'; }
    // if (is_archive()) { echo 'Archive'; }
    // if (is_page()) { echo 'Page'; }
?>