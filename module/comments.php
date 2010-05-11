<?php
/**
 * Comments management
 *
 * @package         wp-cleanfix
 * @subpackage      WPCLEANFIX_COMMENTS
 * @author          =undo= <g.fazioli@saidmade.com>
 * @copyright       Copyright (C) 2010 Saidmade Srl
 * 
 */

class WPCLEANFIX_COMMENTS extends WPCLEANFIX_MODULE {

    /**
     * Class version
     *
     * @var string
     */
    var $version    = "1.0.0";

    /**
     * Check unapproved comments
     *
     * @global <type> $wpdb
     * @param <type> $mes
     * @param <type> $echo
     * @return <type>
     */
    function checkComments($mes = null, $echo = true) {
        global $wpdb;

        $sql = "SELECT * FROM $wpdb->comments WHERE comment_approved = '0';";
        $comments = $wpdb->get_results( $sql );
        if($echo) {
            if( count($comments) > 0 ) {
                echo '<span class="wpcleanfix-warning">' . count($comments) . '</span> (' . __('Quick View', 'wp-cleanfix') . '): <select>';
                foreach($comments as $row) {
                    echo '<option>' . $this->cut_string_at($row->comment_author, 16) . ' - [' . $this->cut_string_at( strip_tags($row->comment_content) ) . ']</option>';
                }
                echo '</select> <a href="edit-comments.php?comment_status=moderated">' . __('Check Them', 'wp-cleanfix') . '</a>' . __(', or Do you want erase them?', 'wp-cleanfix') . ' <button id="buttonCommentsRemoveUnapproved">' . __('Erase!', 'wp-cleanfix') . '</button>';
            } else {
                if(is_null($mes)) : ?>
                <span class="wpcleanfix-ok"><?php _e('None','wp-cleanfix'); ?></span>
                <?php else : ?>
                    <span class="wpcleanfix-cleaned"><?php printf( __('%s Comments erased','wp-cleanfix'), $mes ); ?></span>
                <?php endif;
            }
        } else {
            return $comments;
        }
    }
    // Remove
    function removeComments() {
        global $wpdb;

        $sql = "DELETE FROM $wpdb->comments WHERE comment_approved = '0';";
        $mes = $wpdb->query( $sql );
        $this->checkComments( $mes );
    }

	/**
     * Check trash comments
     *
     * @global <type> $wpdb
     * @param <type> $mes
     * @param <type> $echo
     * @return <type>
     */
    function checkTrash($mes = null, $echo = true) {
        global $wpdb;

        $sql = "SELECT * FROM $wpdb->comments WHERE comment_approved = 'trash';";
        $comments = $wpdb->get_results( $sql );
        if($echo) {
            if( count($comments) > 0 ) {
                echo '<span class="wpcleanfix-warning">' . count($comments) . '</span> (' . __('Quick View', 'wp-cleanfix') . '): <select>';
                foreach($comments as $row) {
                    echo '<option>' . $this->cut_string_at($row->comment_author, 16) . ' - [' . $this->cut_string_at( strip_tags($row->comment_content) ) . ']</option>';
                }
                echo '</select> <button id="buttonCommentsRemoveTrash">' . __('Erase!', 'wp-cleanfix') . '</button>';
            } else {
                if(is_null($mes)) : ?>
                <span class="wpcleanfix-ok"><?php _e('None','wp-cleanfix'); ?></span>
                <?php else : ?>
                    <span class="wpcleanfix-cleaned"><?php printf( __('%s Comments erased','wp-cleanfix'), $mes ); ?></span>
                <?php endif;
            }
        } else {
            return $comments;
        }
    }
    // Remove
    function removeTrash() {
        global $wpdb;

        $sql = "DELETE FROM $wpdb->comments WHERE comment_approved = 'trash';";
        $mes = $wpdb->query( $sql );
        $this->checkTrash( $mes );
    }

    /**
     * Check SPAM comments
     * 
     * @global <type> $wpdb
     * @param <type> $mes
     * @param <type> $echo
     * @return <type>
     */
    function checkSpam($mes = null, $echo = true) {
        global $wpdb;

        $sql = "SELECT * FROM $wpdb->comments WHERE comment_approved = 'spam';";
        $spam = $wpdb->get_results( $sql );
        if($echo) {
            if( count($spam) > 0 ) {
                echo '<span class="wpcleanfix-warning">' . count($spam) . '</span> (' . __('Quick View', 'wp-cleanfix') . '): <select>';
                foreach($spam as $row) {
                    echo '<option>' . $this->cut_string_at($row->comment_author, 16) . ' - [' . $this->cut_string_at( strip_tags($row->comment_content) ) . ']</option>';
                }
                echo '</select> <a href="edit-comments.php?comment_status=spam">' . __('Check Them', 'wp-cleanfix') . '</a>' . __(', or Do you want erase them?', 'wp-cleanfix') . ' <button id="buttonCommentsRemoveSPAM">' . __('Erase!', 'wp-cleanfix') . '</button>';
            } else {
                if(is_null($mes)) : ?>
                <span class="wpcleanfix-ok"><?php _e('None','wp-cleanfix'); ?></span>
                <?php else : ?>
                    <span class="wpcleanfix-cleaned"><?php printf( __('%s Comments erased','wp-cleanfix'), $mes ); ?></span>
                <?php endif;
            }
        } else {
            return $spam;
        }
    }
    // Remove
    function removeSpam() {
        global $wpdb;

        $sql = "DELETE FROM $wpdb->comments WHERE comment_approved = 'spam';";
        $mes = $wpdb->query( $sql );
        $this->checkSpam( $mes );
    }

    // -------------------------------------------------------------------------
    // Tools
    // -------------------------------------------------------------------------

    /**
     * Find and Replace User Interface
     * @param <type> $find
     * @param <type> $replace
     * @param <type> $mes
     */
    function findAndReplaceUI($find = "", $replace = "", $mes = null) {
        if(!is_null($mes)) {
            printf( '<span class="wpcleanfix-cleaned">' . __('%s - found and replaced - ', 'wp-cleanfix') .  '</span>', $mes );
        }
        echo _e('Find:', 'wp-cleanfix') ?> <input value="<?php echo stripslashes( sanitize_text_field( $find )) ?>" type="text" name="wpcleanfix_find_comment_content" id="wpcleanfix_find_comment_content" /> <?php _e('and replace with:', 'wp-cleanfix') ?> <input value="<?php echo stripslashes( sanitize_text_field($replace)) ?>" type="text" name="wpcleanfix_replace_comment_content" id="wpcleanfix_replace_comment_content" /> <button style="background-image:none;padding-left:12px" id="buttonFindReplaceComment"><?php _e('Find/Replace', 'wp-cleanfix') ?></button>
    <?php
    }

    /**
     * Find a string in Post content and replace it
     * 
     * @global <type> $wpdb
     */
    function findAndReplace() {
        global $wpdb;

        $string_find = ($_POST['wpcleanfix_find_comment_content']);
        $string_replace = ($_POST['wpcleanfix_replace_comment_content']);

        if($string_find != "") {
            $sql = "UPDATE $wpdb->comments SET comment_content = REPLACE (comment_content, '{$string_find}', '{$string_replace}')";
            $mes = $wpdb->query( $sql );
        }
        $this->findAndReplaceUI($string_find, $string_replace, $mes);
    }

}

$WPCLEANFIX_COMMENTS = new WPCLEANFIX_COMMENTS();

?>