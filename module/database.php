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

/**
 * Check all databse table for optimizing
 */
function wpcleanfix_database_show_tables_optimize() {
    $db_clean       = DB_NAME;
    $tot_data       = 0;
    $tot_idx        = 0;
    $tot_all        = 0;
    $local_query    = 'SHOW TABLE STATUS FROM '. DB_NAME;
    $result         = mysql_query($local_query);
    $flag           = true;
    if (mysql_num_rows($result)) {
        while ($row = mysql_fetch_array($result)) {
            $tot_data   = $row['Data_length'];
            $tot_idx    = $row['Index_length'];
            $total      = $tot_data + $tot_idx;
            $total      = $total / 1024 ;
            $total      = round ($total,3);
            $gain       = $row['Data_free'];
            $gain       = $gain / 1024 ;
            $total_gain += $gain;
            $gain       = round ($gain,3);

            if($gain > 0) : ?>
                <?php if($flag) : $flag = false; ?><span class="wpcleanfix-warning"><?php _e('Le seguenti tabelle:', 'wp-cleanfix') ?></span> <select><?php endif; ?>
                <option><?php echo $row[0] ?> - <?php echo $gain ?> Kb</option>
            <?php endif;
        }
        $total_gain = round ($total_gain,3);
    }
    ?>
    <?php if(!$flag) : ?></select><?php endif; ?>
    <?php
    if($total_gain > 0) : ?>
        <?php _e(' se ottimizzate libererebbero:', 'wp-cleanfix'); ?> <?php echo $total_gain?> Kb <button id="buttonDatabaseOptimize"><?php _e('Ottimizza!', 'wp-cleanfix') ?></button>
    <?php else: ?>
       <span class="wpcleanfix-ok">Tutte le tabelle sono ottimizzate!</span>
    <?php endif;
}

function wpcleanfix_database_optimize() {
    $local_query    = 'SHOW TABLE STATUS FROM '. DB_NAME;
    $result         = mysql_query($local_query);
    if (mysql_num_rows($result)) {
        while ($row = mysql_fetch_array($result)) {
            $local_query = 'OPTIMIZE TABLE '.$row[0];
            $resultat  = mysql_query($local_query);
        }
    }
    wpcleanfix_database_show_tables_optimize();
}

?>
