<?php
/* ... */
use Illuminate\Database\Eloquent\Model;
/* ... */

class AppServiceProvider extends ServiceProvider
{
    /* ... */
    public function boot()
    {
        /* ... */
        // disable mass assignment protection
        Model::unguard();
    }
}
