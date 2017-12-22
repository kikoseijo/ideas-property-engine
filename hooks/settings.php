<?php


add_action( 'admin_menu', 'mpvc_add_admin_menu' );
add_action( 'admin_init', 'mpvc_settings_init' );


function mpvc_add_admin_menu(  ) {

	add_options_page( 'Milenio Vue Cli', 'MPVC Settings', 'manage_options', 'milenio_plus_vue_client', 'mpvc_options_page', 'dashicons-admin-home', 20);

}


function mpvc_settings_init(  ) {

	register_setting( 'pluginPage', 'mpvc_settings' );

	add_settings_section(
		'mpvc_pluginPage_section',
		__( 'API credentials', 'mpvc' ),
		'mpvc_api_section_callback',
		'pluginPage'
	);

	add_settings_field(
		'mpvc_field_api_user',
		__( 'API user', 'mpvc' ),
		'mpvc_field_api_user_render',
		'pluginPage',
		'mpvc_pluginPage_section'
	);

	add_settings_field(
		'mpvc_field_api_pass',
		__( 'API password', 'mpvc' ),
		'mpvc_field_api_pass_render',
		'pluginPage',
		'mpvc_pluginPage_section'
	);

	add_settings_field(
		'mpvc_field_api_url',
		__( 'API url', 'mpvc' ),
		'mpvc_field_api_url_render',
		'pluginPage',
		'mpvc_pluginPage_section'
	);

	add_settings_field(
		'mpvc_field_api_version',
		__( 'Api version', 'mpvc' ),
		'mpvc_field_api_version_render',
		'pluginPage',
		'mpvc_pluginPage_section'
	);

	add_settings_section(
		'mpvc_pluginPageSettings_section',
		__( 'Plugin configuration', 'mpvc' ),
		'mpvc_settings_section_callback',
		'pluginPage'
	);

	add_settings_field(
		'page_id',
		__( 'Property details page', 'mpvc' ),
		'mpvc_field_settings_detail_render',
		'pluginPage',
		'mpvc_pluginPageSettings_section'
	);

	add_settings_field(
		'listing_page_records_number',
		__( 'Properties per page', 'mpvc' ),
		'mpvc_listing_page_records_number_render',
		'pluginPage',
		'mpvc_pluginPageSettings_section'
	);

}


function mpvc_field_api_user_render()
{
	?>
	<input type='text' name='mpvc_settings[mpvc_field_api_user]' value='<?php echo getMpvcOptions('mpvc_field_api_user'); ?>'>
	<?php
}

function mpvc_field_api_pass_render()
{
	?>
	<input type='password' name='mpvc_settings[mpvc_field_api_pass]' value='<?php echo getMpvcOptions('mpvc_field_api_pass'); ?>'>
	<?php
}


function mpvc_field_api_url_render()
{
	?>
	<input type='text' class='regular-text' name='mpvc_settings[mpvc_field_api_url]' value='<?php echo getMpvcOptions('mpvc_field_api_url'); ?>'>
	<p class="description">Dont include schema, should be in the format of: <em><strong>api.milenioplus.com</strong></em></p>
	<?php
}

function mpvc_field_api_version_render()
{
	$value = getMpvcOptions('mpvc_field_api_version');
	?>
		<select name='mpvc_settings[mpvc_field_api_version]'>
			<option value='1' <?php selected( $value, 1 ); ?>>Api version 1</option>
			<option value='2' <?php selected( $value, 2 ); ?>>Api version 2</option>
		</select>
	<?php
}

function mpvc_field_settings_detail_render()
{
	?>
		<select name="mpvc_settings[page_id]">
	    <?php
	    if( $pages = get_pages() ){
	      foreach( $pages as $page ){
	        echo '<option value="' . $page->ID . '" ' . selected( $page->ID, getMpvcOptions('page_id')) . '>' . $page->post_title . '</option>';
	      }
	    }
	    ?>
	  </select>
		<p class="description">
			Select the property detail page.<br />
			Make sure you include the shortcode in its content <strong style="color:red">[mpvc-detail]</strong>
		</p>
	<?php
}

function mpvc_listing_page_records_number_render()
{
	?>
	<input type='number' name='mpvc_settings[listing_page_records_number]' value='<?php echo getMpvcOptions('listing_page_records_number'); ?>'>
	<p class="description">
		Max number its limited to 20 records per page.<br />
	</p>
	<?php
}


function mpvc_api_section_callback(  )
{
	echo __( 'Configure here with the settings provided by Milenio Plus, api information are provided upon request, please contact <a href="https://www.milenioplus.com" target="_blank">Milenio Plus</a> to obtain yours.', 'mpvc' );
}

function mpvc_settings_section_callback(  )
{
	echo __( 'In this section you must configure required field for the plugin to work without errors.', 'mpvc' );
}


function mpvc_options_page()
{
	?>
	<form action='options.php' method='post'>
		<h1>MPVC - Plugin settings</h1>
		<?php
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );
		submit_button();
		?>
	</form>
	<?php
}
