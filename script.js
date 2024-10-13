navigator.serviceWorker.register("./sw.js");

function enableNotify(){
	Notification.requestPermission().then((permission) => {
		if(permission === 'granted'){
			navigator.serviceWorker.ready.then((sw) => {
				sw.pushManager.subscribe({
				    userVisibleOnly: true,
				    applicationServerKey: "BCXT7_uq8d1dtzyp2WGlGr7iDnm5koAHeCBDxfHjsfJviT4VV2pRXxUL7aUM0w89nRNa2wHlFJFzL5bLfrubn0c"
				}).then((subscription) => {
				    fetch('/saveSubscription.php', {
				        method: 'POST',
				        body: JSON.stringify(subscription),
				        headers: {
				            'Content-Type': 'application/json'
				        }
				    });
				});
			});
		}
	});
}

enableNotify();