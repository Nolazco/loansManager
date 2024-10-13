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

let deferredPrompt;

window.addEventListener('beforeinstallprompt', (e) => {
    // Prevenir que el navegador muestre automáticamente el banner de instalación
    e.preventDefault();
    deferredPrompt = e;

    // Mostrar el botón para instalar la app (esto es opcional)
    const installButton = document.getElementById('installButton');
    installButton.style.display = 'block';

    installButton.addEventListener('click', () => {
        // Muestra el banner de instalación
        deferredPrompt.prompt();
        deferredPrompt.userChoice.then((choiceResult) => {
            if (choiceResult.outcome === 'accepted') {
                console.log('Usuario aceptó instalar la app');
            } else {
                console.log('Usuario rechazó la instalación');
            }
            deferredPrompt = null;
        });
    });
});
