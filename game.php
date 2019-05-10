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
            body{
                
                width:100%;
                height: 100%;
                padding: 0px;
                margin: 0px;
            
            }
            #game{
                width:100%;
                height: 100%;
                padding: 0px;
                margin: 0px;
            }
            
            #score{
                color: white;
                font-size: 40px;
                text-align: center;
                float: right;
            }
            #score2{
                position: absolute;
                left: 5%;
                bottom: 2%;
                color: white;
                font-size: 40px;
                text-align: center;
            }
            
            #direct{
                position: absolute;
                right: 5%;
                bottom: 1%;
                color: white;
                font-size: 20px;
                text-align: right;
            }
            
            #navbar{
                position: absolute;
                top: 0%;
                width:100%;
            }
            
            #lose{
                position: absolute;
                top: 45%;
                left: 35%;
                visibility: hidden;
                color: white;
                font-size: 50px;
                background: rgba(2, 1, 0, .8);
                border: 1px solid darkgray;
                border-radius: 5px;
                padding: 10px;
                text-align: center;
            }
            
            #wrapper{
                position: absolute;
                top: 30%;
                left: 30%;
                color: white;
                font-size: 50px;
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
            }
            
            #log{
                position: absolute;
                top: 0%;
                right: 1%;
                color: red;
                float: right;
                margin: 0px;
            }
            
            #name{
                padding: 5px;
                height: 20px;
            }
            button{
                margin: 20px;
                padding: 7px;
                background-color: black;
                color:white;
            }
            
            #logout{
                margin-left: 10px;
            }
            
        </style>
        
        </head>
    
    <body>
        
        <link rel="stylesheet" href="NavbarCSS.css">
        <div id="navbar">
            <ul>
                <li id="Home"  ><a href="index.php">Home</a></li>
                <li id="Game"  class="active"><a href="game.php" >Game</a></li>
                <li id="Scores"  ><a href="scorePage.php">Scores</a></li>
                <li id="log" onclick="logout()">
                    <?php
                    session_start();
            
                    if($_SESSION['authenticated'] == true){
                        echo"Log Out.";
                    }
                    else{
                        header('Location: index.php?login=failed');
                    }
                    ?>
                </li>
            </ul>
        </div>
        
        <div id="score2">Score: <div id="score">0</div></div>
        <div id="direct"> Press 'ESC' to exit<br> Use 'A', 'D' or Left, Right Arrow Keys <br> Use 'R' to restart</div>
        <div id="lose"> 
            Submit your score? <br>
            Name: <input type="text" name="name" id="name" maxlength="10"><button type="button" onclick="subScore()">OK</button>
            <br>Press 'R' to restart
        </div>
        <div id="game"></div>
        <script src="three.min.js"></script>
        <script>
            var trees = [];
            var scene;
            var cyl = [];
            var coord = [];
            var iteration = 0;
            var cylCount = 35;
            var kiwi;
            setUp();
            var left =false, right = false, pause=false;
            var score=0;
            
            function logout(){
                var myWindow = window.open("logout.php", "_self");
            }
            
            function subScore(){
                var finalScore = document.getElementById("score").innerHTML;
                var user = document.getElementById("name").value ;
                
                if(user!=""){
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("lose").innerHTML = "Submitted! <br>Press 'R' to restart<br>    Press 'H' for High Scores";
                        }
                    };
                    xhttp.open("GET", "score.php?score="+ finalScore + "&user=" + user, true);
                    xhttp.send();
                }
                else{
                    document.getElementById("name").placeholder = "Must be filled...";
                }
                
            }

            
            function setUp(){
                scene = new THREE.Scene();

                var camera = new THREE.PerspectiveCamera( 30, window.innerWidth/window.innerHeight, 0.1, 1000 );
                camera.position.z = 250;
                camera.position.y = 20;
                camera.rotation.x = -.2;
                
                var renderer = new THREE.WebGLRenderer();
                renderer.setSize( window.innerWidth-1, window.innerHeight-4 );
                document.body.appendChild( renderer.domElement );
                document.onkeydown = onKeyDown;
                document.onkeyup = onKeyUp;
                
                light();
                kiwi();
                cliffFace();
                background();
                
                var render = function () {
                    requestAnimationFrame( render );

                    renderer.render(scene, camera);
                    
                   
                   renderer.setClearColor(0x1C4CFF, 1); 
                    if(!pause){
                        move();
                    input();
                    collision();}
          
                };

                render();
                
                
            }
            function light(){
               var hemisphereLight = new THREE.HemisphereLight(0xfffafa,0x000000, .9)
               scene.add(hemisphereLight);
                sun = new THREE.DirectionalLight( 0xcdc1c5, 0.9);
                sun.position.set( 12,6,-7 );
                sun.castShadow = true;
                scene.add(sun);
                //Set up shadow properties for the sun light
                sun.shadow.mapSize.width = 256;
                sun.shadow.mapSize.height = 256;
                sun.shadow.camera.near = 0.5;
                sun.shadow.camera.far = 50 ;
                
                scene.fog = new THREE.FogExp2( 0xf0fff0, 0.002 );
    
            }
            
            
            function kiwi(){
               var geometry = new THREE.BoxGeometry( 5, 2.5, 5);
                var color = new THREE.Color( "#FF1C1C" );//FF1C1C
                var material = new THREE.MeshBasicMaterial( {color: 0xFF1C1C} );
                
                var cube = new THREE.Mesh( geometry, material );
                scene.add( cube ); 
                
                setPos(cube, 0, 4, 190);
                kiwi = cube;
                
            }
            
            function cliffFace(){
                //var geometry = new THREE.CylinderGeometry( 30, 30, 10, 20 );
                var geometry = new THREE.CylinderGeometry(50, 52, 30, 20, 1, false, 0, Math.PI);
                //DEB887
                var material = new THREE.MeshBasicMaterial( {color: 0x8B4513} );
                //var material = new THREE.MeshNormalMaterial();
                
                var z = 200;
                
                for(var x = 0; x<cylCount; x++){
                    cyl[x] = new THREE.Mesh( geometry, material );
                    scene.add( cyl[x] );
                    
                    cyl[x].rotation.y = Math.PI / 2;
                    cyl[x].rotation.x = Math.PI / 2;
                    
                    setPos(cyl[x], 0, -50, z);
                    coord[x]= z;
                    
                    
                    
                    trees[x] = makeTree();
                    scene.add(trees[x]);
                    var scale = 8;
                        trees[x].scale.set( scale, scale+5, scale );
                    
                    var random =Math.floor(Math.random() * (+30 - -30)) + -30;
                    if((random<25&&random>-25)&&!(x<cylCount/3)){
                        
                        var y = Math.sqrt(Math.pow(50,2)-Math.pow(Math.abs(random),2));
                        setPos(trees[x], random, -50+y, z);
                        
                    }
                    else{
                        setPos(trees[x], -1000, 0, -1000);
                    }
                    
                    z-=30;
                }
            }
            
            function background(){
                var geometry = new THREE.CylinderGeometry(50, 50, 30, 20, 5, false, 0, Math.PI);
                //DEB887
                var material = new THREE.MeshBasicMaterial( {color: 0x8B4513} );
                
                //left hand side
                var back = new THREE.Mesh( geometry, material );
                scene.add( back );
                
                back.rotation.y = Math.PI / 2 + Math.PI + Math.PI / 18;
                back.rotation.x = Math.PI / 2;
                var scale = 8;
                back.scale.set( scale, scale, scale );
                
                setPos(back, -400, -70, -350);
                
                back = new THREE.Mesh( geometry, material );
                scene.add( back );
                
                back.rotation.y = Math.PI / 2 + Math.PI ;
                back.rotation.x = Math.PI / 2;
                back.scale.set( scale, scale, scale );
                
                setPos(back, -400, -10, -200);
                
                //right hand side
                back = new THREE.Mesh( geometry, material );
                scene.add( back );
                
                back.rotation.y = Math.PI / 2 + Math.PI - Math.PI / 18;
                back.rotation.x = Math.PI / 2;
                back.scale.set( scale, scale, scale );
                
                setPos(back, 400, -70, -350);
                
                back = new THREE.Mesh( geometry, material );
                scene.add( back );
                
                back.rotation.y = Math.PI / 2 - Math.PI ;
                back.rotation.x = Math.PI / 2;
                back.scale.set( scale, scale, scale );
                
                setPos(back, 400, -10, -200);
            }
            

            function setPos(obj, x, y, z){
                obj.position.x = x;
                obj.position.y = y;
                obj.position.z = z;
            }
            
            
           function move(){
               
               if(iteration == 14){
                   iteration = 0;
                   frontToBack();
                   score++;
                   document.getElementById("score").innerHTML = score;
                   treeShift();
               }
               else{
                   iteration++;
               }
               
               for(var x = 0; x<cyl.length; x++){
                   coord[x]+=2;
                   setPos(cyl[x], 0, -50, coord[x]);
                   
                   trees[x].position.z+=2;
                }
           }
            
            function frontToBack(){
                cyl.push(cyl.shift());
                coord.push(coord.shift());
                coord[coord.length-1]=coord[coord.length-2]-30;
                cyl[cyl.length-1].position.z=coord[coord.length-1];
            }
            
            function treeShift(){
                var temp = trees.shift();
                var random =Math.floor(Math.random() * (+30 - -30)) + -30;
                if(random<25&&random>-25){
                    var y = Math.sqrt(Math.pow(50,2)-Math.pow(Math.abs(random),2));
                    setPos(temp, random, -50+y, coord[coord.length-1]);
                }
                
                trees.push(temp);
            }
            
            function onKeyDown(keyEvent){
                var x = document.activeElement.tagName;
                console.log(x);
                if(x!="INPUT"){
                if ( keyEvent.keyCode === 37||keyEvent.keyCode === 65){
                    left=true;
                }
                else if ( keyEvent.keyCode === 39||keyEvent.keyCode === 68){
                    right=true;
                }
                else if(keyEvent.keyCode===80){
                    
                    pause=!pause;
                    
                }
                else if(keyEvent.keyCode===82){
                    
                    location.reload();
                
                }
                else if(keyEvent.keyCode==27){
                    
                    var myWindow = window.open("index.php", "_self");
                    
                }
                else if(keyEvent.keyCode==72){
                    
                        var myWindow = window.open("scorePage.php", "_self");
                    
                }
                }
            }
            function onKeyUp(keyEvent){
                if ( keyEvent.keyCode === 37||keyEvent.keyCode === 65){
                    left=false;
                }
                else if ( keyEvent.keyCode === 39||keyEvent.keyCode === 68){
                    right=false;
                }
            }
            
            function input(){
                
                if(left){
                    if(kiwi.position.x>-20){
                        kiwi.position.x-=.1;
                        kiwi.position.y=-46+Math.sqrt(Math.pow(50,2)-Math.pow(Math.abs(kiwi.position.x),2));
                    }
                }
                if(right){
                    if(kiwi.position.x<20){
                        kiwi.position.x+=.1;
                        kiwi.position.y=-46+Math.sqrt(Math.pow(50,2)-Math.pow(Math.abs(kiwi.position.x),2));
                    }
                }
            }
            
            function collision(){
                
                 for(var y = 0; y<10; y++){
                   if((Math.abs(trees[y].position.x-kiwi.position.x)<2.8)&&(Math.abs(trees[y].position.z-kiwi.position.z)<2.5)){
                       pause=true;
                       console.log(y);
                       document.getElementById("lose").style.visibility = "visible";
                   }
                }
            }
            
            
            
            
