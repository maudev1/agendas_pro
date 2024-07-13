
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


function scheduleConfirmationNotify(){

    


}


