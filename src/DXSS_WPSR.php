<?php
/** DX Share Selection
 * Contains the integration files for DX Share Selection with WP Socializer
 * v 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DXSS_WPSR {
	
	// Get links from WP-Socializer
	static function dxss_wpsr_get_links() {

		if ( class_exists( 'WPSR_Lists' ) ) {
			$wpsr_socialsites_list = WPSR_Lists::social_icons();
			$i                     = 0;
			foreach ( $wpsr_socialsites_list as $key => $value ) {
				//Messenger needs fb-app-id
				if ( in_array( $key, array( 'addtofavorites', 'fbmessenger' ) ) ) {
					continue;
				}
				if ( 0 != $i ) {
					$tempUrl = str_replace( '{permalink}', '{url}', $value['link'] );
					$tempUrl = str_replace( array( '{excerpt}', '{excerpt-plain}' ), '%s', $tempUrl );
					$tempUrl = str_replace( '{title-plain}', '{title}', $tempUrl );
					$tempUrl = str_replace( '{short-url}', '{surl}', $tempUrl );
					$tempUrl = str_replace( '{twitter-username}', '', $tempUrl );
					echo '<li><a href="#" rel="' . $tempUrl . '">' . $key . '</a></li>';
				}
				$i ++;
			}
		}
	}
}