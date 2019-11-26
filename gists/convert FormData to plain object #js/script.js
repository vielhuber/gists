// warning: this does not work recursively with foo[bar] fields
let formData = new FormData(document.querySelector('form'));

// option 1
let obj = {};
formData.forEach((value, key) => { obj[key] = value; });

// option 2 (inline)
Array.from(formData.entries()).reduce((m, [ key, value ]) => Object.assign(m, { [key]: value }), {});