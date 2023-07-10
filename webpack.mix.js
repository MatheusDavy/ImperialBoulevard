const mix = require('laravel-mix');
const webpack = require('webpack');
const pathAdm = "public/adm/";

mix.autoload({
	jquery: ['$', 'window.jQuery',"jQuery","window.$","jquery","window.jquery"]
});

// ARQUIVOS ADMIN
mix.copy('resources/adm/assets/img', pathAdm + 'img')
.copy('resources/adm/assets/js', pathAdm + 'js')
.copy('resources/adm/assets/plugins', pathAdm + 'plugins')
.copy('node_modules/cropperjs/dist/cropper.css', 'public/site/css/plugins')
.sass('resources/adm/assets/sass/import.scss', pathAdm + 'css/main.css').options({ processCssUrls: false });

mix.copy('resources/site/assets/fonts', 'public/site/fonts')
	.copy('resources/site/assets/img', 'public/site/img')
	.copy('resources/site/assets/json', 'public/site/json')
	.copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/site/webfonts')
	.copy('resources/site/assets/css', 'public/site/css')
    .copy('resources/site/assets/js/pages/cropper.js', 'public/site/js/pages/cropper.js')
    .copy('resources/site/assets/js/pages/jquery-cropper.js', 'public/site/js/pages/jquery-cropper.js')
    .copy('resources/site/assets/js/pages/bootstrap.min.js', 'public/site/js/pages/bootstrap.min.js')
    .copy('resources/site/assets/js/pages/custom.js', 'public/site/js/pages/custom.js')
    .copy('resources/site/assets/js/pages/jquery.js', 'public/site/js/pages/jquery.js')
    .copy('resources/site/assets/js/pages/jquery.magnific-popup.min.js', 'public/site/js/pages/jquery.magnific-popup.min.js')
    .copy('resources/site/assets/js/pages/jquery.mask.min.js', 'public/site/js/pages/jquery.mask.min.js')
    .copy('resources/site/assets/js/pages/jquery.stellar.min.js', 'public/site/js/pages/jquery.stellar.min.js')
    .copy('resources/site/assets/js/pages/owl.carousel.min.js', 'public/site/js/pages/owl.carousel.min.js')
    .copy('resources/site/assets/js/pages/smoothscroll.js', 'public/site/js/pages/smoothscroll.js')


// ARQUIVOS SITE
mix.setPublicPath('public')
.sass('resources/site/assets/sass/vendor.scss',  'site/css/vendor.css').options({ processCssUrls: false })
.sass('resources/site/assets/sass/main.scss',  'site/css/main.css').options({ processCssUrls: false })
.js('resources/site/assets/js/vendor.js', 'site/js/vendor.js')
.js('resources/site/assets/js/main.js', 'site/js/main.js')
.js('resources/site/assets/js/pages/page_home.js', 'public/site/js/pages/page_home.js')
.js('resources/site/assets/js/pages/page_offers.js', 'public/site/js/pages/page_offers.js')
.sourceMaps();


if (mix.inProduction()) {

} else {
    // Uses inline source-maps on development
    mix.webpackConfig({ devtool: 'inline-source-map' });
}

mix.browserSync({
    proxy: 'localhost',
    files: [
        'resources/**/*.*'
    ]
})
.version();
