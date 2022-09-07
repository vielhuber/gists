Tr.prototype.translate = function (a, b, c, d, e, f, h, k) {
    var l = this,
        m = this.a.wc(a),
        n = {
            q: b,
            sl: c,
            tl: d
        };
    this.h.sp && 0 == this.h.sp.indexOf("nmt") || (n.sp = "nmt");
    n.tc = e;
    f && (n.ctt = 1);
    h && (n.dom = 1);
    k && (n.sr = 1);
    n[Dp()] = Bp(b.join(""), Hq);
    return this.s ? this.s.b().then(function (r) {
        null != r && (n.jwtt = r, n.rurl = location.hostname);
        return l.a.na.send(n, C(Wr(m), l))
    }, function (r) {
        r && l.Vb && l.Vb(r)
    }) : this.a.na.send(n, m)
};