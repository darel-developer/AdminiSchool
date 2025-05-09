const CACHE_NAME = "adminischool-cache-v2";
const urlsToCache = [
    "/",
    "/manifest.json",
    "/css/app.css",
    "/js/app.js",
    "/images/logo_title.png",
    "/offline.html" // Add an offline fallback page
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

    event.respondWith(
        caches.match(event.request).then(response => {
            if (response) {
                return response; // Serve from cache
            }
            return fetch(event.request).catch(() => {
                // Serve offline fallback page for navigation requests
                if (event.request.mode === "navigate") {
                    return caches.match("/offline.html");
                }
            });
        })
    );
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
