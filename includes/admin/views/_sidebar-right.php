<?php
/**
 * Right sidebar for settings page
 *
 * @package   Universal_Connector_Admin
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
?>


<div id="postbox-container-1" class="postbox-container sidebar-right">
    <div class="meta-box-sortables">
        <div class="postbox">
            <h3><span><?php esc_attr_e('Get help', 'universal-wordpress');?></span></h3>
            <div class="inside">
                <div>
                    <ul>
                        <li><a class="no-underline" target="_blank" href="https://comelite.net/product/universal-wordpress"><span class="dashicons dashicons-admin-home"></span> <?php esc_attr_e('Plugin Homepage', 'universal-wordpress');?></a></li>
                    </ul>
                </div>
                <div class="sidebar-footer">
                    &copy; <?php echo date('Y'); ?> <a class="no-underline text-highlighted" href="https://comelite.net" title="Comelite IT Solutions LLC" target="_blank">Comelite IT Solutions LLC</a>
                </div>
            </div>
        </div>
    </div>
</div>
