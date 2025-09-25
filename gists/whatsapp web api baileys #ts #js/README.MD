## installation

- ```nvm use --lts```
- ```npm install baileys```

## usage

- ```node script.js```
- clear session: `rm -rf ./auth_info_baileys/`

```js
import makeWASocket, { useMultiFileAuthState } from 'baileys';
import QRCode from 'qrcode';
import P from 'pino'

function sendMessage() {
    return new Promise(async (resolve,reject) => {
      let { state, saveCreds } = await useMultiFileAuthState('auth_info_baileys');
      let sock = makeWASocket({ auth: state, logger: P({
        level: 'silent' // or "info"
      } , P.destination(2) ) });
      sock.ev.on('creds.update', saveCreds);
      sock.ev.on('connection.update', async (update) => {
          let { connection, lastDisconnect, qr } = update;
          if (qr) {
            let code = await QRCode.toString(qr, { type: 'utf8' });
            console.log(code);
          }
          else if (connection === 'close') {
            let statusCode = lastDisconnect?.error?.output?.statusCode;
            // reconnect after pairing (needed!)
            if( statusCode === 515 ) {
              resolve(await sendMessage());
              return;
            }
          }
          else if(connection === 'open') {
              // send message to group
              let response = await sock.groupFetchAllParticipating()
              let msgResponse = null;
              for(let response__value of Object.values(response)) {
                  if( response__value.subject === 'Some Group Name' ) {
                      msgResponse = await sock.sendMessage(response__value.id, { text: '🤖🤖🤖 Dies ist eine automatisch generierte Nachricht 🤖🤖🤖' })
                  }
              }
              resolve(msgResponse);
              return;
          }
      });
    });
}
await sendMessage();
process.exit();
```
