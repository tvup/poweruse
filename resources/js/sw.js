importScripts('https://storage.googleapis.com/workbox-cdn/releases/6.4.1/workbox-sw.js');

if (workbox) {
    console.log(`Yay! Workbox is loaded 🎉`);

    workbox.precaching.precacheAndRoute(self.__WB_MANIFEST);

} else {
    console.log(`Boo! Workbox didn't load 😬`);
}
