<?php
require_once "Login.php";
if(isset($_POST['new_category']) && $_POST['new_category']!=""){
    $conn->query("INSERT INTO `categories`(categories_name) VALUES ('".$_POST['new_category']."')");
}


?>


<html>
<head>
    <title>NEW_CATEGORY</title>
</head>
<form method="post">
    <label>Add new category</label>
    <input type="text" name="new_category"><br>
    <input type="submit" value="Add">

</form>
</html>
