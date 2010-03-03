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
require_once ('module/category.php');
require_once ('module/comments.php');

/**
 * Sanitize $_POST['command]
 */
$command = strip_tags($_POST['command']);
eval ($command.'();' );

?>
