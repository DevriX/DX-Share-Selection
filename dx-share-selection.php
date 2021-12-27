<?php
/**
 * Plugin Name: DX Share Selection
 * Plugin URI: https://devrix.com/
 * Plugin Author: nofeairnc
 * Description: DX Share Selection is a fork of WP Selected Text sharer aiming to share your selected text in social networks. Select a text/code snippet from your post/page and share it to various social media websites.
 * Version: 1.5
 * Author: DevriX
 * Author URI: https://devrix.com/
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package DX-Share-Selection
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'DXSS_VERSION' ) ) {
	define( 'DXSS_VERSION', '1.5' );
}
if ( ! defined( 'DXSS_DIR' ) ) {
	define( 'DXSS_DIR', dirname( __FILE__ ) );
}
if ( ! defined( 'DXSS_URL' ) ) {
	define( 'DXSS_URL', plugin_dir_url( __FILE__ ) );
}
if ( ! defined( 'DXSS_BASENAME' ) ) {
	define( 'DXSS_BASENAME', plugin_basename( __FILE__ ) );
}

// Load languages.
load_plugin_textdomain( 'dxss', false, basename( dirname( __FILE__ ) ) . '/languages/' );

// Include the files.
require_once 'src/class-dxss-share-selection.php';
require_once 'src/class-dxss-wpsr.php';
require_once 'src/class-dxss-option-helper.php';
require_once 'src/class-dxss-bitly.php';
require_once 'src/class-dxss-encryption.php';


$dxss_share_selection = new DXSS_Share_Selection();
register_activation_hook( __FILE__, array( $dxss_share_selection, 'dxss_plugin_activate' ) );
register_deactivation_hook( __FILE__, array( $dxss_share_selection, 'dxss_plugin_deactivate' ) );
