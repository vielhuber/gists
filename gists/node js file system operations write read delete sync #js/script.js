/* the following operations are all working synchroniously */

// install
npm install fs-extra --save
// require
const fs = require('fs-extra');
// copy
fs.copySync('source.txt', 'target.txt', { overwrite: true });
// read
let data = fs.readFileSync('source.txt', 'utf-8');
// write
fs.writeFileSync('target.txt', string, 'utf-8');
// append
fs.appendFileSync('target.txt', string+'\n', 'utf-8');
// move
fs.moveSync('source.txt', 'target.txt', { overwrite: true });
// delete
fs.removeSync('source.txt');