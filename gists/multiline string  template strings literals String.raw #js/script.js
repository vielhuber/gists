// today
var foo = 'This\
is\
a\
multiline\
string';

// ES6
var bar = `This
is
a
multiline
string`;

var baz = `This
is
a
multiline
string
with
a
variable
${new Date()}
inside.`;

// use String.raw when you want to convert regex patterns with backslashes
new RegExp(String.raw`\p{RI}\p{RI}`, 'gu')

// if else
var bazz = `This
is
conditional
${1==1?`foo`:`bar`}
and
thats
cool!`;

var cool = `<ul>
${['foo','bar','baz'].map((item) => `<li>${item}</li>`).join('')}
</ul>`;

var cooler = `<ul>
${Array(5).join(0).split(0).map((item, i) => `<li>${i}.</li>`).join('')}
</ul>`;

var cooler = `<ul>
${Array(5).join(0).split(0).map((item, i) => { i = i+42; return `<li>${i}.</li>` }).join('')}
</ul>`;