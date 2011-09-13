<?php
/**
 * Database management
 *
 * @package         wp-cleanfix
 * @subpackage      database_view
 * @author          =undo= <g.fazioli@saidmade.com>
 * @copyright       Copyright (C) 2010 Saidmade Srl
 *
 */
?>

<table class="widefat wp-cleanfix" width="100%" cellpadding="4" cellspacing="0">
    <thead>
        <tr>
            <th scope="col"><?php _e('Refresh', 'wp-cleanfix') ?></th>
            <th scope="col"><?php _e('Action', 'wp-cleanfix') ?></th>
            <th width="100%" scope="col"><?php _e('Status', 'wp-cleanfix') ?></th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td><?php $this->button_refresh('buttonDatabaseOptimizeTableRefresh') ?></td>
            
            <td>
                <strong><?php _e('Tables optimize', 'wp-cleanfix') ?></strong>
            </td>
            <td>
                <div id="database-optimize">
                    <?php $WPCLEANFIX_DATABASE->checkTables() ?>
                </div>
            </td>
        </tr>
    </tbody>
</table>
