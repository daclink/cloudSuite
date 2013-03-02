#!/usr/local/bin/python2.7
from elementtree.ElementTree import Element, SubElement, dump, ElementTree, tostring
from elementtree.ElementTree import Comment
#from ElementTree_pretty import prettify
from optparse import OptionParser as OP
from subprocess import check_output
from boto.s3.key import Key
from cs_error import *
import boto, sys, time, os

logdir = os.environ['HOME'] + '/cs_log/module.log'
logfile = open(logdir,'a')

error = False
cause = ""

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
'''
#These options are necessary for ALL modules.
'''
parser.add_option("-u", "--username", dest="username",
                        help="the user who will own the file")
parser.add_option("-m", "--modname", dest="mod_name",
                        help="The name for the module")
parser.add_option("--not_unique)", dest="not_unique", action="store_true",
                        help="the name of the originating lab.")
parser.add_option("--labname", dest="labname",
                        help="the name of the originating lab.")
'''
# Modify these options as necessary for the module
'''
parser.add_option("--in", dest="infile",
                        help="The CSV file to graph")

(options, args) = parser.parse_args()

if (not options.username == None):
    username = options.username
    uname = username
else:
    error = True
    cause = cause + "No username supplied\n"

if (not options.mod_name == None):
    mod_name = options.mod_name
else:
    cause = cause + "No Module name supplied\n"
    error = True

if (not options.labname == None):
    labname = options.labname
else:
    cause = cause + "No labname supplied\n"
    error = True

if (not options.infile == None):
    infile = options.infile
else:
    cause = cause + "No input file specified\n"
    error = True

if (not error):
    executable ="grapher/grapher.exe --input="+infile
    try:
        output = check_output(executable ,shell=True)
    except:
        error = True
        cause = "\""+executable +"\" exited with status code " + output

mod_data = "Command called:\n"

for arg in sys.argv:
    mod_data = mod_data + arg + " "

if (error == True) :
    try:
        logfile.write("\n***ERROR***:\n")
        logfile.write("cause : " + cause + "\n")
        logfile.write("mod_data :+" + mod_data + "\n")
        logfile.write("***ERROR***:\n\n")
        raise
    except Exception as Inst:
        print "there was an error: " + cause
        raise PreconditionFail(cause)
    finally:
        logfile.close()

mod_id = labname.split(".")[0]
if (not options.not_unique):
    mod_id = str(mod_id) + str((long(time.time()*100000))%10000)

filename = mod_id + "."
filename = filename + mod_name.split(".")[0]
data     = filename + ".txt"
filename = filename + ".xml"
directory = os.path.dirname(os.path.realpath(__file__)) + filename

runtime = time.asctime(time.localtime(time.time()) )

desc = options.labname.split(".")[1] + "."
desc = desc + mod_name.split(".")[0]

mod_name = mod_name.split(".")[0]

module = Element("module", id=mod_id,name=mod_name)

moduleType  = SubElement(module, "moduleType").text = "data"
description = SubElement(module, "description").text = "Data from running " + desc

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
#e_required = SubElement(f_element, "required")
#e_default  = SubElement(f_element, "default")
#e_selected = SubElement(f_element, "selected")

permissions = SubElement(module, "permissions")
permissions.set("clearance","")
p_owner     = SubElement(permissions, "owner").text = "7"
p_everyone  = SubElement(permissions, "everyone")
p_group     = SubElement(permissions, "group")
p_groupname = SubElement(permissions, "groupname")

methodName  = SubElement(module, "methodName").text = mod_name
createdBy   = SubElement(module, "createdBy").text = uname
dateCreated = SubElement(module, "dateCreated").text = runtime
data        = SubElement(module, "data").text = data
lab         = SubElement(module, "lab"). text = labname.split(".")[1]

indent(module)
#dump(module)
mod_str = dump(module)
#ElementTree(module).write(filename, encoding="UTF-8", xml_declaration=True)
#Put file in users s3 bucket. BOOM.

c = boto.connect_s3()
bucket = "cs.user."+uname+".modules"
b = c.create_bucket(bucket)
k = Key(b)
k.key = filename
k.set_contents_from_string(tostring(module, encoding="UTF-8"))

b = c.create_bucket("cloudsuite.data.warehouse")
k = Key(b)
k.key = data
k.set_contents_from_string(mod_data)
logfile.write("bucket == " + bucket +"\n")
logfile.write("filename == " + filename +"\n")
logfile.write("bucket = cloudsuite.data.warehouse"+"\n")
logfile.write("data == " + data + "\n")
logfile.close()

try:
    logfile = open(logdir,'a')
    logfile.write("bucket == " + bucket +"\n")
    logfile.write("filename == " + filename +"\n")
    logfile.write("bucket = cloudsuite.data.warehouse"+"\n")
    logfile.write("data == " + data + "\n")
except IOError:
    pass
finally:
    logfile.close()    