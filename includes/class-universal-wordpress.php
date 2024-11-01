<?php
/**
 * Universal Connector.
 *
 * @package   Universal_Connector
 * @author    Comelite IT Solutions LLC
 * @license   GPL-2.0+
 * @link      https://comelite.net
 * @copyright 2016 Comelite IT Solutions. All Rigths Reserved
 */

/**
 *-----------------------------------------
 * Do not delete this line
 * Added for security reasons: http://codex.wordpress.org/Theme_Development#Template_Files
 *-----------------------------------------
 */
defined('ABSPATH') or die("Direct access to the script does not allowed");
/*-----------------------------------------*/

class Universal_Connector
{
    private static $customNumber = '';

    /**
     * Plugin version name
     *
     * @since   1.0.0
     *
     * @var     string
     */
    private static $VERSION_NAME = 'universal_wordpress_version';

    /**
     * Plugin version, used for cache-busting of style and script file references.
     *
     * @since   1.0.0
     *
     * @var     string
     */
    private static $VERSION = '1.0.0';

    /**
     * Unique identifier for your plugin.
     *
     * The variable name is used as the text domain when internationalizing strings
     * of text. Its value should match the Text Domain file header in the main
     * plugin file.
     *
     * @since    1.0.0
     *
     * @var      string
     */
    private static $PLUGIN_SLUG = 'universal-wordpress';

    /**
     * Instance of this class.
     *
     * @since    1.0.0
     *
     * @var      object
     */
    protected static $instance = null;

    /**
     * Initialize the plugin by setting localization and loading public scripts
     * and styles.
     *
     * @since     1.0.0
     */
    private function __construct()
    {
        // Load plugin text domain
        add_action('init', array($this, 'load_plugin_textdomain'));

        // Activate plugin when new blog is added
        add_action('wpmu_new_blog', array($this, 'activate_new_site'));

		add_action( 'init', array( __CLASS__, 'add_endpoint'), 0);
		add_action( 'template_redirect', array( __CLASS__, 'do_universal_chat'), 0 );

		// UC Ajax endpoints
		add_action( 'universal_chat_verify', array( $this, 'verify' ) );

        add_shortcode('universalchat', array ($this, 'registerNumber'));
        add_action('wp_footer', array($this, 'addChat'));
        //add_action('wp_head', array($this, 'addTracker'));
    }

	/**
	 * Add our endpoint for frontend ajax requests
	 */
	public static function add_endpoint() {
		add_rewrite_tag( '%universal-chat%', '([^/]*)' );

		add_rewrite_rule( 'universal-chat/([^/]*)/?', 'index.php?universal-chat=$matches[1]', 'top' );
		add_rewrite_rule( 'index.php/universal-chat/([^/]*)/?', 'index.php?universal-chat=$matches[1]', 'top' );
        flush_rewrite_rules();
	}

	/**
	 * Get JM Ajax Endpoint
	 * @param  string $request Optional
	 * @param  string $ssl     Optional
	 * @return string
	 */
	public static function get_endpoint( $request = '%%endpoint%%', $ssl = null ) {
		if ( strstr( get_option( 'permalink_structure' ), '/index.php/' ) ) {
			$endpoint = trailingslashit( home_url( '/index.php/universal-chat/' . $request . '/', 'relative' ) );
		} elseif ( get_option( 'permalink_structure' ) ) {
			$endpoint = trailingslashit( home_url( '/universal-chat/' . $request . '/', 'relative' ) );
		} else {
			$endpoint = add_query_arg( 'universal-chat', $request, trailingslashit( home_url( '', 'relative' ) ) );
		}
		return esc_url_raw( $endpoint );
	}

	/**
	 * Check for WC Ajax request and fire action
	 */
	public static function do_universal_chat() {
        global $wp_query;

		if ( ! empty( $_GET['universal-chat'] ) ) {
			 $wp_query->set( 'universal-chat', sanitize_text_field( $_GET['universal-chat'] ) );
		}

   		if ( $action = $wp_query->get( 'universal-chat' ) ) {
			// Not home - this is an ajax endpoint
			$wp_query->is_home = false;

   			do_action( 'universal_chat_' . sanitize_text_field( $action ) );
   			die();
   		}
	}

	/**
     * Get all data the user needs for the app startup
     * If authenticated, resume info will also be returned
     */
    public function verify() {
        echo ($_REQUEST['token'] == get_option('universal_piwik_token', '')) ? "true" : "false";
	}

