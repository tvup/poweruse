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
const intervalMS = 60 * 60 * 1000
const updateSW = registerSW({
    onRegisteredSW(swUrl, r) {
        r && setInterval(async () => {
            if (!(!r.installing && navigator)) {
                return
            }

            if (('connection' in navigator) && !navigator.onLine) {
                return
            }

            const resp = await fetch(swUrl, {
                cache: 'no-store',
                headers: {
                    'cache': 'no-store',
                    'cache-control': 'no-cache',
                },
            })

            if (resp?.status === 200) {
                await r.update()
            }
        }, intervalMS)
    },
    immediate: true,
    onNeedRefresh() {},
    onOfflineReady() {},
    onRegisterError(error) {
        console.log('Der er desværre sket en fejl, så vi ikke kan registre service workeren: ' + error);
    }
})


import.meta.glob([
    '../images/icons/*.{ico,png,svg,jpg}'
]);

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
