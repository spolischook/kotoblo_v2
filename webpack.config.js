'use strict';

const path = require('path'),
    webpack = require('webpack'),
    ManifestPlugin = require('webpack-manifest-plugin')
;

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
        new ManifestPlugin(),
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
