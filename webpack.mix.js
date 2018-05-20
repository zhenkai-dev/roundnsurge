const mix = require('laravel-mix');

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
mix.webpackConfig({
    devtool: "inline-source-map"
});

const dashboardScipts = [
    'node_modules/jquery/dist/jquery.min.js',
    'node_modules/popper.js/dist/umd/popper.js',
    'node_modules/bootstrap/dist/js/bootstrap.min.js',
    'node_modules/jquery-validation/dist/jquery.validate.min.js',
    'node_modules/jquery-validation/dist/additional-methods.js',
    'node_modules/pace-progress/pace.min.js',
    'node_modules/moment/moment.js',
    'node_modules/moment-timezone/builds/moment-timezone-with-data.min.js',
    'node_modules/autosize/dist/autosize.min.js',
    'node_modules/bootstrap-daterangepicker/daterangepicker.js',
    'resources/assets/global/js/helpers.js',
    'resources/assets/admin/js/helpers.js',
    'resources/assets/admin/js/app.js'
];

mix.babel(dashboardScipts, 'public/admin/js/script.js')
    .sourceMaps();

mix.babel(dashboardScipts, 'public/member/js/script.js')
    .sourceMaps();

mix.babel([
    'node_modules/chart.js/dist/Chart.min.js',
    'node_modules/chart.js/samples/utils.js'
    ], 'public/admin/js/chart.min.js');

mix.babel([
    'node_modules/chart.js/dist/Chart.min.js',
    'node_modules/chart.js/samples/utils.js'
], 'public/member/js/chart.min.js');

mix.sass('node_modules/font-awesome/scss/font-awesome.scss', 'public/admin/css')
    .sass('resources/assets/admin/scss/style.scss', 'public/admin/css')
    .copy('resources/assets/admin/images', 'public/admin/images')
    .copy('resources/assets/admin/css/ckeditor.css', 'public/admin/css')
    .copy('resources/assets/admin/js/ckeditor/', 'public/admin/js/ckeditor')
    .copy('node_modules/nestable/jquery.nestable.js', 'public/admin/js/jquery.nestable.js')
    .copy('node_modules/bootstrap/dist/css/bootstrap.min.css', 'public/admin/css')
    .sourceMaps();

mix.copy('public/admin', 'public/member').sourceMaps();

mix.babel([
    'node_modules/jquery/dist/jquery.min.js',
    'node_modules/popper.js/dist/umd/popper.js',
    'node_modules/bootstrap/dist/js/bootstrap.min.js',
    'node_modules/jquery-validation/dist/jquery.validate.min.js',
    'node_modules/jquery-validation/dist/additional-methods.js',
    'node_modules/autosize/dist/autosize.min.js',
    'node_modules/moment/moment.js',
    'node_modules/moment-timezone/builds/moment-timezone-with-data.min.js',
    'node_modules/bootstrap-daterangepicker/daterangepicker.js',
    'resources/assets/global/js/helpers.js',
    'resources/assets/web/js/helpers.js'
], 'public/web/js/script.js')
    .sourceMaps();

mix.sass('resources/assets/web/scss/style.scss', 'public/web/css')
    .copy('resources/assets/web/images', 'public/web/images')
    .copy('node_modules/swiper/dist/css/swiper.min.css', 'public/web/css')
    .copy('node_modules/swiper/dist/js/swiper.min.js', 'public/web/js')
    .sourceMaps();
