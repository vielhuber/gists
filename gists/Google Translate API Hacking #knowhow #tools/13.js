x.Pf = function (a, b) {
    b.g && this.l.remove(b.f);
    if (!this.b) return !1;
    if (this.l.has(b.ea(), !1)) {
        var c = this.l;
        if (c.has(b.f, !1)) {
            var d = b.f,
                e = c.a[d];
            e || (e = c.b[d], c.a[d] = e);
            b.b = e;
            b.K = !0
        } else c.remove(b.f), b.g = !0;
        zt(b)
    } else if (c = this.l, b.g) c.remove(b.f);
    else if (b.o) {
        d = b.o.replace(/<a /g, "<span ").replace(/\/a>/g, "/span>");
        b.K = !0;
        delete b.o;
        b.o = null;
        b.b = [];
        e = jg(document, Za);
        Q(e, !1);
        e.innerHTML = 0 <= d.indexOf("<i>") ? d : "<b>" + d + "</b>";
        document.body.appendChild(e);
        d = [];
        var f;
        for (f = e.firstChild; f; f = f.nextSibling)
            if ("I" ==
                f.tagName) var h = yt(b, Kg(f), f.innerHTML);
            else if ("B" == f.tagName) {
            h || (h = yt(b, "", ""));
            if (1 == b.a.length) xt(h.$, d, 0, f);
            else {
                var k = d;
                var l = f;
                var m = b.a;
                h = h.$;
                for (var n = [], r, w = l.firstChild; w; w = r) r = w.nextSibling, Ct(w);
                for (r = l.firstChild; r; r = r.nextSibling) r.attributes && r.attributes.i ? (l = parseInt(r.attributes.i.nodeValue, 10), !isNaN(l) && 0 <= l && l < m.length && (m[l].ee && n[l] ? n[l].T += r.firstChild && 3 == r.firstChild.nodeType ? r.firstChild.nodeValue : Kg(r) : n[l] = xt(h, k, l, r))) : 3 == r.nodeType && h.push({
                    R: -1,
                    T: De(r.nodeValue)
                });
                null != h && 0 < h.length && -1 == h[0].R && (1 == h.length ? h[0].R = 0 : (h[1].T = h[0].T + h[1].T, h.shift()))
            }
            h = void 0
        }
        f = b.b;
        for (k = 0; k < f.length - 1; ++k) m = f[k], h = ze(m.$[m.$.length - 1].T), h = h.charCodeAt(h.length - 1), 12288 <= h && 12351 >= h || 65280 <= h && 65519 >= h || (m.$[m.$.length - 1].T += " ");
        sg(e);
        for (e = 0; e < b.a.length; ++e) e < d.length && e < b.l.length && null != d[e] && (f = b.l[e], k = d[e].start, null != k && (m = f.substring(0, f.length - ye(f).length), " " == m && (m = ""), m && (k.T = m + ye(k.T))), k = d[e].end, null != k && (f = f.substring(ze(f).length), " " == f && (f = ""), f && (k.T =
            ze(k.T) + f)));
        1 != b.b.length || b.b[0].lf || (b.b[0].lf = b.f);
        c.write(b.f, b.b);
        zt(b)
    }
    b.H || (this.W = !1);
    c = b.g ? !0 : void 0;
    a.K += b.G;
    null != c && (a.qa = !0);
    b = Math.min(Math.floor(100 * a.K / a.f), 100);
    if (a.o != b || c) a.o = b, a.L ? (a.l(a.o, !0, c), a.W(a.K)) : a.l(a.o, !1, c);
    return !1
};