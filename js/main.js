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

    function wp_cleanfix_ajax_wait(id) {
        jQuery('div#' + id).html( '<div id="ajax-wait"></div>' );
    }

    function wp_cleanfix_ajax_command(button, command, id) {
        jQuery('button#' + button).click(
            function() {
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

    /**
     * Database: optimizza tabelle
     */
    jQuery('button#buttonDatabaseOptimize').click(
        function() {
            if(confirm(wpCleanFixMainL10n.messageConfirm)) {
                jQuery.post( wpCleanFixMainL10n.ajaxURL, {
                        command : 'database-optimize'
                    },
                    function( data ) {
                        //sco_showAjaxLoader( false );
                        jQuery('div#database-optimize').html( data );
                    }
				);
            }
        }
    );

    wp_cleanfix_ajax_command('buttonDatabaseOptimizeTableRefresh', 'wpcleanfix_database_show_tables_optimize', 'database-optimize' );


    /**
     * Posts: remove revision
     */
    jQuery('button#buttonPostsRemoveRevision').click(
        function() {
            if(confirm(wpCleanFixMainL10n.messageConfirm)) {
                jQuery.post( wpCleanFixMainL10n.ajaxURL, {
                        command : 'posts-removerevision'
                    },
                    function( data ) {
                        //sco_showAjaxLoader( false );
                        jQuery('div#posts-revision').html( data );
                    }
				);
            }
        }
    );

    wp_cleanfix_ajax_command('buttonPostRevisionRefresh', 'wpcleanfix_posts_show_posts_revision', 'posts-revision' );
    wp_cleanfix_ajax_command('buttonPostMetaRefresh', 'wpcleanfix_posts_show_unused_post_meta', 'posts-meta' );
    wp_cleanfix_ajax_command('buttonPostTagsRefresh', 'wpcleanfix_posts_show_unused_tag', 'posts-tags' );

    /**
     * Posts: remove unused tag
     */
    jQuery('button#buttonPostsRemoveTag').click(
        function() {
            if(confirm(wpCleanFixMainL10n.messageConfirm)) {
                jQuery.post( wpCleanFixMainL10n.ajaxURL, {
                        command : 'posts-removetag'
                    },
                    function( data ) {
                        //sco_showAjaxLoader( false );
                        jQuery('div#posts-tags').html( data );
                    }
				);
            }
        }
    );

    /**
     * Comments: remove unapproved
     */
    jQuery('button#buttonCommentsRemoveUnapproved').click(
        function() {
            if(confirm(wpCleanFixMainL10n.messageConfirm)) {
                jQuery.post( wpCleanFixMainL10n.ajaxURL, {
                        command : 'comments-removeunapproved'
                    },
                    function( data ) {
                        //sco_showAjaxLoader( false );
                        jQuery('div#comments-unapproved').html( data );
                    }
				);
            }
        }
    );

    wp_cleanfix_ajax_command('buttonCommentUnapprovedCommentRefresh', 'wpcleanfix_comments_show_unapproved_comment', 'comments-unapproved' );
    wp_cleanfix_ajax_command('buttonCommentSpamRefresh', 'wpcleanfix_comments_show_spam_comment', 'comments-spam' );

    /**
     * Comments: remove SPAM
     */
    jQuery('button#buttonCommentsRemoveSPAM').click(
        function() {
            if(confirm(wpCleanFixMainL10n.messageConfirm)) {
                jQuery.post( wpCleanFixMainL10n.ajaxURL, {
                        command : 'comments-removespam'
                    },
                    function( data ) {
                        //sco_showAjaxLoader( false );
                        jQuery('div#comments-spam').html( data );
                    }
				);
            }
        }
    );


});
