<?php
/**
 * Class for Manage Admin (back-end)
 *
 * @package         wp-cleanfix
 * @subpackage      wp-cleanfix_admin
 * @author          =undo= <g.fazioli@saidmade.com>
 * @copyright       Copyright (C) 2010 Saidmade Srl
 * 
 */


/**
 * Include all Class Module
 */
require_once "module/database.php";
require_once "module/usermeta.php";
require_once "module/posts.php";
require_once "module/category.php";
require_once "module/comments.php";

class WPCLEANFIX_ADMIN extends WPCLEANFIX_CLASS {

    function WPCLEANFIX_ADMIN() {
		// super
		$this->WPCLEANFIX_CLASS();

		// Init
        $this->init();
    }

    /**
     * Init the default plugin options and re-load from WP
     *
     * @since 0.1.0
     */
    function init() {
		/**
		 * Load localizations if available
		 *
		 * @since 0.1.0
		 */
		load_plugin_textdomain ( 'wp-cleanfix' , false, 'wp-cleanfix/localization' );

        /**
         * Load all options in $this->options array
         */
        $this->options = get_option( $this->options_key );;

        /**
         * Add option menu in Wordpress backend
         */
 		add_action('admin_init', array( $this, 'plugin_init') );
        add_action('admin_menu', array( $this, 'plugin_setup') );

        /**
         * Add Dashboard Widget
         *
         * @since 0.6.0
         *
         */
        add_action('wp_dashboard_setup', array( &$this, 'add_dashboard_widget') );

        /**
         * Update some changed options
         *
         * @since 0.1.0
         */
        update_option( $this->options_key, $this->options);
    }

