### installation

- `echo "23.5.0" > ".nvmrc"`
- `node --version && npm --version` (at least node >=20 and npm >=9)
- `npm install @browserbasehq/stagehand zod`
- `npx playwright install-deps`
- `npm exec playwright install`
- `echo "OPENAI_API_KEY=sk-..." > .env`

### usage

- `node script.js`

### example

```js
import { Stagehand } from '@browserbasehq/stagehand';
const stagehand = new Stagehand({ env: "LOCAL", debugDom: true, enableCaching: true });
await stagehand.init();

await stagehand.page.goto('https://vielhuber.de');
await stagehand.act({ action: 'click on "Blog".' });
await stagehand.act({ action: 'click on the newest blog entry.' });

await stagehand.close();

//const actions = await stagehand.observe();
//console.log(actions);
```