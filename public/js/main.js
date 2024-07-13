const worker = new Worker("js/worker.js");

function askWorkerToPerformRecurringTask() {
    // post a sting to the worker
    worker.postMessage("recurring");
}
function sendMessageToWorker() {
    // post a sting to the worker
    worker.postMessage("Hello World !");
}
// This event is fired when the worker posts a message
// The value of the message is in messageEvent.data
worker.addEventListener("message", function (messageEvent) {
    const div = document.getElementById("result");
    // Log the received message on the top of the tag
    div.innerHTML = messageEvent.data + "<br>" + div.innerHTML;
});


if ('serviceWorker' in navigator) {
    navigator.serviceWorker
        .register('/ws.js')
        .then(serviceWorker => {
            console.log('Service Worker registered: ' + serviceWorker);
        })
        .catch(error => {
            console.log('Error registering the Service Worker: ' + error);
        });
}