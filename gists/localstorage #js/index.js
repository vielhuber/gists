localStorage.setItem('foo','bar');
localStorage.getItem('foo');
localStorage.removeItem('foo');
if(localStorage.getItem('foo') !== null) {
  // item exists
}

// store objects
localStorage.setItem('foo', JSON.stringify({'foo': 'bar'}));
try { JSON.parse(localStorage.getItem('foo')) } catch (e) { }