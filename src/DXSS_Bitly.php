<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DXSS_Bitly {
	
	// Bitly shorten url
	static function dxss_shorten_url( $url ) {

		$dxss_settings    = DXSS_Option_Helper::fetch_settings_data();
		$dxss_bitly_token = $dxss_settings['bitly_token'];

		if ( empty( $dxss_bitly_token ) ) {
			return false;
		}

		if ( isset( $dxss_settings['bitly_token_encrypted'] ) ) {
			$dxss_bitly_token = DXSS_Encryption::decrypt( $dxss_bitly_token );
		}

		$appkey  = trim($dxss_bitly_token);
		$version = '4';

		$bitly = 'https://api-ssl.bitly.com/v' . $version . '/shorten';

		$response = wp_remote_post( $bitly, array(
			'headers'     => array( 'Content-Type' => 'application/json; charset=utf-8', 'Authorization' => 'Bearer ' . $appkey ),
			'body'        => json_encode( array( 'long_url' => $url ) ),
			'method'      => 'POST',
			'data_format' => 'body',
		) );

		if ( ! is_wp_error( $response ) && ! empty( $response['body'] ) ) {
			$response_arr = json_decode( $response['body'], true );

			if ( ! empty( $response_arr['link'] ) ) {
				return $response_arr['link'];
			}
		}

		return false;
	}
}