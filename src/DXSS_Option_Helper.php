<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DXSS_Option_Helper {
	private static $dxss_settings;
	private static $option_key = 'dxss_settings_data';
	
	public static function fetch_settings_data() {
		// Return if already set
		if ( ! empty( self::$dxss_settings ) ) {
			return self::$dxss_settings;
		}

		// Fetch from DB
		$dxss_settings = get_option( self::$option_key );

		if ( empty( $dxss_settings ) ) {
			$searchUrl = get_bloginfo( 'url' ) . '/?s=%s';

			$dxss_settings = array_merge( self::get_default_settings_data(), array(
				'title' => __( 'Share this text ...', 'dxss' ),
				'lists' => "Search,$searchUrl,favicon\nTwitter,https://twitter.com/intent/tweet?text=%s {url},favicon",

			) );
		}

		// If user have not previously set Title Text Color use Text Color
		if ( ! isset( $dxss_settings['titleTextColor'] ) && ! empty( $dxss_settings['textColor'] ) ) {
			$dxss_settings['titleTextColor'] = $dxss_settings['textColor'];
		}

		// If user used the old Bitly Settings, set the token value from there
		if ( ! isset( $dxss_settings['bitly_token'] ) && ! empty( $dxss_settings['bitly'] ) ) {
			$bityly_split = explode( ',', $dxss_settings['bitly'] );
			if ( ! empty( $bityly_split[1] ) ) {
				$dxss_settings['bitly_token'] = $bityly_split[1];
			}
		}

		self::$dxss_settings = $dxss_settings;

		return self::$dxss_settings;
	}

	public static function update_settings_data( $data ) {
		update_option( self::$option_key, $data );

		self::$dxss_settings = $data;
	}


	public static function get_bitly_token( $bitly_token ) {

		$dxss_old_settings = self::fetch_settings_data();
		$old_token         = $dxss_old_settings['bitly_token'];

		// If user have set a token, before encryption was implemented and it's not changed, encrypt the token before save
		if ( ! isset( $dxss_old_settings['bitly_token_encrypted'] ) && ! empty( $old_token ) && $bitly_token === DXSS_Encryption::$dumb_token_view ) {
			// This will run only once
			$bitly_token = DXSS_Encryption::encrypt( $old_token );

			// Normal save scenario	
		} else {
			// The user has not changed the previously encrypted token
			if ( $bitly_token === DXSS_Encryption::$dumb_token_view ) {
				$bitly_token = $old_token;
				// The user has entered new token value
			} elseif ( ! empty( $value ) ) {
				$bitly_token = DXSS_Encryption::encrypt( $bitly_token );
			}
		}

		return $bitly_token;
	}

	/**
	 * Return Default Settings
	 *
	 * @return string[]
	 */
	public static function get_default_settings_data() {
		return array(
			'borderColor'    => '#fff',
			'bgColor'        => '#444',
			'titleColor'     => '#f2f2f2',
			'hoverColor'     => '#ffffcc',
			'textColor'      => '#000',
			'titleTextColor' => '#000',
			'extraClass'     => '',
			'element'        => 'body',
			'scriptPlace'    => '1',
			'truncateChars'  => '115',
			'bitly_token'    => ''
		);
	}
}
