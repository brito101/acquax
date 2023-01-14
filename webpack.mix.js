const mix = require("laravel-mix");
require("laravel-mix-purgecss");

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
    /** Site */
    .sass("resources/sass/site.scss", "public/css")
    .copy("node_modules/animate.css/animate.min.css", "public/css")
    .copy("node_modules/boxicons", "public/boxicons")
    .copy("node_modules/jquery/dist/jquery.min.js", "public/js")
    .copy("node_modules/bootstrap/dist/js/bootstrap.bundle.min.js", "public/js")
    .copy(
        "resources/OwlCarousel2-2.3.4/dist/owl.carousel.min.js",
        "public/js"
    )
    .copy(
        "resources/Magnific-Popup/dist/jquery.magnific-popup.min.js",
        "public/js"
    )
    .copy(
        "resources/jquery-nice-select-1.1.0/js/jquery.nice-select.min.js",
        "public/js"
    )
    .copy("resources/js/wow.min.js", "public/js")
    .copy("resources/js/form-validator.min.js", "public/js")
    .scripts(["resources/js/mainmenu.js"], "public/js/mainmenu.js")
    .scripts(
        ["resources/js/contact-form-script.js"],
        "public/js/contact-form-script.js"
    )
    .scripts(["resources/js/custom.js"], "public/js/custom.js")
    .scripts(["resources/js/goto.js"], "public/js/goto.js")
    /** App */
    .scripts(["resources/js/app-home.js"], "public/js/app-home.js")
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
    .scripts(["resources/js/apartment.js"], "public/js/apartment.js")
    .scripts(["resources/js/meter.js"], "public/js/meter.js")
    /** New Phones Modal */
    .sass("resources/sass/new-phones-modal.scss", "public/css")
    .scripts(["resources/js/new-phones-modal.js"], "public/js/new-phones-modal.js")
    /** */
    .options({
        processCssUrls: false,
    })
    .sourceMaps()
    .purgeCss();
