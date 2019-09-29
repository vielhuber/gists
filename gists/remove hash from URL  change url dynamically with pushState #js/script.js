if (history.pushState) {
  window.history.replaceState({}, '', (window.location.protocol+"//"+window.location.hostname+window.location.pathname) );
}

if (history.pushState) {
  window.history.replaceState({}, '', ('https://tld.com/new') );
}