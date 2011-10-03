<?php

?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>CloudViewer</title>
        <script language="JavaScript" src="includes/prototype.js"></script>
        <script language="JavaScript" src="includes/jquery.js"></script>
        <script type="text/javascript">
            document.write("hello?");
            function foo() {
                
                new Ajax.Request('http://www.daclink.com/hints/owe',
                {
                    method:'get',
                    onSuccess: function(transport){
                        var response = transport.responseText || "no response text";
                        //alert("Success! \n\n" + response);
                        $('responser').update('fishCAke!');
                        $('responser').innerHTML;
                    },
                    onFailure: function(){ alert('Something went wrong...') }
                });
            }
        </script>
    </head>
    <body>
        <h1>Viewer is online</h1>
        
        <div id ="responser"> <a href="" onclick="foo()">ME!</a></div>
        <?php
        $path = $_SERVER[''];
        $cs = new cloudControler();
         $cs->test();
         echo "<pre>";
         print_r($_SERVER);
        ?>
    </body>
</html>
