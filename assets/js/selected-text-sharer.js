/*
 * jQuery - Selected Text Sharer - Plugin v1.5
 * http://www.aakashweb.com/
 * Copyright 2010, Aakash Chakravarthy
 * Released under the MIT License.
 */
(function($) {
    $.fn.selectedTextSharer = function(options) {

        var defaults = {
            title: 'Share',
            lists: 'Google,http://www.google.com/search?q=%s',
            truncateChars: 115,
            extraClass: '',
            borderColor: '#444',
            background: '#fff',
            titleColor: '#f2f2f2',
            hoverColor: '#ffffcc',
            textColor: '#000',
            titleTextColor: '#000',
        };

        var options = $.extend(defaults, options);

        var listSplit = [];
        var lstSplit = [];

        function getBaseUrl(url) {
            if (url.indexOf('.') == -1 || url.indexOf('/') == -1) {
                return false;
            }
            var result = url.substr(0, url.indexOf('/', url.indexOf('.')) + 1);
            return result;
        }

        function splitList() {
            listSplit = (options.lists).split('|');
            for (i = 0; i < listSplit.length; i++) {
                lstSplit[i] = listSplit[i].split(',');
            }
        }

        function createListBox(ele, e) {
            e = e || window.event;
            stsBox = '<div class="stsBox ' + options.extraClass + '"><div class="title">' + options.title + '</div><div class="list"><ul></ul></div><span class="arrow"></span></div>';

            $('body > .stsBox ').remove();
            $('body').append(stsBox);

        }

        function addToList(ele) {

            stsBoxEle = $('body').find('.stsBox');

            for (i = 0; i < listSplit.length; i++) {
                if (lstSplit[i][0] != null) {
                    if (lstSplit[i][2] != null) {
                        iconUrl = lstSplit[i][2].split(' ').join('');
                        if (iconUrl == 'favicon') {
                            img = '<img src="' + getBaseUrl(lstSplit[i][1]) + 'favicon.ico" width="16" height="16" alt="' + lstSplit[i][0] + '"/> ';
                        } else {
                            img = '<img src="' + lstSplit[i][2] + '" width="16" height="16" alt="' + lstSplit[i][0] + '"/> ';
                        }
                    } else {
                        img = '';
                    }
                    // '<li>' +
                    tempList = '<li>' + img + '<a rel="' + lstSplit[i][1] + '" title="' + lstSplit[i][0] + '" href="#">' + lstSplit[i][0] + '</a></li>';
                    stsBoxEle.find('ul').append(tempList);
                }
            }
        }

        function applyCss(ele) {
            stsBoxEle = $('body').find('.stsBox');

            stsBoxEle.css({
                'display': 'none',
                'z-index': 200,
                'position': 'absolute',
                'overflow': 'hidden',
                'border': '1px solid ' + options.borderColor,
                'white-space': 'nowrap',
                'font-family': 'sans-serif',
                'background': '#FFF',
                'color': '#333',
                'border-radius': '5px',
                'padding': 0
            });

            stsBoxEle.find('img').css({
                'vertical-align': 'middle'
            });

            stsBoxEle.find('.title').css({
                'color': options.titleTextColor,
                'background': options.titleColor,
                'padding': '10px',
                'border-bottom': '1px solid #e5e5e5'
            });

            stsBoxEle.find('.title').find('a').css({
                'float': 'right',
                'padding-left': '5',
                'padding-right': '5'
            });

            stsBoxEle.find('a').css({
                'color': options.textColor,
                'text-decoration': 'none'
            });

            stsBoxEle.find('.list').css({
                'background': options.background,
                'padding': '7px'
            });

            $('.stsBox ul, .stsBox li').css({
                'padding': '2px',
                'cursor': 'pointer',
                'list-style-type': 'none',
                'transition': 'all .3s ease',
                'user-select': 'none',
                'margin-bottom': '5px'
            });

            $('.stsBox ul, .stsBox li img').css({
                'margin-bottom': '3px'
            });


            $('.stsBox li:hover').css({
                'background-color': '#DEF'
            });

            $('.stsBox li').css({
                'padding': '3'
            });

            stsBoxEle.find('.arrow').css({
                'width': 0,
                'height': 0,
                'line-height': 0,
                'border-left': '10px solid transparent',
                'border-top': '15px solid ' + options.borderColor,
                'position': 'absolute',
                'bottom': '-19px'
            });

            stsBoxEle.find('li').hover(function() {
                $(this).css({
                    background: options.hoverColor
                });
            }, function() {
                $(this).css({
                    background: 'none'
                });
            });
        }

        function getSelectionText() {
            if (window.getSelection) {
                selectionTxt = window.getSelection();
            } else if (document.getSelection) {
                selectionTxt = document.getSelection();
            } else if (document.selection) {
                selectionTxt = document.selection.createRange().text;
            }

            return selectionTxt;
        }

        String.prototype.trunc = function(n) {
            return this.substr(0, n - 1) + (this.length > n ? '...' : '');
        };

        function init(ele) {
            splitList();
            createListBox(ele);
            addToList(ele);
            applyCss(ele);
        }

        return this.each(function() {

            init($(this));

            $(this).mouseup(function(e) {

                if ($(e.target).closest('.stsBox').length) {
                    return;
                }

                if (getSelectionText() != '') {
                    stsBoxEle = $('body').find('.stsBox');

					// Get the coordinates of the mouse on the screen.
                    var mouseX = e.pageX;
                    var mouseY = e.pageY;

					// Get an object from the highlighted area.
					let selection = window.getSelection();
					let range = selection.getRangeAt(0);
					let rect = range.getBoundingClientRect();

					// Get the height and width of the current window.
					let windowHeight = $(window).height();
					let windowsWidth = $(window).width();

					// Get the height and width of the popup box.
					let h = stsBoxEle.outerHeight();
					let w = stsBoxEle.outerWidth();

					// Calculate the space to the top and to the right of the popup box.
					let spaceToTop   = windowHeight - ( (windowHeight - mouseY) + h + 20 );
					let spaceToRight = windowsWidth - ( mouseX + w + 10 );

					// Set the initial top and left styles for the popup.
					let top  = 0;
					let left = 0;

					// Make adjustments to the popup position if it goes out of the window.
                    if (spaceToTop >= 0) {
						top = mouseY - 20 - (stsBoxEle.outerHeight() + ($('.stsBox li a').length));
					} else {
						top = mouseY + 20;
					}

                    if (spaceToRight >= 0) {
						left = mouseX + 20;
					} else {
						left = mouseX - Math.abs(spaceToRight);
					}

					// Calculate the position/size of the popup and the highlighted text.
					let boxTop    = top;
					let boxBottom = top + stsBoxEle.outerHeight();
					let boxLeft   = left;
					let boxRight  = left + stsBoxEle.outerWidth();
					let highlightTop = rect.top + window.scrollY;
					let highlightBot = rect.bottom + window.scrollY;
					let highlightLeft  = rect.left + window.scrollX;
					let highlightRight = rect.right + window.scrollX;

					let sidesAreInHighlight = false;

					// Check if the popup goes over the highlighted text.
					if (boxLeft > highlightLeft && boxLeft < highlightRight) {
						sidesAreInHighlight = true;
					} else if (boxRight > highlightLeft && boxRight < highlightRight) {
						sidesAreInHighlight = true;
					} else if(boxLeft < highlightLeft && boxRight > highlightRight) {
						sidesAreInHighlight = true;
					}

					if (sidesAreInHighlight) {
						// If the bottom of the popup is in the highlighted area.
						if (boxBottom < highlightBot && boxBottom > highlightTop) {
							// If the top of the popup is also in the highlighted area.
							if (boxTop < highlightBot && boxTop > highlightTop) {
								// Check if the top or the bottom is closer.
								if (mouseY - highlightTop < highlightBot - mouseY) {
									top = highlightTop - 5 - (stsBoxEle.outerHeight() + ($('.stsBox li a').length));
								} else {
									top = highlightBot + 10;
								}
							} else {
								top = highlightTop - 5 - (stsBoxEle.outerHeight() + ($('.stsBox li a').length));
							}
						// If the top of the popup is in the highlighted area.
						} else if (boxTop < highlightBot && boxTop > highlightTop) {
							top = highlightBot + 10;
						// If the highlighted between the top and bottom of the popup.
						} else {
							// Check if the top or the bottom is closer.
							if (mouseY - highlightTop < highlightBot - mouseY) {
								top = highlightTop - 5 - (stsBoxEle.outerHeight() + ($('.stsBox li a').length));
							} else {
								top = highlightBot + 10;
							}
						}
					}

					// Set the final styles/position for the popup
					stsBoxEle.css({
						top: top,
						left: left,
					});

					// Make the popup visible. (fade in).
                    stsBoxEle.fadeIn('fast');

                    $('.stsBox li a').each(function() {
                        $(this).attr('rev', getSelectionText());
                    });
                }
            });

            $('.stsBox li').click(function() {
                sUrl = $(this).children('a').attr('rel');
                selectedText = $(this).children('a').attr('rev');
                theUrl = sUrl.replace('%s', selectedText);
                theUrl = theUrl.replace('%ts', selectedText.trunc(options.truncateChars));
                window.open(theUrl, 'sts_window');
            });

            $('img').on('error', function(e) {
                e.target.style.display = 'none'
            })

            $(document).mousedown(function(e) {
                if ($(e.target).closest('.stsBox').length)
                    return;

                $('.stsBox').fadeOut('fast');
            });

            $(window).blur(function(e) {
                $('.stsBox').fadeOut('fast');
            });

        });
    };
})(jQuery);