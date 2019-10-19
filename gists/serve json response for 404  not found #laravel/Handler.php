// app/Exceptions/Handler.php
/* ... */
public function render($request, Exception $exception)
{
  if (starts_with($request->path(), 'api') || $request->wantsJson()) {
    return response()->json(['message' => 'not found'], 404);
  }
  /* ... */
}
/* ... */