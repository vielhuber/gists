<?php
// chedck if password for current user is correct without authenticating
if( Hash::check('password', Auth::user()->password) ) {
  echo 'OK';
}

// change password
$user = User::findOrFail($user_id);
$user->password = Hash::make(Input::get('new_password'));
$user->save();