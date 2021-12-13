<?php
/**
 * Contains the integration files for DX Share Selection with WP Socializer
 *
 * @package DX-Share-Selection
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * DXSS_WPSR
 */
class DXSS_WPSR {

	/**
	 * Get links from WP-Socializer
	 */
	public static function dxss_wpsr_get_links() {

		if ( class_exists( 'WPSR_Lists' ) ) {
			$wpsr_socialsites_list = WPSR_Lists::social_icons();
			$i                     = 0;
			foreach ( $wpsr_socialsites_list as $key => $value ) {
				// Messenger needs fb-app-id.
				if ( in_array( $key, array( 'addtofavorites', 'fbmessenger', 'comments', 'phone', 'wechat' ), true ) ) {
					continue;
				}
				if ( 0 !== intval( $i ) ) {
					$temp_url = str_replace( '{permalink}', '{url}', $value['link'] );
					$temp_url = str_replace( array( '{excerpt}', '{excerpt-plain}' ), '%s', $temp_url );
					$temp_url = str_replace( '{title-plain}', '{title}', $temp_url );
					$temp_url = str_replace( '{short-url}', '{surl}', $temp_url );
					$temp_url = str_replace( '{twitter-username}', '', $temp_url );
					echo '<li><a href="#" rel="' . esc_html( $temp_url ) . '">' . esc_html( $value['name'] ) . '</a></li>';
				}
				$i++;
			}
		}
	}
}
