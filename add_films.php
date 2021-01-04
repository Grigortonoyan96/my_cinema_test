<?php
require_once "Login.php";

// xndirum bolor selectner@ poxvum en sel , num_rows-@ num
// 
// $movies_name-@ bolor name-ern en mer movie-n e vor@ voroshum enq kinoin anun talov  
$name="";


if(isset($_POST['movies_name']) && $_POST['movies_name'] !="" && $_POST['producers'] !="" &&
$_POST['description'] !="" && isset($_FILES['image']['name']) && $_POST['Category'] !="") {
    $conn->query("INSERT INTO movies (movies_name,year,description) VALUES('".$_POST['movies_name'] . "'
    ,'".$_POST['year'] ."' , '".$_POST['description']."') ");


    $category_post=$conn->query("SELECT * FROM categories WHERE categories_name='".$_POST['Category']."'");
    $category=$category_post->fetch_array(MYSQLI_ASSOC);
    $category_id=$category['id'];

    $movie_post=$conn->query("SELECT * FROM movies WHERE movies_name='".$_POST['movies_name']."'");
    $movie=$movie_post->fetch_array(MYSQLI_ASSOC);
    $movie_id=$movie['id'];


    $conn->query("INSERT INTO movies_category(movie_id,category_id) VALUES('".$movie_id."','".$category_id."')");

        $name = $_POST['movies_name'];


if(isset($_POST['producers']) && $_POST['producers'] !=""){
    $producers_post=$conn->query("SELECT * FROM producers WHERE anun='".$_POST['producers']."'");
    $producers_post_num=$producers_post->num_rows;
       if($producers_post_num==0){
          $conn->query("INSERT INTO producers(anun) VALUES('".$_POST['producers']."')");
       }
    $producers_post1=$conn->query("SELECT * FROM producers WHERE anun='".$_POST['producers']."'");
    $producers=$producers_post1->fetch_array();
    $producers_id=$producers['id'];

       $conn->query("INSERT INTO movies_producers(movie_id,producer_id) VALUES ('".$movie_id."','".$producers_id."')");
}
}

if (isset($_FILES['image']['name'])) {
    $saveto = "$name.jpg";
    move_uploaded_file($_FILES['image']['tmp_name'], $saveto);

    switch ($_FILES['image']['type']) {
        case "image/gif":
            $src = imagecreatefromgif($saveto);
            break;
        case "image/jpeg":  // Both regular and progressive jpegs
        case "image/pjpeg":
            $src = imagecreatefromjpeg($saveto);
            break;
        case "image/png":
            $src = imagecreatefrompng($saveto);
            break;

    }
}
$category_array=array();
$category=$conn->query("SELECT * FROM categories");
$category_num=$category->num_rows;
for($j=0;$j<$category_num;$j++) {
    $category->data_seek($j);
    $category_array[]=$category->fetch_assoc()['categories_name'];
}

?>
<html>
<head>
    <title>mycinema</title>
</head>
<body>
<form data-ajax='false' method='post'
      enctype='multipart/form-data'>
    <label>Movies_name</label>
<input type="text" name="movies_name" ><br><br>
    <label>Year</label>
    <select name="year">
        <?php
        for($i=1980;$i<2021;$i++){
            echo "<option value='".$i."'>".$i."</option>";
        }
        ?>
    </select>
    <select name="Category">
        <?php
        for($o=0;$o<count($category_array);$o++){
            echo "<option value='".$category_array[$o]."'>".$category_array[$o]."</option>";
        }
        ?>
    </select><br><br>
    <label>Producers</label>
<input type="text" name="producers"><br><br>
    <label>Description</label>
    <p><textarea rows="10" cols="45" name="description"></textarea></p><br>

    <input type='file' name='image'><br><br>

    <input type="submit">
</form>
    <br><br><br>

    <a href="index.php">Witch all films</a>

// git repository
// i add another comment
