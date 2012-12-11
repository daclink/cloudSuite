<?php

?>
<script>
    jQuery.fn.reset = function () {
  $(this).each (function() { this.reset(); });
}
    </script>
<div id="adminSection">
    <div id="distLab" class="admin-content">
        
    </div>
</div>
<script>
$("#adminSection").on('click','#distLabButton',function(){
            $('#labDistForm').ajaxForm(function() { 
                alert("The selected labs have been distributed."); 
                $("#labDistForm").reset();
            }); 
    });
    
$("#statusBar").on('click','#shareLab',function(){
            $('#labDistForm').submit().ajaxForm(function() { 
                alert("The selected labs have been distributed."); 
                $("#labDistForm").reset();
            }); 
    });
    
</script>
<?php

?>