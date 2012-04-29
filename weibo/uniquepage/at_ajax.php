<?php
header('Content-Type: text/html; charset=utf-8');
require_once("../login/connect.php");
 mysql_select_db("simple",$dbc);
 $q='SELECT user_id,email,nickname,province_id,gender,age,friends_id FROM users';
 $r=mysql_query($q,$dbc) or die(mysql_error($dbc));
		 //$a=array();
  while ($row=mysql_fetch_assoc($r)){
         extract($row);
	   $a[]=$nickname;
//	echo $nickname."asjlajkldfjals";
}
		//echo'success';}
		//else {echo 'aaaa';}
	//	echo $a;
	//get the q parameter from URL
$qf=$_GET["friends"];

//lookup all hints from array if length of q>0
if (strlen($qf) > 0)
{
$hint="";
for($i=0; $i<count($a); $i++)
  {
  if (strtolower($qf)==strtolower(substr($a[$i],0,strlen($qf))))
    {
    if ($hint=="")
      {
      $hint=$a[$i];
      }
    else
      {
      $hint=$hint." , ".$a[$i];
      }
    }
  }
}

//Set output to "no suggestion" if no hint were found
//or to the correct values
if ($hint == "")
{
$response="no suggestion";
}
else
{
$response=$hint;
}

//output the response
echo $response;

?>
