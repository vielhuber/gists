<?php
function dateTimeLocal($datetime) {
	
	return
			date('Y-m-d', strtotime($datetime))
			.
			"T"
			.
			date('H:i', strtotime($datetime));

  }
}