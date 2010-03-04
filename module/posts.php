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
        <span class="wpcleanfix-warning"><?php printf(__('%s Revisions, Do you want erase them?', 'wp-cleanfix'), $revisions ) ?></span>
        <button id="buttonPostsRemoveRevision"><?php _e('Erase!', 'wp-cleanfix') ?></button>
    <?php else : ?>
        <?php if(is_null($mes)) : ?>
            <span class="wpcleanfix-ok"><?php _e('No Post Revisions found','wp-cleanfix'); ?></span>
        <?php else : ?>
            <span class="wpcleanfix-cleaned"><?php printf( __('%s - Post Revisions erased','wp-cleanfix'), $mes ); ?></span>
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
        <span class="wpcleanfix-warning"><?php printf(__('%s unused Meta Tag:', 'wp-cleanfix'), count($res) ) ?></span> <select>
    <?php
        foreach($res as $row) : ?>
            <option><?php echo $row->meta_key ?> [<?php echo $row->meta_value ?>]</option>
        <?php endforeach; ?>
    ?></select>  <button id="buttonPostsRemoveMeta"><?php _e('Erase!', 'wp-cleanfix') ?></button>
    <?php else : ?>
        <?php if(is_null($mes)) : ?>
            <span class="wpcleanfix-ok"><?php _e('No unused Meta Tag','wp-cleanfix'); ?></span>
        <?php else : ?>
            <span class="wpcleanfix-cleaned"><?php printf( __('%s - Meta Tag erased','wp-cleanfix'), $mes ); ?></span>
        <?php endif; ?>
    <?php endif;
}

function wpcleanfix_posts_remove_unused_post_meta() {
    global $wpdb;

    $sql = "DELETE pm FROM $wpdb->postmeta pm LEFT JOIN $wpdb->posts wp ON wp.ID = pm.post_id WHERE wp.ID IS NULL";
    $mes = $wpdb->query( $sql );
    wpcleanfix_posts_show_unused_post_meta( $mes );
}


function wpcleanfix_posts_show_unused_tag( $mes = null ) {
    global $wpdb;

    $sql = "SELECT * FROM $wpdb->terms wt INNER JOIN $wpdb->term_taxonomy wtt ON wt.term_id = wtt.term_id WHERE wtt.taxonomy='post_tag' AND wtt.count=0;";
    $res = $wpdb->get_results($sql);
   
    if(count($res) > 0 ) : ?>
       <span class="wpcleanfix-warning"><?php printf(__('%s unused Tags:', 'wp-cleanfix'), count($res) ) ?></span> <select>
    <?php
        foreach($res as $row) : ?>
            <option><?php echo $row->name ?></option>
        <?php endforeach; ?>
    ?></select> <button id="buttonPostsRemoveTag"><?php _e('Erased!', 'wp-cleanfix') ?></button>
    <?php else : ?>
        <?php if(is_null($mes)) : ?>
            <span class="wpcleanfix-ok"><?php _e('No unused Tags','wp-cleanfix'); ?></span>
        <?php else : ?>
            <span class="wpcleanfix-cleaned"><?php printf( __('%s - Tags erased','wp-cleanfix'), $mes ); ?></span>
        <?php endif; ?>
    <?php endif;
}

function wpcleanfix_posts_remove_tag() {
    global $wpdb;
    $sql = "DELETE a,b,c FROM $wpdb->terms AS a	LEFT JOIN $wpdb->term_taxonomy AS c ON a.term_id = c.term_id LEFT JOIN $wpdb->term_relationships AS b ON b.term_taxonomy_id = c.term_taxonomy_id WHERE (c.taxonomy = 'post_tag' AND	c.count = 0 )";
    $mes = $wpdb->query( $sql );
    wpcleanfix_posts_show_unused_tag( $mes );
}


function wpcleanfix_posts_show_postsusers_unlink($mes = null) {
    global $wpdb;

    $sql = "SELECT * FROM $wpdb->posts wpp LEFT JOIN $wpdb->users wpu ON wpu.ID = wpp.post_author WHERE wpu.ID IS NULL";
    $usersposts = $wpdb->get_results( $sql );
    if( count($usersposts) > 0 ) {
        echo '<span class="wpcleanfix-warning">' . count($usersposts) . ' '. __('Posts without Author linked:', 'wp-cleanfix') . '</span> ';
        echo '<button id="buttonPostsUsersRemoveUnlink">' . __('Erase!', 'wp-cleanfix') . '</button> ';
        echo '<button id="buttonPostsUsersCreate">' . __('Create Virtual Authors', 'wp-cleanfix') . '</button>';
    } else {
        if(is_null($mes) ) {
            echo '<span class="wpcleanfix-ok">' . __('No unlink Authors found','wp-cleanfix') . '</span>';
        } else {
           printf( '<span class="wpcleanfix-cleaned">' . __('%s - Posts erased','wp-cleanfix') .  '</span>', $mes );
        }
    }
}


?>
