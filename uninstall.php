<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit();
}

if (get_option("wpkc_settings_clean_plugin_options_on_uninstall") == 'yes') {

    global $wpdb;

    // DELETES ALL OPTIONS IN THE DB
    $wpdb->query(
        "DELETE FROM $wpdb->options
       WHERE option_name LIKE 'wpkc_%'
      "
    );

}
