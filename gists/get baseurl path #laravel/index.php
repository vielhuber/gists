<?php
// public base url
url('/')
// public assets url
asset('assets/arrow.svg')
  
// current url without queries
url()->current()

// current url with queries
url()->full()

  
// public url to named route
route('named.route', ['with_argument' => 1]);

// base path (absolute, not public)
base_path()
base_path('specific/file.txt')
public_path()
public_path('specific/file.txt')
storage_path()
storage_path('specific/file.txt')
resource_path()
resource_path('assets/file.txt')
  