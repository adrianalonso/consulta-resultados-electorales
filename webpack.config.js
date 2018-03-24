var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
     .enableVersioning(Encore.isProduction())
     .addEntry('js/app', './assets/js/app.js')
     .addStyleEntry('css/app', './assets/scss/landing-page.scss')
     .enableSassLoader()
     .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
