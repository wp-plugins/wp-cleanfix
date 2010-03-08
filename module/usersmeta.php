<?php
/**
 * Users management
 *
 * @package         wp-cleanfix
 * @subpackage      info
 * @author          =undo= <g.fazioli@saidmade.com>
 * @copyright       Copyright (C) 2010 Saidmade Srl
 * @version         1.0.0
 */

/**
 * Check for unlink from users and usermeta
 */
function wpcleanfix_show_usersmeta_unlink($mes = null) {
    global $wpdb;

    $sql = "SELECT * FROM $wpdb->usermeta wpum LEFT JOIN $wpdb->users wpu ON wpu.ID = wpum.user_id WHERE wpu.ID IS NULL";
    $usersmeta = $wpdb->get_results( $sql );
    if( count($usersmeta) > 0 ) {
        echo '<span class="wpcleanfix-warning">' . count($usersmeta) . ' '. __('unused User Meta:', 'wp-cleanfix') . '</span> <select>';
        foreach($usersmeta as $row) {
            echo '<option>'. $row->meta_key . ' [' . substr( strip_tags( $row->meta_value ), 0, 32 ) . ']</option>';
        }
        echo '</select> <button id="buttonUserMetaRemoveUnlink">' . __('Erase!', 'wp-cleanfix') . '</button>';
    } else {
        if(is_null($mes) ) {
            echo '<span class="wpcleanfix-ok">' . __('no unused User Meta','wp-cleanfix') . '</span>';
        } else {
           printf( '<span class="wpcleanfix-cleaned">' . __('%s - User Meta erased','wp-cleanfix') .  '</span>', $mes );
        }
    }
}

function wpcleanfix_remove_usermeta_unlink() {
    global $wpdb;

    $sql = "DELETE wpum FROM $wpdb->usermeta wpum LEFT JOIN $wpdb->users wpu ON wpu.ID = wpum.user_id WHERE wpu.ID IS NULL";
    $mes = $wpdb->query( $sql );
    wpcleanfix_show_usersmeta_unlink( $mes );
}

// SELECT * FROM wp_1_posts wpp LEFT JOIN wp_users wpu ON wpu.ID = wpp.post_author WHERE wpu.ID IS NULL

// SELECT * FROM wp_usermeta wpum LEFT JOIN wp_users wpu ON wpu.ID = wpum.user_id WHERE wpu.ID IS NULL


?>
