const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = (env, argv) => {
  const isProduction = argv.mode === 'production';

  return {
    entry: {
      app: './src/js/app.js'
    },
    output: {
      path: path.resolve(__dirname, 'assets'),
      filename: 'js/[name].js',
      clean: true
    },
    module: {
      rules: [
        {
          test: /\.js$/u,
          exclude: /node_modules/u,
          use: {
            loader: 'babel-loader',
            options: {
              presets: [
                [
                  '@babel/preset-env',
                  {
                    useBuiltIns: false,
                    modules: false,
                    targets: {
                      browsers: ['last 2 versions', 'ie >= 11']
                    }
                  }
                ]
              ]
            }
          }
        },
        {
          test: /\.(sc|sa|c)ss$/u,
          use: [
            MiniCssExtractPlugin.loader,
            {
              loader: 'css-loader',
              options: {
                sourceMap: !isProduction,
                importLoaders: 1
              }
            },
            {
              loader: 'postcss-loader',
              options: {
                postcssOptions: {
                  plugins: [
                    require('autoprefixer')()
                  ]
                },
                sourceMap: !isProduction
              }
            },
            {
              loader: 'sass-loader',
              options: {
                sourceMap: !isProduction
              }
            }
          ]
        }
      ]
    },
    plugins: [
      new MiniCssExtractPlugin({
        filename: 'css/[name].css'
      })
    ],
    devtool: isProduction ? false : 'source-map',
    stats: 'minimal'
  };
};
