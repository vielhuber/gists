let p = new Promise((resolve, reject) => { resolve(42); });

p.then((value) =>
{
  console.log(value); // 42
  return value+1;
}).then((value) =>
{
  console.log(value); // 43
  return value+1;
}).then((value) =>
{
  console.log(value); // 44
});

// then returns a promise!
p.then(value => value+1).then(value => value+1).then(value => { console.log(value); }); // 44

// this also works with catch
let p = new Promise((resolve, reject) => { reject(7); });
p.then(value => value+1).catch(value => value+1).then(value => value+1).then(value => { console.log(value); }); // 9