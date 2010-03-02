<?php
/**
 * Class for Manage Admin (back-end)
 *
 * @package         wp-bannerize
 * @subpackage      wp-bannerize_client
 * @author          =undo= <g.fazioli@saidmade.com>
 * @copyright       Copyright (C) 2010 Saidmade Srl
 * @version         2.3.2
 */
class WPCLEANFIX_ADMIN extends WPCLEANFIX_CLASS {

    function WPCLEANFIX_ADMIN() {
        /**
         * Suoerclass constructor
         */
        $this->WPCLEANFIX_CLASS();

        /**
         * Load localizations if available
         *
         * @since 0.1.0
         */
		load_plugin_textdomain ( 'wp-cleanfix' , false, 'wp-cleanfix/localization'  );

        $this->init();
    }

    /**
     * Init the default plugin options and re-load from WP
     *
     * @since 0.1.0
     */
    function init() {

        /**
         * Load all options in $this->options array
         */
        $this->getOptions();

        /**
         * Add option menu in Wordpress backend
         */
        add_action('admin_menu', 	array( &$this, 'add_menus') );

        /**
         * Add wp_enqueue_script for jQuery library
         *
         * @since 0.1.0
         */
        wp_enqueue_script('jquery');
        wp_enqueue_script('postbox');
        wp_enqueue_script('dashboard');

        /**
         * Add queue for style sheet
         *
         * @since 0.1.0
         */
        wp_register_style('wp-cleanfix-style-css', $this->url . "/css/style.css");
        wp_enqueue_style('wp-cleanfix-style-css');
        //wp_enqueue_style('dashboard');

        /**
         * Add main admin javascript
         *
         * @since 2.4.0
         */
		wp_enqueue_script ( 'wp-cleanfix-main-js' , $this->url . '/js/main.js' , array ( 'jquery' ) , '1.0.0' , true );
		wp_localize_script ( 'wp-cleanfix-main-js' , 'wpCleanFixMainL10n' , array (
                                                    'ajaxURL' => $this->url_ajax,
													'messageConfirm' => __( 'Attenzione!! Confermi questa operazione?'  , 'wp-cleanfix' )
													) );
        /**
         * Update some changed options
         *
         * @since 0.1.0
         */
        update_option( $this->options_key, $this->options);
    }

    /**
     * ADD OPTION PAGE TO WORDPRESS ENVIRORMENT
     *
     * Add callback for adding options panel
     *
     */
    function add_menus() {
        add_submenu_page("index.php", $this->plugin_name, $this->plugin_name, 10, $this->plugin_name, array(&$this, "menu"));
    }

    /**
     * Draw Options Panel
     */
    function menu() {
        global $wpdb, $_POST;

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
                    <div title="<?php  _e('Apri/Collassa', 'wp-cleanfix')?>" class="handlediv"></div>
                    <h3 class="hndle"><span>Links</span></h3>
                    <div class="inside">
                       <div style="text-align:center;margin-bottom:12px"><?php include_once('adv.php') ?></div>
                       <p style="text-align:center"><a href="http://www.saidmade.com">Saidmade Srl</a></p>
                       <p style="text-align:center"><a href="http://www.undolog.com">Research &amp; Development Blog</a></p>
                    </div>
                </div>

                <div id="sm_pnres" class="postbox">
                    <div title="<?php  _e('Apri/Collassa', 'wp-cleanfix')?>" class="handlediv"></div>
                    <h3 class="hndle"><span>Donate</span></h3>
                    <div class="inside">
                        <p style="text-align:center;font-family:Tahoma;font-size:10px">Developed by <a target="_blank" href="http://www.saidmade.com"><img alt="Saidmade" align="absmiddle" src="http://labs.saidmade.com/images/sm-a-80x15.png" border="0" /></a>
                            <br/>
                            more Wordpress plugins on <a target="_blank" href="http://labs.saidmade.com">labs.saidmade.com</a> and <a target="_blank" href="http://www.undolog.com">Undolog.com</a>
                            <br/>
                        </p>
                        <div>
                            <form style="text-align:center;width:auto;margin:0 auto" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                                <input type="hidden" name="cmd" value="_s-xclick">
                                <input type="hidden" name="hosted_button_id" value="3499468">
                                <input type="image" src="https://www.paypal.com/it_IT/IT/i/btn/btn_donateCC_LG.gif" name="submit" alt="PayPal - Il sistema di pagamento online più facile e sicuro!">
                                <img alt="" border="0" src="https://www.paypal.com/it_IT/i/scr/pixel.gif" width="1" height="1">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       <div class="has-sidebar sm-padded">
            <div id="post-body-content" class="has-sidebar-content">
                <div class="meta-box-sortables">

                    <div id="sm_rebuild" class="postbox">
                        <div title="<?php  _e('Apri/Collassa', 'wp-cleanfix')?>" class="handlediv"></div>
                        <h3 class="hndle"><span><?php  _e('Informazioni sul sistema', 'wp-cleanfix')?></span></h3>
                        <div class="inside">
                            
                            <?php require_once ('module/info.php') ?>

                        </div>
                    </div>

                    <div id="sm_rebuild" class="postbox">
                        <div title="<?php  _e('Apri/Collassa', 'wp-cleanfix')?>" class="handlediv"></div>
                        <h3 class="hndle"><span><?php  _e('Database', 'wp-cleanfix')?></span></h3>
                        <div class="inside">

                            <?php require_once ('module/database_view.php') ?>

                        </div>
                    </div>

                    <div id="sm_rebuild" class="postbox">
                        <div title="<?php  _e('Apri/Collassa', 'wp-cleanfix')?>" class="handlediv"></div>
                        <h3 class="hndle"><span><?php  _e('Posts', 'wp-cleanfix')?></span></h3>
                        <div class="inside">

                            <?php require_once ('module/posts_view.php') ?>

                        </div>
                    </div>

                    <div id="sm_rebuild" class="postbox">
                        <div title="<?php  _e('Apri/Collassa', 'wp-cleanfix')?>" class="handlediv"></div>
                        <h3 class="hndle"><span><?php  _e('Commenti', 'wp-cleanfix')?></span></h3>
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
     * Costruisce l'html per il bottone aggiorna
     *
     * @since 0.1.0
     * @param string $id
     */
    function button_refresh($id) { ?>
        <button title="<?php _e('Aggiorna', 'wp-cleanfix') ?>" id="<?php echo $id ?>" class="wp-cleanfix-refresh"><span><?php _e('Aggiorna', 'wp-cleanfix') ?></span></button>
    <?php
    }

    /**
     * Attach settings in Wordpress Plugins list
     */
    function register_plugin_settings( $pluginfile ) {
        add_action( 'plugin_action_links_' . basename( dirname( $pluginfile ) ) . '/' . basename( $pluginfile ), array( &$this, 'plugin_settings' ), 10, 4 );
    }

    function plugin_settings( $links ) {
        $settings_link = '<a href="index.php?page=WP CleanFix">' . __('Settings') . '</a>';
        array_unshift( $links, $settings_link );
        return $links;
    }

} // end of class

?>