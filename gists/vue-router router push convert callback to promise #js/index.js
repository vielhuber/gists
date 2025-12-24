router.push('...', () => { callback(); }, () => { callback(); });

new Promise(resolve => { router.push('...', () => { resolve(); }, () => { resolve(); }); }).then(() => { callback() });

async nav() { await new Promise(resolve => { router.push('...', () => { resolve(); }, () => { resolve(); }); }); }