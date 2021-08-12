<?php
// app/Exceptions/Handler.php
class Handler extends ExceptionHandler
{
  // add this to hide a variety of errors (like user authentication)
  protected $dontReport = [
      \Illuminate\Auth\AuthenticationException::class,
      \Illuminate\Auth\Access\AuthorizationException::class,
      \Symfony\Component\HttpKernel\Exception\HttpException::class,
      \Illuminate\Database\Eloquent\ModelNotFoundException::class,
      \Illuminate\Session\TokenMismatchException::class,
      \Illuminate\Validation\ValidationException::class,
      \League\OAuth2\Server\Exception\OAuthServerException::class,
      \Laravel\Passport\Exceptions\OAuthServerException::class
  ];

  public function report(Throwable $exception)
  {
      // sometimes report() gets called from cli and dontReport does not get respected
      if (!$this->shouldReport($exception)) { return; }
      \Log::error( $exception->getMessage() . "\t" . $exception->getMessage() . "\t" . $exception->getFile() . "\t" . $exception->getLine() . "\t" . get_class($exception) );
      //parent::report($exception);
  }
}