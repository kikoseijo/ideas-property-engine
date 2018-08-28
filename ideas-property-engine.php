<?php
/*
Plugin Name:     HIPE Property Engine
Plugin URI:      BlueChillyHomes.com
Description:     Plugin for connecting Wordpress with Milenio Plus Marbella property engine.
Author:          Diseño Ideas
Author URI:      http://disenoideas.com/contact/
Text Domain:     ideas-property-engine
Domain Path:     /languages
Version:         1.0.3
@package         ideas-property-engine
*/


 define('IPE_VERSION', '1.0.3');
 define('IPE_KEY', 'ideas-property-engine');
 define('IPE_BASE_URL', plugin_dir_url(__FILE__));
 // define('IPE_BASE_NAME', plugin_basename( __FILE__));
 define('IPE_PROXY_URL', IPE_BASE_URL . 'proxi.php');

 // VARS
 require __DIR__ . '/milenio.php';

 // Libs
 require __DIR__ . '/libs/helpers.php';

 // Plugin functionality
 require __DIR__ . '/scripts/filters.php';
 require __DIR__ . '/scripts/scripts.php';
 require __DIR__ . '/scripts/shortcodes.php';

 // Admin options
 if (is_admin()) {
     require __DIR__ . '/admin/AdminOptions.php';
     require __DIR__ . '/admin/AdminOptionsListing.php';
     require __DIR__ . '/admin/AdminOptionsStyle.php';
     require __DIR__ . '/admin/AdminOptionsApi.php';
 }

 add_action('plugins_loaded', 'idea_plugin_init');
 function idea_plugin_init()
 {
     load_plugin_textdomain('ideas-property-engine', false,  basename( dirname( __FILE__ ) ) . '/languages');
 }
