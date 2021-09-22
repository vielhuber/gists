<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class TestController extends Controller
{
    public function create(Request $request)
    {
        return $this->nestedFunction1();
    }  
  	private function nestedFunction1()
    {
      	return $this->nestedFunction2();
    }  
  	private function nestedFunction2()
    {
        return response()->json(
            [
                'success' => false,
                'message' => 'fail',
                'public_message' => 'Es ist ein Fehler aufgetreten'
            ],
            500
        );
    }
}
