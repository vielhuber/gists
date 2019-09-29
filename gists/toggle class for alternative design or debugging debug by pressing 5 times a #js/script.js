let keypressACount = 0;
document.addEventListener('keypress', (e) =>
{
  if(e.which == 97 || e.keyCode == 97)
  {
    keypressACount++;
    if (keypressACount >= 5)
    {
      document.documentElement.classList.toggle('alternative');
      keypressACount = 0;
    }
  }
  else {
    keypressACount = 0;
  }
});