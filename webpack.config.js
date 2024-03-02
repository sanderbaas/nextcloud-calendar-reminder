// SPDX-FileCopyrightText: Sander Baas <sander@baasmail.nl>
// SPDX-License-Identifier: AGPL-3.0-or-later
const path = require('path')
const webpackConfig = require('@nextcloud/webpack-vue-config')
const ESLintPlugin = require('eslint-webpack-plugin')
const StyleLintPlugin = require('stylelint-webpack-plugin')

const buildMode = process.env.NODE_ENV
const isDev = buildMode === 'development'
webpackConfig.devtool = isDev ? 'cheap-source-map' : 'source-map'
// webpackConfig.bail = false

webpackConfig.stats = {
    colors: true,
    modules: false,
}

const appId = 'calendarreminder'
webpackConfig.entry = {
    main: { import: path.join(__dirname, 'src', 'main.js'), filename: appId + '-main.js' },
}

webpackConfig.plugins.push(
    new ESLintPlugin({
        extensions: ['js', 'vue'],
        files: 'src',
        failOnError: !isDev,
    })
)
webpackConfig.plugins.push(
    new StyleLintPlugin({
        files: 'src/**/*.{css,scss,vue}',
        failOnError: !isDev,
    }),
)

module.exports = webpackConfig