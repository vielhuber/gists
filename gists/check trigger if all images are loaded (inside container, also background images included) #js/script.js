/* npm install imagesloaded --save-dev */
/* PROBLEM: dynamic changes are not triggered! */
imagesLoaded('.container', { background: true }, () =>
{
  console.log('all images are loaded');
});