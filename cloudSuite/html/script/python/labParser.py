import os
from elementtree.ElementTree import Element, SubElement, dump, ElementTree, parse
from elementtree.ElementTree import Comment
from ElementTree_pretty import prettify
from optparse import OptionParser as OP
from subprocess import check_output

#use BOTO to copy files

fileList = os.listdir('labs/')
i = 0
labDir = 'labs/'
for mod in fileList:
    print "i == " + str(i)
    i+=1
    print mod
    foo = parse(labDir+mod)
    #dump(foo)

    for module in foo.findall('module'):
        method = module.find('method').text
        xmlString = module.find('xmlrpcString').text
        print method, xmlString

    #output = subprocess.check_output
# pull needed data from tree
# call program indicated in
# use data to call mod maker
# move on.
#



