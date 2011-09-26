<?php
/**
 * Module Badge
 *
 * @package		  wp-cleanfix
 * @subpackage	  WPCLEANFIX_BADGE
 * @author		  =undo= <g.fazioli@saidmade.com>
 * @copyright	  Copyright (C) 2010-2011 Saidmade Srl
 *
 */

require_once "module.php";
require_once "usermeta.php";
require_once "posts.php";
require_once "category.php";

class WPCLEANFIX_BADGE {

	public static function countRepair() {
		require_once('badge.inc.php');
		echo $tot;
	}
}

?>