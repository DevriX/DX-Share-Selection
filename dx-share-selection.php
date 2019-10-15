<?php
/*
Plugin Name: DX Share Selection
Plugin URI: http://www.devwp.eu/
Plugin Author: nofeairnc
Description: DX Share Selection is a fork of WP Selected Text sharer aiming to share your selected text in social networks. Select a text/code snippet from your post/page and share it to various social media websites.
Version: 1.2
Author URI: http://www.devwp.eu/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

define('DXSS_VERSION', '1.2');
define('DXSS_AUTHOR', 'Mario Peshev');

if (!defined('WP_CONTENT_URL')) {
	$dxss_pluginpath = get_option('siteurl') . '/wp-content/plugins/' . plugin_basename(dirname(__FILE__)) . '/';
} else {
	$dxss_pluginpath = WP_CONTENT_URL . '/plugins/' . plugin_basename(dirname(__FILE__)) . '/';
}

## Load languages
load_plugin_textdomain('dxss', false, basename(dirname(__FILE__)) . '/languages/');

## Include the files
require_once( 'integration.php' );
require_once( 'dxss-option-helper.php' );

## WPSTS Is active check
function dxss_is_active(){
    if (get_option("dxss_active") == 1) {
        return 1;
    } else{
		return 0;
    }
}

## WPSTS plugin activate
function dxss_plugin_activate(){
	update_option("dxss_active", 1);
}
register_deactivation_hook(__FILE__, 'dxss_plugin_activate');

## WPSTS plugin deactivate
function dxss_plugin_deactivate(){
	update_option("dxss_active", 0);
}
register_deactivation_hook(__FILE__, 'dxss_plugin_deactivate');

## Admin Notices
function dxss_admin_notices(){
	if( isset( $_GET['page'] ) && !dxss_is_active() && $_GET['page'] != 'dx-share-selection'){
		echo '<div class="updated fade"><p>' . __('<b>DX Share Selection</b> plugin is intalled. You should immediately adjust <a href="options-general.php?page=dx-share-selection">the settings</a>', 'dxss') . '</p></div>';
	}
}
add_action('admin_notices', 'dxss_admin_notices');

## Action Links
function dxss_plugin_actions($links, $file){
	static $this_plugin;
	if(!$this_plugin) $this_plugin = plugin_basename(__FILE__);
	if( $file == $this_plugin ){
		$settings_link = '<a href="options-general.php?page=dx-share-selection">' . __('Settings', 'dxss') . '</a> ' . __('Support', 'dxss') . '</a>';
		$links = array_merge( array($settings_link), $links);
	}
	return $links;
}
add_filter('plugin_action_links', 'dxss_plugin_actions', 10, 2);

## Load the Javascripts
function dxss_admin_js() {
	global $dxss_pluginpath;
	$admin_js_url = $dxss_pluginpath . 'dxss-admin-js.js';
	$color_url = $dxss_pluginpath . '/js/farbtastic/farbtastic.js';
	$dxss_js = $dxss_pluginpath . '/dxss/jquery.selected-text-sharer.min.js';

	if (isset($_GET['page']) && $_GET['page'] == 'dx-share-selection') {
		wp_enqueue_script('jquery');
		wp_enqueue_script('dx-share-selection', $admin_js_url, array('jquery'));
		wp_enqueue_script('farbtastic', $color_url, array('jquery', 'dx-share-selection'));
		wp_enqueue_script('dxss_js', $dxss_js, array('jquery', 'dx-share-selection', 'farbtastic'));
	}
}
add_action('admin_enqueue_scripts', 'dxss_admin_js');

## Load the admin CSS
function dxss_admin_css() {
	global $dxss_pluginpath;

	if (isset($_GET['page']) && $_GET['page'] == 'dx-share-selection') {
		wp_enqueue_style('dxss-admin-css', $dxss_pluginpath . 'dxss-admin-css.css');
		wp_enqueue_style('farbtastic-css', $dxss_pluginpath . '/js/farbtastic/farbtastic.css');
	}
}

add_action('admin_enqueue_scripts', 'dxss_admin_css');

## Bitly shorten url
function dxss_shorten_url($url, $format = 'xml'){

	## Get the Options
	$dxss_settings = DXSS_Option_Helper::fetch_settings_data();
	$dxss_bitly = $dxss_settings['bitly'];
	$bityly_split = explode(',', $dxss_bitly);

	if($bityly_split[0] == '' || $bityly_split[1] ==''){
		return false;
	}

	$login = trim($bityly_split[0]);
	$appkey = trim($bityly_split[1]);
	$version = '2.0.1';

	$bitly = 'http://api.bit.ly/shorten?version=' . $version . '&longUrl=' . urlencode($url) . '&login=' . $login . '&apiKey='.$appkey . '&format=' . $format;

	$response = file_get_contents($bitly);

	if(strtolower($format) == 'json'){
		$json = @json_decode($response,true);
		return $json['results'][$url]['shortUrl'];
	}
	else{
		$xml = simplexml_load_string($response);
		return 'http://bit.ly/' . $xml->results->nodeKeyVal->hash;
	}
}

## One function for getting the url and title of the page
function dxss_get_post_details(){
	// Get the global variables
	global $post;

	// Inside loop
	$permalink_inside_loop = get_permalink($post->ID);
	$title_inside_loop = str_replace('+', '%20', get_the_title($post->ID));

	// Outside loop
	$permalink_outside_loop = (!empty($_SERVER['HTTPS'])) ? "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] : "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	$title_outside_loop = str_replace('+', '%20', wp_title('', 0));
	// If title is null
	if($title_outside_loop == ''){
		$title_outside_loop = str_replace('+', '%20', get_bloginfo('name'));
	}

	if(in_the_loop()){
		$details = array(
			'permalink' => $permalink_inside_loop,
			'title' => $title_inside_loop
		);

	}else{
		$details = array(
			'permalink' => $permalink_outside_loop,
			'title' => $title_outside_loop
		);
	}

	return $details;
}

## Get processed list
function dxss_get_processed_list(){
	global $post;

	$info = dxss_get_post_details();
	$rss = get_bloginfo('rss_url');
	$blogname = urlencode(get_bloginfo('name') . ' ' . get_bloginfo('description'));

	$terms = array(
		'{url}', '{title}',
		'{surl}', '{blogname}',
		'{rss-url}'
	);
	$replacable = array(
		$info['permalink'], $info['title'],
		dxss_shorten_url($info['permalink'], 'json'), $blogname,
		$rss
	);

	## Get the Options
	$dxss_settings = DXSS_Option_Helper::fetch_settings_data();
	$dxss_lists = $dxss_settings['lists'];

	$listExplode = explode("\n", $dxss_lists);
	$listImplode = implode('|', $listExplode);
	$list = str_replace("\r","", $listImplode);

	$listFinal = str_replace($terms, $replacable, $list);
	return $listFinal;
}

## Enqueue Scripts to the wordpress
add_action('wp_enqueue_scripts', 'dxss_scripts');
function dxss_scripts() {
	global $dxss_pluginpath;

	## Get the Options
	$dxss_settings = DXSS_Option_Helper::fetch_settings_data();
	$dxss_scriptPlace = $dxss_settings['scriptPlace'];

    wp_enqueue_script('wp-selected-text-searcher', $dxss_pluginpath . 'dxss/dev/jquery.selected-text-sharer.js', array('jquery'), null, $dxss_scriptPlace);
}

## Activate Jquery the Jquery
function dxss_jquery_plugin_activate(){

	## Get the Options
	$dxss_settings = DXSS_Option_Helper::fetch_settings_data();

	$dxss_title = $dxss_settings['title'];
	$dxss_lists = $dxss_settings['lists'];

	$dxss_borderColor = $dxss_settings['borderColor'];
	$dxss_bgColor = $dxss_settings['bgColor'];
	$dxss_titleColor = $dxss_settings['titleColor'];
	$dxss_hoverColor = $dxss_settings['hoverColor'];
	$dxss_textColor = $dxss_settings['textColor'];
	$dxss_extraClass = $dxss_settings['extraClass'];

	$dxss_element = $dxss_settings['element'];
	$dxss_scriptPlace = $dxss_settings['scriptPlace'];
	$dxss_truncateChars = $dxss_settings['truncateChars'];

		echo "\n".
"<script type='text/javascript'>
/* <![CDATA[ */
	jQuery(document).ready(function(){
		jQuery('body').selectedTextSharer({
			title : '$dxss_title',
			lists : '" . dxss_get_processed_list() . "',
			truncateChars : '$dxss_truncateChars',
			extraClass : '$dxss_extraClass',
			borderColor : '$dxss_borderColor',
			background : '$dxss_bgColor',
			titleColor : '$dxss_titleColor',
			hoverColor : '$dxss_hoverColor',
			textColor : '$dxss_textColor'
		});
	});
