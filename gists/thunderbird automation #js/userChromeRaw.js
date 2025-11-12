async function purge() {
    for (let account of MailServices.accounts.accounts) {
        if (account.incomingServer.type !== 'imap') { continue; }
        let imapServer = account.incomingServer.QueryInterface(Ci.nsIImapIncomingServer);       
        await new Promise((resolve) => {
            imapServer.performExpand(null);
            resolve();            
        });
    }
    
    for(let folder of MailServices.accounts.allFolders) {
        //if(folder.URI.indexOf('foo') === -1) { continue; }
        console.log(folder.URI);
        await promiseUpdate(folder);
        console.log('update done');
        await sleep(100);
        await promiseCompact(folder);
        console.log('compact done');
        await sleep(100);
    }
}
setInterval(() => {
    purge();
},30*60*1000);
purge();


function sleep(ms) {
    return new Promise((resolve) => setTimeout(() => resolve(), ms));
}

function promiseUpdate(folder) {
    return new Promise((resolve, reject) => {
        if (folder.server.type !== 'imap' || !folder.canFileMessages) {
            resolve();
            return;
        }
        //console.log('downloadAllForOffline');
        folder.downloadAllForOffline({
            OnStartRunningUrl: function(url) {},
            OnStopRunningUrl: function(url, exitCode) {
                if (exitCode === 0) {
                    //console.log('Update erfolgreich: ' + folder.URI);
                    resolve('Update OK');
                } else {
                    //console.warn('Update fehlgeschlagen (' + exitCode + '): ' + folder.URI);
                    resolve('Update fehlgeschlagen');
                }
            }
        }, null);
    });
}

function promiseCompact(folder) {
    return new Promise((resolve, reject) => {
        if (!folder.canCompact) {
            resolve();
            return;
        }
        //console.log('compact');
        folder.compact({
            OnStartRunningUrl: function(url) {},
            OnStopRunningUrl: function(url, exitCode) {
                if (exitCode === 0) {
                    //console.log('Kompaktieren erfolgreich: ' + folder.URI);
                    resolve('Kompaktieren OK');
                } else {
                    //console.warn('Kompaktieren fehlgeschlagen (' + exitCode + '): ' + folder.URI);
                    resolve('Kompaktieren fehlgeschlagen');
                }
            }
        }, null);
    });
}