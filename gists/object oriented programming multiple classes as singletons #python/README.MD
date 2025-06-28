### /classes/__init__.py
```py
from .foo import Foo
from .bar import Bar

foo = Foo()
bar = Bar()

# this enables "import *"
__all__ = [
    "foo",
    "bar"
]
```

### /classes/foo.py
```py
class Foo:

    _instance = None

    def __new__(cls, *args, **kwargs):
        if cls._instance is None:
            cls._instance = super().__new__(cls)
        return cls._instance

    def __init__(self):
        if not hasattr(self, "_initialized"):
            self._initialized = True

    def test(self):
        print("foo")
```

### /classes/bar.py
```py
class Bar:

    _instance = None

    def __new__(cls, *args, **kwargs):
        if cls._instance is None:
            cls._instance = super().__new__(cls)
        return cls._instance

    def __init__(self):
        if not hasattr(self, "_initialized"):
            self._initialized = True

    def test(self):
        print("bar")
```

### /script.py
```py
from classes foo, bar
#from classes import *

class Test:

    def __init__(self):
        self.var1 = 42

    async def main(self):
        foo.test()
        bar.test()

if __name__ == "__main__":
  test = Test()
  test.main()
```