//Tree code by by Juwal Bose4 Sep 2017 https://gamedevelopment.tutsplus.com/tutorials/creating-a-simple-3d-endless-runner-game-using-three-js--cms-29157
            function makeTree(){
                var sides=8;
                var tiers=6;
                var scalarMultiplier=(Math.random()*(0.25-0.1))+0.05;
                var midPointVector= new THREE.Vector3();
                var vertexVector= new THREE.Vector3();
                var treeGeometry = new THREE.ConeGeometry( 0.5, 1, sides, tiers);
                var treeMaterial = new THREE.MeshStandardMaterial( { color: 0x33ff33,flatShading:THREE.FlatShading  } );
                var offset;
                midPointVector=treeGeometry.vertices[0].clone();
                var currentTier=0;
                var vertexIndex;
                blowUpTree(treeGeometry.vertices,sides,0,scalarMultiplier);
                tightenTree(treeGeometry.vertices,sides,1);
                blowUpTree(treeGeometry.vertices,sides,2,scalarMultiplier*1.1,true);
                tightenTree(treeGeometry.vertices,sides,3);
                blowUpTree(treeGeometry.vertices,sides,4,scalarMultiplier*1.2);
                tightenTree(treeGeometry.vertices,sides,5);
                var treeTop = new THREE.Mesh( treeGeometry, treeMaterial );
                treeTop.castShadow=true;
                treeTop.receiveShadow=false;
                treeTop.position.y=0.9;
                treeTop.rotation.y=(Math.random()*(Math.PI));
                var treeTrunkGeometry = new THREE.CylinderGeometry( 0.1, 0.1,0.5);
                var trunkMaterial = new THREE.MeshStandardMaterial( { color: 0x886633,flatShading:THREE.FlatShading  } );
                var treeTrunk = new THREE.Mesh( treeTrunkGeometry, trunkMaterial );
                treeTrunk.position.y=0.25;
                var tree =new THREE.Object3D();
                tree.add(treeTrunk);
                tree.add(treeTop);
                
                return(tree);
                
            }
            function blowUpTree(vertices,sides,currentTier,scalarMultiplier,odd){
                var vertexIndex;
                var vertexVector= new THREE.Vector3();
                var midPointVector=vertices[0].clone();
                var offset;
                for(var i=0;i<sides;i++){
                    vertexIndex=(currentTier*sides)+1;
                    vertexVector=vertices[i+vertexIndex].clone();
                    midPointVector.y=vertexVector.y;
                    offset=vertexVector.sub(midPointVector);
                    if(odd){
                        if(i%2===0){
                            offset.normalize().multiplyScalar(scalarMultiplier/6);
                            vertices[i+vertexIndex].add(offset);
                        }else{
                            offset.normalize().multiplyScalar(scalarMultiplier);
                            vertices[i+vertexIndex].add(offset);
                            vertices[i+vertexIndex].y=vertices[i+vertexIndex+sides].y+0.05;
                        }
                    }else{
                        if(i%2!==0){
				    offset.normalize().multiplyScalar(scalarMultiplier/6);
                            vertices[i+vertexIndex].add(offset);
                        }else{
                            offset.normalize().multiplyScalar(scalarMultiplier);
                            vertices[i+vertexIndex].add(offset);
                            vertices[i+vertexIndex].y=vertices[i+vertexIndex+sides].y+0.05;
                        }
                    }
                }
            }
            function tightenTree(vertices,sides,currentTier){
                var vertexIndex;
                var vertexVector= new THREE.Vector3();
                var midPointVector=vertices[0].clone();
                var offset;
                    for(var i=0;i<sides;i++){
                        vertexIndex=(currentTier*sides)+1;
                        vertexVector=vertices[i+vertexIndex].clone();
                        midPointVector.y=vertexVector.y;
                        offset=vertexVector.sub(midPointVector);
                        offset.normalize().multiplyScalar(0.06);
                        vertices[i+vertexIndex].sub(offset);
                    }
            }
//tree code ends here
        </script>
    </body>
</html>