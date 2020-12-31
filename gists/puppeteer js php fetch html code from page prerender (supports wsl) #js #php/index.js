const puppeteer = require('puppeteer');
(async () => {
  	try {
      const browser = await puppeteer.launch({
          headless: true,
          ignoreHTTPSErrors: true,
          args: [
              '--disable-gpu',
              '--disable-dev-shm-usage',
              '--disable-setuid-sandbox',
              '--no-first-run',
              '--no-sandbox',
              '--no-zygote',
              '--single-process',
          ],
      });
      const page = await browser.newPage();
      await page.setDefaultTimeout(3000);
      await page.goto('https://vielhuber.de', { waitUntil: 'networkidle2' });
      await page.waitForSelector('.text');
      let foo = await page.$eval('.text', (e) => e.innerHTML);
      await page.screenshot({ path: 'example.png' });
      await browser.close();
    }
  	catch (e) {
     	console.log(e); 
    }
})();
