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
        var pd = { command: command };
        
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
                if(cc) {
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
                        wp_cleanfix_check_optimize();
                    }
                );
            }
        );
    }


    function wp_cleanfix_check_optimize() {
        jQuery.post( wpCleanFixMainL10n.ajaxURL, {
                command : 'wpcleanfix_database_show_tables_optimize'
            },
            function( data ) {
                jQuery('div#database-optimize').html( data );
            }
        );
    }

    // ------------------------------------------------------------------------------------------------------------------------------------------------------------
    //
    // Database
    wp_cleanfix_ajax_command('buttonDatabaseOptimize', 'wpcleanfix_database_optimize', 'database-optimize', true );
    wp_cleanfix_ajax_command('buttonDatabaseOptimizeTableRefresh', 'wpcleanfix_database_show_tables_optimize', 'database-optimize' );


    // ------------------------------------------------------------------------------------------------------------------------------------------------------------
    //
    // UsersMeta
    wp_cleanfix_ajax_command('buttonUserMetaRemoveUnlink', 'wpcleanfix_remove_usermeta_unlink', 'usersmeta-unused', true );
    wp_cleanfix_ajax_command('buttonUserMetaUnusedRefresh', 'wpcleanfix_show_usersmeta_unlink', 'usersmeta-unused' );


    // ------------------------------------------------------------------------------------------------------------------------------------------------------------
    //
    // Post Revision
    wp_cleanfix_ajax_command('buttonPostsRemoveRevision', 'wpcleanfix_posts_remove_revision', 'posts-revision', true );
    wp_cleanfix_ajax_command('buttonPostRevisionRefresh', 'wpcleanfix_posts_show_posts_revision', 'posts-revision' );

    // Post Meta
    wp_cleanfix_ajax_command('buttonPostsRemoveMeta', 'wpcleanfix_posts_remove_unused_post_meta', 'posts-meta', true );
    wp_cleanfix_ajax_command('buttonPostMetaRefresh', 'wpcleanfix_posts_show_unused_post_meta', 'posts-meta' );

    // Post Tag
    wp_cleanfix_ajax_command('buttonPostsRemoveTag', 'wpcleanfix_posts_remove_tag', 'posts-tags', true );
    wp_cleanfix_ajax_command('buttonPostTagsRefresh', 'wpcleanfix_posts_show_unused_tag', 'posts-tags' );

    // Posts Users
    // @todo: da fare
    wp_cleanfix_ajax_command('buttonPostsUsersRemoveUnlink', '', 'posts-users', true );
    wp_cleanfix_ajax_command('buttonPostsUsersLinkToAuthor', '', 'posts-users', true );
    wp_cleanfix_ajax_command('buttonPostsUsersRefresh', 'wpcleanfix_posts_show_postsusers_unlink', 'posts-users' );

    // Pages Users
    // @todo: da fare
    wp_cleanfix_ajax_command('buttonPagesUsersRemoveUnlink', '', 'pages-users', true );
    wp_cleanfix_ajax_command('buttonPagesUsersLinkToAuthor', '', 'pages-users', true );
    wp_cleanfix_ajax_command('buttonPagesUsersRefresh', 'wpcleanfix_posts_show_pagesusers_unlink', 'pages-users' );

    // Attachment unlink to Post
    // @todo: da fare
    wp_cleanfix_ajax_command('buttonAttachementsRemoveUnlink', '', 'attachment-post', true );
    wp_cleanfix_ajax_command('buttonAttachmentsRefresh', 'wpcleanfix_posts_show_attachment_unlink', 'attachment-post' );

    // Find & Replace Post Content
    wp_cleanfix_ajax_command('buttonFindReplacePost', 'wpcleanfix_replace_post_content', 'find-replace-post-content', true,
            function() {
                return { wpcleanfix_find_post_content: jQuery('input#wpcleanfix_find_post_content').val(),
                wpcleanfix_replace_post_content: jQuery('input#wpcleanfix_replace_post_content').val() };
            }
        );


    // ------------------------------------------------------------------------------------------------------------------------------------------------------------
    //
    // Category unused
    wp_cleanfix_ajax_command('buttonCategoryRemoveUnsed', 'wpcleanfix_category_remove_unsed', 'category-unused', true );
    wp_cleanfix_ajax_command('buttonCategoryUnusedRefresh', 'wpcleanfix_category_show_unused', 'category-unused' );

    // Category Terms unlink
    wp_cleanfix_ajax_command('buttonTermsUnlinkRemove', 'wpcleanfix_category_remove_unsed', 'category-unused', true );
    wp_cleanfix_ajax_command('buttonTermsUnlinkRefresh', 'wpcleanfix_terms_show_unlink_to_taxonomy', 'terms-unlink' );

    // Category TermTaxonomy unlink
    wp_cleanfix_ajax_command('buttonTermsUnlinkRemove', 'wpcleanfix_category_remove_unsed', 'category-unused', true );
    wp_cleanfix_ajax_command('buttonTermTaxonomyUnlinkRefresh', 'wpcleanfix_termtaxonomy_show_unlink_to_terms', 'termtaxonomy-unlink' );


    // ------------------------------------------------------------------------------------------------------------------------------------------------------------
    //
    // Unapproved Comments
    wp_cleanfix_ajax_command('buttonCommentsRemoveUnapproved', 'wpcleanfix_comments_delete_unapproved_comment', 'comments-unapproved', true );
    wp_cleanfix_ajax_command('buttonCommentUnapprovedCommentRefresh', 'wpcleanfix_comments_show_unapproved_comment', 'comments-unapproved' );

    // Spam Comments
    wp_cleanfix_ajax_command('buttonCommentsRemoveSPAM', 'wpcleanfix_comments_delete_spam_comment', 'comments-spam', true );
    wp_cleanfix_ajax_command('buttonCommentSpamRefresh', 'wpcleanfix_comments_show_spam_comment', 'comments-spam' );

    // Find & Replace Comment Content
    wp_cleanfix_ajax_command('buttonFindReplaceComment', 'wpcleanfix_replace_comment_content', 'find-replace-comment-content', true,
            function() {
                return { wpcleanfix_find_comment_content: jQuery('input#wpcleanfix_find_comment_content').val(),
                wpcleanfix_replace_comment_content: jQuery('input#wpcleanfix_replace_comment_content').val() };
            }
        );


});
