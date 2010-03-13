<?php
/**
 * Comments management
 *
 * @package         wp-cleanfix
 * @subpackage      comments
 * @author          =undo= <g.fazioli@saidmade.com>
 * @copyright       Copyright (C) 2010 Saidmade Srl
 * 
 */

/**
 * Check all unapproved comments
 */
function wpcleanfix_comments_show_unapproved_comment($mes = null) {
    global $wpdb;

    $sql = "SELECT * FROM $wpdb->comments WHERE comment_approved = '0';";
    $comments = $wpdb->get_results( $sql );
    if( count($comments) > 0 ) {
        echo '<span class="wpcleanfix-warning">' . count($comments) . __(' unapproved comments', 'wp-cleanfix') . '</span> (' . __('Quick View', 'wp-cleanfix') . '): <select>';
        foreach($comments as $row) {
            echo '<option>' . $row->comment_author . ' - [' . substr(strip_tags($row->comment_content), 0, 32) . ']</option>';
        }
        echo '</select> <a href="edit-comments.php?comment_status=moderated">' . __('Check Them', 'wp-cleanfix') . '</a>' . __(', or Do you want erase them?', 'wp-cleanfix') . ' <button id="buttonCommentsRemoveUnapproved">' . __('Erase!', 'wp-cleanfix') . '</button>';
    } else {
        if(is_null($mes)) : ?>
        <span class="wpcleanfix-ok"><?php _e('No unapproved Comments','wp-cleanfix'); ?></span>
        <?php else : ?>
            <span class="wpcleanfix-cleaned"><?php printf( __('%s - unapproved Comments erased','wp-cleanfix'), $mes ); ?></span>
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
        echo '<span class="wpcleanfix-warning">' . count($spam) . ' ' . __('SPAM Comments:', 'wp-cleanfix') . '</span> (' . __('Quick View', 'wp-cleanfix') . '): <select>';
        foreach($spam as $row) {
            echo '<option>' . $row->comment_author . ' - [' . substr(strip_tags($row->comment_content), 0, 32) . ']</option>';
        }
        echo '</select> <a href="edit-comments.php?comment_status=spam">' . __('Check Them', 'wp-cleanfix') . '</a>' . __(', or Do you want erase them?', 'wp-cleanfix') . ' <button id="buttonCommentsRemoveSPAM">' . __('Erase!', 'wp-cleanfix') . '</button>';
    } else {
        if(is_null($mes)) : ?>
        <span class="wpcleanfix-ok"><?php _e('No SPAM Comments','wp-cleanfix'); ?></span>
        <?php else : ?>
            <span class="wpcleanfix-cleaned"><?php printf( __('%s - SPAM Comments erased','wp-cleanfix'), $mes ); ?></span>
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
