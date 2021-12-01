<?php
/*** Set the content type header ***/
header("Content-type: text/css; charset=utf8"); // Without this header, it wont work
header("Cache-Control: no-cache, must-revalidate");
header('Access-Control-Allow-Methods: GET');

$button_entity = new Wlbb\Entity\Button();
$pluginButton = $button_entity->getButtonsOption();
?>

#wlbb-btn-board-wrap {
	height: auto;
    bottom: 15px;
    text-align:center;
    position: fixed;
    z-index: 1000;
	/*padding: 15px;*/
}
#wlbb-btn-board-wrap {
    max-width: <?php echo esc_attr( $button_entity->maxWidth ) + 6; ?>px;
    float: <?php echo esc_attr( $button_entity->position ); ?>;
    <?php echo esc_attr( $button_entity->position ); ?>: 15px;
	
}

#wlbb-btn-board-wrap .overflow-hidden {
	overflow-y: hidden;
}

.wlbb-btns-container {
	text-align:center;
	width: auto;
	padding-top: 20px;
	padding-left: 15px;
	padding-right: 15px;
	padding-bottom: 0px;
}

#wlbb-btn-board-wrap .wlbb-btns-container.hide {
	opacity: 0;
}

#wlbb-btn-board-wrap a {
    text-align:center;
}

.wlbb-btns-container .pointer-none {
	pointer-events:none;
}

.wlbb-height {
	height: 15px;
}

.wlbb-icon {
	position:relative;
	text-align:center;
	width:auto;
	height:0px;
	color:#FFFFFF;
}
.wlbb-icon {
	padding:<?php echo esc_attr( $button_entity->padding ); ?>px;
	border-top-right-radius: 	<?php echo esc_attr( $button_entity->borderRadius ); ?>px;
	border-top-left-radius: 	<?php echo esc_attr( $button_entity->borderRadius ); ?>px;
	border-bottom-right-radius: <?php echo esc_attr( $button_entity->borderRadius ); ?>px;
	border-bottom-left-radius: 	<?php echo esc_attr( $button_entity->borderRadius ); ?>px; 
	-moz-border-radius: 		<?php echo esc_attr( $button_entity->borderRadius ); ?>px <?php echo esc_attr( $button_entity->borderRadius ); ?>px <?php echo esc_attr( $button_entity->borderRadius ); ?>px <?php echo esc_attr( $button_entity->borderRadius ); ?>px;
	-webkit-border-radius: 		<?php echo esc_attr( $button_entity->borderRadius ); ?>px <?php echo esc_attr( $button_entity->borderRadius ); ?>px <?php echo esc_attr( $button_entity->borderRadius ); ?>px <?php echo esc_attr( $button_entity->borderRadius ); ?>px;
	-khtml-border-radius: 		<?php echo esc_attr( $button_entity->borderRadius ); ?>px <?php echo esc_attr( $button_entity->borderRadius ); ?>px <?php echo esc_attr( $button_entity->borderRadius ); ?>px <?php echo esc_attr( $button_entity->borderRadius ); ?>px;
}

.wlbb-icon i {
	margin: 0;
	position: absolute;
	top: 50%;
	left: 50%;
	margin-right: -50%;
	transform: translate(-50%, -50%);
}
.wlbb-icon i {
	font-size:<?php echo esc_attr( $button_entity->size ); ?>px;
	color:<?php echo esc_attr( $button_entity->default_icon_color ); ?>;
	transition: 0.5s;
	-moz-transition: 0.5s;
	-webkit-transition: 0.5s;
	-o-transition: 0.5s;
}

.wlbb-icon i img.wlbb-image-icon {
  	width: 100%;
  	max-width:<?php echo esc_attr( $button_entity->max_width_image ); ?>px;
	vertical-align: inherit;
}

.wlbb-icon.wlbb-button {
	margin: 5px 0 0 0;
	cursor:pointer;
	transition: 0.5s;
	-moz-transition: 0.5s;
	-webkit-transition: 0.5s;
	-o-transition: 0.5s; 	
}
.wlbb-icon.wlbb-button {
	background:<?php echo esc_attr( $button_entity->default_background_color ); ?>;
}
.wlbb-icon.wlbb-button:hover {
	transition: 0.5s;
	-moz-transition: 0.5s;
	-webkit-transition: 0.5s;
	-o-transition: 0.5s;
}
.wlbb-icon.wlbb-button:hover {
	background:<?php echo esc_attr( $button_entity->default_background_color_hover ); ?>;
}

.wlbb-icon.wlbb-button:hover i {
	color:<?php echo esc_attr( $button_entity->default_icon_color_hover ); ?>;
	transition: 0.5s;
	-moz-transition: 0.5s;
	-webkit-transition: 0.5s;
	-o-transition: 0.5s;
}

