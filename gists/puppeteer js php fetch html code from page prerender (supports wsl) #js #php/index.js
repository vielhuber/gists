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

  // more examples
  
  await page.waitForSelector('.text');
  
  try {
    await page.waitForSelector('.text', { timeout: 60000 });
  } catch () {
    console.log('not found!');
    /* ... */
  }
    
  await page.goto('...', { waitUntil: 'domcontentloaded' });

  await new Promise(resolve => setTimeout(resolve, 3000));
  
  await page.click('.foo');
  
  await page.type('input[type="password"]', 'xxx');
  
  let foo = await page.$eval('.text', (e) => e.innerHTML);
  
  let links = await page.$$eval('a.special-link', $els => {
    let data = [];
    $els.forEach($el => {
    	data.push($el.getAttribute('href'));
    });
    return data;
  });
  
  if (await page.$('.link-that-exists') !== null) {
    await page.$$eval('.link-that-exists', $els => {
      $els.forEach($el => {
        $el.click();
      });
    });
  }
  
}
catch (e) {
  console.log(e); 
}
finally {
  browser.close();
}
