<?php
return [
	'db' => [
		//...
	],
    'template_security' => [
        'php_modifiers' => ['dirname'],
        'php_functions' => ['dirname', 'shell_exec', 'isset'],
    ]
];