$0.style.backgroundColor = 'blue !important'; // does not work

$0.style.setProperty('background-color', 'blue', 'important'); // works (be aware: $0.style.backgroundColor still returns 'blue')