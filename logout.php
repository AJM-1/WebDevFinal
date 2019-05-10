<?php
session_start();
$_SESSION['authenticated'] = false;
unset($_SESSION['authenticated']);
if(session_destroy()){
    echo"success";
}
if($_SESSION['authenticated']){
    echo"still true";
}
header('Location: index.php');
?>