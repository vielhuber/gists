// warning: 42 is output to the console!
let p = new Promise((resolve, reject) => { reject(); console.log('foo'); });
p.then(() => {}).catch(() => {});

// do this instead
let p = new Promise((resolve, reject) => { reject(); return; console.log('foo'); });
p.then(() => {}).catch(() => {});