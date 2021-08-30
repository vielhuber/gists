<?php
add_action( 'admin_bar_menu', function()
{
    if(!is_multisite())
    {
        return;
    }
    global $wp_admin_bar;    
    $blog_names = [];
    $sites = $wp_admin_bar->user->blogs;
    foreach($sites as $sites__key=>$sites__value)
    {
		/* if you also want to replace it with the url */
        if(1==1)
        {
            $sites[$sites__key]->blogname = $sites__value->domain;
            $blog_names[$sites__key] = $sites__value->domain;
        }
        else
        {
        	$blog_names[$site_id] = strtoupper($site->blogname);
        }
    }
    unset($blog_names[1]);
    asort($blog_names);
    $wp_admin_bar->user->blogs = [];
    // if you want to hide the main blog, disable this
    if(1==1) {
        $wp_admin_bar->user->blogs{1} = $sites[1];
    }
    foreach($blog_names as $blog_names__key=>$blog_names__value)
    {
        $wp_admin_bar->user->blogs{$blog_names__key} = $sites[$blog_names__key];
    }
}, 0 );