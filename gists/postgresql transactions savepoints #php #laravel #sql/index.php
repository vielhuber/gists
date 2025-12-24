<?php
// this is typical for a long controller that handles multiple actions.
// if one action fails, we rollback the entire changes happened before
// in postgresql transactions are handled a little bit differently like in mysql:
// if an error happens inside a transaction, all further queries are blocked and the following error is given:
// "In failed sql transaction: ERROR: current transaction is aborted, commands ignored until end of transaction block"
// we overcome this by using savepoints: after an action failed, we immediately rollback to the beginning. then we do the rest
// at the end we check if on minimum one error occured and rollback everything
// https://stackoverflow.com/questions/14009506/dont-rollback-on-errors-in-transactions-using-php-pdo-and-postgres
// https://stackoverflow.com/questions/22906844/laravel-using-try-catch-with-dbtransaction

public function postUser()
{
  // initialize
  DB::beginTransaction();
  DB::statement('SAVEPOINT savepoint;');
  $success = true;

  // bad query
  try { $foo = DB::table('phones')->insert(['area_code' => 123]); }
  catch (\PDOException $e) { $success = false; DB::statement('ROLLBACK TO SAVEPOINT savepoint;'); }

  // good query
  try { $foo = DB::table('phones')->insert(['number' => 1, 'type' => 'landline', 'member_id' => 1]); }
  catch (\PDOException $e) { $success = false; DB::statement('ROLLBACK TO SAVEPOINT savepoint;'); }

  // finalize
  if( $success === true ) { DB::commit(); }
  else { DB::rollback(); }  
}

// another solution (this has the disadvantage that you can NOT catch further error messages)
DB::beginTransaction();
try
{
    DB::insert(...);
    DB::insert(...);
    DB::insert(...);
    DB::commit();
}
catch (\Exception $e)
{
    DB::rollback();
}