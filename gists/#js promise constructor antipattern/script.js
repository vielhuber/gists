// https://stackoverflow.com/questions/23803743/what-is-the-explicit-promise-construction-antipattern-and-how-do-i-avoid-it

// bad
function_name()
{
    return new Promise((resolve,reject) => {
       // do some async task that returns a promise
       someAsyncTask().then((result) =>
       {
         	// modify the result if needed
         	result++;
         	resolve(result);
       }).catch((error) =>
       {
         console.log(error);
         reject();
       }); 
    });
}

// good
function_name()
{
    return someAsyncTask().then((result) =>
    {
      result++;
      return result;
    }).catch((error) =>
    {
      console.log(error);
    });
}