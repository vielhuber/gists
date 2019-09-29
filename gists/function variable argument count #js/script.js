function add(a, ...args) {
  args.forEach((i) => { a = a+i; });
  return a;
}
// spread after function call
add(1, 2, 3, 4); // 10

// spread before function call
const arr = [2,3,4];
add(1, ...arr)