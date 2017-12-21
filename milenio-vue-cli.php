<?php
/**
 * Plugin Name:     Milenio Vue Cli
 * Plugin URI:      BlueChillyHomes.com
 * Description:     Plugin for BlueChillyHomes accesing milenio properties
 * Author:          Kiko Seijo
 * Author URI:      http://sunnyface.com
 * Text Domain:     milenio-vue-cli
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Milenio_Vue_Cli
 */


define('MPVC_VERSION', '0.1.4');
define('MPVC_PROXY_URL', plugins_url( 'proxi.php',  __FILE__));

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

require __DIR__ . '/hooks/scripts.php';
require __DIR__ . '/hooks/admin_menu.php';
require __DIR__ . '/hooks/settings.php';
require __DIR__ . '/hooks/shortcodes.php';
