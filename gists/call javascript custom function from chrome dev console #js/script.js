"use strict";
(function($) {	
	$(document).ready(function() {
        window.customFunction = customFunction;
        function customFunction() {
            alert('FOO');     
        }
	});
})(jQuery);