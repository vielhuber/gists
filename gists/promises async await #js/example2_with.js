async function mailUsers()
{
 	let users = await db.query('SELECT id FROM users');
  	for( let users__value of users )
    {
     	await mailUser(users__value.id); 
    }
}