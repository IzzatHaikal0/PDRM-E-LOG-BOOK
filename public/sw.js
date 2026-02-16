// === CHANGED: Bumped version to 1.0.1 to FORCE phones to update ===
const CACHE_NAME = 'v1.0.1'; 

const cacheAssets = [
    '/favicon.ico',
    // === NEW: You MUST cache the offline page during install! ===
    '/offline.html' 
];

// 1. Install Event
self.addEventListener('install', event => {
    // Force the waiting service worker to become the active service worker
    self.skipWaiting(); 
    
    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => {
            console.log('Service Worker: Caching Files');
            return cache.addAll(cacheAssets);
        })
    );
});

// 2. Activate Event (Cleanup old caches)
self.addEventListener('activate', event => {
    // Tell the active service worker to take control of the page immediately
    event.waitUntil(clients.claim()); 

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

// 3. Fetch Event
self.addEventListener('fetch', function(event) {
    
    // === NEW SECURITY FIX: Never intercept POST/PUT/DELETE requests ===
    // This guarantees your Laravel Logins and Form submissions never break!
    if (event.request.method !== 'GET') {
        return; 
    }

    // 1. If it's a page navigation (like opening the app or clicking a link)
    if (event.request.mode === 'navigate') {
        event.respondWith(
            // ALWAYS try the live server first so Laravel can check the Remember Token
            fetch(event.request).catch(() => {
                // Only if the server is completely dead/offline, show the offline fallback
                return caches.match('/offline.html'); 
            })
        );
        return;
    }

    // 2. For all other things (CSS, Images, JS), use your normal cache strategy
    event.respondWith(
        caches.match(event.request).then(function(response) {
            return response || fetch(event.request);
        })
    );
});