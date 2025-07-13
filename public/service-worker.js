const CACHE_NAME = "adminischool-cache-v3";
const API_CACHE_NAME = "api-cache-v1";
const OFFLINE_URL = "/offline.html";

const PRECACHE_ASSETS = [
    "/",
    "/manifest.json",
    "/css/app.css",
    "/js/app.js",
    "/images/logo_title.png",
    OFFLINE_URL
];

self.addEventListener("install", (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => cache.addAll(PRECACHE_ASSETS))
            .then(() => self.skipWaiting())
    );
});

self.addEventListener("activate", (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    if (cacheName !== CACHE_NAME && cacheName !== API_CACHE_NAME) {
                        return caches.delete(cacheName);
                    }
                })
            );
        }).then(() => self.clients.claim())
    );
});

self.addEventListener("fetch", (event) => {
    // Ignore les requêtes non-GET
    if (event.request.method !== "GET") return;

    // Gestion des API
    if (event.request.url.includes("/api/")) {
        event.respondWith(
            fetch(event.request)
                .then((response) => {
                    // Mise en cache des réponses API
                    const cacheCopy = response.clone();
                    caches.open(API_CACHE_NAME)
                        .then((cache) => cache.put(event.request, cacheCopy));
                    return response;
                })
                .catch(() => {
                    // Retourne la version en cache si disponible
                    return caches.match(event.request);
                })
        );
        return;
    }

    // Gestion de la navigation
    if (event.request.mode === "navigate") {
        event.respondWith(
            fetch(event.request)
                .catch(() => caches.match(OFFLINE_URL))
        );
        return;
    }

    // Pour les autres assets
    event.respondWith(
        caches.match(event.request)
            .then((cachedResponse) => {
                return cachedResponse || fetch(event.request);
            })
    );
});

self.addEventListener("sync", (event) => {
    if (event.tag === "sync-actions") {
        event.waitUntil(
            syncPendingActions()
        );
    }
});

async function syncPendingActions() {
    const actions = await getPendingActions();
    for (const action of actions) {
        try {
            const response = await fetch(action.url, {
                method: action.method,
                body: action.body,
                headers: new Headers(action.headers)
            });
            
            if (response.ok) {
                await removePendingAction(action.id);
            }
        } catch (error) {
            console.error("Sync failed:", error);
        }
    }
}