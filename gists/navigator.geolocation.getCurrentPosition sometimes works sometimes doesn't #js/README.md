- https://stackoverflow.com/questions/3397585/navigator-geolocation-getcurrentposition-sometimes-works-sometimes-doesnt

### before
```js
navigator.geolocation.getCurrentPosition((position) => {
  let val = results[0].address_components[2].long_name + ', ' + results[0].address_components[3].long_name;
  doSthWithVal(val);      
}, (error) => { });
```

### after
```js
if(localStorage.getItem('getCurrentPosition') !== null) {
  doSthWithVal(localStorage.getItem('getCurrentPosition'));
}
else {
  navigator.geolocation.getCurrentPosition((position) => {
      let val = results[0].address_components[2].long_name + ', ' + results[0].address_components[3].long_name;
      localStorage.setItem('getCurrentPosition',val);
      doSthWithVal(val);      
  }, (error) => { });
}
```