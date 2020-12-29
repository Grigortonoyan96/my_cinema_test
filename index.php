<?php
require_once "Login.php";

$movies=$conn->query("SELECT * From movies");
$movies_num=$movies->num_rows;
for ($j=0;$j<$movies_num; $j++) {
    $movies->data_seek($j);
    $name = $movies->fetch_assoc()['movies_name'];
    $movies->data_seek($j);
    $movies_id= $movies->fetch_assoc()['id'];
    $movies->data_seek($j);
    echo "<h3>name:" . htmlspecialchars($movies->fetch_assoc()['movies_name']) . "<br>";
    showProfile($name);
    $rating_array=array();
    $movies_rating=$conn->query("SELECT * FROM `ratings` WHERE movie_id='".$movies_id."'");
    $movies_rating_num=$movies_rating->num_rows;
    for($a=0;$a<$movies_rating_num;$a++){
        $movies_rating->data_seek($a);
        $rating_array[]=$movies_rating->fetch_assoc()['rating'];
    }
    if(array_sum($rating_array)>0) {
        echo "this film rating is:" . array_sum($rating_array) / count($rating_array);
    }
    echo "<br><br>" . "<br><br>" . "<br><br>" . "<br><br>";


    ?>


    <a href="film.php?view=<?php $movies->data_seek($j);
    echo $movies->fetch_assoc()['movies_name']; ?>">About the movie</a>
    <?php
    // hima estex petq e grenq mi cod vori mijocov mer vote-@ gna baza ,
    if ($loggedin) {
        ?>
        <form method="post">
            <select name="ratingvotes">
                <?php
                for ($i = 0; $i < 11; $i++) {
                    echo "<option value='" . $i . "'>" . $i . "</option>";
                }
                ?>
            </select>
            <input type="hidden"  name="movies_hidden_id" value="<?php $movies->data_seek($j);
            echo $movies->fetch_assoc()['id']; ?>">
            <input type="submit" value="votes">
        </form>
    <?php }

    if (isset($_SESSION['login'])) {
        $login = $_SESSION['login'];
        $onuser_login = $conn->query("SELECT * FROM onuser WHERE username='" . $login . "'");
        $onuser_login_id = $onuser_login->fetch_assoc()['id'];
    }
    if(isset($_POST['ratingvotes'])){
        $movies_hidden_id=$conn->query("SELECT * FROM ratings WHERE movie_id='".$_POST['movies_hidden_id']."'");
        $movies_hidden_id_num=$movies_hidden_id->num_rows;
        if($movies_hidden_id_num==0){
        $conn->query("INSERT INTO ratings(user_id,movie_id,rating) VALUES('".$onuser_login_id."','".$_POST['movies_hidden_id']."','".$_POST['ratingvotes']."')");
        }
        elseif ($movies_hidden_id_num!=0){
            $conn->query("UPDATE ratings SET rating='".$_POST['ratingvotes']."' WHERE user_id='".$onuser_login_id."' AND movie_id='".$_POST['movies_hidden_id']."'");
        }
        }
    }


?>
<br><br>
<a href="add_films.php">Add new film</a>
<a href="new_category.php">Add new category</a>


