<?php
/**
 * Module Badge
 *
 * @package         wp-cleanfix
 * @subpackage      WPCLEANFIX_BADGE
 * @author          =undo= <g.fazioli@saidmade.com>
 * @copyright       Copyright (C) 2010 Saidmade Srl
 *
 */

require_once "module/module.php";
require_once "module/usermeta.php";
require_once "module/posts.php";
require_once "module/category.php";

class WPCLEANFIX_BADGE {

	public static function countRepair() {
		global $WPCLEANFIX_USERMETA;
		global $WPCLEANFIX_POSTS;
		global $WPCLEANFIX_CATEGORY;

		$tot = 0;

		$check = $WPCLEANFIX_USERMETA->checkUserMeta(null, false);

		$tot += count($check);

		$tot += $WPCLEANFIX_POSTS->checkRevisions(null, false);
        $tot += $WPCLEANFIX_POSTS->checkTrash(null, false);
        $tot += count( $WPCLEANFIX_POSTS->checkPostMeta(null, false) );
        $tot += count( $WPCLEANFIX_POSTS->checkTags(null, false) );
        $tot += count( $WPCLEANFIX_POSTS->checkPostsUsers(null, false) );
        $tot += count( $WPCLEANFIX_POSTS->checkPostsUsers(null, false, 'page') );
        $tot += count( $WPCLEANFIX_POSTS->checkAttachment(null, false, 'page') );

        $tot += count( $WPCLEANFIX_CATEGORY->checkCategory(null, false) );
        $tot += count( $WPCLEANFIX_CATEGORY->checkTermInTaxonomy(null, false) );
        $tot += count( $WPCLEANFIX_CATEGORY->checkTaxonomyInTerm(null, false) );

		echo $tot;
	}
}

?>