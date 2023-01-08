<?php
/**
 * Main plugin bootstrap class
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

    /**
     * Define all constains here
     *
     * @since 1.0
     * @access public
     */
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

    /**
     * Include all plugin class
     *
     * @since 1.0
     * @access public
     */
    public function includes()
    {
        include_once WPKC_ABSPATH . 'includes/class-wpkc-scripts.php';
        include_once WPKC_ABSPATH . 'includes/class-wpkc-settings.php';
        include_once WPKC_ABSPATH . 'includes/class-wpkc-features.php';
    }

    /**
     * Initialize hooks
     *
     * @since 1.0
     * @access public
     */
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
     * @since 1.0
     * @access public
     */
    public function load_plugin_text_domain()
    {

        load_plugin_textdomain('wp-keyword-censor', false, WPKC_ABSPATH . 'languages/');

    }

    /**
     * Ran when any plugin is activated.
     *
     * @since 1.0
     * @param string $filename The filename of the activated plugin.
     */
    public function activated_plugin($filename)
    {

        if(get_option('wpkc_field_content_to_filter') == ""){
            update_option('wpkc_field_content_to_filter', 
                array(
                    'title' => 'on',
                    'content' => 'on',
                    'excerpt' => 'on',
                    'comments' => 'on'
                )
            );
        }
        
        if(get_option('wpkc_field_case_sensitive') == ""){
            update_option('wpkc_field_case_sensitive', array('sensitive' => 'on'));
        }
        
        if(get_option('wpkc_field_keyword_rendering') == ""){
            update_option('wpkc_field_keyword_rendering', 'replace_all');
        }

        if(get_option('wpkc_field_replace_keyword_with') == ""){
            update_option('wpkc_field_replace_keyword_with', '*');
        }

        if(get_option('wpkc_field_apply_changes_on_following_users') == ""){
            update_option('wpkc_field_apply_changes_on_following_users', array('logged_in' => 'on', 'logged_out' => 'on'));
        }
        
    }

    /**
     * Ran when any plugin is deactivated.
     *
     * @since 1.0
     * @param string $filename The filename of the deactivated plugin.
     */
    public function deactivated_plugin($filename)
    {

    }
}
