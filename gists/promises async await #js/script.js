/* async await functions are asynchronious functions that ALWAYS return promises */
/* inside they can "await" for other promises */
/* those await lines run like synchronius lines */
function test1()
{
  return new Promise(resolve => {
    setTimeout(() => {
      resolve(1337);
    }, 2000);
  });
}                                    
function test2()
{
  return new Promise((resolve,reject) => {
    setTimeout(() => {
      resolve(1338);
    }, 2000);
  });
}
async function load()
{
 	let value1 = await test1();
  	let value2 = await test2().catch(error => console.log(error));
    let value3 = await test2().then(() => { }).catch(() => { }); // you even can then and catch!
  	return value1 + value2;
}
function init()
{
 	load().then((v) => { console.log(v); }); 
}
init();