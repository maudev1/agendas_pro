// // a function that generates a random number every second and posts it to the main JavaScript
// function generateNumbers(){
//     setInterval(function(){
//         // post a message to the main JavaScript
//         self.postMessage(Math.random());
//     }, 1000);
// }
// // This event is fired when the worker recieves a message from the main JavaScript
// // The value of the message is in messageEvent.data
// self.addEventListener("message", function(messageEvent){
//     if(messageEvent.data === "recurring"){
//         // If the value of the event is "recurring", we launch the above function
//         generateNumbers();
//     }else{
//         // Post a message back to the main JS
//         self.postMessage("Hello to you too !");
//     }
// });




let worker = {
    init: function () {

        worker.checkBrowserSupport();
        worker.watch();



    },
    watch: function () {

        worker.notify()


    },

    notify: function () {

        // let schedule = localStorage.getItem('schedule');


            

        // if (Notification.permission === "granted") {
        //     // Check whether notification permissions have already been granted;
        //     // if so, create a notification
        //     const notification = new Notification("Hi there!");
        //     // …
        // } else if (Notification.permission !== "denied") {
        //     // We need to ask the user for permission
        //     Notification.requestPermission().then((permission) => {
        //         // If the user accepts, let's create a notification
        //         if (permission === "granted") {
        //             // const notification = new Notification("Hi there!");
        //             // …
        //         }
        //     });
        // }

        // At last, if the user has denied notifications, and you
        // want to be respectful there is no need to bother them anymore.
    },

    checkBrowserSupport: function () {

        // console.log(document.window)

        // Document.window.Notification.requestPermission().then((result) => {
        //     console.log(result);
        //   })
        // init.js
        // if (!("Notification" in navigator)) {
        //     console.log('Esse browser não suporta notificações desktop');
        // } else {
        //     if (Notification.permission !== 'denied') {
        //         // Pede ao usuário para utilizar a Notificação Desktop
        //         await Notification.requestPermission();
        //     }
        // }



    }

};

(() => {

    "use strict";
    worker.init();

})()