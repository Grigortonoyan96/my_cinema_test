<?php

require_once "Login.php";
// 2 hat select unenanq movies_category-i ev movies_producers anunner@ dnenq $join_tables ev $sel_mov_prod isk nrans $row_join_tables ev $row_join_tables1


function showFilm($user)
{
    if (file_exists("$user.jpg"))
        echo "<img src='$user.jpg' style='float:left;width: 350px'>";
}

if(isset($_GET['view'])) {
    $user = $_GET['view'];
    $join_tables = $conn->query("select * from movies inner join movies_category on movies.id = movies_category.movie_id inner join categories on movies_category.category_id = categories.id INNER JOIN movies_producers ON movies.id=movies_producers.movie_id
INNER JOIN producers ON producers.id=movies_producers.producer_id
WHERE movies.movies_name='" . $user . "'");
    $row_join_tables = $join_tables->num_rows;
    for ($j=0;$j< $row_join_tables;$j++) {

        $join_tables->data_seek($j);
        echo "<h1>name:".htmlspecialchars($join_tables->fetch_assoc()['movies_name']) . "<br></h1>";
        showFilm($user);
        $join_tables->data_seek($j);
        echo "<li>year:" .htmlspecialchars($join_tables->fetch_assoc()['year']) . "<br>";
        $join_tables->data_seek($j);
        echo "<li>producer:" .htmlspecialchars($join_tables->fetch_assoc()['anun']) . "<br>";
        $join_tables->data_seek($j);
        echo "<li>category:" . htmlspecialchars($join_tables->fetch_assoc()['categories_name']) . "<br><br><br><br>";
        $join_tables->data_seek($j);
        echo "<h3>Description:" . htmlspecialchars($join_tables->fetch_assoc()['description']) . "<br</h3>";
        $join_tables->data_seek($j);
        $join_tables->fetch_assoc()['id'];

        if ($loggedin) {
            $admin = $conn->query("SELECT * FROM onuser WHERE username='".$_SESSION['login']."'");
            $admin_id=$admin->fetch_assoc()['id'];
                if(isset($_GET['view'])){
                    $movies_name=$_GET['view'];
                    $choose_this_movie=$conn->query("SELECT * FROM movies WHERE movies_name='".$movies_name."'");
                    $movie_id=$choose_this_movie->fetch_assoc()['id'];
                    $sel=$conn->query("SELECT * FROM ratings WHERE user_id='".$admin_id."' AND movie_id='".$movie_id."'");
                    $num_sel=$sel->num_rows;
                        if(isset($_POST['rating']) && $num_sel==0){
                            $conn->query("INSERT INTO ratings(user_id,movie_id,rating) VALUES('".$admin_id."','".$movie_id."','".$_POST['rating']."') ");
                        }
                        elseif (isset($_POST['rating']) && $num_sel!=0){
                            $conn->query("UPDATE ratings SET rating='".$_POST['rating']."' WHERE user_id='".$admin_id."' AND movie_id='".$movie_id."'");
                        }
                }
            }
        }
    }
echo "<br><br><br>";
if($loggedin){

    echo "<h4>Your Rating this Film</h4>";
    ?> <form method="post">
    <?php
    for($i=1;$i<11;$i++){
        echo "<button name='rating' value='".$i."'>".$i."</button>";
    }
    ?>
</form>
<?php
}
$array=array();

    $rating=$conn->query("SELECT rating FROM `ratings` WHERE movie_id='".$movie_id."'");
    $rating_num=$rating->num_rows;
    for($j=0;$j<$rating_num;$j++){
        $rating->data_seek($j);
        $array[]=$rating->fetch_assoc()['rating'];
    }
    if(array_sum($array)>0) {
        echo "this film rating is:" . array_sum($array) / count($array);
    }

?>

<br><br><br>

    <a href="index.php">back</a>







