/**
 * Javascript functions
 *
 * @package		 wp-cleanfix
 * @subpackage	 tools.js
 * @author		 =undo= <g.fazioli@undolog.com>, <g.fazioli@saidmade.com>
 * @copyright	 Copyright (C) 2011 Saidmade Srl
 *
 */
jQuery(document).ready(function($) {

	$('input#wpCleanFixEditor').change(function() {
		if ($(this).is(':checked')) {
			$('form#wpCleanFixEditorForm input[type=text]').removeAttr('disabled');
		} else {
			$('form#wpCleanFixEditorForm input[type=text]').attr('disabled', 'disabled');
		}
	});

	$('input#wpCleanFixToolsPostsLimitExcerptLength').change(function() {
		if ($(this).is(':checked')) {
			$('input#wpCleanFixToolsPostsExcerptLength').removeAttr('disabled');
		} else {
			$('input#wpCleanFixToolsPostsExcerptLength').attr('disabled', 'disabled');
		}
	});

	$('input.wpCleanFixColorSelect').blur(function() {
		$(this).next().css({background: '#' + $(this).val()
		});
	});

	$('a.wpCleanFixClearNextTextarea').click(function() {
		$(this).parent().children("textarea").text('');
		return false;
	});

});