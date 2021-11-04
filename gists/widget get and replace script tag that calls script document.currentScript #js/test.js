let script = document.currentScript;
// in case the script is added dynamically, use fallback
if (script.getAttribute('data-foo') === null) {
    let scripts = document.getElementsByTagName('script');
    script = scripts[scripts.length - 1];
}

script.outerHTML = 'replace with magic';