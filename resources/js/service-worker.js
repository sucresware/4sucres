self.addEventListener('push', function (event) {
    if (event.data) {
        var data = event.data.json();
        self.registration.showNotification(data.title, {
            body: data.body,
            icon: data.icon,
            badge: data.badge,
            data: data.data,
        });
    }
});

self.addEventListener('notificationclick', function (event) {
    clients.openWindow(event.notification.data.url);
}, false);
