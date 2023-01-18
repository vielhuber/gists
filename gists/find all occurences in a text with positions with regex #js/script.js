// example: find all values between double brackets
let regex = /\(\((.+?)\)\)/g,
	match = null;
while ((match = regex.exec(text)) !== null)
{
	console.log('match found at ' + match.index);
}