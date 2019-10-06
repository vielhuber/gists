const puppeteer = require('puppeteer');
(async () => {
  const browser = await puppeteer.launch({
       args: [
            '--disable-gpu',
            '--disable-dev-shm-usage',
            '--disable-setuid-sandbox',
            '--no-first-run',
            '--no-sandbox',
            '--no-zygote',
            '--single-process',
       ]
  });
  const page = await browser.newPage();
  await page.goto('https://vielhuber.de');
  await page.screenshot({path: 'example.png'});
  await browser.close();
})();