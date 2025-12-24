<?php
// App/Traits/ExampleModel.php
namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Traits\isActive;
class ExampleModel extends Model
{
    use isActive;	
  	/* ... */
}
