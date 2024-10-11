let keypressACount = 0;
document.addEventListener('keypress', (e) =>
{
  if(e.key === 'a')
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