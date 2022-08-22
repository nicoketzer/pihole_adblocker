<?php
    include("update_grav.php");
    error_reporting(E_ALL);
    //Vars
    $type = 0; //Whitlist only Domain
    $comment = "Added via Blockpage"; //Kommentar
    $site = $_SERVER["SERVER_NAME"];
    //Funktions
    function open_db(){
        //SQLite handler for db
        $db_path = "/etc/pihole/gravity.db";
        return new SQLite3($db_path);
    }
    function sql_result_to_array($result){
        if($result){
            $array = array();
            while($row = $result->fetchArray()) {
                array_push($array,$row);
            }
            return $array;
        }else{
            return array(false);
        }
    }
    function execute_sql($handler,$sql, $type = "query"){
        try{
            if($type == "query"){
                $result = $handler->query($sql);
                return sql_result_to_array($result);
            }else{
                $result = $handler->exec($sql);
                return $result; //Is a bool
            }
        }catch(Exception $e){
            echo "lul";
            print_r($e->getMessage());
            exit;
        }
    }
    function do_it(){
        global $site;
        global $comment;
        $db_handler = open_db();
        $sql1 = "SELECT * FROM domainlist WHERE domain = '" . $site . "'";
        $res1 = execute_sql($db_handler,$sql1);
        if(!isset($res1[0])){
            $sql2 = "INSERT INTO domainlist ('type','domain','enabled','date_added','date_modified','comment') VALUES(0,'" . $site . "',1," . time() . "," . time() . ",'" . $comment . "')";
            execute_sql($db_handler,$sql2,"exec");
        }
        $db_handler->close();
	//Function in include-File
	update();
	//Exit
        return true;
    }
    //Do it if it must be done
    if(isset($_GET["site"])){
            do_it();
            echo '
<html>
    <head>
        <title>Wait for unblocking...</title>
        <script src="refresh.js"></script>
	<script src="timer.js"></script>
    </head>
    <body bgcolor=000000 text=FFFFFF>
        <center>
            <br /><br /><br /><br /><br />
            <img class="LEFT" src="/piholeCustomImage.png" width=400><br /><br /><br />
            <h1 style="font-size:40px;">You unblocked this Site.</h1>
            <p style="font-size:30px;">It can take up to one Minute to apply this Changes.</p>
            <br /><br />
            <p style="font-size:40px;">Diese Seite wird dich automatisch weiterleiten sobald diese Freigegeben wurde.</p>
	    <p style="font-size:20px;">Sekunden seitdem:</p><p id="timer">0</p><br />
        </center>
    </body>
</html>
            ';
            exit;
    }else if(isset($_GET["status"])){
	echo "true_true";
        exit;
    }
?>
<html>
    <head>
        <title>This Page is blocked</title>
        <script>
        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires="+d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/;SameSite=Strict";
        }
        window.onload = function(){
            setCookie("old_loc",window.location,1);
        }
        </script>
    </head>
    <body bgcolor=000000 text=FFFFFF>
        <center>
            <br /><br /><br /><br /><br />
            <img class="LEFT" src="/piholeCustomImage.png" width=400><br /><br /><br />
            <h1 style="font-size:40px;">WHERE DO YOU THINK YOU ARE GOING?</h1>
            <p style="font-size:30px;">This Page has Been Blocked By PiHole.</p>
            <br /><br />
            <p style="font-size:40px;">Klicke <a href="/?site=true">hier</a> um die Seite freizugeben</p>
        </center>
    </body>
</html>

