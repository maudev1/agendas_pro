class Push {

    constructor() {

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

        // this.initPush();

    }

    initPush() {
        // let self = this
        if (!navigator.serviceWorker.ready) {
            return;
        }

        new Promise(function (resolve, reject) {
            const permissionResult = Notification.requestPermission(function (result) {
                resolve(result);
            });

            if (permissionResult) {
                permissionResult.then(resolve, reject);
            }
        })
             .then((permissionResult) => {
                 if (permissionResult !== 'granted') {
                     throw new Error('We weren\'t granted permission.');
                 }
                //  self.subscribeUser();
             });
    }

    subscribeUser() {
        navigator.serviceWorker.ready
            .then((registration) => {
                const subscribeOptions = {
                    userVisibleOnly: true,
                    applicationServerKey: this.urlBase64ToUint8Array(
                        'BM-ZRc6vULcr5I_s0ErKbIw2Pecf08Tj0VV-fzkt0FSVHrUg6x02izMafHhxYlebiA2r1EzIj-zTQIe4Gho_vrI'
                    )
                };

                return registration.pushManager.subscribe(subscribeOptions);
            })
            .then((pushSubscription) => {
                console.log('Received PushSubscription: ', JSON.stringify(pushSubscription));
                this.storePushSubscription(pushSubscription);
            });
    }

    subscribeCustomer(schedule) {
        navigator.serviceWorker.ready
            .then((registration) => {
                const subscribeOptions = {
                    userVisibleOnly: true,
                    applicationServerKey: this.urlBase64ToUint8Array(
                        'BM-ZRc6vULcr5I_s0ErKbIw2Pecf08Tj0VV-fzkt0FSVHrUg6x02izMafHhxYlebiA2r1EzIj-zTQIe4Gho_vrI'
                    )
                };

                return registration.pushManager.subscribe(subscribeOptions);
            })
            .then((pushSubscription) => {
                console.log('Received PushSubscription: ', JSON.stringify(pushSubscription));

                this.storePushSubscription(pushSubscription, schedule);
            });
    }

    urlBase64ToUint8Array(base64String) {
        var padding = '='.repeat((4 - base64String.length % 4) % 4);
        var base64 = (base64String + padding)
            .replace(/\-/g, '+')
            .replace(/_/g, '/');

        var rawData = window.atob(base64);
        var outputArray = new Uint8Array(rawData.length);

        for (var i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    }

    storePushSubscription(pushSubscription, data) {
        let form = document.getElementById('checkout-form');
        let token = form.children._token

        let subscription          = {'pushSubscription': pushSubscription};
        subscription ['customer'] = data.customer;
        subscription ['schedule'] = data.schedule;
        
        fetch('/push/register', {
            method: 'POST',
            body: JSON.stringify(subscription),
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-Token': token.value
            }
        })
            .then((res) => {
                return res.json();
            })
            .then((res) => {
                console.log(res)
            })
            .catch((err) => {
                console.log(err)
            });
    }
};



