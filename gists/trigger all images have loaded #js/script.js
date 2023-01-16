var img = $(".parent_div img");
var count = img.length;
img.load(function() {
  count--;
  if(count === 0) {
    alert('done');
  }
});