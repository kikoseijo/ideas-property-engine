<?php

function mpvc_listing($atts = [], $content = null, $tag = '')
{
    // Property details page
    $pageId = getMpvcOptions( 'page_id' );
    if (!($pageId>0)) {
      echo __('HIPE - ERROR:<br />The plugin its not configured right, the <b>detail page ID</b> its not setup.<br />Enter your Wordpress control panel, go to <b>Settings > HIPE Agent > Configure search</b>.<br />Configure there where to send users when they want to see the property details page.', IPE_KEY);
      return;
    }

    $atts = array_change_key_case((array)$atts, CASE_LOWER);
    $mpvc_atts = shortcode_atts([
        'color' => getMpvcOptions( 'primary_color' ),
        'bg_color' => getMpvcOptions( 'box_bg_color' ),
        'img_width' => '100%',
        'img_height' => '300px',
        'detail_page' => get_permalink( $pageId ),
    ], $atts, $tag);

    wp_enqueue_script(IPE_KEY .'-manifest');
    wp_enqueue_script(IPE_KEY .'-vendors');
    wp_enqueue_script(IPE_KEY .'-scripts');
    wp_enqueue_style(IPE_KEY .'-styles');
    // wp_enqueue_style(IPE_KEY .'-elements');

    $o = '<div id="mpvc-app">';
    $o .= '<filters-horizontal tint-color="'.$mpvc_atts['color'].'" bg-color="'.$mpvc_atts['bg_color'].'"></filters-horizontal>';
    $o .= '<search-filters tint-color="'.$mpvc_atts['color'].'" bg-color="'.$mpvc_atts['bg_color'].'"></search-filters>';
    $o .= '<property-listing-loadmore';
    $o .= ' bg-color="'.$mpvc_atts['bg_color'].'"';
    $o .= ' tint-color="'.$mpvc_atts['color'].'"';
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
        'color' => getMpvcOptions( 'primary_color' ),
        'slider_height' => '500px',
    ], $atts, $tag);

    wp_enqueue_script(IPE_KEY .'-manifest');
    wp_enqueue_script(IPE_KEY .'-vendors');
    wp_enqueue_script(IPE_KEY .'-scripts');
    wp_enqueue_style(IPE_KEY .'-styles');

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
