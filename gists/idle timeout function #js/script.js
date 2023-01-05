var idleTime = 0;
$(document).ready(function () {
    var idleInterval = setInterval(timerIncrement, 60000); // 1 minute
    $(this).mousemove(function (e) {
        idleTime = 0;
    });
    $(this).scroll(function (e) {
    	idleTime = 0;
    });
    $(this).keypress(function (e) {
        idleTime = 0;
    });
});
function timerIncrement() {
    idleTime = idleTime + 1;
    if (idleTime >= 30) { // 30 minutes
        window.location.reload();
    }
}