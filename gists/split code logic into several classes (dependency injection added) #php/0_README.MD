### dependency injection

- method: inject all classes in the constructor, on which the class depends on
- good for testing and reducing complexity
- for instantiating objects, you can use containers like PHP-DI (http://php-di.org/doc/understanding-di.html)

### solve circular references

- recommended: extract a third class that both classes depend on
- perhaps: refactor your code
- perhaps: combine those circular classes
- perhaps: use setter injection (https://codeinphp.github.io/post/dependency-injection-in-php/)