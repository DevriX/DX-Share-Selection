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

                    var x = e.pageX;
                    var y = e.pageY;

                    stsBoxEle.fadeIn('fast');
                    if (stsBoxEle.outerHeight() <= y) {
                        stsBoxEle.css({
                            top: y - 10 - (stsBoxEle.outerHeight() + ($('.stsBox li a').length)),
                            left: x + 30
                        });
                        // The menu shouldn't get displayed out of the viewport
                    } else {
                        stsBoxEle.css({
                            top: y - (stsBoxEle.outerHeight() - ($('.stsBox li a').length * 30)),
                            left: x + 30
                        });
                    }

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