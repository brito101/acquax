const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js("resources/js/app.js", "public/js")
    .copy("resources/img", "public/img")
    .sass("resources/sass/app.scss", "public/css")
    /** Admin */
    .scripts(["resources/js/company.js"], "public/js/company.js")
    .scripts(["resources/js/vacancy.js"], "public/js/vacancy.js")
    .scripts(["resources/js/address.js"], "public/js/address.js")
    .scripts(["resources/js/phone.js"], "public/js/phone.js")
    /** Web */
    .copy("resources/views/site/assets/img", "public/site/img")
    .sass("resources/views/site/assets/sass/style.scss", "public/site/css")
    .options({
        processCssUrls: false,
    })
    .scripts(
        ["resources/views/site/assets/js/plugins/simple-anime.js"],
        "public/site/js/plugins/simple-anime.js"
    )
    .scripts(
        ["resources/views/site/assets/js/script.js"],
        "public/site/js/script.js"
    )
    .sourceMaps();
