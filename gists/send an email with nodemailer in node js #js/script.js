// installation
npm install nodemailer --save

// usage
const nodemailer = require('nodemailer');
let transporter = nodemailer.createTransport({
      host: 'hostname',
      port: 587,
      secure: true,
      auth: {
          user: 'username',
          pass: 'password'
      }
    }),
    message = {
      from: '"Testmail 👻" <'+'david@vielhuber.de'+'>',
      to: 'david@vielhuber.de',
      subject: 'Test E-Mail ✔',
      generateTextFromHTML: true,
      html: fs.readFileSync('template.html', 'utf-8'),
      attachments: []
    }
message = embedInlineImages(message);
transporter.sendMail(message, (error, info) => {
	if (error) { return console.log(error); }
});

// helper function to auto inline images
function embedInlineImages(message)
{
  message.html = message.html.replace(/<img[^>]*>/gi, function (imgTag)
                                      {
    return imgTag.replace(/\b(src\s*=\s*(?:['"]?))([^'"> ]+)/i, function (src, prefix, url)
                          {
      let cid = (~~(Math.random()*(9999-1000+1))+1000)+'@possible';
      message.attachments.push({
        filename: (url || '').trim(),
        path: process.cwd()+'/'+(url || '').trim(),
        cid: cid
      });
      return (prefix || '') + 'cid:' + cid;
    });
  });
  return message;
}