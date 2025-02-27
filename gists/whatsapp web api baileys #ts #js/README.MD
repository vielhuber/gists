## installation

- ```echo "23.5.0" > ".nvmrc"```
- ```node --version && npm --version``` (at least node >=20 and npm >=9)
- ```npm init -y```
- ```npm install baileys```
- ```npm install --save-dev tsx```

```ts
import makeWASocket, { useMultiFileAuthState } from 'baileys';
async function connectToWhatsApp () {
    const { state, saveCreds } = await useMultiFileAuthState('auth_info_baileys');
    const sock = makeWASocket({ auth: state, printQRInTerminal: true });
    sock.ev.on('creds.update', saveCreds);
    sock.ev.on('connection.update', async (update) => {
        const { connection, lastDisconnect } = update;
        if(connection === 'open') {
            // send message to group
            const response = await sock.groupFetchAllParticipating()
            for(let response__value of Object.values(response)) {
                if( response__value.subject === 'Some Group Name' ) {
                    await sock.sendMessage(response__value.id, { text: '🤖🤖🤖 Dies ist eine automatisch generierte Nachricht 🤖🤖🤖' })
                }
            }
            process.exit();
        }
    });
}
connectToWhatsApp();
```

## usage

- ```npx tsx index.ts```