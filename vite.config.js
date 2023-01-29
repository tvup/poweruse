import {defineConfig, loadEnv} from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import i18n from 'laravel-vue-i18n/vite';
import {VitePWA} from 'vite-plugin-pwa';

export default defineConfig(({command, mode}) => {
    const env = loadEnv(mode, process.cwd(), '');
    return {
        assetsInclude: ['**/*.webm'],
        publicDir: 'public',
        base: './',
        build: {
            outDir: './public',
            sourcemap: true,
            minify: false,
            manifest: true,
            emptyOutDir: false,
        },
        plugins: [
            VitePWA({
                base: '/',
                scope: '/',
                outDir: './public',
                minify: false,
                includeManifestIcons: false,
                mode: env.APP_ENV=='production' ? 'production' : 'development',
                strategies: 'generateSW',
                injectRegister: 'inline',
                registerType: 'prompt',
                manifest: {
                    name: 'Poweruse - Total-prices',
                    short_name: 'PU - totalprices',
                    start_url: '/',
                    icons: [
                        {
                            src: '/assets/images/icons/pwa-192x192.png',
                            sizes: '192x192',
                            type: 'image/png'
                        },
                        {
                            src: '/assets/images/icons/pwa-512x512.png',
                            sizes: '512x512',
                            type: 'image/png'
                        },
                    ],
                    theme_color: '#2196f3',
                    background_color: '#2196f3',
                    description: 'My Awesome App that will make you fall in love with Laravel.'
                },
                workbox: {
                    skipWaiting: false,
                    additionalManifestEntries: [{url: '/index.php', revision: '1'}],
                    globPatterns: ['**/*.{js,ico,css,png,svg,jpg,jpeg,webm,woff2,ttf}'],
                    maximumFileSizeToCacheInBytes: 2150000,
                    navigateFallback: '/index.php',
                    navigateFallbackDenylist: [/^\/assets\/images/] //This is due to the manifest icons are in the public
                                                                    //folder and we don't want those to be versioned for the
                                                                    //time being.
                },
                devOptions: {
                    enabled: true,
                    type: 'module',
                },

            }),
            laravel({
                input: [
                    'resources/sass/app.scss',
                    'resources/js/app.js',
                    'resources/js/custom.js',
                ],
                refresh: true,
            }),
            vue({
                template: {
                    transformAssetUrls: {
                        base: null,
                        includeAbsolute: false,
                    },
                },
            }),
            i18n(),
        ],
        resolve: {
            alias: {
                vue: 'vue/dist/vue.esm-bundler.js',
                $: "jQuery",
            },
        },
    }
});
