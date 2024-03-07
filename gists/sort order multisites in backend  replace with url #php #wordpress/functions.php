<?php
add_action(
    'admin_bar_menu',
    function () {
        if (!is_multisite()) {
            return;
        }
        global $wp_admin_bar;

        // replace name
        foreach ($wp_admin_bar->user->blogs as $blogs__key => $blogs__value) {
            // domain
            if (1 == 1) {
                $wp_admin_bar->user->blogs[$blogs__key]->blogname = $blogs__value->domain;
            }
            // domain + path
            if (1 == 0) {
                $wp_admin_bar->user->blogs[$blogs__key]->blogname = trim($blogs__value->domain.$blogs__value->path,'/');
            }
            // uppercase
            if (1 == 0) {
                $wp_admin_bar->user->blogs[$blogs__key]->blogname = mb_strtoupper($blogs__value->blogname);
            }
        }

        // sort
        usort($wp_admin_bar->user->blogs, function ($a, $b) {
            // primary first
            if ($a->userblog_id == '1' && $b->userblog_id != '1') {
                return -1;
            }
            if ($a->userblog_id != '1' && $b->userblog_id == '1') {
                return 1;
            }
            // manual sort
          	if(1 == 0) {
              foreach (['foo','bar','baz'] as $manual_sort__value) {
                  if (
                      stripos($a->blogname, $manual_sort__value) !== false &&
                      stripos($b->blogname, $manual_sort__value) === false
                  ) {
                      return -1;
                  }
                  if (
                      stripos($a->blogname, $manual_sort__value) === false &&
                      stripos($b->blogname, $manual_sort__value) !== false
                  ) {
                      return 1;
                  }
              }
            }
            // by name
            return strcasecmp($a->blogname, $b->blogname);
        });

        // mark as active
        foreach ($wp_admin_bar->user->blogs as $blogs__key => $blogs__value) {
            if (is_network_admin() === false && get_current_blog_id() == $blogs__value->userblog_id) {
                $wp_admin_bar->user->blogs[$blogs__key]->blogname =
                    '<strong style="text-decoration:underline;">' . $blogs__value->blogname . '</strong>';
            }
        }
    },
    0
);