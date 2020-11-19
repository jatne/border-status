"use strict";

const Config = require('./build.config');
const Webpack = require('webpack');
const WebpackMerge = require('webpack-merge');
const WriteFilePlugin = require('write-file-webpack-plugin');

let WebpackConfig = require('./webpack.common');

if (Config.enabled.watcher) {
    WebpackConfig.entry = require("./util/hmrEntryPoint")(WebpackConfig.entry, Config.hmrClient);
    WebpackConfig = WebpackMerge(WebpackConfig,
        {
            plugins: [
                new Webpack.HotModuleReplacementPlugin(),
                new WriteFilePlugin(),
            ],
        },
    );
}

module.exports = WebpackConfig;
