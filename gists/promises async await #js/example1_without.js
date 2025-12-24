function getHamburger(server, defaultBurger)
{
  	if( server.hasBurgers().then((serverHasBurgers) =>
    {
      if(!serverHasBurgers)
      {
       	return defaultBurger; 
      }
      let burgersEaten = getNumberOfEatenBurgersToday();
      return server.getMaxNumberOfBurgersPerDay().then((maxBurgers) =>
      {
        if( burgersEaten < maxBurgers )
        {
            return server.loadBurger(); 
        }
        return defaultBurger;
      });
    });
}