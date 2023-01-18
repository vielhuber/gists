// install
npm install archiver --save

// require
let fs = require('fs'),
    archiver = require('archiver');

// init
var output = fs.createWriteStream(__dirname + '/output.zip');
var archive = archiver('zip', { zlib: { level: 9 } });
archive.pipe(output);

// callback
output.on('close', () => { console.log('callback when everything is finished'); });

// append files / folders
archive.append(fs.createReadStream(__dirname + '/file1.txt'), { name: 'file1.txt' });
archive.append('string cheese!', { name: 'file2.txt' });
archive.directory('subdir/', 'new-subdir');
archive.directory('subdir/', false);
archive.glob('subdir/*.txt');
archive.finalize();