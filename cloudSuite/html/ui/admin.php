<?php ?>

<div id="adminSection">
    <div id="distLab" class="admin-content">

    </div>
</div>

<!--script>

    var shareOptions = {    target: "",
        beforeSubmit : "",
        success: labShareSuccess};
    $('#labDistForm').submit(function(){
        $(this).ajaxSubmit(shareOptions);
        return false;
    });
            
    
                
    var options = { target: "/dist.php",
        beforeSubmit : showRequest,
        success: labShareSuccess};
               
    $('#labDistForm').submit(function() {
        $(this).ajaxSubmit(options);
        return false; 
    });
       
            
    function showRequest(formData, jqForm, options) {
        var queryString = $.param(formData);
                
        alert('About to submit: \n\n'+ queryString);
                
        return true;
    }
            
    function showResponse(responseText, statusText, xhr, $form)  { 
    
        alert('status: ' + statusText + '\n\nresponseText: \n' + responseText + 
            '\n\nThe output div should have already been updated with the responseText.'); 
    
    
        //try out something with POST and data...
    
    } 
            
</script-->

<script>
   
    

    
</script>
<div id="dialog_hider">
    <div id="delModDialog"> Remove the module from the lab?</div>
    <div id="editModDialog"> Edit module</div>
    <div id="delLabDialog"> Delete Lab?</div>
</div>

</script>
<?php
?>