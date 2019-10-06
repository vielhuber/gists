/* variant 1 */
export default class utils {
   static foo() { return 'foo'; }
   static bar() { return 'bar'; }
}
import utils from './utils';
utils.foo(); utils.bar(); // class call!

/* variant 2 */
function foo() { return 'foo'; }
function bar() { return 'bar'; }
export { foo, bar };
import { foo, bar } from './utils';
foo(); bar(); // direct call!
