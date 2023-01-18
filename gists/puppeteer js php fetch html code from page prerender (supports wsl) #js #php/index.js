const puppeteer = require('puppeteer');
(async () => {
  	let browser = null;
  	try {
      browser = await puppeteer.launch({
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
      let page = await browser.newPage();
      await page.setDefaultTimeout(3000);      
      await page.setViewport({ width: 800, height: 600 });
      /* block images and css */
      await page.setRequestInterception(true);
      page.on('request', (req) => {
        if(req.resourceType() == 'stylesheet' || req.resourceType() == 'font' || req.resourceType() == 'image') {
          req.abort();
        }
        else {
          req.continue();
        }
      });      
      await page.goto('https://vielhuber.de', { waitUntil: 'networkidle2' });
      await page.waitForSelector('.text');
      await new Promise((resolve) => setTimeout(() => resolve(), 1000));
      await page.click('.foo');
      let foo = await page.$eval('.text', (e) => e.innerHTML);
      await page.screenshot({ path: 'example.png' });
      await browser.close();
    }
  	catch (e) {
     	console.log(e); 
    }
  	finally {
      	browser.close();
    }
})();
