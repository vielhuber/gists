## 1: CLEAN CODE

- The Boy Scout Rule: Leave the campground cleaner than you found it ("always refactor a little bit every time you work on your code")

## 2: MEANINGFUL NAMES

- Use intention-revealing names ("elapsedTimeInDays" vs. "d")
- Use pronounceable names ("generationTimestamp" vs "genymdhms")
- Use searchable names ("realDaysPerDay" vs "d")
- Be consistent (always use one of fetch/retrieve/get in different classes)
- Don't add obsolete prefixes (e.g. don't use "GSTzip", "GSTlocation", "GSTstreet", "GSTnumber" inside a class "GST")
- Classes should be nouns ("Customer", "Account")
- Functions should use verbs ("deletePage") or should be prefixed with set/get ("getName")

## 3: FUNCTIONS

- Should not be longer than 5 lines of code
- Should always do one _main_ thing (you can describe that "thing" in one meaningful sentence)
- Should always have one level of abstraction
- Classes always should follow the "Single-Responsibility-Principle": Class should only one thing
- Should follow the "Open-Closed-Principle": Modules should be open for extensions and closed for modifications
- Avoid functions with side effects: E.g. registration that (unexpectetly) sets automatically sessions/cookies
- Don't use output arguments (instead of appendFooter(html) use html.appendFooter())
- Stepdown Rule: Programs should always be readable from TOP TO BOTTOM (functions used are always declared after and not before)
- Function arguments: 0 (niladic, best), 1 (monoadic, OK), 2 (dyadic, OK), 3 or more (polyadic, should always be avoided)
- Do not use boolean/flag arguments (the function then does more than one thing!)
- Extract try/catch structures outside of functions
- "DRY": Don't Repeat Yourself: Avoid duplication of logic/code and make functions with common behaviour
- Structured Programming: Every function should have one entry and one exit (one return, no break/continue/goto statements); only makes sense in big sized functions (which should also be avoided)
- Code is always bad at the beginning: Refactoring always needs to be done afterwards

## 4: COMMENTS

- Always try to avoid comments and express yourself in code
- Legal comments: Copyright, regex explanations, explanations of unobvious code structures, todo, warnings
- All other comments should be deleted (javadoc headers, closing brace comments, commented out code, ...)

## 5: FORMATTING

- Avoid files that have more than 500 lines of code (recommendation: 200 lines)
- The Newspaper Metaphor: Top (high level concepts), bottom (detailled implementations)
- Insert blank lines between functions to increase readability
- Variables, methods etc. that are connected should be in neighbourhood
- A function that is called should be below a function that does the calling
- Set a horizontal limit of 80-120 characters
- Insert blank characters between math equations and function arguments to increase readability
- Avoid aligned argument declarations

## 6: OBJECTS AND DATA STRUCTURES

- Avoid manipulating directly public variables
- Create abstract interfaces so that one can manipulate the essence of the data without having to know its implementation
- Don't blindly add getters and setters
- Objects hide their data behind abstractions and expose functions that operate on that data
   - Easy to add new kinds of objects
   - Hard to add new behaviours to existing objects
- Data structures expose their data and have no meaningful functions
   - Easy to add new behaviours to existing data structures
   - Hard to add new kinds of data structures
- Both ways have advantages/disadvantages, so choose dependent on your situation
- The law of Demeter: Object should only communicate with other objects in their neighbourhood
- Avoid "hybrids" (half object, half data structure) with functions and public variables

## 7: ERROR HANDLING

- Naive approach without exceptions is dangerous: It is easy to forget setting checks in if statements
- Always use try/catch blocks and throw exceptions when possible
- Provide context inside your exception messages
- Combine exceptions inside a wrapper class to prevent duplicated code
- Don't return null in the case of errors - throw an exception or return a special case object

## 8: BOUNDARIES

