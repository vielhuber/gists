<?php
// long fix: hoster should add updated ca bundles
// quick fix
add_filter( 'https_ssl_verify', '__return_false' );