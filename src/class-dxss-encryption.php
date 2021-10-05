<?php
/**
 * Contains encrypting and decripting functions.
 *
 * @package DX-Share-Selection
 */

/**
 * DXSS_Encryption
 */
class DXSS_Encryption {
	/**
	 * Secret key for encryption.
	 *
	 * @var String $encrypt_secret
	 */
	private static $encrypt_secret = '2KwK<J)Uvmp/{AP}q;M-<2d(VZ]ELAF)W>3#,e2T$.Mg^;G9}r*RFsc6hF_-?>+SU97Tv9';
	/**
	 * Dumb token view.
	 *
	 * @var String $dumb_token_view
	 */
	public static $dumb_token_view = '*************************************';

	/**
	 * Encrypt's string.
	 *
	 * @param String $string The string to encrypt.
	 *
	 * @return string
	 */
	public static function encrypt( $string ) {

		$secret_key = self::$encrypt_secret;

		$cipher_method    = 'aes-128-ctr';
		$enc_key          = hash( 'sha256', $secret_key );
		$enc_iv           = openssl_random_pseudo_bytes( openssl_cipher_iv_length( $cipher_method ) );
		$encrypted_string = openssl_encrypt( $string, $cipher_method, $enc_key, 0, $enc_iv ) . '::' . bin2hex( $enc_iv );

		return $encrypted_string;
	}

	/**
	 * Decrypts string.
	 *
	 * @param String $encrypted_string The string to decrypt.
	 *
	 * @return false|string
	 */
	public static function decrypt( $encrypted_string ) {

		if ( empty( $encrypted_string ) ) {
			return '';
		}

		$secret_key = self::$encrypt_secret;

		list( $encrypted_string, $enc_iv ) = explode( '::', $encrypted_string );

		$cipher_method = 'aes-128-ctr';
		$enc_key       = hash( 'sha256', $secret_key );
		$string        = openssl_decrypt( $encrypted_string, $cipher_method, $enc_key, 0, hex2bin( $enc_iv ) );

		return $string;
	}
}
