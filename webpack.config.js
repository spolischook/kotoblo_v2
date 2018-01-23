'use strict';

const path = require('path');

module.exports = {
    entry: './entry.js',
    output: {
        path: path.resolve('public', 'js'),
        filename: 'scripts.js'
    }
};
