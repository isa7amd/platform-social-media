<?php

require "con.php";


if(!isset($_COOKIE['user_id'])){

    header("location:projectlogin333.php");

    exit();

}


// welcome

echo "WELCOME ".htmlspecialchars($_COOKIE['full_name']);

echo "<br><br>";




// SEARCH

if(!isset($_POST['search']) || empty($_POST['search'])){


    $sql="
    SELECT * FROM posts
    ORDER BY created_at DESC
    ";


    $statement=$conn->prepare($sql);

    $statement->execute();


    $posts=$statement->fetchAll(PDO::FETCH_ASSOC);



}

else{


    $sql="
    SELECT * FROM posts
    WHERE post_text LIKE :search
    ORDER BY created_at DESC
    ";


    $statement=$conn->prepare($sql);


    $statement->execute([

        ":search"=>"%".$_POST['search']."%"

    ]);


    $posts=$statement->fetchAll(PDO::FETCH_ASSOC);



}





echo "<table border='4'>";


echo "<tr>";

echo "<th>AUTHOR</th>";

echo "<th>POST TEXT</th>";

echo "<th>IMAGE</th>";

echo "<th>CREATED AT</th>";

echo "<th>VIEW</th>";

echo "<th>ACTION</th>";

echo "</tr>";






foreach($posts as $post){


    // get author name

    $sql="
    SELECT full_name FROM users
    WHERE user_id=:user_id
    ";


    $statement=$conn->prepare($sql);


    $statement->execute([

        ":user_id"=>$post['user_id']

    ]);


    $user=$statement->fetch(PDO::FETCH_ASSOC);



    echo "<tr>";



    // AUTHOR

    echo "<td>";

    echo htmlspecialchars($user['full_name']);

    echo "</td>";





    // POST TEXT

    echo "<td>";

    echo htmlspecialchars($post['post_text']);

    echo "</td>";






    // IMAGE

    echo "<td>";

    echo "<img src='".htmlspecialchars($post['image_path'])."' width='150'>";

    echo "</td>";






    // DATE

    echo "<td>";

    echo htmlspecialchars($post['created_at']);

    echo "</td>";







    // VIEW

    echo "<td>";

    echo "<a href='projectdetail333.php?id=".$post['post_id']."'>VIEW</a>";

    echo "</td>";







    // ACTION

    echo "<td>";



    if($_COOKIE['user_id']==$post['user_id']){


        echo "<a href='projectdelete333.php?id=".$post['post_id']."'>DELETE</a>";


    }



    echo "</td>";



    echo "</tr>";



}



echo "</table>";





if(isset($_GET['edit'])){

    header("location:editprofile.php");

    exit();

}


?>

<?php

include "nav333.php";

?>

<!DOCTYPE html>

<html>


<head>

<title>HOME PAGE GLOBAL FEED</title>

<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="project.css" rel="stylesheet">

<br><br>

</head>



<body>



<form action="" method="post">


<label for="search">

SEARCH

</label>


<br>


<input 
type="search"
name="search"
id="search"
placeholder="ENTER THE TEXT POST PLEASE">


<br><br>


<button type="submit">

SEARCH

</button>


</form>



<br><br>




<form action="projectcreate333.php" method="get">

<button type="submit">

ADD NEW POST

</button>

</form>



<br>




<form action="" method="get">

<button type="submit" name="edit">

EDIT PROFILE

</button>

</form>



<br>




<form action="logout333.php" method="get">

<button type="submit">

LOGOUT

</button>

</form>



<form action="projectsearch333.php" method="post">

<button>

SEARCH IN NEW PAGE

</button>

</form>



</body>

</html>