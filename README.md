# Basic.Plugin Boilerplate
To make sure that every automation is in place and working please make sure that you have the following structure.

- Local Website URL: `http://{PROJECT_ID}.test`. Default for `Valet`
- Plugin directory: `/wp-content/plugins/wpk_{PROJECT_ID}`

**SSL Support**

To enable SSL support, please go to `./resources/build/build.config.js` and change `isSSL: false` to `isSSL: true`.

**Another TLD support**

To change the default Local Website URL (`.test`), please go to `./resources/build/build.config.js` and change the value of `devURL` from `.test` to the domain of your choice.


## How to start new project using the Basic.Plugin Boilerplate?
Run the following command inside `/wp-content/plugins`. Make sure that you have changed the destination directory (`{PROJECT_ID}`) at the end of the command below:
```
git clone --depth 1 git@git-ssh.mpcreation.net:wp-kraken/boilerplates/basic.plugin.git wpk_{PROJECT_ID}
cd wpk_{PROJECT_ID}
```

Example: 
```
git clone --depth 1 git@git-ssh.mpcreation.net:wp-kraken/boilerplates/basic.plugin.git wpk_x000000
cd wpk_x000000
```
---
After that, go to the new directory and start `yarn` installation. Remember to change `{PROJECT_ID}` and `{YOUR NAME}`
```
git remote rm origin
yarn && yarn wpk --author "{YOUR NAME}"
```

Example:
```
git remote rm origin
yarn && yarn wpk --author "Grzesiek P."
```

## How to change/increase project version?
We use simplified Semantic Versioning. More about this can be read here https://semver.org/ .

Example: version `X.Y.Z` means:
- `X` - MAJOR version, something changed and is not compatible with previous releases
- `Y` - MINOR version, we added new functionality but it is compatible with the previous versions
- `Z` - PATCH version, mostly fixes from client or QA 

We should release version `1.0.0` to tests. Then, each hotfix release should increase the last part of version: `1.0.1`, `1.0.2`.

After tests are done, we release to client without changing the current version number. Ex. `1.0.111`.

*DO NOT EDIT VERSION MANUALLY* . We have an interface to do so:
```
yarn ver --v 1.0.1
````


## How to start BrowserSync?
BrowserSync uses different port than standard web server. Currently, it is configured to support HMR (Hot Module Replacement).

HMR allows to refresh CSS/JS code (even SCSS/TS) without page reload. It speed up mostly frontend work.
```shell script
yarn watch
```

After that, navigate to your project on different port: `http://{PROJECT_ID}.loc:3000`.

From now, each change to CSS / JS / PHP files should trigger a refresh. In some cases, the full reload of website may be needed and will be triggered automatically.

## How to build assets for Development?
This command should be run only if you do not use BrowserSync.

It will compile assets and emit them to `./dist` folder.
```shell script
yarn build:dev
```

## How to build assets for Production?
This command should be use to prepare a release that can be installed as WordPress Plugin at target website or sent to client.
It will compile assets, perform additional optimizations and emit them to `./dist` folder. 

After that, a compressed ZIP archive will be generated inside project root path.
```shell script
yarn build:prod
```

Remember to change project version first.

## How to make a new ZIP package?
```shell script
yarn archive
```
