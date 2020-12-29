

<?php

$conn=new mysqli('localhost','root','','my_cinema_star');


function showProfile($user)
{
    if (file_exists("$user.jpg"))
        echo "<img src='$user.jpg' style='float:left;width: 150px'>";

}








