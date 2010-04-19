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

?>
<table class="widefat wp-cleanfix" width="100%" cellpadding="4" cellspacing="0">
    <thead>
        <tr>
            <th scope="col"><?php $this->button_refresh_all('buttonCategoryRefreshAll') ?></th>
            <th scope="col"><?php _e('Action', 'wp-cleanfix') ?></th>
            <th width="100%" scope="col"><?php _e('Status', 'wp-cleanfix') ?></th>
        </tr>
    </thead>

    <tbody>

        <tr>
            <td><?php $this->button_refresh('buttonCategoryUnusedRefresh') ?></td>
            <td>
                <strong><?php _e('Unused Categories', 'wp-cleanfix') ?></strong>
            </td>
            <td>
                <div id="category-unused">
                    <?php $WPCLEANFIX_CATEGORY->checkCategory() ?>
                </div>
            </td>
        </tr>

        <tr>
            <td><?php $this->button_refresh('buttonTermsUnlinkRefresh') ?></td>
            <td>
                <strong><?php _e('Unlink Terms', 'wp-cleanfix') ?></strong>
            </td>
            <td>
                <div id="terms-unlink">
                    <?php $WPCLEANFIX_CATEGORY->checkTermInTaxonomy(); ?>
                </div>
            </td>
        </tr>

        <tr>
            <td><?php $this->button_refresh('buttonTermTaxonomyUnlinkRefresh') ?></td>
            <td>
                <strong><?php _e('Unlink Taxonomy', 'wp-cleanfix') ?></strong>
            </td>
            <td>
                <div id="termtaxonomy-unlink">
                    <?php $WPCLEANFIX_CATEGORY->checkTaxonomyInTerm() ?>
                </div>
            </td>
        </tr>

    </tbody>

</table>