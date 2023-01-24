import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import i18n from 'laravel-vue-i18n/vite';
import { VitePWA } from 'vite-plugin-pwa';

export default defineConfig({
    publicDir: 'public',
    build: {
        minify: false,
        manifest: true,
        emptyOutDir: false,
    },
    plugins: [
        VitePWA({
            includeManifestIcons: false,
            mode: 'development',
            strategies: 'generateSW',
            injectRegister: 'inline',
            registerType: 'prompt',
            manifest: {
                name: 'Poweruse - Total-prices',
                short_name: 'PU - totalprices',
                start_url: '/totalprices',
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
                scope: '/',
                description: 'My Awesome App that will make you fall in love with Laravel.'
            },
            workbox: {
                additionalManifestEntries: [{url: '/index.php', revision: '1'}],
                navigateFallback: '/index.php',
                navigateFallbackDenylist: [/^\/assets\/images/]
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
});
