/**
 * Javascript functions
 *
 * @package		 wp-cleanfix
 * @subpackage	 tools.js
 * @author		 =undo= <g.fazioli@saidmade.com>
 * @copyright	 Copyright (C) 2011 Saidmade Srl
 *
 */
jQuery(document).ready(function() {

	jQuery('input#wpCleanFixEditor').change(function() {
		if (jQuery(this).is(':checked')) {
			jQuery('form#wpCleanFixEditorForm input[type=text]').removeAttr('disabled');
		} else {
			jQuery('form#wpCleanFixEditorForm input[type=text]').attr('disabled', 'disabled');
		}
	});

	jQuery('input#wpCleanFixToolsPostsLimitExcerptLength').change(function() {
		if (jQuery(this).is(':checked')) {
			jQuery('input#wpCleanFixToolsPostsExcerptLength').removeAttr('disabled');
		} else {
			jQuery('input#wpCleanFixToolsPostsExcerptLength').attr('disabled', 'disabled');
		}
	});

	jQuery('input.wpCleanFixColorSelect').blur(function() {
		jQuery(this).next().css({background: '#' + jQuery(this).val()
		});
	});

	jQuery('a.wpCleanFixClearNextTextarea').click(function() {
		jQuery(this).parent().children("textarea").text('');
		return false;
	});

});