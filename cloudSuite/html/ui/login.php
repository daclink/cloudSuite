<?php
session_start();

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    $_SESSION['cs']['username'] = $_GET['uname'];
   // $_SESSION['uname'] = $_POST['uname'];
    echo $_SESSION['cs']['username'];
    
    return 0;
?>
