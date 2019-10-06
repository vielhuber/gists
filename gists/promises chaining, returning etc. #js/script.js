/* variant1 */
function foo()
{
    return new Promise((resolve) =>
    {
        console.log(1);
        resolve();
    }).then(() =>
    {
        return new Promise((resolve) =>
        {
            console.log(2);
            resolve();
        });
    }).then(() =>
    {
        return new Promise((resolve) =>
        {
            console.log(3);
            resolve();
        });
    });
};
foo().then(() => { console.log(4); });
// 1 2 3 4


/* variant2 */
async function foo()
{
    await new Promise((resolve) => { console.log(1); resolve(); });
    await new Promise((resolve) => { console.log(2); resolve(); });    
    await new Promise((resolve) => { console.log(3); resolve(); });
}
foo().then(() => { console.log(4); });
// 1 2 3 4


/* variant3 */
function baz(n)
{
    return new Promise((resolve) =>
    {
        console.log(n);
        resolve();
    });
}
baz(1).then(() => { baz(2).then(() => { baz(3); }); }).then(() => { console.log(4); });