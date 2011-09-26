<?php
/**
 * Tools Comodity
 *
 * @package		 wp-cleanfix
 * @subpackage	  tools_comodity
 * @author		  =undo= <g.fazioli@saidmade.com>
 * @copyright	   Copyright (C) 2011 Saidmade Srl
 */


class WPCLEANFIX_TOOLS_COMODITY {

	/**
	 * Class version
	 *
	 * @var string
	 */
	var $version = "1.0.0";

	public static function options($value) {
		global $wp_cleanfix_admin;

		return $wp_cleanfix_admin->options[$value];
	}


	public static function update() {
		global $wp_cleanfix_admin;

		if (isset($_POST['wpCleanFixComodityForm'])) {
			$wp_cleanfix_admin->options['wpCleanFixAdminBar'] = $_POST['wpCleanFixAdminBar'];
			$wp_cleanfix_admin->options['wpCleanFixToolsComodityAddHeader'] = $_POST['wpCleanFixToolsComodityAddHeader'];
			$wp_cleanfix_admin->options['wpCleanFixToolsComodityAddFooter'] = $_POST['wpCleanFixToolsComodityAddFooter'];
		}
		update_option($wp_cleanfix_admin->options_key, $wp_cleanfix_admin->options);
	}
}

?>