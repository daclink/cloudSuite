
<?php
$uname = (isset($_SESSION['cs']['username'])) ? $_SESSION['cs']['username'] : "Login";
?>

<div id="task-bar">
    <div id="labButton" class="task-bar-item chiClick csshadow">Lab</div> 
    <div id="adminButton" class="task-bar-item chiClick csshadow">Admin</div>
    <div id="settingsButton" class="task-bar-item chiClick csshadow">Settings</div>
    <div id="username" class="task-bar-item chiClick csshadow"><?php echo $uname; ?></div>
</div>
