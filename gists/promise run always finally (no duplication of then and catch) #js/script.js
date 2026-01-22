let p = new Promise((resolve, reject) => { resolve(42); reject(7); });

// WARNING: resolved/rejected values are not present in finally method

// variant 1
p.then((data) => { console.log('this runs if success'); }).catch((data) => { console.log('this runs if error'); }).then(() => { console.log('this runs always'); });

// variant 2
p.finally(() => { console.log('this runs always') });

// variant 3
try { await p; }
finally { console.log('this runs always'); }

// variant 4 (with data!)
p.then(v=>v).catch(v=>v).then(data =>
{
  console.log('this runs always');
});