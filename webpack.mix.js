const mix = require('laravel-mix')

mix.js('resources/assets/js/app.js', 'publishable/js').vue({ version: 2 })