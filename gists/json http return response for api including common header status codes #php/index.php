<?php
/*
200: OK
201: Created (when a object is successfully created)
301: Moved permanently
302: Moved temporarily
304: Not modified (cached) (this is like 200!)
400: Bad request (malformed request syntax, invalid request message parameters, missing required fields, ...)
401: Unauthorized (Auth missing)
403: Forbidden (Auth is available but not sufficient)
404: Not found
405: Method not allowed (GET/POST, ...)
408: Timeout
410: Gone (forever, 404 means could perhaps appear again, sometimes better for seo)
500: Internal server error (some server side exception is thrown)
*/

function response($data, $code = 200) {
  http_response_code($code);
  header('Content-Type: application/json');
  echo json_encode($data);
  die();
}

response(
  [
    'success' => true,
    'message' => 'successfully created object',
    'public_message' => 'Object erfolgreich angelegt!',
    'data' => [
      'id' => 42,
      'foo' => 'bar'
    ]
  ]
);

response(
  [
    'success' => false,
    'message' => 'username or password missing',
    'public_message' => 'Benutzername oder Passwort fehlt!'
  ],
  401
);

// response with data (variant 1)
response(
  [
    'foo' => 'bar',
    'bar' => 'baz',
  ]
);
  
// response with data (variant 2)
response(
  [
    'success' => true,
    'data' => [
      'foo' => 'bar',
      'bar' => 'baz'
    ]
  ]
);