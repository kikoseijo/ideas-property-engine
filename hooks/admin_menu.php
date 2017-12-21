<?php




function mpvc_options_page()
{
    $page_title = 'Milenio CLI';
    $menu_title = 'Milenio Settings';
    $capability = 'manage_options';
    // embed function
    $menu_slug = 'milenio-settings';
    $function = 'mpvc_options_page_html';
    // File
    // $menu_slug = plugin_dir_path(__FILE__) . 'admin/view.php',;
    // $function = null;
    $icon_url = 'dashicons-admin-home';// plugin_dir_url(__FILE__) . 'images/icon_mpvc.png';
    $position = 20;
    add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position);
    // add_submenu_page($parent_slug, $page_title, $menu_title,  $capability, $menu_slug, $function = '');
}
add_action('admin_menu', 'mpvc_options_page');
