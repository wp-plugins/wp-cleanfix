<?php
/**
 * Category management
 *
 * @package         wp-cleanfix
 * @subpackage      usermeta_view
 * @author          =undo= <g.fazioli@saidmade.com>
 * @copyright       Copyright (C) 2010 Saidmade Srl
 *
 */

?>
<table class="widefat wp-cleanfix" width="100%" cellpadding="4" cellspacing="0">
    <thead>
        <tr>
            <th scope="col" width="64"><?php _e('Refresh', 'wp-cleanfix') ?></th>
            <th scope="col"><?php _e('Action', 'wp-cleanfix') ?></th>
            <th width="100%" scope="col"><?php _e('Status', 'wp-cleanfix') ?></th>
        </tr>
    </thead>

    <tbody>

        <tr>
            <td><?php $this->button_refresh('buttonUserMetaUnusedRefresh') ?></td>
            <td>
                <strong><?php _e('User Meta', 'wp-cleanfix') ?></strong>
            </td>
            <td>
                <div id="usersmeta-unused">
                    <?php $WPCLEANFIX_USERMETA->checkUserMeta() ?>
                </div>
            </td>
        </tr>

    </tbody>

</table>