<?php
header('Content-Type: text/html; charset=utf-8');
		echo "<script src='friends.js'></script>";
function get_province($province_id){
		
		global $dbc;
		
		$q='SELECT province FROM province WHERE province_id='.$province_id;
		$r=mysql_query($q,$dbc) or die (mysql_error($dbc));
		$row=mysql_fetch_assoc($r);
		extract($row);
		return $province;
}
 include('../login/connect.php');
 mysql_select_db("simple",$dbc);
 $q='SELECT user_id,email,nickname,province_id,gender,age,friends_id FROM users';
 $r=mysql_query($q,$dbc) or die(mysql_error($dbc));
 $num_users=mysql_num_rows($r);
$table=<<<endhtml
<div style="text-align:center;">
 <h2> 我的朋友列表</h2>
 <table border="1" cellpadding="2"  cellspacing="2" style="width:50%;margin-left:auto;margin-right:auto">
  <tr>
   <th>名字</th>
   <th>省份</th>
   <th>性别</th>
   <th>年龄</th>
   <th>朋友</th>
  </tr>
endhtml;
while ($row=mysql_fetch_assoc($r)){
		extract($row);
/* 另一种代码
		echo '<tr>';
    	echo '<td>'.$city_id.'</td>';
		echo '<td>'.$email.'</td>';
		echo '<td>'.$gender.'</td>';
		echo '<td>'.$age.'</td>';
 		echo '<td>'.$friends_id.'</td>';
		echo'</tr>';*/
	  $province = get_province($province_id);

			  $table.=<<<endhtml
	   <tr>
	<!-- 貌似这样做会快一些  但是出现点问题了
	<td><form action='../otherpage/otherpage.php?user_id=$user_id' method=post>
		<input value=$nickname name=nickname type="submit">
		</td>-->
		<td><a href='../otherpage/other_page.php?user_id=$user_id'><input type=button value=$nickname></a></td>
		<td>$province</td>
		<td>$gender</td>
		<td>$age</td>
		<td>$friends_id</td>
	   </tr>
endhtml;
}
$table.=<<<endhtml
 </table>
<p>$num_users  人</p>
</div>
endhtml;
echo $table;
?>
