/* npm install imagesloaded --save-dev */
/* PROBLEM: dynamic changes are not triggered! */
/* but this is intentionally: just use this function again after all dynamic changes are done! */
imagesLoaded('.container', { background: true }, () =>
{
  console.log('all images are loaded');
});