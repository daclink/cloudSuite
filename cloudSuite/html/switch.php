<?php
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
<!DOCTYPE html>
<html>
    <head>
        <title>CloudSuite v0.2.1 </title>
        <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon"/>
        <link type="text/css" href="theme/css/blitzer/jquery-ui-1.8.18.custom.css" rel="stylesheet" />
        <link type="text/css" href="./styles/main.css" rel="stylesheet" />
        
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript" src="./theme/js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="./theme/js/jquery-ui-1.8.18.custom.min.js"></script>
        
        <script type="text/javascript">
          $(function(){
        	// Tabs
		$('#tabs').tabs();
                $("#collections").accordion({ header: "h3" });
                
                	// Dialog			
				$('#dialog').dialog({
					autoOpen: false,
					width: 600,
					buttons: {
						"Ok": function() { 
							$(this).dialog("close"); 
						}, 
						"Cancel": function() { 
							$(this).dialog("close"); 
						} 
					}
				});
				
				// Dialog Link
				$('#dialog_link').click(function(){
					$('#dialog').dialog('open');
					return false;
				});

               $('').click(function(){
                   $(this).toggle();
               })
            });
        </script>
       
        <script language="JavaScript">
        
          function newMod(form) {
            
              var dest = form.destination.value;
              var loadString = form.method.value + "=" +form.name;
              loadString = loadString + "&modName=" + form.modName.value;
              
              $("#"+dest).load('./rest.php?'+ loadString);
              
          }
        
        function clearDiv(id){
            
            $("#"+id).text();
            
        }
        
        </script>
        
        
        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
           
    </head>
    <body>
            
        <div id="task-bar">
            <div id="labButton" class="task-bar-item chiClick csshadow">Lab</div> 
            <div id="adminButton" class="task-bar-item chiClick csshadow">Admin</div>
            <div id="settingsButton" class="task-bar-item chiClick csshadow">Settings</div>
            <div id="username" class="chiClick csshadow">User Name</div>
        </div>
        
        <div class="lab-content settings">settings</div>
        <div class="lab-content admin">Admin</div>
        <div class="lab-content lab">lab</div>
        
        
        <div id="adminSection">
            
            <div class="testContent">
                <form name="newModule" action="" method="get"> 
                   new module name : 
                   <input type="text" name="modName" />
                   <input type="hidden" name="destination" value="newModuleContent" />
                   <input type="hidden" name="method" value="newModule" />  <br/>
                   
                   <input type="button" name="button" value="click" onClick="newMod(this.form)"/>
                   
                </form>
                
                <div id="newModuleContent">
                    
                </div>
                
               
            </div>
            
        </div>
        
     
        <script type="text/javascript">
            
            $(document).ready(function() {
                $("div.settings").hide();
                $("div.admin").hide();
                $("div.lab").show();
            });
             
             $("div.chiClick").mouseup(function(){
                 $(this).addClass("csshadow").removeClass("clicked");
             }).mousedown(function(){
                 $(this).addClass("clicked").removeClass("csshadow");
             }).mouseout(function(){
                 $(this).addClass("csshadow").removeClass("clicked");
             });
             
             $("#settingsButton").mouseup(function(){
                 $("div.settings").show();
                 $("div.admin").hide();
                 $("div.lab").hide();
             });
             
             $("#labButton").mouseup(function(){
                $("div.settings").hide();
                $("div.admin").hide();
                $("div.lab").show();
             });
             
             $("#adminButton").mouseup(function(){
                $("div.settings").hide();
                $("div.admin").show();
                $("div.lab").hide();
             });
             
        </script>
       
        
        
    </body>
</html>

