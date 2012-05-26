<?php
include_once  '../' . 'cs' . DIRECTORY_SEPARATOR . 'cloudsuite.class.php';
//session_start();

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    if (User::login($_GET['uname'], $_GET['pass'])) {
        
        echo "1";
        
        return 1;
        
    }
    ;
    
    // $_SESSION['uname'] = $_POST['uname'];
    
    return 0;
?>
