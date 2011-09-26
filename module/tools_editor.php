<?php
/**
 * Tools Editor
 *
 * @package         wp-cleanfix
 * @subpackage      WPCLEANFIX_TOOLS_EDIOR
 * @author          =undo= <g.fazioli@saidmade.com>
 * @copyright       Copyright (C) 2011 Saidmade Srl
 */


class WPCLEANFIX_TOOLS_EDITOR {

    /**
     * Class version
     *
     * @var string
     */
    var $version    = "1.0.0";

	public static function options($value) {
		global $wp_cleanfix_admin;

		return $wp_cleanfix_admin->options[$value];
	}


	public static function update() {
		global $wp_cleanfix_admin;

		if ( get_magic_quotes_gpc() ) {
			$_POST      = array_map( 'stripslashes_deep', $_POST );
			$_GET       = array_map( 'stripslashes_deep', $_GET );
			$_COOKIE    = array_map( 'stripslashes_deep', $_COOKIE );
			$_REQUEST   = array_map( 'stripslashes_deep', $_REQUEST );
		}

		if( isset($_POST['wpCleanFixEditorForm']) ) {
			$wp_cleanfix_admin->options['wpCleanFixEditor'] = ( isset($_POST['wpCleanFixEditor']) ? "1" : "0");
			if( isset($_POST['wpCleanFixEditor']) ) {
				$wp_cleanfix_admin->options['wpCleanFixFontEditorName'] = $_POST['wpCleanFixFontEditorName'];
				$wp_cleanfix_admin->options['wpCleanFixEditorHeight'] = $_POST['wpCleanFixEditorHeight'];
				$wp_cleanfix_admin->options['wpCleanFixBackgroundColor'] = $_POST['wpCleanFixBackgroundColor'];
				$wp_cleanfix_admin->options['wpCleanFixTextSize'] = $_POST['wpCleanFixTextSize'];
				$wp_cleanfix_admin->options['wpCleanFixTextColor'] = $_POST['wpCleanFixTextColor'];
				$wp_cleanfix_admin->options['wpCleanFixAllowTags'] = $_POST['wpCleanFixAllowTags'];
			}
		}
		update_option($wp_cleanfix_admin->options_key, $wp_cleanfix_admin->options);
	}

}
?>