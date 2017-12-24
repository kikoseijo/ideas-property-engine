<?php


function mpvc_plugin_add_settings_link( $links ) {
    $settings_link = '<a href="admin.php?page='.IPE_KEY.'">' . __( 'Settings' ) . '</a>';
    $api_settings_link = '<a href="admin.php?page=mpvc_config_api">' . __( 'Configure API' ) . '</a>';
    array_push( $links, $settings_link, $api_settings_link );
  	return $links;
}

add_filter( "plugin_action_links_" . IPE_KEY, 'mpvc_plugin_add_settings_link' );
