/**
 * Javascript functions
 *
 * @package         wp-bannerize
 * @subpackage      main.js
 * @author          =undo= <g.fazioli@saidmade.com>
 * @copyright       Copyright (C) 2010 Saidmade Srl
 * @version         1.0.0
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
        jQuery('button#' + button).live('click',
            function() {
                if(cc) {
                     if(!confirm(wpCleanFixMainL10n.messageConfirm)) {
                         return;
                     }
                }
                wp_cleanfix_ajax_wait(id);
                jQuery.post( wpCleanFixMainL10n.ajaxURL, {
                        command : command
                    },
                    function( data ) {
                        jQuery('div#' + id).html( data );
                    }
                );
            }
        );
    }

    // Database
    wp_cleanfix_ajax_command('buttonDatabaseOptimize', 'wpcleanfix_database_optimize', 'database-optimize', true );
    wp_cleanfix_ajax_command('buttonDatabaseOptimizeTableRefresh', 'wpcleanfix_database_show_tables_optimize', 'database-optimize' );

    // Post Revision
    wp_cleanfix_ajax_command('buttonPostsRemoveRevision', 'wpcleanfix_posts_remove_revision', 'posts-revision', true );
    wp_cleanfix_ajax_command('buttonPostRevisionRefresh', 'wpcleanfix_posts_show_posts_revision', 'posts-revision' );

    // Post Tag
    wp_cleanfix_ajax_command('buttonPostsRemoveTag', 'wpcleanfix_posts_remove_tag', 'posts-tags', true );
    wp_cleanfix_ajax_command('buttonPostTagsRefresh', 'wpcleanfix_posts_show_unused_tag', 'posts-tags' );

    // Post Meta
    wp_cleanfix_ajax_command('buttonPostMetaRefresh', 'wpcleanfix_posts_show_unused_post_meta', 'posts-meta' );


    // Category unused
    wp_cleanfix_ajax_command('buttonCategoryRemoveUnsed', 'wpcleanfix_category_remove_unsed', 'category-unused', true );
    wp_cleanfix_ajax_command('buttonCategoryUnusedRefresh', 'wpcleanfix_category_show_unused', 'category-unused' );


    // Unapproved Comments
    wp_cleanfix_ajax_command('buttonCommentsRemoveUnapproved', 'wpcleanfix_comments_delete_unapproved_comment', 'comments-unapproved', true );
    wp_cleanfix_ajax_command('buttonCommentUnapprovedCommentRefresh', 'wpcleanfix_comments_show_unapproved_comment', 'comments-unapproved' );

    // Spam Comments
    wp_cleanfix_ajax_command('buttonCommentsRemoveSPAM', 'wpcleanfix_comments_delete_spam_comment', 'comments-spam', true );
    wp_cleanfix_ajax_command('buttonCommentSpamRefresh', 'wpcleanfix_comments_show_spam_comment', 'comments-spam' );


});
