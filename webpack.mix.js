const { mix } = require('laravel-mix');

mix
    .js('resources/assets/js/app.js', 'public/js')
    .postCss('resources/assets/css/app.css', 'public/css')

    .version()
    .copy('resources/assets/audio/horn.mp3', 'public/audio/horn.mp3')
    .options({
        processCssUrls: false,

        postCss: [require('postcss-easy-import')],
    });
