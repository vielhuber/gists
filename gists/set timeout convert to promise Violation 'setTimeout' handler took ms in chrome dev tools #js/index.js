// before
setTimeout(() => {
    // potentially long running task
}, 1500);

// after
new Promise(resolve => { setTimeout(() => { resolve(); }, 1500); }).then(() => {
    // potentially long running task
});