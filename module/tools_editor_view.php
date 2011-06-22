<?php
/**
 * Tools Editor
 *
 * @package		 wp-cleanfix
 * @subpackage	  tools_editor_view
 * @author		  =undo= <g.fazioli@saidmade.com>
 * @copyright	   Copyright (C) 2011 Saidmade Srl
 *
 */

require_once('tools_editor.php');

WPCLEANFIX_TOOLS_EDITOR::update();

?>

<form action="" method="post" id="wpCleanFixEditorForm">
	<input type="hidden" value="1" name="wpCleanFixEditorForm"/>

	<p><input type="checkbox" name="wpCleanFixEditor" id="wpCleanFixEditor"
			  value="1" <?php checked(WPCLEANFIX_TOOLS_EDITOR::options('wpCleanFixEditor'), 1) ?>/>
		<label><?php _e('Fix HTML editor', 'wp-cleanfix') ?></label></p>

	<p><label><?php _e('Font name:', 'wp-cleanfix') ?>
		<input <?php disabled(WPCLEANFIX_TOOLS_EDITOR::options('wpCleanFixEditor'), "0") ?> size="32" type="text"
																							name="wpCleanFixFontEditorName"
																							value='<?php echo htmlspecialchars(WPCLEANFIX_TOOLS_EDITOR::options('wpCleanFixFontEditorName'), ENT_QUOTES) ?>'/> <?php _e('(Ex. Monaco, Curier)', 'wp-cleanfix') ?>
	</p>

	<p><label><?php _e('Editor\'s height:', 'wp-cleanfix') ?></label>
		<input <?php disabled(WPCLEANFIX_TOOLS_EDITOR::options('wpCleanFixEditor'), "0") ?> style="text-align:right;"
																							type="text" size="4"
																							name="wpCleanFixEditorHeight"
																							value="<?php echo WPCLEANFIX_TOOLS_EDITOR::options('wpCleanFixEditorHeight') ?>"/>
		px</p>

	<p><label><?php _e('Text size:', 'wp-cleanfix') ?></label>
		<input <?php disabled(WPCLEANFIX_TOOLS_EDITOR::options('wpCleanFixEditor'), "0") ?> style="text-align:right;"
																							type="text" size="4"
																							name="wpCleanFixTextSize"
																							value="<?php echo WPCLEANFIX_TOOLS_EDITOR::options('wpCleanFixTextSize') ?>"/>
		px</p>

	<p><label><?php _e('Background color:', 'wp-cleanfix') ?></label>
		<input <?php disabled(WPCLEANFIX_TOOLS_EDITOR::options('wpCleanFixEditor'), "0") ?> style="text-align:right;"
																							type="text" size="6"
																							class="wpCleanFixColorSelect"
																							name="wpCleanFixBackgroundColor"
																							id="wpCleanFixBackgroundColor"
																							value="<?php echo WPCLEANFIX_TOOLS_EDITOR::options('wpCleanFixBackgroundColor') ?>"/>
		<span <?php echo (WPCLEANFIX_TOOLS_EDITOR::options('wpCleanFixBackgroundColor') != "")
				? 'style="background:#' . WPCLEANFIX_TOOLS_EDITOR::options('wpCleanFixBackgroundColor') . ';"' : '' ?>
				class="wpCleanFixColorPreview"></span></p>

	<p><label><?php _e('Text color:', 'wp-cleanfix') ?></label>
		<input <?php disabled(WPCLEANFIX_TOOLS_EDITOR::options('wpCleanFixEditor'), "0") ?> style="text-align:right;"
																							type="text" size="6"
																							class="wpCleanFixColorSelect"
																							name="wpCleanFixTextColor"
																							id="wpCleanFixTextColor"
																							value="<?php echo WPCLEANFIX_TOOLS_EDITOR::options('wpCleanFixTextColor') ?>"/>
		<span <?php echo (WPCLEANFIX_TOOLS_EDITOR::options('wpCleanFixTextColor') != "")
				? 'style="background:#' . WPCLEANFIX_TOOLS_EDITOR::options('wpCleanFixTextColor') . ';"' : '' ?>
				class="wpCleanFixColorPreview"></span></p>

	<p><label><?php _e('Extra HTML tags allowed:', 'wp-cleanfix') ?></label>
		<input <?php disabled(WPCLEANFIX_TOOLS_EDITOR::options('wpCleanFixEditor'), "0") ?> size="32" type="text"
																							name="wpCleanFixAllowTags"
																							value="<?php echo WPCLEANFIX_TOOLS_EDITOR::options('wpCleanFixAllowTags') ?>"/>
	</p>

	<p style="text-align:right"><input type="submit" class="button-secondary"
									   value="<?php _e('Save', 'wp-cleanfix') ?>"/></p>
</form>