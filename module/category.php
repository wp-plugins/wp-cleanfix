<?php
/**
 * Category management
 *
 * @package         wp-cleanfix
 * @subpackage      info
 * @author          =undo= <g.fazioli@saidmade.com>
 * @copyright       Copyright (C) 2010 Saidmade Srl
 * @version         1.0.0
 */

/**
 * Check for unsed category
 */
function wpcleanfix_category_show_unused($mes = null) {
    global $wpdb;

    $sql = "SELECT x.count AS howmany, t.name AS name FROM $wpdb->terms AS t, $wpdb->term_taxonomy AS x WHERE t.term_id = x.term_id AND x.taxonomy='category' AND x.count = 0 ORDER BY x.count";
    $categories = $wpdb->get_results( $sql );
    if( count($categories) > 0 ) {
        echo '<span class="wpcleanfix-warning">' . count($categories) . ' '. __('Categorie non utilizzate:', 'wp-cleanfix') . '</span> <select>';
        foreach($categories as $row) {
            echo '<option>'. $row->name . '</option>';
        }
        echo '</select> <button id="buttonCategoryRemoveUnsed">' . __('Rimuovi!', 'wp-cleanfix') . '</button>';
    } else {
        if(is_null($mes) ) {
            echo '<span class="wpcleanfix-ok">' . __('Nessuna Categoria risulta non utilizzata','wp-cleanfix') . '</span>';
        } else {
           printf( '<span class="wpcleanfix-cleaned">' . __('%s - Categorie eliminate','wp-cleanfix') .  '</span>', $mes );
        }
    }
}

function wpcleanfix_category_remove_unsed() {
    global $wpdb;

    $sql = "DELETE t, x FROM $wpdb->terms AS t, $wpdb->term_taxonomy AS x WHERE t.term_id = x.term_id AND x.taxonomy='category' AND x.count = 0";
    $mes = $wpdb->query( $sql );

    $sql = "SELECT * FROM `$wpdb->term_relationships` WHERE `term_taxonomy_id` IN(SELECT term_taxonomy_id FROM $wpdb->terms AS t, $wpdb->term_taxonomy AS x WHERE t.term_id = x.term_id AND x.count = 0 AND taxonomy = 'category' ORDER BY x.count)";
    $res = $wpdb->get_results( $sql );
    if(count($res) > 0) {
        $sql = "DELETE FROM `$wpdb->term_relationships` WHERE `term_taxonomy_id` IN(SELECT term_taxonomy_id FROM $wpdb->terms AS t, $wpdb->term_taxonomy AS x WHERE t.term_id = x.term_id AND x.count = 0 AND taxonomy = 'category' ORDER BY x.count)";
        $res = $wpdb->query( $sql );
        $mes .= ' ' . __('eliminate anche releazioni esterne aggiuntive');
    }
    wpcleanfix_category_show_unused( $mes );
}

// Questa Select ritorna tutti i term_id della tabella wp_terms che NON si trovano in wp_term_taxonomy
//
// SELECT a.term_id FROM `wp_1_terms` AS a WHERE 1 AND NOT EXISTS(SELECT * FROM wp_1_term_taxonomy b WHERE b.term_id=a.term_id )

function wpcleanfix_terms_show_unlink_to_taxonomy($mes = null) {
    global $wpdb;

    $sql = "SELECT * FROM `$wpdb->terms` AS a WHERE 1 AND NOT EXISTS (SELECT * FROM `$wpdb->term_taxonomy` b WHERE b.term_id = a.term_id )";
    $check = $wpdb->get_results( $sql );
    if( count($check) > 0 ) {
        echo '<span class="wpcleanfix-warning">' . count($check) . ' '. __('Incongruenze trovate:', 'wp-cleanfix') . '</span> <select>';
        foreach($check as $row) {
            echo '<option>'. $row->name . '</option>';
        }
        echo '</select> <!-- <button id="buttonTermsRemoveUnlink">' . __('Rimuovi!', 'wp-cleanfix') . '</button> -->';
    } else {
        if(is_null($mes) ) {
            echo '<span class="wpcleanfix-ok">' . __('Nessuna incongruenza trovata','wp-cleanfix') . '</span>';
        } else {
           printf( '<span class="wpcleanfix-cleaned">' . __('%s - Incongruenze eliminate','wp-cleanfix') .  '</span>', $mes );
        }
    }
}

// Questa, invece, controlla che non ci siano defunti: cioè term_id presenti in term_taxonomy ma mancanti in wp_terms
// SELECT a.term_id FROM `wp_1_term_taxonomy` AS a WHERE 1 AND NOT EXISTS(SELECT * FROM wp_1_terms b WHERE b.term_id=a.term_id )

function wpcleanfix_termtaxonomy_show_unlink_to_terms($mes = null) {
    global $wpdb;

    $sql = "SELECT * FROM `$wpdb->term_taxonomy` AS a WHERE 1 AND NOT EXISTS (SELECT * FROM `$wpdb->terms` b WHERE b.term_id = a.term_id )";
    $check = $wpdb->get_results( $sql );
    if( count($check) > 0 ) {
        $warning = 0;
        echo '<span class="wpcleanfix-warning">' . count($check) . ' '. __('Incongruenze trovate', 'wp-cleanfix') . '</span>';
        foreach($check as $row) {
            if($row->count > 0) $warning++;
        }
    } else {
        if(is_null($mes) ) {
            echo '<span class="wpcleanfix-ok">' . __('Nessuna incongruenza trovata','wp-cleanfix') . '</span>';
        } else {
           printf( '<span class="wpcleanfix-cleaned">' . __('%s - Incongruenze eliminate','wp-cleanfix') .  '</span>', $mes );
        }
    }
}


?>
