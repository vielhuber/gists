<!DOCTYPE html><html lang="de"><head><title>.</title></head><body>
<?php

$data = [
	['lvl' => 0, 'lbl' => 'A'],
	['lvl' => 1, 'lbl' => 'B'],
	['lvl' => 2, 'lbl' => 'C'],
	['lvl' => 2, 'lbl' => 'D'],
	['lvl' => 1, 'lbl' => 'E'],
	['lvl' => 2, 'lbl' => 'F'],
	['lvl' => 0, 'lbl' => 'G'],
	['lvl' => 1, 'lbl' => 'G'],
	['lvl' => 2, 'lbl' => 'H'],
	['lvl' => 3, 'lbl' => 'I'],
	['lvl' => 4, 'lbl' => 'J'],
	['lvl' => 5, 'lbl' => 'K'],
	['lvl' => 6, 'lbl' => 'L'],
	['lvl' => 7, 'lbl' => 'M'],
	['lvl' => 8, 'lbl' => 'N'],
	['lvl' => 9, 'lbl' => 'O'],
	['lvl' => 2, 'lbl' => 'P'],
];

$opened_tags = [];
$with_indent = true;

echo '<ul class="OUTER">'.PHP_EOL;
foreach($data as $data__key=>$data__value) {
	$next_is_lower = isset($data[$data__key+1]) && $data[$data__key+1]['lvl'] > $data__value['lvl'];
	$next_lvl = !isset($data[$data__key+1]) ? 0 : $data[$data__key+1]['lvl'];

	if( $with_indent ) { echo str_repeat(' ', ($data__value['lvl']+1)*4); }
	echo '<li class="NORMAL_INNER">'.PHP_EOL;
	$opened_tags[] = ['</li><!-- /NORMAL_INNER -->', $data__value['lvl']];

	if( $with_indent ) { echo str_repeat(' ', ($data__value['lvl']+1)*4+2); }
	echo $data__value['lbl'].PHP_EOL;

	if( $next_is_lower ) {
		if( $with_indent ) { echo str_repeat(' ', ($data__value['lvl']+1)*4+2); }
		echo '<ul class="NESTED_UL">'.PHP_EOL;
		$opened_tags[] = ['</ul><!-- /NESTED_UL -->', $data__value['lvl']];
	}

	else {
		$opened_tags = array_reverse($opened_tags);
		while(!empty($opened_tags) && $opened_tags[0][1] >= $next_lvl) {
			if( $with_indent ) { echo str_repeat(' ', ($opened_tags[0][1]+1)*4+($opened_tags[0][0]==='</ul>'?2:0)); }
			echo $opened_tags[0][0].PHP_EOL;
			unset($opened_tags[0]);
			$opened_tags = array_values($opened_tags);
		}
		$opened_tags = array_reverse($opened_tags);
	}
}
echo '</ul><!-- /OUTER -->'.PHP_EOL;

?>
</body></html>