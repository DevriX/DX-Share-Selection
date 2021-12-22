<?php
/**
 * Contains functions to manage options.
 *
 * @package DX-Share-Selection
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * DXSS_Option_Helper
 */
class DXSS_Option_Helper {
	/**
	 * The settings.
	 *
	 * @var mixed $dxss_settings
	 */
	private static $dxss_settings;
	/**
	 * The options key.
	 *
	 * @var String $option_key
	 */
	private static $option_key = 'dxss_settings_data';

	/**
	 * Fetch the settings data.
	 *
	 * @return mixed
	 */
	public static function fetch_settings_data() {
		// Return if already set.
		if ( ! empty( self::$dxss_settings ) ) {
			return self::$dxss_settings;
		}

		// Fetch from DB.
		$dxss_settings = get_option( self::$option_key );

		if ( empty( $dxss_settings ) ) {
			$search_url = get_bloginfo( 'url' ) . '/?s=%s';

			$dxss_settings = array_merge(
				self::get_default_settings_data(),
				array(
					'title' => __( 'Share this text...', 'dxss' ),
					'lists' => "Search,$search_url,favicon\nTwitter,https://twitter.com/intent/tweet?text=%s {url},favicon",
				)
			);
		}

		// If user have not previously set Title Text Color use Text Color.
		if ( ! isset( $dxss_settings['titleTextColor'] ) && ! empty( $dxss_settings['textColor'] ) ) {
			$dxss_settings['titleTextColor'] = $dxss_settings['textColor'];
		}

		// If user used the old Bitly Settings, set the token value from there.
		if ( ! isset( $dxss_settings['bitly_token'] ) && ! empty( $dxss_settings['bitly'] ) ) {
			$bityly_split = explode( ',', $dxss_settings['bitly'] );
			if ( ! empty( $bityly_split[1] ) ) {
				$dxss_settings['bitly_token'] = $bityly_split[1];
			}
		}

		self::$dxss_settings = $dxss_settings;

		return self::$dxss_settings;
	}

	/**
	 * Update the settings data.
	 *
	 * @param mixed $data The data.
	 */
	public static function update_settings_data( $data ) {
		update_option( self::$option_key, $data );

		self::$dxss_settings = $data;
	}

	/**
	 * Get the bitly token.
	 *
	 * @param String $bitly_token The bitly token.
	 * @return String
	 */
	public static function get_bitly_token( $bitly_token ) {

		$dxss_old_settings = self::fetch_settings_data();
		if ( array_key_exists( 'bitly_token', $dxss_old_settings ) ) {
			$old_token = $dxss_old_settings['bitly_token'];
		} else {
			$old_token = '';
		}

		// If user have set a token, before encryption was implemented and it's not changed, encrypt the token before save.
		if ( ! isset( $dxss_old_settings['bitly_token_encrypted'] ) && ! empty( $old_token ) && DXSS_Encryption::$dumb_token_view === $bitly_token ) {
			// This will run only once.
			$bitly_token = DXSS_Encryption::encrypt( $old_token );

			// Normal save scenario.
		} else {
			// The user has not changed the previously encrypted token.
			if ( DXSS_Encryption::$dumb_token_view === $bitly_token ) {
				$bitly_token = $old_token;
				// The user has entered new token value.
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
			'borderColor'    => '#7a7a7a',
			'bgColor'        => '#aaaaaa',
			'titleColor'     => '#f2f2f2',
			'titleTextColor' => '#000',
			'hoverColor'     => '#ffffcc',
			'textColor'      => '#000',
			'extraClass'     => '',
			'scriptPlace'    => '1',
			'truncateChars'  => '115',
			'element'        => 'body',
			'bitly_token'    => '',
			'deactDesktop'   => 'deactivate',
			'deactMobile'    => 'deactivate',
		);
	}
}
