
class CT:

    def __init__(self,foo):
        self.foo = foo

    def out(self):
        bar = "Foo is: " + self.foo
        return bar
    def in_thing(self,foo):
        self.foo = foo
    @staticmethod
    def sg():
        return "this is a static method yo"

