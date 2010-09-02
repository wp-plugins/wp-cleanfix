<?php
/**
 * Main class for subclassing backend and frontend class
 *
 * @package         wp-cleanfix
 * @subpackage      wp-cleanfix_class
 * @author          =undo= <g.fazioli@saidmade.com>
 * @copyright       Copyright (C) 2010 Saidmade Srl
 *
 */

class WPCLEANFIX_CLASS {

    /**
     * Plugin version (see above)
     *
     * @since 0.1.0
     * @var string
     */
    var $version 						= "1.4.3";

    /**
     * WP-CLEANFIX release.minor.revision
     * See split below
     *
     * @since 0.1.0
     * @var integer
     */
    var $release                        = 0;
    var $minor                          = 0;
    var $revision                       = 0;

    /**
     * Plugin name
     *
     * @since 0.1.0
     * @var string
     */
    var $plugin_name 					= "WP CleanFix";

    /**
     * Added for Fix Administrator Permission Warning
     * 
     * @since 1.2.0
     * @var string
     */
    var $plugin_slug                    = "wp-cleanfix";

    /**
     * Setting from main file to __FILE__
     * 
     * @since 0.6.0
     * @var string
     */
    var $plugin_file                    = "";

	/**
	 * Handle Option Admin Page Item
	 *
	 * @since 1.3.5
	 * @var handle
	 */
	var $plugin_page;

    /**
     * Key for database options
     *
     * @since 0.1.0
     * @var string
     */
    var $options_key 					= "wp-cleanfix";

    /**
     * Options array containing all options for this plugin
     *
     * @since 0.1.0
     * @var array
     */
    var $options						= array();


    /**
     * This plugin url: http://domain.com/wp-content/plugins/wp-cleanfix
     *
     * @since 0.1.0
     * @var string
     */
    var $url                            = "";

    /**
     * URL del gateway Ajax
     *
     * @since 0.1.0
     * @var string
     */

	var $url_ajax                        = "";

	/**
	 * Standard PHP 4 constructor
	 *
	 * @since 0.1.0
	 * @global object $wpdb
	 */
	function WPCLEANFIX_CLASS() {
		global $wpdb;

		/**
		 * Split version for more detail
		 */
		$split_version  = explode(".", $this->version);
		$this->release  = $split_version[0];
		$this->minor    = $split_version[1];
		$this->revision = $split_version[2];
        /**
         * Build the common and usefull path
         */
        $this->url          = plugins_url("", __FILE__);
        $this->url_ajax     = $this->url . '/wp-cleanfix-ajax.php';

        if (! defined('WP_CONTENT_DIR'))
            define('WP_CONTENT_DIR', ABSPATH . 'wp-content');

        if (! defined('WP_CONTENT_URL'))
            define('WP_CONTENT_URL', get_option('siteurl') . '/wp-content');

        if (! defined('WP_ADMIN_URL'))
            define('WP_ADMIN_URL', get_option('siteurl') . '/wp-admin');

        if (! defined('WP_PLUGIN_DIR'))
            define('WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins');

        if (! defined('WP_PLUGIN_URL'))
            define('WP_PLUGIN_URL', WP_CONTENT_URL . '/plugins');

    }

} // end of class
?>