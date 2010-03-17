<?php
/**
 * Ajax modulo for POST request
 *
 * @package         wp-cleanfix
 * @subpackage      wp-cleanfix_ajax
 * @author          =undo= <g.fazioli@saidmade.com>
 * @copyright       Copyright (C) 2010 Saidmade Srl
 *
 * $_POST['command'] = todo
 *
 *
 */

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) ) {
    // write some code and rest assured that the Javascript is enabled.

    require_once ('../../../wp-load.php');
    require_once ('module/database.php');
    require_once ('module/usersmeta.php');
    require_once ('module/posts.php');
    require_once ('module/category.php');
    require_once ('module/comments.php');

    // @since 0.3.6 fix
    load_plugin_textdomain ( 'wp-cleanfix' , false, 'wp-cleanfix/localization'  );

    /**
     * Sanitize $_POST['command]
     */
    $command = strip_tags($_POST['command']);
    eval ($command.'();' );
}

?>
