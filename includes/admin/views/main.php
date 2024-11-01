<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
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

<div class="wrap">

    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>

    <!-- @TODO: Provide markup for your options page here. -->
	<p><a href="https://comelite.net/universal" target="_blank">Universal</a> allows you to chat with your online visitors from your mobile while they visit your website. It's a free service installed on your Telegram messenger.<br /></p>
	<p>Follow the next steps to add Universal Chat to your website:</p>
	<ol>
		<li><a href="https://comelite.net/universal/registrations/add" target="_blank">Register for a free account</a></li>
		<li><a href="https://comelite.net/universal/pages/singleaccount" target="_blank">Setup your Telegram</a></li>
		<li>Copy your Html Widget Code and paste it in the <a href="<?php echo admin_url('admin.php?page=' . $this->plugin_slug . '-settings') ?>">Settings page</a></li>
	</ol>
	<p>And you are good to go!</p>
	<ul>
		<li>If you have any questions about Universal, <a href="http://comelite.net/universal/pages/faq" target="_blank">read the FAQ</a></li>
		<li>With Universal, you can also <a href="http://comelite.net/universal/pages/usinggroups" target="_blank">set up a Service Center</a></li>
		<li>The Business Plan allows you to <a href="http://comelite.net/universal/pages/usingchannels" target="_blank">create multiple communication channels</a></li>
	</ul>

</div>
