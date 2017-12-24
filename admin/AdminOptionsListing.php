<?php

class AdminOptionsListing
{
    private static $PAGE = IPE_KEY .'-config-listing';
    private static $GROUP = 'mpvc_config_listing_group';
    private static $SECTION = 'mpvc_config_listing_admin';
    private static $KEY = 'mpvc_config_listing'; // HAND REPLACE---- FIelds ⚠️

    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    public function add_plugin_page()
    {
        add_submenu_page(
            IPE_KEY,
            'HIPE - Admin Listing configuration',
            'Configure search',
            'manage_options',
            self::$PAGE,
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        ?>
        <div class="wrap">
            <h1>HIPE - Configure search page display settings</h1>
            <hr />
            <form method="post" action="options.php">
            <?php
                settings_fields( self::$GROUP );
                do_settings_sections( self::$PAGE );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
        register_setting(
            self::$GROUP, // Option group
            self::$KEY, // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            self::$SECTION, // ID
            __('Property listing settings', IPE_KEY),
            array( $this, 'print_section_info' ), // Callback
            self::$PAGE // Page
        );

        add_settings_field(
            'page_id',
            __('Property details page', IPE_KEY),
            array( $this, 'page_id_callback' ), // Callback
            self::$PAGE,
            self::$SECTION
        );

        add_settings_field(
            'items_per_row',
            __('Properties per row', IPE_KEY),
            array( $this, 'items_per_row_callback' ), // Callback
            self::$PAGE,
            self::$SECTION
        );

        add_settings_field(
            'page_limit',
            __('Properties per page', IPE_KEY),
            array( $this, 'page_limit_callback' ), // Callback
            self::$PAGE,
            self::$SECTION
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();

        if( isset( $input['page_limit'] ) )
            $new_input['page_limit'] = absint( $input['page_limit'] );
        if( isset( $input['items_per_row'] ) )
            $new_input['items_per_row'] = absint( $input['items_per_row'] );
        if( isset( $input['page_id'] ) )
            $new_input['page_id'] = absint( $input['page_id'] );

        return $new_input;
    }


    function print_section_info()
    {
        echo __('Here you can configure how you want the listing page to be displayed.', IPE_KEY);
        echo '<br />&nbsp;<hr />';

    }

    function page_limit_callback()
    {
        ?>
    	<input type='number' name='mpvc_config_listing[page_limit]' value='<?php echo getMpvcOptions('page_limit');?>' min="3" max="20" style="width:65px;">
    	<p class="description">
    		How many properties are loaded when clicking the load more button. (20 Max)<br />
    		<b>TIP:</b> <code>$page_limit % $items_per_row = 0</code>.
    	</p>
    	<?php
    }

    function items_per_row_callback()
    {
        $value =  getMpvcOptions('items_per_row');
        ?>
    	<input type='number' name='mpvc_config_listing[items_per_row]' value='<?php echo $value?>' min="2" max="6" style="width:65px;">
    	<p class="description">
    		How many properties will show in the listing page.<br />ej: "2", "3", ..."6"<br />
    	</p>
    	<?php
    }

    function page_id_callback()
    {

        if ($pages = get_pages()) {
            echo '<select name="mpvc_config_listing[page_id]">';
            foreach ($pages as $page) {
                echo '<option value="'.$page->ID.'" '.selected($page->ID, getMpvcOptions('page_id')).'>'.$page->post_title.'</option>';
            }
            echo '</select>';
        }
        ?>
    		<p class="description">
    			Select the property detail page.<br />
    			Make sure you include the shortcode in its content <code style="color:red">[mpvc-detail]</code><br />
                <br />
                <b>TIP:</b><br />
    			You can overide this value using shortcode attributes.<br />
                ej.: <code>[mpvc-detail <span style="color:blue">detail_page="<b>/my-custom-page/?lang=en</b>"</span>]</code>
    		</p>
    	<?php
    }
}

$admin_options_listing = new AdminOptionsListing();
