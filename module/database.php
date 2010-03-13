<?php
/**
 * Database management
 *
 * @package         wp-cleanfix
 * @subpackage      database
 * @author          =undo= <g.fazioli@saidmade.com>
 * @copyright       Copyright (C) 2010 Saidmade Srl
 * 
 */

/**
 * Check all databse table for optimizing
 */
function wpcleanfix_database_show_tables_optimize() {
    if( !defined('DB_NAME') || DB_NAME == "") {
        die(__('Internal Error #1: no such DB_NAME setting properly', 'wp-cleanfix'));
    }

    $db_clean       = DB_NAME;
    $tot_data       = 0;
    $total_gain     = 0;
    $tot_idx        = 0;
    $tot_all        = 0;
    $local_query    = 'SHOW TABLE STATUS FROM '. DB_NAME;
    $result         = mysql_query($local_query);
    $flag           = true;
    $num            = mysql_num_rows($result);
    $index_count    = 0;
    $buffer         = "";

    if ( $num > 0 ) {
        while ($row = mysql_fetch_array($result)) {
            $tot_data   = $row['Data_length'];
            $tot_idx    = $row['Index_length'];
            $total      = round( ( $tot_data + $tot_idx ) / 1024, 3 );
            $gain       = ($row['Data_free']) / 1024;
            $total_gain += $gain;
            $gain       = round ($gain,3);

            if($gain > 0) {
                $index_count++;
                $buffer .=  '<option>' . $row[0] . ' - ' . $gain . ' Kb</option>';
            }
        }

        if($total_gain > 0) {
            $total_gain = round ($total_gain,3);
            echo '<span class="wpcleanfix-warning">';
            printf( __('%s Optimize Tables of %s: ', 'wp-cleanfix'), $index_count, $num );
            echo '</span>';
            echo '<select>' . $buffer . '</select> ';
            _e(' if optimized them you gain: ', 'wp-cleanfix');
            echo '<span style="color:green;font-weight:bold">' . $total_gain . ' Kb</span>';
            echo ' <button id="buttonDatabaseOptimize">' . __('Optimizes!', 'wp-cleanfix'). '</button>';
        } else {
            echo '<span class="wpcleanfix-ok">' . __('All database tables are optimized!', 'wp-cleanfix') . '</span>';
        }
    }
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
