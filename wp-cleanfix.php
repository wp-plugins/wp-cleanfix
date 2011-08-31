<?php
/*
Plugin Name: WP CleanFix
Plugin URI: http://wordpress.org/extend/plugins/wp-cleanfix/
Description: WP CleanFix is an all in one tool for check, repair, fix and optimize your Wordpress blog.
Version: 2.1.1
Author: Giovambattista Fazioli
Author URI: http://www.saidmade.com
Disclaimer: Use at your own risk. No warranty expressed or implied is provided.

	Copyright 2010-2011 Saidmade Srl (email : g.fazioli@saidmade.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/

require_once('wp-cleanfix_class.php');

if (@isset($_SERVER['HTTP_X_REQUESTED_WITH']) ) {
	require_once ('module/module.php');
    require_once ('module/database.php');
    require_once ('module/usermeta.php');
    require_once ('module/posts.php');
    require_once ('module/category.php');
    require_once ('module/comments.php');
    require_once ('module/badge.php');

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

} else {
	if (is_admin()) {
		require_once('wp-cleanfix_admin.php');
		//
		$wp_cleanfix_admin = new WPCLEANFIX_ADMIN();
		$wp_cleanfix_admin->register_plugin_settings(__FILE__);
	}
	include_once('wp-cleanfix-tools.php');
}

?>