#!/usr/bin/python
from elementtree.ElementTree import Element, SubElement, dump, ElementTree
from elementtree.ElementTree import Comment
from ElementTree_pretty import prettify
from optparse import OptionParser as OP

def indent(elem, level=0):
	i = "\n" + level*" "
	if len(elem):
		if not elem.text or not elem.text.strip():
			elem.text = i + " "
		if not elem.tail or not elem.tail.strip():
			elem.tail = i
		for elem in elem:
			indent(elem, level+1)
		if not elem.tail or not elem.tail.strip():
			elem.tail = i
	else:
		if level and (not elem.tail or not elem.tail.strip()):
			elem.tail = i

parser = OP()

parser.add_option("-u", "--username", dest="username",
						help="the user who will own the file")
parser.add_option("-m", "--modname", dest="mod_name",
						help="The name for the module")
parser.add_option("-d", "--data", dest="mod_data",
						help="The data to store in the mod")

(options, args) = parser.parse_args()

if options.username:
	username = options.username
else:
	username = "no name"

if options.mod_name:
	mod_name = options.mod_name
else:
	mod_name = "generi-name"

if options.mod_data:
	mod_data = options.mod_data
module = Element("module", id="file",name="thing")

moduleType  = SubElement(module, "moduleType").text = "data"
description = SubElement(module, "description")

systemReqs = SubElement(module, "systemRequirement")
sr_product = SubElement(systemReqs, "product")
sr_version = SubElement(systemReqs, "version")

fieldset    = SubElement(module, "fieldset")
f_legend    = SubElement(fieldset, "legend")

f_element = SubElement(fieldset, "element")
e_type     = SubElement(f_element, "type")
e_name     = SubElement(f_element, "name")
e_value    = SubElement(f_element, "value")
e_desc     = SubElement(f_element, "description")
e_input    = SubElement(f_element, "input")
e_output   = SubElement(f_element, "output")
e_required = SubElement(f_element, "required")
e_default  = SubElement(f_element, "default")
e_selected = SubElement(f_element, "selected")

permissions = SubElement(module, "permissions")
p_owner     = SubElement(permissions, "owner").text = "7"
p_everyone  = SubElement(permissions, "everyone")
p_group     = SubElement(permissions, "group")
p_groupname = SubElement(permissions, "everyone")

methodName  = SubElement(module, "methodName")
createdBy   = SubElement(module, "createdBy")
dateCreated = SubElement(module, "dateCreated")
data        = SubElement(module, "data").text = mod_data

indent(module)
dump(module)
ElementTree(module).write(mod_name+".xml", xml_declaration=True)
#Put file in users s3 bucket. BOOM.

