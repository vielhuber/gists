/* fetch returns a promise which only fails (inside catch) on network error */
/* we want to combine all errors (also from the api) in a fetcher function */
function fetcher()
{
    return new Promise((resolve, reject) => {
        fetch('https://httpbin.org/html')
            .then((result) => {
                return result.json();
            })
            .catch((error) => {
                return { success: false, message: error };
            })
            .then((data) => {
                if (data === undefined || data === '' || data === null || typeof data !== 'object' || data.success === false) {
                    reject(data);
                } else {
                    resolve(data);
                }
            });
    });
}

async function main()
{
   try {
       await fetcher();
       await fetcher();
       await fetcher();
   }
   catch(e)
   {
       console.log('error');
   }
}

main();