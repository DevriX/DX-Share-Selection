var lists = [];
lists.push( Array( '...', '#', 'favicon' ) );
lists.push( Array( 'Twitter', 'https://twitter.com/intent/tweet?text=%s {url}', 'favicon' ) );
lists.push( Array( 'Facebook', 'http://www.facebook.com/sharer.php?u={url}&quote=%s', 'favicon' ) );
lists.push( Array( 'Wikipedia (en)', 'http://en.wikipedia.org/w/index.php?title=Special:Search&search=%s', 'favicon' ) );
lists.push( Array( 'Google Maps', 'http://maps.google.com/?q=%s', 'favicon' ) );
lists.push( Array( 'Email', 'mailto:?subject={title}&amp;body=%s - {url}', 'http://mail.google.com/favicon.ico' ) );
lists.push( Array( 'Tumblr', 'https://www.tumblr.com/widgets/share/tool?url={url}&caption=%s', 'favicon' ) );

$j = jQuery.noConflict();

$j( document ).ready( function() {

	// Basic Admin Functions

	$j( '#colorpicker' ).hide();
	$j( '.helpWindow, .wpsrBox' ).hide();

	$j( '.message' ).append( '<span class="close">x</span>' );

	$j( '.message .close' ).click( function() {
		$j( this ).parent().slideUp();
	} );

	for ( i = 0; i < lists.length; i++ ) {
		$j( '#addList' ).append( '<option value="' + i + '">' + lists[i][0] + '</option>' );
	}
	$j( '#addList' ).append( '<option value="moreButtons">More buttons ...</option>' );


	$j( '#addList' ).change( function() {
		if ( $j( '#addList' ).val() == 'moreButtons' ) {
			$j( '.wpsrBox' ).fadeIn();
			$j( '#dxss_list_search' ).focus();
		} else {
			if ( $j( this ).val() > 0 ) {
				val = $j( '#dxss_lists' ).val() + '\n' + lists[$j( this ).val()];
				$j( '#dxss_lists' ).val( val );
			}
		}
	} );

	$j( '#addCustom' ).click( function() {
		customName = prompt( 'Enter the name of the button. Eg: Google, Wikipedia' );
		customUrl = prompt( 'Enter the Share URL of the site. Use %s in the URL for the selected text. See help for more terms', 'http://' );
		customIcon = prompt( 'Enter the Icon URL. Use "favicon" to automatically get the Icon', 'favicon' );

		if ( customName != null ) {
			val = $j( '#dxss_lists' ).val() + '\n' + customName + ',' + customUrl + ',' + customIcon;
			$j( '#dxss_lists' ).val( val );
		}

	} );

	$j( '#addSearch' ).click( function() {
		searchName = prompt( 'Enter the name of the button. Eg: Search my blog' );
		searchUrl = prompt( 'Enter the Search URL of your site. You can also use your google adsense search URL eg:http://domain.com/?s=%s', 'http://' );
		searchIcon = prompt( 'Enter the Icon URL. Use "favicon" to automatically get the Icon', 'favicon' );

		if ( searchName != null ) {
			val = $j( '#dxss_lists' ).val() + '\n' + searchName + ',' + searchUrl + ',' + searchIcon;
			$j( '#dxss_lists' ).val( val );
		}
	} );

	$j( '.openHelp' ).click( function() {
		$j( '.helpWindow' ).fadeIn();
	} );

	$j( '.closeHelp' ).click( function() {
		$j( '.helpWindow' ).fadeOut();
	} );

	$j( '.openWpsrLinks' ).click( function() {
		$j( '.wpsrBox' ).fadeIn();
		$j( '#dxss_list_search' ).focus();
	} );

	$j( '.closeLinks' ).click( function() {
		$j( '.wpsrBox' ).fadeOut();
	} );

	var f = $j.farbtastic( '#colorpicker' );
	$j( '.color' ).each( function() {
		f.linkTo( this );
	} ).focus( function() {
		f.linkTo( this );
	} );

	$j( '.color' ).focus( function() {
		$j( '#colorpicker' ).fadeIn();
	} );

	$j( '.color' ).blur( function() {
		$j( '#colorpicker' ).fadeOut();
	} );

	// Live search
	$j( '#dxss_list_search' ).keyup( function( event ) {
		var search_text = $j( '#dxss_list_search' ).val();
		var rg = new RegExp( search_text, 'i' );
		$j( '.dxss_wpsr_sites li' ).each( function() {
			if ( $j.trim( $j( this ).text() ).search( rg ) == -1 ) {
				$j( this ).css( 'display', 'none' );
			} else {
				$j( this ).css( 'display', '' );
			}
		} );
	} );

	$j( '.dxss_wpsr_sites a' ).click( function() {
		val = $j( '#dxss_lists' ).val() + '\n' + $j( this ).text() + ',' + decodeURIComponent( $j( this ).attr( 'rel' ) ) + ',' + 'favicon';
		$j( '#dxss_lists' ).val( val );
		$j( this ).after( '<span class="addedInfo">  Added !</span>' );
		$j( '.addedInfo' ).fadeOut( '100' );
	} );

	$j( '.preview' ).hover( function() {
		listVal = $j( '#dxss_lists' ).val();
		listsFinal = listVal.split( '\n' ).join( '|' );
		$j( '.preview' ).selectedTextSharer( {
			title: $j( 'input[name="dxss_title"]' ).val(),
			lists: listsFinal,
			truncateChars: $j( 'input[name=dxss_truncateChars]' ).val(),
			extraClass: $j( 'input[name=dxss_extraClass]' ).val(),
			borderColor: $j( 'input[name=dxss_borderColor]' ).val(),
			background: $j( 'input[name=dxss_bgColor]' ).val(),
			titleColor: $j( 'input[name=dxss_titleColor]' ).val(),
			hoverColor: $j( 'input[name=dxss_hoverColor]' ).val(),
			textColor: $j( 'input[name=dxss_textColor]' ).val(),
		} );
	} );
} );
