### installation
```sh
npm install --save express
npm install --save nodemon
```

### start
```sh
node index.js
npx nodemon # to automatically reload on route changes
```

### files

**package.json**
```json
"scripts": {
	"start": "node index.js"
}
```

**index.js**
```js
const express = require('express'),
    app = express(),
    port = process.env.PORT || 3000;
app.get('/', (req, res) => {
	// get query args
    let foo = req.query.foo;
    // send 404
    res.sendStatus(400);
    // send json
    res.json({
    	success: true,
    	data: null
    });
    res.send('Hello World!');
});
app.listen(port, () => {
    console.log(`Example app listening at http://localhost:${port}`);
});
```