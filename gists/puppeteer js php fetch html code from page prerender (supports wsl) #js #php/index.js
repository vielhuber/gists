import puppeteer from 'puppeteer';

let browser = null;
try {
  browser = await puppeteer.launch({
    headless: false,
    ignoreHTTPSErrors: true,
    args: [
      '--disable-gpu',
      '--disable-dev-shm-usage',
      '--disable-setuid-sandbox',
      '--no-first-run',
      '--no-sandbox',
      '--no-zygote',
      '--single-process',
      '--window-size=1920,1080'
    ],
    defaultViewport: {
      width: 1920,
      height: 1080
    },
    //userDataDir: '/tmp/myChromeSession', // only important for subsequent sessions where devices should be remembered    
  });

  let page = await browser.newPage();
  await page.setDefaultTimeout(3000);
  
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

  await page.goto('https://vielhuber.de/42', { waitUntil: 'networkidle2' });
  await page.screenshot({ path: 'live.png' });
  await browser.close();

  /*
      await page.waitForSelector('.text');
      await new Promise((resolve) => setTimeout(() => resolve(), 1000));
      await page.click('.foo');
      let foo = await page.$eval('.text', (e) => e.innerHTML);
      */
}
catch (e) {
  console.log(e); 
}
finally {
  browser.close();
}
