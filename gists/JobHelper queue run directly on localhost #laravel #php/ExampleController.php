<?php
// app/Http/Controllers/ExampleController.php
namespace App\Http\Controllers;

use App\Helpers\JobHelper;

class ExampleController extends Controller
{

    /* ... */
  
    public function postExample()
    {
        JobHelper::queue('ExampleQueue', [
            'custom' => 'args'
        ]);      
        return Redirect::route('getExample')->with('success', 'Erledigt!');
    }

}
