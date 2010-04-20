<?php
/**
 * Posts management
 *
 * @package         wp-cleanfix
 * @subpackage      WPCLEANFIX_POSTS
 * @author          =undo= <g.fazioli@saidmade.com>
 * @copyright       Copyright (C) 2010 Saidmade Srl
 */


class WPCLEANFIX_POSTS {

    /**
     * Class version
     *
     * @var string
     */
    var $version    = "1.0.0";

	/**
	 * Verifica se ci sono revisioni per i post
	 *
	 * @param string $echo
	 * @return void
	 */
    function checkRevisions($mes = null, $echo = true) {
        global $wpdb;

        $sql = "SELECT COUNT(*) FROM $wpdb->posts WHERE post_type = 'revision'";
        $revisions = $wpdb->get_var( $sql );
        if($echo) {
            if(intval($revisions) > 0) : ?>
                <span class="wpcleanfix-warning"><?php echo $revisions ?></span>
                <select>
                <?php
                    $sql = "SELECT DISTINCT( COUNT(*) ) AS numero, ID, post_title FROM $wpdb->posts WHERE post_type = 'revision' GROUP BY post_title";
                    $res = $wpdb->get_results($sql);
                    foreach($res as $post) : ?>
                    <option><?php echo $post->post_title ?> (<?php echo $post->numero ?>)</option>
                    <?php endforeach; ?>
                </select>
                <button id="buttonPostsRemoveRevision"><?php _e('Erase!', 'wp-cleanfix') ?></button>
            <?php else : ?>
                <?php if(is_null($mes)) : ?>
                    <span class="wpcleanfix-ok"><?php _e('None','wp-cleanfix'); ?></span>
                <?php else : ?>
                    <span class="wpcleanfix-cleaned"><?php printf( __('%s Rows erased','wp-cleanfix'), $mes ); ?></span>
                <?php endif; ?>
            <?php endif;
        } else {
			return ($revisions);
		}
    }
    // Remove
	function removeRevision() {
		global $wpdb;

		$sql = "DELETE a,b,c FROM $wpdb->posts a LEFT JOIN $wpdb->term_relationships b ON (a.ID = b.object_id) LEFT JOIN $wpdb->postmeta c ON (a.ID = c.post_id) WHERE a.post_type = 'revision'";
		$mes = $wpdb->query($sql);
		$this->checkRevisions( $mes );
	}

	/**
	 * Verifica se ci sono post nel cestino
	 *
	 * @param string $echo
	 * @return void
	 */
    function checkTrash($mes = null, $echo = true) {
        global $wpdb;

        $sql = "SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'trash'";
        $trash = $wpdb->get_var( $sql );
        if($echo) {
            if(intval($trash) > 0) : ?>
                <span class="wpcleanfix-warning"><?php echo $trash ?></span>
                <select>
                <?php
                    $sql = "SELECT post_title FROM $wpdb->posts WHERE post_status = 'trash'";
                    $res = $wpdb->get_results($sql);
                    foreach($res as $post) : ?>
                    <option><?php echo $post->post_title ?></option>
                    <?php endforeach; ?>
                </select>
                <button id="buttonPostsRemoveTrash"><?php _e('Erase!', 'wp-cleanfix') ?></button>
            <?php else : ?>
                <?php if(is_null($mes)) : ?>
                    <span class="wpcleanfix-ok"><?php _e('None','wp-cleanfix'); ?></span>
                <?php else : ?>
                    <span class="wpcleanfix-cleaned"><?php printf( __('%s Rows erased','wp-cleanfix'), $mes ); ?></span>
                <?php endif; ?>
            <?php endif;
        } else {
			return ($trash);
		}
    }
    // Remove
	function removeTrash() {
		global $wpdb;

		$sql = "DELETE a,b,c FROM $wpdb->posts a LEFT JOIN $wpdb->term_relationships b ON (a.ID = b.object_id) LEFT JOIN $wpdb->postmeta c ON (a.ID = c.post_id) WHERE a.post_status = 'trash'";
		$mes = $wpdb->query($sql);
		$this->checkTrash( $mes );
	}

