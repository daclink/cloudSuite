<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/*%******************************************************************************************%*/
// CORE DEPENDENCIES

// Look for include file in the same directory (e.g. `./config.inc.php`).
if (file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.php'))
{
	include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.php';
}
// Fallback to `~/.aws/sdk/config.inc.php`
//TODO: Chnage this to a set of configuration defaults.
/*
elseif (getenv('HOME') && file_exists(getenv('HOME') . DIRECTORY_SEPARATOR . '.aws' . DIRECTORY_SEPARATOR . 'sdk' . DIRECTORY_SEPARATOR . 'config.inc.php'))
{
	include_once getenv('HOME') . DIRECTORY_SEPARATOR . '.aws' . DIRECTORY_SEPARATOR . 'sdk' . DIRECTORY_SEPARATOR . 'config.inc.php';
}
*/

/*%******************************************************************************************%*/

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'cs' . DIRECTORY_SEPARATOR . 'cloudsuite.class.php';

?>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title>CloudSuite</title>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
        
         <script type="text/javascript" charset="utf-8">
             $(function() {
                $( "input:submit, button", ".getID").button();
                $( ".button").click(function(){
                    sendValue($(".txtValue").val())
                })
             });
             $(document).load(function(){
                 $('#getID')
             });

        $(document).ready(function(){
            $('#txtValue').keyup(function(){
                sendValue($(this).val());   
                
            }); 
            
        });
        function sendValue(str){
            $.post("./script/php/id.php",{ sendValue: str },
            function(data){
                $('#display').html(data.returnValue);
            }, "json");
            
        }
        
    </script>
    </head>
    <body>
        <!--Ajax Testing section -->
        <input type="submit" value="GetID" id="getID"></input>
        <div id="dispID">
            <button id="buttonID">get ID</button>
            
        </div>
        
            <label for="txtValue">Enter a value : </label>
    <input type="text" name="txtValue" value="" id="txtValue">
    
    <div id="currID"></div>
        <!-- end ajax test -->
        
        <div>
            <?php
                echo"<pre>";
                print_r($_ENV['cs']);
                echo"</pre>";
                $xmlFile = $_ENV['cs']['collection_dir'].'biological.xml';
                $xmlScheme = $_ENV['cs']['schema_dir'].'collection.xsd';
                
                echo "<div> File is $xmlFile</div>";
                echo "<div> scheme is $xmlScheme</div>";
                
               if( Utils::validate($xmlScheme, $xmlFile)) {
                echo "<div>IT'S GOOD!</div>";
                
                 $collection = new Collection($xmlScheme, $xmlFile);
                 
                 echo "<pre>";
                 $foo = Collection::listModules($xmlScheme, $xmlFile);
                    
                 print_r($foo);
                 echo "</pre>";
                 /*
                 $user = new user();
                 
                 $user->name = "filbert";
                 
                 echo "<pre>";
                 
                 echo $user->name;
                 try{
                 $user->foo = "bar";
                 } catch (Exception $e) {
                     echo 'Caught exception: ',  $e->getMessage(), "\n";
                 }
                 
                */
                 echo "</pre>";
                 
               } else {
                  echo "<div>IT'S not valid but good!!</div>";
               }
               
               ?>
        </div>
    </body>
</html>
