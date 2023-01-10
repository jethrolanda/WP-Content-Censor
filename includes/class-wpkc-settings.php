<?php
/**
 * Plugins custom settings page that adheres to wp standard
 * see: https://developer.wordpress.org/plugins/settings/custom-settings-page/
 *
 * @since   1.0
 */

defined('ABSPATH') || exit;

/**
 * WP Settings Class.
 */
class WPKC_Settings
{

    /**
     * The single instance of the class.
     *
     * @var WooCommerce
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
     * 
     * @since 1.0
     */
    public function __construct()
    {

        // Add custom menu to wp admin menu
        add_action('admin_menu', array($this, 'custom_menu'), 10);

        // Add settings to the add menu
        add_action('admin_init', array($this, 'wpkc_settings_init'));

    }

    /**
     * Add custom wp admin menu.
     * 
     * @since 1.0
     */
    public function custom_menu()
    {
        add_menu_page(
            __('Keyword Censor Settings', 'wp-keyword-censor'),
            __('Keyword Censor', 'wp-keyword-censor'),
            'edit_posts',
            'keyword_censor_settings',
            array($this, 'keyword_censor_settings_page'),
            'dashicons-media-spreadsheet'
        );
    }

    /**
     * Display content to the new added custom wp admin menu.
     * 
     * @since 1.0
     */
    public function keyword_censor_settings_page()
    {

        // check user capabilities
        if (!current_user_can('manage_options')) {
            return;
        }

        // add error/update messages

        // check if the user have submitted the settings
        // WordPress will add the "settings-updated" $_GET parameter to the url
        if (isset($_GET['settings-updated'])) {
            // add settings saved message with the class of "updated"
            add_settings_error('wpkc_messages', 'wpkc_message', __('Settings Saved', 'wp-keyword-censor'), 'updated');
        }

        // show error/update messages
        settings_errors('wpkc_messages');?>

        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form action="options.php" method="post">
                <?php
                    // output security fields for the registered setting "keyword_censor_settings"
                    settings_fields('keyword_censor_settings');
                    // output setting sections and their fields
                    // (sections are registered for "keyword_censor_settings", each field is registered to a specific section)
                    do_settings_sections('keyword_censor_settings');
                    // output save settings button
                    submit_button(__('Save Settings', 'wp-keyword-censor'));
                ?>
            </form>
        </div><?php
    }

    /**
     * Initialize settings page.
     * 
     * @since 1.0
     */
    public function wpkc_settings_init()
    {
        
        // Register a new section in the "keyword_censor_settings" page.
        add_settings_section(
            'wpkc_settings_section_settings',
            '',
            '',
            'keyword_censor_settings'
        );

        register_setting('keyword_censor_settings', 'wpkc_field_keywords');
        add_settings_field(
            'wpkc_field_keywords',
            __('Keywords', 'wp-keyword-censor'),
            array($this, 'keyword_field_cb'),
            'keyword_censor_settings',
            'wpkc_settings_section_settings',
        );

        register_setting('keyword_censor_settings', 'wpkc_field_content_to_filter');
        add_settings_field(
            'wpkc_field_content_to_filter',
            __('Content to filter', 'wp-keyword-censor'),
            array($this, 'content_to_filter_field_cb'),
            'keyword_censor_settings',
            'wpkc_settings_section_settings'
        );

        register_setting('keyword_censor_settings', 'wpkc_field_case_sensitive');
        add_settings_field(
            'wpkc_field_case_sensitive', 
            __('Case-sensitive', 'wp-keyword-censor'),
            array($this, 'case_sensitive_field_cb'),
            'keyword_censor_settings',
            'wpkc_settings_section_settings'
        );

        
        register_setting('keyword_censor_settings', 'keyword_search_field_cb');
        add_settings_field(
            'keyword_search_field_cb', 
            __('Keyword search', 'wp-keyword-censor'),
            array($this, 'keyword_search_field_cb'),
            'keyword_censor_settings',
            'wpkc_settings_section_settings'
        );

        register_setting('keyword_censor_settings', 'wpkc_field_keyword_rendering');
        add_settings_field(
            'wpkc_field_keyword_rendering', 
            __('Keyword rendering', 'wp-keyword-censor'),
            array($this, 'keyword_rendering_field_cb'),
            'keyword_censor_settings',
            'wpkc_settings_section_settings'
        );

        register_setting('keyword_censor_settings', 'wpkc_field_replace_keyword_with', array($this, 'sanitize'));
        add_settings_field(
            'wpkc_field_replace_keyword_with', 
            __('Replace keyword with', 'wp-keyword-censor'),
            array($this, 'replace_keyword_with_field_cb'),
            'keyword_censor_settings',
            'wpkc_settings_section_settings'
        );

        register_setting('keyword_censor_settings', 'wpkc_field_apply_changes_on_following_users');
        add_settings_field(
            'wpkc_field_apply_changes_on_following_users', 
            __('Apply the changes on the following users', 'wp-keyword-censor'),
            array($this, 'apply_changes_on_following_users_field_cb'),
            'keyword_censor_settings',
            'wpkc_settings_section_settings'
        );

        register_setting('keyword_censor_settings', 'wpkc_field_delete_options');
        add_settings_field(
            'wpkc_field_delete_options', 
            __('Delete options on uninstallation', 'wp-keyword-censor'),
            array($this, 'delete_options_field_cb'),
            'keyword_censor_settings',
            'wpkc_settings_section_settings'
        );

    }
    
    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     * @since 1.0
     */
    public function sanitize($input)
    {
        
        return sanitize_text_field($input);

    }

