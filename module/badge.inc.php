<?php
global $WPCLEANFIX_USERMETA;
global $WPCLEANFIX_POSTS;
global $WPCLEANFIX_CATEGORY;

$tot = 0;

$tot += count($WPCLEANFIX_USERMETA->checkUserMeta(null, false));

$tot += $WPCLEANFIX_POSTS->checkRevisions(null, false);
$tot += $WPCLEANFIX_POSTS->checkAutodraft(null, false);
$tot += $WPCLEANFIX_POSTS->checkTrash(null, false);

$tot += count($WPCLEANFIX_POSTS->checkPostMeta(null, false));
$tot += count($WPCLEANFIX_POSTS->checkPostMetaEditLock(null, false));
$tot += count($WPCLEANFIX_POSTS->checkTags(null, false));
$tot += count($WPCLEANFIX_POSTS->checkPostsUsers(null, false));
$tot += count($WPCLEANFIX_POSTS->checkPostsUsers(null, false, 'page'));
$tot += count($WPCLEANFIX_POSTS->checkAttachment(null, false, 'page'));

$tot += count($WPCLEANFIX_CATEGORY->checkCategory(null, false));
$tot += count($WPCLEANFIX_CATEGORY->checkTermInTaxonomy(null, false));
$tot += count($WPCLEANFIX_CATEGORY->checkTaxonomyInTerm(null, false));

?>