import {defineConfig, loadEnv} from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import i18n from 'laravel-vue-i18n/vite';
import {VitePWA} from 'vite-plugin-pwa';
import { readFileSync, writeFile } from 'fs';
import { fileURLToPath } from 'url';

const file = fileURLToPath(new URL('revision', import.meta.url));
let revision = readFileSync(file, 'utf8');
revision = parseInt(revision) + 1;
writeFile(file, revision.toString(), (err) => { });

export default defineConfig(({command, mode}) => {
    const env = loadEnv(mode, process.cwd(), '');
    return {
        assetsInclude: ['**/*.webm'],
        publicDir: 'public',
        base: './',
        build: {
            outDir: './public',
            sourcemap: true,
            manifest: true,
            emptyOutDir: false,
        },
        plugins: [
            VitePWA({
                base: '/',
                scope: '/',
                outDir: './public',
                includeManifestIcons: false,
                mode: mode === 'production' ? 'production' : 'development',
                strategies: 'injectManifest',
                srcDir: 'resources/js',
                filename: 'sw.js',
                manifest: {
                    name: 'Poweruse - Total-prices',
                    short_name: 'PU - totalprices',
                    id: '/totalprices',
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
                        {
                            src: '/assets/images/icons/pwa-maskable_icon.png',
                            sizes: '512x512',
                            type: 'image/png',
                            purpose: 'maskable'
                        },
                    ],
                    theme_color: '#2196f3',
                    background_color: '#2196f3',
                    description: 'Get current electricty prices, calculate your upcomming bill, explore your past usages, and more.',
                },
                workbox: {
                    modifyURLPrefix: {
                        'build/': '/' //I'm unsure if this actually is needed
                    },
                    skipWaiting: false,

                    additionalManifestEntries: [
                        {url: '/home', revision: revision.toString()}
                    ],
                    globPatterns: ['**/*.{js,ico,css,png,svg,jpg,jpeg,webm,woff2,ttf}'],
                    maximumFileSizeToCacheInBytes: 2150000,
                    navigateFallback: '/home',
                    navigateFallbackDenylist: [
                        /^\/assets\/images/ ,
                        /^\/el-meteringpoint/ ,
                        /^\/el-charges/ ,
                        /^\/consumption/ ,
                        /^\/el-spotprices/ ,
                        /^\/el/ ,
                        /^\/el-custom/ ,
                        /^\/totalprices/ ,
                        /^\/login/ ,
                        /^\/register/ ,
                        /^\/privacy/,
                        /^\/profile/
                    ] //This is due to the manifest icons are in the public
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
                buildDirectory: './'
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
                '@': '/resources/js',
            },
        },
    }
});
