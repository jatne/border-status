"use strict";

const Config = require("./build.config");
const Replacer = require("replace-in-file");
const {argv} = require("yargs");

const Author = argv.author;

const Replacements = {
    files: [
        "index.php",
        "app/**/*.php",
        "package.json",
    ],
    from: [
        /{PROJECT_ID}/g,
        /wpk-package-project-id/g,
        /{AUTHOR}/g,
        /{NAMESPACE}/g,
    ],
    to: [
        Config.ProjectId,
        Config.ProjectId,
        Author,
        Config.ProjectId,
    ],
};

try {
    const Results = Replacer.sync(Replacements);

    console.log("Replacement results: ", Results);
} catch (Error) {
    console.error("Error occurred: ", Error);
}
