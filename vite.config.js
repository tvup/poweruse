import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import i18n from 'laravel-vue-i18n/vite';
import { VitePWA } from 'vite-plugin-pwa';

export default defineConfig({
    publicDir: 'public',
    build: {
        root: '/var/www/html/',
        outDir: 'public/build/',
        manifest: true,
        rollupOptions: {
            // overwrite default .html entry
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/custom.js',
            ],
        },
            // '/var/www/html/resources/images/icons/favicon.ico',
        emptyOutDir: false,
    },
    plugins: [
        VitePWA({
            mode: 'development',
            strategies: 'generateSW',
            injectRegister: 'inline',
            registerType: 'prompt',
            outDir: 'public',
            emptyOutDir: false,
            manifest: {
                name: 'Poweruse - Total-prices',
                short_name: 'PU - totalprices',
                icons: [
                    {
                        src: 'resources/images/icons/pwa-192x192.png',
                        sizes: '192x192',
                        type: 'image/png'
                    },
                    {
                        src: 'resources/images/icons/pwa-512x512.png',
                        sizes: '512x512',
                        type: 'image/png'
                    },
                ],
                start_url: '/totalprices',
                theme_color: '#2196f3',
                background_color: '#2196f3',
                scope: '/',
                description: 'My Awesome App that will make you fall in love with Laravel.'
            },
            workbox: {
                swDest: './public/sw.js',
                globDirectory: 'public',
                globPatterns: ['**/*.{js,css,html,ico,png,svg,json,vue,txt,woff2}'],
                additionalManifestEntries: [{url: 'index.php', revision: '1'}],
                navigateFallback: 'index.php',
            },
            devOptions: {
                enabled: true,
                type: 'module',
            },

        }),
        laravel({
            input: [
                // 'resources/sass/app.scss',
                // 'resources/js/app.js',
                // 'resources/js/custom.js',
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
});
