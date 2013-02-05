#!/usr/bin/env python

import sys, time
from daemon import Daemon

class MyDaemon(Daemon):
    def run(self):
        foo = 0
        while foo < 10 :
            print "Woo"
            foo = foo + 1
            time.sleep(1)

if __name__ == "__main__":
    daemon = MyDaemon('/tmp/daemon-example.pid')
    if len(sys.argv) == 2:
        if 'start' == sys.argv[1]:
            daemon.start()
        elif 'stop' == sys.argv[1]:
            daemon.stop()
        elif 'restart' == sys.argv[1]:
            daemon.restart()
        else:
            print "Unknown command"
            sys.exit(2)
        sys.exit(0)
    else:
        print "Usage %s start|stop restart"
        sys.exit(2)

