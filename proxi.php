<?php

error_reporting(E_ALL & ~E_NOTICE);

$http_basic_user     = '509API';
$http_basic_password = 'ce156d2106d48769';
$http_host_path      = 'api.milenioplus.com/v2/' . $_REQUEST['path'];
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
