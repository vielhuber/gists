let arr = [7,8,9];

arr.map(i => i+1); // [8,9,10]

/* example of modifying item of array of objects */
arr = arr.map((i) => { i.content = i.content+'foo'; return i; });

/* get key */
arr.map((v,i) => v+i); // [7,9,11]

arr.filter(i => i > 7); // [8,9]
arr.filter(i => i > 7)[0] || null; // 8
arr.filter(i => i > 9)[0] || null; // null

arr.find(i => i > 7); // 8

arr.some(i => i > 7); // true

arr.sort((a,b) => b-a); // [9,8,7]

/* sum */
[{amount:1},{amount:3},{amount:3},{amount:7}].reduce((accumulator, currentValue) => accumulator + currentValue.amount, 0) // 14

let obj = {0: 7, 1: 8, 2: 9};

Object.keys(obj).map(i => obj[i]+1); // [8,9,10]
Object.keys(obj).map(i => { obj[i] += 1; }); console.log(obj); // {0: 8, 1: 9, 2: 10}

Object.keys(obj).filter(i => obj[i] > 7 ) // [1,2]
Object.keys(obj).filter(i => obj[i] > 7 ).reduce( (res, key) => (res[key] = obj[key], res), {}); // { 1: 8, 2: 9 }

Object.keys(obj).find(i => obj[i] > 7); // 1
Object.values(obj).find(i => i > 7); // 8

Object.keys(obj).some(i => obj[i] > 7); // true
Object.values(obj).some(i => i > 7); // true