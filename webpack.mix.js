const mix = require('laravel-mix')

mix
    .copyDirectory('fonts', 'publishable/fonts')
    .css('resources/assets/css/app.css', 'publishable/css')
    .js('resources/assets/js/app.js', 'publishable/js')
    .vue({ version: 3 })