<?php
/**
 * Plugin Name: WP Content Censor
 * Description: This plugins censors words or phrase in wordpress contents.
 * Version: 1.0
 * Author: Jethro Landa
 * Author URI: https://jethrolanda.com/
 * Text Domain: wp-plugin-template
 * Domain Path: /languages/
 * Requires at least: 5.8
 * Requires PHP: 7.2
 *
 * @package WooCommerce
 */

defined('ABSPATH') || exit;

function custom_menu()
{
    add_menu_page(
        'Censor Keywords Settings',
        'Censor Keywords',
        'edit_posts',
        'censor_keywords_settings',
        'content_sensor_settings_page',
        'dashicons-media-spreadsheet'
    );
}

add_action('admin_menu', 'custom_menu', 10);

function content_sensor_settings_page()
{
    include_once __DIR__ . '/views/wpcc-views-settings.php';
}

function wp_content_censor()
{

}

// Global for backwards compatibility.
$GLOBALS['wp_content_censor'] = wp_content_censor();
