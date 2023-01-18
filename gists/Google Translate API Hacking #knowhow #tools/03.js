Hq = function () {
    function a(d) {
        return function () {
            return d
        }
    }
    var b = String.fromCharCode(107),
        c = a(String.fromCharCode(116));
    b = a(b);
    c = [c(), c()];
    c[1] = b();
    return yq["_c" + c.join(b())] || ""
}(),