<?php if ( $button_entity->shadowBox != '' ) : ?>
.wlbb-icon.wlbb-button.shadow_box {
	-webkit-filter:	<?php echo esc_attr( $button_entity->default_shadow ); ?>;
	-moz-filter: 	<?php echo esc_attr( $button_entity->default_shadow ); ?>;
	-ms-filter: 	<?php echo esc_attr( $button_entity->default_shadow ); ?>;
	-o-filter: 		<?php echo esc_attr( $button_entity->default_shadow ); ?>;
	filter: 		<?php echo esc_attr( $button_entity->default_shadow ); ?>;	
}

.wlbb-icon.wlbb-button.hover_shadow_box:hover {
	-webkit-filter:	<?php echo esc_attr( $button_entity->default_shadow ); ?>;
	-moz-filter: 	<?php echo esc_attr( $button_entity->default_shadow ); ?>;
	-ms-filter: 	<?php echo esc_attr( $button_entity->default_shadow ); ?>;
	-o-filter: 		<?php echo esc_attr( $button_entity->default_shadow ); ?>;
	filter: 		<?php echo esc_attr( $button_entity->default_shadow ); ?>;	
}
<?php endif; ?>

<?php if ($button_entity->mobileOnly) : ?>
	@media screen and (min-width: <?php echo esc_attr( $button_entity->mobileSwitch ); ?>px) {
		#wlbb-btn-board-wrap { display: none; }			
	}
<?php endif; ?>

/**	
 * Buttons Option
 */
<?php foreach ($pluginButton as $button => $values) : 
    $button_id = isset($values['button_id']) ? $values['button_id'] : '';
	$custom_border_radius = isset( $values['border_radius'] ) ? $values['border_radius'] : $button_entity->defaultBorder;
	$background_color = isset( $values['background_color'] ) ? $values['background_color'] : $button_entity->default_background_color;
	$background_color_hover = isset( $values['background_color_hover'] ) ? $values['background_color_hover'] : $button_entity->default_background_color_hover;
	$icon_color = isset( $values['icon_color'] ) ? $values['icon_color'] : $button_entity->default_icon_color;
	$icon_color_hover = isset( $values['icon_color_hover'] ) ? $values['icon_color_hover'] : $button_entity->default_icon_color_hover;
	$custom_border_radius = isset($values['border_radius']) ? $values['border_radius'] : '';

?>

.wlbb-icon i.wlbb-<?php echo esc_attr( $button_id ); ?> {
	color:<?php echo esc_attr( $icon_color ); ?>;
}

.wlbb-icon.wlbb-button.wlbb-<?php echo esc_attr( $button_id ); ?> {
	background:<?php echo esc_attr( $background_color ); ?>;
	<?php if ( $custom_border_radius != '' ) : ?>
		border-top-right-radius: 	<?php echo esc_attr( $custom_border_radius ); ?>px;
		border-top-left-radius: 	<?php echo esc_attr( $custom_border_radius ); ?>px;
		border-bottom-right-radius: <?php echo esc_attr( $custom_border_radius ); ?>px;
		border-bottom-left-radius: 	<?php echo esc_attr( $custom_border_radius ); ?>px; 
		-moz-border-radius: 		<?php echo esc_attr( $custom_border_radius ); ?>px <?php echo esc_attr( $custom_border_radius ); ?>px <?php echo esc_attr( $custom_border_radius ); ?>px <?php echo esc_attr( $custom_border_radius ); ?>px;
		-webkit-border-radius: 		<?php echo esc_attr( $custom_border_radius ); ?>px <?php echo esc_attr( $custom_border_radius ); ?>px <?php echo esc_attr( $custom_border_radius ); ?>px <?php echo esc_attr( $custom_border_radius ); ?>px;
		-khtml-border-radius: 		<?php echo esc_attr( $custom_border_radius ); ?>px <?php echo esc_attr( $custom_border_radius ); ?>px <?php echo esc_attr( $custom_border_radius ); ?>px <?php echo esc_attr( $custom_border_radius ); ?>px;
	<?php endif; ?>
}
.wlbb-icon.wlbb-button.wlbb-<?php echo esc_attr( $button_id ); ?>:hover {
	background:<?php echo esc_attr( $background_color_hover ); ?>;
}

.wlbb-icon.wlbb-button.wlbb-<?php echo esc_attr( $button_id ); ?>:hover i.wlbb-<?php echo esc_attr( $button_id ); ?> {
	color:<?php echo esc_attr( $icon_color_hover ); ?>;
}
<?php endforeach; ?>

/**
 * SINGLE DISPLAY BUTTON
 */
