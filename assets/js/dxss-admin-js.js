var lists = [];
lists.push(Array('Twitter', 'https://twitter.com/intent/tweet?text=%s {url}', 'favicon'));
lists.push(Array('Facebook', 'https://www.facebook.com/sharer.php?u={url}&quote=%s', 'favicon'));
lists.push(Array('Wikipedia (en)', 'https://en.wikipedia.org/w/index.php?title=Special:Search&search=%s', 'favicon'));
lists.push(Array('Google Search', 'https://google.com/search?q=%s', 'favicon'));
lists.push(Array('Google Maps', 'https://maps.google.com/?q=%s', 'favicon'));
lists.push(Array('Email', 'mailto:?subject={title}&amp;body=%s - {url}', 'https://mail.google.com/favicon.ico'));
lists.push(Array('Tumblr', 'https://www.tumblr.com/widgets/share/tool?url={url}&caption=%s', 'favicon'));

$j = jQuery.noConflict();

$j(document).ready(function() {

    // Basic Admin Functions

    $j('#colorpicker').hide();
    $j('.helpWindow, .wpsrBox').hide();

    $j('.message').append('<span class="close">x</span>');

    $j('.message .close').on('click', function() {
        $j(this).parent().slideUp();
    });

    for (i = 0; i < lists.length; i++) {
        if (lists[i][2] != null) {
            iconUrl = lists[i][2].split(' ').join('');
            if (iconUrl == 'favicon') {
                img = '<img src="' + getBaseUrl(lists[i][1]) + 'favicon.ico" width="16" height="16" alt="' + lists[i][0] + '"/> ';
            } else {
                img = '<img src="' + lists[i][2] + '" width="16" height="16" alt="' + lists[i][0] + '"/> ';
            }
        } else {
            img = '';
        }
        $j('#addList').append('<button value="' + i + '" type="button" class="button" >' + img + lists[i][0] + '</button>');
    }


    $j('#addList button').on('click', function() {
        var button = lists[$j(this).val()];
        delete button[3];
		let newLine = $j('#dxss_lists').val() === '' ? '' : '\n';
        val = $j('#dxss_lists').val() + newLine + button;
        $j('#dxss_lists').val(val).change();
    });

    $j('#addCustom').on('click', function() {
        customName = prompt('Enter the name of the button. Eg: Google, Wikipedia');
        customUrl = prompt('Enter the Share URL of the site. Use %s in the URL for the selected text. See help for more terms', 'http://');
        customIcon = prompt('Enter the Icon URL. Use "favicon" to automatically get the Icon', 'favicon');

        if (customName != null) {
			let newLine = $j('#dxss_lists').val() === '' ? '' : '\n';
            val = $j('#dxss_lists').val() + newLine + customName + ',' + customUrl + ',' + customIcon;
            $j('#dxss_lists').val(val).change();
        }

    });

    $j('#addSearch').on('click', function() {
        searchName = prompt('Enter the name of the button. Eg: Search my blog');
        searchUrl = prompt('Enter the Search URL of your site. You can also use your google adsense search URL eg:http://domain.com/?s=%s', 'http://');
        searchIcon = prompt('Enter the Icon URL. Use "favicon" to automatically get the Icon', 'favicon');

        if (searchName != null) {
			let newLine = $j('#dxss_lists').val() === '' ? '' : '\n';
            val = $j('#dxss_lists').val() + newLine + searchName + ',' + searchUrl + ',' + searchIcon;
            $j('#dxss_lists').val(val).change();
        }
    });

    $j('.openHelp').on('click', function() {
        $j('.helpWindow').fadeIn();
    });

    $j('.closeHelp').on('click', function() {
        $j('.helpWindow').fadeOut();
    });

    $j('.openWpsrLinks').on('click', function() {
		$j('.wpsrBox').fadeIn();
        $j('#dxss_list_search').focus();
    });

    $j('.closeLinks').on('click', function() {
        $j('.wpsrBox').fadeOut();
    });

	function fadeOutBox() {
        $j('.lightBox').fadeOut();
		$j(document).off('click', fadeOutBox);
	}

    var f = $j.farbtastic('#colorpicker');
    $j('.color').each(function() {
        f.linkTo(this);
    }).focus(function() {
        f.linkTo(this);
    });

    $j('.color').on('focus', function() {
		setTimeout(function(){
			if ($j('#colorpicker').css('display') === 'none') {
				$j('#colorpicker').fadeIn();
			} else {
				$j('#colorpicker').css('display', 'inline-block');
			}
		}, 6);
    });

    $j('.color').on('blur', function() {
		setTimeout(function(){
			if (!$j('.color').is(":focus")) {
				$j('#colorpicker').fadeOut();
			}
		}, 5);
    });

    // Live search
    $j('#dxss_list_search').keyup(function(event) {
        var search_text = $j('#dxss_list_search').val();
        var rg = new RegExp(search_text, 'i');
        $j('.dxss_wpsr_sites li').each(function() {
            if ($j.trim($j(this).text()).search(rg) == -1) {
                $j(this).css('display', 'none');
            } else {
                $j(this).css('display', '');
            }
        });
    });

	updatePreview();
	$j('.dxss-settings').on('input change paste', updatePreview);
	$j('.dxss-restore-button').on('click', function() {
		setTimeout(updatePreview, 40)
	});

	$j('.farbtastic div').on('mousedown', function() {
		$j(document).one('mouseup', updatePreview);
	});

	function updatePreview () {
		listVal = $j( '#dxss_lists' ).val();
		listsFinal = listVal.split( '\n' ).join( '|' );

		$j( '.test-preview' ).empty();
		$j( '.test-preview' ).append('<div class="append-here"></div>');
		$j( '.append-here' ).selectedTextSharer( {
			title: $j( '#dxss_title' ).val(),
			lists: listsFinal,
			truncateChars: $j( '#dxss_truncateChars' ).val(),
			extraClass: $j( '#dxss_extraClass' ).val(),
			borderColor: $j( '#dxss_borderColor' ).val(),
			background: $j( '#dxss_bgColor' ).val(),
			titleColor: $j( '#dxss_titleColor' ).val(),
			titleTextColor: $j( '#dxss_titleTextColor' ).val(),
			hoverColor: $j( '#dxss_hoverColor' ).val(),
			textColor: $j( '#dxss_textColor' ).val(),
		} );
		$j('.append-here').append($j('.stsBox'));
		$j('.stsBox a').on('click', e => e.preventDefault());
	}

    $j('.dxss_wpsr_sites a').on('click', function() {
		let newLine = $j('#dxss_lists').val() === '' ? '' : '\n';
        val = $j('#dxss_lists').val() + newLine + $j(this).text() + ',' + $j(this).attr('rel') + ',' + 'favicon';
        $j('#dxss_lists').val(val).change();
        $j(this).after('<span class="addedInfo">  Added !</span>');
        $j('.addedInfo').fadeOut('100');
    });

    $j('#restore-customize').on('click', function() {
        var defaultSetings = dx_share_selection.settings_data_default;

        $j('#dxss_borderColor').val(defaultSetings.borderColor);
        $j('#dxss_bgColor').val(defaultSetings.bgColor);
        $j('#dxss_titleColor').val(defaultSetings.titleColor);
        $j('#dxss_hoverColor').val(defaultSetings.hoverColor);
        $j('#dxss_textColor').val(defaultSetings.textColor);
        $j('#dxss_titleTextColor').val(defaultSetings.titleTextColor);
        $j('#dxss_extraClass').val(defaultSetings.extraClass);

        $j('.color').each(function() {
            f.linkTo(this);
        }).focus(function() {
            f.linkTo(this);
        });

    });

    $j('#restore-optional').on('click', function() {
        var defaultSetings = dx_share_selection.settings_data_default;

        $j('#dxss_scriptPlace').val(defaultSetings.scriptPlace);
        $j('#dxss_truncateChars').val(defaultSetings.truncateChars);
        $j('#dxss_element').val(defaultSetings.element);
        $j('input[name=dxss_bitly_token]').val(defaultSetings.bitly);
    });
});


String.prototype.replaceArray = function(find, replace) {
    var replaceString = this;
    var regex;
    for (var i = 0; i < find.length; i++) {
        regex = new RegExp(find[i], "g");
        replaceString = replaceString.replace(regex, replace[i]);
    }
    return replaceString;
};

function getBaseUrl(url) {
    if (url.indexOf('.') == -1 || url.indexOf('/') == -1) {
        return false;
    }
    var result = url.substr(0, url.indexOf('/', url.indexOf('.')) + 1);
    return result;
}