<?php
/**
 * Tools Debug
 *
 * @package		wp-cleanfix
 * @subpackage	tools_debug
 * @author		=undo= <g.fazioli@saidmade.com>
 * @copyright	Copyright (C) 2011 Saidmade Srl
 */


class WPCLEANFIX_TOOLS_DEBUG {

	/**
	 * Class version
	 *
	 * @var string
	 */
	var $version = "1.0.0";

	public static function options($value) {
		global $wp_cleanfix_admin;

		return isset($wp_cleanfix_admin->options[$value]) ? $wp_cleanfix_admin->options[$value] : false;
	}

	public static function update() {
		global $wp_cleanfix_admin;

		if (isset($_POST['wpCleanFixDebugForm'])) {
			$wp_cleanfix_admin->options['wpCleanFixActiveDebugger'] = $_POST['wpCleanFixActiveDebugger'];
			$wp_cleanfix_admin->options['wpCleanFixFooPostsTitle'] = $_POST['wpCleanFixFooPostsTitle'];
			$wp_cleanfix_admin->options['wpCleanFixFooPostsCategory'] = $_POST['wpCleanFixFooPostsCategory'];
			$wp_cleanfix_admin->options['wpCleanFixFooPostsType'] = $_POST['wpCleanFixFooPostsType'];
		}
		update_option($wp_cleanfix_admin->options_key, $wp_cleanfix_admin->options);

		if (isset($_POST['wpCleanFixFooPosts'])) {
			$numberPosts = intval($_POST['wpCleanFixFooPosts']);
			if ($numberPosts > 0) {
				$my_post = array(
					'post_title' => '',
					'post_type' => $_POST['wpCleanFixFooPostsType'],
					'post_content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam non elit a leo tincidunt dapibus. Donec cursus ipsum arcu, vel posuere velit. Nulla eu lorem risus, eu euismod odio. Integer rutrum, turpis quis dignissim rutrum, odio elit malesuada diam, rhoncus pharetra massa dui vel diam. Nulla facilisi. Pellentesque volutpat placerat justo eget vulputate. Mauris orci urna, vehicula in hendrerit eu, laoreet nec nisl. Sed at neque risus. Quisque at felis sit amet magna mollis sagittis. Sed posuere orci at massa consequat eget auctor erat dictum. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque interdum adipiscing risus eu varius. Donec quam purus, convallis aliquam sodales vel, commodo et massa.',
					'post_status' => 'publish', 'post_author' => 1, 'post_category' => $_POST['wpCleanFixFooPostsCategory']);
				for ($i = 0; $i < $numberPosts; $i++) {
					$my_post['post_title'] = $_POST['wpCleanFixFooPostsTitle'] . ' #' . $i;
					wp_insert_post($my_post);
				}
				?>
					<div id="message" class="updated fade"><p><?php _e('Foo posts create succefully', 'wp-cleanfix') ?></p></div>
				<?php
			}
		}
	}

	/**
	 * Return HTML code (ul/li) with all Wordpress categories
	 *
	 * @param array $selected_cats
	 * @return string
	 */
	function get_categories_checkboxes($selected_cats = null) {

		/**
		 * Internal "iterate" recursive function. For build a tree of category
		 * Parent/Child
		 *
		 * @param object $cat_object
		 * @param array $selected_cats
		 * @return string
		 */
		function _i_show_category($cat_object, $selected_cats = null) {
			$checked = '';
			if (!is_null($selected_cats) && is_array($selected_cats)) {
				$checked = (in_array($cat_object->cat_ID, $selected_cats)) ? 'checked="checked"' : "";
			}
			$ou = '<li><label><input ' . $checked . ' type="checkbox" name="wpCleanFixFooPostsCategory[]" value="' . $cat_object->cat_ID . '" /> ' . $cat_object->cat_name . '</label>';

			$childs = get_categories('parent=' . $cat_object->cat_ID);
			foreach ($childs as $key => $cat) {
				$ou .= '<ul style="margin-left:12px">' . _i_show_category($cat, $selected_cats) . '</ul>';
			}
			$ou .= '</li>';
			return $ou;
		}


		$all_categories = get_categories();
		$o = '<ul style="margin-left:12px">';

		foreach ($all_categories as $key => $cat) {
			if ($cat->parent == "0")
				$o .= _i_show_category($cat, $selected_cats);
		}
		return $o . '</ul>';
	}

}

?>