function asyncExampleResolve()
{
  return new Promise((resolve, reject) => { resolve(); });
}
function asyncExampleReject()
{
  return new Promise((resolve, reject) => { reject(); });
}


/* currently best way to do it */
async function bar()
{
  	try {
      await asyncExampleReject(1);
      await asyncExampleResolve(2);
      await asyncExampleResolve(3);
      // if you want to return an empty resolved promise, simply omit everything
      return 'general ok'; // optional (if not provided, async also returns an empty resolved promise)
      return Promise.resolve(); // this is also possible, but as said not needed
    }
    catch
    {
		return Promise.reject('general error'); // mandatory (if we would use return 'general error', async would return it as a resolved promise; if we wouldn't return anything, async would return an empty resolved promise)
  	}
}
bar().then((e) => { console.log(e === 'general ok'); }).catch((e) => { console.log(e === 'general error'); });




/* without try/catch blocks */
async function bar()
{
	await asyncExampleReject(1);
  	await asyncExampleResolve(2);
  	await asyncExampleResolve(3);
}
bar().then(() => { console.log('no output if all 3 examples succeeded'); }).catch((e) => { console.log('e is the output of the first failing promise'); });

/* without try/catch blocks */
async function bar()
{
	await asyncExampleReject(1);
  	await asyncExampleResolve(2);
  	await asyncExampleResolve(3);
    return Promise.resolve('general ok');
}
bar().then(() => { console.log(e === 'general ok'); }).catch((e) => { console.log('e is the output of the first failing promise'); });

/* this is also possible (now you can pass also success data!) */
function bar()
{
  	return new Promise(async (resolve, reject) => {
      try {
          await asyncExampleReject(1);
          await asyncExampleResolve(2);
          await asyncExampleResolve(3);
          resolve('everything ok');
      }
      catch
      {
          reject('general error');
      }
    });
}
bar().then((e) => { console.log(e === 'general ok'); }).catch((e) => { console.log(e === 'general error'); });

/* with this pattern, it is also possible to neglect await (it is optional) */
function bar()
{
  	return new Promise(async (resolve, reject) => {
      try {
          resolve('general ok');
      }
      catch
      {
          reject('general error');
      }
    });
}
bar().then((e) => { console.log(e === 'general ok'); }).catch((e) => { console.log(e === 'general error'); });