
self.addEventListener('install', event => {
    console.log('Service Worker installing.');
});

self.addEventListener('activate', event => {
    console.log('Service Worker activating.');
});


self.addEventListener("message", function (messageEvent) {
    if (messageEvent.data === "recurring") {



    } else {
        // Post a message back to the main JS
        self.postMessage("Hello to you too !");
    }
});


self.addEventListener("push", event => {

    let notification = event.data.json();

    notify(notification);

    self.clients.matchAll().then(function (clients) {

        clients.forEach(function (client) {
            client.postMessage({
                msg: notification,
                // url: event.request.url
            });

        })



    })


}, false);


function notify(notification) {
    self.registration.showNotification(
        notification.title,
        notification.options
    ).catch((error) => {
        console.log(error);
    });
}

