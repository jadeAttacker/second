<?php
header("Content-type:text/html;charset:utf-8");
include("config.php");
$link=mysqli_connect(HOST,USER,PASS) or die("连接失败！");
mysqli_select_db($link,DBNAME);
$name=$_POST["name"];
$price=$_POST["price"];
$picture=$_POST["picture"];
$time=time();
//写入数据库
$sql="insert into shoppingcar values(null,'{$name}',{$price},'{$picture}',{$time})";
mysqli_query($link,$sql);
mysqli_close($link);
echo "成功！";
?>