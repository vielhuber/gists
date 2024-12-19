<?php
try {
	// code that may throw an exception or error
  	throw new \Exception('argh');
  	throw new \Error('argh');
} catch (\Throwable $t) {
	// executed only in php 7, will not match in php 5
} catch (\Exception $e) {
	// executed only in php 5, will not be reached in php 7
} finally {
    // always runs
}