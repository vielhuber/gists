function a(x) {
  function b(y) {
    return x + y;
  }
  return b;
}

console.log(a(3)(4)); // 7

// explanation
a(3)(4) = (a(3))(4) = b'(4) = 7 mit b'(y) = { return 3+y; }