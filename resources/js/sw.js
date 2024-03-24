importScripts('https://storage.googleapis.com/workbox-cdn/releases/6.4.1/workbox-sw.js');

if (workbox) {
    workbox.precaching.precacheAndRoute(self.__WB_MANIFEST);
}

self.addEventListener('message', (event) => {
    if (event.data.action === 'clearCache') {
        self.caches.keys().then((cacheNames) => {
            cacheNames.forEach((cacheName) => {
                self.caches.delete(cacheName);
            });
        });
    }
});
