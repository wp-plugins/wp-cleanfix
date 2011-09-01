<?php
/**
 * Ajax module for POST request
 *
 * @package         wp-cleanfix
 * @subpackage      wp-cleanfix_ajax
 * @author          =undo= <g.fazioli@saidmade.com>
 * @copyright       Copyright (C) 2010-2011 Saidmade Srl
 *
 * $_POST['command'] = todo
 *
 */

if (@isset($_SERVER['HTTP_X_REQUESTED_WITH']) ) {
	require_once ('module/module.php');
    require_once ('module/database.php');
    require_once ('module/usermeta.php');
    require_once ('module/posts.php');
    require_once ('module/category.php');
    require_once ('module/comments.php');
    require_once ('module/badge.php');

	load_plugin_textdomain ( 'wp-cleanfix' , false, 'wp-cleanfix/localization'  );

	function wpCleanFixAjax() {
		global $WPCLEANFIX_DATABASE;
		global $WPCLEANFIX_USERMETA;
		global $WPCLEANFIX_POSTS;
		global $WPCLEANFIX_CATEGORY;
		 // Sanitize $_POST['command]
		$command = strip_tags( $_POST['command'] );
		eval ( $command );
		die();
	}

	add_action('wp_ajax_wpCleanFixAjax', 'wpCleanFixAjax' );
}

?>