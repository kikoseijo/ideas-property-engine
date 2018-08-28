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

      global $provincesArr, $langsArray;

        return array(
            'pluginUrl' => IPE_BASE_URL,
            'gatewayUrl' => IPE_PROXY_URL,
            'provinces' => $provincesArr,
            'langs' => $langsArray,

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
            'filterTypes' => array(
                'for-sale' => __('Properties for sale', 'ideas-property-engine'),
                'short-term' => __('Vacational rentals', 'ideas-property-engine'),
                'long-term' => __('Long term rentals', 'ideas-property-engine'),
            ),
            'sortTypes' => array(
                'date_new_old' => __('Newest', 'ideas-property-engine'),
                'date_old_new' => __('Olders', 'ideas-property-engine'),
                'price_high_low' => __('Price (High to Low)', 'ideas-property-engine'),
                'price_low_high' => __('Price (Low to high)', 'ideas-property-engine'),
            ),
            'residential' => array(
                'apartment' => __('Apartment', 'ideas-property-engine'),
                'country-house' => __('Country House / Finca', 'ideas-property-engine'),
                'penthouse' => __('Penthouse', 'ideas-property-engine'),
                'plot' => __('Plot', 'ideas-property-engine'),
                'townhouse' => __('Townhouse', 'ideas-property-engine'),
                'villa' => __('Villa', 'ideas-property-engine'),
            ),
            'comercial' => array(
                'office' => __('Office', 'ideas-property-engine'),
                'business' => __('Business', 'ideas-property-engine'),
                'cafe' => __('Cafe', 'ideas-property-engine'),
                'bar' => __('Bar', 'ideas-property-engine'),
                'restaurant' => __('Restaurant', 'ideas-property-engine'),
                'retail' => __('Retail', 'ideas-property-engine'),
                'shop' => __('Shop', 'ideas-property-engine'),
                'hotel' => __('Hotel', 'ideas-property-engine'),
                'leisure' => __('Leisure Property', 'ideas-property-engine'),
                'industrial' => __('Industrial Property', 'ideas-property-engine'),
                'warehouse' => __('Warehouse', 'ideas-property-engine'),
                'commercial-land' => __('Landv', 'ideas-property-engine'),
                'development' => __('Development', 'ideas-property-engine'),
            ),
            'orientations' => array(
                'east' => __('East', 'ideas-property-engine'),
                'north' => __('North', 'ideas-property-engine'),
                'north-east' => __('NorthEast', 'ideas-property-engine'),
                'north-west' => __('North West', 'ideas-property-engine'),
                'south' => __('South', 'ideas-property-engine'),
                'south-east' => __('South East', 'ideas-property-engine'),
                'south-west' => __('SouthWest', 'ideas-property-engine'),
                'west' => __('West', 'ideas-property-engine'),
            ),
            'features' => array(
                '24-hour-security' => __('24 Hour Security', 'ideas-property-engine'),
                'air-conditioning' => __('Air Conditioning', 'ideas-property-engine'),
                'alarm-system' => __('Alarm System', 'ideas-property-engine'),
                'beachside' => __('Beachside', 'ideas-property-engine'),
                'close-to-park' => __('Close to Park', 'ideas-property-engine'),
                'close-to-schools' => __('Close to Schools', 'ideas-property-engine'),
                'double-glazing' => __('Double Glazing', 'ideas-property-engine'),
                'fireplace' => __('Fireplace', 'ideas-property-engine'),
                'frontline-beach' => __('Frontline Beach', 'ideas-property-engine'),
                'frontline-golf' => __('Frontline Golf', 'ideas-property-engine'),
                'gated-complex' => __('Gated Complex', 'ideas-property-engine'),
                'heated-swimming-pool' => __('Heated Swimming Pool', 'ideas-property-engine'),
                'heating' => __('Heating', 'ideas-property-engine'),
                'lift' => __('Lift', 'ideas-property-engine'),
                'modern' => __('Modern Style', 'ideas-property-engine'),
                'mountain-views' => __('Mountain Views', 'ideas-property-engine'),
                'newly-built' => __('Newly Built. Property never lived in.', 'ideas-property-engine'),
                'park-views' => __('Park Views', 'ideas-property-engine'),
                'pool-views' => __('Pool Views', 'ideas-property-engine'),
                'private-garden' => __('Private Garden', 'ideas-property-engine'),
                'renovation-required' => __('Renovation Required', 'ideas-property-engine'),
                'rustic' => __('Rustic Style', 'ideas-property-engine'),
                'sauna' => __('Sauna', 'ideas-property-engine'),
                'sea-views' => __('Sea Views', 'ideas-property-engine'),
                'solar-power' => __('Solar Power', 'ideas-property-engine'),
                'storage-room' => __('Storage Room', 'ideas-property-engine'),
                'swimming-pool' => __('Swimming Pool', 'ideas-property-engine'),
                'tennis-paddle-court' => __('Tennis and/or Paddle Court', 'ideas-property-engine'),
                'underfloor-heating' => __('Underfloor Heating', 'ideas-property-engine'),
                'golf-views' => __('Golf views', 'ideas-property-engine'),
                'gym' => __('Gimnasium', 'ideas-property-engine'),
                'walking-distance-to-amenities' => __('Walking Distance to Amenities', 'ideas-property-engine'),
                'walking-distance-to-beach' => __('Walking Distance to the Beach', 'ideas-property-engine'),

            ),
            // Translations UI strings
            'trans' => array(
                'propertyTitle' => __('%property_type% in %city% %sale_type%', 'ideas-property-engine'),
                'resultsResume' => __('Viewing <strong>%viewing%</strong> properties, out of <strong>%total%</strong> properties found.', 'ideas-property-engine'),
                'viewingCacheText' => __('Loading properties from caché', 'ideas-property-engine'),
                'highSeasson' => __('High', 'ideas-property-engine'),
                'lowSeasson' => __('Low', 'ideas-property-engine'),
                'forSale' => __('for sale', 'ideas-property-engine'),
                'forRent' => __('for rent', 'ideas-property-engine'),
                'symbol' => __('€', 'ideas-property-engine'),
                'titleLocationSearch' => __('Search by location', 'ideas-property-engine'),
                'placeholderLocationSearch' => __('start typing...', 'ideas-property-engine'),
                'titleListingTypes' => __('Listing type', 'ideas-property-engine'),
                'placeholderListingTypes' => __('Select type', 'ideas-property-engine'),
                'titlePropertyType' => __('Property type', 'ideas-property-engine'),
                'placeholderPropertyType' => __('Select property type', 'ideas-property-engine'),
                'nBeds' => __('N. Bedrooms', 'ideas-property-engine'),
                'sBeds' => __('Beds', 'ideas-property-engine'),
                'nBaths' => __('N. Bathrooms', 'ideas-property-engine'),
                'sBaths' => __('Baths', 'ideas-property-engine'),
                'nSleeps' => __('Sleeps', 'ideas-property-engine'),
                'plotSize' => __('Plot size', 'ideas-property-engine'),
                'plot' => __('Plot', 'ideas-property-engine'),
                'buildSize' => __('Build size', 'ideas-property-engine'),
                'build' => __('Build', 'ideas-property-engine'),
                'titlePropDescs' => __('Property descriptions', 'ideas-property-engine'),
                'titlePropDesc' => __('Property description', 'ideas-property-engine'),
                'titlePropertyFeatures' => __('Property features', 'ideas-property-engine'),
                'sortBy' => __('Sort by', 'ideas-property-engine'),
                'readMore' => __('read more', 'ideas-property-engine'),
                'loadMoreButton' => __('Load more properties', 'ideas-property-engine'),
                'loadingPropertiesText' => __('Updating to the latest properties, please wait....', 'ideas-property-engine'),
                'loadingPropertyText' => __('Loading property details, please wait....', 'ideas-property-engine'),
                'propertyDetailErrorTitle' => __('Property ID error', 'ideas-property-engine'),
                'propertyDetailErrorText' => __('Sorry this property could have been deleted, contact us if you think this is an error.', 'ideas-property-engine'),
                'apiConnectionErrorTitle' => __('API - Connection ERROR', 'ideas-property-engine'),
                'additionalInformation' => __('Additional information', 'ideas-property-engine'),
                'price' => __('Price', 'ideas-property-engine'),
                'propertyRef' => __('Property reference', 'ideas-property-engine'),
                'propertyForSale' => __('Property for sale', 'ideas-property-engine'),
                'availableLongText' => __('Property available for Long term rental', 'ideas-property-engine'),
                'availableShortText' => __('Property available for Short term rental', 'ideas-property-engine'),
                'numberBeds' => __('Number of bedrooms', 'ideas-property-engine'),
                'nSleepsText' => __('Number of sleeps', 'ideas-property-engine'),
                'nBathsText' => __('Number of bathrooms', 'ideas-property-engine'),
                'energyRating' => __('Energy rating', 'ideas-property-engine'),
                'floorNumber' => __('Floor number', 'ideas-property-engine'),
                'propertyLocation' => __('Property location', 'ideas-property-engine'),
                'location' => __('Location', 'ideas-property-engine'),
                'orientationText' => __('Property orientation', 'ideas-property-engine'),
                'parkingSpaces' => __('Parking spaces', 'ideas-property-engine'),
                'buildSizeDesc' => __('Build size in square meters', 'ideas-property-engine'),
                'plotSizeDesc' => __('Plot size in square meters', 'ideas-property-engine'),
                'terrazeSize' => __('Terraze size in square meters', 'ideas-property-engine'),
                'lastUpdate' => __('Last updated', 'ideas-property-engine'),
                'updated' => __('Updated', 'ideas-property-engine'),
                // 'xxxxxxx' => __('xxxxxxxx', 'ideas-property-engine'),
            ),
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
