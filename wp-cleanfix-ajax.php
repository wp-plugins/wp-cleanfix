<?php
/**
 * Ajax modulo for POST request
 *
 * @package         wp-cleanfix
 * @subpackage      wp-cleanfix_ajax
 * @author          =undo= <g.fazioli@saidmade.com>
 * @copyright       Copyright (C) 2010 Saidmade Srl
 * @version         1.0.0
 *
 * $_POST['command'] = todo
 *
 *
 */

require_once ('../../../wp-load.php');
require_once ('module/database.php');
require_once ('module/posts.php');
require_once ('module/comments.php');

/**
 * Sanitize $_POST['command]
 */
$command = strip_tags($_POST['command']);

switch ( $command ) {
    case 'database-optimize':
        wpcleanfix_database_optimize();
        break;
    case 'posts-removerevision':
        wpcleanfix_posts_remove_revision();
        break;
    case 'posts-removetag':
        wpcleanfix_posts_remove_tag();
        break;
    case 'comments-removeunapproved':
        wpcleanfix_comments_delete_unapproved_comment();
        break;
    case 'comments-removespam':
        wpcleanfix_comments_delete_spam_comment();
        break;
    default:
        eval ($command.'();' );
        //_e('Impossibile completare l\'operazione!', 'wp-cleanfix');
        break;
}

?>
