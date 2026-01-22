document.querySelector('.button').addEventListener('click', (e) =>
{
  let answer = prompt('Bitte geben Sie zur Bestätigung REMOVE ein!');
  if (answer !== 'REMOVE') {
      e.preventDefault();
  }
});