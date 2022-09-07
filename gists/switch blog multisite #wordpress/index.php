// switch to specific wp site
switch_to_blog(1337);
// do something on the other site
...
// switch back
restore_current_blog();
// be aware: never use this (because weird things can happen)
switch_to_blog($original_blog_id);