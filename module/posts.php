<?php
/**
 * Posts management
 *
 * @package         wp-cleanfix
 * @subpackage      info
 * @author          =undo= <g.fazioli@saidmade.com>
 * @copyright       Copyright (C) 2010 Saidmade Srl
 * @version         1.0.0
 */

/**
 * Check for posts revisions
 */
function wpcleanfix_posts_show_posts_revision($mes = null) {
    global $wpdb;

    $sql = "SELECT COUNT(*) FROM $wpdb->posts WHERE post_type = 'revision'";
    $revisions = $wpdb->get_var( $sql );
    if(!$revisions == 0 || !$revisions == NULL) : ?>
        <span class="wpcleanfix-warning"><?php printf(__('%s Revisioni, vuoi eliminarle?', 'wp-cleanfix'), $revisions ) ?></span>
        <button id="buttonPostsRemoveRevision"><?php _e('Rimuovi Revisioni!', 'wp-cleanfix') ?></button>
    <?php else : ?>
        <?php if(is_null($mes)) : ?>
            <span class="wpcleanfix-ok"><?php _e('Nessun post in revisione','wp-cleanfix'); ?></span>
        <?php else : ?>
            <span class="wpcleanfix-cleaned"><?php printf( __('%s - revisioni di post eliminate','wp-cleanfix'), $mes ); ?></span>
        <?php endif; ?>
    <?php endif;
}

function wpcleanfix_posts_remove_revision() {
    global $wpdb;

    $sql = "DELETE a,b,c FROM $wpdb->posts a LEFT JOIN $wpdb->term_relationships b ON (a.ID = b.object_id) LEFT JOIN $wpdb->postmeta c ON (a.ID = c.post_id) WHERE a.post_type = 'revision'";
    $mes = $wpdb->query( $sql );
    wpcleanfix_posts_show_posts_revision( $mes );
}


function wpcleanfix_posts_show_unused_post_meta( $mes = null ) {
    global $wpdb;

    $sql = "SELECT * FROM $wpdb->postmeta pm LEFT JOIN $wpdb->posts wp ON wp.ID = pm.post_id WHERE wp.ID IS NULL;";
    $res = $wpdb->get_results($sql);
    if(count($res) > 0 ) : ?>
        <select>
    <?php
        foreach($res as $row) : ?>
            <option><?php //echo $row ?></option>
        <?php endforeach; ?>
    ?></select>  <button id="buttonPostsRemoveMeta"><?php _e('Rimuovi!', 'wp-cleanfix') ?></button>
    <?php else : ?>
        <?php if(is_null($mes)) : ?>
            <span class="wpcleanfix-ok"><?php _e('Nessun Meta Tag risulta inutilizzato','wp-cleanfix'); ?></span>
        <?php else : ?>
            <span class="wpcleanfix-cleaned"><?php printf( __('%s - meta tag eliminati','wp-cleanfix'), $mes ); ?></span>
        <?php endif; ?>
    <?php endif;
}


function wpcleanfix_posts_show_unused_tag( $mes = null ) {
    global $wpdb;

    $sql = "SELECT * FROM $wpdb->terms wt INNER JOIN $wpdb->term_taxonomy wtt ON wt.term_id = wtt.term_id WHERE wtt.taxonomy='post_tag' AND wtt.count=0;";
    $res = $wpdb->get_results($sql);
   
    if(count($res) > 0 ) : ?>
       <span class="wpcleanfix-warning"><?php printf(__('%s Tag non utilizzati:', 'wp-cleanfix'), count($res) ) ?></span> <select>
    <?php
        foreach($res as $row) : ?>
            <option><?php echo $row->name ?></option>
        <?php endforeach; ?>
    ?></select> <button id="buttonPostsRemoveTag"><?php _e('Rimuovi tutti', 'wp-cleanfix') ?></button>
    <?php else : ?>
        <?php if(is_null($mes)) : ?>
            <span class="wpcleanfix-ok"><?php _e('Nessun Tag risulta inutilizzato','wp-cleanfix'); ?></span>
        <?php else : ?>
            <span class="wpcleanfix-cleaned"><?php printf( __('%s - tag eliminati','wp-cleanfix'), $mes ); ?></span>
        <?php endif; ?>
    <?php endif;
}

function wpcleanfix_posts_remove_tag() {
    global $wpdb;
    $sql = "DELETE a,b,c FROM $wpdb->terms AS a	LEFT JOIN $wpdb->term_taxonomy AS c ON a.term_id = c.term_id LEFT JOIN $wpdb->term_relationships AS b ON b.term_taxonomy_id = c.term_taxonomy_id WHERE (c.taxonomy = 'post_tag' AND	c.count = 0	)";
    $mes = $wpdb->query( $sql );
    wpcleanfix_posts_show_unused_tag( $mes );
}


?>
