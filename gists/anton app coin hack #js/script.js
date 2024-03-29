coins = 42,
sourceId = localStorage.getItem('sourceId').split('"').join(''),
deviceLogId = localStorage.getItem('deviceLogId').split('"').join(''),
users = JSON.parse(localStorage.getItem('users'));
users.forEach(users__value => {
    fetch('https://logger-lb-5.anton.app/events', {
        method: 'POST',
        'headers': { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            "events":[{"event":"adjustCoins","value":coins,"src":sourceId,"created":(new Date()).toISOString()}],
            "log":users__value.l,
            "credentials":{"authToken":users__value.t,"deviceLogId":deviceLogId}
        }),
    }).then(v=>v).catch(v=>v).then(data => { window.location.reload(); });
});