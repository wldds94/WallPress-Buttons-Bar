<div class="wrap">
    <h1>Wlbb Dashboard Plugin</h1>
	<?php settings_errors(); ?>

	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab-1">Manage Settings</a></li>
		<li><a href="#tab-2">General Settings</a></li>
		<!-- <li><a href="#tab-3">Shortcodes</a></li> -->
		<!-- <li><a href="#tab-4">Updates</a></li> -->
		<li><a href="#tab-5">About</a></li>
		<!-- <li><a href="#tab-6">Dev API</a></li> -->
	</ul>

	<div class="tab-content">
		<div id="tab-1" class="tab-pane active">
			<form method="post" action="options.php">
				<?php 
					settings_fields( 'wlbb_plugin_settings' );
					do_settings_sections( 'wlbb_plugin' );
					submit_button();
				?>
			</form>			
		</div>

		<div id="tab-2" class="tab-pane">
			<p>Here you can set the general configuration.</p>

			<div class="wl-float-right">
				<div class="wl-float-left">
					<table>
						<td>
							<div class="btn-reset">
								<form id="wlbb-reset-general-opt-form" action="#" method="post" data-url="<?php echo admin_url('admin-ajax.php'); ?>" >
									<div id="wlbb-reset-button-container" class="wlbb-reset-container">
										
										<i id="wlbb-loading-spin" class="fa fa-spinner fa-spin wlbb-loading-spin wlbb-hide" aria-hidden="true"></i>
										<input class="submit_button button reset button-small" type="submit" value="Reset All" name="submit" />
										
										<input type="hidden" name="action" value="wlbb_reset_general">
										<?php wp_nonce_field( 'ajax-rst-gen-opt-nonce', 'wlbb_custom_general_reset' ); ?>
									</div>
								</form>
							</div>
						</td>
					</table>
				</div>
			</div>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'wlbb_plugin_general_settings' );
					do_settings_sections( 'wlbb_general_settings' );
					submit_button();
				?>
			</form>				
		</div>

		<!-- <div id="tab-3" class="tab-pane">
			<h3>Shortcodes</h3>
		</div> -->

		<!-- <div id="tab-4" class="tab-pane" style="min-height: 450px;">
			<h3>Updates</h3>
			<p>Stai utilizzando l'ultima versione del Plugin" :)</p>
		</div> -->

		<div id="tab-5" class="tab-pane">

			<div class="wlbb-amdim-dashboard-header">
				<img src="<?php echo esc_url( WLBB_PLUGIN_URL . 'dist/assets/img/logo.png' ); ?>" alt="Logo non trovato">
				<h1>The WallPress Buttons Board</h1>
			</div>

			<h3>Help</h3>
			<div class="wlbb-admin-documentation">

				<div class="wlbb-admin-step-doc">
					<p><h4>1 - Active the Features by Dashboard <a href="<?php echo admin_url( 'admin.php?page=wlbb_plugin' ); ?>">Manage Settings Tab</a></h4></p>
					<div>
						<img src="<?php echo esc_url( WLBB_PLUGIN_URL . 'dist/assets/img/wlbb_activation_features.png' ); ?>" alt="Immagine non trovata">
					</div>
					<div class="border-bottom-delimiter" style="border-bottom:1px solid #a9a9af; margin-top:35px;"></div>
				</div>

				<div class="wlbb-admin-step-doc">
					<p><h4>2 - Set the general configuration by Dashboard <a href="<?php echo admin_url( 'admin.php?page=wlbb_plugin' ); ?>">General Settings Tab</a></h4></p>
					<div>
						<img src="<?php echo esc_url( WLBB_PLUGIN_URL . 'dist/assets/img/wlbb_general_configuration.png' ); ?>" alt="Immagine non trovata">
					</div>
					<div class="border-bottom-delimiter" style="border-bottom:1px solid #a9a9af; margin-top:35px;"></div>
				</div>

				<div class="wlbb-admin-step-doc">
					<p><h4>3 - Customize your button board by <a href="<?php echo admin_url( 'admin.php?page=wlbb_custom_button_page' ); ?>">Custom Button Manager</a></h4></p>
					<p>Click on tab <b>"Add Button"</b> and set start with your creation.</p>
					<div>
						<img src="<?php echo esc_url( WLBB_PLUGIN_URL . 'dist/assets/img/wlbb_custom_list_btn.png' ); ?>" alt="Immagine non trovata">
					</div>
					<div class="border-bottom-delimiter" style="border-bottom:1px solid #a9a9af; margin-top:35px;"></div>
				</div>

				<div class="wlbb-admin-step-doc">
					<p>Customize the single button.</p>
					<div>
						<img src="<?php echo esc_url( WLBB_PLUGIN_URL . 'dist/assets/img/wlbb_add_custom_btn.png' ); ?>" alt="Immagine non trovata">
					</div>
					<div class="border-bottom-delimiter" style="border-bottom:1px solid #a9a9af; margin-top:35px;"></div>
				</div>

				<div class="wlbb-admin-step-doc">
					<p><h4>4 - Customize the single page by the meta box. Find your configuration.</h4></p>
					<div>
						<img src="<?php echo esc_url( WLBB_PLUGIN_URL . 'dist/assets/img/wlbb_custom_meta_btn.png' ); ?>" alt="Immagine non trovata">
					</div>
					<div class="border-bottom-delimiter" style="border-bottom:1px solid #a9a9af; margin-top:35px;"></div>
				</div>

			</div>
		</div>

		<!-- <div id="tab-6" class="tab-pane">
			<h3>API Settings</h3> -->
			<?php
				// $wlbb_plugin = get_option( 'wlbb_plugin' ) ?: array();
				// $wlbb_plugin_general = get_option( 'wlbb_plugin_general' ) ?: array();
				// $wlbb_plugin_button = get_option( 'wlbb_plugin_button' ) ?: array();

				// echo '<pre>';
				// echo 'wlbb_plugin: ';
				// var_dump( $wlbb_plugin );

				// echo '<pre>';
				// echo 'wlbb_plugin_general: ';
				// var_dump( $wlbb_plugin_general );

				// echo '<pre>';
				// echo 'wlbb_plugin_button: ';
				// var_dump( $wlbb_plugin_button );
				// echo '</pre>';
			?>
		<!-- </div> -->

	</div>
</div>