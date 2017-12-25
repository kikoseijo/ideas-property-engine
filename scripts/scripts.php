<?php

/**
 * Usage
 *
 * Dentro del shortcode
 * wp_enqueue_script( IPE_KEY .'-script' );
 * wp_enqueue_style( IPE_KEY .'-style' );
 */

class RegisterScripts
{
    public $detailPageUrl;
    public $pluginOptions;

    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'register_plugin_styles']);
        add_action('admin_enqueue_scripts', [$this, 'register_plugin_styles']);
        add_filter('query_vars', [$this, 'insert_query_vars']);

        $apiOptions = get_option( 'mpvc_config_api', []);
        $styleOptions = get_option( 'mpvc_config_style', []) ;
        $listingOptions = get_option( 'mpvc_config_listing', []);

        $base_options = array_merge($apiOptions, $styleOptions, $listingOptions);

        $pluginDefaults = array(
            'search_provinces' => 'MA',
            'api_version' => '2',
            'page_limit' => '9',
            'with_shared' => true,
            'items_per_row' => '3',
            'primary_color' => '#074997',
            'box_bg_color' => '#f9f9f9',
            'api_url' => 'api.milenioplus.com'
        );
        $this->pluginOptions = wp_parse_args($base_options, $pluginDefaults);

        if ($options['page_id']>0) {
            $this->detailPageUrl = get_permalink( $this->pluginOptions['page_id'] );
        }
    }

    /**
     * Register and enqueue style sheet.
     */
    public function register_plugin_styles()
    {
        wp_register_style(IPE_KEY .'-styles', plugins_url(IPE_KEY .'/dist/css/theme.css'), [], IPE_VERSION);
        wp_register_script(IPE_KEY .'-manifest', plugins_url(IPE_KEY .'/dist/js/manifest.js'), [], IPE_VERSION, true);
        wp_register_script(IPE_KEY .'-vendors', plugins_url(IPE_KEY .'/dist/js/vendor.js'), [], IPE_VERSION, true);
        wp_register_script(IPE_KEY .'-scripts', plugins_url(IPE_KEY .'/dist/js/main.js'), [], IPE_VERSION, true);
        wp_localize_script(IPE_KEY .'-scripts', 'HIPE', $this->pluginJsArrayData() );

        if( is_admin() ) {
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_script(IPE_KEY .'-admin-scripts', plugins_url(IPE_KEY .'/admin/js-mpvc.js'), ['wp-color-picker'], false, true);
        }
    }

    public function insert_query_vars($vars)
    {
        array_push($vars, 'propertyId');
        return $vars;
    }

    public function pluginJsArrayData()
    {

      global $filterTypes, $sortTypes, $propertyTypesResidential, $transArray,
              $propertyTypesComercial, $orientationArr, $langArr,
              $featuresArr, $provincesArr, $langsArray;

        return array(
            'pluginUrl' => IPE_BASE_URL,
            'gatewayUrl' => IPE_PROXY_URL,
            // Settings options
            'searchProvinces' => $this->pluginOptions['search_provinces'],
            'withShared' => $this->pluginOptions['with_shared'],
            'detailPageId' => $this->pluginOptions['page_id'],
            'itemsPerRow' => $this->pluginOptions['items_per_row'],
            'pageLimit' => $this->pluginOptions['page_limit'],
            'styles' => array(
                'primaryColor' => $this->pluginOptions['primary_color'],
                'boxBgColor' => $this->pluginOptions['box_bg_color'],
            ),
            // Types & Scripts localization
            'filterTypes' => $filterTypes,
            'sortTypes' => $sortTypes,
            'residential' => $propertyTypesResidential,
            'comercial' => $propertyTypesComercial,
            'orientations' => $orientationArr,
            'langs' => $langsArray,
            'features' => $featuresArr,
            'provinces' => $provincesArr,
            // Translations UI strings
            'trans' => $transArray,
        );
    }
}

$mpvc_scripts = new RegisterScripts();

/* Plugin helper function */
if (!function_exists('getMpvcOptions'))
{
    function getMpvcOptions($key){
        global $mpvc_scripts;
        return array_key_exists($key, $mpvc_scripts->pluginOptions) ? $mpvc_scripts->pluginOptions[$key] : null;
    }
}
