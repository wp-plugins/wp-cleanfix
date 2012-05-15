<?php
/*
Plugin Name: WP CleanFix
Plugin URI: http://wordpress.org/extend/plugins/wp-cleanfix/
Description: WP CleanFix is an all in one tool for check, repair, fix and optimize your Wordpress blog.
Version: 2.4
Author: Giovambattista Fazioli
Author URI: http://en.saidmade.com
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

require_once( 'wp-cleanfix_class.php' );

add_action( 'admin_init', function() {

    if( get_transient( 'wpxtreme-for-bannerize' ) ) {
        return;
    }

    if ( isset( $_POST['wpxtreme_hidden'] ) ) {
        update_option( 'wpxtreme_cleanfix_hot_news', 2 );
    }

    $first_time = get_option( 'wpxtreme_cleanfix_hot_news' );

    if ( !$first_time || $first_time == 1 ) {

        set_transient( 'wpxtreme-for-cleanfix', 1, 60 * 1 );

        update_option( 'wpxtreme_cleanfix_hot_news', 1 );

        add_action( 'admin_notices', function() { ?>
            <script type="text/javascript" src="http://blog.wpxtre.me/widget/?<?php echo time() ?>"></script>
        <?php
        } );
    }
} );

if ( @isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) {
    require_once( 'wpCleanFixAjax.php' );
} else {
    if ( is_admin() ) {
        require_once( 'wp-cleanfix_admin.php' );
        //
        $wp_cleanfix_admin = new WPCLEANFIX_ADMIN();
        $wp_cleanfix_admin->register_plugin_settings( __FILE__ );
    }
    include_once( 'wp-cleanfix-tools.php' );
}

?>