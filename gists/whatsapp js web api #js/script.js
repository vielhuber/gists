const { Client, LocalAuth } = require('whatsapp-web.js');
const qrcode = require('qrcode-terminal');
const fs = require('fs');

const client = new Client({
    authStrategy: new LocalAuth({ clientId: 'custom-session' }),
    puppeteer: {
        headless: true,
        args: [
            '--no-sandbox',
            '--disable-setuid-sandbox',
            '--disable-gpu',
            '--disable-dev-shm-usage',
            '--disable-setuid-sandbox',
            '--no-first-run',
            '--no-sandbox',
            '--no-zygote',
            '--single-process'
        ]
    }
});

client.on('qr', qr => {
    console.log('QR-Code scannen, um Zugriff zu erhalten!');
    qrcode.generate(qr, { small: true });
    process.exit();
});

client.on('ready', async () => {
    //console.log('Client ist bereit!');
    let data = [];
    let chats = await client.getChats();
    //console.log(chats);
    for (let chat of chats) {
        if (chat.name === 'David Vielhuber') {
            //console.log(`📨 Letzte 50 Nachrichten von ${chat.name || chat.id.user}:`);
            let messages = await chat.fetchMessages({ limit: 50 });
            messages.forEach(messages__value => {
                data.push(messages__value);
                //console.log(`[${msg.timestamp}] ${msg.from}: ${msg.body}`);
            });
        }
    }
    fs.writeFileSync('data.json', JSON.stringify(data));
    process.exit();
});

client.initialize();
