importScripts('https://storage.googleapis.com/workbox-cdn/releases/6.4.1/workbox-sw.js');

if (workbox) {
    workbox.precaching.precacheAndRoute(self.__WB_MANIFEST);
}

self.addEventListener('message', (event) => {
    if (event.data.action === 'clearCache') {
        self.caches.keys().then((cacheNames) => {
            cacheNames.forEach((cacheName) => {
                console.log('Good bye');
                self.caches.delete(cacheName);
            });
        });
    }
});

self.addEventListener('message', (event) => {
    if (event.data.action === 'skipWaiting') {
        self.skipWaiting();
    }
});





self.addEventListener('fetch', function(event) {
    if (!event.request.url.startsWith('http')) {
        //console.log('Service worker ignores non-http(s) requests:', event.request.url);
        return;
    }
    if (event.request.method === 'GET') {

        event.respondWith(
            (async () => {
                try {

                    const cachedResponse = await getResponse(event.request.url);
                    if (cachedResponse) {
                        console.log('Returnerer cachede data fra IndexedDB');
                        return new Response(cachedResponse, {
                            headers: {'Content-Type': 'text/html'} // Tilpas denne efter faktisk respons type.
                        });
                    }


                    // Hvis ikke, fetch svaret fra netværket.
                    const response = await fetch(event.request);
                    const text = await response.clone().text(); // Antagelse: svaret er tekstbaseret.

                    // Gem svaret i IndexedDB til senere brug.
                    await saveResponse(event.request.url, text);

                    // Returner det frisk hentede svar.
                    return response;
                } catch (error) {
                    console.log('Fejl under fetching:', error);
                    return new Response('Der opstod en fejl', {
                        status: 503, // Service Unavailable
                    });
                }
            })()
        );
    }



});


async function saveResponse(key, value) {
    const db = await dbPromise;
    const tx = db.transaction('responses', 'readwrite');
    const store = tx.objectStore('responses');
    const request = store.put(value, key);
    console.log('saved!', key);
    console.log('saved!', value);

    return new Promise((resolve, reject) => {
        request.onsuccess = () => resolve();
        request.onerror = (event) => reject('Error saving to IndexedDB: ' + event.target.errorCode);
    });
}

async function getResponse(key) {
    const db = await dbPromise;
    const tx = db.transaction('responses', 'readonly');
    const store = tx.objectStore('responses');
    const request = store.get(key);
    console.log('retrieved!');

    return new Promise((resolve, reject) => {
        request.onsuccess = () => resolve(request.result); // Returner det fundne svar
        request.onerror = (event) => reject('Error reading from IndexedDB: ' + event.target.errorCode);
    });
}






const dbPromise = new Promise((resolve, reject) => {
    const open = indexedDB.open('MyDatabase', 1);

    open.onupgradeneeded = function() {
        const db = open.result;
        if (!db.objectStoreNames.contains('responses')) {
            db.createObjectStore('responses');
        }
    };

    open.onsuccess = function() {
        resolve(open.result);
    };

    open.onerror = function(event) {
        reject('IndexedDB error: ' + event.target.errorCode);
    };
});


