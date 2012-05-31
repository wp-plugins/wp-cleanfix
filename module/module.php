<?php
/**
 * Module "super" Class
 *
 * @package         wp-cleanfix
 * @subpackage      WPCLEANFIX_MODULE
 * @author          =undo= <g.fazioli@saidmade.com>
 * @copyright       Copyright (C) 2010 Saidmade Srl
 *
 */

class WPCLEANFIX_MODULE {

    /**
     * Cut a string
     *
     * @param        $s
     * @param int    $l
     * @param string $e
     *
     * @return string
     */
    function cut_string_at( $s, $l = 32, $e = '...' ) {
        if ( strlen( $s ) > absint( $l ) ) {
            return ( substr( $s, 0, $l ) . $e );
        }
        return $s;
    }
}

?>