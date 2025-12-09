/* fetch returns a promise which only fails (inside catch) on network error */
/* we want to combine all errors (also from the api) in a fetcher function */
function fetch(url, args) {
    if (args.cache === undefined) {
        args.cache = 'no-cache';
    }
    if (args.headers === undefined) {
        args.headers = { 'Content-Type': 'application/json' };
    }
    return new Promise(resolve => {
        fetch(url, args)
            .then(response => {
                let data = response.json(),
                    status = response.status;
                if (status == 200 || status == 304) {
                    return data;
                }
                return { success: false, message: status };
            })
            .catch(error => {
                return { success: false, message: error };
            })
            .then(response => {
                resolve(response);
            });
    });
}

async function main() {
    await fetch(url, args);
    await fetch(url, args);
    await fetch(url, args);
}

main();