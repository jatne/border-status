"use strict";

const Config = require("./build.config");
const WebpackConfig = require("./webpack.dev");

const Webpack = require("webpack");
const BrowserSync = require("browser-sync").create();
const DevMiddleware = require("webpack-dev-middleware");
const HotMiddleware = require("webpack-hot-middleware");

const Compiler = Webpack(WebpackConfig);

BrowserSync.init({
    open: false,
    host: Config.devUrl,
    https: Config.isSSL,
    proxy: {
        target: (Config.isSSL ? "https://" : "http://") + Config.devUrl,
    },
    middleware: [
        DevMiddleware(Compiler, {
            publicPath: Config.paths.dist,
            stats: Config.stats,
        }),
        HotMiddleware(Compiler, {
            stats: Config.stats,
        }),
    ],
    plugins: ["bs-html-injector?files[]=../../app/**/*.php"],
    stats: Config.stats,
});
