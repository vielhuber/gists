// old
document.addEventListener('DOMContentLoaded', () =>
{
    let page = new Page();
});

// new
new Promise((resolve) =>
{
    if (document.readyState != 'loading') { resolve(); }
    else { document.addEventListener('DOMContentLoaded', () => { resolve(); }); }
}).then(() =>
{
    let page = new Page();
});