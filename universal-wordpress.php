<?php
/**
 * @package   Universal_Connector
 * @author    Comelite IT Solutions LLC
 * @license   GPL-2.0+
 * @link      https://comelite.net
 * @copyright 2016 Comelite IT Solutions. All Rigths Reserved
 *
 * @wordpress-plugin
 * Plugin Name:       Universal Chat
 * Plugin URI:        https://comelite.net/product/universal-wordpress
 * Description:       Plugin Description
 * Version:           1.0.0
 * Author:            Comelite IT Solutions LLC
 * Author URI:        https://comelite.net
 * Text Domain:       universal-wordpress
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

/**
 *-----------------------------------------
 * Do not delete this line
 * Added for security reasons: http://codex.wordpress.org/Theme_Development#Template_Files
 *-----------------------------------------
 */
defined('ABSPATH') or die("Direct access to the script does not allowed");
/*-----------------------------------------*/
define('CHAT_HOST', "//universalchat.herokuapp.com"); define('TRACKER_HOST', "//comelite.net/piwik/");
//define('CHAT_HOST', "//localhost:3000"); define('TRACKER_HOST', "//localhost:8064/piwik/");

/*----------------------------------------------------------------------------*
 * * * ATTENTION! * * *
 * FOR DEVELOPMENT ONLY
 * SHOULD BE DISABLED ON PRODUCTION
 *----------------------------------------------------------------------------*/
error_reporting(E_ALL);
ini_set('display_errors', 1);
/*----------------------------------------------------------------------------*/

/*----------------------------------------------------------------------------*
 * Plugin Settings
 *----------------------------------------------------------------------------*/

/* ----- Plugin Module: Settings ----- */
require_once plugin_dir_path(__FILE__) . 'includes/class-universal-wordpress-settings.php';

register_activation_hook(__FILE__, array('Universal_Connector_Settings', 'activate'));
add_action('plugins_loaded', array('Universal_Connector_Settings', 'get_instance'));
/* ----- Module End: Settings ----- */

/*----------------------------------------------------------------------------*
 * Include extensions and CPT
 *----------------------------------------------------------------------------*/

/* ----- Plugin Module: CPT ----- */
require_once plugin_dir_path(__FILE__) . 'includes/cpt/class-universal-wordpress-cpt.php';
add_action('plugins_loaded', array('Universal_Connector_CPT', 'get_instance'));
/* ----- Module End: CPT ----- */

/*----------------------------------------------------------------------------*
 * Custom DB Tables
 *----------------------------------------------------------------------------*/

/* ----- Plugin Module: Database ----- */
require_once plugin_dir_path(__FILE__) . 'includes/class-universal-wordpress-db.php';

register_activation_hook(__FILE__, array('Universal_Connector_DB', 'activate'));
add_action('plugins_loaded', array('Universal_Connector_DB', 'db_check'));
/* ----- Module End: Database ----- */

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

require_once plugin_dir_path(__FILE__) . 'includes/class-universal-wordpress.php';

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 */
register_activation_hook(__FILE__, array('Universal_Connector', 'activate'));
register_deactivation_hook(__FILE__, array('Universal_Connector', 'deactivate'));

add_action('plugins_loaded', array('Universal_Connector', 'get_instance'));

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

if (is_admin() && (!defined('DOING_AJAX') || !DOING_AJAX)) {

    /* ----- Plugin Module: CRUD ----- */
    require_once plugin_dir_path(__FILE__) . 'includes/admin/class-universal-wordpress-admin-crud-list.php';
    /* ----- Module End: CRUD ----- */

    require_once plugin_dir_path(__FILE__) . 'includes/admin/class-universal-wordpress-admin.php';
    add_action('plugins_loaded', array('Universal_Connector_Admin', 'get_instance'));

    require_once plugin_dir_path(__FILE__) . 'includes/admin/class-universal-wordpress-admin-pages.php';
    add_action('plugins_loaded', array('Universal_Connector_Admin_Pages', 'get_instance'));

    require_once plugin_dir_path(__FILE__) . 'includes/admin/class-universal-wordpress-admin-pages-crud.php';
    add_action('plugins_loaded', array('Universal_Connector_Admin_Pages_CRUD', 'get_instance'));

    require_once plugin_dir_path(__FILE__) . 'includes/admin/class-universal-wordpress-admin-pages-settings.php';
    add_action('plugins_loaded', array('Universal_Connector_Admin_Pages_Settings', 'get_instance'));

}

/*----------------------------------------------------------------------------*
 * Register Plugin Shortcode
 *----------------------------------------------------------------------------*/

/* ----- Plugin Module: Shortcode ----- */
// Admin Side
require_once plugin_dir_path(__FILE__) . 'includes/shortcode/class-universal-wordpress-shortcode-admin.php';
add_action('plugins_loaded', array('Universal_Connector_Shortcode_Admin', 'get_instance'));

// Public Side
require_once plugin_dir_path(__FILE__) . 'includes/shortcode/class-universal-wordpress-shortcode-public.php';
add_action('plugins_loaded', array('Universal_Connector_Shortcode_Public', 'get_instance'));
/* ----- Module End: Shortcode ----- */

/*----------------------------------------------------------------------------*
 * Handle AJAX Calls
 *----------------------------------------------------------------------------*/

/* ----- Plugin Module: AJAX ----- */
require_once plugin_dir_path(__FILE__) . 'includes/class-universal-wordpress-ajax.php';
add_action('plugins_loaded', array('Universal_Connector_AJAX', 'get_instance'));
/* ----- Module End: AJAX ----- */
