<?php

function mpvc_listing($atts = [], $content = null, $tag = '')
{
    // Property details page
    $pageId = getMpvcOptions( 'page_id' );
    if (!($pageId>0)) {
      return 'MPVC - ERROR: You must configure detail page id in the plugin settins, you can find the settings in Wordpress control panel, Settings > MPVC Settings > Property details page';
    }

    $atts = array_change_key_case((array)$atts, CASE_LOWER);
    $mpvc_atts = shortcode_atts([
        'tint_color' => '#074997',
        'h_search_color' => '#f9f9f9',
        'img_width' => '100%',
        'img_height' => '300px',
        'detail_page' => get_permalink( $pageId ),
    ], $atts, $tag);

    wp_enqueue_script('mpvc-manifest');
    wp_enqueue_script('mpvc-vendors');
    wp_enqueue_script('mpvc-scripts');
    wp_enqueue_style('mpvc-styles');
    // wp_enqueue_style('mpvc-elements');

    $o = '<div id="mpvc-app">';
    $o .= '<filters-horizontal tint-color="'.$mpvc_atts['tint_color'].'" bg-color="'.$mpvc_atts['h_search_color'].'"></filters-horizontal>';
    $o .= '<search-filters tint-color="'.$mpvc_atts['tint_color'].'" bg-color="'.$mpvc_atts['h_search_color'].'"></search-filters>';
    $o .= '<property-listing-loadmore';
    $o .= ' tint-color="'.$mpvc_atts['tint_color'].'"';
    $o .= ' i-height="'.$mpvc_atts['img_height'].'"';
    $o .= ' i-width="'.$mpvc_atts['img_width'].'"';
    $o .= ' detail-url="'.$mpvc_atts['detail_page'].'"';
    $o .= '></property-listing-loadmore>';
    $o .= '</div>';
    return $o;
}

function mpvc_detail($atts = [], $content = null, $tag = '')
{
    $atts = array_change_key_case((array)$atts, CASE_LOWER);
    $mpvc_atts = shortcode_atts([
        'tint_color' => '#074997',
        'slider_height' => '500px',
    ], $atts, $tag);

    wp_enqueue_script('mpvc-manifest');
    wp_enqueue_script('mpvc-vendors');
    wp_enqueue_script('mpvc-scripts');
    wp_enqueue_style('mpvc-styles');

    $o = '<div id="mpvc-app">';
    $o .= '<property-details';
    $o .= ' slider-height="'.$mpvc_atts['slider_height'].'"';
    $o .= ' tint-color="'.$mpvc_atts['tint_color'].'"';
    $o .= '></property-details>';
    $o .= '</div>';
    return $o;
}

function mpvc_shortcodes_init()
{
    add_shortcode('mpvc-listings', 'mpvc_listing');
    add_shortcode('mpvc-detail', 'mpvc_detail');
}

add_action('init', 'mpvc_shortcodes_init');
