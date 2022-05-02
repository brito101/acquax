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
    .scripts(["resources/js/address.js"], "public/js/address.js")
    .scripts(["resources/js/phone.js"], "public/js/phone.js")
    .scripts(
        ["resources/js/document-person.js"],
        "public/js/document-person.js"
    )
    .scripts(["resources/js/reading.js"], "public/js/reading.js")
    .scripts(["resources/js/reading-index.js"], "public/js/reading-index.js")
    .scripts(
        ["resources/js/dealerships-reading.js"],
        "public/js/dealerships-reading.js"
    )
    .scripts(
        ["resources/js/apartment.js"],
        "public/js/apartment.js"
    )
    .options({
        processCssUrls: false,
    })
    .sourceMaps();
