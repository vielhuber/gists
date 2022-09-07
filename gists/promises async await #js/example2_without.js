function mailUsers()
{
 	return db.query('SELECT id FROM users').then((users) =>
    {
     	return waitForEach(
          ((user) => processUser(user.id)),
          users
        )
    });  	
}

function waitForEach( processFunction, [head, ...tail] )
{
 	if( !head )
    {
    	return Promise.resolve();  
    }
  	return processFunction(head).then(() => { return waitForEach(processFunction, tail); });
}