<?php
// 设置会话 cookie 的生命周期为 1 小时
ini_set('session.cookie_lifetime', 3600);
// 设置服务器端会话数据的垃圾回收最大生命周期也为 1 小时
ini_set('session.gc_maxlifetime', 3600);

session_start();

if (!isset($_GET['code']) || empty($_GET['code'])) {
    echo "<script>alert('无效的访问！');location.href='register.html';</script>";
    exit;
}

$code = $_GET['code'];

if (!isset($_SESSION['verification_code']) || $code !== $_SESSION['verification_code']) {
    echo "<script>alert('无效的验证链接或验证码已过期！');location.href='register.html';</script>";
    exit;
}

$user = $_SESSION['temp_user'];

// 连接数据库
$link = mysqli_connect("localhost", "your_username", "your_password", "your_dbname");
mysqli_set_charset($link, 'utf8');

// 插入用户数据
$sql = "INSERT INTO user(name, password, email, registertime) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, "ssss", $user['name'], $user['password'], $user['email'], $user['date']);
mysqli_stmt_execute($stmt);

if (mysqli_stmt_affected_rows($stmt) > 0) {
    echo "<script>alert('验证成功，您的帐号已激活！');location.href='login.html';</script>";
    // 清除会话中的临时数据
    unset($_SESSION['temp_user']);
    unset($_SESSION['verification_code']);
} else {
    echo "<script>alert('验证失败，请重试！');</script>";
}

mysqli_close($link);
?>
