<?php
/**
 * Category management
 *
 * @package         wp-cleanfix
 * @subpackage      WPCLEANFIX_CATEGORY
 * @author          =undo= <g.fazioli@saidmade.com>
 * @copyright       Copyright (C) 2010 Saidmade Srl
 * 
 */

class WPCLEANFIX_CATEGORY {

    /**
     * Class version
     *
     * @var string
     */
    var $version    = "1.0.0";

    /**
     * Check unused categories
     *
     * @global <type> $wpdb
     * @param <type> $mes
     * @param <type> $echo
     * @return <type>
     */
    function checkCategory($mes = null, $echo = true) {
        global $wpdb;

        $sql = "SELECT x.count AS howmany, t.name AS name FROM `$wpdb->terms` AS t, `$wpdb->term_taxonomy` AS x WHERE t.term_id = x.term_id AND t.term_id <> 1 AND x.taxonomy='category' AND x.count = 0 ORDER BY x.count";
        $categories = $wpdb->get_results( $sql );
        if($echo) {
            if( count($categories) > 0 ) {
                echo '<span class="wpcleanfix-warning">' . count($categories) . '</span> <select>';
                foreach($categories as $row) {
                    echo '<option>'. $row->name . '</option>';
                }
                echo '</select> <button id="buttonCategoryRemoveUnsed">' . __('Erase!', 'wp-cleanfix') . '</button>';
            } else {
                if(is_null($mes) ) {
                    echo '<span class="wpcleanfix-ok">' . __('None','wp-cleanfix') . '</span>';
                } else {
                   printf( '<span class="wpcleanfix-cleaned">' . __('%s Categories erased','wp-cleanfix') .  '</span>', $mes );
                }
            }
        } else {
            return $categories;
        }
    }
    // Remove
    function removeCategory() {
        global $wpdb;

        $sql = "DELETE t, x FROM `$wpdb->terms` AS t, `$wpdb->term_taxonomy` AS x WHERE t.term_id = x.term_id AND t.term_id <> 1 AND x.taxonomy='category' AND x.count = 0";
        $mes = $wpdb->query( $sql );

        $sql = "SELECT * FROM `$wpdb->term_relationships` WHERE `term_taxonomy_id` IN(SELECT term_taxonomy_id FROM `$wpdb->terms` AS t, `$wpdb->term_taxonomy` AS x WHERE t.term_id = x.term_id AND x.count = 0 AND taxonomy = 'category' ORDER BY x.count)";
        $res = $wpdb->get_results( $sql );
        if(count($res) > 0) {
            $sql = "DELETE FROM `$wpdb->term_relationships` WHERE `term_taxonomy_id` IN(SELECT term_taxonomy_id FROM `$wpdb->terms` AS t, `$wpdb->term_taxonomy` AS x WHERE t.term_id = x.term_id AND x.count = 0 AND taxonomy = 'category' ORDER BY x.count)";
            $res = $wpdb->query( $sql );
            $mes .= ' ' . __('erased external links too');
        }
        $this->checkCategory( $mes );
    }

    /**
     * Check Terms in Taxonomy. Return term_id not present in term_taxonomy
     * Questa Select ritorna tutti i term_id della tabella wp_terms che NON si trovano in wp_term_taxonomy
     *
     * @global <type> $wpdb
     * @param <type> $mes
     * @param <type> $echo
     */
    function checkTermInTaxonomy($mes = null, $echo = true) {
        global $wpdb;

        $sql = "SELECT * FROM `$wpdb->terms` AS a WHERE 1 AND NOT EXISTS (SELECT * FROM `$wpdb->term_taxonomy` b WHERE b.term_id = a.term_id )";
        $check = $wpdb->get_results( $sql );
        if($echo) {
            if( count($check) > 0 ) {
                echo '<span class="wpcleanfix-warning">' . count($check) . '</span> <select>';
                foreach($check as $row) {
                    echo '<option>'. $row->name . '</option>';
                }
                echo '</select> <button id="buttonTermsUnlinkRemove">' . __('Erase!', 'wp-cleanfix') . '</button>';
            } else {
                if(is_null($mes) ) {
                    echo '<span class="wpcleanfix-ok">' . __('None','wp-cleanfix') . '</span>';
                } else {
                   printf( '<span class="wpcleanfix-cleaned">' . __('%s Terms erased','wp-cleanfix') .  '</span>', $mes );
                }
            }
        } else {
            return $check;
        }
    }
    // Remove
    function removeTermInTaxonomy() {
        global $wpdb;

        $sql = "DELETE a FROM `$wpdb->terms` AS a WHERE 1 AND NOT EXISTS (SELECT * FROM `$wpdb->term_taxonomy` b WHERE b.term_id = a.term_id )";
        $mes = $wpdb->query( $sql );
        $this->checkTermInTaxonomy($mes);
    }

    /**
     * Check Taxonomy in Terms. Return term_id not present in terms
     * Questa, invece, controlla che non ci siano defunti: cioè term_id presenti in term_taxonomy ma mancanti in wp_terms
     *
     * @param <type> $mes
     * @param <type> $echo
     */
    function checkTaxonomyInTerm($mes = null, $echo = true) {
        global $wpdb;

        $sql = "SELECT * FROM `$wpdb->term_taxonomy` AS a WHERE 1 AND NOT EXISTS (SELECT * FROM `$wpdb->terms` b WHERE b.term_id = a.term_id )";
        $check = $wpdb->get_results( $sql );
        if($echo) {
            if( count($check) > 0 ) {
                $warning = 0;
                echo '<span class="wpcleanfix-warning">' . count($check) . '</span> <button id="buttonTermTaxonomyUnlinkRemove">' . __('Erase!', 'wp-cleanfix') . '</button>';
                foreach($check as $row) {
                    if($row->count > 0) $warning++;
                }
            } else {
                if(is_null($mes) ) {
                    echo '<span class="wpcleanfix-ok">' . __('None','wp-cleanfix') . '</span>';
                } else {
                   printf( '<span class="wpcleanfix-cleaned">' . __('%s Taxonomy erased','wp-cleanfix') .  '</span>', $mes );
                }
            }
        } else {
            return $check;
        }
    }
    // Remove
    function removeTaxonomyInTerm() {
        global $wpdb;

        $sql = "DELETE a FROM `$wpdb->term_taxonomy` AS a WHERE 1 AND NOT EXISTS (SELECT * FROM `$wpdb->terms` b WHERE b.term_id = a.term_id )";
        $mes = $wpdb->query( $sql );
        $this->checkTaxonomyInTerm($mes);
    }

}

$WPCLEANFIX_CATEGORY = new WPCLEANFIX_CATEGORY();

?>