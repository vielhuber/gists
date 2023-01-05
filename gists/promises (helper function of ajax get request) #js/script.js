/*
promises are a way to trigger events based on async operations
*/

/* example 1 */
var promise = new Promise(function(resolve, reject) {
	// do something, possibly async
	// ...
	// fulfill promise
	resolve("stuff worked!");
	// reject promise
	reject(Error("it broke"));
});
promise.then(function(result) {
	console.log(result);
}.catch(function (error) {
    console.log(error.message);
 });

/* example 2 */
var promise1 = new Promise(function(resolve, reject) { resolve("1"); });
var promise2 = new Promise(function(resolve, reject) { resolve("2"); });
var promise3 = new Promise(function(resolve, reject) { reject("3"); });
Promise.all([promise1, promise2, promise3]).then(function(result) {
	console.log(result); // array of resolves in the same order as arguments
}.catch(function (error) {
    console.log(error.message);
});

/* example 3 (helper function for ajax get request) */
function get(url) {
  return new Promise(function(resolve, reject) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url);
    xhr.onload = function() {
      if (xhr.status == 200) {
        resolve(xhr.response);
      }
      else {
        reject(Error(xhr.statusText));
      }
    };
    xhr.onerror = function() {
      reject(Error("Network Error"));
    };
    xhr.send();
  });
}
get('https://httpbin.org/get').then(function(response) {
  console.log("Success!", response);
}.catch(function (error) {
    console.log(error.message);
});


/*
notes
- promises are often used when you want to track events that happen asynchroniously 
- jquery deferreds are different, don't mix this up!
- observables are again another thing and a step further (for any type of reactive programming)
- concept in pseudo language:
	promiseOfObject.callThisIfSomethingHasFinished(function() {

	}).orIfFailedCallThis(function() {

	});

	whenAllTheseHaveFinished([promiseOfObject1, promiseOfObject2]).callThis(function() {

	}).orIfSomeFailedCallThis(function() {

	});
*/