### installation
```sh
npm install @adiwajshing/baileys
npm install typescript
npm install ts-node
```

### usage
```sh
npx ts-node test.ts
```

### run from php
```php
shell_exec('/root/.nvm/versions/node/v12.10.0/bin/node ./node_modules/ts-node/dist/bin test.ts');
shell_exec('"C:\Program Files\nodejs\node" ./node_modules/ts-node/dist/bin test.ts');
```

### example
```test.ts
import { WAConnection, MessageType, ReconnectMode, waChatKey } from '@adiwajshing/baileys';
import * as fs from 'fs';
async function test() {
    const conn = new WAConnection();
    conn.autoReconnect = ReconnectMode.onConnectionLost;
    conn.connectOptions.maxRetries = 10;
    conn.chatOrderingKey = waChatKey(true);
    conn.on('credentials-updated', () => {
        console.log(`credentials updated`);
        const authInfo = conn.base64EncodedAuthInfo(); // get all the auth info we need to restore this session
        fs.writeFileSync('./auth_info.json', JSON.stringify(authInfo, null, '\t')); // save this info to a file
    });
    fs.existsSync('./auth_info.json') && conn.loadAuthInfo('./auth_info.json');
    await conn.connect();
    const id = '49xxxxxxxxxx@s.whatsapp.net';
    const message = await conn.sendMessage(id, 'Coole Sache', MessageType.text);
    console.log(message);
    conn.close();
}
test().catch((err) => console.log(`encountered error: ${err}`));
```