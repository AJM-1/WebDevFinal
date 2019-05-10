<!doctype html>

<!--
    Name: Andrew Murphy
    Pawprint: ajmfpn
    Date: 0/0/2019
    Challenge 0:
-->

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>High Scores</title>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <style>
            body{
                width: 100%;
                height: 100%;
                color: white;
            }
            #resizable { 
                width: 98%; 
                height: 60%; 
                padding: 0.5em; 
                min-height: 300px;
                height: 300px;
                overflow: hidden;
                background: rgba(2, 1, 0, .2);
                color: white;
                margin-left: .3%;
                
            }
            
            #resizable h3 {  
                margin: 0; 
            }
            
            img{
                width:40%;
                margin-left: 8%;
            }
            
            .ui-widget-header{
                background: rgba(191, 1, 1, .2);
                color: white;
            }
            
            #log{
                position: absolute;
                top: 0%;
                right: 1%;
                color: red;
                float: right;
                margin: 0px;
            }
        </style>
            <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        
        <script>
            $( function() {
                $( "#resizable" ).resizable();
            } );
            
            function logout(){
                var myWindow = window.open("logout.php", "_self");
            }
        </script>
    </head>
    
    <body>
        <link rel="stylesheet" href="NavbarCSS.css">
        <div id="navbar">
            <ul>
                <li id="Home"  ><a href="index.php">Home</a></li>
                <li id="Game"  ><a href="game.php" >Game</a></li>
                <li id="Scores" class="active" ><a href="scorePage.php">Scores</a></li>
                <li id="log" onclick="logout()">
                    <?php
                    session_start();
            
                    if($_SESSION['authenticated'] == true){
                        echo"Log Out.";
                    }
                    else{
                        echo"Log In!";;
                    }
                    ?>
                </li>
            </ul>
        </div>
 
        <div id="resizable" class="ui-widget-content">
            <h3 class="ui-widget-header">High Scores:</h3>
            <?php 
        $score = $_GET["score"];
        $user = $_GET["user"];
        
        $servername = "ec2-18-218-122-35.us-east-2.compute.amazonaws.com";
        $username = "root";
        $password = "RootRootRootRoot";
        $dbname = "HighScore";
        
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        
        $sql = "SELECT `scores`.`idscores`,
    `scores`.`score`
FROM `HighScore`.`scores`
ORDER BY `scores`.`score` DESC;";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            $position = 0;
            echo"
<table style=\"width:100%\">
  <tr>
    <th>Position</th>
    <th>Name</th> 
    <th>Score</th>
  </tr>";
            while($row = $result->fetch_assoc()) {
                $position+=1;
                echo "<tr><th>".$position."</th><th>" . $row["idscores"]. "</th><th>" . $row["score"]. "</th></tr>";
            }
        } else {
            echo "0 results";
        }
            
        echo"</table>";
        
        $conn->close();
        ?>        
            
        </div>
 
 
        <div>Pull window to resize and reveal more scores^</div>
        <img src="kiwi3.png" alt="Kiwi2">
        <img src="kiwi2.png" alt="Kiwi3">
    </body>
</html>