    /**
     * Display keyword field.
     * 
     * @param array $args Field arguments
     * @since 1.0
     */
    public function keyword_field_cb($args)
    {
        
        // Get the value of the setting we've registered with register_setting()
        $option = get_option('wpkc_field_keywords'); ?>

        <textarea name="wpkc_field_keywords" id="" cols="100" rows="10" placeholder="<?php echo __('Ex: Pussy | Dog', 'wp-keyword-censor'); ?>" ><?php echo isset($option) && !empty($option) ? $option : ''; ?></textarea>
        <p class="description"><?php echo __('Note: This will only censor words that is saved in the database and will not include the hard coded text in theme or plugin files.', 'wp-keyword-censor'); ?></p><?php

    }

    /**
     * Display content to filter field
     * 
     * @param array $args Field arguments
     * @since 1.0
     */
    public function content_to_filter_field_cb($args)
    {
        
        $option     = get_option('wpkc_field_content_to_filter'); 
        $title      = isset($option['title']) && !empty($option['title']) ? $option['title'] : '';
        $content    = isset($option['content']) && !empty($option['content']) ? $option['content'] : '';
        $excerpt    = isset($option['excerpt']) && !empty($option['excerpt']) ? $option['excerpt'] : '';
        $comments   = isset($option['comments']) && !empty($option['comments']) ? $option['comments'] : '';?>

        <fieldset>
            <label for="wpkc_field_content_to_filter_title">
            <input name="wpkc_field_content_to_filter[title]" id="wpkc_field_content_to_filter_title" type="checkbox" <?php checked($title, 'on', true); ?>> <?php echo __('Title', 'wp-keyword-censor'); ?>
            </label>
        </fieldset>
        <fieldset>
            <label for="wpkc_field_content_to_filter_content">
            <input name="wpkc_field_content_to_filter[content]" id="wpkc_field_content_to_filter_content" type="checkbox" <?php checked($content, 'on', true); ?>> <?php echo __('Content', 'wp-keyword-censor'); ?>
            </label>
        </fieldset>
        <fieldset>
            <label for="wpkc_field_content_to_filter_excerpt">
            <input name="wpkc_field_content_to_filter[excerpt]" id="wpkc_field_content_to_filter_excerpt" type="checkbox" <?php checked($excerpt, 'on', true); ?>> <?php echo __('Excerpt', 'wp-keyword-censor'); ?>
            </label>
        </fieldset>
        <fieldset>
            <label for="wpkc_field_content_to_filter_comments">
            <input name="wpkc_field_content_to_filter[comments]" id="wpkc_field_content_to_filter_comments" type="checkbox" <?php checked($comments, 'on', true); ?>> <?php echo __('Comments', 'wp-keyword-censor'); ?>
            </label>
        </fieldset><?php

    }

    /**
     * Display case-sensitive field
     * 
     * @param array $args Field arguments
     * @since 1.0
     */
    public function case_sensitive_field_cb($args)
    {
        // Get the value of the setting we've registered with register_setting()
        $option     = get_option('wpkc_field_case_sensitive'); 
        $sensitive  = isset($option['sensitive']) && !empty($option['sensitive']) ? $option['sensitive'] : ''; ?>

        <fieldset>
            <label for="wpkc_field_case_sensitive">
                <input name="wpkc_field_case_sensitive[sensitive]" id="wpkc_field_case_sensitive" type="checkbox" <?php checked($sensitive, 'on', true); ?>> <?php echo __('Restrictly match the keyword(s) casing.', 'wp-keyword-censor'); ?>
            </label>
        </fieldset><?php

    }

