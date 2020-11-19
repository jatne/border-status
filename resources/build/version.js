"use strict";

const Replacer = require("replace-in-file");
const {argv} = require("yargs");

const NewVersion = argv.v;

if (typeof NewVersion !== "string" || NewVersion.length < 5) {
    console.error("Provide new version with '-v x.x.x'.");
    return;
}

const ReplacementsIndex = {
    files: "index.php",
    from: /([0-9]\.){2}[0-9]/gi,
    to: NewVersion,
};

const ReplacementsPackage = {
    files: "package.json",
    from: `"version": "${process.env.npm_package_version}",`,
    to: `"version": "${NewVersion}",`,
};

try {
    const ResultsIndex = Replacer.sync(ReplacementsIndex);
    const ResultsPackage = Replacer.sync(ReplacementsPackage);

    console.info("Replacement results: ");
    console.info(ResultsIndex);
    console.info(ResultsPackage);
} catch (Error) {
    console.error("Error occurred: ", Error);
}
