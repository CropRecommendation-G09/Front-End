<?php
date_default_timezone_set('PRC'); //设置时区
include('config.php');
$link = @mysqli_connect(HOST,USER,PASS) or die('数据库连接失败');
mysqli_select_db($link,DBNAME);
mysqli_set_charset($link,'utf8');

//接收传值
$name = $_POST['name'];
$password = $_POST['password'];
$email = $_POST['email'];
$date	 = date("Y-m-d H:i:s");

// 检查用户名长度是否在 5 到 12 之间
if (strlen($name) < 5 || strlen($name) > 12) {
    echo "<script>alert('用户名长度必须在 5 到 12 之间！');history.go(-1);</script>";
    exit;
}

if (strlen($email) < 1) {
    echo "<script>alert('邮箱不能为空！');history.go(-1);</script>";
    exit;
}

if (strlen($password) < 5 || strlen($password) > 12) {
    echo "<script>alert('密码长度必须在 5 到 12 之间！');history.go(-1);</script>";
    exit;
}

$nameSql = "select id from user where name='{$name}'";
mysqli_query($link, $nameSql);
if (mysqli_affected_rows($link)>0) {
    echo "<script>alert('该帐号已被注册，请重新输入！');history.go(-1);</script>";
    exit;
}

$sql = "insert into user( `name`, `password`, `email`, `registertime`) values('$name','$password','$email', '$date')";

$result =  mysqli_query($link,$sql);

if (mysqli_insert_id($link)>0) {
    echo "<script>alert('注册成功,请登录！');location.href='../login.html'</script>";
    exit;
}else{
    echo "<script>alert('注册失败！');history.go(-1);</script>";
    exit;
}

?>