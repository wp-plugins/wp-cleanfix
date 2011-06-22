<?php
/**
 * Tools Comodity
 *
 * @package		 wp-cleanfix
 * @subpackage	  tools_comodity_view
 * @author		  =undo= <g.fazioli@saidmade.com>
 * @copyright	   Copyright (C) 2011 Saidmade Srl
 *
 */

require_once('tools_comodity.php');

WPCLEANFIX_TOOLS_COMODITY::update();

?>

<form action="" method="post" id="wpCleanFixComodityForm">
	<input type="hidden" value="1" name="wpCleanFixComodityForm"/>

	<p><input type="checkbox" name="wpCleanFixRemoveFrontendAdminBar" id="wpCleanFixRemoveFrontendAdminBar"
			  value="1" <?php checked(WPCLEANFIX_TOOLS_COMODITY::options('wpCleanFixRemoveFrontendAdminBar'), 1) ?>/>
		<label><?php _e('Remove Frontend Admin Bar', 'wp-cleanfix') ?></label></p>

	<p>
		<label><?php _e('Add to header:', 'wp-cleanfix') ?></label><a
			class="button-secondary wpCleanFixClearNextTextarea" href="#"><?php _e('Clear', 'wp-cleanfix') ?></a><br/>
		<textarea class="wpCleanFixCode" name="wpCleanFixToolsComodityAddHeader" id="wpCleanFixToolsComodityAddHeader"
				  rows="4"
				  cols="4"><?php echo stripslashes(WPCLEANFIX_TOOLS_COMODITY::options('wpCleanFixToolsComodityAddHeader')) ?></textarea>
	</p>

	<p>
		<label><?php _e('Add to footer:', 'wp-cleanfix') ?></label> <a
			class="button-secondary wpCleanFixClearNextTextarea" href="#"><?php _e('Clear', 'wp-cleanfix') ?></a><br/>
		<textarea class="wpCleanFixCode" name="wpCleanFixToolsComodityAddFooter" id="wpCleanFixToolsComodityAddFooter"
				  rows="4"
				  cols="4"><?php echo stripslashes(WPCLEANFIX_TOOLS_COMODITY::options('wpCleanFixToolsComodityAddFooter')) ?></textarea>
	</p>


	<p style="text-align:right"><input type="submit" class="button-secondary"
									   value="<?php _e('Save', 'wp-cleanfix') ?>"/></p>
</form>