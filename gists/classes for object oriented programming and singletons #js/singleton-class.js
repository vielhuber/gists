let instance = null;

export default class Example {
    constructor() {
      	/* this is called "the singleton pattern"
        if (!instance) {
            instance = this;
        }
        return instance;
    }

    set(val) {
      	this.val = val;
    }
  
  	get() {
      	return this.val;
    }
}
