import random

# ...


class Example:

    staticVariable = "baz"

    def __init__(self):
        self.attr1 = "foo"
        self.attr2 = "bar"
        self.attr3 = "baz"

    def test1(self):
        print(self.attr1)
        self.attr1 = "foo42"
        print(self.attr1)
        self.test2("foo")

    def test2(self, str):
        print(str)

    def main(self):
        print("start!")
        self.test1()


example = Example()
example.main()
print(Example.staticVariable)
