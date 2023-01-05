var arr = [
    ['a', 'b', 'c', 'd', 'a'],
    ['c', 'd', 'e'],
    ['b', 'c', 'd', 'd']
];
    
var arr = arr.shift().reduce(function(res, v) {
    if (res.indexOf(v) === -1 && arr.every(function(a) {
        return a.indexOf(v) !== -1;
    })) res.push(v);
    return res;
}, []);