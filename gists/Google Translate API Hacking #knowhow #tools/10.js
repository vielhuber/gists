function _setupNS(b) {
    b = b.split(".");
    for (var a = window, c = 0; c < b.length; ++c) a.hasOwnProperty ? a.hasOwnProperty(b[c]) ? a = a[b[c]] : a = a[b[c]] = {} : a = a[b[c]] || (a[b[c]] = {});
    return a
}
window.addEventListener && "undefined" == typeof document.readyState && window.addEventListener("DOMContentLoaded", function () {
    document.readyState = "complete"
}, !1);
if (_isNS('google.translate.Element')) {
    return
}(function () {
    var c = _setupNS('google.translate._const');
    c._cest = gtConstEvalStartTime;
    gtConstEvalStartTime = undefined;
    c._cl = 'de';
    c._cac = '';
    c._cam = '';
    c._ctkk = '440159.776620256';
    var h = 'translate.googleapis.com';
    var s = (true ? 'https' : window.location.protocol == 'https:' ? 'https' : 'http') + '://';
    var b = s + h;
    c._pah = h;
    c._pas = s;
    c._pbi = b + '/translate_static/img/te_bk.gif';
    c._pci = b + '/translate_static/img/te_ctrl3.gif';
    c._pli = b + '/translate_static/img/loading.gif';
    c._plla = h + '/translate_a/l';
    c._pmi = b + '/translate_static/img/mini_google.png';
    c._ps = b + '/translate_static/css/translateelement.css';
    c._puh = 'translate.google.com';
    _loadCss(c._ps);
    _loadJs(b + '/translate_static/js/element/main_de.js');
})();