'use strict';

const path = require('path');
const webpack = require('webpack');

module.exports = {
    entry: {
        'scripts': './entry.js',
        'admin': './admin.js',
    },
    output: {
        path: path.resolve('public', 'js'),
        filename: '[name].js'
    },
    plugins: [
        new webpack.ProvidePlugin({
            jQuery: 'jquery',
            $: 'jquery',
            hljs: 'highlight.js',
            'window.hljs': 'highlight.js',
        }),
    ],
    module: {
        rules: [
            {
                test: /\.css$/,
                use: [
                    'style-loader',
                    'css-loader',
                ]
            }
        ]
    }
};
