let request = new Request('https://tld.com', {
    method: 'POST',
    body: JSON.stringify({ foo: 'bar' }),
    cache: 'no-cache',
    headers: {
       'content-type': 'application/json'
    }});

let obj = {
     'url': request.url,
    'method': request.method,
    'body': await request.clone().text(),
    'cache': request.cache,
    'headers': [...request.headers]
};

let str = JSON.stringify(obj); 

let restoredObject = JSON.parse(str);

let restoredRequest = new Request(restoredObject.url, {
    method: restoredObject.method,
    body: restoredObject.body,
    cache: restoredObject.cache,
    headers: restoredObject.headers
});

console.log(request);
console.log(await request.text());
console.log(obj);
console.log(str);
console.log(restoredObject);
console.log(restoredRequest);
console.log(restoredRequest.headers.get('content-type'));
console.log(await restoredRequest.text());