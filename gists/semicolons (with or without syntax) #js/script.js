// js has auto semicolon insertion

BEFORE
var x = 1
var y = 2
AFTER
var x = 1;
var y = 2;

BEFORE
x 
++ 
y
AFTER
x++;
y;

BEFORE
function foo() {
 return 
    42
}
AFTER
function foo() {
 return;
    42;
}

BEFORE
function foo() {
 return 
    42;
}
AFTER
function foo() {
 return;
    42;
}

}

// if you use code without semicolons and next line begins with (, use ";" before it!
var i = 1
(function() { alert(i); })() // error

var i = 1
;(function() { alert(i); })() // 1

