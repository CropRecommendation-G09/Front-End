<?php
date_default_timezone_set('PRC'); //设置时区
include('config.php');
$link = @mysqli_connect(HOST, USER, PASS) or die('数据库连接失败');
mysqli_select_db($link, DBNAME);
mysqli_set_charset($link, 'utf8');
//接收传值
$email = $_POST['email'];
$password = $_POST['password'];

// // 调试输出
// echo "email: " . $email . "<br>";
// echo "Password: " . $password . "<br>";

//验证数据库里的账号 密码
// $sql = "select * from user where name='{$email}' or  email='{$email}'";//验证邮箱以及用户名
$sql = "select * from user where email='{$email}'";//仅验证邮箱
$result = mysqli_query($link, $sql);

if ($result && mysqli_num_rows($result) > 0) {//用户存在
    $row = mysqli_fetch_assoc($result);
    if ($password != $row['password']) {//判断密码
        echo "<script>alert('密码错误，请重新输入！');history.go(-1);</script>";
        exit;
    }
    echo "<script>alert('登录成功！');localStorage.setItem('loggedIn', 'true');location.href='../login.html'</script>";
    exit;
} else {//用户不存在
    echo "<script>alert('帐号不存在，请重新输入！');history.go(-1);</script>";
    exit;
}

?>