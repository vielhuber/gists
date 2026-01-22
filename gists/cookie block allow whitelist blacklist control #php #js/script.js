const whitelist = ['_gid'],
    cookieDesc = Object.getOwnPropertyDescriptor(Document.prototype, 'cookie');
if (cookieDesc && cookieDesc.configurable) {
    Object.defineProperty(document, 'cookie', {
        get: () => {
            return cookieDesc.get.call(document);
        },
        set: val => {
            let accept = false;
            whitelist.forEach(whitelist__value => {
                if (val.indexOf(whitelist__value + '=') === 0) {
                    accept = true;
                }
            });
            if (accept === true) {
                cookieDesc.set.call(document, val);
            }
        }
    });
}
