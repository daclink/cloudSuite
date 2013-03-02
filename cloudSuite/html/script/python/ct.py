from subprocess import call

class CT:

    def __init__(self,foo):
        self.foo = foo
        self.stuff = "why?!"

    def out(self):
        bar = "Foo is: " + self.foo
        return bar
    
    def in_thing(self,foo):
        self.foo = foo

    @staticmethod
    def sg():
        return "this is a static method yo"

    def intnl(self):
        self.out()

    def sag(self):
        return self.sg()

    def caller(self, cmd):
        return call([cmd])


def what():
    print "what what!"

