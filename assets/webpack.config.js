const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
const TerserPlugin = require("terser-webpack-plugin");
const CopyPlugin = require('copy-webpack-plugin'); // https://webpack.js.org/plugins/copy-webpack-plugin/
const DependencyExtractionWebpackPlugin = require( '@wordpress/dependency-extraction-webpack-plugin' );
// const { PurgeCSSPlugin } = require('purgecss-webpack-plugin');
const glob = require('glob-all');

const JS_DIR = path.resolve(__dirname, 'src/js');
const IMG_DIR = path.resolve(__dirname, 'src/img');
const LIB_DIR = path.resolve( __dirname, 'src/library' );
const BUILD_DIR = path.resolve(__dirname, 'build');

const entry = {
    main: JS_DIR + '/main.js',
    single: JS_DIR + '/single.js',
    editor: JS_DIR + '/editor.js',
    blocks: JS_DIR + '/blocks.js',
    author: JS_DIR + '/author.js',
    home: JS_DIR + '/home.js',
    review: JS_DIR + '/review.js',
    contact: JS_DIR + '/contact.js',
    product: JS_DIR + '/product.js',
};
const output = {
    path: BUILD_DIR,
    filename: 'js/[name].js',
    clean: true,
};



const plugins = ( argv ) => [
    new CleanWebpackPlugin( {
        cleanStaleWebpackAssets: ('production'  === argv.mode) // Automatically remove all unused webpack assets on rebuild, when set to true in production. ( https://www.npmjs.com/package/clean-webpack-plugin#options-and-defaults-optional )
    }),
    new MiniCssExtractPlugin({
        filename: 'css/[name].css'
    }),
    new CopyPlugin( {
        patterns: [
            { from: LIB_DIR, to: BUILD_DIR + '/library' }
        ]
    } ),
    new CssMinimizerPlugin(),
    new DependencyExtractionWebpackPlugin({
        injectPolyfill: true,
        combineAssets: true,
    }),
    // new PurgeCSSPlugin({
    //     paths: glob.sync([
    //         path.join(__dirname, '../*.php'),
    //         path.join(__dirname, '../inc/**/*.php'),
    //         path.join(__dirname, '../template-parts/**/*.php'),
    //         path.join(__dirname, '../template-parts/*.php'),
    //         path.join(__dirname, '../woocommerce/**/**/*.php'),
    //         path.join(__dirname, '../woocommerce/**/*.php'),
    //         path.join(__dirname, '../woocommerce/*.php'),
    //         path.join(__dirname, 'node_modules/bootstrap/**/*.scss'), // Add the path to Bootstrap SCSS files
    //         path.join(__dirname, 'src/sass/*.scss'),
    //         path.join(__dirname, 'src/sass/**/*.scss'),
    //         path.join(__dirname, 'src/sass/**/**/*.scss'),
    //         path.join(__dirname, 'js/*.js'),
    //         path.join(__dirname, 'js/**/*.js'),
    //     ]),
    // }),
];

const rules = [
    {
        test: /\.js$/,
        include: [JS_DIR],
        exclude: /node_modules/,
        use: 'babel-loader'
    },
    {
        test: /\.s?[ac]ss$/i,
        exclude: /node_modules/,
        use: [MiniCssExtractPlugin.loader,
            'css-loader',
            'sass-loader',
        ],
    },
    {
        test: /\.(png|jpg|jpeg|svg|gif|ico|webp)$/,
        generator: {
            filename: '[path][name].[ext]',
        },
        use: [
            {
                loader: 'file-loader',
                options: {
                    name: '[path][name].[ext]',
                    publicPath: 'production' === process.env.NODE_ENV ? '../' : '../../'
                },
            },
        ],
    },
    {
        test: /\.(ttf|otf|eot|svg|woff(2)?)(\?[a-z0-9]+)?$/,
        exclude: [  LIB_DIR, /node_modules/ ],
        type: 'asset/resource',
        generator: {
            filename: '[path][name].[ext]',
        },
        use: [
            {
                loader: 'file-loader',
                options: {
                    name: '[path][name].[ext]',
                    publicPath: 'production' === process.env.NODE_ENV ? '../' : '../../'
                }
            }
        ]
    },
    // SVG files (for fonts)
    {
        test: /\.svg$/,
        include: [path.resolve(__dirname, 'node_modules/bootstrap-icons/icons')],
        use: [
            {
                loader: 'url-loader',
                options: {
                    limit: 4096,
                    mimetype: 'image/svg+xml',
                    name: '[path][name].[ext]',
                    publicPath: 'production' === process.env.NODE_ENV ? '../' : '../../',
                },
            },
        ],
    },

];

module.exports = ( env , argv ) => ({
    entry : entry,
    output: output,
    devtool: 'source-map',
    module: {
        rules: rules,
    },
    optimization: {
        minimizer: [
            new CssMinimizerPlugin({
                minify: [
                    CssMinimizerPlugin.cssnanoMinify,
                    CssMinimizerPlugin.cleanCssMinify
                ]
            }),
            new TerserPlugin({
                minify: TerserPlugin.uglifyJsMinify,
                parallel: true,
            }),
        ],
    },
    plugins: plugins( argv ),
    externals: {
        jquery: 'jQuery',
    },
});