<?php

require_once "Login.php";
if(isset($_POST['login'])) {
    $onuser=$conn->query("SELECT * FROM onuser WHERE username='".$_POST['login']."'");
    $onuser_num=$onuser->num_rows;
}
if(isset($_POST['login']) && $_POST['login']!="" && isset($_POST['password']) && $_POST['password']!=""
&& $_POST['password']==$_POST['retrypass'] && $onuser_num==0){
    $pass=$_POST['password'];
    $conn->query("INSERT INTO onuser(username,PASSWORD) VALUES ('".$_POST['login']."','".password_hash($pass,1)."')");
}

?>

<html>
<head>
    <title>Registration</title>
</head>
<body>
<h1>Registration</h1>
<form method="post" enctype='multipart/form-data'>
    <label>Login</label>
    <input type="text" name="login"><br>
    <label>Password</label>
    <input type="password" name="password"><br>
    <label>Retry Password</label>
    <input type="password" name="retrypass"><br>
    <input type="submit">
</form>
</body>




</html>

<br><br><br>

<a href="index.php">Witch all films</a>
