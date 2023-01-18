class PwaTest {

    async load() {
        let message = await this.fetchData();
        message = await this.updateOrApplyCache(message);
        let data = await this.applyQueue(message.data);
        this.buildHtml(message, data);
        this.bindActions();
        this.trackChanges();
        this.debugIdb();
    }

    async buildHtml(message, data) {
        // output debug information
        document.querySelector('.get-debug').innerHTML = `
            Status: ${message.success === true ? 'OK' : 'ERROR'}<br/>
            Response data: ${JSON.stringify(message)}<br/>
            Final data (queue applied): ${JSON.stringify(data)}
        `;

        // build input fields
        document.querySelector('.input-container').innerHTML = `
            <form>
                <input type="text" name="key1" placeholder="key1" value="${ data.filter(i => i.key === 'key1').map(i => i.value) || '' }" ${ data.filter(i => i.key === 'key1' && i.tmp === true).length > 0 ? ' data-tmp ' : '' } /><br/>
                <input type="text" name="key2" placeholder="key2" value="${ data.filter(i => i.key === 'key2').map(i => i.value) || '' }" ${ data.filter(i => i.key === 'key2' && i.tmp === true).length > 0 ? ' data-tmp ' : '' } /><br/>
                <input type="text" name="key3" placeholder="key3" value="${ data.filter(i => i.key === 'key3').map(i => i.value) || '' }" ${ data.filter(i => i.key === 'key3' && i.tmp === true).length > 0 ? ' data-tmp ' : '' }  /><br/>
            </form>
        `;

        // build/bind actions
        document.querySelector('.action-container').innerHTML = `
            <button class="clear_cache">clear cache</button>
            <button class="clear_queue">clear queue</button>
            <button class="sync_queue">sync queue</button>
        `;
    }

    async updateOrApplyCache(message) {
        // always cache data on success with the newest version
        if(message.success == true) {
            await this.updateCache(message.data);
            return message;
        }
        // if it was not successful (due to a network error), get cache
        // remember: we excluded the GET route intentionally in the service worker to handle the error here) 
        else {
            return {
                success: true,
                cached: true,
                data: await idbKeyval.get('cache') || []
            }
        }
    }

    fetchData() {
        return new Promise((resolve, reject) => {
            fetch('api.php').then((response) => {
                let data = response.json(),
                    status = response.status;
                if (status == 200 || status == 304) { return data; }
                return { success: false };
            }).catch((error) => {
                return { success: false };
            }).then(async (message) => {
                resolve(message);
            });
        });
    }

    debugIdb() {
        setInterval(async () => {
            document.querySelector('.idb-debug').innerHTML = `
                cache: ${ JSON.stringify(await idbKeyval.get('cache') || []) }<br/>
                queue: ${ JSON.stringify(await idbKeyval.get('queue') || []) }
            `;
        }, 500);
    }

    bindActions() {
        document.addEventListener('click', async (e) => { if( e.target.closest('.clear_cache') ) {
            await idbKeyval.del('cache');
            window.location.reload();
            e.preventDefault();
        }});
        document.addEventListener('click', async (e) => { if( e.target.closest('.clear_queue') ) {
            await idbKeyval.del('queue');
            window.location.reload();
            e.preventDefault();
        }});
        document.addEventListener('click', async (e) => { if( e.target.closest('.sync_queue') ) {
            await this.syncQueue();
            e.preventDefault();
        }});
    }

    trackChanges() {
        // register all changes on that form in a queue
        // this queue is NOT a queue in means of failed POST requests (which is also another valid approach)
        // we instead track all changes and you can push your queue (if online!)
        document.addEventListener('change', async (e) => {
            let $form = e.target.closest('.input-container form');
            if( $form ) {
                let $el = e.target;
                $el.setAttribute('data-tmp','');
                await this.addChangedValueToQueue($el.getAttribute('name'), $el.value);
            }
        });
    }

    async updateCache(data) {
        await idbKeyval.set('cache', data);
    }

    async applyQueue(original) {
        let cache = JSON.parse(JSON.stringify(original));
        let queue = await idbKeyval.get('queue') || [];

        cache.map(i => { i.tmp = false; return i; });

        for(let queue__value of queue) {
            let d1 = new Date(queue__value.timestamp.replace(' ','T'));
            let to_create = true;
            for(let cache__value of cache) {
                if( cache__value.key === queue__value.key ) {
                    let d2 = new Date(cache__value.timestamp.replace(' ','T'));
                    if( d1 > d2 ) {
                        cache__value.value = queue__value.value;
                        cache__value.timestamp = queue__value.timestamp;
                        cache__value.tmp = true;
                    }
                    to_create = false;
                    break;
                }
            }
            if( to_create === true ) {
                cache.push(queue__value);
            }
        }
        return cache;
    }

    async addChangedValueToQueue(key, value) {
        let queue = await idbKeyval.get('queue') || [];
        let timestamp =
            (new Date()).getFullYear() + '-' +
            ('0'+((new Date()).getMonth()+1)).slice(-2) + '-' +
            ('0'+(new Date()).getDate()).slice(-2) + ' ' +
            ('0'+(new Date()).getHours()).slice(-2) + ':' +
            ('0'+(new Date()).getMinutes()).slice(-2) + ':' +
            ('0'+(new Date()).getSeconds()).slice(-2);
        // if already exists, update
        let exists = false;
        for(let queue__value of queue) {
            if( queue__value.key === key ) {
                queue__value.value = value;
                queue__value.timestamp = timestamp;
                exists = true;
                break;
            }
        }
        if( exists === false ) {
            queue.push({
                key: key,
                value: value,
                timestamp: timestamp
            });
        }
        await idbKeyval.set('queue', queue);
    }

    async syncQueue() {
        fetch(
            'api.php',
            {
                method: 'POST',
                body: JSON.stringify({ 'queue': await idbKeyval.get('queue') || [] }),
                cache: 'no-cache',
                headers: { 'content-type': 'application/json' }
            }
        ).then((response) => {
            let data = response.json(),
                status = response.status;
            if (status == 200 || status == 304) { return data; }
            return { success: false };
        }).catch((error) => {
            return { success: false };
        }).then(async (message) => {
            // clear queue only on success
            if( message.success === true ) {
                await idbKeyval.set('queue', []);
                window.location.reload();
            }
            else {
                alert('failed to sync. get back online first!');
            }
        });
    }

}

let pwatest = new PwaTest();
window.addEventListener('load', e => {
    pwatest.load();   
});
