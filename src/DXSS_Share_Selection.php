<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DXSS_Share_Selection {

	public function __construct() {
		add_action( 'admin_notices', array( $this, 'dxss_admin_notices' ) );
		add_filter( 'plugin_action_links', array( $this, 'dxss_plugin_actions' ), 10, 2 );
		add_action( 'admin_enqueue_scripts', array( $this, 'dxss_admin_js' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'dxss_admin_css' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'dxss_scripts' ) );
		add_action( 'admin_menu', array( $this, 'dxss_addpage' ) );
		add_action( 'wp_footer', array( $this, 'dxss_jquery_plugin_activate' ) );
	}

	// WPSTS Is active check
	public function dxss_is_active() {
		if ( 1 == get_option( 'dxss_active' ) ) {
			return 1;
		} else {
			return 0;
		}
	}

	// WPSTS plugin activate
	public function dxss_plugin_activate() {
		update_option( 'dxss_active', 1 );
	}

	// Admin Notices
	public function dxss_admin_notices() {
		if ( isset( $_GET['page'] ) && ! $this->dxss_is_active() && 'dx-share-selection' != $_GET['page'] ) {
			echo '<div class="updated fade"><p>' . __( '<b>DX Share Selection</b> plugin is intalled. You should immediately adjust <a href="options-general.php?page=dx-share-selection">the settings</a>', 'dxss' ) . '</p></div>';
		}
	}

	// Action Links
	public function dxss_plugin_actions( $links, $file ) {
	
		if ( $file == DXSS_BASENAME ) {
			$settings_link = '<a href="options-general.php?page=dx-share-selection">' . __( 'Settings', 'dxss' ) . '</a> ' . __( 'Support', 'dxss' ) . '</a>';
			$links         = array_merge( array( $settings_link ), $links );
		}

		return $links;
	}

	// Load the Javascripts
	public function dxss_admin_js() {
		$admin_js_url = DXSS_URL . 'assets/dist/js/dxss-admin-js.min.js';
		$dxss_js      = DXSS_URL . 'assets/dist/js/selected-text-sharer.min.js';
		$color_url    = DXSS_URL . 'js/farbtastic/farbtastic.js';

		if ( isset( $_GET['page'] ) && 'dx-share-selection' == $_GET['page'] ) {
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'dx-share-selection', $admin_js_url, array( 'jquery' ) );
			wp_localize_script( 'dx-share-selection', 'dx_share_selection', array(
					'settings_data_default' => DXSS_Option_Helper::get_default_settings_data()
				)
			);
			wp_enqueue_script( 'farbtastic', $color_url, array( 'jquery', 'dx-share-selection' ) );
			wp_enqueue_script( 'dxss_js', $dxss_js, array( 'jquery', 'dx-share-selection', 'farbtastic' ) );
		}

	}

	// Load the admin CSS
	public function dxss_admin_css() {
		if ( isset( $_GET['page'] ) && 'dx-share-selection' == $_GET['page'] ) {
			wp_enqueue_style( 'dsxx-css', DXSS_URL . 'assets/dist/css/dxss-css.min.css' );
			wp_enqueue_style( 'dxss-admin-css', DXSS_URL . 'assets/dist/css/dxss-admin-css.min.css' );
			wp_enqueue_style( 'farbtastic-css', DXSS_URL . '/js/farbtastic/farbtastic.css' );
		}
	}

	

	// One function for getting the url and title of the page
	public function dxss_get_post_details() {
		// Get the global variables
		global $post;

		// Inside loop
		$permalink_inside_loop = get_permalink( $post->ID );
		$title_inside_loop     = str_replace( '+', '%20', get_the_title( $post->ID ) );

		// Outside loop
		$permalink_outside_loop = ( ! empty( $_SERVER['HTTPS'] ) ) ? 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] : 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		$title_outside_loop     = str_replace( '+', '%20', wp_title( '', 0 ) );
		// If title is null
		if ( '' == $title_outside_loop ) {
			$title_outside_loop = str_replace( '+', '%20', get_bloginfo( 'name' ) );
		}

		if ( in_the_loop() ) {
			$details = array(
				'permalink' => $permalink_inside_loop,
				'title'     => $title_inside_loop,
			);

		} else {
			$details = array(
				'permalink' => $permalink_outside_loop,
				'title'     => $title_outside_loop,
			);
		}

		return $details;
	}


	// Get processed list
	public function dxss_get_processed_list() {
		global $post;

		$info     = $this->dxss_get_post_details();
		$rss      = get_bloginfo( 'rss_url' );
		$blogname = urlencode( get_bloginfo( 'name' ) . ' ' . get_bloginfo( 'description' ) );

		$terms      = array(
			'{url}',
			'{title}',
			'{blogname}',
			'{rss-url}',
		);
		$replacable = array(
			$info['permalink'],
			$info['title'],
			$blogname,
			$rss,
		);

		// Get the Options
		$dxss_settings = DXSS_Option_Helper::fetch_settings_data();
		$dxss_lists    = $dxss_settings['lists'];

		// Generate short url from Bit.ly only if needed
		if ( false !== mb_strpos( $dxss_lists, '{surl}' ) ) {
			$terms[]      = '{surl}';
			$replacable[] = DXSS_Bitly::dxss_shorten_url( $info['permalink'] );
		}

		$listExplode = explode( "\n", $dxss_lists );
		$listImplode = implode( '|', $listExplode );
		$list        = str_replace( "\r", '', $listImplode );

		$listFinal = str_replace( $terms, $replacable, $list );

		return $listFinal;
	}


	// Enqueue Scripts to the WordPress
	public function dxss_scripts() {
		// Get the Options
		$dxss_settings    = DXSS_Option_Helper::fetch_settings_data();
		$dxss_scriptPlace = $dxss_settings['scriptPlace'];

		$dxss_js = DXSS_URL . 'assets/dist/js/selected-text-sharer.min.js';

		wp_enqueue_style( 'dsxx-css', DXSS_URL . 'assets/dist/css/dxss-css.min.css' );
		wp_enqueue_script( 'wp-selected-text-searcher', $dxss_js, array( 'jquery' ), null, $dxss_scriptPlace );
	}


	// Activate Jquery Selector element
	public function dxss_jquery_plugin_activate() {

		// Get the Options
		$dxss_settings = DXSS_Option_Helper::fetch_settings_data();

		echo "\n" .
		     "<script type='text/javascript'>
				/* <![CDATA[ */
					jQuery(document).ready(function(){
						if(jQuery('" . $dxss_settings['element'] . "').length > 0){
							jQuery('" . $dxss_settings['element'] . "').selectedTextSharer({
								title : '".$dxss_settings['title']."',
								lists : '" . $this->dxss_get_processed_list() . "',
								truncateChars : '".$dxss_settings['truncateChars']."',
								extraClass : '".$dxss_settings['extraClass']."',
								borderColor : '".$dxss_settings['borderColor']."',
								background : '".$dxss_settings['bgColor']."',
								titleColor : '".$dxss_settings['titleColor']."',
								hoverColor : '".$dxss_settings['hoverColor']."',
								textColor : '".$dxss_settings['textColor']."',
								titleTextColor : '".$dxss_settings['titleTextColor']."'
							});
						}
					});
				/* ]]>*/
				</script>\n";
	}


	// Add the Admin menu
	public function dxss_addpage() {
		add_submenu_page( 'options-general.php', 'DX Share Selection', 'DX Share Selection', 'manage_options', 'dx-share-selection', array($this,'dxss_admin_page') );
	}

	public function dxss_save_options(){
		$dxss_updated = false;
		// Get and store options
		$dxss_settings['title'] = $_POST['dxss_title'];
		$dxss_settings['lists'] = preg_replace( '/^[ \t]*[\r\n]+/m', '', trim( stripslashes( $_POST['dxss_lists'] ) ) );

		$dxss_settings['borderColor']    = $_POST['dxss_borderColor'];
		$dxss_settings['bgColor']        = $_POST['dxss_bgColor'];
		$dxss_settings['titleColor']     = $_POST['dxss_titleColor'];
		$dxss_settings['hoverColor']     = $_POST['dxss_hoverColor'];
		$dxss_settings['textColor']      = $_POST['dxss_textColor'];
		$dxss_settings['titleTextColor'] = $_POST['dxss_titleTextColor'];
		$dxss_settings['extraClass']     = $_POST['dxss_extraClass'];

		$dxss_settings['scriptPlace']   = $_POST['dxss_scriptPlace'];
		$dxss_settings['truncateChars'] = $_POST['dxss_truncateChars'];
		$dxss_settings['element']       = $_POST['dxss_element'];
		$dxss_settings['bitly_token']   = $_POST['dxss_bitly_token'];

		$dxss_settings['dxss_is_activate'] = 1;
		DXSS_Option_Helper::update_settings_data( $dxss_settings );
		$dxss_updated = true;

		if ( 0 == get_option( 'dxss_active' ) ) {
			update_option( 'dxss_active', 1 );
		}

		if ( true == $dxss_updated ) {
			echo "<div class='message updated'><p>Updated successfully</p></div>";
		}
	}


	public function dxss_admin_page() {
		if ( ! empty( $_POST['dxss_submit'] ) ) {
			$this->dxss_save_options();
		}
		
		// Get the Options
		$dxss_settings = DXSS_Option_Helper::fetch_settings_data();

		// Load the admin menu html
		require DXSS_DIR . '/templates/dxss.php';
	}
}