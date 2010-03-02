<?php
/**
 * Comments management
 *
 * @package         wp-cleanfix
 * @subpackage      comments
 * @author          =undo= <g.fazioli@saidmade.com>
 * @copyright       Copyright (C) 2010 Saidmade Srl
 * @version         1.0.0
 */

/**
 * Check all unapproved comments
 */
function wpcleanfix_comments_show_unapproved_comment($mes = null) {
    global $wpdb;

    $sql = "SELECT COUNT(*) FROM $wpdb->comments WHERE comment_approved = '0';";
    $comments = $wpdb->get_var( $sql );
    if(!$comments == 0 || !$comments == NULL) {
        printf( __('Ci sono %s commenti ancora non approvati', 'wp-cleanfix'), $comments );
        ?> <button id="buttonCommentsRemoveUnapproved"><?php _e('Rimuovi Commenti!', 'wp-cleanfix') ?></button><?php
    } else {
        if(is_null($mes)) : ?>
        <span class="wpcleanfix-ok"><?php _e('Nessun commento non approvato','wp-cleanfix'); ?></span>
        <?php else : ?>
            <span class="wpcleanfix-cleaned"><?php printf( __('%s - commenti non approvati eliminati','wp-cleanfix'), $mes ); ?></span>
        <?php endif;
    }
}

function wpcleanfix_comments_delete_unapproved_comment() {
    global $wpdb;

    $sql = "DELETE FROM $wpdb->comments WHERE comment_approved = '0';";
    $mes = $wpdb->query( $sql );
    wpcleanfix_comments_show_unapproved_comment( $mes );
}



function wpcleanfix_comments_show_spam_comment($mes = null) {
    global $wpdb;

    $sql = "SELECT COUNT(*) FROM $wpdb->comments WHERE comment_approved = 'spam';";
    $comments = $wpdb->get_var( $sql );
    if(!$comments == 0 || !$comments == NULL) {
        printf( __('Ci sono %s commenti segnati come SPAM', 'wp-cleanfix'), $comments );
        ?> <button id="buttonCommentsRemoveSPAM"><?php _e('Rimuovi SPAM!', 'wp-cleanfix') ?></button><?php
    } else {
        if(is_null($mes)) : ?>
        <span class="wpcleanfix-ok"><?php _e('Nessun commento SPAM presente','wp-cleanfix'); ?></span>
        <?php else : ?>
            <span class="wpcleanfix-cleaned"><?php printf( __('%s - commenti SPAM eliminati','wp-cleanfix'), $mes ); ?></span>
        <?php endif;
    }
}

function wpcleanfix_comments_delete_spam_comment() {
    global $wpdb;

    $sql = "DELETE FROM $wpdb->comments WHERE comment_approved = 'spam';";
    $mes = $wpdb->query( $sql );
    wpcleanfix_comments_show_posts_revision( $mes );
}

?>
