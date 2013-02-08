#!/usr/bin/python
from elementtree.ElementTree import Element, SubElement, dump, ElementTree
from elementtree.ElementTree import Comment
from ElementTree_pretty import prettify
import indent 

class Wrapper:
    
    #def modMaker(self):           
    def __init__(self, mod_id=0,mod_name=""):
        self.mod_id=mod_id
        self.mod_name=mod_name
        self.mod = Element("module", id=self.mod_id, name=self.mod_name) 
        module = Element("module", id=self.mod_id, name=self.mod_name)

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
        data        = SubElement(module, "data")

        self.mod = module
        print "end of line"

        '''
        window = Element("window")

        title = SubElement(window, "title", font="large")
        title.text = "A Sample text window"

        text = SubElement(window, "text", wrap="word")
        box = SubElement(window, "buttonbox")
        SubElement(box, "button").text = "ok"
        SubElement(box, "button").text = "cancel"
        #indent(window)
        #dump(window)
        '''
    @staticmethod
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

    def dump_mod(self):
        self.indent(self.mod)
        dump(self.mod)

    #@staticmethod
    def writeMod(self):
        ElementTree(self.module).write("testMod.xml", xml_declaration=True)

