let mix = require('laravel-mix')

mix.setPublicPath('dist')
    .js('resources/js/fields.js', 'js')
    .sass('resources/sass/fields.scss', 'css')
