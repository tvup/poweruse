// Importér Workbox-biblioteker (kun nødvendigt, hvis du bruger Workbox i en standalone SW uden Vite-plugin).
// importScripts('https://storage.googleapis.com/workbox-cdn/releases/6.4.1/workbox-sw.js');

// Check om Workbox blev indlæst korrekt.
if (workbox) {
    console.log(`Yay! Workbox is loaded 🎉`);

    // Her bruger du self.__WB_MANIFEST, normalt sammen med Workbox's precacheAndRoute metode.
    workbox.precaching.precacheAndRoute(self.__WB_MANIFEST);

    // Tilføj dine egne event listeners og caching strategier...
    self.addEventListener('fetch', event => {
        // Anvende strategier for caching eller returnere svar på fetch events
    });
} else {
    console.log(`Boo! Workbox didn't load 😬`);
}

// Dine egne event listeners og custom logik kan følge her...
