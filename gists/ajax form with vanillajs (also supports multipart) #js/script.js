document.addEventListener('DOMContentLoaded', () => {
  document.querySelector('form').addEventListener('submit', (e) => {
    e.preventDefault();
    let form = e.target,
        data = new FormData(form),
        request = new XMLHttpRequest();
    request.onreadystatechange = () => {
        if( request.readyState <= 3 ) {
          return;
        }
      	if( request.status == 200 ) {
          console.log(JSON.parse(request.responseText));
          form.reset();
        }
        else {
          console.log(JSON.parse(request.responseText));
        }       
    }
    request.open(form.method, form.action);
    request.send(data);
  });
})