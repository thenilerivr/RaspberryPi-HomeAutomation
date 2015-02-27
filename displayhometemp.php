<!DOCTYPE html>
<meta charset="utf-8">
<html>
  <head>
    <title>Nile's House</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <!-- Load c3.css -->
    <link href="/css/c3.css" rel="stylesheet" type="text/css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>
    <script src="/c3/c3.js"></script>

<style>

body { font: 12px Arial;}

path {
    stroke: steelblue;
    stroke-width: 2;
    fill: none;
}

.axis path,
.axis line {
    fill: none;
    stroke: grey;
    stroke-width: 1;
    shape-rendering: crispEdges;
}

</style>
<body>
<div class="col-md-12"> <h1>Home Temp</h1> </div>
<div class="col-md-12" id="home"></div>

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
</body>
</html>
