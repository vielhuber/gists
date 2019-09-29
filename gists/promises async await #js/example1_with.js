async function getHamburger(server, defaultBurger)
{
    if(!await server.hasBurgers())
    {
     	return defaultBurger; 
    }
  	let burgersEaten = getNumberOfEatenBurgersToday();
  	let maxBurgers = await server.getMaxNumberOfBurgersPerDay();
    if( burgersEaten < maxBurgers )
    {
     	return server.loadBurger(); 
    }
  	return defaultBurger;
}