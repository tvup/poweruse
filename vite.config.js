import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import i18n from 'laravel-vue-i18n/vite';
import { VitePWA } from 'vite-plugin-pwa';

export default defineConfig({
    define: {
        __DATE__: `'${new Date().toISOString()}'`,
    },
    build: {
        manifest: true,
        outDir: 'public/build/',
    },
    plugins: [
        VitePWA({
            injectRegister: 'inline',
            registerType: 'autoUpdate',
            strategies: 'generateSW',
            workbox: {
                additionalManifestEntries: [{url: 'index.php', revision: '1'}],
                navigateFallback: 'index.php',
            },
            devOptions: {
                enabled: true,
                type: 'module',
            },
            manifest: {
                name: 'Poweruse - Total-prices',
                short_name: 'PU - totalprices',
                icons: [
                    {
                        "src": "resources/images/favicon/512x512.png",
                        "type": "image/png",
                        "sizes": "512x512"
                    }
                ],
                start_url: '/totalprices',
                theme_color: '#2196f3',
                background_color: '#2196f3',
                scope: '/',
                description: 'My Awesome App that will make you fall in love with Laravel.'
            }
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
