<?php
    $username = "monitor"; 
    $password = "password";   
    $host = "localhost";
    $database="hometemp";
    
    $server = mysql_connect($host, $username, $password);
    $connection = mysql_select_db($database, $server) or die('Could not connect: ' . mysql_error());
     
mysql_select_db('hometemp') or die('Could not select database');
  
$dataArray=array();
  
//get data from database
//$sql="SELECT temperature FROM tempdata";
//$result_temperature = mysql_query($sql) or die('Query failed: ' . mysql_error());

    $myquery = "SELECT * FROM tempdata";
    $query = mysql_query($myquery);
    
    if ( ! $query ) {
        echo mysql_error();
        die;
    }
    
$data = array();
    
    for ($x = 0; $x < mysql_num_rows($query); $x++) {
        $data[] = mysql_fetch_assoc($query);
    }
    
echo json_encode($data); 
     
    mysql_close($server);
?>
