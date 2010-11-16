<?php
/**
 * Database management
 *
 * @package         wp-cleanfix
 * @subpackage      WPCLEANFIX_DATABASE
 * @author          =undo= <g.fazioli@saidmade.com>
 * @copyright       Copyright (C) 2010 Saidmade Srl
 * 
 */

class WPCLEANFIX_DATABASE {

    /**
     * Class version
     *
     * @var string
     */
    var $version    = "1.0.0";

    /**
     * Do optiminazion of database tables
     *
     */
    function optimize() {
        $local_query    = 'SHOW TABLE STATUS FROM '. DB_NAME;
        $result         = mysql_query($local_query);
        if (@mysql_num_rows($result)) {
            while ($row = mysql_fetch_array($result)) {
                $local_query = 'OPTIMIZE TABLE '.$row[0];
                $resulopt  = mysql_query($local_query);
            }
        }
        $this->checkTables();
    }

    /**
     * Check Database table for optimizing
     *
     * @param boolean $echo If true print output, else do nothing (using in dashborard)
     * @return string   Total gain out
     */
    function checkTables($echo = true) {
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
        $num            = 0;
		if(!is_null($result)) {
			// Sembra che questa riga emetta un Warning su alcuni sistemi
			$num = @mysql_num_rows($result);
		}
        $index_count    = 0;
        $buffer         = "";
		$gain			= 0;

        if ( $num > 0 ) {
            while ($row = mysql_fetch_array($result)) {
                $tot_data   = $row['Data_length'];
                $tot_idx    = $row['Index_length'];
                $total      = round( ( $tot_data + $tot_idx ) / 1024, 3 );
                $gain       = round( floatval($row['Data_free']) / 1024, 2);
                $total_gain += $gain;

                if($gain > 0) {
                    $index_count++;
					$gain_str = sprintf('%6.2f', $gain);
                    $buffer .=  '<option>' . $row[0] . ' - ' . $gain_str . ' Kb</option>';
                }
            }

            if($total_gain > 0) {
                $total_gain = round ($total_gain,3);
                if($echo) {
                    echo '<span class="wpcleanfix-warning">';
                    printf( __('%s of %s:', 'wp-cleanfix'), $index_count, $num );
                    echo ' </span>';
                    echo '<select>' . $buffer . '</select> ';
                    _e(' if optimized them you gain:', 'wp-cleanfix');
                    echo ' <span style="color:green;font-weight:bold">' . $total_gain . ' Kb</span>';
                    echo ' <button id="buttonDatabaseOptimize">' . __('Optimizes!', 'wp-cleanfix'). '</button>';
                } else {
                    return $total_gain;
                }
            } else {
                if($echo) {
                    echo '<span class="wpcleanfix-ok">' . __('None', 'wp-cleanfix') . '</span>';
                }
            }
        }
    }
}

$WPCLEANFIX_DATABASE = new WPCLEANFIX_DATABASE();

?>