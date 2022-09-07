// best performance (but not recommended due to css BEM)
getElementById()

// good performance  (only returns the first entry)
querySelector()

// badest performance (has to search through all dom nodes
querySelectorAll()

/* example */
document.querySelectorAll('.list .list__items') // bad
document.querySelector('.list').querySelectorAll('.list__items') // good