    /**
     * Display keyword rendering field
     * 
     * @param array $args Field arguments
     * @since 1.0
     */
    public function keyword_search_field_cb($args)
    {
        
        $option = get_option('keyword_search_field_cb'); ?>

        <fieldset>
            <label>
                <input type="radio" name="keyword_search_field_cb" value="part_keyword" <?php checked($option, 'part_keyword', true); ?>> <?php echo __('Censor part of word or phrase (ex. Keyword: come, Result: Wel**** to wordpress.)', 'wp-keyword-censor'); ?>
            </label><br>
            <label>
                <input type="radio" name="keyword_search_field_cb" value="exact_keyword" <?php checked($option, 'exact_keyword', true); ?>> <?php echo __('Censor exact word or phrase (ex. Keyword: come, Result: Welcome to wordpress.). Notice that it didn\'t censor come, this option will only censor if its the exact word or phrase.', 'wp-keyword-censor'); ?>
            </label>
        </fieldset><?php

    }

    /**
     * Display keyword rendering field
     * 
     * @param array $args Field arguments
     * @since 1.0
     */
    public function keyword_rendering_field_cb($args)
    {
        
        $option = get_option('wpkc_field_keyword_rendering'); ?>

        <fieldset>
            <label>
                <input type="radio" name="wpkc_field_keyword_rendering" value="replace_all" <?php checked($option, 'replace_all', true); ?>> <?php echo __('Replace all words (ex. Cloudy = ******)', 'wp-keyword-censor'); ?>
            </label><br>
            <label>
                <input type="radio" name="wpkc_field_keyword_rendering" value="exclude_first_letter" <?php checked($option, 'exclude_first_letter', true); ?>> <?php echo __('Exclude first letter (ex. Cloudy = C*****)', 'wp-keyword-censor'); ?>
            </label><br>
            <label>
                <input type="radio" name="wpkc_field_keyword_rendering" value="exclude_first_and_last_letter" <?php checked($option, 'exclude_first_and_last_letter', true); ?>> <?php echo __('Exclude first and last letter (ex. Cloudy = C****y)', 'wp-keyword-censor'); ?>
            </label><br>
        </fieldset><?php

    }
    
    /**
     * Display replace keyword with field
     * 
     * @param array $args Field arguments
     * @since 1.0
     */
    public function replace_keyword_with_field_cb($args)
    {
        
        $option = get_option('wpkc_field_replace_keyword_with'); ?>
        
        <input type="text" id="wpkc_field_replace_keyword_with" name="wpkc_field_replace_keyword_with" placeholder="*" style="width: 400px;" maxlength="1" value="<?php echo esc_attr($option);?>" />
        <p class="description"><?php echo __('Note: If left blank, will use asterisk (*) as default. Only 1 character limit is allowed.', 'wp-keyword-censor'); ?></p><?php

    }

    /**
     * Display apply changes on the following users field
     * 
     * @param array $args Field arguments
     * @since 1.0
     */
    public function apply_changes_on_following_users_field_cb($args)
    {
        
        $option     = get_option('wpkc_field_apply_changes_on_following_users');
        $logged_in  = isset($option['logged_in']) && !empty($option['logged_in']) ? $option['logged_in'] : ''; 
        $logged_out = isset($option['logged_out']) && !empty($option['logged_out']) ? $option['logged_out'] : ''; ?>

        <fieldset>
            <label for="wpkc_field_apply_changes_on_following_users_logged_in">
            <input name="wpkc_field_apply_changes_on_following_users[logged_in]" id="wpkc_field_apply_changes_on_following_users_logged_in" type="checkbox"  <?php checked($logged_in, 'on', true); ?>> <?php echo __('Logged-in', 'wp-keyword-censor'); ?>
            </label>
        </fieldset>
        <fieldset>
            <label for="wpkc_field_apply_changes_on_following_users_logged_out">
            <input name="wpkc_field_apply_changes_on_following_users[logged_out]" id="wpkc_field_apply_changes_on_following_users_logged_out" type="checkbox"  <?php checked($logged_out, 'on', true); ?>> <?php echo __('Logged-out', 'wp-keyword-censor'); ?>
            </label>
        </fieldset><?php

    }

    /**
     * Display case-sensitive field
     * 
     * @param array $args Field arguments
     * @since 1.0
     */
    public function delete_options_field_cb($args)
    {
        // Get the value of the setting we've registered with register_setting()
        $option  = get_option('wpkc_field_delete_options'); 
        $delete  = isset($option['delete']) && !empty($option['delete']) ? $option['delete'] : ''; ?>

        <fieldset>
            <label for="wpkc_field_delete_options">
                <input name="wpkc_field_delete_options[delete]" id="wpkc_field_delete_options" type="checkbox" <?php checked($delete, 'on', true); ?>> <?php echo __('Delete all options in the database when this plugin is uninstalled. This is to avoid unused data in the db.', 'wp-keyword-censor'); ?>
            </label>
        </fieldset><?php

    }
    
}

new WPKC_Settings();
