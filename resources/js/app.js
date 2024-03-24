import './bootstrap';

import {createApp, ref} from "vue";

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import { i18nVue } from 'laravel-vue-i18n';

// Import /swal from /sweetalert2 first.
import swal from 'sweetalert2';

// Then, set /window.swal as /swal so we can instantiate /swal later within our component.
window.swal = swal;

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

//This is for prompt-update of PWA
import { registerSW } from 'virtual:pwa-register'

function useRegisterSW(options = {}) {
    const {
        immediate = true,
        onNeedRefresh,
        onOfflineReady,
        onRegistered,
        onRegisteredSW,
        onRegisterError
    } = options;
    const needRefresh = ref(false);
    const offlineReady = ref(false);
    const updateServiceWorker = registerSW({
        immediate,
        onNeedRefresh() {
            needRefresh.value = true;
            window.dispatchEvent(new CustomEvent('open-modal', {detail: 'confirm-update-page'}));
            onNeedRefresh == null ? void 0 : onNeedRefresh();
        },
        onOfflineReady() {
            offlineReady.value = true;
            onOfflineReady == null ? void 0 : onOfflineReady();
        },
        onRegistered,
        onRegisteredSW,
        onRegisterError
    });
    return {
        updateServiceWorker,
        offlineReady,
        needRefresh
    };
}

const {
    offlineReady,
    needRefresh,
    updateServiceWorker,
} = useRegisterSW({
    immediate: true,
    onRegisteredSW(swUrl, r) {
        // eslint-disable-next-line no-console
        //console.log(`Service Worker at: ${swUrl} ` + reloadSW)
        r && setInterval(async () => {
            // eslint-disable-next-line no-console
            //console.log('Checking for sw update')
            // eslint-disable-next-line no-console
            await r.update()
        }, 600000 /* Every 10 minutes */)
    },
})
window.updateServiceWorker = updateServiceWorker;


import.meta.glob([
    '../videos/*.webm',
    '../images/icons/*.{ico,png,svg,jpg}',
    '../images/*.jpeg'
]);

import Chart from 'chart.js/auto';
window.Chart = Chart;

import flatpickr from "flatpickr";
let appLocale = $('html').attr('lang');
import {Danish} from "flatpickr/dist/l10n/da";
import {english} from "flatpickr/dist/l10n/default";
switch (appLocale) {
    case 'da':
        flatpickr.localize(Danish);
        break;
    case 'en':
    default:
        flatpickr.localize(english);
}
window.flatpickr = flatpickr;

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
app.mount('#app');
