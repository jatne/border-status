"use strict";

const Config = require('./build.config');
const Archiver = require('archiver');
const FS = require('fs');

const IgnoredFiles = [
    'resources/**',
    'node_modules/**',
    '.git/**',
    '.env',
    '.gitignore',
    '.eslintrc.js',
    '.editorconfig',
    '.stylelintrc.js',
    '.tsconfig.json',
    'package.json',
    'package-lock.json',
    'composer.json',
    'composer-lock.json',
    'yarn.lock',
    'README.md',
    `${Config.ProjectDir}.zip`,
];

// create a file to stream archive data to.
const Output = FS.createWriteStream(`${Config.paths.root}/${Config.ProjectDir}.zip`);

const Plugin = Archiver('zip', {
    name: `${Config.ProjectDir}.zip`,
});

Plugin.pipe(Output);
Plugin.glob('**/*', {
    cwd: './', ignore: IgnoredFiles,
}, {
    prefix: `${Config.ProjectDir}/`,
});

Plugin.finalize();
