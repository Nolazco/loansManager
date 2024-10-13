navigator.serviceWorker.register("./sw.js");

function enableNotify(){
	Notification.requestPermission().then((permission) => {
		if(permission === 'granted'){
			navigator.serviceWorker.ready.then((sw) => {
				sw.pushManager.subscribe({
				    userVisibleOnly: true,
				    applicationServerKey: "BFbGqtQSJRmLiglIct8FIKUODsEO2xr3Ba5lIfse9DxrizLRQfJ29JgiMm9-5aqle3nVtGYQiIpAjz7lFnoTh9Y"
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
