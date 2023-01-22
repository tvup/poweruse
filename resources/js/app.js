import './bootstrap';
import './bootstrap-datepicker';

import {createApp} from "vue";

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import { i18nVue } from 'laravel-vue-i18n';

// Import /swal from /sweetalert2 first.
import swal from 'sweetalert2';

// Then, set /window.swal as /swal so we can instantiate /swal later within our component.
window.swal = swal;

import.meta.glob([
    '../images/favicon/**',
]);

import MeteringPoint from "../views/components/metering-points/MeteringPoint.vue";
import Charge from "../views/components/charges/Charge.vue";
import Paginate from "vuejs-paginate-next";
import {
    Button,
    HasError,
    AlertError,
    AlertErrors,
    AlertSuccess
} from 'vform/src/components/bootstrap5'

import { pwaInfo } from 'virtual:pwa-info';
import { registerSW } from 'virtual:pwa-register'

const date = __DATE__

import { Workbox } from 'workbox-window'
import { precacheAndRoute, createHandlerBoundToURL } from 'workbox-precaching'
import { registerRoute, NavigationRoute } from 'workbox-routing'

if ('serviceWorker' in navigator) {

    const wb = new Workbox('/build/assets/sw.js')

    precacheAndRoute([
        { url: '/index.php', revision: '383676' }
    ])

    const handler         = createHandlerBoundToURL('/index.php')
    const navigationRoute = new NavigationRoute(handler)
    registerRoute(navigationRoute)

    wb.register()
}

// eslint-disable-next-line no-console
console.log(pwaInfo);

const app = createApp({});
app.use(i18nVue, {
    resolve: async lang => {
        const langs = import.meta.glob('../lang/*.json');
        return await langs[`../lang/${lang}.json`]();
    }
});
app.component('metering-point', MeteringPoint);
app.component('charge', Charge);
app.component('pagination', Paginate);
app.component(Button.name, Button);
app.component('has-error', HasError);
app.component(AlertError.name, AlertError);
app.component(AlertErrors.name, AlertErrors);
app.component(AlertSuccess.name, AlertSuccess);
app.innerHTML = `
  <div>
   <img src="/favicon.svg" alt="PWA Logo" width="60" height="60">
    <h1>Vite + TypeScript</h1>
    <p>Testing SW without <b>Injection Point (self.__WB_MANIFEST)</b></p>
    <br/>
    <p>${date}</p>
    <br/>
  </div>
`
app.mount('#app');

registerSW({
    immediate: true,
    onNeedRefresh() {
        // eslint-disable-next-line no-console
        console.log('onNeedRefresh message should not appear')
    },
    onOfflineReady() {
        // eslint-disable-next-line no-console
        console.log('onOfflineReady message should not appear')
    },
})