<?php
/**
 * Universal Connector
 *
 * @package   Universal_Connector_Shortcode_Public
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

/**
 * Handle Plugin Shortcode Public Side Features
 */
class Universal_Connector_Shortcode_Public
{

    /**
     * Instance of this class.
     *
     * @since    1.0.0
     *
     * @var      object
     */
    protected static $instance = null;

    /**
     * Initialize the class
     *
     * @since     1.0.0
     */
    private function __construct()
    {
        /**
         * Call $plugin_slug from public plugin class.
         */
        $plugin               = Universal_Connector::get_instance();
        $this->plugin_slug    = $plugin->get_plugin_slug();
        $this->plugin_version = $plugin->get_plugin_version();
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
     * Render Shortcode [plugin_shorcode]
     *
     * @since     1.0.0
     */
    public function render_sc($atts, $content = "")
    {
        extract(shortcode_atts(array(
            'id' => '',
        ), $atts));

        $id = (int) $id;

        if (!$id) {
            return '';
        }

        $contentValue = $content ? $content : __('Universal Connector Shorcode', 'universal-wordpress');

        return '<span data-some-attr-id="' . $id . '" style="cursor:pointer;">' . $contentValue . '</span>';

    }

}

/**
 * Register [plugin_shorcode] shortcode
 *
 * usage: [plugin_shorcode id='entry-id']Preview[/plugin_shorcode]
 * or: [plugin_shorcode id='entry-id' /]
 *
 * @since    1.0.0
 */
add_shortcode('plugin_shorcode', array(Universal_Connector_Shortcode_Public::get_instance(), 'render_sc'));
