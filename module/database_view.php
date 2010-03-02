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

require_once 'database.php';

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
        <tr scope="row">
            <td><?php $this->button_refresh('buttonDatabaseOptimizeTableRefresh') ?></td>
            
            <td>
                <strong><?php _e('Tabelle da ottimizzare', 'wp-cleanfix') ?></strong>
            </td>
            <td>
                <div id="database-optimize">
                    <?php wpcleanfix_database_show_tables_optimize() ?>
                </div>
            </td>
        </tr>
    </tbody>
</table>