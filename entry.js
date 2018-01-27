'use strict';

require('jquery');
require('popper.js');
require('bootstrap');

$(document).ready(function() {
    $('pre code').each(function(i, block) {
        hljs.highlightBlock(block);
    });
});
