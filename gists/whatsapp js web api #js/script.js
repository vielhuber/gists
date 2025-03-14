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
        ],
        defaultViewport: {
            width: 1920,
            height: 1080
        }
    }
});

client.on('qr', async qr => {
    console.log('QR-Code erhalten!');
    qrcode.generate(qr, { small: true }, function (qrcode) {
      	console.log(qrcode);
        console.log('Schreibe Datei...');
        fs.writeFileSync(
            'qr.json',
            JSON.stringify({
                success: true,
                data: { img: qrcode }
            })
        );
        fs.writeFileSync(
            'status.json',
            JSON.stringify({
                success: true,
                message: 'finished'
            })
        );
    });
});

client.on('ready', async () => {
    console.log('Client ist bereit!');

  	// send message
    let recipient = 'xxx@g.us';
    await client.sendMessage(recipient, '🤖 test 🤖');
    let media = MessageMedia.fromFilePath('dummy.pdf');
    let response = await client.sendMessage(recipient, media, { caption: '🤖 media file 🤖' });
  
    // fetch messages
  	let data = [];
    let chats = await client.getChats();
    for (let chat of chats) {
        let messages = await chat.fetchMessages({ limit: 50 });
        messages.forEach(messages__value => {
          data.push(messages__value);
        });
    }
    fs.writeFileSync('data.json', JSON.stringify({ success: true, data: data }));
    fs.writeFileSync(
        'status.json',
        JSON.stringify({
            success: true,
            message: 'finished'
        })
    );
  	await client.destroy();
    process.exit();
});

fs.writeFileSync(
    'status.json',
    JSON.stringify({
        success: true,
        message: 'initializing'
    })
);
client.initialize();

// limit timeout
setTimeout(async () => {
  	await client.destroy();
    process.exit();
}, 120000);
