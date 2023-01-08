<?php
/**
 * Contains logic to all features
 * 
 * @since   1.0
 */

defined('ABSPATH') || exit;

/**
 * Class that contains all settings logic
 */
class WPKC_Features
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

      // Apply changes to logged-in or logged-out
      add_action('wp_loaded', array($this, 'wp_loaded'));

    }
    
    /**
     * Apply changes when user is logged-in or logged-out.
     * 
     * @since 1.0
     */
    public function wp_loaded()
    {

      $option = get_option('wpkc_field_apply_changes_on_following_users');
      $is_user_logged_in = is_user_logged_in();

      if(
        (isset($option['logged_in']) && $option['logged_in'] === 'on' && $is_user_logged_in == true)
        ||
        (isset($option['logged_out']) && $option['logged_out'] === 'on' && $is_user_logged_in == false) 
      ) {

        // Filter title
        add_filter('the_title', array($this,'filter_title'));

        // Filter Content
        add_filter('the_content', array($this,'filter_content'));

        // Filter Excerpt
        add_filter('the_excerpt', array($this,'filter_excerpt'));

        // WC Excerpt hook
        add_filter('woocommerce_short_description', array($this,'filter_excerpt'));
        
        // Filter Comment
        add_filter('comment_text', array($this,'filter_comment'));

      }
      
    }

    /**
     * Filter the title.
     * 
     * @param string $title Post title strings
     * @since 1.0
     */
    public function filter_title($title)
    {
      
      $content_to_filter = get_option('wpkc_field_content_to_filter'); 

      if(isset($content_to_filter['title']) && $content_to_filter['title'] == 'on') {
        
        $keywords = get_option('wpkc_field_keywords');
        $keywords = array_map('trim',explode('|', $keywords));

        $replace_with = $this->replace_keyword_with($keywords, $title);
        
        $title = $this->case_sensitive($keywords, $replace_with, $title);
          
      }
      
      return $title;

    }

    /**
     * Filter the content.
     * 
     * @param string $content Post content strings
     * @since 1.0
     */
    public function filter_content($content)
    {
      
      $content_to_filter = get_option('wpkc_field_content_to_filter'); 

      if(isset($content_to_filter['content']) && $content_to_filter['content'] == 'on') {
        
        $keywords = get_option('wpkc_field_keywords');
        $keywords = array_map('trim',explode('|', $keywords));

        $replace_with = $this->replace_keyword_with($keywords, $content);
        
        $content = $this->case_sensitive($keywords, $replace_with, $content);
        
      }
      
      return $content;

    }

    /**
     * Filter the excerpt.
     * 
     * @param string $excerpt Post excerpt strings
     * @since 1.0
     */
    public function filter_excerpt($excerpt)
    {
      
      $content_to_filter = get_option('wpkc_field_content_to_filter'); 
      
      if(isset($content_to_filter['excerpt']) && $content_to_filter['excerpt'] == 'on') {
        
        $keywords = get_option('wpkc_field_keywords');
        $keywords = array_map('trim',explode('|', $keywords));

        $replace_with = $this->replace_keyword_with($keywords, $excerpt);
        
        $excerpt = $this->case_sensitive($keywords, $replace_with, $excerpt);
        
      }
      
      return $excerpt;

    }
    
    /**
     * Filter the excerpt.
     * 
     * @param string $comments Post comments strings
     * @since 1.0
     */
    public function filter_comment($comments)
    {
      
      $content_to_filter = get_option('wpkc_field_content_to_filter'); 
      
      if(isset($content_to_filter['comments']) && $content_to_filter['comments'] == 'on') {
        
        $keywords = get_option('wpkc_field_keywords');
        $keywords = array_map('trim',explode('|', $keywords));

        $replace_with = $this->replace_keyword_with($keywords, $comments);
        
        $comments = $this->case_sensitive($keywords, $replace_with, $comments);
        
      }
      
      return $comments;

    }
    
    /**
     * Helper function that check whether to use case-sensitive or case-insensitive function
     * 
     * @param array   $keywords Excerpt strings
     * @param array   $replace_with Excerpt strings
     * @param string  $strings The strings to search for
     * @since 1.0
     */
    public function case_sensitive($keywords, $replace_with, $strings)
    {

      $sensitive  = get_option('wpkc_field_case_sensitive');
      $sensitive  = isset($sensitive['sensitive']) && !empty($sensitive['sensitive']) ? $sensitive['sensitive'] : '';

      if($sensitive == 'on'){
        $strings = str_replace($keywords, $replace_with, $strings);
      } else {
        $strings = str_ireplace($keywords, $replace_with, $strings);
      }
      
      return $strings;

    }

    /**
     * Helper function that defines the keywords to be rendered
     * 
     * @param array   $keywords All the keywords to search
     * @param string  $strings  The strings to search for
     * @since 1.0
     */
    public function replace_keyword_with($keywords, $strings)
    {

      $keyword_rendering  = get_option('wpkc_field_keyword_rendering');
      $character          = get_option('wpkc_field_replace_keyword_with');
      $character          = empty($character) ? '*' : $character;
      $replace_with       = [];

      
      if(!empty($keywords)){
        foreach($keywords as $keyword){
          $length = strlen($keyword);
          
          preg_match('/\b' . preg_quote($keyword, '/') . '\b/i', $strings, $matches);
          $keyword = isset($matches[0]) ? $matches[0] : $keyword;

          if($keyword_rendering == 'exclude_first_letter') {
            $replace        = str_repeat($character, $length-1);
            $replace_with[] = substr($keyword, 0, 1) . $replace;
          } else if($keyword_rendering == 'exclude_first_and_last_letter') {
            $replace        = str_repeat($character, $length-2);
            $replace_with[] = substr($keyword, 0, 1) . $replace . substr($keyword, $length - 1, 1); 
          } else {
            $replace_with[] = str_repeat($character, $length);
          }
        }
      }
      
      return $replace_with;

    }

}

new WPKC_Features();
