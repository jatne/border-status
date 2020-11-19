module.exports = {
    plugins: [
        'eslint-plugin',
        "@typescript-eslint",
        'import',
        "eslint-comments",
    ],
    extends: [
        'eslint:recommended',
        'plugin:@typescript-eslint/eslint-recommended',
        'plugin:@typescript-eslint/recommended',
        'plugin:@typescript-eslint/recommended-requiring-type-checking',
    ],
    env: {
        es6: true,
        node: true,
    },
    rules: {
        '@typescript-eslint/consistent-type-definitions': ['error', 'interface'],
        '@typescript-eslint/explicit-function-return-type': 'error',
        '@typescript-eslint/no-explicit-any': 'error',
        '@typescript-eslint/no-non-null-assertion': 'off',
        '@typescript-eslint/no-use-before-define': 'off',
        '@typescript-eslint/no-var-requires': 'off',
        '@typescript-eslint/unbound-method': 'off',

        //
        // eslint base
        //

        'comma-dangle': ['error', 'always-multiline'],
        'constructor-super': 'off',
        curly: ['error', 'all'],
        'no-mixed-operators': 'error',
        // 'no-console': 'error',
        'no-process-exit': 'error',

        //
        // eslint-plugin-eslint-comment
        //

        // require a eslint-enable comment for every eslint-disable comment
        'eslint-comments/disable-enable-pair': [
            'error',
            {
                allowWholeFile: true,
            },
        ],
        // disallow a eslint-enable comment for multiple eslint-disable comments
        'eslint-comments/no-aggregating-enable': 'error',
        // disallow duplicate eslint-disable comments
        'eslint-comments/no-duplicate-disable': 'error',
        // disallow eslint-disable comments without rule names
        'eslint-comments/no-unlimited-disable': 'error',
        // disallow unused eslint-disable comments
        'eslint-comments/no-unused-disable': 'error',
        // disallow unused eslint-enable comments
        'eslint-comments/no-unused-enable': 'error',
        // disallow ESLint directive-comments
        'eslint-comments/no-use': [
            'error',
            {
                allow: [
                    'eslint-disable',
                    'eslint-disable-line',
                    'eslint-disable-next-line',
                    'eslint-enable',
                ],
            },
        ],

        //
        // eslint-plugin-import
        //

        // disallow non-import statements appearing before import statements
        'import/first': 'error',
        // Require a newline after the last import/require in a group
        'import/newline-after-import': 'error',
        // Forbid import of modules using absolute paths
        'import/no-absolute-path': 'error',
        // disallow AMD require/define
        'import/no-amd': 'error',
        // forbid default exports
        'import/no-default-export': 'error',
        // Forbid the use of extraneous packages
        'import/no-extraneous-dependencies': [
            'error',
            {
                devDependencies: true,
                peerDependencies: true,
                optionalDependencies: false,
            },
        ],
        // Forbid mutable exports
        'import/no-mutable-exports': 'error',
        // Prevent importing the default as if it were named
        'import/no-named-default': 'error',
        // Prohibit named exports
        'import/no-named-export': 'off', // we want everything to be a named export
        // Forbid a module from importing itself
        'import/no-self-import': 'error',
        // Require modules with a single export to use a default export
        'import/prefer-default-export': 'off', // we want everything to be named
    },
    parserOptions: {
        sourceType: 'module',
        ecmaFeatures: {
            jsx: false,
        },
        project: ['./tsconfig.json'],
        tsconfigRootDir: __dirname,
    },
};
