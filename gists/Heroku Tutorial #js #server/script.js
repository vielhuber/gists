const Spooky = require('spooky');
const nodemailer = require('nodemailer');
const spooky = new Spooky({
    child: { transport: 'http' },
    casper: { logLevel: 'debug', verbose: true }
}, (err) => {
    spooky.start('https://vielhuber.de');
    spooky.then(function() {
        this.emit('done', this.evaluate(function() { return document.title; }));
    });
    spooky.run();
});
spooky.on('error', (e, stack) => {
    console.error(e); if (stack) { console.log(stack); }
});
spooky.on('done', (data) => {
    const transporter = nodemailer.createTransport({
        host: 'sslout.df.eu',
        port: 465,
        secure: true,
        auth: {
            user: 'smtp@vielhuber.de',
            pass: 'XXXXX' // enter your credentials here
        }
    });
    transporter.sendMail({
        from: '"Heroku" <smtp@vielhuber.de>',
        to: 'david@vielhuber.de',
        subject: 'Erledigt',
        text: data,
        html: '<b>'+data+'</b>'
    }, (error, info) => {
        if (error) { return console.log(error); }
    });
});