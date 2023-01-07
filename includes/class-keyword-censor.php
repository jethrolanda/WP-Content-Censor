<?php
/**
 * Setup
 *
 * @since   1.0
 */

defined('ABSPATH') || exit;

/**
 * Main Class.
 */
final class Keyword_Censor
{

    /**
     * Version.
     */
    public $version = '1.0';

    /**
     * The single instance of the class.
     *
     * @since 1.0
     */
    protected static $_instance = null;

    /**
     * Main Instance.
     *
     * @since 1.0
     */
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->define_constants();
        $this->includes();
        $this->init_hooks();
    }

    private function define_constants()
    {

        $this->define('WPKC_ABSPATH', dirname(WPKC_PLUGIN_FILE) . '/');
        $this->define('WPKC_PLUGIN_BASENAME', plugin_basename(WPKC_PLUGIN_FILE));
        $this->define('WPKC_VERSION', $this->version);
        $this->define('WPKC_NOTICE_MIN_PHP_VERSION', '7.2');
        $this->define('WPKC_NOTICE_MIN_WP_VERSION', '5.2');

    }

    /**
     * Define constant if not already set.
     *
     * @param string      $name  Constant name.
     * @param string|bool $value Constant value.
     */
    private function define($name, $value)
    {
        if (!defined($name)) {
            define($name, $value);
        }
    }

    public function includes()
    {
        include_once WPKC_ABSPATH . 'includes/class-wpkc-scripts.php';
        include_once WPKC_ABSPATH . 'includes/class-wpkc-settings.php';
    }

    private function init_hooks()
    {

        // Load Plugin Text Domain
        add_action('plugins_loaded', array($this, 'load_plugin_text_domain'));

        // Activate / Deactivate plugin
        register_activation_hook(WPKC_PLUGIN_FILE, array($this, 'activated_plugin'));
        register_deactivation_hook(WPKC_PLUGIN_FILE, array($this, 'deactivated_plugin'));

    }

    /**
     * Load plugin text domain.
     *
     * @since 1.2.0
     * @since 1.3.0 Refactor codebase and move to its dedicated model.
     * @access public
     */
    public function load_plugin_text_domain()
    {

        load_plugin_textdomain('wp-keyword-censor', false, WPKC_ABSPATH . 'languages/');

    }

    /**
     * Ran when any plugin is activated.
     *
     * @since WooCommerce C
     * @param string $filename The filename of the activated plugin.
     */
    public function activated_plugin($filename)
    {

    }

    /**
     * Ran when any plugin is deactivated.
     *
     * @since WooCommerce C
     * @param string $filename The filename of the deactivated plugin.
     */
    public function deactivated_plugin($filename)
    {

    }
}
