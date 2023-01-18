// variant 1 (preservs errors)
let html = '<p>foo</p>';
let template = document.createElement('template');
html = html.trim();
template.innerHTML = html;
let dom = template.content.firstChild;

// varian 2 (keeps errors)
new DOMParser().parseFromString('<p>foo</p>', 'text/html');