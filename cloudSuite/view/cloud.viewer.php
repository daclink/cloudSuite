<?php

?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>CloudViewer</title>
        <script language="JavaScript" src="includes/prototype.js"></script>
    </head>
    <body>
        <h1>Viewer is online</h1>
        <script type="text/javascript">
            document.write("hello?");
            new Ajax.Request('http://www.daclink.com/hints/owe',
            {
                method:'get',
                onSuccess: function(transport){
                    var response = transport.responseText || "no response text";
                    alert("Success! \n\n" + response);
                },
                onFailure: function(){ alert('Something went wrong...') }
            });
        </script>
        <?php
        $cs = new cloudserver();
         $cs->test();
        ?>
    </body>
</html>
