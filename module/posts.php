<?php
/**
 * Posts management
 *
 * @package         wp-cleanfix
 * @subpackage      posts
 * @author          =undo= <g.fazioli@saidmade.com>
 * @copyright       Copyright (C) 2010 Saidmade Srl
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
            <span class="wpcleanfix-cleaned"><?php printf( __('%s - Rows erased','wp-cleanfix'), $mes ); ?></span>
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
            <span class="wpcleanfix-cleaned"><?php printf( __('%s - Rows erased','wp-cleanfix'), $mes ); ?></span>
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
            <span class="wpcleanfix-cleaned"><?php printf( __('%s - Rows erased','wp-cleanfix'), $mes ); ?></span>
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

    $sql = "SELECT * FROM $wpdb->posts wpp LEFT JOIN $wpdb->users wpu ON wpu.ID = wpp.post_author WHERE wpp.post_type = 'post' AND wpp.post_status = 'publish' AND wpu.ID IS NULL";
    $usersposts = $wpdb->get_results( $sql );
    if( count($usersposts) > 0 ) {
        echo '<span class="wpcleanfix-warning">' . count($usersposts) . ' '. __('Posts without Author linked:', 'wp-cleanfix') . '</span> ';
        echo '<button id="buttonPostsUsersRemoveUnlink">' . __('Erase!', 'wp-cleanfix') . '</button> ';

        _e('Or link Posts to: ', 'wp-cleanfix');
        
        $sql = "SELECT * FROM $wpdb->users WHERE user_status = 0 ORDER BY user_login";
        $users = $wpdb->get_results( $sql );
        echo '<select>';
        foreach($users as $user) : ?>
            <option><?php echo $user->user_login . " [" . $user->display_name , "]" ?></option>
        <?php endforeach;
        echo '</select>';
        echo '<button id="buttonPostsUsersLinkToAuthor">' . __('Link', 'wp-cleanfix') . '</button> ';
    } else {
        if(is_null($mes) ) {
            echo '<span class="wpcleanfix-ok">' . __('No unlink Authors found','wp-cleanfix') . '</span>';
        } else {
           printf( '<span class="wpcleanfix-cleaned">' . __('%s - Posts erased','wp-cleanfix') .  '</span>', $mes );
        }
    }
}

/**
 * Pages do not link with Author
 *
 * @global <type> $wpdb
 * @param <type> $mes
 */
function wpcleanfix_posts_show_pagesusers_unlink($mes = null) {
    global $wpdb;

    $sql = "SELECT * FROM $wpdb->posts wpp LEFT JOIN $wpdb->users wpu ON wpu.ID = wpp.post_author WHERE wpp.post_type = 'page' AND wpp.post_status = 'publish' AND wpu.ID IS NULL";
    $usersposts = $wpdb->get_results( $sql );
    if( count($usersposts) > 0 ) {
        echo '<span class="wpcleanfix-warning">' . count($usersposts) . ' '. __('Posts without Author linked:', 'wp-cleanfix') . '</span> ';
        echo '<button id="buttonPagesUsersRemoveUnlink">' . __('Erase!', 'wp-cleanfix') . '</button> ';

        _e('Or link Pages to: ', 'wp-cleanfix');

        $sql = "SELECT * FROM $wpdb->users WHERE user_status = 0 ORDER BY user_login";
        $users = $wpdb->get_results( $sql );
        echo '<select>';
        foreach($users as $user) : ?>
            <option><?php echo $user->user_login . " [" . $user->display_name , "]" ?></option>
        <?php endforeach;
        echo '</select>';
        echo '<button id="buttonPagesUsersLinkToAuthor">' . __('Link', 'wp-cleanfix') . '</button> ';

    } else {
        if(is_null($mes) ) {
            echo '<span class="wpcleanfix-ok">' . __('No unlink Authors found','wp-cleanfix') . '</span>';
        } else {
           printf( '<span class="wpcleanfix-cleaned">' . __('%s - Pages erased','wp-cleanfix') .  '</span>', $mes );
        }
    }
}

function wpcleanfix_pagesusers_remove() {
    global $wpdb;
    $sql = "DELETE FROM $wpdb->posts wpp LEFT JOIN $wpdb->users wpu ON wpu.ID = wpp.post_author WHERE wpp.post_type = 'page' AND wpp.post_status = 'publish' AND wpu.ID IS NULL";
    $mes = $wpdb->query( $sql );
    wpcleanfix_posts_show_pagesusers_unlink( $mes );
}


/**
 * Post Attachment do not link with Post
 *
 * @global <type> $wpdb
 * @param <type> $mes
 */
function wpcleanfix_posts_show_attachment_unlink($mes = null) {
    global $wpdb;

    $sql = "SELECT * FROM $wpdb->posts wpa LEFT JOIN $wpdb->posts wpp ON wpa.post_parent = wpp.ID WHERE wpa.post_type = 'attachment' AND wpa.post_parent > 0 AND wpp.ID IS NULL";
    $attachments = $wpdb->get_results( $sql );
    if( count($attachments) > 0 ) {
        echo '<span class="wpcleanfix-warning">' . count($attachments ) . ' '. __('Attachments without valid Post/Page link:', 'wp-cleanfix') . '</span> ';
        echo '<button id="buttonAttachementsRemoveUnlink">' . __('Erase!', 'wp-cleanfix') . '</button> ';
    } else {
        if(is_null($mes) ) {
            echo '<span class="wpcleanfix-ok">' . __('No unlink attachment','wp-cleanfix') . '</span>';
        } else {
           printf( '<span class="wpcleanfix-cleaned">' . __('%s - attachments erased','wp-cleanfix') .  '</span>', $mes );
        }
    }
}


function wpcleanfix_replace_post_content() {
    global $wpdb, $_POST;

    $string_find = ($_POST['wpcleanfix_find_post_content']);
    $string_replace = ($_POST['wpcleanfix_replace_post_content']);

    if($string_find != "" && $string_replace != "") {
        $sql = "UPDATE $wpdb->posts SET post_content = REPLACE (post_content, '{$string_find}', '{$string_replace}')";
        $mes = $wpdb->query( $sql );
    }
    wpcleanfix_show_replace_post_content($string_find, $string_replace, $mes);
}

function wpcleanfix_show_replace_post_content($find = "", $replace = "", $mes = null) {
    if(!is_null($mes)) {
        printf( '<span class="wpcleanfix-cleaned">' . __('%s - found and replaced - ', 'wp-cleanfix') .  '</span>', $mes );
    }
    echo _e('Find:', 'wp-cleanfix') ?> <input value="<?php echo $find ?>" type="text" name="wpcleanfix_find_post_content" id="wpcleanfix_find_post_content" /> <?php _e('and replace with:', 'wp-cleanfix') ?> <input value="<?php echo $replace ?>" type="text" name="wpcleanfix_replace_post_content" id="wpcleanfix_replace_post_content" /> <button style="background-image:none;padding-left:12px" id="buttonFindReplace"><?php _e('Find/Replace', 'wp-cleanfix') ?></button>
<?php
}


?>
