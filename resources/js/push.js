function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding)
        .replace(/-/g, '+')
        .replace(/_/g, '/');

    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);

    for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}

if ("Notification" in window && navigator.serviceWorker) {

    Notification.requestPermission().then(function(permission) {
        if (permission === "granted") {

            navigator.serviceWorker.register('/service-worker.js')
                .then(function(reg) {
                    console.log("Service Worker registered!", reg);

                    reg.pushManager.getSubscription().then(function(sub) {
                        if (sub === null) {
                            console.log("No subscription detected, subscribing...");

                            reg.pushManager.subscribe({
                                userVisibleOnly: true,
                                applicationServerKey: urlBase64ToUint8Array("{{ env('VAPID_PUBLIC_KEY') }}")
                            }).then(function(subscription) {
                                console.log("Subscribed:", subscription);
                                axios.post('/push-subscribe', subscription);
                            }).catch(function(err) {
                                console.error("Subscription failed", err);
                            });

                        } else {
                            console.log("Already subscribed", sub);
                            axios.post('/push-subscribe', sub);
                        }
                    });

                }).catch(function(error) {
                    console.error("Service Worker registration failed:", error);
                });

        } else {
            console.warn("Notifications permission denied");
        }
    });
}