    /**
     * Controlla la presenza di Post Meta non utilizzati
     * 
     * @global <type> $wpdb
     * @param <type> $mes
     * @param <type> $echo
     * @return <type> 
     */
    function checkPostMeta($mes = null, $echo = true) {
        global $wpdb;

        $sql = "SELECT * FROM $wpdb->postmeta pm LEFT JOIN $wpdb->posts wp ON wp.ID = pm.post_id WHERE wp.ID IS NULL;";
        $res = $wpdb->get_results($sql);

        if($echo) {
            if(count($res) > 0 ) : ?>
                <span class="wpcleanfix-warning"><?php echo count($res) ?></span> <select>
            <?php
                foreach($res as $row) : ?>
                    <option><?php echo $row->meta_key ?> [<?php echo $row->meta_value ?>]</option>
                <?php endforeach; ?>
            ?></select> <button id="buttonPostsRemoveMeta"><?php _e('Erase!', 'wp-cleanfix') ?></button>
            <?php else : ?>
                <?php if(is_null($mes)) : ?>
                    <span class="wpcleanfix-ok"><?php _e('None','wp-cleanfix'); ?></span>
                <?php else : ?>
                    <span class="wpcleanfix-cleaned"><?php printf( __('%s Rows erased','wp-cleanfix'), $mes ); ?></span>
                <?php endif; ?>
            <?php endif;    
        } else {
            return ( $res );
        }
    }
    // Remove
    function removePostMeta() {
        global $wpdb;

        $sql = "DELETE pm FROM $wpdb->postmeta pm LEFT JOIN $wpdb->posts wp ON wp.ID = pm.post_id WHERE wp.ID IS NULL";
        $mes = $wpdb->query( $sql );
        $this->checkPostMeta( $mes );
    }

    /**
     * Controlla la presenza di Tags non utilizzati
     * @todo Ho notato che questa funzione (vedi select sql) ritorna dei tags quando questi
     * sono inseriti in Post non pubblicati. Questo non è del tutto buono...
     *
     * @global <type> $wpdb
     * @param <type> $mes
     * @param <type> $echo
     * @return <type>
     */
    function checkTags($mes = null, $echo = true) {
        global $wpdb;

        $sql = "SELECT * FROM $wpdb->terms wt INNER JOIN $wpdb->term_taxonomy wtt ON wt.term_id = wtt.term_id WHERE wtt.taxonomy='post_tag' AND wtt.count=0;";
        $res = $wpdb->get_results($sql);

        if($echo) {
            if(count($res) > 0 ) : ?>
                <span class="wpcleanfix-warning"><?php echo count($res) ?></span> <select>
            <?php
                foreach($res as $row) : ?>
                    <option><?php echo $row->name ?></option>
                <?php endforeach; ?>
            ?></select> <button id="buttonPostsRemoveTag"><?php _e('Erased!', 'wp-cleanfix') ?></button>
            <?php else : ?>
                <?php if(is_null($mes)) : ?>
                    <span class="wpcleanfix-ok"><?php _e('None','wp-cleanfix'); ?></span>
                <?php else : ?>
                    <span class="wpcleanfix-cleaned"><?php printf( __('%s Rows erased','wp-cleanfix'), $mes ); ?></span>
                <?php endif; ?>
            <?php endif;
        } else {
            return $res;
        }
    }
    // Remove
    function removeTags() {
        global $wpdb;
        $sql = "DELETE a,b,c FROM $wpdb->terms AS a	LEFT JOIN $wpdb->term_taxonomy AS c ON a.term_id = c.term_id LEFT JOIN $wpdb->term_relationships AS b ON b.term_taxonomy_id = c.term_taxonomy_id WHERE (c.taxonomy = 'post_tag' AND	c.count = 0 )";
        $mes = $wpdb->query( $sql );
        $this->checkTags( $mes );
    }

    /**
     * Check the ID author's Post
     *
     * @global <type> $wpdb
     * @param <type> $mes
     * @param <type> $echo
     * @param string $type  Post or Page. Default 'post'
     * @return <type>
     */
	function checkPostsUsers($mes = null, $echo = true, $type = 'post') {
		global $wpdb;

		$sql = "SELECT wpp.ID as postID FROM $wpdb->posts wpp LEFT JOIN $wpdb->users wpu ON wpu.ID = wpp.post_author WHERE wpp.post_type = '$type' AND wpp.post_status = 'publish' AND wpu.ID IS NULL";
		$usersposts = $wpdb->get_results( $sql );

        if($echo) {
            if( count($usersposts) > 0 ) {
                echo '<span class="wpcleanfix-warning">' . count($usersposts) . '</span> ';
                echo '<button id="button'.$type.'UsersRemoveUnlink">' . __('Erase!', 'wp-cleanfix') . '</button> ';

                // Costruisco la lista dei Post senza autore
                $pids = "";
                foreach ($usersposts as $post_id) {
                    $pids .= ($pids == "") ? $post_id->postID : "," . $post_id->postID;
                }
                ?>
                <input type="hidden" id="wpcleanfix_<?php echo $type ?>_ids" value="(<?php echo $pids ?>)" />
                <?php

                _e('Or link to: ', 'wp-cleanfix');

                $sql = "SELECT * FROM $wpdb->users WHERE user_status = 0 ORDER BY user_login";
                $users = $wpdb->get_results( $sql );
                echo '<select id="wpcleanfix_' . $type . '_author_id">';
                foreach($users as $user) : ?>
                    <option value="<?php echo $user->ID ?>"><?php echo $user->user_login . " [" . $user->display_name , "]" ?></option>
                <?php endforeach;
                echo '</select>';
                echo ' <button id="button'.$type.'UsersLinkToAuthor">' . __('Link', 'wp-cleanfix') . '</button> ';
            } else {
                if(is_null($mes) ) {
                    echo '<span class="wpcleanfix-ok">' . __('None','wp-cleanfix') . '</span>';
                } else {
                   printf( '<span class="wpcleanfix-cleaned">%s</span>', $mes );
                }
            }
        } else {
            global $wpdb;
            return $usersposts;
        }
	}
    // Re-link
    function relinkPostsUsers($type = 'post') {
        global $wpdb;

        $sql = "UPDATE $wpdb->posts SET post_author = " . $_POST['wpcleanfix_' . $type . '_author_id'] . " WHERE ID IN " . $_POST['wpcleanfix_' . $type . '_ids'];
        $mes = $wpdb->query( $sql );
        $this->checkPostsUsers( sprintf( __('%s Posts relinked', 'wp-cleanfix'), $mes), true, $type );
    }
    // Remove
    function removePostsUsers($type = 'post') {
        global $wpdb;

        $sql = "DELETE wpp FROM $wpdb->posts wpp LEFT JOIN $wpdb->users wpu ON wpu.ID = wpp.post_author WHERE wpp.post_type = '$type' AND wpp.post_status = 'publish' AND wpu.ID IS NULL";
        $mes = $wpdb->query( $sql );
        $this->checkPostsUsers( sprintf( __('%s Posts erased', 'wp-cleanfix'), $mes), true, $type );
    }

