"use strict";

const Path = require('path');
const {argv} = require('yargs');

const isProduction = argv.mode && argv.mode === 'production';
const isDevelopment = !argv.mode || argv.mode !== 'production';
const isWatcher = !isProduction && (!argv.mode || argv.mode === 'none');

if (process.env.NODE_ENV === undefined) {
    process.env.NODE_ENV = isProduction ? 'production' : 'development';
}

const RootPath = Path.resolve();
const ProjectDir = Path.basename(RootPath);
const ProjectId = ProjectDir.replace('wpk_', '');

module.exports = {
    entry: {
        frontend: [
            "./scripts/frontend.ts",
            "./styles/frontend.scss",
        ],
        dashboard: [
            "./scripts/dashboard.ts",
            "./styles/dashboard.scss",
        ],
    },
    ProjectDir: ProjectDir,
    ProjectId: ProjectId,
    isSSL: false,
    mode: !!isDevelopment || !!isWatcher ? 'development' : 'production',
    devUrl: ProjectId + '.test',
    paths: {
        root: RootPath,
        assets: Path.join(RootPath, 'resources/'),
        dist: Path.join(RootPath, 'dist/'),
    },
    enabled: {
        sourceMaps: true,
        optimize: !!isProduction,
        watcher: !!isWatcher,
    },
    hmrClient: 'webpack-hot-middleware/client?path=/__webpack_hmr&timeout=20000&reload=true&noInfo=true',

    stats: {
        hash: false,
        version: false,
        timings: false,
        children: false,
        errors: false,
        errorDetails: false,
        warnings: false,
        chunks: false,
        modules: false,
        reasons: false,
        source: false,
        publicPath: false,
    },
};
