<?php   
use Illuminate\Support\Facades\Mail;

public function send(Request $request)
{
  $data = [
      'subject' => 'Neue Kontaktanfrage',
      'message' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.',
      'from_email' => 'david@vielhuber.de',
      'from_name' => 'David Vielhuber',
      'to_email' => 'david@vielhuber.de',
      'to_name' => 'David Vielhuber',
      'reply_email' => 'david@vielhuber.de',
      'reply_name' => 'David Vielhuber',
      'attachment_filename' => 'path/to/file.pdf',
      'attachment_filename_public' => 'YourFile.pdf',
      'attachment_mime' => 'application/pdf'
  ];
  try
  {
    // text only
    Mail::raw($data['message'], function($message) use ($data)
    {
      $message->from($data['from_email'], $data['from_name']);
      $message->to($data['to_email'], $data['to_name']);
      $message->replyTo($data['reply_email'], $data['reply_name']);
      $message->subject($data['subject']);
      $message->attach($data['attachment_filename'], ['as' => $data['attachment_filename_public'], 'mime' => $data['attachment_mime']]);
    });
    
    // html
    Mail::send([], [], function($message) use ($data) {
    {
      $message->from($data['from_email'], $data['from_name']);
      $message->to($data['to_email'], $data['to_name']);
      $message->replyTo($data['reply_email'], $data['reply_name']);
      $message->subject($data['subject']);
      $message->setBody($data['message'], 'text/html');
      $message->attach($data['attachment_filename'], ['as' => $data['attachment_filename_public'], 'mime' => $data['attachment_mime']]);
    });
    
    return response()->json(['success' => true], 200);
  }
  catch(\Exception $e)
  {
    return response()->json([
      'success' => false,
      'message' => 'internal server error',
      'public_message' => 'email sending failed'
    ], 500);
  }
}