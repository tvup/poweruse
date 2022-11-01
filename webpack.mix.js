// webpack.mix.js

let mix = require('laravel-mix');

mix.js('public/js/app.js', 'dist').setPublicPath('dist');

