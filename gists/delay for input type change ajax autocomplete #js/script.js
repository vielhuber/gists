var delay = (function(){
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();

$('input').keyup(function() {
    delay(function(){
      alert('foo');
    }, 1000 );
});