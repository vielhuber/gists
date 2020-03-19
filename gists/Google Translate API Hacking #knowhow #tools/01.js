function Bp(a, b) {
    var c = b.split(".");
    b = Number(c[0]) || 0;
    for (var d = [], e = 0, f = 0; f < a.length; f++) {
        var h = a.charCodeAt(f);
        128 > h ? d[e++] = h : (2048 > h ? d[e++] = h >> 6 | 192 : (55296 == (h & 64512) && f + 1 < a.length && 56320 == (a.charCodeAt(f + 1) & 64512) ? (h = 65536 + ((h & 1023) << 10) + (a.charCodeAt(++f) & 1023), d[e++] = h >> 18 | 240, d[e++] = h >> 12 & 63 | 128) : d[e++] = h >> 12 | 224, d[e++] = h >> 6 & 63 | 128), d[e++] = h & 63 | 128)
    }
    a = b;
    for (e = 0; e < d.length; e++) a += d[e], a = Ap(a, "+-a^+6");
    a = Ap(a, "+-3^+b+-f");
    a ^= Number(c[1]) || 0;
    0 > a && (a = (a & 2147483647) + 2147483648);
    c = a % 1E6;
    return c.toString() +
        "." + (c ^ b)
}