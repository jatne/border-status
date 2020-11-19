"use strict";

const Config = require("./build.config");
const Webpack = require("webpack");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CopyPlugin = require('copy-webpack-plugin');
const {CleanWebpackPlugin} = require("clean-webpack-plugin");
const FriendlyErrorsWebpackPlugin = require("friendly-errors-webpack-plugin");

const WebpackConfig = {
    mode: Config.mode,
    context: Config.paths.assets,
    watch: Config.enabled.watcher,
    devtool: (Config.enabled.sourceMaps ? "#cheap-module-eval-source-map" : undefined),

    entry: Config.entry,

    output: {
        path: Config.paths.dist,
        publicPath: "/wp-content/plugins/" + Config.ProjectDir + "/dist/",
        filename: `scripts/[name].js`,
    },

    stats: Config.stats,

    resolve: {
        modules: [
            Config.paths.assets,
            "node_modules",
        ],
        enforceExtension: false,
        extensions: [".ts", ".js", ".tsx", ".jsx", ".json"],
    },

    resolveLoader: {
        moduleExtensions: ["-loader"],
    },

    module: {
        rules: [
            {
                enforce: "pre",
                test: /\.ts|js$/,
                include: Config.paths.assets + "scripts/",
                use: "eslint",
            },
            {
                test: /\.jsx?|tsx?$/,
                include: Config.paths.assets + "scripts/",
                loader: ["cache","babel"],
            },
            {
                test: /\.(ttf|otf|eot|woff2?|png|jpe?g|gif|svg|ico)$/,
                include: [
                    Config.paths.assets + "fonts/",
                    Config.paths.assets + "images/",
                ],
                loader: "file",
                options: {
                    name: "[path][name].[ext]",
                },
            },
            {
                test: /\.s?css$/,
                use: [
                    {
                        loader: MiniCssExtractPlugin.loader,
                        options: {
                            hmr: Config.enabled.watcher,
                            sourceMap: Config.enabled.sourceMaps,
                        },
                    },
                    {
                        loader: "cache",
                    },
                    {
                        loader: "css", options: {
                            sourceMap: Config.enabled.sourceMaps,
                        },
                    },
                    {
                        loader: "postcss",
                        options: {
                            config: {
                                path: Config.paths.assets + "build/",
                            },
                            sourceMap: Config.enabled.sourceMaps,
                        },
                    },
                    {
                        loader: "resolve-url-loader",
                    },
                    {
                        loader: "sass", options: {
                            sourceMap: Config.enabled.sourceMaps,
                        },
                    },
                ],
            },
        ],
    },

    plugins: [
        new CopyPlugin({
            patterns: [
                { from: Config.paths.assets + "/images", to: Config.paths.dist + "/images" }
            ],
        }),
        new Webpack.optimize.OccurrenceOrderPlugin(true),
        new CleanWebpackPlugin(
            {
                verbose: false,
            },
        ),
        new MiniCssExtractPlugin({
            filename: `styles/[name].css`,
            allChunks: true,
            disable: (Config.enabled.watcher),
        }),
        new Webpack.LoaderOptionsPlugin({
            test: /\.s?css$/,
            options: {
                output: {path: Config.paths.dist},
            },
        }),
        new Webpack.LoaderOptionsPlugin({
            minimize: Config.enabled.optimize,
            debug: Config.enabled.watcher,
            stats: {colors: true},
        }),
        new FriendlyErrorsWebpackPlugin(),
    ],
};

module.exports = WebpackConfig;
