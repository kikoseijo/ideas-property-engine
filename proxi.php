<?php

// error_reporting(E_ALL & ~E_NOTICE);

define( 'WP_USE_THEMES', false );
require_once '../../../wp-load.php';

$options = get_option( 'mpvc_settings' );

$http_basic_user     = $options['mpvc_field_api_user'];
$http_basic_password = $options['mpvc_field_api_pass'];
$http_host_path      = $options['mpvc_field_api_url'] .'/v'.$options['mpvc_field_api_version'].'/' . $_REQUEST['path'];
$http_scheme         = 'https';

if (!($http_basic_user && $http_basic_password && $http_host_path)) {
  http_response_code(500);
  die('Invalid parameters');
}
if (!$http_scheme) {
  $http_scheme =  'https';
}
$url = sprintf('%s://%s:%s@%s?%s',
  $http_scheme,
  $http_basic_user,
  $http_basic_password,
  $http_host_path,
  $_SERVER['QUERY_STRING']
);
print file_get_contents($url);
