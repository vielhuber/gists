<?php
if (function_exists('opcache_get_status')) {
  $status = opcache_get_status();
  var_dump($status);
  echo 'Cache Hit Rate: ' . $status['opcache_statistics']['opcache_hit_rate'] . '%';
}