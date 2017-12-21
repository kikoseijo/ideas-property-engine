<?php

function mpvc_listing($atts = [], $content = null, $tag = '')
{
    $atts = array_change_key_case((array)$atts, CASE_LOWER);
    $mpvc_atts = shortcode_atts([
        'width' => '100%',
        'detail-url' => '/property-details/',
        'height' => '300px',
    ], $atts, $tag);

    wp_enqueue_script('mpvc-scripts');
    wp_enqueue_style('mpvc-styles');

    $o = '<div id="mpvc-app">';
    $o .= '<filters-horizontal></filters-horizontal>';
    $o .= '<search-filters></search-filters>';
    $o .= '<property-listing-loadmore i-width="'.$mpvc_atts['width'].'" detail-url="'.$mpvc_atts['detail-url'].'" i-height="'.$mpvc_atts['height'].'"></property-listing-loadmore>';
    $o .= '</div>';
    return $o;
}

function mpvc_detail($atts = [], $content = null, $tag = '')
{
    $atts = array_change_key_case((array)$atts, CASE_LOWER);
    $mpvc_atts = shortcode_atts([
        'width' => '100%',
    ], $atts, $tag);

    wp_enqueue_script('mpvc-scripts');
    wp_enqueue_style('mpvc-styles');

    $o = '<div id="mpvc-app">';
    $o .= '<property-details></property-details>';
    $o .= '</div>';
    return $o;
}

function mpvc_shortcodes_init()
{
    add_shortcode('mpvc-listings', 'mpvc_listing');
    add_shortcode('mpvc-detail', 'mpvc_detail');
}

add_action('init', 'mpvc_shortcodes_init');