- If you use third party libraries: Do not use/pass around raw objects (e.g. Map) with full functionality (e.g. if you don't need to clear() the map in any class)
- Instead use special class that only uses the Map object under the hood
- For third party libraries write "learning tests" to experiment and play with the API (in those tests we call the API as we expect it to use it in our application) 
- If you use an obscure API, write an abstraction class that works like you wish it worked (and does all the stuff under the hood)
- Boundaries should be clear and we should avoid letting our code know too much about third party libraries

## 9: UNIT TESTS

- Tests and production code are always written together
- This is important, because the production code is designed differently when you write it before the test code instead of after
- Tests should have the same code quality than production code
- With unit tests, you loose the fear to make changes
- Tests should be easy to read and understand
- Guideline: One Assert per test (this is not strictly needed, but recommended)
- Better rule: One concept per test (don't test completely different things in one common test)
- Three laws of TDD (test driven development):
   - Always write a (failing) test first, then production code
   - Keep tests as simple as possible (that they fail)
   - Keep production code as simple as possible (that it passes)
- Five rules (F.I.R.S.T.):
   - Fast: Tests must run quickly
   - Independent: Tests should not depend on other tests to run
   - Repeatable: Tests should work in every environment
   - Self-validating: Tests should have a boolean assert, not a comparison between big txt files
   - Timely: Tests must be written together with production code

## 10: CLASSES

- Order: Variables (public static, private static, public, private); Functions (public, then all private functions called by the public functions)
- Classes should be small in terms of responsibilities (avoid "God classes" with e.g. 50 public methods)
- The name of a class should describe what responsibilities it fulfills
- The Single Responsibility Principle (SRP): Class should have only one reason to change
- If a class has more than one responsibility, it should be divided in multiple classes
- Build a system with many small classes, not a few large ones
- Build classes where methods are cohesive (they are highly connected and manipulate the same variables)
- When classes lose cohesion, split them (move some functions out that manipulte common data)
- Example: A "Sql" class with select/create/update/delete might be too big. Create subclasses "SelectSql", "CreateSql", "UpdateSql" and "DeleteSql"

## 11: SYSTEMS

- Software should separate the startup process from the runtime logic
- That means: Don't do things like getService() { if( service === null ) { service = createService(); } return service; }
- One common place for the startup process is the "main" method in Java/C
- Another way is to build "Factories", where objects are created
- Dependency Injection: An object should not take responsibility for instantiating dependencies itself; It gets those dependencies directly passed via init function arguments
- When scaling up software, only those systems can grow, that separates its concerns effectively
- That means one can start a software project with a simple but nicely decoupled architecture

## 12: EMERGENCE

- 4 Rules of simple design
  - Runs all the tests
    - Try to get 100% test coverage
    - Basic rule for all further rules
    - With tests you can refactor your code
  - Contanins no duplication
    - Try to remove any duplication that is present
  - Expresses the intent of the programmer
    - Choose good names
    - Keep functions small
  - Minimizes the number of classes and methods
    - This is not the most important rule
  
## 13: CONCURRENCY

- Concurrency does not always improve performance
- Design changes when writing concurrent programs
- Concurrency produces overhead and is complex
- Concurrency bugs are hard to trace
- Keep your concurrency-related code separate from other code
- Limit the access of any data that may be shared between concurrent functions
- Follow the Single Responsibility Rule

## 14: SUCCESSIVE REFINEMENT

- Author did not simply write the program from the beginning to the end in its final form
- To write clean code, you must first write dirty code and then clean it
- Don't move to the next task, when your program starts working; Instead start cleaning!
- Think about enhancements to the codebase: Will your code then get ugly? Prevent that with having a clean struture
- Tipp: Separate exception/error logic from the main classes, if they get too big
- Bad code is very expensive: Always clean asap!

## 15: JUNIT INTERNALS

- Prevent using prefixes (like "f") in variable/function/class names
- Negatives are harder to understand than positives: Reorder if statements
- Often refactoring leads to another decision that leads to the undoing of the first (this is no problem!)

## 16: REFACTORING SERIALDATE

- First, complete test suite for full code coverage
- Create an Abstract Factory for creating dates in another class
- Remove attribute prefixes like "final" that only add clutter to the code and don't provide any benefit
- Carefully rename all names (also the main class), reconsider every naming

## 17: SMELLS AND HEURISTICS

- Comments
   - Inappropriate information, obsolete comments, redundant comments, poorly written comments, commented-out code
- Environment
   - Build/test requires more than 1 command
- Functions
   - Too many arguments (no argument is best, 3 is worse)
   - Flag boolean arguments (what does someFunction(false) do other than someFunction(true)?)
   - Dead functions, that are never called
- General
   - Feature envy: Methods of a class should be interesting only inside that class, not in other classes
   - Non static functions should be favoured over static functions
   - Replace special numbers with named constants
   - Combine conditionals into functions
   - Avoid negative conditionals