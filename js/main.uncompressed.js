/**
 * Javascript functions
 *
 * @package         wp-cleanfix
 * @subpackage      main.js
 * @author          =undo= <g.fazioli@saidmade.com>
 * @copyright       Copyright (C) 2010 Saidmade Srl
 *
 */
jQuery(document).ready(function() {

    /**
     * Mostra l'animazione gif per attesa ajax
     *
     * @since 0.1.1
     * @var string id del contenitore
     */
    function wp_cleanfix_ajax_wait(id) {
        jQuery('div#' + id).html( '<div id="ajax-wait"></div>' );
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
        var pd = {command: command};
        
        if( !( arguments[4] == undefined ) ) {
            var callBack = arguments[4];
        }

        jQuery('button#' + button).live('click',
            function() {
                // @since 0.3.0
                if(uu) {
                    alert(wpCleanFixMainL10n.notImplement);
                    return;
                }
                if(cc && id != 'database-optimize') {
                     if(!confirm(wpCleanFixMainL10n.messageConfirm)) {
                         return;
                     }
                }
                if(callBack != undefined) {
                    var no = callBack();
                    no.command = pd.command;
                    pd = no;
                }
                wp_cleanfix_ajax_wait(id);
                jQuery.post( wpCleanFixMainL10n.ajaxURL, pd,
                    function( data ) {
                        jQuery('div#' + id).html( data );
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
        jQuery.post( wpCleanFixMainL10n.ajaxURL, {
                command : '$WPCLEANFIX_DATABASE->checkTables();'
            },
            function( data ) {
                jQuery('div#database-optimize').html( data );
            }
        );
    }

    /**
     * Register refresh button id for refresh all
     */
    function wp_cleanfix_refresh_all(button_id, button_ids) {
        jQuery('button#' + button_id).click(function(){
            for(var i = 0; i < button_ids.length; i++) {
                jQuery('button#' + button_ids[i]).click();
            }
        });
    }

    // ------------------------------------------------------------------------------------------------------------------------------------------------------------
    //
    // Database
    wp_cleanfix_ajax_command('buttonDatabaseOptimize', '$WPCLEANFIX_DATABASE->optimize();', 'database-optimize', true );
    wp_cleanfix_ajax_command('buttonDatabaseOptimizeTableRefresh', '$WPCLEANFIX_DATABASE->checkTables();', 'database-optimize' );


    // -------------------------------------------------------------------------
    // UserMeta
    // -------------------------------------------------------------------------

    // User Meta
    wp_cleanfix_ajax_command('buttonUserMetaRemoveUnlink', '$WPCLEANFIX_USERMETA->removeUserMeta();', 'usersmeta-unused', true );
    wp_cleanfix_ajax_command('buttonUserMetaUnusedRefresh', '$WPCLEANFIX_USERMETA->checkUserMeta();', 'usersmeta-unused' );


    // -------------------------------------------------------------------------
    // Posts
    // -------------------------------------------------------------------------

    wp_cleanfix_refresh_all('buttonPostsRefreshAll',
        ['buttonPostRevisionRefresh',
          'buttonPostMetaRefresh',
          'buttonPostTagsRefresh',
          'buttonPostsUsersRefresh',
          'buttonPagesUsersRefresh',
          'buttonAttachmentsRefresh'
        ] );

    // Post Revision
    wp_cleanfix_ajax_command('buttonPostsRemoveRevision', '$WPCLEANFIX_POSTS->removeRevision();', 'posts-revision', true );
    wp_cleanfix_ajax_command('buttonPostRevisionRefresh', '$WPCLEANFIX_POSTS->checkRevisions();', 'posts-revision' );

    // Post Meta
    wp_cleanfix_ajax_command('buttonPostsRemoveMeta', '$WPCLEANFIX_POSTS->removePostMeta();', 'posts-meta', true );
    wp_cleanfix_ajax_command('buttonPostMetaRefresh', '$WPCLEANFIX_POSTS->checkPostMeta();', 'posts-meta' );

    // Post Tags
    wp_cleanfix_ajax_command('buttonPostsRemoveTag', '$WPCLEANFIX_POSTS->removeTags();', 'posts-tags', true );
    wp_cleanfix_ajax_command('buttonPostTagsRefresh', '$WPCLEANFIX_POSTS->checkTags();', 'posts-tags' );

    // Posts Users
    // @todo: da fare
    wp_cleanfix_ajax_command('buttonpostUsersRemoveUnlink', '$WPCLEANFIX_POSTS->removePostsUsers();', 'posts-users', true );
    wp_cleanfix_ajax_command('buttonpostUsersLinkToAuthor', '$WPCLEANFIX_POSTS->relinkPostsUsers();', 'posts-users', true,
        function() {
            return {
                wpcleanfix_post_author_id: jQuery('select#wpcleanfix_post_author_id option:selected').val(),
                wpcleanfix_post_ids: jQuery('input#wpcleanfix_post_ids').val()
            };
        }    
    );

    wp_cleanfix_ajax_command('buttonPostsUsersRefresh', '$WPCLEANFIX_POSTS->checkPostsUsers();', 'posts-users' );

    // Pages Users
    // @todo: da fare
    wp_cleanfix_ajax_command('buttonpageUsersRemoveUnlink', '$WPCLEANFIX_POSTS->removePostsUsers(page);', 'pages-users', true );
    wp_cleanfix_ajax_command('buttonpageUsersLinkToAuthor', '$WPCLEANFIX_POSTS->relinkPostsUsers(page);', 'pages-users', true,
        function() {
            return {
                wpcleanfix_page_author_id: jQuery('select#wpcleanfix_page_author_id option:selected').val(),
                wpcleanfix_page_ids: jQuery('input#wpcleanfix_page_ids').val()
            };
        }
    );

    wp_cleanfix_ajax_command('buttonPagesUsersRefresh', "$WPCLEANFIX_POSTS->checkPostsUsers(null, true, page);", 'pages-users' );

    // Attachment unlink to Post
    // @todo: da fare
    wp_cleanfix_ajax_command('buttonAttachementsRemoveUnlink', '$WPCLEANFIX_POSTS->removeAttachment();', 'attachment-post', true );
    wp_cleanfix_ajax_command('buttonAttachmentsRefresh', '$WPCLEANFIX_POSTS->checkAttachment();', 'attachment-post' );

    // Find & Replace Post Content
    wp_cleanfix_ajax_command('buttonFindReplacePost', '$WPCLEANFIX_POSTS->fintAndReplace();', 'find-replace-post-content', true,
        function() {
            return {
                wpcleanfix_find_post_content: jQuery('input#wpcleanfix_find_post_content').val(),
                wpcleanfix_replace_post_content: jQuery('input#wpcleanfix_replace_post_content').val()
            };
        }
    );

    // -------------------------------------------------------------------------
    // Categories
    // -------------------------------------------------------------------------

    wp_cleanfix_refresh_all('buttonCategoryRefreshAll',
        ['buttonCategoryUnusedRefresh',
          'buttonTermsUnlinkRefresh',
          'buttonTermTaxonomyUnlinkRefresh'
        ] );

    // Category unused
    wp_cleanfix_ajax_command('buttonCategoryRemoveUnsed', '$WPCLEANFIX_CATEGORY->removeCategory();', 'category-unused', true );
    wp_cleanfix_ajax_command('buttonCategoryUnusedRefresh', '$WPCLEANFIX_CATEGORY->checkCategory();', 'category-unused' );

    // Category Terms unlink
    wp_cleanfix_ajax_command('buttonTermsUnlinkRemove', '$WPCLEANFIX_CATEGORY->removeTermInTaxonomy();', 'terms-unlink', true );
    wp_cleanfix_ajax_command('buttonTermsUnlinkRefresh', '$WPCLEANFIX_CATEGORY->checkTermInTaxonomy();', 'terms-unlink' );

    // Category TermTaxonomy unlink
    wp_cleanfix_ajax_command('buttonTermTaxonomyUnlinkRemove', '$WPCLEANFIX_CATEGORY->removeTaxonomyInTerm();', 'termtaxonomy-unlink', true );
    wp_cleanfix_ajax_command('buttonTermTaxonomyUnlinkRefresh', '$WPCLEANFIX_CATEGORY->checkTaxonomyInTerm();', 'termtaxonomy-unlink' );


    // -------------------------------------------------------------------------
    // Comments
    // -------------------------------------------------------------------------

    wp_cleanfix_refresh_all('buttonCommentsRefreshAll',
        ['buttonCommentUnapprovedCommentRefresh',
          'buttonCommentSpamRefresh'
        ] );

    // Unapproved Comments
    wp_cleanfix_ajax_command('buttonCommentsRemoveUnapproved', '$WPCLEANFIX_COMMENTS->removeComments();', 'comments-unapproved', true );
    wp_cleanfix_ajax_command('buttonCommentUnapprovedCommentRefresh', '$WPCLEANFIX_COMMENTS->checkComments();', 'comments-unapproved' );

    // Spam Comments
    wp_cleanfix_ajax_command('buttonCommentsRemoveSPAM', '$WPCLEANFIX_COMMENTS->removeSpam();', 'comments-spam', true );
    wp_cleanfix_ajax_command('buttonCommentSpamRefresh', '$WPCLEANFIX_COMMENTS->checkSpam();', 'comments-spam' );

    // Find & Replace Comment Content
    wp_cleanfix_ajax_command('buttonFindReplaceComment', '$WPCLEANFIX_COMMENTS->findAndReplace();', 'find-replace-comment-content', true,
        function() {
            return {wpcleanfix_find_comment_content: jQuery('input#wpcleanfix_find_comment_content').val(),
            wpcleanfix_replace_comment_content: jQuery('input#wpcleanfix_replace_comment_content').val()};
        }
    );
});