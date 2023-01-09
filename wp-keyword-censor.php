<?php
/**
 * Plugin Name: WP Keyword Censor
 * Description: This plugin censors unwanted words or phrase in wordpress contents.
 * Version: 1.0
 * Author: Jethro Landa
 * Author URI: https://jethrolanda.com/
 * Text Domain: wp-keyword-censor
 * Domain Path: /languages/
 * Requires at least: 5.8
 * Requires PHP: 7.2
 */

defined('ABSPATH') || exit;

if (!defined('WPKC_PLUGIN_FILE')) {
    define('WPKC_PLUGIN_FILE', __FILE__);
}

// Include the main Keyword Censor class.
if (!class_exists('WPKC_Bootstrap', false)) {
    include_once dirname(WPKC_PLUGIN_FILE) . '/includes/class-wpkc-bootstrap.php';
}

function wpkc()
{
    return WPKC_Bootstrap::instance();
}

// Global for backwards compatibility.
$GLOBALS['wpkc'] = wpkc();
