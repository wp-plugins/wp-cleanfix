<?php
/**
 * Class for Manage Admin (back-end)
 *
 * @package			wp-cleanfix
 * @subpackage		wp-cleanfix_admin
 * @author			=undo= <g.fazioli@undolog.com>, <g.fazioli@saidmade.com>
 * @copyright		Copyright (C) 2010-2011 Saidmade Srl
 *
 */

/**
 * Include all Class Module
 */
require_once "module/module.php";
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
		//$this->init();
        add_action( 'plugins_loaded', array( $this, 'init' ), 1 );
	}

	/**
	 * Init the default plugin options and re-load from WP
	 *
	 * @since 0.1.0
	 */
	function init() {

		/**
		 * Add version control in options.
		 */
		$this->options = $tempOptions = array(
			'wp_cleanfix_version' => $this->version, 'toRepair' => 0, 'wpCleanFixEditor' => '0',
			'wpCleanFixReplaceFontsEditor' => '0', 'wpCleanFixFontEditorName' => 'Monaco',
			'wpCleanFixEditorHeight' => '500', 'wpCleanFixTextSize' => '14', 'wpCleanFixTextColor' => '888',
			'wpCleanFixAllowTags' => 'pre[id|name|class|style],iframe[align|longdesc|name|width|height|frameborder|scrolling|marginheight|marginwidth|src]',
			'wpCleanFixAdminBar' => '0', 'wpCleanFixToolsComodityAddHeader' => '', 'wpCleanFixBackgroundColor' => 0,
			'wpCleanFixToolsComodityAddFooter' => '', 'wpCleanFixToolsPostsLimitExcerptLength' => '0',
			'wpCleanFixActiveDebugger' => '0', 'wpCleanFixToolsPostsExcerptLength' => '40'

		);
		add_option($this->options_key, $this->options);

		/**
		 * Load localizations if available
		 *
		 * @since 0.1.0
		 */
		load_plugin_textdomain('wp-cleanfix', false, 'wp-cleanfix/localization');

		/**
		 * Load all options in $this->options array
		 */
		$this->options = get_option($this->options_key);

		if (!isset($this->options['wpCleanFixToolsComodityAddFooter'])) {
			update_option($this->options_key, $tempOptions);
			$this->options = get_option($this->options_key);
		}

		/**
		 * Add option menu in Wordpress backend
		 */
		add_action('admin_init', array($this, 'plugin_init'));
		add_action('admin_menu', array($this, 'plugin_setup'));
		add_action('admin_post_save_wp_cleanfix', array(&$this, 'on_save_changes'));
		add_filter('screen_layout_columns', array(&$this, 'on_screen_layout_columns'), 10, 2);

		/**
		 * Add Dashboard Widget
		 *
		 * @since 0.6.0
		 *
		 */
		add_action('wp_dashboard_setup', array(&$this, 'add_dashboard_widget'));

		if ($this->options['wpCleanFixActiveDebugger'] == '1') {
			add_action('wp_dashboard_setup', array(&$this, 'addDashboardDebug'));
		}

		/**
		 * Update some changed options
		 *
		 * @since 0.1.0
		 */
		update_option($this->options_key, $this->options);
	}

	function on_screen_layout_columns($columns, $screen) {
		if ($screen == $this->plugin_page) {
			$columns[$this->plugin_page] = 2;
		} else if ($screen == $this->tools_page) {
			$columns[$this->tools_page] = 2;
		}
		return $columns;
	}

	function on_save_changes() {
		// user permission check
		if (!current_user_can('manage_options')) {
			wp_die(__('Cheatin&#8217; uh?'));
		}
		// cross check the given referer
		check_admin_referer('wp-cleanfix-general');

		// process here your on $_POST validation and / or option saving

		// lets redirect the post request into get request (you may add additional params at the url, if you need to show save results
		wp_redirect($_POST['_wp_http_referer']);
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
		wp_register_style('wp-cleanfix-style-css', $this->url . '/css/style.css', false, kWPCleanFixVersion);

		$this->countRepair();
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
		wp_enqueue_script('common');
		wp_enqueue_script('postbox');
		wp_enqueue_script('wp-lists');

		/**
		 * Add main admin javascript
		 *
		 * @since 2.4.0
		 */
		wp_enqueue_script('wp-cleanfix-main-js', $this->url . '/js/main.js', array('jquery'), kWPCleanFixVersion, true);
		wp_localize_script('wp-cleanfix-main-js', 'wpCleanFixJavascriptLocalization', array(
																						   'ajaxURL' => $this->url_ajax,
																						   'messageConfirm' => __('Warning!! Are you sure to confirm this operation?', 'wp-cleanfix'),
																						   'notImplement' => __('Sorry! Be patient. Not yet implemented in this beta release', 'wp-cleanfix')));
	}

	/**
	 * Execute when plugin is showing on backend
	 *
	 * @since 2.0
	 * @return void
	 */
	function plugin_tools_scripts() {
		/**
		 * Add wp_enqueue_script for jQuery library
		 */
		wp_enqueue_script('common');
		wp_enqueue_script('postbox');
		wp_enqueue_script('wp-lists');

		/**
		 * Add main Tools Javascript
		 *
		 * @since 2.0
		 */
		wp_enqueue_script('wp-cleanfix-tools-js', $this->url . '/js/tools.js',
						  array('jquery'), kWPCleanFixVersion, true);
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
		// 1.3.3 - Administrator Only
		if (current_user_can(kWPCleanFixUserCapabilitiy)) {
			add_action('admin_print_scripts', array($this, 'plugin_admin_scripts'));
			add_action('admin_print_styles', array($this, 'plugin_admin_styles'));

			wp_add_dashboard_widget(kWPCleanFixDashboardReportKey, __('WP CleanFix - Summary Report', 'wp-cleanfix'),
									array(&$this, 'dashboard_widget_function'));
		}
	}

	function addDashboardDebug() {
		// 1.3.3 - Administrator Only
		if (current_user_can(kWPCleanFixUserCapabilitiy)) {
			add_action('admin_print_scripts', array($this, 'plugin_admin_scripts'));
			add_action('admin_print_styles', array($this, 'plugin_admin_styles'));

			if ( (defined('WP_DEBUG') && !WP_DEBUG) ||
				 (defined('WP_DEBUG_LOG') && !WP_DEBUG_LOG) ||
				 (defined('WP_DEBUG_DISPLAY') && WP_DEBUG_DISPLAY ) ) {
				add_action('admin_notices', function() {
						if (current_user_can('manage_options')) {
							?><div id="message" class="error"><?php
						_e('In order to turn on the log file, you must add these "define" in your WordPress wp-config.php file:', 'wp-cleanfix');
							var_dump(defined('WP_DEBUG_DISPLAY'));
							?><br/><code>define('WP_DEBUG', true);<br/>define('WP_DEBUG_LOG', true);<br/>
							define('WP_DEBUG_DISPLAY', false);<br/>
							ini_set('display_errors', 0);</code></div><?php

						}
					});
			}

			wp_add_dashboard_widget(kWPCleanFixDashboardDebuggerKey, __('WP CleanFix - Debug', 'wp-cleanfix'),
									array(&$this, 'dashboardDebugger'));
		}
	}

	function countRepair() {
		$tot = 0;
		require_once('module/badge.inc.php');
		return $tot;
	}

	function dashboardDebugger() {
		$logfile = ('../wp-content/debug.log'); // Enter the server path to your logs file here
		$displayErrorsLimit = 100; // The maximum number of errors to display in the widget
		$errorLengthLimit = 2300; // The maximum number of characters to display for each error
		$fileCleared = false;
		$userCanClearLog = current_user_can('manage_options');
		// Clear file?
		if ($userCanClearLog && isset($_GET["system-php-errors"]) && $_GET["system-php-errors"] == "clear") {
			$handle = fopen($logfile, "w");
			fclose($handle);
			$fileCleared = true;
		}
		// Read file
		if (file_exists($logfile)) {
			$errors = file($logfile);
			$errors = array_reverse($errors);
			if ($fileCleared) {
				echo '<p><em>' . __('File cleared.', 'wp-cleanfix') . '</em></p>';
			}
			if ($errors) {
				if ($errors > 1) {
					echo '<p>' . count($errors) . ' ' . __('errors found', 'wp-cleanfix');
				} else {
					echo '<p>' . count($errors) . ' ' . __('error found', 'wp-cleanfix');
				}
				if ($userCanClearLog) {
					echo' [ <b><a href="' . get_bloginfo('url') .
						'/wp-admin/?system-php-errors=clear" onclick="return confirm(\'' .
						__('Are you sure?', 'wp-cleanfix') . '\');">' . __('Clear Log File', 'wp-cleanfix') .
						'</a></b> ]';
				}
				echo '</p>';
				$filter = '';
				if (isset($_POST['wpCleanFixFilter']) && $_POST['wpCleanFixFilter'] != '') {
					$filter = $_POST['wpCleanFixFilter'];
				}
				echo '<div id="system-php-errors" style="height:250px;overflow:scroll;padding:2px;background-color:#333;border:1px solid #ccc;">';
				echo '<ol style="padding:0;margin:0;">';
				$i = 0;
				foreach ($errors as $error) {
					if ($filter != '' && stripos($error, $filter) === false)
						continue;
					echo '<li style="padding:2px 4px 6px;border-bottom:1px solid #666;font-family:Monaco;color:#fa0">';
					$errorOutput = preg_replace('/\[([^\]]+)\]/', '<b>[$1]</b>', $error, 1);
					if ($filter != '')
						$errorOutput = str_ireplace($filter,
													'<span style="color:#fff;font-weight:bold;text-shadow:0 0 2px #fff;margin:0 3px">' .
													$filter . '</span>', $errorOutput);
					if (strlen($errorOutput) > $errorLengthLimit) {
						echo substr($errorOutput, 0, $errorLengthLimit) . ' [...]';
					} else {
						echo $errorOutput;
					}
					echo '</li>';
					$i++;
					if ($i > $displayErrorsLimit) {
						echo'<li style="padding:2px;border-bottom:2px solid #ccc;"><em>' .
							__('More than ', 'wp-cleanfix') . ' ' . $displayErrorsLimit . ' ' .
							__('errors in log...', 'wp-cleanfix') . '</em></li>';
						break;
					}
				}
				echo '</ol></div>';
				?>
			<form style="margin:8px 0 0 0" name="wpCleanFixMonitor" method="post">
				<input style="width:80%;background:#444;color:#fa0;padding:6px 2px" type="text"
					   name="wpCleanFixFilter" value="<?php echo $filter ?>"/>
				<button><?php _e('Filter', 'wp-cleanfix') ?></button>
			</form>
				<?php

			} else {
				echo '<p>' . __('No such errors in log file.', 'wp-cleanfix') . '</p>';
			}
		} else {
			echo '<p><em>' . __('Error while reading the log file.', 'wp-cleanfix') . '</em></p>';
		}
	}

	/**
	 * Show content in Dashboard Widget
	 */
	function dashboard_widget_function() {
		global $WPCLEANFIX_DATABASE;
		global $WPCLEANFIX_USERMETA;
		global $WPCLEANFIX_POSTS;
		global $WPCLEANFIX_CATEGORY;
		//global $WPCLEANFIX_COMMENTS;

		$almost_one = 0;
		$tot = 0;

		// ---------------------------------------------------------------------
		// Database
		// ---------------------------------------------------------------------
		ob_start();
		$check = $WPCLEANFIX_DATABASE->checkTables(false);
		if ($check > 0) : $almost_one = 1 ?>
		<p><span class="wpcleanfix-warning"><?php printf(__('%s Kb tables gain', 'wp-cleanfix'), $check) ?></span></p>
			<?php endif; ?>

		<?php if ($almost_one == 1) :
			$o = ob_get_contents();
			ob_end_clean(); ?>
		<h4 class="wp-cleanfix-title-dashboard"><?php _e("Database", 'wp-cleanfix') ?></h4>
			<?php echo $o ?>
			<?php endif; ?>

		<?php
   // ---------------------------------------------------------------------
		// User Meta
		// ---------------------------------------------------------------------
		ob_start();
		$check = $WPCLEANFIX_USERMETA->checkUserMeta(null, false);
		if (count($check) > 0) : $almost_one = 2;
			$tot += count($check) ?>
		<p><span
				class="wpcleanfix-warning"><?php printf(__('%s unused User Meta', 'wp-cleanfix'), count($check)) ?></span>
		</p>
			<?php endif; ?>

		<?php if ($almost_one == 2) :
			$o = ob_get_contents();
			ob_end_clean(); ?>
		<h4 class="wp-cleanfix-title-dashboard"><?php _e("User Meta", 'wp-cleanfix') ?></h4>
			<?php echo $o ?>
			<?php endif; ?>

		<?php
   // ---------------------------------------------------------------------
		// Posts
		// ---------------------------------------------------------------------
		ob_start();
		$check = $WPCLEANFIX_POSTS->checkRevisions(null, false);
		if ($check > 0) : $almost_one = 3;
			$tot += $check ?>
		<p><span class="wpcleanfix-warning"><?php printf(__('%s Post Revisions', 'wp-cleanfix'), $check) ?></span></p>
			<?php endif; ?>

		<?php
  		$check = $WPCLEANFIX_POSTS->checkAutodraft(null, false);
		if ($check > 0) : $almost_one = 3;
			$tot += $check ?>
		<p><span class="wpcleanfix-warning"><?php printf(__('%s Auto Draft', 'wp-cleanfix'), $check) ?></span></p>
			<?php endif; ?>

		<?php
  		 $check = $WPCLEANFIX_POSTS->checkTrash(null, false);
		if ($check > 0) : $almost_one = 3;
			$tot += $check ?>
		<p><span class="wpcleanfix-warning"><?php printf(__('%s Post in Trash', 'wp-cleanfix'), $check) ?></span></p>
			<?php endif; ?>

		<?php
  		 $check = $WPCLEANFIX_POSTS->checkPostMeta(null, false);
		if (count($check) > 0) : $almost_one = 3;
			$tot += count($check) ?>
		<p><span
				class="wpcleanfix-warning"><?php printf(__('%s unused Post Meta', 'wp-cleanfix'), count($check)) ?></span>
		</p>
			<?php endif; ?>

		<?php
  		 $check = $WPCLEANFIX_POSTS->checkPostMetaEditLock(null, false);
		if (count($check) > 0) : $almost_one = 3;
			$tot += count($check) ?>
		<p><span
				class="wpcleanfix-warning"><?php printf(__('%s Post Meta Edit Lock', 'wp-cleanfix'), count($check)) ?></span>
		</p>
			<?php endif; ?>

		<?php
  		 $check = $WPCLEANFIX_POSTS->checkTags(null, false);
		if (count($check) > 0) : $almost_one = 3;
			$tot += count($check) ?>
		<p><span class="wpcleanfix-warning"><?php printf(__('%s unused Tags', 'wp-cleanfix'), count($check)) ?></span>
		</p>
			<?php endif; ?>

		<?php
  		 $check = $WPCLEANFIX_POSTS->checkPostsUsers(null, false);
		if (count($check) > 0) : $almost_one = 3;
			$tot += count($check) ?>
		<p><span
				class="wpcleanfix-warning"><?php printf(__('%s Posts without author', 'wp-cleanfix'), count($check)) ?></span>
		</p>
			<?php endif; ?>

		<?php
  		 $check = $WPCLEANFIX_POSTS->checkPostsUsers(null, false, 'page');
		if (count($check) > 0) : $almost_one = 3;
			$tot += count($check) ?>
		<p><span
				class="wpcleanfix-warning"><?php printf(__('%s Pages without author', 'wp-cleanfix'), count($check)) ?></span>
		</p>
			<?php endif; ?>

		<?php
  		 $check = $WPCLEANFIX_POSTS->checkAttachment(null, false, 'page');
		if (count($check) > 0) : $almost_one = 3;
			$tot += count($check) ?>
		<p><span
				class="wpcleanfix-warning"><?php printf(__('%s Attachment unlink', 'wp-cleanfix'), count($check)) ?></span>
		</p>
			<?php endif; ?>

		<?php if ($almost_one == 3) :
			$o = ob_get_contents();
			ob_end_clean(); ?>
		<h4 class="wp-cleanfix-title-dashboard"><?php _e("Posts", 'wp-cleanfix') ?></h4>
			<?php echo $o ?>
			<?php endif; ?>

		<?php
   // ---------------------------------------------------------------------
		// Category
		// ---------------------------------------------------------------------
		ob_start();
		$check = $WPCLEANFIX_CATEGORY->checkCategory(null, false);
		if (count($check) > 0) : $almost_one = 4;
			$tot += count($check) ?>
		<p><span
				class="wpcleanfix-warning"><?php printf(__('%s unused Categories', 'wp-cleanfix'), count($check)) ?></span>
		</p>
			<?php endif; ?>

		<?php
  		 $check = $WPCLEANFIX_CATEGORY->checkTermInTaxonomy(null, false);
		if (count($check) > 0) : $almost_one = 4;
			$tot += count($check) ?>
		<p><span
				class="wpcleanfix-warning"><?php printf(__('%s terms unlink in taxonomy', 'wp-cleanfix'), count($check)) ?></span>
		</p>
			<?php endif; ?>

		<?php
  		 $check = $WPCLEANFIX_CATEGORY->checkTaxonomyInTerm(null, false);
		if (count($check) > 0) : $almost_one = 4;
			$tot += count($check) ?>
		<p><span
				class="wpcleanfix-warning"><?php printf(__('%s taxonomy unlink in term', 'wp-cleanfix'), count($check)) ?></span>
		</p>
			<?php endif; ?>

		<?php if ($almost_one == 4) :
			$o = ob_get_contents();
			ob_end_clean(); ?>
		<h4 class="wp-cleanfix-title-dashboard"><?php _e("Categories", 'wp-cleanfix') ?></h4>
			<?php echo $o ?>
			<?php endif; ?>


		<?php
   // ---------------------------------------------------------------------
		// Report
		// ---------------------------------------------------------------------
		if ($almost_one) : ?>
		<p style="text-align:right"><a class="button rbutton"
									   href="admin.php?page=<?php echo $this->plugin_slug ?>-mainshow"><?php _e('Go to Repair', 'wp-cleanfix')?></a>
		</p>
			<?php else : ?>
		<p><?php _e('Nothing to Report', 'wp-cleanfix')?></p>
			<?php endif;

		$this->options['toRepair'] = $tot;
		update_option($this->options_key, $this->options);
		?>
	<p class="wp-cleanfix-copy" style="border-top:1px solid #aaa;padding-top:4px">&copy;copyright <a
			href="http://www.saidmade.com">saidmade
		srl</a>
	</p>
	<p style="border-top:1px solid #aaa;padding-top:4px;line-height:22px;font-size:12px;font-weight:bold"><?php _e('Look the new "CleanFix Tools" panel for to extend Wordpress features: utility, comodity and tools ', 'wp-cleanfix') ?>
		<a class="button-primary" href="<?php bloginfo('wpurl') ?>/wp-admin/admin.php?page=wp-cleanfixtools">CleanFix
			Tools</a></p>
		<?php

	}

	/**
	 * ADD OPTION PAGE TO WORDPRESS ENVIRORMENT
	 *
	 * Add callback for adding options panel
	 *
	 */
	function plugin_setup() {

		if (function_exists('add_menu_page')) {
			$this->plugin_page = add_menu_page($this->plugin_name, $this->plugin_name, kWPCleanFixUserCapabilitiy,
											   $this->directory . '-mainshow', array(&$this, 'menu'),
											   $this->uri . "/css/images/wp-cleanfix-16x16.png", 3);
		}

		$this->options['toRepair'] = $this->countRepair();
		update_option($this->options_key, $this->options);
		$itemTitle = $this->plugin_name;
		if ($this->options['toRepair'] != 0) {
			$itemTitle = sprintf('%s <span id="wpcleanfix_badge"><span class="update-plugins count-%d"><span class="update-count">%d</span></span></span>', __('Clean & Fix', 'wp-cleanfix'), $this->options['toRepair'], $this->options['toRepair']);
		}
		$this->plugin_page = add_submenu_page(
			$this->directory . '-mainshow', $this->plugin_name, $itemTitle, kWPCleanFixUserCapabilitiy,
			$this->directory . '-mainshow', array(&$this, 'menu'));


		add_action('load-' . $this->plugin_page, array($this, 'on_load_page'));
		add_action('admin_print_scripts-' . $this->plugin_page, array($this, 'plugin_admin_scripts'));
		add_action('admin_print_styles-' . $this->plugin_page, array($this, 'plugin_admin_styles'));

		$this->tools_page = add_submenu_page(
			$this->directory . '-mainshow', $this->plugin_name, __('Tools', 'wp-cleanfix'), kWPCleanFixUserCapabilitiy,
			$this->plugin_slug . 'tools', array(&$this, "tools"));

		add_action('load-' . $this->tools_page, array($this, 'on_tools_load_page'));
		add_action('admin_print_scripts-' . $this->tools_page, array($this, 'plugin_tools_scripts'));
		add_action('admin_print_styles-' . $this->tools_page, array($this, 'plugin_admin_styles'));
	}

	function on_tools_load_page() {
		// =undo= 2.0 beta
		add_meta_box('wp_cleanfix_tools_comodity', __('Comodity', 'wp-cleanfix'),
					 array(&$this, 'boxToolsComodity'), $this->tools_page, 'side', 'core');
		add_meta_box('wp_cleanfix_tools_editor', __('Extends Editor', 'wp-cleanfix'),
					 array(&$this, 'boxToolsEditor'), $this->tools_page, 'normal', 'core');
		add_meta_box('wp_cleanfix_tools_posts', __('Extends Posts', 'wp-cleanfix'),
					 array(&$this, 'boxToolsPosts'), $this->tools_page, 'normal', 'core');
		add_meta_box('wp_cleanfix_tools_debug', __('Debug', 'wp-cleanfix'),
					 array(&$this, 'boxToolsDebug'), $this->tools_page, 'normal', 'core');
	}

	function boxToolsComodity() {
		require_once ('module/tools_comodity_view.php');
	}

	function boxToolsEditor() {
		require_once ('module/tools_editor_view.php');
	}

	function boxToolsPosts() {
		require_once ('module/tools_posts_view.php');
	}

	function boxToolsDebug() {
		require_once ('module/tools_debug_view.php');
	}

	// -----------------------------------------------------------------------------------------------------------------

	function on_load_page() {
		add_meta_box('wp_cleanfix_information', __('Important informations', 'wp-cleanfix'),
					 array(&$this, 'boxInformation'), $this->plugin_page, 'side', 'core');
		add_meta_box('wp_cleanfix_database', __('Database', 'wp-cleanfix'),
					 array(&$this, 'boxDatabase'), $this->plugin_page, 'normal', 'core');
		add_meta_box('wp_cleanfix_users', __('Users', 'wp-cleanfix'),
					 array(&$this, 'boxUsers'), $this->plugin_page, 'normal', 'core');
		add_meta_box('wp_cleanfix_posts', __('Posts', 'wp-cleanfix'),
					 array(&$this, 'boxPosts'), $this->plugin_page, 'normal', 'core');
		add_meta_box('wp_cleanfix_categories', __('Categories', 'wp-cleanfix'),
					 array(&$this, 'boxCategories'), $this->plugin_page, 'normal', 'core');
		add_meta_box('wp_cleanfix_comments', __('Comments', 'wp-cleanfix'),
					 array(&$this, 'boxComments'), $this->plugin_page, 'normal', 'core');
	}

	function boxInformation() {
		require_once ('module/info.php');
	}

	function boxDatabase() {
		global $WPCLEANFIX_DATABASE;
		require_once ('module/database_view.php');
	}

	function boxUsers() {
		global $WPCLEANFIX_USERMETA;
		require_once ('module/usermeta_view.php');
	}

	function boxPosts() {
		global $WPCLEANFIX_POSTS;
		require_once ('module/posts_view.php');
	}

	function boxCategories() {
		global $WPCLEANFIX_CATEGORY;
		require_once ('module/category_view.php');
	}

	function boxComments() {
		global $WPCLEANFIX_COMMENTS;
		require_once ('module/comments_view.php');
	}

	/**
	 * Draw Tools Panel
	 */
	function tools() {
		global $screen_layout_columns;

		/**
		 * Any error flag
		 */
		$any_error = "";

		if (isset($_POST['command_action'])) {
			$any_error = __('Your settings have been saved.', 'wp-cleanfix');
		}

		/**
		 * Show error or OK
		 */
		if ($any_error != '') {
			echo '<div id="message" class="updated fade"><p>' . $any_error . '</p></div>';
		}
		?>

	<div class="wrap">

		<?php $this->saidmadeHeader() ?>

		<!-- <form action="admin-post.php" method="post" id="wp-cleanfix-form-postbox"> -->
		<?php wp_nonce_field('wp-cleanfix-tools'); ?>
		<?php wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false); ?>
		<?php wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false); ?>
		<input type="hidden" name="action" value="save_wp_cleanfix_tools"/>


		<div id="poststuff"
			 class="metabox-holder<?php echo 2 == $screen_layout_columns ? ' has-right-sidebar' : ''; ?>">
			<div id="side-info-column" class="inner-sidebar">
				<?php do_meta_boxes($this->tools_page, 'side', ""); ?>
			</div>
			<div id="post-body" class="has-sidebar">
				<div id="post-body-content" class="has-sidebar-content">
					<?php do_meta_boxes($this->tools_page, 'normal', ""); ?>
				</div>
			</div>
			<br class="clear"/>
		</div>

		<!-- </form> -->
		<script type="text/javascript">
			//<![CDATA[
			jQuery(document).ready(function() {
				// close postboxes that should be closed
				jQuery('.if-js-closed').removeClass('if-js-closed').addClass('closed');
				// postboxes setup
				postboxes.add_postbox_toggles('<?php echo $this->tools_page; ?>');

			});
			//]]>
		</script>
	</div>

		<?php

	}


	/**
	 * Draw Options Panel
	 */
	function menu() {
		global $screen_layout_columns;

		/**
		 * Any error flag
		 */
		$any_error = "";

		if (isset($_POST['command_action'])) {
			$any_error = __('Your settings have been saved.', 'wp-cleanfix');
		}

		/**
		 * Show error or OK
		 */
		if ($any_error != '') {
			echo '<div id="message" class="updated fade"><p>' . $any_error . '</p></div>';
		}
		?>

	<div class="wrap">

		<?php $this->saidmadeHeader(true) ?>

		<!-- <form action="admin-post.php" method="post" id="wp-cleanfix-form-postbox"> -->
		<?php wp_nonce_field('wp-cleanfix-general'); ?>
		<?php wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false); ?>
		<?php wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false); ?>
		<input type="hidden" name="action" value="save_wp_cleanfix"/>


		<div id="poststuff"
			 class="metabox-holder<?php echo 2 == $screen_layout_columns ? ' has-right-sidebar' : ''; ?>">
			<div id="side-info-column" class="inner-sidebar">
				<?php do_meta_boxes($this->plugin_page, 'side', ""); ?>
			</div>
			<div id="post-body" class="has-sidebar">
				<div id="post-body-content" class="has-sidebar-content">
					<?php do_meta_boxes($this->plugin_page, 'normal', ""); ?>
				</div>
			</div>
			<br class="clear"/>
		</div>

		<!-- </form> -->
		<script type="text/javascript">
			//<![CDATA[
			jQuery(document).ready(function() {
				// close postboxes that should be closed
				jQuery('.if-js-closed').removeClass('if-js-closed').addClass('closed');
				// postboxes setup
				postboxes.add_postbox_toggles('<?php echo $this->plugin_page; ?>');

			});
			//]]>
		</script>
	</div>

		<?php

	}

	/**
	 * Build HTML output for refresh button
	 *
	 * @since 0.1.0
	 * @param string $id
	 */
	function button_refresh($id) {
		?>
	<button title="<?php _e('Refresh', 'wp-cleanfix') ?>" id="<?php echo $id ?>" class="wp-cleanfix-refresh">
		<span><?php _e('Refresh', 'wp-cleanfix') ?></span></button>
		<?php

	}

	/**
	 * Build HTML output for refresh all button
	 *
	 * @since 1.0.0
	 * @param <type> $id
	 */
	function button_refresh_all($id) {
		?>
	<button title="<?php _e('Refresh All', 'wp-cleanfix') ?>" id="<?php echo $id ?>" class="wp-cleanfix-refresh">
		<span><?php _e('Refresh All', 'wp-cleanfix') ?></span></button>
		<?php

	}

	/**
	 * Attach settings in Wordpress Plugins list
	 */
	function register_plugin_settings($pluginfile) {
		$this->plugin_file = $pluginfile;
		add_action('plugin_action_links_' . basename(dirname($pluginfile)) . '/' . basename($pluginfile),
				   array(&$this, 'plugin_settings'), 10, 4);
		add_filter('plugin_row_meta', array(&$this, 'add_plugin_links'), 10, 2);
	}

	/**
	 * Add links on installed plugin list
	 */
	function add_plugin_links($links, $file) {
		if ($file == plugin_basename($this->plugin_file)) {
			$links[] = '<strong style="color:#fa0">' . __('For more info and plugins visit', 'wp-cleanfix') .
					   ' <a href="http://www.saidmade.com">Saidmade</a></strong>';
		}
		return $links;
	}

	/**
	 * Add setting to plugin list
	 *
	 * @param array $links
	 * @return array
	 */
	function plugin_settings($links) {
		$settings_link = '<a href="admin.php?page=wp-cleanfix-mainshow">' . __('Clean & Fix') . '</a>';
		array_unshift($links, $settings_link);
		return $links;
	}

	/**
	 * Comodity: echo saidmade WP Bannerize header
	 *
	 * @return void
	 */
	function saidmadeHeader($bottom = false) {
		?>
	<div class="wp_cleanfix_box">
		<div class="wp_cleanfix_copy_info">
        </div>
		<a class="wp_cleanfix_logo" href="http://en.saidmade.com/products/wordpress/wp-cleanfix/">
			<?php echo $this->plugin_name ?> ver. <?php echo $this->version ?>
		</a>
		<?php if ($bottom) : ?>
		<p><?php _e('Look the new "CleanFix Tools" panel for to extend Wordpress features: utility, comodity and tools ', 'wp-cleanfix') ?>
			<a class="button-primary" href="<?php bloginfo('wpurl') ?>/wp-admin/admin.php?page=wp-cleanfixtools">CleanFix
				Tools</a></p>
		<?php endif; ?>
	</div><?php

	}

} // end of class

?>