.wlbb-btns-container .wlbb-icon-pane {
    display: none;
}

.wlbb-btns-container .wlbb-icon-pane.active {
    display: block;
}

/**
 * ANIMATION
 */
<?php
// $animation = isset( $pluginGeneral['animation_style'] ) ? $pluginGeneral['animation_style'] : '';
// $button_entity->animation_class = isset( $animation['animation_name'] ) ? 'wlbb-' . $animation['animation_name'] : false;
// $animation_duration = isset( $animation['animation_duration'] ) ? $animation['animation_duration'] / 1000 : false;
// $animation_iteration = isset( $animation['animation_iteration'] ) ? $animation['animation_iteration'] : 'infinite';

if($button_entity->animation_class) :
?>
	/** ####### PULSE ####### */
	.wlbb-icon.wlbb-button.wlbb-pulse {
		animation-name: <?php echo esc_attr( $button_entity->animation_class ); ?>;
		animation-duration: <?php echo esc_attr( $button_entity->animation_duration ?: 2.5 ); ?>s;
		animation-timing-function: ease-out;
		animation-iteration-count: <?php echo esc_attr( $button_entity->animation_iteration ?: 'infinite' ); ?>;	
	}

	/** ####### ZOOM ####### */
	.wlbb-icon.wlbb-button.wlbb-zoom {
		animation-name: <?php echo esc_attr( $button_entity->animation_class ); ?>;
		animation-duration: <?php echo esc_attr( $button_entity->animation_duration ?: 3 ); ?>s;
		animation-timing-function: ease-out;
		animation-iteration-count: <?php echo esc_attr( $button_entity->animation_iteration ?: 'infinite' ); ?>;	
	}

	/** ####### DOUBLE ROTATE ####### */
	.wlbb-icon.wlbb-button.wlbb-double_rotate {
		animation-name: <?php echo esc_attr( $button_entity->animation_class ); ?>;
		animation-duration: <?php echo esc_attr( $button_entity->animation_duration ?: 12 ); ?>s;
		animation-timing-function: ease-out;
		animation-iteration-count: <?php echo esc_attr( $button_entity->animation_iteration ?: 'infinite' ); ?>;	
	}

	/** ####### ROTATE ####### */
	.wlbb-icon.wlbb-button.wlbb-rotate {
		animation-name: <?php echo esc_attr( $button_entity->animation_class ); ?>;
		animation-duration: <?php echo esc_attr( $button_entity->animation_duration ?: 6 ); ?>s;
		animation-timing-function: ease-out;
		animation-iteration-count: <?php echo esc_attr( $button_entity->animation_iteration ?: 'infinite' ); ?>;	
	}

	/** ####### PULSE & ROTATE ####### */
	.wlbb-icon.wlbb-button.wlbb-pulse_rotate {
		animation-name: <?php echo esc_attr( $button_entity->animation_class ); ?>;
		animation-duration: <?php echo esc_attr( $button_entity->animation_duration ?: 6 ); ?>s;
		animation-timing-function: ease-out;
		animation-iteration-count: <?php echo esc_attr( $button_entity->animation_iteration ?: 'infinite' ); ?>;	
	}

	/** ####### ZOOM & ROTATE ####### */
	.wlbb-icon.wlbb-button.wlbb-zoom_rotate {
		animation-name: <?php echo esc_attr( $button_entity->animation_class ); ?>;
		animation-duration: <?php echo esc_attr( $button_entity->animation_duration ?: 6 ); ?>s;
		animation-timing-function: ease-out;
		animation-iteration-count: <?php echo esc_attr( $button_entity->animation_iteration ?: 'infinite' ); ?>;	
	}

	/** ####### ZOOM & ROTATE & PULSE ####### */
	.wlbb-icon.wlbb-button.wlbb-zoom_rotate_pulse {
		animation-name: <?php echo esc_attr( $button_entity->animation_class ); ?>;
		animation-duration: <?php echo esc_attr( $button_entity->animation_duration ?: 6 ); ?>s;
		animation-timing-function: ease-out;
		animation-iteration-count: <?php echo esc_attr( $button_entity->animation_iteration ?: 'infinite' ); ?>;	
	}

	@keyframes wlbb-pulse {
		0% { box-shadow: 0 0 0 0 <?php echo esc_attr( hex2rgba( $button_entity->black_background_color, 0.6 ) ); ?>; }
		40% { box-shadow: 0 0 0 5px <?php echo esc_attr( hex2rgba( $button_entity->black_background_color, 0.4 ) ); ?>; }
		60% { box-shadow: 0 0 0 9px <?php echo esc_attr( hex2rgba( $button_entity->black_background_color, 0.05 ) ); ?>; }
	}

	@keyframes wlbb-double_rotate {
		0% {transform: rotate(0deg);}
		25% {transform: rotate(360deg);}
		50% {transform: rotate(0deg);}
		75% {transform: rotate(360deg);}
	   100% {transform: rotate(0deg);}
	}

	@keyframes wlbb-zoom {
		0% { transform: scale(1.1); }
	}

	@keyframes wlbb-rotate {
		0% {transform: rotate(0deg);}
	  100% {transform: rotate(360deg);}
	}

	@keyframes wlbb-pulse_rotate {
		5% { transform: rotate(360deg); }
	   10% { transform: scale(1.0); }
	   15% { box-shadow: 0 0 0 0 <?php echo esc_attr( hex2rgba( $button_entity->black_background_color, 0.6 ) ); ?>; }
	   30% { box-shadow: 0 0 0 5px <?php echo esc_attr( hex2rgba( $button_entity->black_background_color, 0.4 ) ); ?>; }
	   45% { box-shadow: 0 0 0 10px <?php echo esc_attr( hex2rgba( $button_entity->black_background_color, 0.15 ) ); ?>; }
	   60% { box-shadow: 0 0 0 14px <?php echo esc_attr( hex2rgba( $button_entity->black_background_color, 0.05 ) ); ?>; }
	}

	@keyframes wlbb-zoom_rotate {
	   10% { transform: scale(1.1); }
	   15% { 
			transform: scale(1.0);
			box-shadow: 0 0 0 0 <?php echo esc_attr( hex2rgba( $button_entity->black_background_color, 0.6 ) ); ?>; 
		}
	   30% { box-shadow: 0 0 0 5px <?php echo esc_attr( hex2rgba( $button_entity->black_background_color, 0.4 ) ); ?>; }
	   45% { box-shadow: 0 0 0 10px <?php echo esc_attr( hex2rgba( $button_entity->black_background_color, 0.15 ) ); ?>; }
	   60% { box-shadow: 0 0 0 14px <?php echo esc_attr( hex2rgba( $button_entity->black_background_color, 0.05 ) ); ?>; }
	}

	@keyframes wlbb-zoom_rotate_pulse {
	   5% { transform: scale(1.1); }
	   10% { 
		   transform: scale(1.0);
		}
	   11% { transform: rotate(360deg); }
	   15% { 
			transform: rotate(0deg);
			box-shadow: 0 0 0 0 <?php echo esc_attr( hex2rgba( $button_entity->black_background_color, 0.6 ) ); ?>; 
		}
	   30% { box-shadow: 0 0 0 5px <?php echo esc_attr( hex2rgba( $button_entity->black_background_color, 0.4 ) ); ?>; }
	   45% { box-shadow: 0 0 0 10px <?php echo esc_attr( hex2rgba( $button_entity->black_background_color, 0.15 ) ); ?>; }
	   60% { box-shadow: 0 0 0 14px <?php echo esc_attr( hex2rgba( $button_entity->black_background_color, 0.05 ) ); ?>; }
	}

	@keyframes wlbb-zoom_rotate_pulse_2 {
	   5% { transform: scale(1.1); }
	   10% { 
		   transform: scale(1.0);
		}
	   11% { transform: rotate(0deg); }
	   15% { 
			transform: rotate(360deg);
			box-shadow: 0 0 0 0 <?php echo esc_attr( hex2rgba( $button_entity->black_background_color, 0.6 ) ); ?>; 
		}
	   30% { box-shadow: 0 0 0 5px <?php echo esc_attr( hex2rgba( $button_entity->black_background_color, 0.4 ) ); ?>; }
	   45% { box-shadow: 0 0 0 10px <?php echo esc_attr( hex2rgba( $button_entity->black_background_color, 0.15 ) ); ?>; }
	   60% { box-shadow: 0 0 0 14px <?php echo esc_attr( hex2rgba( $button_entity->black_background_color, 0.05 ) ); ?>; }
	}
	
<?php endif; ?>

<?php
/* Convert hexdec color string to rgb(a) string */
function hex2rgba($color, $opacity = false) {

	$default = 'rgb(0,0,0)';

	//Return default if no color provided
	if(empty($color)) return $default; 

	//Sanitize $color if "#" is provided 
        if ($color[0] == '#' ) { $color = substr( $color, 1 ); }

        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) { $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] ); } 
		elseif ( strlen( $color ) == 3 ) { $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] ); }
		else { return $default; }

        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);

        //Check if opacity is set(rgba or rgb)
        if($opacity){
        	if(abs($opacity) > 1)
        		$opacity = 1.0;
        	$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
        	$output = 'rgb('.implode(",",$rgb).')';
        }

        //Return rgb(a) color string
        return $output;
}
?>