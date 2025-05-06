const CACHE_NAME = "adminischool-cache-v1";
const urlsToCache = [
    "/",
    "/manifest.json",
    "/css/app.css",
    "/js/app.js",
    "/images/logo_title.png"
];

self.addEventListener("install", event => {
    console.log("[Service Worker] Install event");
    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => {
            console.log("[Service Worker] Caching all resources");
            return cache.addAll(urlsToCache);
        })
    );
});

self.addEventListener("fetch", event => {
    console.log("[Service Worker] Fetch event for:", event.request.url);

    // Vérifiez si la requête est pour une ressource externe
    if (event.request.url.startsWith("https://img.icons8.com/")) {
        event.respondWith(
            caches.open(CACHE_NAME).then(cache => {
                return cache.match(event.request).then(response => {
                    if (response) {
                        return response; // Retourne la ressource mise en cache
                    }
                    return fetch(event.request).then(networkResponse => {
                        cache.put(event.request, networkResponse.clone()); // Met en cache la ressource
                        return networkResponse;
                    });
                });
            })
        );
    } else {
        // Gestion des ressources locales
        event.respondWith(
            caches.match(event.request).then(response => {
                return response || fetch(event.request);
            })
        );
    }
});

self.addEventListener("activate", event => {
    console.log("[Service Worker] Activate event");
    const cacheWhitelist = [CACHE_NAME];
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cacheName => {
                    if (!cacheWhitelist.includes(cacheName)) {
                        console.log("[Service Worker] Deleting old cache:", cacheName);
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});
