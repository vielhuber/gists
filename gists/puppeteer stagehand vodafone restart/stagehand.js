import { Stagehand } from '@browserbasehq/stagehand';

const stagehand = new Stagehand({
    headless: true,
    env: 'LOCAL',
    debugDom: true,
    enableCaching: true,
    verbose: 0
});

await stagehand.init();

await stagehand.page.goto('http://192.168.0.1');

await stagehand.page.act({
    action: 'enter %password% into the password field',
    variables: { password: process.env.VODAFONE_PASSWORD }
});

await stagehand.page.act({ action: 'click the login button' });

await stagehand.page.act({ action: 'if a message appears, that another user is logged in, click "OK"' });

await stagehand.page.act({ action: 'click on "Einstellungen"' });

// manual call, since the radio button is invisible
await stagehand.page.locator('#led_enable').click();

await new Promise(resolve => setTimeout(() => resolve(), 5000));

await stagehand.page.act({ action: 'click on "Anwenden"' });

await stagehand.close();
