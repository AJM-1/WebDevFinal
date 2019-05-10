<?php
session_start();

$secretpassword = 'pass';
$secretusername = 'test';
$_SESSION['authenticated'] = false;

if ($_SESSION['authenticated'] == true) {
   // Go somewhere secure
   //header('Location: game.php');
    echo("authenticated = true");
} else {
   $error = null;
    
   if (!empty($_POST)) {
       $username = empty($_POST['user']) ? null : $_POST['user'];
       $password = empty($_POST['pass']) ? null : $_POST['pass'];

       if ($username == $secretusername && $password == $secretpassword) {
           $_SESSION['authenticated'] = true;
           
           // Redirect to your secure location
           if($_SESSION['authenticated'] == true){
               header('Location: game.php');
               echo("authenticated = true   2");
           }
           
           return;
       } else {
           $error = 'Incorrect username or password';
       }
   }
   // Create a login form or something
    header('Location: index.php?login=failed');
   ?>
<form action="login.php"><input type="text" name="username" /><input type="text" name="password" /><input type="submit" value="login" /></form>
<?php
}