/* ]]>*/
</script>\n";
}
add_action('wp_footer', 'dxss_jquery_plugin_activate');

## Add the Admin menu
add_action('admin_menu', 'dxss_addpage');

function dxss_addpage() {
    add_submenu_page('options-general.php', 'DX Share Selection', 'DX Share Selection', 'manage_options', 'dx-share-selection', 'dxss_admin_page');
}

function dxss_admin_page(){
	global $dxss_pluginpath;
	$dxss_updated = false;

	if ( ! empty( $_POST["dxss_submit"] ) ) {
		## Get and store options
		$dxss_settings['title'] = $_POST['dxss_title'];
		$dxss_settings['lists'] = preg_replace('/^[ \t]*[\r\n]+/m', "", trim(stripslashes($_POST['dxss_lists'])));

		$dxss_settings['borderColor'] = $_POST['dxss_borderColor'];
		$dxss_settings['bgColor'] = $_POST['dxss_bgColor'];
		$dxss_settings['titleColor'] = $_POST['dxss_titleColor'];
		$dxss_settings['hoverColor'] = $_POST['dxss_hoverColor'];
		$dxss_settings['textColor'] = $_POST['dxss_textColor'];
		$dxss_settings['extraClass'] = $_POST['dxss_extraClass'];

		$dxss_settings['scriptPlace'] = $_POST['dxss_scriptPlace'];
		$dxss_settings['truncateChars'] = $_POST['dxss_truncateChars'];
		$dxss_settings['element'] = $_POST['dxss_element'];
		$dxss_settings['bitly'] = $_POST['dxss_bitly'];
		$dxss_settings['grepElement'] = $_POST['dxssgrep_element'];

		$dxss_settings['dxss_is_activate'] = 1;
		DXSS_Option_Helper::update_settings_data( $dxss_settings );
		$dxss_updated = true;

		if(get_option("dxss_active") == 0){
			update_option("dxss_active", 1);
		}

	}

	if($dxss_updated == true){
		echo "<div class='message updated'><p>Updated successfully</p></div>";
	}

	## Get the Options
	$dxss_settings = DXSS_Option_Helper::fetch_settings_data();

	$dxss_title = $dxss_settings['title'];
	$dxss_lists = $dxss_settings['lists'];

	$dxss_borderColor = $dxss_settings['borderColor'];
	$dxss_bgColor = $dxss_settings['bgColor'];
	$dxss_titleColor = $dxss_settings['titleColor'];
	$dxss_hoverColor = $dxss_settings['hoverColor'];
	$dxss_textColor = $dxss_settings['textColor'];
	$dxss_extraClass = $dxss_settings['extraClass'];
	$dxssgrep_element = $dxss_settings['grepElement'];

	$dxss_element = $dxss_settings['element'];
	$dxss_scriptPlace = $dxss_settings['scriptPlace'];
	$dxss_truncateChars = $dxss_settings['truncateChars'];
	$dxss_bitly = $dxss_settings['bitly'];
    /* Load the admin menu html
     * It has php and html mixed up, so a simple readfile() won't work.
     */
    require 'dxss.html';
}

?>
