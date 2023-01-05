// without a name
(function() {

})();

// with a name
(function self_invoking() {
  
})();

// with name and arguments
(function self_invoking(argument1, argument2, argument3) {

})('value1', 'value2', 'value3');

// running forever
(function self_invoking() {
    // i run forever
    self_invoking();
})();

// jQuery (jQuery gets "converted" to $)
(function($) {

})(jQuery);