	/**
	 * Register style for plugin
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function plugin_init() {
        /**
         * Add queue for style sheet
         *
         * @since 0.1.0
         */
        wp_register_style('wp-cleanfix-style-css', $this->url . "/css/style.css");
        
	}

    /**
	 * Execute when plugin is showing on backend
	 *
	 * @since 1.0.0
	 * @return void
	 */
    function plugin_admin_scripts() {
        /**
         * Add wp_enqueue_script for jQuery library
         *
         * @since 0.1.0
         */
        wp_enqueue_script('jquery');
        wp_enqueue_script('postbox');
        wp_enqueue_script('dashboard');

        /**
         * Add main admin javascript
         *
         * @since 2.4.0
         */
		wp_enqueue_script ( 'wp-cleanfix-main-js' , $this->url . '/js/main.js' , array ( 'jquery' ) , '1.4' , true );
		wp_localize_script ( 'wp-cleanfix-main-js' , 'wpCleanFixMainL10n' , array (
                                                    'ajaxURL'           => $this->url_ajax,
													'messageConfirm'    => __( 'Warning!! Are you sure to confirm this operation?', 'wp-cleanfix' ),
                                                    'notImplement'      => __( 'Sorry! Be patient. Not yet implemented in this beta release', 'wp-cleanfix' )
													) );
    }

	/**
	 * Execute when plugin is showing on backend
	 *
	 * @sine 1.0.0
	 * @return void
	 */
    function plugin_admin_styles() {
       wp_enqueue_style('wp-cleanfix-style-css');
    }

    /**
     * Add Dashboard Widget
     *
     * @since 0.6.0
     *
     */
    function add_dashboard_widget() {
        add_action( 'admin_print_scripts', array($this, 'plugin_admin_scripts') );
		add_action( 'admin_print_styles', array($this, 'plugin_admin_styles') );

        wp_add_dashboard_widget( $this->options_key, __('WP CleanFix - Summary Report', 'wp-cleanfix'), array(&$this, 'dashboard_widget_function') );
    }

    /**
     * Show content in Dashboard Widget
     */
    function dashboard_widget_function() {
        global $WPCLEANFIX_DATABASE;
        global $WPCLEANFIX_USERMETA;
        global $WPCLEANFIX_POSTS;
        global $WPCLEANFIX_CATEGORY;
        global $WPCLEANFIX_COMMENTS;

        $almost_one = 0;

        // ---------------------------------------------------------------------
        // Database
        // ---------------------------------------------------------------------
        ob_start();
        $check = $WPCLEANFIX_DATABASE->checkTables(false);
        if( $check > 0 ) : $almost_one = 1 ?>
            <p><span class="wpcleanfix-warning"><?php printf(__('%s Kb tables gain', 'wp-cleanfix'), $check ) ?></span></p>
        <?php endif; ?>

        <?php if( $almost_one == 1 ) :
            $o = ob_get_contents();
            ob_end_clean(); ?>
            <h4 class="wp-cleanfix-title-dashboard"><?php _e("Database", 'wp-cleandfix') ?></h4>
            <?php echo $o ?>
        <?php endif; ?>

        <?php
        // ---------------------------------------------------------------------
        // User Meta
        // ---------------------------------------------------------------------
        ob_start();
        $check = $WPCLEANFIX_USERMETA->checkUserMeta(null, false);
        if( count($check) > 0 ) : $almost_one = 2 ?>
            <p><span class="wpcleanfix-warning"><?php printf(__('%s unused User Meta', 'wp-cleanfix'), count($check) ) ?></span></p>
        <?php endif; ?>

        <?php if( $almost_one == 2 ) :
            $o = ob_get_contents();
            ob_end_clean(); ?>
            <h4 class="wp-cleanfix-title-dashboard"><?php _e("User Meta", 'wp-cleandfix') ?></h4>
            <?php echo $o ?>
        <?php endif; ?>

        <?php
        // ---------------------------------------------------------------------
        // Posts
        // ---------------------------------------------------------------------
        ob_start();
        $check = $WPCLEANFIX_POSTS->checkRevisions(null, false);
        if( $check > 0 ) : $almost_one = 3; ?>
            <p><span class="wpcleanfix-warning"><?php printf(__('%s Post Revisions', 'wp-cleanfix'), $check ) ?></span></p>
        <?php endif; ?>

        <?php
        $check = $WPCLEANFIX_POSTS->checkPostMeta(null, false);
        if( count($check) > 0 ) : $almost_one = 3; ?>
            <p><span class="wpcleanfix-warning"><?php printf(__('%s unused Post Meta', 'wp-cleanfix'), count($check) ) ?></span></p>
        <?php endif; ?>

        <?php
        $check = $WPCLEANFIX_POSTS->checkTags(null, false);
        if( count($check) > 0 ) : $almost_one = 3; ?>
            <p><span class="wpcleanfix-warning"><?php printf(__('%s unused Tags', 'wp-cleanfix'), count($check) ) ?></span></p>
        <?php endif;  ?>

        <?php
        $check = $WPCLEANFIX_POSTS->checkPostsUsers(null, false);
        if( count($check) > 0 ) : $almost_one = 3; ?>
            <p><span class="wpcleanfix-warning"><?php printf(__('%s Posts without author', 'wp-cleanfix'), count($check) ) ?></span></p>
        <?php endif;  ?>

        <?php
        $check = $WPCLEANFIX_POSTS->checkPostsUsers(null, false, 'page');
        if( count($check) > 0 ) : $almost_one = 3; ?>
            <p><span class="wpcleanfix-warning"><?php printf(__('%s Pages without author', 'wp-cleanfix'), count($check) ) ?></span></p>
        <?php endif;  ?>

        <?php
        $check = $WPCLEANFIX_POSTS->checkAttachment(null, false, 'page');
        if( count($check) > 0 ) : $almost_one = 3; ?>
            <p><span class="wpcleanfix-warning"><?php printf(__('%s Attachment unlink', 'wp-cleanfix'), count($check) ) ?></span></p>
        <?php endif;  ?>

        <?php if( $almost_one == 3 ) :
            $o = ob_get_contents();
            ob_end_clean(); ?>
            <h4 class="wp-cleanfix-title-dashboard"><?php _e("Posts", 'wp-cleandfix') ?></h4>
            <?php echo $o ?>
        <?php endif; ?>

        <?php
        // ---------------------------------------------------------------------
        // Category
        // ---------------------------------------------------------------------
        ob_start();
        $check = $WPCLEANFIX_CATEGORY->checkCategory(null, false);
        if( count($check) > 0 ) : $almost_one = 4 ?>
            <p><span class="wpcleanfix-warning"><?php printf(__('%s unused Categories', 'wp-cleanfix'), count($check) ) ?></span></p>
        <?php endif; ?>

        <?php
        $check = $WPCLEANFIX_CATEGORY->checkTermInTaxonomy(null, false);
        if( count($check) > 0 ) : $almost_one = 4 ?>
            <p><span class="wpcleanfix-warning"><?php printf(__('%s terms unlink in taxonomy', 'wp-cleanfix'), count($check) ) ?></span></p>
        <?php endif; ?>

        <?php
        $check = $WPCLEANFIX_CATEGORY->checkTaxonomyInTerm(null, false);
        if( count($check) > 0 ) : $almost_one = 4 ?>
            <p><span class="wpcleanfix-warning"><?php printf(__('%s taxonomy unlink in term', 'wp-cleanfix'), count($check) ) ?></span></p>
        <?php endif; ?>

        <?php if( $almost_one == 4 ) :
            $o = ob_get_contents();
            ob_end_clean(); ?>
            <h4 class="wp-cleanfix-title-dashboard"><?php _e("Categories", 'wp-cleandfix') ?></h4>
            <?php echo $o ?>
        <?php endif; ?>


        <?php
        // ---------------------------------------------------------------------
        // Report
        // ---------------------------------------------------------------------
        if($almost_one) : ?>
            <p style="text-align:right"><a class="button rbutton" href="/wp-admin/index.php?page=WP CleanFix"><?php _e('Go to Repair', 'wp-cleanfix')?></a></p>
        <?php else : ?>
            <p><?php _e('Nothing to Report', 'wp-cleanfix')?></p>
        <?php endif;

		echo '<p class="wp-cleanfix-copy" style="border-top:1px solid #aaa;padding-top:4px">©copyright <a href="http://www.saidmade.com">saidmade srl</a></p>';
    }

    /**
     * ADD OPTION PAGE TO WORDPRESS ENVIRORMENT
     *
     * Add callback for adding options panel
     *
     */
    function plugin_setup() {
        $plugin_page = add_submenu_page("index.php", $this->plugin_name, $this->plugin_name, 10, $this->plugin_name, array(&$this, "menu"));
        add_action( 'admin_print_scripts-'. $plugin_page, array($this, 'plugin_admin_scripts') );
		add_action( 'admin_print_styles-'. $plugin_page, array($this, 'plugin_admin_styles') );
    }

    /**
     * Draw Options Panel
     */
    function menu() {
        global $wpdb;
        global $WPCLEANFIX_DATABASE;
        global $WPCLEANFIX_USERMETA;
		global $WPCLEANFIX_POSTS;
        global $WPCLEANFIX_CATEGORY;
        global $WPCLEANFIX_COMMENTS;

        /**
         * Any error flag
         */
        $any_error = "";

        if( isset( $_POST['command_action'] ) ) {
            $any_error = __('Your settings have been saved.', 'wp-cleanfix');
        }

        /**
         * Show error or OK
         */
        if( $any_error != '') {
            echo '<div id="message" class="updated fade"><p>' . $any_error . '</p></div>';
        }
        ?>

<div class="wrap">
    <div class="icon32" id="icon-options-general"><br/></div>
    <h2><?=$this->plugin_name?> ver. <?=$this->version?></h2>

    <div id="poststuff" class="metabox-holder has-right-sidebar">
        <div class="inner-sidebar">
            <div id="side-sortables" class="meta-box-sortabless ui-sortable" style="position: relative;">

                <div id="sm_pnres" class="postbox">
                    <div title="<?php  _e('Open/Collapse', 'wp-cleanfix')?>" class="handlediv"></div>
                    <h3 class="hndle"><span>Links</span></h3>
                    <div class="inside">
                       <div style="text-align:center;margin-bottom:12px"><?php include_once('adv.php') ?></div>
                       <p style="text-align:center"><a href="http://labs.saidmade.com">Labs Saidmade</a></p>
                       <p style="text-align:center"><a href="http://www.undolog.com">Research &amp; Development Blog</a></p>
                    </div>
                </div>

                <div id="sm_pnres" class="postbox">
                    <div title="<?php  _e('Open/Collapse', 'wp-cleanfix')?>" class="handlediv"></div>
                    <h3 class="hndle"><span>Donate</span></h3>
                    <div class="inside">
                        <p style="text-align:center;font-family:Tahoma;font-size:10px">Developed by <a target="_blank" href="http://www.saidmade.com"><img alt="Saidmade" align="absmiddle" src="http://labs.saidmade.com/images/sm-a-80x15.png" border="0" /></a>
                            <br/>
                            more Wordpress plugins on <a target="_blank" href="http://labs.saidmade.com">labs.saidmade.com</a> and <a target="_blank" href="http://www.undolog.com">Undolog.com</a>
                            <br/>
                        </p>
                        <div>
                            <form style="text-align:center;width:auto;margin:0 auto" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                                <input type="hidden" name="cmd" value="_s-xclick" />
                                <input type="hidden" name="hosted_button_id" value="3499468" />
                                <input type="image" src="https://www.paypal.com/it_IT/IT/i/btn/btn_donateCC_LG.gif" name="submit" alt="PayPal - Il sistema di pagamento online pi˘ facile e sicuro!" />
                                <img alt="" border="0" src="https://www.paypal.com/it_IT/i/scr/pixel.gif" width="1" height="1" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       <div class="has-sidebar sm-padded">
            <div id="post-body-content" class="has-sidebar-content">
                <div class="meta-box-sortables">

                    <div class="postbox">
                        <div title="<?php  _e('Open/Collapse', 'wp-cleanfix')?>" class="handlediv"></div>
                        <h3 class="hndle"><span><?php  _e('Important informations', 'wp-cleanfix')?></span></h3>
                        <div class="inside">
                            
                            <?php require_once ('module/info.php') ?>

                        </div>
                    </div>

                    <div class="postbox">
                        <div title="<?php  _e('Open/Collapse', 'wp-cleanfix')?>" class="handlediv"></div>
                        <h3 class="hndle"><span><?php  _e('Database', 'wp-cleanfix')?></span></h3>
                        <div class="inside">

                            <?php require_once ('module/database_view.php') ?>

                        </div>
                    </div>

                    <div class="postbox">
                        <div title="<?php  _e('Open/Collapse', 'wp-cleanfix')?>" class="handlediv"></div>
                        <h3 class="hndle"><span><?php  _e('Users', 'wp-cleanfix')?></span></h3>
                        <div class="inside">

                            <?php require_once ('module/usermeta_view.php') ?>

                        </div>
                    </div>

                    <div class="postbox">
                        <div title="<?php  _e('Open/Collapse', 'wp-cleanfix')?>" class="handlediv"></div>
                        <h3 class="hndle"><span><?php  _e('Posts', 'wp-cleanfix')?></span></h3>
                        <div class="inside">

                            <?php require_once ('module/posts_view.php') ?>

                        </div>
                    </div>

                    <div class="postbox">
                        <div title="<?php  _e('Open/Collapse', 'wp-cleanfix')?>" class="handlediv"></div>
                        <h3 class="hndle"><span><?php  _e('Categories', 'wp-cleanfix')?></span></h3>
                        <div class="inside">

                            <?php require_once ('module/category_view.php') ?>

                        </div>
                    </div>

                    <div class="postbox">
                        <div title="<?php  _e('Open/Collapse', 'wp-cleanfix')?>" class="handlediv"></div>
                        <h3 class="hndle"><span><?php  _e('Comments', 'wp-cleanfix')?></span></h3>
                        <div class="inside">

                            <?php require_once ('module/comments_view.php') ?>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

    <?php
    }

    /**
     * Build HTML output for refresh button
     *
     * @since 0.1.0
     * @param string $id
     */
    function button_refresh($id) { ?>
        <button title="<?php _e('Refresh', 'wp-cleanfix') ?>" id="<?php echo $id ?>" class="wp-cleanfix-refresh"><span><?php _e('Refresh', 'wp-cleanfix') ?></span></button>
    <?php
    }

    /**
     * Build HTML output for refresh all button
     *
     * @since 1.0.0
     * @param <type> $id
     */
    function button_refresh_all($id) { ?>
        <button title="<?php _e('Refresh All', 'wp-cleanfix') ?>" id="<?php echo $id ?>" class="wp-cleanfix-refresh"><span><?php _e('Refresh All', 'wp-cleanfix') ?></span></button>
    <?php
    }

    /**
     * Attach settings in Wordpress Plugins list
     */
    function register_plugin_settings( $pluginfile ) {
        $this->plugin_file = $pluginfile;
        add_action( 'plugin_action_links_' . basename( dirname( $pluginfile ) ) . '/' . basename( $pluginfile ), array( &$this, 'plugin_settings' ), 10, 4 );
        add_filter( 'plugin_row_meta',  array(&$this, 'add_plugin_links'), 10, 2);
    }

    /**
	 * Add links on installed plugin list
	 */
	function add_plugin_links($links, $file) {
        if( $file == plugin_basename( $this->plugin_file ) ) {
            $links[] = '<strong style="color:#fa0">' . __('For more info and plugins visit', 'wp-cleanfix') . ' <a href="http://labs.saidmade.com">Labs Saidmade</a></strong>';
        }
		return $links;
	}

    /**
     * Add setting to plugin list
     * 
     * @param <type> $links
     * @return <type>
     */
    function plugin_settings( $links ) {
        $settings_link = '<a href="index.php?page=WP CleanFix">' . __('Settings') . '</a>';
        array_unshift( $links, $settings_link );
        return $links;
    }

} // end of class

?>