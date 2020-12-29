<?php
session_start();
if(isset($_POST['logout'])){
    session_destroy();
}
require_once "functions.php";


if(isset($_SESSION['login'])) {

}

else{
    echo "<a href=\"Registration.php\">sing up</a>";
}


$loggedin=$user="";
if(isset($_POST['username']) && $_POST['username']!="" && $_POST['password']!="") {

    $username=$conn->query("SELECT * FROM onuser WHERE username='".$_POST['username']."'");
    $num_user=$username->num_rows;
    for($q=0;$q<$num_user;$q++){
        $username->data_seek($q);
        $base_password = $username->fetch_assoc()['PASSWORD'];

        if(password_verify($_POST['password'], $base_password)) {
            $_SESSION['login']=$_POST['username'];
            $_SESSION['password']=$_POST['password'];

        }
    }
}
if(isset($_SESSION['login']) && $_SESSION['login']!=""){
    $loggedin=True;
    $user = $_SESSION['login'];
    echo "you are login in";
}
else{
    $loggedin=False;
    echo "please sing up";
}
if($loggedin) {
    echo "<div id='html'>Hello $user</div>";
    ?>
    <form method="post">
        <button name="logout">logout</button>
    </form>
    <?php
}
else{
    echo "<div id='html'>Hello Guest</div>";
    ?>
<html>
<head></head>
<body>
<form method="post">
    <label>Login</label>
    <input type="text" name="username"><br><br>
    <label>Password</label>
    <input type="password" name="password"><br><br>
    <input type="submit">
</form>
</body>
</html>
<?php
}

?>
<br><br><br>





