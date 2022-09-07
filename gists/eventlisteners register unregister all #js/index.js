var eventListeners = [];

registerEventListener(window, 'scroll', () => { console.log('ok'); });
        
setTimeout(() => { unregisterAllEventListeners(); }, 5000);

function registerEventListener(obj, type, fn) {
    obj.addEventListener(type, fn);
    eventListeners.push({ obj: obj, type: type, fn: fn });
}

function unregisterAllEventListeners() {
    eventListeners.forEach(eventListeners__value => {
        eventListeners__value.obj.removeEventListener(eventListeners__value.type, eventListeners__value.fn);
    });
}