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

    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'register_plugin_styles']);

        // add_filter('rewrite_rules_array', [$this, 'insert_rewrite_rules']);
        add_filter('query_vars', [$this, 'insert_query_vars']);
        add_action('wp_head', [$this, 'pw_global_js_vars'] );
        // add_action('wp_loaded', [$this, 'flush_rules']);
    }

    /**
     * Register and enqueue style sheet.
     */
    public function register_plugin_styles()
    {
        wp_register_style('mpvc-styles', plugins_url('milenio-vue-cli/dist/css/theme.css'), [], MPVC_VERSION);
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
    	echo '<script type="text/javascript">
    	/* <![CDATA[ */
    	var MPVC = {"gatewayUrl":"'.MPVC_PROXY_URL.'"};
    	/* ]]> */
    	</script>';
    }


}

new RegisterScripts();


function custom_rewrite_basic() {
  add_rewrite_rule('^property-details/([^/]*)/?', 'property-details/?propertyId=$matches[1]', 'top');
}
add_action('init', 'custom_rewrite_basic', 10, 0);

// flush_rules() if our rules are not yet included

// Adding a new rule

// Adding the id var so that WP recognizes it
