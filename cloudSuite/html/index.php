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
session_start();
//$_SESSION['cs']['lab'] = 'foo';
if (isset($_SESSION['cs']['username'])) {
    $_ENV['cs']['username'] = $_SESSION['cs']['username'];
    $uname = $_SESSION['cs']['username'];
}
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'cs' . DIRECTORY_SEPARATOR . 'cloudsuite.class.php';

if (isset($_GET['debug'])){
    
    $_ENV['cs']['debug'] = $_GET['debug'];
    
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>CloudSuite v0.3.1.1</title>
        <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon"/>
        <link type="text/css" href="theme/css/blitzer/jquery-ui-1.8.18.custom.css" rel="stylesheet" />
        <link type="text/css" href="./styles/main.css" rel="stylesheet" />
        
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript" src="./theme/js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="./theme/js/jquery-ui-1.8.18.custom.min.js"></script>
        
        <script type="text/javascript">
          
          
          function getModToAdd(xmlFile){
              console.log("getModToAdd was called " + xmlFile);
              var restPath = "./rest.php?getModProperties=true&create=true&modToLoad="+xmlFile;
              restPath = restPath + "&labFileName=" + $("#labFileNameHidden").val();
              $("#lab").append("<div id='edit-mod'></div>");
              $("#edit-mod").load(restPath);
              $("#edit-mod").addClass('lab-content csshadow lab-slider');
              
          }
            
          function returnLab(){
              $("#status-bar").animate({height:"10%"},1000);
              $("#mainContainer").animate({height:"85%"},1000);
              $("#labList").hide();
          }
          
          function addModToLab(moduleWPath){
              //alert("Hey there! " + $("#labFileNameHidden").val());
              //console.log("Module with path is "+moduleWPath)+$("#labFileNameHidden").val();
              var restPath = "./rest.php?addModuleToLab="+$("#labFileNameHidden").val();
              restPath = restPath + "&moduleToLoad="+moduleWPath;
              $("#lab").load(restPath);
          }
            
          function loadLabReturnNormal(id, name){
                returnLab();
                $("#labListAccordian").replaceWith("<div id=\"labListAccordian\"></div>"); 
                
                if(id != null){
                    
                    var file = id + '.' + name + '.xml';
                   // alert("id = " + id + "File = " + file);
                    file = './rest.php?loadLabByFileName=' + file;
                    $('#lab').load(file);
                }
             }
             
          function clearTaskAlert(){
               $('#taskBarAlert').html("");
               $('#taslBarAlert').attr('class','');
               console.log("Clear!");
          }
          
          function logout() {
              $("#confirmLogOut").dialog({
                    resizable: false,
                    height:200,
                    modal: true,
                    buttons: {
                        "Logout?": function() {
                            $( this ).dialog( "close" );
                        $.ajax({
                            type: 'GET',
                            url: 'rest.php',
                            data: {logout:'TRUE'}
                        }).done(function( msg ){
                            $('#username').html('Login');
                            $('#username').attr('onclick',"loginButtonOpen()");
                            loggedInButtonClose();
                            clearTaskAlert();
                            $('#lab').load('./ui/defaultLabDisplay.php');
                        }); 
                            
                            
                        },
                        Cancel: function() {
                            $( this ).dialog( "close" );
                        }
                }
            });
	  }
          
          function login() {
              
              //alert("Uname = " + $("#login-name").val() + "pass = "+ $("#login-pass").val());
              var var_uname = $("#login-name").val();
              var var_pass = $("#login-pass").val();
              
              $.ajax({
               type: 'GET',
                url: 'ui/login.php',
               data: {uname:$("#login-name").val(), pass:$("#login-pass").val()}
              }).done(function( msg ){
                  
                  if (msg == "1") {
                      $('#username').html(var_uname);
                      $('#username').attr('onclick',"loginButtonOpen('"+var_uname+"')");
                      $('#logout').html("Log out " + var_uname +"?");
                      
                      loginButtonClose();
                      clearTaskAlert();
                      $('#lab').load('./rest.php?listLab=true');
                  } else {
                      //alert("fail!");
                      $('#taskBarAlert').addClass("login-item");
                      $('#taskBarAlert').html("Please try again!");
                      $('#taskBarAlert').fadeOut(1600, "swing");
                      $("#login-pass").focus();
                  }
                  
                  
                
              }); 
                    

          }   
             
          function loginButtonOpen(uname){
          
            clearTaskAlert();
            $("#task-bar").animate({height: "15%"},1000);
            $("#mainContainer").animate({height:"75%"},1000);
            
            if (uname == null || uname == '') {
              $(".task-bar-item").fadeOut(500,function(){
                    $(".login-item").fadeIn(500);
              });
            } else {
              $(".task-bar-item").fadeOut(500,function(){
                    $(".logged-in-item").fadeIn(500);
              });    
            }
            
          }
          
          function loginButtonClose(){
              $("#task-bar").animate({height: "5%"},1000);
              $("#mainContainer").animate({height:"85%"},1000);
              $(".login-item").fadeOut(500,function(){
                $(".task-bar-item").fadeIn(500);
              });
              $("#login-name").attr('value','');
              $("#login-pass").attr('value','');
              clearTaskAlert();
              
          }
          
          function loggedInButtonClose(){
              $("#task-bar").animate({height: "5%"},1000);
              $("#mainContainer").animate({height:"85%"},1000);
              $(".logged-in-item").fadeOut(500,function(){
                $(".task-bar-item").fadeIn(500);
              });
              //clearTaskAlert();
              
          }
          
          function delMod(modID, labID, modName) {
              console.log("delete modID" + modID + " labID = " + labID);
             // $(function() {
		$( "#delModDialog" ).dialog({
                    modal: true,
                    title: "Remove : " + modName + "?",
                    width: 600,
                    buttons: {
                        "Remove": function() {
                            var path = './restLab.php?removeMod=' + modID + "&labID=" +labID;
                            $('#lab').load(path);
                            $(this).dialog("close");
                        },
                        "Cancel": function() {
                            $(this).dialog("close");
                        }
                    }
                });
              //});
          }
          function editMod(modID, labID, modName) {
              console.log("rdit modName = " + modName + " edit modID = " + modID + " labID = " + labID);
              $('#editModDialog').dialog({
                  buttons: {
                        "Ok": function() { 
			$(this).dialog("close"); 
			}, 
			"Cancel": function() { 
			$(this).dialog("close"); 
			} 
                   }
              });
          }
             
          $(function(){
        	// Tabs
		$('#tabs').tabs();
                $("#collections").accordion({ clearStyle:true, header: "h3" });
                
                // Dialog			
		$('#dialog').dialog({
                    autoOpen: false,
                    width: 600,
                    modal: true,
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

              
            });
        </script>
       
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
           
    </head>
    <body>
        <?php 
            Utils::showStuff(SID, 'session ID '); 
            //Utils::showStuff($_SESSION['cs']['lab'],"lab");
         ?>
        
        <?php include('./ui/taskbar.html');?>
        <div id="mainContainer">
            <div id="lab_container" class="labDisplay">
                 <?php include('./ui/lab.php'); ?>

            </div>
            <div id="admin_container" class="adminDisplay">
                 <?php include('./ui/admin.php'); ?>

            </div>
            <div id="settings_container" class="settingsDisplay">
                 <?php include('./ui/settings.php'); ?>

            </div>
        </div>
        <?php include('./ui/statusbar.html');?>
        
     
        <script type="text/javascript">
         <?php
            // $xmlFile = $_ENV['cs']['collection_dir'].'biological.xml';
             
             
         ?>
            
            $(document).ready(function(){
                $("button").click(function(){
                $("#module").load('./rest.php?listModule=true&xmlScheme=<?echo $xmlScheme?>&xmlFile=<?echo $xmlFile?>');
                });
                $("div.settingsDisplay").hide();
                $("div.adminDisplay").hide();
                $("div.logged-in-item").hide();
                $("div.labDisplay").show();
                $("#settingsButton").removeClass("ChiSelected");
                $("#labButton").addClass("ChiSelected");
                $("#adminButton").removeClass("ChiSelected");
                $("#labList").hide();
                $("div.logged-in-item").hide();
                
                <?php
                    
                    if(isset($_SESSION['cs'][$uname]['labFileName'])){
                ?>
                var prevLab = './rest.php?loadLabByFileName=<?php echo $_SESSION['cs'][$uname]['labFileName']?>';
                    $('#lab').load(prevLab);
                <?php } elseif(isset($_SESSION['cs']['username']))  {?>
                    $('#lab').load('./rest.php?listLab=true');
                <?php
                } else { ?>
                    $('#lab').load('./ui/defaultLabDisplay.php');
                <?php } ?>
            });
            
             $("div.modList").live('click', function() {
                var id = this.id;
                $("#data").load('./rest.php?colGetModID=true&xmlScheme=<?echo $xmlScheme?>&xmlFile=<?echo $xmlFile?>&modid='+id);
             });
             
             $("div.colList").live('click', function() {
                 $("#colDesc").load('./rest.php?colGetDesc=true&xmlScheme=<?echo $xmlScheme?>&xmlFile=<?echo $xmlFile?>');
             });
             
             $("div.chiClick").live('click', function (){
                 $("div.chiClick").mouseup(function(){
                     $(this).addClass("csshadow").removeClass("clicked");
                 }).mousedown(function(){
                     $(this).addClass("clicked").removeClass("csshadow");
                 }).mouseout(function(){
                     $(this).addClass("csshadow").removeClass("clicked");
                 });
             
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
             
             $("#loadLab").mouseup(function(){
                $("#labListAccordian").load('./rest.php?listLab=true');
                $("#labList").show();
                $("#status-bar").animate({height:"85%"},1000);
                $("#mainContainer").animate({height:"10%"},1000);
             });
             
             $("div.labChoice").mouseup(function(){loadLabReturnNormal()});
             
             $("#newLab").mouseup(function(){
                $("#labListAccordian").load('./ui/newLab.php');
                $("#labList").show();
                $("#status-bar").animate({height:"85%"},1000);
                $("#mainContainer").animate({height:"10%"},1000);
             });
             
             $("#saveLab").mouseup(function(){
                 //alert("woo!" + $("#labFileNameHidden").val());
                 
                 if ($("#labFileNameHidden").val() != null ){
                    var sendData = new Object();
                    sendData["saveLab"] = $("#labFileNameHidden").val();
                    $.ajax({
                       //url: "http://cloudsuite.info/rest.php?saveLab="+$("#labFileNameHidden").val()
                       url: "http://cloudsuite.info/rest.php",
                       data: sendData
                    }).done(function (data) {
                       console.log(data);
                       alert($("#labFileNameHidden").val() + " saved"); 
                    });
                     
                 } else {
                     alert("No Lab to save!");
                 }
                 
             });
             
              
          $("#addModForm-button").live('click',function() { 
              
                $('input').each(function(){
                    console.log("ID = " + $(this).attr('id') + " val = " + $(this).val() + " checked? = " +$(this).attr('checked'));
                    
                    
                });
                console.log("edit mod name " + $('#edit-mod-name').val());
                addModToLab($("#edit-mod-name").val());
            });
            
          $("#cancelModForm-button").live('click',function() {   
            $("#edit-mod").remove();
          });
        </script>
        <div id="dialog_hider">
            <div id="delModDialog"> Remove the module from the lab?</div>
            <div id="editModDialog"> hey hey hey</div>
        </div>
        
        <div id="confirmLogOut">Confirm log out.</div>
    </body>
</html>

