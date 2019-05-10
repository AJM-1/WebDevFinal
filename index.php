<!DOCTYPE html>

<!--
    Name: Andrew Murphy
    Pawprint: ajmfpn
    Date: 0/0/2019
    Challenge 0:
-->

<html lang="en">
    <head>
        <meta charset="utf-8">
        
        <title> Kiwi!</title>
        
        <!-- css --> 
        <style>
            /* css comment */
            body{
                width: 100%;
                height: 100%;
                color:white;
                font-size: 25px;
            }
            iframe{
                margin:auto;
            }
            
            #desc{
                text-align: center;
                width: 40%;
                margin: auto;
            }
            #cont{
                width: 10%;
                margin: auto;
                align-content: center;
                
                text-align: center;
                color:white;
            }
            
            #sub{
                width:80%;
                margin-left: 25%;
            }
            
            img{
                width:40%;
                margin-left: 8%;
            }
            
            #failed{
                color:red;
                font-size: 15px;
            }
            
            #log{
                color: red;
                padding: 5px;
            }
            
            #log:hover{
                background-color: #808080;
            }
            
            h1{
                font-size: 40px;
                width: 100%;
                text-align: center;
            }
        </style>
        
        </head>
    
    <body>
        <link rel="stylesheet" href="NavbarCSS.css">
        <div id="navbar">
            <ul>
                <li id="Home"  class="active"><a href="index.html">Home</a></li>
                <li id="Game"  ><a href="game.php" >Game</a></li>
                <li id="Scores"  ><a href="scorePage.php">Scores</a></li>
            </ul>
        </div>
        
        <h1>Kiwi! The Game!</h1>
        
        <iframe width="100%" height="541" src="https://www.youtube.com/embed/sdUUx5FdySs" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        
        <br>
        <?php
        session_start();
             
        if($_SESSION['authenticated'] == true){
            echo"<div id=\"cont\">You are logged in!<br><br>
                <div id=\"log\" onclick=\"logout()\">Log out!</div>
            </div>";
        }
        else{
           echo"
           <div id=\"desc\">Login to play the game based on this video!</div>
        
        <br><br>
        
        <div id=\"cont\">
            <form action=\"/secure.php\" method=\"post\">
                ";
            
            if($_GET["login"]=="failed"){
                echo "<div id=\"failed\">Login Failed,<br>Try again.</div><br>";
            } 
        echo"
                Username:<br>
                <input type=\"text\" name=\"user\" value=\"test\">
                <br>
                Password:<br>
                <input type=\"password\" name=\"pass\" value=\"pass\">
                <br><br>
                <input id=\"sub\" type=\"submit\" value=\"Submit\">
            </form> 
        </div>
           ";
        }
        ?>
        
        
        <script>
            function logout(){
                var myWindow = window.open("logout.php", "_self");
            }
        </script>
    </body>
</html>