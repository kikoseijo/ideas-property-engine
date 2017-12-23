<?php

/**
 * Usage
 *
 * Dentro del shortcode
 * wp_enqueue_script( 'mpvc-script' );
 * wp_enqueue_style( 'mpvc-style' );
 */

class RegisterScripts
{
    public $detailPageUrl;
    public $pluginOptions;

    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'register_plugin_styles']);

        // add_filter('rewrite_rules_array', [$this, 'insert_rewrite_rules']);
        add_filter('query_vars', [$this, 'insert_query_vars']);
        add_action('wp_head', [$this, 'pw_global_js_vars'] );

        $pluginDefaults = array(
            'province' => 'MA',
            'mpvc_field_api_version' => '2',
            'page_limit' => '9',
            'items_per_row' => '3',
            'mpvc_field_api_url' => 'api.milenioplus.com'
        );
        $this->pluginOptions = wp_parse_args(get_option( 'mpvc_settings' ), $pluginDefaults);

        if ($options['page_id']>0) {
            $this->detailPageUrl = get_permalink( $this->pluginOptions['page_id'] );
        }
        // add_action('wp_loaded', [$this, 'flush_rules']);
    }

    /**
     * Register and enqueue style sheet.
     */
    public function register_plugin_styles()
    {
        // <link href="https://use.fontawesome.com/releases/v5.0.2/css/all.css" rel="stylesheet">
        wp_register_style('mpvc-styles', plugins_url('milenio-vue-cli/dist/css/theme.css'), [], MPVC_VERSION);
        // wp_register_style('mpvc-elements', 'https://unpkg.com/element-ui@2.0.8/lib/theme-chalk/index.css', [], MPVC_VERSION);
        wp_register_script('mpvc-manifest', plugins_url('milenio-vue-cli/dist/js/manifest.js'), [], MPVC_VERSION);
        wp_register_script('mpvc-vendors', plugins_url('milenio-vue-cli/dist/js/vendor.js'), [], MPVC_VERSION);
        wp_register_script('mpvc-scripts', plugins_url('milenio-vue-cli/dist/js/main.js'), [], MPVC_VERSION, true);
    }

    /**
     * @param $rules
     * @return mixed
     */
    public function insert_rewrite_rules($rules)
    {
        $newrules = [];
        // RewriteRule ^property-details/(.*)?/$ property-details/?propertyId=$1
        $newrules['property-details/(\d*)$'] = 'property-details/?propertyId=$1';
        return $newrules + $rules;
    }

    public function flush_rules()
    {
        $rules = get_option('rewrite_rules');

        if (!isset($rules['property-details/(\d*)$'])) {
            global $wp_rewrite;
            $wp_rewrite->flush_rules();
        }
    }

    /**
     * @param $vars
     * @return mixed
     */
    public function insert_query_vars($vars)
    {
        array_push($vars, 'propertyId');
        return $vars;
    }

    public function pw_global_js_vars() {
      global $filterTypes, $sortTypes, $propertyTypesResidential, $transArray,
              $propertyTypesComercial, $orientationArr, $langArr,
              $featuresArr, $provincesArr, $langsArray;

        $settings = array(
            'pluginUrl' => MPVC_BASE_URL,
            'gatewayUrl' => MPVC_PROXY_URL,
            'detailPageId' => $this->pluginOptions['page_id'],
            'searchProvince' => $this->pluginOptions['province'],
            'itemsPerRow' => $this->pluginOptions['items_per_row'],
            'pageLimit' => $this->pluginOptions['page_limit'],
            'filterTypes' => $filterTypes,
            'sortTypes' => $sortTypes,
            'residential' => $propertyTypesResidential,
            'comercial' => $propertyTypesComercial,
            'orientations' => $orientationArr,
            'langs' => $langsArray,
            'features' => $featuresArr,
            'provinces' => $provincesArr,
            'trans' => $transArray,
        );

    	echo '<script type="text/javascript">
    	/* <![CDATA[ */
    	window.MPVC = '.json_encode($settings).';
    	/* ]]> */
    	</script>';
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
