var timeout;
$('input[type=text]').keypress(function() {
    if(timeout) {
        clearTimeout(timeout);
        timeout = null;
    }
    timeout = setTimeout(myFunction, 5000);
});