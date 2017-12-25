<?php

class AdminOptionsStyle
{
    private static $PAGE = IPE_KEY .'-config-style';
    private static $GROUP = 'mpvc_config_style_group';
    private static $SECTION = 'mpvc_config_style_admin';
    private static $KEY = 'mpvc_config_style'; // HAND REPLACE---- FIelds ⚠️

    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    public function add_plugin_page()
    {
        add_submenu_page(
            IPE_KEY,
            'HIPE - Color styles configuration',
            'Configure style',
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
            <h1>HIPE - Style configuration</h1>
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
            __('Color styles configuration', IPE_KEY),
            array( $this, 'print_section_info' ), // Callback
            self::$PAGE // Page
        );

        add_settings_field(
            'primary_color',
            __('Primary color', IPE_KEY),
            array( $this, 'primary_color_callback'),
            self::$PAGE,
            self::$SECTION
        );

        add_settings_field(
            'box_bg_color',
            __('Search-Box background', IPE_KEY),
            array( $this, 'box_bg_color_callback'),
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

        if( isset( $input['primary_color'] ) )
                $new_input['primary_color'] = sanitize_text_field( $input['primary_color'] );
        if( isset( $input['box_bg_color'] ) )
                $new_input['box_bg_color'] = sanitize_text_field( $input['box_bg_color'] );
        // if( isset( $input['items_per_row'] ) )
        //     $new_input['items_per_row'] = absint( $input['items_per_row'] );
        // if( isset( $input['page_id'] ) )
        //     $new_input['page_id'] = absint( $input['page_id'] );

        return $new_input;
    }


    function print_section_info()
    {
        echo __('Here you can change some global stylings for the plugin, extra configurations can be done upon request with a personalized version and unlimited posibilities, dont hesitate to contact us for a free quote.', IPE_KEY);
        echo '<br />&nbsp;<hr />';
    }

    function primary_color_callback()
    {
        ?>
    	<input type='text' name='mpvc_config_style[primary_color]' value='<?php echo getMpvcOptions('primary_color');?>' class='cpa-color-picker'>
    	<?php
    }

    function box_bg_color_callback()
    {
        ?>
    	<input type='text' name='mpvc_config_style[box_bg_color]' value='<?php echo getMpvcOptions('box_bg_color');?>' class='cpa-color-picker'>
    	<?php
    }
}

$admin_options_style = new AdminOptionsStyle();
