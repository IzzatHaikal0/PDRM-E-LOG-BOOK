const CACHE_NAME = 'v1.0.0';
const cacheAssets = [
    '/favicon.ico',
    // Add other assets here if needed, e.g., '/images/logo.png'
];

// 1. Install Event
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => {
            console.log('Service Worker: Caching Files');
            return cache.addAll(cacheAssets);
        })
    );
});

// 2. Activate Event (Cleanup old caches)
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keyList => {
            return Promise.all(keyList.map(key => {
                if(key !== CACHE_NAME){
                    console.log('Service Worker: Clearing Old Cache', key);
                    return caches.delete(key);
                }
            }));
        })
    );
});

// 3. Fetch Event (The Typo Fix)
self.addEventListener('fetch', event => {
    event.respondWith(
        caches.open(CACHE_NAME).then(cache => {
            // FIXED SPELLING: event.request
            return cache.match(event.request).then(response => {
                return response || fetch(event.request);
            });
        })
    );
});