    /**
     * Check post attachment unlink
     *
     * @global <type> $wpdb
     * @param <type> $mes
     * @param <type> $echo
     * @return <type>
     */
    function checkAttachment($mes = null, $echo = true) {
        global $wpdb;

        $sql = "SELECT * FROM $wpdb->posts wpa LEFT JOIN $wpdb->posts wpp ON wpa.post_parent = wpp.ID WHERE wpa.post_type = 'attachment' AND wpa.post_parent > 0 AND wpp.ID IS NULL";
        $attachments = $wpdb->get_results( $sql );
        if($echo) {
            if( count($attachments) > 0 ) {
                echo '<span class="wpcleanfix-warning">' . count($attachments ) . '</span> ';
                echo '<button id="buttonAttachementsRemoveUnlink">' . __('Erase!', 'wp-cleanfix') . '</button> ';
            } else {
                if(is_null($mes) ) {
                    echo '<span class="wpcleanfix-ok">' . __('None','wp-cleanfix') . '</span>';
                } else {
                   printf( '<span class="wpcleanfix-cleaned">' . __('%s Attachments erased','wp-cleanfix') .  '</span>', $mes );
                }
            }
        } else {
            return $attachments;
        }
    }
    // Remove
    function removeAttachment() {
        global $wpdb;
        $sql = "DELETE wpa FROM $wpdb->posts wpa LEFT JOIN $wpdb->posts wpp ON wpa.post_parent = wpp.ID WHERE wpa.post_type = 'attachment' AND wpa.post_parent > 0 AND wpp.ID IS NULL";
        $mes = $wpdb->query( $sql );
        $this->checkAttachment($mes);
    }

    // -------------------------------------------------------------------------
    // Tools
    // -------------------------------------------------------------------------

    /**
     * Find and Replace User Interface
     *
     * @param <type> $find
     * @param <type> $replace
     * @param <type> $mes
     */
    function findAndReplaceUI($find = "", $replace = "", $mes = null) {
        if(!is_null($mes)) {
            printf( '<span class="wpcleanfix-cleaned">' . __('%s - found and replaced - ', 'wp-cleanfix') .  '</span>', $mes );
        }
        _e('Find:', 'wp-cleanfix');
        ?>
        <input value="<?php echo stripslashes( sanitize_text_field($find) ) ?>" type="text" name="wpcleanfix_find_post_content" id="wpcleanfix_find_post_content" />
        <?php _e('and replace with:', 'wp-cleanfix') ?> <input value="<?php echo stripslashes( sanitize_text_field($replace) ) ?>" type="text" name="wpcleanfix_replace_post_content" id="wpcleanfix_replace_post_content" />
        <button style="background-image:none;padding-left:12px" id="buttonFindReplacePost"><?php _e('Find/Replace', 'wp-cleanfix') ?></button>
    <?php
    }

    /**
     * Find a string in Post content and replace it
     *
     * @global <type> $wpdb
     */
    function findAndReplace() {
        global $wpdb;

        $string_find = ($_POST['wpcleanfix_find_post_content']);
        $string_replace = ($_POST['wpcleanfix_replace_post_content']);

        if($string_find != "") {
            $sql = "UPDATE $wpdb->posts SET post_content = REPLACE (post_content, '{$string_find}', '{$string_replace}')";
            $mes = $wpdb->query( $sql );
        }
        $this->findAndReplaceUI($string_find, $string_replace, $mes);
    }

}

$WPCLEANFIX_POSTS = new WPCLEANFIX_POSTS();

?>