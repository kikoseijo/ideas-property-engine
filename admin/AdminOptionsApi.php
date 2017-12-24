<?php

class AdminOptionsApi
{
    private static $PAGE = IPE_KEY .'-config-api';
    private static $GROUP = 'mpvc_config_api_group';
    private static $SECTION = 'mpvc_config_api_admin';
    private static $KEY = 'mpvc_config_api'; // HAND REPLACE---- FIelds ⚠️

    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    public function add_plugin_page()
    {
        add_submenu_page(
            IPE_KEY,
            'HIPE - API configuration',
            'API Credentials',
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
            <h1>HIPE - Plugin settings</h1>
    		<hr>
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
            __('API Credential configuration', IPE_KEY),
            array( $this, 'print_section_info' ), // Callback
            self::$PAGE // Page
        );

        add_settings_field(
            'api_user',
            __('API user', IPE_KEY),
            array( $this, 'api_user_callback'),
            self::$PAGE,
            self::$SECTION
        );

        add_settings_field(
            'api_pass',
            __('API password', IPE_KEY),
            array( $this, 'api_pass_callback'),
            self::$PAGE,
            self::$SECTION
        );

        add_settings_field(
            'api_url',
            __('API url', IPE_KEY),
            array( $this, 'api_url_callback'),
            self::$PAGE,
            self::$SECTION
        );

        add_settings_field(
            'api_version',
            __('Api version', IPE_KEY),
            array( $this, 'api_version_callback'),
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

        if( isset( $input['api_version'] ) )
            $new_input['api_version'] = absint( $input['api_version'] );
        if( isset( $input['api_user'] ) )
            $new_input['api_user'] = sanitize_text_field( $input['api_user'] );
        if( isset( $input['api_pass'] ) )
            $new_input['api_pass'] = sanitize_text_field( $input['api_pass'] );
        if( isset( $input['api_url'] ) )
            $new_input['api_url'] = sanitize_text_field( $input['api_url'] );
        return $new_input;
    }


    function print_section_info()
    {
        echo __('You must configure the information here in order to connect the plugin with Milenio Plus API database.<br />API credentials are provided upon request from <a href="https://www.milenioplus.com?ref=mpvc-wordpress-plugin" target="_blank">Milenio Plus</a>.', IPE_KEY);
        echo '<br />&nbsp;<hr />';

    }


    function api_user_callback()
    {
        ?>
    	<input type='text' name='mpvc_config_api[api_user]' value='<?php echo getMpvcOptions('api_user');?>'>
    	<?php
    }

    function api_pass_callback()
    {
        ?>
    	<input type='password' name='mpvc_config_api[api_pass]' value='<?php echo getMpvcOptions('api_pass');?>'>
    	<?php
    }

    function api_url_callback()
    {
        ?>
    	<input type='text' class='regular-text' name='mpvc_config_api[api_url]' value='<?php echo getMpvcOptions('api_url');?>'>
    	<p class="description">Dont include schema, should be in the format of: <em><strong>api.milenioplus.com</strong></em></p>
    	<?php
    }

    function api_version_callback()
    {
        $value = getMpvcOptions('api_version');
        ?>
    		<select name='mpvc_config_api[api_version]'>
    			<option value='1' <?php selected($value, 1);?>>Api version 1</option>
    			<option value='2' <?php selected($value, 2);?>>Api version 2</option>
    		</select>

    	<?php
    }
}

$admin_options_api = new AdminOptionsApi();
