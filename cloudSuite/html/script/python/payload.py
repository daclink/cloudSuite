import boto, sys, time
from elementtree.ElementTree import Element, SubElement, dump, ElementTree, parse, fromstring
from elementtree.ElementTree import Comment
from ElementTree_pretty import prettify
from subprocess import check_output, call

bucket = "cloudsuite.labs"

c  = boto.connect_s3()
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
    completed_bucket = "cs.user."+uname+".labs"
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
    completed_lab = "completed/"+labname
    cb = c.get_bucket(completed_bucket)
    cb.copy_key(completed_lab,bucket,labname)
    b.delete_key(key)