    /**
     * Return the plugin slug.
     *
     * @since    1.0.0
     *
     * @return    Plugin slug variable.
     */
    public function get_plugin_slug()
    {
        return self::$PLUGIN_SLUG;
    }

    /**
     * Return the plugin version.
     *
     * @since    1.0.0
     *
     * @return    Plugin version variable.
     */
    public function get_plugin_version()
    {
        return self::$VERSION;
    }

    /**
     * Return an instance of this class.
     *
     * @since     1.0.0
     *
     * @return    object    A single instance of this class.
     */
    public static function get_instance()
    {

        // If the single instance hasn't been set, set it now.
        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Fired when the plugin is activated.
     *
     * @since    1.0.0
     *
     * @param    boolean    $network_wide    True if WPMU superadmin uses
     *                                       "Network Activate" action, false if
     *                                       WPMU is disabled or plugin is
     *                                       activated on an individual blog.
     */
    public static function activate($network_wide)
    {

        if (function_exists('is_multisite') && is_multisite()) {

            if ($network_wide) {

                // Get all blog ids
                $blog_ids = self::get_blog_ids();

                foreach ($blog_ids as $blog_id) {

                    switch_to_blog($blog_id);
                    self::single_activate();
                }

                restore_current_blog();

            } else {
                self::single_activate();
            }

        } else {
            self::single_activate();
        }

    }

    /**
     * Fired when the plugin is deactivated.
     *
     * @since    1.0.0
     *
     * @param    boolean    $network_wide    True if WPMU superadmin uses
     *                                       "Network Deactivate" action, false if
     *                                       WPMU is disabled or plugin is
     *                                       deactivated on an individual blog.
     */
    public static function deactivate($network_wide)
    {

        if (function_exists('is_multisite') && is_multisite()) {

            if ($network_wide) {

                // Get all blog ids
                $blog_ids = self::get_blog_ids();

                foreach ($blog_ids as $blog_id) {

                    switch_to_blog($blog_id);
                    self::single_deactivate();

                }

                restore_current_blog();

            } else {
                self::single_deactivate();
            }

        } else {
            self::single_deactivate();
        }

    }

    /**
     * Fired when a new site is activated with a WPMU environment.
     *
     * @since    1.0.0
     *
     * @param    int    $blog_id    ID of the new blog.
     */
    public function activate_new_site($blog_id)
    {

        if (1 !== did_action('wpmu_new_blog')) {
            return;
        }

        switch_to_blog($blog_id);
        self::single_activate();
        restore_current_blog();
    }

    public function registerNumber($atts){
      $attr = shortcode_atts( array(
                'number' => get_option( 'universal_registration_number', '' ),
            ), $atts );

      self::$customNumber = $attr['number'];
    }

    /*
    * Fired when the header is being registered
    */
    public function addTracker()
    {
    }

    /**
     * Fired when a new site is rendering the footer
     */
    public function addChat(){      
      
      $HtmlWidgetCode = get_option( 'universal_html_widget_code', '' );      

      ob_start();     

	  print_r($HtmlWidgetCode);
      
      ob_flush();
    }

    /**
     * Get all blog ids of blogs in the current network that are:
     * - not archived
     * - not spam
     * - not deleted
     *
     * @since    1.0.0
     *
     * @return   array|false    The blog ids, false if no matches.
     */
    private static function get_blog_ids()
    {

        global $wpdb;

        // get an array of blog ids
        $sql = "SELECT blog_id FROM $wpdb->blogs
            WHERE archived = '0' AND spam = '0'
            AND deleted = '0'";

        return $wpdb->get_col($sql);

    }

    /**
     * Fired for each blog when the plugin is activated.
     *
     * @since    1.0.0
     */
    private static function single_activate()
    {
        update_option(self::$VERSION_NAME, self::$VERSION);

        // @TODO: Define activation functionality here
    }

    /**
     * Fired for each blog when the plugin is deactivated.
     *
     * @since    1.0.0
     */
    private static function single_deactivate()
    {
        // @TODO: Define deactivation functionality here
    }

    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain()
    {

        $domain = self::$PLUGIN_SLUG;
        $locale = apply_filters('plugin_locale', get_locale(), $domain);

        load_textdomain($domain, trailingslashit(WP_LANG_DIR) . $domain . '/' . $domain . '-' . $locale . '.mo');
        load_plugin_textdomain($domain, false, basename(plugin_dir_path(dirname(__FILE__))) . '/languages/');

    }

}
