// 32-bit
if (PHP_INT_SIZE == 4) {
	echo date('Y-m-d',strtotime('2040-01-10T16:41:07+01:00'));
}
// 64-bit
if (PHP_INT_SIZE == 8) {
	echo (new \DateTime('2040-01-10T16:41:07+01:00'))->format('Y-m-d');
}