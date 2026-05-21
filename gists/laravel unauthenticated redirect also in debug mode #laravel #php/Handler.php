<?php
// app/Exceptions/Handler.php
/* ... */
public function render($request, Exception $exception)
{
  /* redirect also in debug mode */
  if ($exception instanceof \Illuminate\Auth\AuthenticationException){
  	return $this->unauthenticated($request, $exception);
  }
  /* ... */
}
/* ... */