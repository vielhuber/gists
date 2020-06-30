fetch(
  'http://example.com/movies.json',
  {
    method: 'POST',
    body: JSON.stringify({ foo: 'bar' }),
    cache: 'no-cache',
    headers: {
       'content-type': 'application/json'
    }
  }
).then((response) =>
{
  // this is another promise which gets resolved in the second then
  // do something if you want with it
  // or simply return it
  // important: to check for status codes (like 404 or 500), check here if needed
  let data = response.json(),
      status = response.status;
  if (status == 200 || status == 304) {
   	return data; 
  }
  return { success: false, message: status };
}).catch((error) => 
{
	// this does not fire on 404 or other status codes but on all js errors AND network outage
   return { success: false, message: error }; // this format makes sense to match the apis format
}).then((data) =>
{
	// this is the actual data emitted by response.json() OR the data returned by catch
});

/* shorthand */
fetch('http://example.com/movies.json').then(res => res.json()).then(response => { console.log('Success:', response); });
fetch('http://example.com/movies.json').then(res => res.json()).catch(error => { console.error('Error:', error); return error; }).then(response_or_error => console.log(response_or_error));

fetch('http://example.com/movies.json').then(v=>v).catch(v=>v).then(data => { console.log(data); }); 

/* here is a way to construct the body data from a dom form automatically */
let body = {},
formData = new FormData(document.querySelector('form'));
formData.forEach((value, key) => { body[key] = value; });
body = JSON.stringify(body);

/* how to send manually a x-www-form-urlencoded with fetch */
let data = new URLSearchParams();
data.append('foo','bar');
data.append('bar','baz');
fetch(
  'https://tld.com/foo', {
    method: 'POST',
    body: data
  })
  .then(v=>v).catch(v=>v).then(data => { console.log(data); }); 

/* how to send an existing basic form with x-www-form-urlencoded with fetch */
let form = document.querySelector('form');
fetch(
  form.getAttribute('action'), {
    method: form.getAttribute('method'),
    body: new URLSearchParams(new FormData(form)), // be aware: only new FormData sets the header automatically to multipart; so we have to wrap it in URLSearchParams
    //headers: { 'Content-Type': 'application/x-www-form-urlencoded' } // you don't need this line because it gets automatically set because of URLSearchParams
  })
  .then(v=>v).catch(v=>v).then(data => { console.log(data); }); 

/* if you need text instead of json, do this */
... .then(v=>v.text()). ...
... .then((response) => { return response.text() }). ...