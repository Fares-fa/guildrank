<link href="ProgressBar.css" rel="stylesheet" type="text/css" />
<?php

include('../includes/config.php');
$ConnectODBC = 'Driver={SQL Server};Server='.$server.';Database='.$Database.';';

$config = array( 'db_username' => $username, 'db_password' => $password, 'db_dsn' => $ConnectODBC);
function Get_Top_Class($HonorPoint,$lv){
global $config;
$conn = odbc_connect($config['db_dsn'],$config['db_username'],$config['db_password']);
$p = "SELECT TOP 1 * FROM [Player] WHERE [HonorPoint] = $HonorPoint AND [Admin] = 0 ORDER BY [HonorPoint] Desc, [RewardPoint] Desc";
$pp = odbc_exec($conn,$p);
$return = odbc_fetch_array($pp);
if($lv)
return $return['HonorPoint'];    
else
return $return['Name'];    
}

?>
<style>
body {
	background-image:url('images/background_0_0.png');
  background-attachment: fixed;
  background-repeat: no-repeat;
  background-size: 100% 100%;
}
 h3   {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;
    font-weight: bold;
    margin: 0;
    font-size: 22px;
    font-weight: 200;
    margin: 0;
    color: #ffffff;
    text-shadow: 0px 0px 10px #ca6b6b;
}



}


 h10   {
       
font-family: Arial, Helvetica, sans-serif; font-size:12px;  font-weight: bold; margin: 0;
color: #2a2a2a;

}

.ranking-top-three tr th,
.ranking-top-three tr td {
	padding:0;
	text-align:center;
}

.ranking-list,
.ranking-top-three {
	width:100%;
	border-collapse: collapse;
}

.ranking-list tbody tr {
	border-bottom:1px solid #a90606;
    border-left:1px solid #a90606;
    border-right:1px solid #a90606;
}

.ranking-list tbody tr:last-child {
	*border-bottom:none;
}

.ranking-list tr:nth-child(odd) {
	background-color:#1c2023;
}

.ranking-list tr:nth-child(even) {
	background-color:#2d3134;
}

.ranking-list tr th,
.ranking-list tr td {
	text-align:center;
	font-size:12px;
	font-weight:500;
	font-weight:500;
	border-right:1px solid #e64017;

}

.ranking-list tr th:last-child,
.ranking-list tr td:last-child {
	border-right:none;
}

.ranking-list tr th {
padding: 7px;
    /* color: #e52aa3; */
    background-color: #6a1c1e;
    /* border-right: 1px solid #e0a8

	
}
.ranking-list tr th:first-child {
		border-left:1px solid #a90606;
}
.ranking-list tr td {
	padding:5px;
	color:#fff;
}

.ranking-list tr td a {
	color:#81615c;
}

.ranking-list tr td a:hover {
	color:#A79895;
	text-decoration:underline;
}
</style>
<!DOCTYPE html>
<head>
<title>Honor Ranking </title>
<link href="ProgressBar.css" rel="stylesheet" type="text/css" />
<script>
  var isNS = (navigator.appName == "Netscape") ? 1 : 0;
  if(navigator.appName == "Netscape") document.captureEvents(Event.MOUSEDOWN||Event.MOUSEUP);
  function mischandler(){
  return false;
  }
  function mousehandler(e){
  var myevent = (isNS) ? e : event;
  var eventbutton = (isNS) ? myevent.which : myevent.button;
  if((eventbutton==2)||(eventbutton==3)) return false;
  }
  document.oncontextmenu = mischandler;
  document.onmousedown = mousehandler;
  document.onmouseup = mousehandler;
  </script>
</head>
 
<table class="ranking-list" align=center>
<thead><tr>
<th width='15%'><h3>#</h3></th>
<th width='20%'><h3>Guild</h3></th>
    <th width='20%'><h3>Leader</h3></th>
<th width='20%'><h3>SubLeader</h3></th>
<th width='20%'><h3>Total Members</h3></th>

<th width='10%'><h3>Honor Points</h3></th>
<th width='15%'><h3>Contribution</h3></th>
<th width='15%'><h3>Experience</h3></th>



</tr></thead>



<?php
require_once ("../includes/config.php");
  SQL_Check($_SERVER['REQUEST_URI'],"index.php");

include('exparray.php');


include("geoip.inc");
$gi = geoip_open("GeoIP.dat",GEOIP_STANDARD);
Database($kal_db);
    
 $plist = $db->Execute("SELECT DISTINCT Guild.GID,Guild.Name, SUM(Player.Contribute) OVER (PARTITION BY Guild.GID) AS total_points, SUM(Player.HonorPoint) OVER 
(PARTITION BY Guild.GID) AS sum_points,Guild.Exp,Guild.Leader,Guild.SubLeader,COUNT(Player.GID)OVER(PARTITION BY Guild.GID) AS totalmember FROM Player INNER JOIN Guild ON
Player.GID = Guild.GID ORDER BY sum_points DESC;");
    

$top =1;
function lastip($uid)
{
global $db,$kal_auth;
Database($kal_auth);
$cou = $db->Execute("SELECT [Registration_IP],[Last IP Logged In] FROM Login WHERE UID = '".$uid."'");

$co = $cou->fetchrow();
if(!empty($co[1]))
return $co[1];
else
return $co[0];

}


    
  for($i=0;$i < $plist->numrows();++$i)
{

$r = $plist->fetchrow();

$a = $exparray[$r[5]];
$b = $r[4]/$a*100;
$bol = explode(".", $b);


$uid = $r[0];
      

$contSum = $db->Execute("SELECT SUM(Contribute) From Player WHERE Player.GID= '".$uid."' ");


      
$guildlevel=$contSum;
Database($kal_auth);

$st = $db->Execute("SELECT TOP 1 Type FROM Log WHERE Player1 = '".$uid."' ORDER BY Date desc");



if($st3[0] == "0")
{
$status = '<img width=16 height=16 src="images/online.png">';
}
else
{
$status = '<img width=16 height=16 src="images/offline.png">';
}
		   $Name = $r[1];
 $nn = str_replace("<", "&lt;", $Name);
	if(empty($r[1]))
{

$guild = "-";


} else {

$guild = ''.$r[12].'';
}


if($top == 1){
$topf = '<img src="images/1.png">';
}
else if($top == 2){
$topf = '<img src="images/2.png">';
}
else if($top == 3){
$topf = '<img src="images/3.png">';
}
else{
$topf = $top;
}
  
if ($bol[0] >= 100) {
$bol[0] = '99';
} 

echo "<tr>";
echo "<td><h3>";
echo ''.$topf.'';
echo "</h3></td>";
echo "<td><h3>";
echo ''.$nn.'';
echo "</h3></td>";
echo "<td><h3>";
echo ''.$r[5].'';
echo "</h3></td>";
echo "<td><h3>";
echo ''.$r[6].'';
echo "</h3></td>";
echo "<td><h3>";
echo ''.$r[7].'';
echo "</h3></td>";
echo "<td><h3>";
echo ''.$r[3].'';
echo "</h3></td>";
echo "<td><h3>";
echo ''.$r[2].'';
echo "</h3></td>";
echo "<td><h3>";
echo ''.$r[4].'';
echo "</h3></td>";



$top++;
}
geoip_close($gi);
echo '</table>';
?>				
