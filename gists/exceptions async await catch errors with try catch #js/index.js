function test1()
{
  return new Promise((resolve, reject) => {
      throw 'foo';
  });
}
async function foo()
{
    try
    {
      await test1();
      console.log('success');
    }
    catch(e)
    {
    	console.error(e);
    }
}