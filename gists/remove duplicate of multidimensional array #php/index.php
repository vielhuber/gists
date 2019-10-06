$arr = [
  ['foo' => 'bar', 'bar' => 'baz'],
  ['moo' => 'hoo'],
  ['foo' => 'bar'],
  ['foo' => 'bar', 'bar' => 'baz']
];
$arr = array_map('unserialize', array_unique(array_map('serialize', $arr)));
echo '<pre>';print_r($arr);