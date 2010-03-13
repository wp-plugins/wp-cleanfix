<?php
/**
 * Posts management
 *
 * @package         wp-cleanfix
 * @subpackage      posts_view
 * @author          =undo= <g.fazioli@saidmade.com>
 * @copyright       Copyright (C) 2010 Saidmade Srl
 * 
 */

require_once 'posts.php';

?>
<table class="widefat wp-cleanfix" width="100%" cellpadding="4" cellspacing="0">
    <thead>
        <tr>
            <th scope="col" width="64"><?php _e('Refresh', 'wp-cleanfix') ?></th>
            <th width="200" scope="col"><?php _e('Action', 'wp-cleanfix') ?></th>
            <th scope="col"><?php _e('Status', 'wp-cleanfix') ?></th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td><?php $this->button_refresh('buttonPostRevisionRefresh') ?></td>
            <td>
                <strong><?php _e('Revisions', 'wp-cleanfix') ?></strong>
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

        <tr>
            <td><?php $this->button_refresh('buttonPostsUsersRefresh') ?></td>
            <td>
                <strong><?php _e('Posts without author', 'wp-cleanfix') ?></strong>
            </td>
            <td>
                <div id="posts-users">
                    <?php wpcleanfix_posts_show_postsusers_unlink() ?>
                </div>
            </td>
        </tr>

        <tr>
            <td><?php $this->button_refresh('buttonPagesUsersRefresh') ?></td>
            <td>
                <strong><?php _e('Pages without author', 'wp-cleanfix') ?></strong>
            </td>
            <td>
                <div id="pages-users">
                    <?php wpcleanfix_posts_show_pagesusers_unlink() ?>
                </div>
            </td>
        </tr>

        <tr>
            <td><?php $this->button_refresh('buttonAttachmentsRefresh') ?></td>
            <td>
                <strong><?php _e('Attachment without Post', 'wp-cleanfix') ?></strong>
            </td>
            <td>
                <div id="attachment-post">
                    <?php wpcleanfix_posts_show_attachment_unlink() ?>
                </div>
            </td>
        </tr>


    </tbody>

</table>


