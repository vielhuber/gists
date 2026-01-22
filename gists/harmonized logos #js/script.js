window.onload = function() {
  [].forEach.call(document.querySelectorAll('ul img'), function(el) {
    var container_width = parseInt(window.getComputedStyle(el.parentNode.parentNode).width);
    var image_ratio = (el.naturalHeight/el.naturalWidth);
    var target_area = Math.pow((container_width/10),2);
    var harmonized_width = Math.sqrt(target_area/image_ratio);
    el.parentNode.style.width = (Math.round((harmonized_width/container_width)*100*100)/100)+'%';
  });
}