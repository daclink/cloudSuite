#!/usr/bin/env python
import sys
from xml.dom import minidom, Node

Station1 = ['thing1','234']
Station2 = ['thing2','asd']
Station3 = ['thing3','foo']
stlist = [Station1, Station2, Station3]
#Create a dom object
DOMimpl = minidom.getDOMImplementation()

#create a doc
xmldoc = DOMimpl.createDocument(None, "Workstations", None)
doc_root = xmldoc.documentElement

#add nodes

for station in stlist:
    node = xmldoc.createElement("comp")
    
    element = xmldoc.createElement('proc')
    element.appendChild(xmldoc.createTextNode(station[0]))
    node.appendChild(element)
    
    element = xmldoc.createElement('mem')
    element.appendChild(xmldoc.createTextNode(station[1]))
    node.appendChild(element)
    
    #add node
    doc_root.appendChild(node)
    
print "\nnodes\n========="
nodeList = doc_root.childNodes
for node in nodeList:
    print node.toprettyxml()

#Write to file        
file = open("stations.xml",'w')
file.write(xmldoc.toxml())