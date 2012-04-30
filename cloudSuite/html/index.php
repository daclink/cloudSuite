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

if (isset($_GET['debug'])){
    
    $_ENV['cs']['debug'] = $_GET['debug'];
    
}

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
       
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
           
    </head>
    <body>
            
        <?php include('./ui/taskbar.html');?>
        
        <div class="labDisplay">
             <?php include('./ui/lab.php'); ?>
            
        </div>
        <div class="adminDisplay">
             <?php include('./ui/admin.php'); ?>
            
        </div>
        <div class="settingsDisplay">
             <?php include('./ui/settings.php'); ?>
            
        </div>
        
        <?php include('./ui/statusbar.html');?>
        
     
        <script type="text/javascript">
         <?php
             $xmlFile = $_ENV['cs']['collection_dir'].'biological.xml';
             
             
         ?>
            
            $(document).ready(function(){
                $("button").click(function(){
                $("#module").load('./rest.php?listModule=true&xmlScheme=<?echo $xmlScheme?>&xmlFile=<?echo $xmlFile?>');
                });
                $("div.settingsDisplay").hide();
                $("div.adminDisplay").hide();
                $("div.labDisplay").show();
                $("#settingsButton").removeClass("ChiSelected");
                $("#labButton").addClass("ChiSelected");
                $("#adminButton").removeClass("ChiSelected");
            });
            
             $("div.modList").live('click', function() {
                var id = this.id;
                $("#data").load('./rest.php?colGetModID=true&xmlScheme=<?echo $xmlScheme?>&xmlFile=<?echo $xmlFile?>&modid='+id);
             });
             
             $("div.colList").live('click', function() {
                 $("#colDesc").load('./rest.php?colGetDesc=true&xmlScheme=<?echo $xmlScheme?>&xmlFile=<?echo $xmlFile?>');
             });
             
             $("div.chiClick").mouseup(function(){
                 $(this).addClass("csshadow").removeClass("clicked");
             }).mousedown(function(){
                 $(this).addClass("clicked").removeClass("csshadow");
             }).mouseout(function(){
                 $(this).addClass("csshadow").removeClass("clicked");
             });
             
             $("#settingsButton").mouseup(function(){
                $("div.settingsDisplay").show();
                $("div.adminDisplay").hide();
                $("div.labDisplay").hide();
                $("#settingsButton").addClass("ChiSelected");
                $("#labButton").removeClass("ChiSelected");
                $("#adminButton").removeClass("ChiSelected");
             });
             
             $("#labButton").mouseup(function(){
                $("div.settingsDisplay").hide();
                $("div.adminDisplay").hide();
                $("div.labDisplay").show();
                $("#settingsButton").removeClass("ChiSelected");
                $("#labButton").addClass("ChiSelected");
                $("#adminButton").removeClass("ChiSelected");
             });
             
             $("#adminButton").mouseup(function(){
                $("div.settingsDisplay").hide();
                $("div.adminDisplay").show();
                $("div.labDisplay").hide();
                $("#settingsButton").removeClass("ChiSelected");
                $("#labButton").removeClass("ChiSelected");
                $("#adminButton").addClass("ChiSelected");
             });
             
        </script>
       
        
        
    </body>
</html>

