<?php
public function count($filename)
{
  if( !file_exists($filename) )
  {
    throw new \Exception('file does not exist');
  }
  $pages = exec('pdftk '.$filename.' dump_data | '.(( !stristr(PHP_OS, 'DAR') && stristr(PHP_OS, 'WIN') )?('findstr'):('grep')).' NumberOfPages');
  $pages = preg_replace('/[^0-9,.]/', '', $pages);
  $pages = intval($pages);
  return $pages;
}