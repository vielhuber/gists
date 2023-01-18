## some easy rules
- if you need to store files in a database, always use datatype BLOB (not base64 string)
- storing the mime type is recommened, but not mandatory
- if you serve that file via a json rest api, simply base64 encode it beforehand
- solution #1 only works for files less than 2 mb on chrome!
- for a better solution look at solution 2

## solution 1
```js
let base64 = response.data.data,
    filename = response.data.name,
    url = 'data:application/octet-stream;base64,'+base64;

let a = document.createElement('a');
a.setAttribute('style','display:none');
a.setAttribute('download', filename);
a.setAttribute('href', url);
document.body.appendChild(a);
a.click();
a.remove();
```

## solution 2
```js
let base64 = response.data.data,
    filename = response.data.name,
    url = hlp.base64tourl(base64);

let a = document.createElement('a');
a.setAttribute('style','display:none');
a.setAttribute('download', filename);
a.setAttribute('href', url);
document.body.appendChild(a);
a.click();
window.URL.revokeObjectURL(url);
a.remove();
```