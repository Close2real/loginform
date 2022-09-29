/**
 * @type {Encore}
 */
const Encore = require('@symfony/webpack-encore');
const path = require("path");
const fs = require("fs");

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/build/')

    .setPublicPath('/build')

    .addEntry('app', './@front/index.tsx')

    .splitEntryChunks()

    .enableSingleRuntimeChunk()

    .cleanupOutputBeforeBuild()

    .enableBuildNotifications()

    .enableSourceMaps(!Encore.isProduction())

    .enableVersioning(Encore.isProduction())

    .enableSassLoader((options) => {
        options.sourceMap = true;
        options.sassOptions = {
            outputStyle: "compressed",
            sourceComments: !Encore.isProduction(),
        };
    }, {})

    .enableTypeScriptLoader(function (typeScriptConfigOptions) {
        typeScriptConfigOptions.transpileOnly = true;
        typeScriptConfigOptions.configFile = "tsconfig.json";
    })
    .addLoader({
        test: /\.svg$/,
        use: [
            {
                loader: 'svg-url-loader',
                options: {
                    limit: 10000,
                },
            },
        ],
    })

    .enableForkedTypeScriptTypesChecking()

    .enableReactPreset();

const react_config = Encore.getWebpackConfig();

react_config.watchOptions = { poll: 2000, ignored: /node_modules/ };
react_config.resolve.extensions.push('tsx');
react_config.resolve.extensions.push('js');
react_config.resolve.extensions.push('json');

const pathAliasesBuffer = fs.readFileSync(path.resolve(__dirname, "./tsconfig.paths.json"))
// noinspection JSCheckFunctionSignatures
const pathAliases = JSON.parse(pathAliasesBuffer);

const aliases = {};

Object.entries(pathAliases.compilerOptions.paths).forEach(([key, value]) => {
    aliases[key.slice(0, -2)] = path.resolve(__dirname, value[0].slice(0, -2))
});

react_config.resolve.alias = Object.assign(react_config.resolve.alias, aliases);

module.exports = react_config;
