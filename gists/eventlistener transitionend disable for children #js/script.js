document.querySelector('.foo').addEventListener('transitionend', e => {
  console.log('this fires also if transitions end for children of .foo!');
});

// method 1
document.querySelector('.foo').querySelectorAll('*').forEach(children__value => {
  children__value.addEventListener('transitionend', e => {
    event.stopPropagation();
  });
});

// method 2
document.querySelector('.foo').addEventListener('transitionend', e => {
  if (e.target !== e.currentTarget) {
    return;
  }
  console.log('this fires also if transitions end for children of .foo!');
});