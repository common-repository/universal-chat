<?php
/**
 * Universal Connector.
 *
 * @package   Universal_Connector_List
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

<div class="wrap">

    <h1>
        <?php echo esc_html(get_admin_page_title()); ?>
        <a href="<?php echo admin_url('admin.php?page=' . $this->plugin_slug . '-entry-add') ?>" class="page-title-action"><?php _e('Add New', 'universal-wordpress');?></a>
    </h1>


    <form id="universal-wordpress-filter" method="post">

        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>">

        <?php $universal_wordpress_list_table->display();?>

    </form>

</div>
