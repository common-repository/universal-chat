<?php
/**
 * Universal Connector.
 *
 * @package   Universal_Connector_AJAX
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
 * Register custom post types and taxonomies
 */
class Universal_Connector_CPT
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
     * List of all Custom Post Types to be registered
     *
     * @since    1.0.0
     *
     * @var      array
     */
    private static $cpt_list = array();

    /**
     * Initialize the plugin by setting localization and loading public scripts
     * and styles.
     *
     * @since     1.0.0
     */
    private function __construct()
    {
        self::load_cpt();
        add_action('init', array($this, 'register_cpt_and_taxonomies'));
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
     * Assign Custom Post Types to class variable.
     *
     * @since     1.0.0
     */
    private static function load_cpt()
    {
        $cpt = array(
            'entries' => array(
                'labels'             => array(
                    'name'               => _x('Entries', 'post type general name', 'universal-wordpress'),
                    'singular_name'      => _x('Entry', 'post type singular name', 'universal-wordpress'),
                    'menu_name'          => _x('Entries', 'admin menu', 'universal-wordpress'),
                    'name_admin_bar'     => _x('Entry', 'add new on admin bar', 'universal-wordpress'),
                    'add_new'            => _x('Add New', 'entry', 'universal-wordpress'),
                    'add_new_item'       => __('Add New Entry', 'universal-wordpress'),
                    'new_item'           => __('New Entry', 'universal-wordpress'),
                    'edit_item'          => __('Edit Entry', 'universal-wordpress'),
                    'view_item'          => __('View Entry', 'universal-wordpress'),
                    'all_items'          => __('All Entry', 'universal-wordpress'),
                    'search_items'       => __('Search Entry', 'universal-wordpress'),
                    'parent_item_colon'  => __('Parent Entries:', 'universal-wordpress'),
                    'not_found'          => __('No Entries found.', 'universal-wordpress'),
                    'not_found_in_trash' => __('No Entries found in Trash.', 'universal-wordpress'),
                ),
                'description'        => __('Manage your entries', 'universal-wordpress'),
                'public'             => false,
                'publicly_queryable' => false,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'query_var'          => false,
                'rewrite'            => array('slug' => 'entries'),
                'capability_type'    => 'post',
                'has_archive'        => false,
                'hierarchical'       => false,
                'menu_position'      => 25,
                'menu_icon'          => 'dashicons-layout',
                'supports'           => array('title'),
            ),
        );

        self::$cpt_list = $cpt;
    }

    /**
     * Register all Custom Post Types and Taxonomies.
     *
     * @since     1.0.0
     */
    public function register_cpt_and_taxonomies()
    {
        // Register CPT
        foreach (self::$cpt_list as $slug => $args) {
            register_post_type($slug, $args);
        }
    }

}
