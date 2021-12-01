<?php
$sections = isset( get_option('wlbb_version_option')['button_settings_default'] ) ? get_option('wlbb_version_option')['button_settings_default'] : array();
$options = get_option( 'wlbb_plugin_button' ) ?: array();
$empty = count($options) > 0 ? 0 : 1;
?>

<div class="wrap">

	<h1>Buttons Manager</h1>
	<?php settings_errors(); ?>	

	<ul class="nav nav-tabs">
		<li class="<?php echo esc_attr( !isset($_POST['edit_button']) ? 'active' : '' ); ?>"><a href="#tab-1">Your Buttons</a></li>
		<li class="<?php echo esc_attr( isset($_POST['edit_button']) ? 'active' : '' ); ?>"><a href="#tab-2">Add Button</a></li>
		<!-- <li><a href="#tab-3">Test Buttons</a></li> -->
	</ul>

	<div class="tab-content">
		<div id="tab-1" class="tab-pane <?php echo esc_attr( !isset($_POST['edit_button']) ? 'active' : '' ); ?>">
			<h3 class="wl-float-left">Manage Your Button</h3>

			<div class="wl-float-right">
				<div class="wl-float-left">
					<table>
						<!-- <td>
							<button class="button button-small"><span class="dashicons dashicons-list-view"></span></button>
						</td>
						<td>
							<button class="button button-small"><span class="dashicons dashicons-table-row-after"></span></button>
						</td> -->
						<td>
							<div class="btn-reset">
								<?php $reset_disabled = $empty ? 'disabled' : ''; ?>
								<form id="wlbb-reset-button-form" action="#" method="post" data-url="<?php echo admin_url('admin-ajax.php'); ?>"  data-empty="<?php echo esc_attr( $empty ); ?>">
									<div id="wlbb-reset-button-container" class="wlbb-reset-container">
										
										<i id="wlbb-loading-spin" class="fa fa-spinner fa-spin wlbb-loading-spin wlbb-hide" aria-hidden="true"></i>
										<input class="submit_button button reset button-small" type="submit" value="Reset All" name="submit" <?php echo esc_attr( $reset_disabled ); ?> >
										
										<input type="hidden" name="action" value="wlbb_reset_button">
										<?php wp_nonce_field( 'ajax-rst-btn-nonce', 'wlbb_custom_button_reset' ); ?>
									</div>
								</form>
							</div>
						</td>
					</table>
				</div>
			</div>
				<table id="wlbb-button-table" class="wlbb-table display" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Singular name</th>
                            <th class="text-center">Display public</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($options as $option) {
                            $display_public = isset( $option['display_public' ]) ? "TRUE" : "FALSE";
                            ?>
                            <tr>
                                <td><?php echo esc_html( $option['button_id'] ); ?></td>
                                <td><?php echo esc_html( isset($option['title_section']) ? $option['title_section'] : '' ); ?></td>
                                <td class="text-center"><?php echo esc_html( $display_public ); ?></td>
                                <td class="text-center">
								
									<form method="post" action="" class="inline-block">                    
                                        <input type="hidden" name="edit_button" value="<?php echo esc_attr( $option['button_id'] ); ?>">
									<?php
                                        submit_button( 'Edit', 'primary small', 'submit', false );
									?>
                                    </form>
                                      

                                    <span> - </span>
									<form method="post" action="options.php" class="inline-block">
									<?php
                                        settings_fields( 'wlbb_plugin_button_settings' );
                                        submit_button( 'Delete', 'delete small', 'submit', false, array(
                                            'onclick' => 'return confirm("Are you sure you want to delete this Custom Button? The data associated with it will not be deleted.");'
                                        ) );
									?>
                                        <input type="hidden" name="remove_button" value="<?php echo esc_attr( $option['button_id'] ); ?>">
									
									</form>
                                    
                                    
                                </td>
                            </tr>
                        
                    <?php } ?>
                    </tbody>
                </table>
				<?php if ( count($options) === 0 ) : ?>
					<p>Your data is empty.
						<!-- <ul class="nav nav-tabs">
							<li>
								<a class="tab-text-link" href="#tab-2" data-empty="1">Add your custom button!</a>
							</li>
						</ul> -->
					</p>
				<?php endif; ?>
		</div>

		<div id="tab-2" class="tab-pane <?php echo esc_attr( isset($_POST['edit_button']) ? 'active' : '' ); ?>">
			<form method="post" action="options.php" class="wlbb-form">
				<?php
					settings_fields( 'wlbb_plugin_button_settings' );
					do_settings_sections( 'wlbb_button_custom' );
					submit_button();
				?>
					<input type="hidden" name="save_button">				
			</form>	
		</div>

		<!-- <div id="tab-3" class="tab-pane">
			<h3>Test Page</h3>

			Vedi table.scss
				<div class="containerDivTable">

				<div class="rowDivHeader">
					<div class="cellDivHeader">Recommendation</div>
					<div class="cellDivHeader">Typical savings</div>
					<div class="cellDivHeader">Improved SAP</div>
					<div class="cellDivHeader">Improved EI</div>
					<div class="cellDivHeader">Indicative cost</div>
					<div class="cellDivHeader">Include</div>
					<div class="cellDivHeader lastCell">Removal Reason</div>
				</div>

				<div class="rowDiv">
					<div class="cellDiv">Room-in-roof-insulation</div>
					<div class="cellDiv">93.0</div>
					<div class="cellDiv">F : 29</div>
					<div class="cellDiv">B : 89</div>
					<div class="cellDiv">£1,500 - £2,700</div>
					<div class="cellDiv">Checkbox</div>
					<div class="cellDiv lastCell">Textbox</div>
				</div>

			</div> 
		</div> --> 

		<?php 
		/* foreach ($sections as $key => $value) : 
		?>
			<div id="<?php echo $key; ?>" class="tab-pane">
				<form method="post" action="options.php" class="wlbb-form">
					<?php
						settings_fields( 'wlbb_plugin_button_settings' );
						do_settings_sections( 'wlbb_button_' . $key );
						submit_button();
					?>
				</form>	
			</div>
		<?php 
		endforeach;  */?>

	</div>
</div>