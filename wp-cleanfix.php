<?php
/*
Plugin Name: WP-CLEANFIX
Plugin URI: http://wordpress.org/extend/plugins/wp-cleanfix/
Description: WP-CLEANFIX, all in one tool for check, repair, fix and optimize your Wordpress blog.. For more info and plugins visit <a href="http://labs.saidmade.com">Labs Saidmade</a>.
Version: 0.1.0
Author: Giovambattista Fazioli
Author URI: http://www.undolog.com
Disclaimer: Use at your own risk. No warranty expressed or implied is provided.

	Copyright 2010 Saidmade Srl (email : g.fazioli@undolog.com - g.fazioli@saidmade.com)

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

require_once( 'wp-cleanfix_class.php');

if( is_admin() ) {
	require_once( 'wp-cleanfix_admin.php' );
	//
	$wp_cleanfix_admin = new WPCLEANFIX_ADMIN();
	$wp_cleanfix_admin->register_plugin_settings( __FILE__ );
}
?>