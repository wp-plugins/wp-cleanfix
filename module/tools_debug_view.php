<?php
/**
 * Tools Debug
 *
 * @package			wp-cleanfix
 * @subpackage		tools_debug_view
 * @author			=undo= <g.fazioli@saidmade.com>
 * @copyright		Copyright (C) 2011 Saidmade Srl
 *
 */

require_once('tools_debug.php');

WPCLEANFIX_TOOLS_DEBUG::update();

?>

<form action="" method="post" id="wpCleanFixDebugForm">
	<input type="hidden" value="1" name="wpCleanFixDebugForm"/>

	<fieldset>
		<legend><?php _e('Debug', 'wp-cleanfix') ?></legend>
		<p>
			<label for="wpCleanFixActiveDebugger"><input type="checkbox" name="wpCleanFixActiveDebugger"
														 id="wpCleanFixActiveDebugger"
														 value="1" <?php checked(WPCLEANFIX_TOOLS_DEBUG::options('wpCleanFixActiveDebugger'), 1) ?>/> <?php _e('Active Debugger Window in Dashboard (Insert the lines below in wp-config.php file)', 'wp-cleanfix') ?>
			</label>
		</p>

		<p>
			<code>define('WP_DEBUG', true);<br/>
				define('WP_DEBUG_LOG', true);<br/>
				define('WP_DEBUG_DISPLAY', false);<br/>
				ini_set('display_errors', 0);
			</code>
		</p>
	</fieldset>

	<fieldset>
		<legend><?php _e('Foo Posts', 'wp-cleanfix') ?></legend>
		<p>
			<label for="wpCleanFixFooPosts"><?php _e('Create:', 'wp-cleanfix') ?>
				<select name="wpCleanFixFooPosts">
					<option></option>
					<option value="10">10</option>
					<option value="20">20</option>
					<option value="50">50</option>
					<option value="100">100</option>
				</select>
				<select name="wpCleanFixFooPostsType">
					<option value="post"><?php _e('Posts', 'wp-cleanfix') ?></option>
					<option value="page"><?php _e('Pages', 'wp-cleanfix') ?></option>
				</select>
			</label>
		</p>
		<p><label for="wpCleanFixFooPostsTitle">
			<?php _e('With title:', 'wp-cleanfix') ?>
			<input type="text" size="32" name="wpCleanFixFooPostsTitle" id="wpCleanFixFooPostsTitle"
				   value="<?php echo WPCLEANFIX_TOOLS_DEBUG::options('wpCleanFixFooPostsTitle') ?>"/>
		</label></p>

		<p>
			<label for="wpCleanFixFooPostsTitle"><?php _e('In category:', 'wp-cleanfix') ?>
				<?php echo WPCLEANFIX_TOOLS_DEBUG::get_categories_checkboxes() ?>
			</label>
		</p>

	</fieldset>


	<p style="text-align:right"><input type="submit" class="button-secondary"
									   value="<?php _e('Save', 'wp-cleanfix') ?>"/></p>
</form>