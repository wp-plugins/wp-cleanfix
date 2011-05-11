<?php
/**
 * Users management
 *
 * @package         wp-cleanfix
 * @subpackage      WPCLEANFIX_USERMETA
 * @author          =undo= <g.fazioli@saidmade.com>
 * @copyright       Copyright (C) 2010 Saidmade Srl
 * 
 */

class WPCLEANFIX_USERMETA {

    /**
     * Class version
     *
     * @var string
     */
    var $version    = "1.0.0";

    function checkUserMeta($mes = null, $echo = true) {
        global $wpdb;

        $sql = "SELECT * FROM `$wpdb->usermeta` wpum LEFT JOIN `$wpdb->users` wpu ON wpu.ID = wpum.user_id WHERE wpu.ID IS NULL";
        $usersmeta = $wpdb->get_results( $sql );
        if($echo) {
            if( count($usersmeta) > 0 ) {
                echo '<span class="wpcleanfix-warning">' . count($usersmeta) . '</span> <select>';
                foreach($usersmeta as $row) {
                    echo '<option>'. $row->meta_key . ' [' . substr( strip_tags( $row->meta_value ), 0, 32 ) . ']</option>';
                }
                echo '</select> <button id="buttonUserMetaRemoveUnlink">' . __('Erase!', 'wp-cleanfix') . '</button>';
            } else {
                if(is_null($mes) ) {
                    echo '<span class="wpcleanfix-ok">' . __('None','wp-cleanfix') . '</span>';
                } else {
                   printf( '<span class="wpcleanfix-cleaned">' . __('%s User Meta erased','wp-cleanfix') .  '</span>', $mes );
                }
            }
        } else {
            return $usermeta;
        }
    }
    // Remove
    function removeUserMeta() {
        global $wpdb;

        $sql = "DELETE wpum FROM `$wpdb->usermeta` wpum LEFT JOIN `$wpdb->users` wpu ON wpu.ID = wpum.user_id WHERE wpu.ID IS NULL";
        $mes = $wpdb->query( $sql );
        $this->checkUserMeta( $mes );
    }
}

$WPCLEANFIX_USERMETA = new WPCLEANFIX_USERMETA();

?>
