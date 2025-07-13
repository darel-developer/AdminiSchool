const mix = require('laravel-mix');
const WorkboxPlugin = require('workbox-webpack-plugin');

// Configuration standard Laravel
mix.js('resources/js/app.js', 'public/js')
   .js('resources/js/offlineDB.js', 'public/js')
   .js('resources/js/offlineInterceptor.js', 'public/js')
   .postCss('resources/css/app.css', 'public/css')
   .version();

// Configuration PWA uniquement en production
if (mix.inProduction()) {
    mix.webpackConfig({
        plugins: [
            new WorkboxPlugin.InjectManifest({
                swSrc: './public/sw.js',
                swDest: 'sw.js',
                exclude: [/\.map$/, /manifest\.json$/],
                maximumFileSizeToCacheInBytes: 10 * 1024 * 1024 // 10MB
            })
        ]
    });
}