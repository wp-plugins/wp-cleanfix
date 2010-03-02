<?php
/**
 * Database management
 *
 * @package         wp-cleanfix
 * @subpackage      info
 * @author          =undo= <g.fazioli@saidmade.com>
 * @copyright       Copyright (C) 2010 Saidmade Srl
 * @version         1.0.0
 */

require_once 'posts.php';

?>
<table class="widefat wp-cleanfix" width="100%" cellpadding="4" cellspacing="0">
    <thead>
        <tr>
            <th scope="col" width="64"><?php _e('Aggiorna', 'wp-cleanfix') ?></th>
            <th width="200" scope="col"><?php _e('Funzione', 'wp-cleanfix') ?></th>
            <th scope="col"><?php _e('Stato', 'wp-cleanfix') ?></th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td><?php $this->button_refresh('buttonPostRevisionRefresh') ?></td>
            <td>
                <strong><?php _e('Revisioni', 'wp-cleanfix') ?></strong>
            </td>
            <td>
                <div id="posts-revision">
                    <?php wpcleanfix_posts_show_posts_revision() ?>
                </div>
            </td>
        </tr>

        <tr>
            <td><?php $this->button_refresh('buttonPostMetaRefresh') ?></td>
            <td>
                <strong><?php _e('Post Meta', 'wp-cleanfix') ?></strong>
            </td>
            <td>
                <div id="posts-meta">
                    <?php wpcleanfix_posts_show_unused_post_meta() ?>
                </div>
            </td>
        </tr>

        <tr>
            <td><?php $this->button_refresh('buttonPostTagsRefresh') ?></td>
            <td>
                <strong><?php _e('Tags', 'wp-cleanfix') ?></strong>
            </td>
            <td>
                <div id="posts-tags">
                    <?php wpcleanfix_posts_show_unused_tag() ?>
                </div>
            </td>
        </tr>


    </tbody>

</table>


