<?php
/**
 * Tools Posts
 *
 * @package		 wp-cleanfix
 * @subpackage	  tools_view
 * @author		  =undo= <g.fazioli@saidmade.com>
 * @copyright	   Copyright (C) 2011 Saidmade Srl
 *
 */

require_once('tools_posts.php');

WPCLEANFIX_TOOLS_POSTS::update();

?>

<form action="" method="post" id="wpCleanFixPostsForm">
	<input type="hidden" value="1" name="wpCleanFixPostsForm"/>

	<p><input type="checkbox" name="wpCleanFixToolsPostsLimitExcerptLength" id="wpCleanFixToolsPostsLimitExcerptLength"
			  value="1" <?php checked(WPCLEANFIX_TOOLS_POSTS::options('wpCleanFixToolsPostsLimitExcerptLength'), 1) ?>/>
		<label><?php _e('Limit Excerpt Length', 'wp-cleanfix') ?></label>
		<input <?php disabled(WPCLEANFIX_TOOLS_POSTS::options('wpCleanFixToolsPostsLimitExcerptLength'), "0") ?>
				style="text-align:right;" type="text" size="4" name="wpCleanFixToolsPostsExcerptLength"
				id="wpCleanFixToolsPostsExcerptLength"
				value="<?php echo WPCLEANFIX_TOOLS_POSTS::options('wpCleanFixToolsPostsExcerptLength') ?>"/> <?php _e('Characters', 'wp-cleanfix') ?>
	</p>

	<p style="text-align:right"><input type="submit" class="button-secondary"
									   value="<?php _e('Save', 'wp-cleanfix') ?>"/></p>
</form>