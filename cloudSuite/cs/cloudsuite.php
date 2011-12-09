<?php namespace cs;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cloudsuite
 *
 * @author drew
 */
class  Module{
    //put yofur code here
    
     public static function getModuleList(){
         if(isset($_ENV['MODULE_PATH'])){
             return array ($_ENV['MODULE_PATH']);
         }
    }
    
    public static function writeModule(Module $module){
        $success = false;
            
            if(isset($ENV['MODULE_PATH'])){
                $success = true;
            } else {
                $success = false;
            }
            
        return $success;
    }
    
}

?>
