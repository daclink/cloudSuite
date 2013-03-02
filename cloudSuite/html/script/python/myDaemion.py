#!/usr/bin/env python
import boto, sys, time
from elementtree.ElementTree import Element, SubElement, dump, ElementTree, parse, fromstring
from elementtree.ElementTree import Comment
from ElementTree_pretty import prettify
from subprocess import check_output, call
from daemon import Daemon

class MyDaemon(Daemon):
    def run(self):
        foo = 0
        while 1:
            bucket = "cloudsuite.labs"

            c  = boto.connect_s3()
            rs = c.get_all_buckets()
            b  = c.get_bucket(bucket)

            rs = b.get_all_keys()

            #print rs

            for key in rs:
                labname = key.name
                bar = key.get_contents_as_string()
                foo = fromstring(bar)
                #dump(foo)
                owner = foo.find('owner').text
                uname = owner.lower()
                for module in foo.findall('module'):
                   method = module.find('method').text
                   xmlString = module.find('xmlrpcString').text
                   print "method", method
                   print "xmlString", xmlString
                   print sys.argv[0]
                   exe =  "python " + method + " -u " + uname + " --labname=" + labname, xmlString
                   res = call(exe,shell=True)
                   runtime = time.asctime(time.localtime(time.time()) )
                   try:
                    logfile = open('cloudsuiteg.log','a')
                    try:
                        logfile.write(str(exe) + " \t " + " \t " + str(res) + " \t " + str(runtime) + "\n")
                    finally:
                        logfile.close()
                   except IOError:
                       pass
                b.delete_key(key)
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
