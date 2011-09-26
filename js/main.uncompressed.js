/**
 * Javascript functions
 *
 * @package         wp-cleanfix
 * @subpackage      main.js
 * @author          =undo= <g.fazioli@undolog.com>, <g.fazioli@saidmade.com>
 * @copyright       Copyright (C) 2011 Saidmade Srl
 *
 */
jQuery(document).ready(function($) {

	/*
	jQuery('form#wp-cleanfix-form-postbox').submit(
			function() {
				return false;
			});
	*/

    /**
     * Mostra l'animazione gif per attesa ajax
     *
     * @since 0.1.1
     * @var string id del contenitore
     */
    function wp_cleanfix_ajax_wait(id) {
        $('div#' + id).html( '<div id="ajax-wait"></div>' );
    }

    /**
     * Imposta il bottone di refresh
     *
     * @since 0.1.1
     * @var string button
     * @var string command
     * @var string id
     */
    function wp_cleanfix_ajax_command(button, command, id) {
        var cc = !( arguments[3] == undefined );
        var uu = (command == '');
        var pd = {action : 'wpCleanFixAjax', command: command};

        if( !( arguments[4] == undefined ) ) {
            var callBack = arguments[4];
        }

        $('button#' + button).live('click',
            function() {
                // @since 0.3.0
                if(uu) {
                    alert(wpCleanFixJavascriptLocalization.notImplement);
                    return;
                }
                if(cc && id != 'database-optimize') {
                     if(!confirm(wpCleanFixJavascriptLocalization.messageConfirm)) {
                         return;
                     }
                }
                if(callBack != undefined) {
                    var no = callBack();
					no.action = 'wpCleanFixAjax';
                    no.command = pd.command;
                    pd = no;
                }
                wp_cleanfix_ajax_wait(id);

                $.post( wpCleanFixJavascriptLocalization.ajaxURL, pd,
                    function( data ) {
                        $('div#' + id).html( data );
                        // @since 0.5.3
                        if(id != 'database-optimize' && cc) {
                            wp_cleanfix_check_optimize();
                        }
                    }
                );
            }
        );
    }

    /**
     * Refresh only "database optimize" section
     */
    function wp_cleanfix_check_optimize() {
        // fix ajax loader
        // @since 0.5.3
        wp_cleanfix_ajax_wait('database-optimize');
        $.post( wpCleanFixJavascriptLocalization.ajaxURL, {
				action: 'wpCleanFixAjax',
                command: '$WPCLEANFIX_DATABASE->checkTables();'
            },
            function( data ) {
                $('div#database-optimize').html( data );
            }
        );
		var badge = {action: 'wpCleanFixAjax', command: 'WPCLEANFIX_BADGE::countRepair();' };
		$.post( wpCleanFixJavascriptLocalization.ajaxURL, badge,
			function( data ) {
				if(data > 0 || data != '0') {
					$('span#wpcleanfix_badge').html('<span class="update-plugins count-%d"><span class="update-count">'+data+'</span></span>');
				} else {
					$('span#wpcleanfix_badge').html('');
				}
			}
		);
    }

    /**
     * Register refresh button id for refresh all
     */
    function wp_cleanfix_refresh_all(button_id, button_ids) {
        $('button#' + button_id).click(function(){
            for(var i = 0; i < button_ids.length; i++) {
                $('button#' + button_ids[i]).trigger('click');
            }
        });
    }

    // -----------------------------------------------------------------------------------------------------------------
	// Database
	// -----------------------------------------------------------------------------------------------------------------
	wp_cleanfix_ajax_command('buttonDatabaseOptimize', '$WPCLEANFIX_DATABASE->optimize();', 'database-optimize', true );
	wp_cleanfix_ajax_command('buttonDatabaseOptimizeTableRefresh', '$WPCLEANFIX_DATABASE->checkTables();', 'database-optimize' );
    // -------------------------------------------------------------------------

	// -----------------------------------------------------------------------------------------------------------------
	// UserMeta
	// -----------------------------------------------------------------------------------------------------------------
    wp_cleanfix_ajax_command('buttonUserMetaRemoveUnlink', '$WPCLEANFIX_USERMETA->removeUserMeta();', 'usersmeta-unused', true );
    wp_cleanfix_ajax_command('buttonUserMetaUnusedRefresh', '$WPCLEANFIX_USERMETA->checkUserMeta();', 'usersmeta-unused' );

	// -----------------------------------------------------------------------------------------------------------------
    // Posts
	// -----------------------------------------------------------------------------------------------------------------
    wp_cleanfix_refresh_all('buttonPostsRefreshAll',
        ['buttonPostRevisionRefresh',
		  'buttonPostAutodraftRefresh',
          'buttonPostTrashRefresh',
          'buttonPostMetaRefresh',
          'buttonPostMetaEditLockRefresh',
          'buttonPostTagsRefresh',
          'buttonPostsUsersRefresh',
          'buttonPagesUsersRefresh',
          'buttonAttachmentsRefresh'
        ] );

	// -----------------------------------------------------------------------------------------------------------------
    // Post Revision
	// -----------------------------------------------------------------------------------------------------------------
    wp_cleanfix_ajax_command('buttonPostsRemoveAutodraft', '$WPCLEANFIX_POSTS->removeAutodraft();', 'posts-autodraft', true );
    wp_cleanfix_ajax_command('buttonPostAutodraftRefresh', '$WPCLEANFIX_POSTS->checkAutodraft();', 'posts-autodraft' );

	// -----------------------------------------------------------------------------------------------------------------
    // Post Autodraft
	// -----------------------------------------------------------------------------------------------------------------
    wp_cleanfix_ajax_command('buttonPostsRemoveRevision', '$WPCLEANFIX_POSTS->removeRevision();', 'posts-revision', true );
    wp_cleanfix_ajax_command('buttonPostRevisionRefresh', '$WPCLEANFIX_POSTS->checkRevisions();', 'posts-revision' );

	// -----------------------------------------------------------------------------------------------------------------
    // Post Trash
	// -----------------------------------------------------------------------------------------------------------------
    wp_cleanfix_ajax_command('buttonPostsRemoveTrash', '$WPCLEANFIX_POSTS->removeTrash();', 'posts-trash', true );
    wp_cleanfix_ajax_command('buttonPostTrashRefresh', '$WPCLEANFIX_POSTS->checkTrash();', 'posts-trash' );

	// -----------------------------------------------------------------------------------------------------------------
    // Post Meta
	// -----------------------------------------------------------------------------------------------------------------
    wp_cleanfix_ajax_command('buttonPostsRemoveMeta', '$WPCLEANFIX_POSTS->removePostMeta();', 'posts-meta', true );
    wp_cleanfix_ajax_command('buttonPostMetaRefresh', '$WPCLEANFIX_POSTS->checkPostMeta();', 'posts-meta' );

	// -----------------------------------------------------------------------------------------------------------------
    // Post Meta Edit Lock
	// -----------------------------------------------------------------------------------------------------------------
    wp_cleanfix_ajax_command('buttonPostsRemoveMetaEditLock', '$WPCLEANFIX_POSTS->removePostMetaEditLock();', 'posts-editlock', true );
    wp_cleanfix_ajax_command('buttonPostMetaEditLockRefresh', '$WPCLEANFIX_POSTS->checkPostMetaEditLock();', 'posts-editlock' );

	// -----------------------------------------------------------------------------------------------------------------
    // Post Tags
	// -----------------------------------------------------------------------------------------------------------------
    wp_cleanfix_ajax_command('buttonPostsRemoveTag', '$WPCLEANFIX_POSTS->removeTags();', 'posts-tags', true );
    wp_cleanfix_ajax_command('buttonPostTagsRefresh', '$WPCLEANFIX_POSTS->checkTags();', 'posts-tags' );

	// -----------------------------------------------------------------------------------------------------------------
    // Posts Users
    // @todo: da fare
    wp_cleanfix_ajax_command('buttonpostUsersRemoveUnlink', '$WPCLEANFIX_POSTS->removePostsUsers();', 'posts-users', true );
    wp_cleanfix_ajax_command('buttonpostUsersLinkToAuthor', '$WPCLEANFIX_POSTS->relinkPostsUsers();', 'posts-users', true,
        function() {
            return {
                wpcleanfix_post_author_id: $('select#wpcleanfix_post_author_id option:selected').val(),
                wpcleanfix_post_ids: $('input#wpcleanfix_post_ids').val()
            };
        }
    );

    wp_cleanfix_ajax_command('buttonPostsUsersRefresh', '$WPCLEANFIX_POSTS->checkPostsUsers();', 'posts-users' );

	// -----------------------------------------------------------------------------------------------------------------
    // Pages Users
    // @todo: da fare
    wp_cleanfix_ajax_command('buttonpageUsersRemoveUnlink', '$WPCLEANFIX_POSTS->removePostsUsers(page);', 'pages-users', true );
    wp_cleanfix_ajax_command('buttonpageUsersLinkToAuthor', '$WPCLEANFIX_POSTS->relinkPostsUsers(page);', 'pages-users', true,
        function() {
            return {
                wpcleanfix_page_author_id: $('select#wpcleanfix_page_author_id option:selected').val(),
                wpcleanfix_page_ids: $('input#wpcleanfix_page_ids').val()
            };
        }
    );

    wp_cleanfix_ajax_command('buttonPagesUsersRefresh', "$WPCLEANFIX_POSTS->checkPostsUsers(null, true, page);", 'pages-users' );

	// -----------------------------------------------------------------------------------------------------------------
    // Attachment unlink to Post
    // @todo: da fare
    wp_cleanfix_ajax_command('buttonAttachementsRemoveUnlink', '$WPCLEANFIX_POSTS->removeAttachment();', 'attachment-post', true );
    wp_cleanfix_ajax_command('buttonAttachmentsRefresh', '$WPCLEANFIX_POSTS->checkAttachment();', 'attachment-post' );

	// -----------------------------------------------------------------------------------------------------------------
    // Find & Replace Post Content
    wp_cleanfix_ajax_command('buttonFindReplacePost', '$WPCLEANFIX_POSTS->findAndReplace();', 'find-replace-post-content', true,
        function() {
            return {
                wpcleanfix_find_post_content: $('input#wpcleanfix_find_post_content').val(),
                wpcleanfix_replace_post_content: $('input#wpcleanfix_replace_post_content').val()
            };
        }
    );

	// -----------------------------------------------------------------------------------------------------------------
    // Categories
	// -----------------------------------------------------------------------------------------------------------------
    wp_cleanfix_refresh_all('buttonCategoryRefreshAll',
        ['buttonCategoryUnusedRefresh',
          'buttonTermsUnlinkRefresh',
          'buttonTermTaxonomyUnlinkRefresh'
        ] );

	// -----------------------------------------------------------------------------------------------------------------
    // Category unused
    wp_cleanfix_ajax_command('buttonCategoryRemoveUnsed', '$WPCLEANFIX_CATEGORY->removeCategory();', 'category-unused', true );
    wp_cleanfix_ajax_command('buttonCategoryUnusedRefresh', '$WPCLEANFIX_CATEGORY->checkCategory();', 'category-unused' );

    // Category Terms unlink
    wp_cleanfix_ajax_command('buttonTermsUnlinkRemove', '$WPCLEANFIX_CATEGORY->removeTermInTaxonomy();', 'terms-unlink', true );
    wp_cleanfix_ajax_command('buttonTermsUnlinkRefresh', '$WPCLEANFIX_CATEGORY->checkTermInTaxonomy();', 'terms-unlink' );

    // Category TermTaxonomy unlink
    wp_cleanfix_ajax_command('buttonTermTaxonomyUnlinkRemove', '$WPCLEANFIX_CATEGORY->removeTaxonomyInTerm();', 'termtaxonomy-unlink', true );
    wp_cleanfix_ajax_command('buttonTermTaxonomyUnlinkRefresh', '$WPCLEANFIX_CATEGORY->checkTaxonomyInTerm();', 'termtaxonomy-unlink' );


	// -----------------------------------------------------------------------------------------------------------------
    // Comments
	// -----------------------------------------------------------------------------------------------------------------

    wp_cleanfix_refresh_all('buttonCommentsRefreshAll',
        ['buttonCommentUnapprovedCommentRefresh',
		  'buttonCommentTrashCommentRefresh',
          'buttonCommentSpamRefresh'
        ] );

    // Unapproved Comments
    wp_cleanfix_ajax_command('buttonCommentsRemoveUnapproved', '$WPCLEANFIX_COMMENTS->removeComments();', 'comments-unapproved', true );
    wp_cleanfix_ajax_command('buttonCommentUnapprovedCommentRefresh', '$WPCLEANFIX_COMMENTS->checkComments();', 'comments-unapproved' );

	// Comments in Trash
	wp_cleanfix_ajax_command('buttonCommentsRemoveTrash', '$WPCLEANFIX_COMMENTS->removeTrash();', 'comments-trash', true );
	wp_cleanfix_ajax_command('buttonCommentTrashCommentRefresh', '$WPCLEANFIX_COMMENTS->checkTrash();', 'comments-trash' );

    // Spam Comments
    wp_cleanfix_ajax_command('buttonCommentsRemoveSPAM', '$WPCLEANFIX_COMMENTS->removeSpam();', 'comments-spam', true );
    wp_cleanfix_ajax_command('buttonCommentSpamRefresh', '$WPCLEANFIX_COMMENTS->checkSpam();', 'comments-spam' );

    // Find & Replace Comment Content
    wp_cleanfix_ajax_command('buttonFindReplaceComment', '$WPCLEANFIX_COMMENTS->findAndReplace();', 'find-replace-comment-content', true,
        function() {
            return {wpcleanfix_find_comment_content: $('input#wpcleanfix_find_comment_content').val(),
            wpcleanfix_replace_comment_content: $('input#wpcleanfix_replace_comment_content').val()};
        }
    );
});