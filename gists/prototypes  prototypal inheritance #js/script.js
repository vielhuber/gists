// every object has a property called "prototype" where you can add methods and/or other properties to it
// when you create other objects from this object the newly created object will inherit those properties
// without cloning but with referencing


/* newer way */
const cat = {
	makeSound: function() {
		console.log(this.sound);
	}
}

const cat1 = Object.create(cat);
cat1.sound = 'WHOUUUUUU';
cat1.makeSound();

const cat2 = Object.create(cat);
cat2.sound = 'dfhdhjkfkjd';
cat2.makeSound();

// Object.create(cat) creates a new object and sets the prototype of this object to "cat"
console.log( cat.isPrototypeOf(cat2) );



/* old way */
function Cat(sound) {
	this.sound = sound;
}
Cat.prototype.makeSound = function() {
	console.log('I say: '+this.sound);
}
const cat3 = new Cat('kdfjhkjfdhdkhs');
cat3.makeSound();


