<?php
/**
 * Comments management
 *
 * @package         wp-cleanfix
 * @subpackage      comments_view
 * @author          =undo= <g.fazioli@saidmade.com>
 * @copyright       Copyright (C) 2010 Saidmade Srl
 * 
 */
?>
<table class="widefat wp-cleanfix" width="100%" cellpadding="4" cellspacing="0">
    <thead>
        <tr>
            <th scope="col"><?php $this->button_refresh_all('buttonCommentsRefreshAll') ?></th>
            <th scope="col"><?php _e('Action', 'wp-cleanfix') ?></th>
            <th width="100%" scope="col"><?php _e('Status', 'wp-cleanfix') ?></th>
			<th scope="col"><?php _e('Help/Info', 'wp-cleanfix') ?></th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td><?php $this->button_refresh('buttonCommentUnapprovedCommentRefresh') ?></td>

            <td>
                <strong><?php _e('Unapproved Comments', 'wp-cleanfix') ?></strong>
            </td>

            <td>
                <div id="comments-unapproved">
                    <?php $WPCLEANFIX_COMMENTS->checkComments(); ?>
                </div>
            </td>
			<td>
				<div class="wpCleanFixHelper">
					<span class="wpCleanFixWarning"><?php _e('This function remove unapproved comments. This is like the WordPress\'s function', 'wp-cleanfix') ?></span>
				</div>
			</td>
        </tr>

        <tr>
            <td><?php $this->button_refresh('buttonCommentTrashCommentRefresh') ?></td>

            <td>
                <strong><?php _e('Comments in Trash', 'wp-cleanfix') ?></strong>
            </td>

            <td>
                <div id="comments-trash">
                    <?php $WPCLEANFIX_COMMENTS->checkTrash(); ?>
                </div>
            </td>
			<td>
				<div class="wpCleanFixHelper">
					<span class="wpCleanFixWarning"><?php _e('This function remove comment in trash', 'wp-cleanfix') ?></span>
				</div>
			</td>
        </tr>

        <tr>
            <td><?php $this->button_refresh('buttonCommentSpamRefresh') ?></td>
            
            <td>
                <strong><?php _e('SPAM Comments', 'wp-cleanfix') ?></strong>
            </td>
            <td>
                <div id="comments-spam">
                    <?php $WPCLEANFIX_COMMENTS->checkSpam(); ?>
                </div>
            </td>
			<td>
				<div class="wpCleanFixHelper">
					<span class="wpCleanFixWarning"><?php _e('This function remove SPAN comment', 'wp-cleanfix') ?></span>
				</div>
			</td>
        </tr>


        <tr class="tools">
            <td><img src="<?php echo $this->url . "/css/images/tools.png" ?>" alt="<?php _e('Tools', 'wp-cleanfix') ?>" /></td>
            <td>
                <strong><?php _e('Comment Content', 'wp-cleanfix') ?></strong>
            </td>
            <td>
                <div id="find-replace-comment-content">
                    <?php $WPCLEANFIX_COMMENTS->findAndReplaceUI() ?>
                </div>
            </td>
			<td>
				<div class="wpCleanFixHelper">
					<span class="wpCleanFixWarning"><?php _e('This function find/replace text in comment content.', 'wp-cleanfix') ?></span>
				</div>
			</td>
        </tr>

    </tbody>

</table>


