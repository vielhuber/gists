fetch(
  'http://example.com/movies.json',
  {
    method: 'POST',
    body: JSON.stringify({ foo: 'bar' }),
    cache: 'no-cache',
    headers: {
       'Content-Type': 'application/json',
       //'X-Requested-With': 'XMLHttpRequest' // this should be set e.g. on laravel applications (otherwise it is not detected that this is a js call)
    }
  }
).then((response) =>
{
  // this is another promise which gets resolved in the second then
  // do something if you want with it
  // or simply return it
  // important: to check for status codes (like 404 or 500), check here if needed
  let data = response.json(),
      status = response.status,
      headers = Object.fromEntries(response.headers.entries()),
      specificHeader = response.headers.get('foo');
  // if you want to preserve thes status later, save it in a global variable (declared outside of fetch!)
  // fetchStatus = response.status;
  if (status == 200 || status == 304) {
    // we assume that the result of the promise "data" has the format { success: ???, message: ???, data: ??? }; if not, modify it (below in the second "then")
   	return data; 
  }
  return { success: false, message: status };
}).catch((error) => 
{
	// this does not fire on 404 or other status codes but on all js errors AND network outage
   return { success: false, message: error }; // this format makes sense to match the apis format
}).then((response) =>
{
	// this is the actual data emitted by response.json() OR the object returned by catch
  	console.log([ response.success, response.message, response.data ]);
});

/* shorthand */
fetch('http://example.com/movies.json').then(res => res.json()).then(response => { console.log('Success:', response); });
fetch('http://example.com/movies.json').then(res => res.json()).catch(error => { console.error('Error:', error); return error; }).then(response_or_error => console.log(response_or_error));

fetch('http://example.com/movies.json').then(v=>v).catch(v=>v).then(data => { console.log(data); });

/* pass object to GET request */
fetch('http://example.com/foo?' + (new URLSearchParams(Object.entries({'zip': '94036', 'location': 'Passau', 'street': 'Baumannstraße'}))))

/* add current client cookies to request (by default, fetch does NOT do this) */
fetch('http://example.com/movies.json', { method: 'GET', credentials: 'include' })

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

/* if you EXPECT html/text in the ressponse instead of json, do this */
... .then(v=>v.text()). ...
... .then((response) => { return response.text() }). ...