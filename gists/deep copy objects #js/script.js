// objects
let obj1 = { 
  a: 1,
  b: { 
    c: 2,
  },
};
let obj2 = JSON.parse(JSON.stringify(obj1));

// everything else
npm install --save clone-deep
let obj2 = cloneDeep(obj1);