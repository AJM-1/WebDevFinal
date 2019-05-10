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
        
        <title>  </title>
        
        <!-- css --> 
        <style>
            /* css comment */
        </style>
        
        </head>
    
    <body>
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
        
        $sql = "INSERT INTO `HighScore`.`scores`
(`idscores`,
`score`)
VALUES
('".$user."',
'".$score."');";
        $result = $conn->query($sql);

        
        
        
        
        
        $sql = "SELECT `scores`.`idscores`,
    `scores`.`score`
FROM `HighScore`.`scores`;";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "id: " . $row["idscores"]. " - Name: " . $row["score"]. " ";
            }
        } else {
            echo "0 results";
        }
        
        $conn->close();
        ?>
    </body>
</html>