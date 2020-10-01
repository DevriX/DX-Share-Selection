<?php

class DXSS_Option_Helper {
	private static $dxss_settings_data;

	private static $option_key = 'dxss_settings_data';

	private static $dxss_settings_data_default = array(
		'borderColor' => '#fff',
		'bgColor' => '#444',
		'titleColor' => '#f2f2f2',
		'hoverColor' => '#ffffcc',
		'textColor' => '#000',
		'titleTextColor' => '#000',
		'extraClass' => '',
		'element' => 'body',
		'scriptPlace' => '1',
		'truncateChars' => '115',
		'bitly_token' => ''
	);
	
	public static function fetch_settings_data() {
		// Return if already set
		if ( ! empty( self::$dxss_settings_data ) ) {
			return self::$dxss_settings_data;
		}

		// Fetch from DB
		self::$dxss_settings_data = get_option( self::$option_key );

		if ( empty( self::$dxss_settings_data ) ) {
			$searchUrl = get_bloginfo('url') . '/?s=%s';

			self::$dxss_settings_data = array_merge( self::$dxss_settings_data_default, array(
				'title' => __( 'Share this text ...', 'dxss' ),
				'lists' => "Search,$searchUrl,favicon\nTwitter,https://twitter.com/intent/tweet?text=%s {url},favicon",

			) );
		}

		return self::$dxss_settings_data;
	}

	public static function update_settings_data( $data ) {
		update_option( self::$option_key, $data );

		self::$dxss_settings_data = $data;
	}

	/**
	 * Return Default Settings
	 *
	 * @return string[]
	 */
	public static function get_default_settings_data() {
		return self::$dxss_settings_data_default;
	}
}
