/**
 * Loop through webpack entry
 * and add the hmr middleware
 * @param  {Object} entry Webpack entry
 * @param  {string} entryPoint HMR client entry
 * @return {Object} entry with hot middleware
 */
module.exports = (entry, entryPoint) => {
    const results = {};

    Object.keys(entry).forEach((name) => {
        results[name] = Array.isArray(entry[name]) ? entry[name].slice(0) : [entry[name]];
        results[name].unshift(entryPoint);
    });

    return results;
};
