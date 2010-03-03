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

    $sql = "SELECT * FROM $wpdb->comments WHERE comment_approved = '0';";
    $comments = $wpdb->get_results( $sql );
    if( count($comments) > 0 ) {
        echo '<span class="wpcleanfix-warning">' . count($comments) . __(' commenti non approvati:', 'wp-cleanfix') . '</span> <select>';
        foreach($comments as $row) {
            echo '<option>' . $row->comment_author . ' - [' . substr($row->comment_content, 0, 32) . ']</option>';
        }
        echo '</select> <a href="edit-comments.php?comment_status=moderated">' . __('Controllali singolarmente') . '</a>' . __(', o vuoi eliminarli tutti?', 'wp-cleanfix') . ' <button id="buttonCommentsRemoveUnapproved">' . __('Rimuovi!', 'wp-cleanfix') . '</button>';
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

    $sql = "SELECT * FROM $wpdb->comments WHERE comment_approved = 'spam';";
    $spam = $wpdb->get_results( $sql );
    if( count($spam) > 0 ) {
        echo '<span class="wpcleanfix-warning">' . count($spam) . __(' commenti segnati come spam:', 'wp-cleanfix') . '</span> <select>';
        foreach($spam as $row) {
            echo '<option>' . $row->comment_author . ' - [' . substr($row->comment_content, 0, 32) . ']</option>';
        }
        echo '</select> <a href="edit-comments.php?comment_status=spam">' . __('Controlla SPAM singolarmente') . '</a>' . __(', o vuoi eliminarli tutti?', 'wp-cleanfix') . ' <button id="buttonCommentsRemoveSPAM">' . __('Rimuovi!', 'wp-cleanfix') . '</button>';
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
    wpcleanfix_comments_show_spam_comment( $mes );
}

?>
