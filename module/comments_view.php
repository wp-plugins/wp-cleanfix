<?php
/**
 * Comments management
 *
 * @package         wp-cleanfix
 * @subpackage      comments_view
 * @author          =undo= <g.fazioli@saidmade.com>
 * @copyright       Copyright (C) 2010 Saidmade Srl
 * @version         1.0.0
 */

require_once 'comments.php';

?>
<table class="widefat wp-cleanfix" width="100%" cellpadding="4" cellspacing="0">
    <thead>
        <tr>
            <th scope="col" width="64"><?php _e('Aggiorna', 'wp-cleanfix') ?></th>
            <th scope="col" width="200"><?php _e('Funzione', 'wp-cleanfix') ?></th>
            <th scope="col"><?php _e('Stato', 'wp-cleanfix') ?></th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td><?php $this->button_refresh('buttonCommentUnapprovedCommentRefresh') ?></td>

            <td>
                <strong><?php _e('Commenti non approvati', 'wp-cleanfix') ?></strong>
            </td>

            <td>
                <div id="comments-unapproved">
                    <?php wpcleanfix_comments_show_unapproved_comment() ?>
                </div>
            </td>
        </tr>

        <tr>
            <td><?php $this->button_refresh('buttonCommentSpamRefresh') ?></td>
            
            <td>
                <strong><?php _e('Commenti segnati come SPAM', 'wp-cleanfix') ?></strong>
            </td>
            <td>
                <div id="comments-spam">
                    <?php wpcleanfix_comments_show_spam_comment() ?>
                </div>
            </td>
        </tr>

    </tbody>

</table>


