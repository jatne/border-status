"use strict";

module.exports = {
    parser: 'postcss-safe-parser',
    plugins: {
        autoprefixer: true,
        cssnano: {
            preset: [
                'default', {
                    discardComments:
                        {
                            removeAll: true,
                        },
                },
            ],
        },
    },
};
