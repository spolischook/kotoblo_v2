'use strict';

require('highlight.js');
require('./node_modules/highlight.js/styles/tomorrow-night.css');
let $ = require('jquery');
require('bootstrap');

// CKEDITOR.replace( 'article_text' );

let source = $('#article_textSource');
console.log(source.length);
if (source.length === 1) {
    let parent = source.parent();
    $.ajax('/editor', {
        method: 'POST',
        data: source[0].outerHTML,
        success: function (data) {
            source.replaceWith(data);
        }
    }).then(() => $('.nav-tabs a').click(function (e) {
        e.preventDefault();
        console.log($(this));
        $(this).tab('show');
        let href = this.getAttribute('href');
        if ('#md-to-html' === href) {
            $.ajax('/render-md', {
                'method': 'POST',
                'data': $('#md-source textarea').val(),
                'success': function (data) {
                    $('#md-to-html').html(data.data);
                    $(document).ready(function() {
                        $('pre code').each(function(i, block) {
                            console.dir(block.className);
                            hljs.highlightBlock(block);
                        });
                    });
                }
            });
        }
    }));
}

