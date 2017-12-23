<?php
/**
 * Plugin Name:     Milenio Vue Cli
 * Plugin URI:      BlueChillyHomes.com
 * Description:     Plugin for BlueChillyHomes accesing milenio properties
 * Author:          Kiko Seijo
 * Author URI:      http://sunnyface.com
 * Text Domain:     mpvc
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         milenio_plus_vue_client
 */

define('MPVC_VERSION', '0.1.16');
define('MPVC_BASE_URL', plugin_dir_url( __FILE__));
define('MPVC_PROXY_URL', MPVC_BASE_URL . 'proxi.php');

 function mpvc_setup() {

 }
 add_action( 'init', 'mpvc_setup' );

 function mpvc_install() {
     mpvc_setup();
 }
 register_activation_hook( __FILE__, 'mpvc_install' );

function mpvc_deactivation() {

}
//register_deactivation_hook( __FILE__, 'mpvc_deactivation' );
register_uninstall_hook(__FILE__, 'mpvc_deactivation');

function custom_rewrite_basic() {
  add_rewrite_rule('^property-details/([^/]*)/?', 'property-details/?propertyId=$matches[1]', 'top');
}
// add_action('init', 'custom_rewrite_basic', 10, 0);

require __DIR__ . '/vars/langs.php';  // Must be the first... options are loaded from here.
require __DIR__ . '/vars/milenio.php';  // Must be the first... options are loaded from here.
require __DIR__ . '/scripts/scripts.php';  // Must be the first... options are loaded from here.
require __DIR__ . '/scripts/settings.php';
require __DIR__ . '/scripts/shortcodes.php';
