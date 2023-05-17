const mix = require('laravel-mix')

mix.copy('node_modules/@mdi/font/fonts/', 'dist/fonts/')
mix.js('resources/assets/js/app.js', 'publishable/js').vue({ version: 3 })