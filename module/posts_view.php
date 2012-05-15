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

?>
<table class="widefat wp-cleanfix" width="100%" cellpadding="4" cellspacing="0">
    <thead>
        <tr>
            <th scope="col"><?php $this->button_refresh_all('buttonPostsRefreshAll') ?></th>
            <th scope="col"><?php _e('Action', 'wp-cleanfix') ?></th>
            <th width="100%" scope="col"><?php _e('Status', 'wp-cleanfix') ?></th>
			<th scope="col"><?php _e('Help/Info', 'wp-cleanfix') ?></th>
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
                    <?php $WPCLEANFIX_POSTS->checkRevisions(); ?>
                </div>
            </td>
			<td>
				<div class="wpCleanFixHelper">
					<span class="wpCleanFixWarning"><?php _e('This function remove all the post\'s revisions. Usualy Wordpress makes a lot of revisions for one Post. However the revisions are useful to come back to previous version of post. This operation is not undoable!', 'wp-cleanfix') ?></span>
				</div>
			</td>
        </tr>

		<tr>
            <td><?php $this->button_refresh('buttonPostAutodraftRefresh') ?></td>
            <td>
                <strong><?php _e('Auto Draft', 'wp-cleanfix') ?></strong>
            </td>
            <td>
                <div id="posts-autodraft">
                    <?php $WPCLEANFIX_POSTS->checkAutodraft(); ?>
                </div>
            </td>
			<td>
				<div class="wpCleanFixHelper">
					<span class="wpCleanFixWarning"><?php _e('This function remove Auto Draft Post. The Auto Draft are auto-generate by Wordpress when start new post or edit a post.', 'wp-cleanfix') ?></span>
				</div>
			</td>
        </tr>

        <tr>
            <td><?php $this->button_refresh('buttonPostTrashRefresh') ?></td>
            <td>
                <strong><?php _e('Trash', 'wp-cleanfix') ?></strong>
            </td>
            <td>
                <div id="posts-trash">
                    <?php $WPCLEANFIX_POSTS->checkTrash(); ?>
                </div>
            </td>
			<td>
				<div class="wpCleanFixHelper">
					<span class="wpCleanFixWarning"><?php _e('This function remove delete post in trash. In pratic', 'wp-cleanfix') ?></span>
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
                    <?php $WPCLEANFIX_POSTS->checkPostMeta(); ?>
                </div>
            </td>
			<td>
				<div class="wpCleanFixHelper">
					<span class="wpCleanFixWarning"><?php _e('This function remove unused Post Meta', 'wp-cleanfix') ?></span>
				</div>
			</td>
        </tr>

		<tr>
            <td><?php $this->button_refresh('buttonPostMetaEditLockRefresh') ?></td>
            <td>
                <strong><?php _e('Post Meta Edit Lock', 'wp-cleanfix') ?></strong>
            </td>
            <td>
                <div id="posts-editlock">
                    <?php $WPCLEANFIX_POSTS->checkPostMetaEditLock(); ?>
                </div>
            </td>
			<td>
				<div class="wpCleanFixHelper">
					<span class="wpCleanFixWarning"><?php _e('This function remove the Lock on a Post', 'wp-cleanfix') ?></span>
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
                    <?php $WPCLEANFIX_POSTS->checkTags() ?>
                </div>
            </td>
			<td>
				<div class="wpCleanFixHelper">
					<span class="wpCleanFixWarning"><?php _e('This function remove unused Tag', 'wp-cleanfix') ?></span>
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
                    <?php $WPCLEANFIX_POSTS->checkPostsUsers() ?>
                </div>
            </td>
			<td>
				<div class="wpCleanFixHelper">
					<span class="wpCleanFixWarning"><?php _e('This function remove the Posts without an author', 'wp-cleanfix') ?></span>
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
                    <?php $WPCLEANFIX_POSTS->checkPostsUsers(null, true, 'page') ?>
                </div>
            </td>
			<td>
				<div class="wpCleanFixHelper">
					<span class="wpCleanFixWarning"><?php _e('This function remove the Pages without an author', 'wp-cleanfix') ?></span>
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
                    <?php $WPCLEANFIX_POSTS->checkAttachment() ?>
                </div>
            </td>
			<td>
				<div class="wpCleanFixHelper">
					<span class="wpCleanFixWarning"><?php _e('This function remove the attach without valid Posts', 'wp-cleanfix') ?></span>
				</div>
			</td>
        </tr>

        <tr class="tools">
            <td><img src="<?php echo $this->url . "/css/images/tools.png" ?>" alt="<?php _e('Tools', 'wp-cleanfix') ?>" /></td>
            <td>
                <strong><?php _e('Post Content', 'wp-cleanfix') ?></strong>
            </td>
            <td>
                <div id="find-replace-post-content">
                    <?php $WPCLEANFIX_POSTS->findAndReplaceUI(); ?>
                </div>
            </td>
			<td>
				<div class="wpCleanFixHelper">
					<span class="wpCleanFixWarning"><?php _e('This function find/replace text in post content', 'wp-cleanfix') ?></span>
				</div>
			</td>
        </tr>


    </tbody>

</table>


