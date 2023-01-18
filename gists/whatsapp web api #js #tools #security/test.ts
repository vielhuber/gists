import { WAConnection, MessageType, ReconnectMode, waChatKey } from '@adiwajshing/baileys';
import * as fs from 'fs';
async function test() {
    const conn = new WAConnection();
    conn.autoReconnect = ReconnectMode.onConnectionLost;
    conn.connectOptions.maxRetries = 10;
    conn.chatOrderingKey = waChatKey(true);
    conn.on('credentials-updated', () => {
        const authInfo = conn.base64EncodedAuthInfo();
        fs.writeFileSync('./auth_info.json', JSON.stringify(authInfo, null, '\t'));
    });
    fs.existsSync('./auth_info.json') && conn.loadAuthInfo('./auth_info.json');
    await conn.connect();
    const id = '49xxxxxxxxxx@s.whatsapp.net';
    const message = await conn.sendMessage(id, 'This works', MessageType.text);
    conn.close();
}
test().catch((err) => console.log(`encountered error: ${err}`));
