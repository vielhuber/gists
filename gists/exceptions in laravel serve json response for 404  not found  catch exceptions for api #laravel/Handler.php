// app/Exceptions/Handler.php
use App;
/* ... */
public function render($request, Exception $exception)
{
  if (starts_with($request->path(), 'api') || $request->wantsJson()) {
    $message = __exception_message($exception);
    if (!App::environment('local')) {
      if (is_array($message) && array_key_exists('public_message', $message)) {
        $response = $message;
        $response = ['success' => false] + $response;
      } else {
        $response = [
          'success' => false,
          'message' => 'internal server error',
          'public_message' => 'Es ist ein Fehler aufgetreten'
        ];
      }
    } else {
      if (is_array($message) && array_key_exists('public_message', $message)) {
        $response = $message;
        $response = ['success' => false] + $response;
      } else {
        return parent::render($request, $exception); // let laravel handle the rest
      }
    }
    return response()->json($response, 404);
  }
  /* ... */
}
/* ... */