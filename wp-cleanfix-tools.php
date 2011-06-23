<?php
/**
 * wp-cleanfix-tools
 *
 * @author =undo=
 * @date 22/06/11
 * 
 * (C)2011 Saidmade Srl. All rights reserved
 *
 */
 
/**
 * Tools
 * Backend and Frontend patch/fix/commodity/utility
 */

$wp_cleanfix_options = get_option( 'wp-cleanfix' );

if( $wp_cleanfix_options['wpCleanFixEditor'] == "1" ) {

	/**
	 * Editor
	 * @return void
	 */
	function wp_cleanfix_add_style_header() {
		global $wp_cleanfix_options;
		?>
		<style type="text/css">
			#editorcontainer #content {
				font-family:<?php echo $wp_cleanfix_options['wpCleanFixFontEditorName'] ?>;
				background: #<?php echo $wp_cleanfix_options['wpCleanFixBackgroundColor'] ?>;
				color: #<?php echo $wp_cleanfix_options['wpCleanFixTextColor'] ?>;
				font-size:<?php echo $wp_cleanfix_options['wpCleanFixTextSize'] ?>px;
				height:<?php echo $wp_cleanfix_options['wpCleanFixEditorHeight'] ?>px;
			}
		</style>
	<?php
	}
	add_action('admin_print_styles', 'wp_cleanfix_add_style_header' );

	/**
	 * Allow extra tags in Editor
	 */
	if( $wp_cleanfix_options['wpCleanFixAllowTags'] != "" ) {
		/**
		 * Extends default editor
		 *
		 * @param  $initArray
		 * @return
		 */
		function wp_cleanfix_change_mce_options($initArray) {
			global $wp_cleanfix_options;

			$ext = $wp_cleanfix_options['wpCleanFixAllowTags'];

			if ( isset( $initArray['extended_valid_elements'] ) ) {
				$initArray['extended_valid_elements'] .= ',' . $ext;
			} else {
				$initArray['extended_valid_elements'] = $ext;
			}

			return $initArray;
		}
		add_filter('tiny_mce_before_init', 'wp_cleanfix_change_mce_options');
	}

}

/**
 * Posts
 */
if( isset($_POST['wpCleanFixToolsPostsLimitExcerptLength']) ) {
	function wp_cleanfix_excerpt_length($length) {
		global $wp_cleanfix_options;
		return $wp_cleanfix_options['wpCleanFixToolsPostsExcerptLength'];
	}
	add_filter('excerpt_length', 'wp_cleanfix_excerpt_length');
}

/**
 * Comodity
 */

if( $wp_cleanfix_options['wpCleanFixRemoveFrontendAdminBar'] == "1" ) {
	add_filter('show_admin_bar', '__return_false');
}

if( $wp_cleanfix_options['wpCleanFixToolsComodityAddHeader'] != "") {
	function wp_cleanfix_addheader() {
		global $wp_cleanfix_options;
		echo stripslashes($wp_cleanfix_options['wpCleanFixToolsComodityAddHeader']);
	}
	add_action('wp_head', 'wp_cleanfix_addheader');
}

if( $wp_cleanfix_options['wpCleanFixToolsComodityAddFooter'] != "") {
	function wp_cleanfix_addfooter() {
		global $wp_cleanfix_options;
		echo stripslashes( $wp_cleanfix_options['wpCleanFixToolsComodityAddFooter'] );
	}
	add_action('wp_footer', 'wp_cleanfix_addfooter');
}

?>