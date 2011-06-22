<?php
/**
 * Tools Posts
 *
 * @package         wp-cleanfix
 * @subpackage      tools_posts
 * @author          =undo= <g.fazioli@saidmade.com>
 * @copyright       Copyright (C) 2011 Saidmade Srl
 */


class WPCLEANFIX_TOOLS_POSTS {

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

		if( isset($_POST['wpCleanFixPostsForm']) ) {
			$wp_cleanfix_admin->options['wpCleanFixToolsPostsLimitExcerptLength'] = ( isset($_POST['wpCleanFixToolsPostsLimitExcerptLength']) ? "1" : "0");
			if( isset($_POST['wpCleanFixToolsPostsLimitExcerptLength']) ) {
				$wp_cleanfix_admin->options['wpCleanFixToolsPostsExcerptLength'] = $_POST['wpCleanFixToolsPostsExcerptLength'];
			}
		}
		update_option($wp_cleanfix_admin->options_key, $wp_cleanfix_admin->options);
	}

}
?>