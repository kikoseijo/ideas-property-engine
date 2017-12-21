<?php

/**
 * Plugin Settings
 * It lets you define settings pages, sections within those pages and fields within the sections.
 *
 *
 * Example:
 * $setting = get_option('mpvc_setting_name');
 */

/**
 * @internal never define functions inside callbacks.
 * these functions could be run multiple times; this would result in a fatal error.
 */

/**
 * custom option and settings
 */
function mpvc_settings_init()
{
    // register a new setting for "mpvc" page
    register_setting('mpvc', 'mpvc_options');

    // register a new section in the "mpvc" page
    add_settings_section(
        'mpvc_section_developers',
        __('The Matrix has you.', 'mpvc'),
        'mpvc_section_developers_cb',
        'mpvc'
    );

    // register a new field in the "mpvc_section_developers" section, inside the "mpvc" page
    add_settings_field(
        'mpvc_field_pill', // as of WP 4.6 this value is used only internally
        // use $args' label_for to populate the id inside the callback
        __('Pill', 'mpvc'),
        'mpvc_field_pill_cb',
        'mpvc',
        'mpvc_section_developers',
        [
            'label_for'        => 'mpvc_field_pill',
            'class'            => 'mpvc_row',
            'mpvc_custom_data' => 'custom',
        ]
    );
}

/**
 * register our mpvc_settings_init to the admin_init action hook
 */
add_action('admin_init', 'mpvc_settings_init');

/**
 * custom option and settings:
 * callback functions
 */

// developers section cb

// section callbacks can accept an $args parameter, which is an array.
// $args have the following keys defined: title, id, callback.
// the values are defined at the add_settings_section() function.
function mpvc_section_developers_cb($args)
{
    ?>
  <p id="<?php echo esc_attr($args['id']);?>"><?php esc_html_e('Follow the white rabbit.', 'mpvc');?></p>
  <?php
}

// pill field cb

// field callbacks can accept an $args parameter, which is an array.
// $args is defined at the add_settings_field() function.
// wordpress has magic interaction with the following keys: label_for, class.
// the "label_for" key value is used for the "for" attribute of the <label>.
// the "class" key value is used for the "class" attribute of the <tr> containing the field.
// you can add custom key value pairs to be used inside your callbacks.
/**
 * @param $args
 */
function mpvc_field_pill_cb($args)
{
    // get the value of the setting we've registered with register_setting()
    $options = get_option('mpvc_options');
    // output the field
    ?>
  <select id="<?php echo esc_attr($args['label_for']);?>"
  data-custom="<?php echo esc_attr($args['mpvc_custom_data']);?>"
  name="mpvc_options[<?php echo esc_attr($args['label_for']);?>]"
  >
  <option value="red" <?php echo isset($options[$args['label_for']]) ? (selected($options[$args['label_for']], 'red', false)) : ('');?>>
  <?php esc_html_e('red pill', 'mpvc');?>
  </option>
  <option value="blue" <?php echo isset($options[$args['label_for']]) ? (selected($options[$args['label_for']], 'blue', false)) : ('');?>>
  <?php esc_html_e('blue pill', 'mpvc');?>
  </option>
  </select>
  <p class="description">
  <?php esc_html_e('You take the blue pill and the story ends. You wake in your bed and you believe whatever you want to believe.', 'mpvc');?>
  </p>
  <p class="description">
  <?php esc_html_e('You take the red pill and you stay in Wonderland and I show you how deep the rabbit-hole goes.', 'mpvc');?>
  </p>
  <?php
}



/**
 * top level menu:
 * callback functions
 */
function mpvc_options_page_html()
{
    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }

    // add error/update messages

    // check if the user have submitted the settings
    // wordpress will add the "settings-updated" $_GET parameter to the url
    if (isset($_GET['settings-updated'])) {
        // add settings saved message with the class of "updated"
        add_settings_error('mpvc_messages', 'mpvc_message', __('Settings Saved', 'mpvc'), 'updated');
    }

    // show error/update messages
    settings_errors('mpvc_messages');
    ?>
  <div class="wrap">
  <h1><?php echo esc_html(get_admin_page_title());?></h1>
  <form action="options.php" method="post">
  <?php
// output security fields for the registered setting "mpvc"
    settings_fields('mpvc');
    // output setting sections and their fields
    // (sections are registered for "mpvc", each field is registered to a specific section)
    do_settings_sections('mpvc');
    // output save settings button
    submit_button('Save Settings');
    ?>
  </form>
  </div>
  <?php
}
