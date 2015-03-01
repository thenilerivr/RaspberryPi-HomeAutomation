<?php
$username = "monitor";
$password = "password";
$host = "localhost";
$database="hometemp";

$server = mysql_connect($host, $username, $password);
$connection = mysql_select_db($database, $server) or die('Could not connect: ' . mysql_error());

mysql_select_db('hometemp') or die('Could not select database');

//get data from database
$sql = "SELECT ttime, temperature FROM tempdata";
$result = mysql_query( $sql );

if(! $result )
{
  die('Could not get data: ' . mysql_error());
}
echo "<table border='1'>";
echo "<tr> <th>Time</th> <th>Temperature</th> </tr>";
while($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
	echo "<tr><td>".
       $row['ttime'].
       "</td><td>".
       $row['temperature'].
       "</td></tr>";
}
echo "</table>";
echo "\nFetched data successfully\n";
mysql_close($server);

?>