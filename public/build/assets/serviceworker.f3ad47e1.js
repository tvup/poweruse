self.addEventListener("fetch",function(e){e.respondWith(caches.match(e.request).then(function(t){return t||fetch(e.request)}))});
