// app/Exceptions/Handler.php
public function report(Throwable $exception)
{
  //parent::report($exception);
  \Log::error( $exception->getMessage() . "\t" . $exception->getMessage() . "\t" . $exception->getFile() . "\t" . $exception->getLine() );
}