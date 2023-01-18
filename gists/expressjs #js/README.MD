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
app.use(this.express.static('public')); // make all static files in "public" folder available (without "public" in url)
app.get('/', (req, res) => {
	// get query args
    let foo = req.query.foo;
    // send status + data
    res.send(200);
    res.json({
    	success: true,
    	data: null
    });
    return; // this has to be calld if you don't use "send"
});
app.listen(port, () => {
    console.log(`Example app listening at http://localhost:${port}`);
});
```