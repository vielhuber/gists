#### links

- https://hackernoon.com/use-indexeddb-with-idb-a-1kb-library-that-makes-it-easy-8p1f3yqq

#### installation

```sh
npm install idb
```

#### usage

```js
import { openDB } from 'idb';

// connect (or create database if it does not exist)
const db1 = await openDB('database-name', 1, {
    upgrade(db) {
        db.createObjectStore('store1');
    }
});

// create (only if not exists)
db1.add('store1', 'value', 'key');

// update (or create)
db1.put('store1', 'value2', 'key');

// error handling (always do this)
db1.add('store1', 'value3', 'key')
    .then((result) => {})
    .catch((err) => {});
try { db1.add('store1', 'value', 'key'); } catch(e) {}

// get value
let val = await db1.get('store1', 'key');

// delete key
db1.delete('store1', 'key');

// close database
db1.close();
```