self.addEventListener("push", (event) => {
    const notification = event.data.json();
    // {"title":"Hi" , "body":"something amazing!" , "url":"./?message=123"}
    event.waitUntil(self.registration.showNotification(notification.title, {
        body: notification.body,
        icon: "icon.png",
        data: {
            notifURL: notification.url
        }
    }));
});

self.addEventListener("notificationclick", (event) => {
    event.waitUntil(clients.openWindow(event.notification.data.notifURL));
});

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open('v1').then((cache) => {
            return cache.addAll([
                './',
                './index.php',
                './style.css',
                './script.js',
                './gato192.png',
                './gato512.png'
            ]);
        })
    );
});

self.addEventListener('fetch', (event) => {
    event.respondWith(
        caches.match(event.request).then((response) => {
            return response || fetch(event.request);
        })
    );
});
