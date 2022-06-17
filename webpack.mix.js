let mix = require('laravel-mix')

require('./nova.mix')

mix
    .setPublicPath('dist')
    .js('resources/js/fields.js', 'js')
    .vue({ version: 3 })
    .sass('resources/sass/fields.scss', 'css')
    .nova('/kirschbaum-development/nova-mail')
