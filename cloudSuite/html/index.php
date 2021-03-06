<?php
/* %******************************************************************************************% */
// CORE DEPENDENCIES
// Look for include file in the same directory (e.g. `./config.inc.php`).
if (file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.php')) {
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

/* %******************************************************************************************% */
session_start();
//$_SESSION['cs']['lab'] = 'foo';

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'cs' . DIRECTORY_SEPARATOR . 'cloudsuite.class.php';

if (User::checkSession()) {
    $uname = User::checkSession();
}

if (isset($_SESSION['cs']['username'])) {
    $_ENV['cs']['username'] = $_SESSION['cs']['username'];
    $uname = $_SESSION['cs']['username'];
} elseif (isset($_COOKIE['cs_uname'])) {
    $uname = $_COOKIE['cs_username'];
    $_SESSION['cs']['username'] = $uname;
} else {
    setcookie("cs_username");
}

if (isset($_GET['debug'])) {

    $_ENV['cs']['debug'] = $_GET['debug'];
}

//Utils::showStuff($uname,"User name");
//Utils::showStuff($_COOKIE, "Cookie");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>CloudSuite v0.7</title>
        <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon"/>
        <link type="text/css" href="./styles/jquery-ui-1.8.18.custom.css" rel="stylesheet" />
        <link type="text/css" href="./styles/main.css" rel="stylesheet" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript" src="./theme/js/jquery-1.8.2.js"></script>
        <script type="text/javascript" src="./theme/js/jquery-ui-1.9.1.custom.min.js"></script>
        <script src="http://malsup.github.com/jquery.form.js"></script> 

        <script type="text/javascript" src="./script/jqueryPlugins/jquery.simplemodal-1.4.3.js"></script>

        <script type="text/javascript">
          
          
            function getModToAdd(xmlFile){
                console.log("getModToAdd was called " + xmlFile);
                var restPath = "./rest.php?getModProperties=true&create=true&modToLoad="+xmlFile;
                restPath = restPath + "&labFileName=" + $("#labFileNameHidden").val();
                $("#lab").append("<div id='edit-mod'></div>");
                $("#edit-mod").load(restPath);
                $("#edit-mod").addClass('lab-content csshadow lab-slider');
              
            }
            
            function getCloudMod(bucket, key){
                var restPath = "./cloudCommand/cloudMod/";
                restPath = restPath + bucket +"/";
                restPath = restPath + key +"/";
                restPath = restPath + $("#labFileNameHidden").val();
                
                console.log("restpath is " + restPath);
                
                $.ajax({
                    type: 'GET',
                    url: restPath
                }).done(function( retVal ){
                    $("#lab").append("<div id='edit-mod'></div>");
                    $("#edit-mod").html(retVal);
                    //$("#edit-mod").addClass('lab-content csshadow lab-slider');
                    $("#edit-mod").dialog({
                        resizable: false,
                        height:'auto',
                        width:'auto',
                        title: "User Data",
                        modal: true ,
                        buttons: {
                            "Close": function() {
                                $( this ).dialog( "close" );
                            },
                            "Delete": function() {
                                $( this ).dialog( "close" );
                                //var dataFileName = $("#hiddenDataMod").val();
                                //alert("dataFileName == " + dataFileName);
                                var path = "./cloudCommand/datamod/"+key+"/"+bucket;
                                var r = confirm("Really delete " + key + " and all associated data? (this can not be undone)");
                                
                                if (r) {
                                    $.ajax({
                                        type: 'DELETE',
                                        url: path
                                    }).done(function( msg ){
                                        alert(key + " deleted.")
                                        getCollections($("#task-bar").data("uname"));
                                    }); 
                                }
                            
                            
                            }
                        }
                    });
                });
                
            }
            
            function returnLab(){
                $("#status-bar").animate({height:"10%"},1000);
                $("#mainContainer").animate({height:"85%"},1000);
                $("#labList").hide();
            }
          
            function addModToLab(moduleWPath, formVals){
                
                //alert("Hey there! " + $("#labFileNameHidden").val());
                console.log("Module with path is " + moduleWPath + $("#labFileNameHidden").val());
                console.log("Module values " + formVals);
                var restPath = "./rest.php?addModuleToLab="+$("#labFileNameHidden").val()+"&"+formVals;
                restPath = restPath + "&moduleToLoad="+moduleWPath;
                $("#lab").load(restPath);
            }
            
            function loadLabReturnNormal(id, name){
                returnLab();
                $("#labListAccordian").replaceWith("<div id=\"labListAccordian\"></div>"); 
                
                if(id != null){
                    
                    var file = id + '.' + name + '.xml';
                    // alert("id = " + id + "File = " + file);
                    $("#runLab").attr('name', file);
                    // file = './rest.php?loadLabByFileName=' + file;
                    //$('#lab').load(file);
                    file = './cloudCommand/loadLab/'+$("#task-bar").data("uname")+'/'+file
                    console.log("file : " + file);
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
                                //  $('#lab_container').load('./ui/lab.php');
                                jQuery.removeData($("#task-bar"),"uname");
                                getCollections();
                            }); 
                        },
                        Cancel: function() {
                            $( this ).dialog( "close" );
                        }
                    }
                });
            };
          
            function login() {
              
                //alert("Uname = " + $("#login-name").val() + "pass = "+ $("#login-pass").val());
                var var_uname = $("#login-name").val();
                var var_pass = $("#login-pass").val();
                $("#task-bar").data("uname", var_uname);
                $.ajax({
                    type: 'GET',
                    url: 'ui/login.php',
                    data: {uname:$("#login-name").val(), pass:$("#login-pass").val()}
                }).done(function( msg ){
                  
                    if (msg == "1") {
                        $('#username').html(var_uname);
                        $('#username').attr("name",var_uname);
                        $('#username').attr('onclick',"loginButtonOpen('"+var_uname+"')");
                        $('#logout').html("Log out " + var_uname +"?");
                        loginButtonClose();
                        clearTaskAlert();
                        $('#lab').load('./cloudCommand/labList/'+var_uname);
                        $("#task-bar").data("uname", var_uname);
                        getCollections($("#task-bar").data("uname"));
                        
                    } else {
                        //alert("fail!");
                        jQuery.removeData($("#task-bar"),"uname");
                        $('#taskBarAlert').addClass("login-item");
                        $('#taskBarAlert').html("Please try again!");
                        $('#taskBarAlert').fadeOut(1600, "swing");
                        $("#login-pass").focus();
                    }
                });
                
                $("#collections").accordion("refresh");
                
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
            }
            
            function editMod(modID, labID, modName) {
                console.log("edit modName = " + modName + " edit modID = " + modID + " labID = " + labID);
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
            
            function delLab(labName) {
            
                var owner = $("#task-bar").data("uname");
                var path = "cloudCommand/lab/"+owner+"/"+labName;
                
                $( "#delLabDialog" ).dialog({
                    modal: true,
                    title: "Deleteing " + labName + "...",
                    width: 600,
                    buttons: {
                        "Delete": function() {
                            //ajax call to cloudCommand/lab/owner/labName
                            $(this).dialog("close");
                            $.ajax({
                                type: 'DELETE',
                                url: path
                            }).done(function( msg ){
                                console.log(msg)
                                alert(labName + " deleted");
                                $('#lab').load('./cloudCommand/labList/'+owner);
                            });
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
        <script>
            jQuery.fn.reset = function () {
                $(this).each (function() { this.reset(); });
            }
        </script>

    </head>
    <body>
        <?php
        Utils::showStuff(SID, 'session ID ');
//Utils::showStuff($_SESSION['cs']['lab'],"lab");
        ?>

        <?php include('./ui/taskbar.html'); ?>
        <div id="mainContainer">
            <div id="lab_container" class="labDisplay">
                <?php include('./ui/lab.php'); ?>

            </div>

            <div id="queued_container" class="queuedDisplay">
                <?php include('./ui/queued.php'); ?>

            </div>
            <div id="complete_container" class="completedDisplay">
                <?php include('./ui/complete.php'); ?>

            </div>
            <div id="admin_container" class="adminDisplay">
                <?php include('./ui/admin.php'); ?>

            </div>
            <div id="settings_container" class="settingsDisplay">
                <?php include('./ui/settings.php'); ?>

            </div>
        </div>
        <?php include('./ui/statusbar.html'); ?>

        <div class="modal_dialog" id="modmodmod">
            test test test
        </div>

        <script type="text/javascript">
<?php
// $xmlFile = $_ENV['cs']['collection_dir'].'biological.xml';
?>
            
    $(document).ready(function(){
        
        $("button").click(function(){
            $("#module").load('./rest.php?listModule=true&xmlScheme=<? echo $xmlScheme ?>&xmlFile=<? echo $xmlFile ?>');
        });
        /*
                $("div.settingsDisplay").hide();
                $("div.adminDisplay").hide();
                $("div.queuedDisplay").hide();
                $("div.completeDisplay").hide();
                $("div.logged-in-item").hide();
                $("div.labDisplay").show();
                $("#settingsButton").removeClass("ChiSelected");
                $("#labButton").addClass("ChiSelected");
                $("#adminButton").removeClass("ChiSelected");
         */
        $("#labList").hide();
        $("div.logged-in-item").hide();
        taskBarClick('div.labDisplay','#labButton');
        /*           
<?php
if (isset($_SESSION['cs'][$uname]['labFileName'])) {
    ?>
                            alert('lab name..')
                                //var prevLab = './rest.php?loadLabByFileName=<?php //echo $_SESSION['cs'][$uname]['labFileName']                  ?>';
                                var prevLab = './cloudCommand/loadLab/<?php echo $_SESSION['cs'][$uname]['labFileName']; ?>';
                                $('#lab').load(prevLab);
                                $('#runLab').attr('name','<?php echo $_SESSION['cs'][$uname]['labFileName']; ?>');
                                loadQueued();
<?php } elseif (isset($_SESSION['cs']['username'])) { ?>
                            alert('no lab name..');
                            alert('name is :  <?php echo $_SESSION['cs']['username']; ?>');
                            $('#lab').load('./rest.php?listLab=true&uname=<?php echo $_SESSION['cs']['username']; ?>');
                            loadQueued();
<?php } else { ?>
                    alert('Default..')
                            $('#lab').load('./ui/defaultLabDisplay.php');
<?php } ?>
         */
    });
            
    $("div.modList").live('click', function() {
        var id = this.id;
        $("#data").load('./rest.php?colGetModID=true&xmlScheme=<? echo $xmlScheme ?>&xmlFile=<? echo $xmlFile ?>&modid='+id);
    });
             
    $("div.colList").live('click', function() {
        $("#colDesc").load('./rest.php?colGetDesc=true&xmlScheme=<? echo $xmlScheme ?>&xmlFile=<? echo $xmlFile ?>');
    });
             
    $("body").on('click', 'div.chiClick', function (){
        $("div.chiClick").mouseup(function(){
            $(this).addClass("csshadow").removeClass("clicked");
        }).mousedown(function(){
            $(this).addClass("clicked").removeClass("csshadow");
        }).mouseout(function(){
            $(this).addClass("csshadow").removeClass("clicked");
        });
             
    });
  
    function taskBarClick(showClass, buttonID){
            
        $("#mainContainer").children().not(showClass).hide();
        // $("#lab_Container").not(showClass).hide();
        $("div.status-bar-item").not(showClass).hide();
        $("div.task-bar-item").not(buttonID).removeClass("ChiSelected");
        $(buttonID).addClass("ChiSelected");
        $(showClass).show();
        if ($("#task-bar").data("uname")==="AJ" && showClass === "adminDisplay") {
            $("#shareLab").show;
        }
    }
             
    $("#task-bar").on('click','#settingsButton',function(){
        taskBarClick('div.settingsDisplay','#settingsButton');
    });
            
    $("#task-bar").on('click','#labButton',function(){
        taskBarClick('div.labDisplay','#labButton');
        console.log("loading lab container!");
        getCollections($("#task-bar").data("uname"));
    });
            
    $("#task-bar").on('click','#adminButton',function(){
        taskBarClick('div.adminDisplay','#adminButton');
        $("#serverStat").load("./cloudCommand/server/"+$("#task-bar").data("uname"));
        $("#distLab").load("./cloudCommand/distLab/"+$("#task-bar").data("uname"));
    });
             
    $("#task-bar").on('click','#queuedButton',function(){
        loadQueued();
        taskBarClick('div.queuedDisplay','#queuedButton');
    });
             
    $("#task-bar").on('click','#completedButton',function(){
        taskBarClick('div.completedDisplay','#completedButton');
    });
            
            
    $("#status-bar").on('click', '#loadLab', function(){         
        //$("#loadLab").mouseup(function(){
        $("#labListAccordian").load('./cloudCommand/labList/'+ $("#task-bar").data("uname"));
        //$("#labListAccordian").load('./rest.php?listLab=true');
        $("#labList").show();
        $("#status-bar").animate({height:"85%"},1000);
        $("#mainContainer").animate({height:"10%"},1000);
    });
             
    $("#labList").on('click', 'div.labChoice', function(){loadLabReturnNormal()})
    // $("div.labChoice").mouseup(function(){loadLabReturnNormal()});
             
    $("#newLab").mouseup(function(){
        $("#labListAccordian").load('./ui/newLab.php');
        $("#labList").show();
        $("#status-bar").animate({height:"85%"},1000);
        $("#mainContainer").animate({height:"10%"},1000);
    });
             
    $("#status-bar").on('click', "#saveLab",function(){    
        //alert("woo!" + $("#labFileNameHidden").val());
        //$("#task-bar").data("uname")
        if ($("#labFileNameHidden").val() != null ){
            var sendData = new Object();
            sendData["saveLab"] = $("#labFileNameHidden").val();
            var file = "./cloudCommand/saveLab/"+$("#task-bar").data("uname")+"/"+$("#labFileNameHidden").val();
            var fileName = $("#labFileNameHidden").val();
            console.log("saving url == " + file);
            $.ajax({
                method:'POST',
                //url: "http://cloudsuite.info/rest.php?saveLab="+$("#labFileNameHidden").val()
                //url: "http://cloudsuite.info/rest.php",
                url:   file
                //data: sendData
            }).done(function (data) {
                console.log(data);
                $("#runLab").attr('name', fileName);
                alert(fileName + " saved");
            }).fail(function(){
                alert("saving the lab failed. " + file);
            });
                     
        } else {
            alert("No Lab to save!");
        }
                 
    });
    
    function loadQueued(){
        $.ajax({
            type: 'GET',
            url: '/cloudCommand/queue',
            data: {user:'foo'}
        }).done(function( queuedLabs ){
            $("#queuedSection").html(queuedLabs);
            
            console.log(queuedLabs);
        });
    }
    
    $("#status-bar").on('click', "#runLab",function(){
        
        var name = $(this).attr('name');
        $.ajax({
            type: 'POST',
            url: '/cloudCommand/queue/'+name,
            data: {lab:name,userName:"asd"}
        }).done(function( msg ){
            if (msg){
                alert("Lab " + name + " has been queued.");
                loadQueued();
            } else {
                alert("There was a problem queuing " + name);   
            }
            //alert("Message is : " + msg);
            /*       
            if (msg == "1") {
                alert("Lab \"" + $(this).attr('name') + "\" has been queued.");
            } else {
                alert("fail!");
            }*/
       
        });
    });
            
    function showResponse(responseText, statusText, xhr, $form)  { 
    
        alert('status: ' + statusText + '\n\nresponseText: \n' + responseText + 
            '\n\nThe output div should have already been updated with the responseText.'); 
    }
    
    function failShare(){
        alert("fail share called");
    }
            
    $('#lab').on('click', '#addModForm-button', function(){ 
    
        var form = $('#addModForm').formSerialize();
        console.log("form stuff is " + form);
        console.log("edit mod name " + $('#edit-mod-name').val());        
        addModToLab($("#edit-mod-name").val(), form);
    });
    $("#lab").on('click', '#cancelModForm-button', function() {  
        $("#edit-mod").remove();
    });
          
    $("#task-bar").on('click', '#loginNameContainer', function(){
        $("#login-name").focus(); 
    });
    $("#task-bar").on('click', '#loginPassContainer', function(){
        $("#login-pass").focus(); 
    });
    
    $("#labDistForm").submit(function(){
        alert("share button pressed button function");
              
        var options = { target: "dist.php",
            beforeSubmit : showRequest,
            success: labShareSuccess,
            fail: failShare,
            type: "POST",
            resetForm:1 };
        $("#labDistForm").ajaxSubmit(options);
        //  $("#labDistForm").reset();
        return false; 
    });
    
    $("#status-bar").on("click","#shareLab", function(){
        
        var form = $('#labDistForm').formSerialize();
        console.log("form stuff is " + form);
        console.log("edit mod name " + $('#edit-mod-name').val());        
        
        
        $.post("http://cloudsuite.info/cloudCommand/shareLab",
        form,
        function(data,status){
            if (status==="success") {
                alert("Lab(s) have been distributed");
                $("#labDistForm").reset();
            } else {
                alert("Lab(s) failed to distribute please try again.");
            }
                    
        }); 
                
                
    });
    
    function statusMessage(){
        
        var loop = true;
        while(loop) {
            console.log("looping...");
            if($("#serverCode").name == "80" || $("#serverCode").name == "16") {
                $("#serverCode").html("woo");
                $("#serverStat").load("./cloudCommand/server/"+$("#task-bar").data("uname"));
                loop = false;
            } else {
                $("#serverCode").html("wait for it...");
                $("#serverStat").load("./cloudCommand/server/"+$("#task-bar").data("uname"));
            }
        }
     
    }
    
    $("#serverStat").on('click', '#startServer', function(){
        $.ajax({
            url : "cloudCommand/startServer/"+$("#task-bar").data("uname")+"/i-6f8d0812",
            type: "put"
        }).done(function(){
            $("#serverStat").load("./cloudCommand/server/"+$("#task-bar").data("uname"));
                
         
        });
    });
    
    $("#serverStat").on('click', '#stopServer', function(){
        
        $.ajax({
            url : "cloudCommand/stopServer/"+$("#task-bar").data("uname")+"/i-6f8d0812",
            type: "put"
        }).done(function(){
            $("#serverStat").load("./cloudCommand/server/"+$("#task-bar").data("uname"));
                
         
        });
        
    });
 
    
    $("#serverStat").on('click', '#refreshServer', function(){
    
        //    $("#statusDiv").html("Refreshing ...");
        /*
       if (codeNum === 64) {
            alert('woo! 64');
        }else {
            alert("boo");
        }*/
        //alert("codeVal is " + codeVal +" Code num is " + codeNum);  
        $("#serverStat").load("./cloudCommand/server/"+$("#task-bar").data("uname"));
    });
    
    /*  $("body").on('click', 'input', function(){         
        console.log( $(":checked").val() + " is checked!" );
    });*/
    
    

    function getCollections(uname){
    
        $.ajax({
            type: 'GET',
            url: 'ui/lab_1.php',
            data: {uname:uname}
        }).done(function( msg ){
            $('#collections').html(msg);
        })
                        
    }
    
        </script>
        <div id="dialog_hider">
            <div id="delModDialog"> Remove the module from the lab?</div>
            <div id="editModDialog"> Edit module</div>
            <div id="delLabDialog"> Delete Lab?</div>
        </div>



        <div id="confirmLogOut">Confirm log out.</div>
    </body>
</html>

