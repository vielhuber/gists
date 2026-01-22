document.addEventListener('DOMContentLoaded', () => {
    updateNetworkStatus();
    window.addEventListener('online', () => { updateNetworkStatus(); });
    window.addEventListener('offline', () => { updateNetworkStatus(); });
});
function updateNetworkStatus() {
    let status = navigator.onLine ? 'online' : 'offline';
    console.log(status);
}