/* bad */
fn() {
  return new Promise((resolve) => {
    /* ... */
    resolve();
  });
}
  
/* good (async await returns a promise!) */
async fn() {
  await someAsyncStuff();
  return 'whatever';
}

/* also always working (needed, if inside promise a return value should be passed through) */
async fn() {
  return await new Promise((resolve) => {
    resolve('42');
  });
}