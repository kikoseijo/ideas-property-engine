<?php

add_action( 'admin_menu', 'mpvc_add_admin_menu' );
// add_action( 'admin_init', 'mpvc_settings_init' );

function mpvc_add_admin_menu(  ) {

	add_menu_page( 'HIPE Property engine', 'HIPE Agent', 'manage_options', IPE_KEY, 'mpvc_options_page', 'dashicons-admin-home', 10);
  //
	// add_submenu_page( IPE_KEY, 'HIPE - Admin Styling configuration', 'Configure Styles', 'manage_options', 'mpvcStyleVars', 'mpvc_style_page');
	// add_submenu_page( IPE_KEY, 'HIPE - Configure API', 'Configure API', 'manage_options', 'mpvc_config_api', 'mpvcApiVars', 'mpvc_api_page');
}


function mpvc_options_page()
{
	wp_enqueue_script(IPE_KEY .'-manifest');
  wp_enqueue_script(IPE_KEY .'-vendors');
  wp_enqueue_script(IPE_KEY .'-scripts');
  wp_enqueue_style(IPE_KEY .'-styles');
	?>
	<div class="wrap">
		<h1>HIPE - Property search</h1>
		<hr>
		<div id="mpvc-app">
			<admin-table></admin-table>
		</div>
	</div>
	<?php
}
