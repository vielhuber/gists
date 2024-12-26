import puppeteer from 'puppeteer';

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
        '--window-size=1920,1080'
    ],
    defaultViewport: {
        width: 1920,
        height: 1080
    }
});

const page = await browser.newPage();

await page.setDefaultTimeout(5000);

await page.goto('http://192.168.0.1');

await page.locator('#Password').fill(process.env.VODAFONE_PASSWORD);

await page.locator('#LoginBtn').click();

await new Promise(resolve => setTimeout(() => resolve(), 2000));

if ((await page.$('#OneUserLoginMsgOKBtn')) !== null) {
    page.locator('#OneUserLoginMsgOKBtn').click();
}

await page.locator('a[href*="settings_device"]').click();

await page.locator('#led_enable').click();

await page.waitForSelector('#beforeApplyMsg');

await page.locator('#applyButton2').click();

await page.waitForSelector('#afterApplyMsg');

await browser.close();
