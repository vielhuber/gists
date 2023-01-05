<?php
$validator = Validator::make(Input::all(), [
    'field1' => 'required|max:255',
    'field2' => 'required|email|max:255|unique:users,email,'.$user_id
]);
if ($validator->fails()) {
    return Redirect::route('getRoute',$user_id)->withErrors($validator)->withInput();
}