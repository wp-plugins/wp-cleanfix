<?php
/**
 * Category management
 *
 * @package         wp-cleanfix
 * @subpackage      category_view
 * @author          =undo= <g.fazioli@saidmade.com>
 * @copyright       Copyright (C) 2010 Saidmade Srl
 * 
 */

require_once 'category.php';

?>
<table class="widefat wp-cleanfix" width="100%" cellpadding="4" cellspacing="0">
    <thead>
        <tr>
            <th scope="col" width="64"><?php _e('Refresh', 'wp-cleanfix') ?></th>
            <th width="200" scope="col"><?php _e('Action', 'wp-cleanfix') ?></th>
            <th scope="col"><?php _e('Status', 'wp-cleanfix') ?></th>
        </tr>
    </thead>

    <tbody>

        <tr>
            <td><?php $this->button_refresh('buttonCategoryUnusedRefresh') ?></td>
            <td>
                <strong><?php _e('Categories', 'wp-cleanfix') ?></strong>
            </td>
            <td>
                <div id="category-unused">
                    <?php wpcleanfix_category_show_unused() ?>
                </div>
            </td>
        </tr>

        <tr>
            <td><?php $this->button_refresh('buttonTermsUnlinkRefresh') ?></td>
            <td>
                <strong><?php _e('Terms', 'wp-cleanfix') ?></strong>
            </td>
            <td>
                <div id="terms-unlink">
                    <?php wpcleanfix_terms_show_unlink_to_taxonomy() ?>
                </div>
            </td>
        </tr>

        <tr>
            <td><?php $this->button_refresh('buttonTermTaxonomyUnlinkRefresh') ?></td>
            <td>
                <strong><?php _e('Taxonomy', 'wp-cleanfix') ?></strong>
            </td>
            <td>
                <div id="termtaxonomy-unlink">
                    <?php wpcleanfix_termtaxonomy_show_unlink_to_terms() ?>
                </div>
            </td>
        </tr>

    </tbody>

</table>


