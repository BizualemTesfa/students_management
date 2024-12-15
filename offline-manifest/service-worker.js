const CACHE_NAME = "student-management-app-v3";
const FILES_TO_CACHE = [
    "/",
    "/index.php",
    "/assets/css/styles.css",
    "/assets/js/script.js",
    "/admin/dashboard.php",
    "/teacher/dashboard.php",
    "/student/dashboard.php",
];

self.addEventListener("install", (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            console.log("Caching app shell");
            return cache.addAll(FILES_TO_CACHE);
        })
    );
    self.skipWaiting();
});

self.addEventListener("activate", (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cache) => {
                    if (cache !== CACHE_NAME) {
                        console.log("Deleting old cache:", cache);
                        return caches.delete(cache);
                    }
                })
            );
        })
    );
    self.clients.claim();
});

self.addEventListener("fetch", (event) => {
    event.respondWith(
        caches.match(event.request).then((response) => {
            return response || fetch(event.request);
        })
    );
});

/*
self.addEventListener('sync', (event) => {
    if (event.tag === 'sync-results') {
        event.waitUntil(syncOfflineResults());
    }
});

async function syncOfflineResults() {
    const db = await openIndexedDB(); // Replace with IndexedDB logic for fetching unsynced results
    const unsyncedResults = await db.getAll('results');

    for (const result of unsyncedResults) {
        try {
            const response = await fetch('/server/api.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(result),
            });
            if (response.ok) {
                await db.delete('results', result.id); // Remove synced result
            }
        } catch (error) {
            console.error('Sync failed for result:', result.id, error);
        }
    }
}
*/