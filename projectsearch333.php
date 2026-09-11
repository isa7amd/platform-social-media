<?php

require "con.php";

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



if(!isset($_COOKIE['user_id'])){

    header("Location: projectlogin333.php");

    exit();

}



$posts = [];

$keyword = "";



if(isset($_POST['search'])){


    $keyword = trim($_POST['keyword']);



    $sql = "

    SELECT

    posts.*,

    users.full_name

    FROM posts

    JOIN users

    ON posts.user_id = users.user_id

    WHERE posts.post_text LIKE :search

    ORDER BY posts.created_at DESC

    ";



    $statement = $conn->prepare($sql);



    $statement->execute([

        ":search"=>"%".$keyword."%"

    ]);



    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);



}



?>


<!DOCTYPE html>

<html>


<head>

<meta charset="utf-8">

<title>SEARCH POSTS</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="project.css" rel="stylesheet">

</head>



<body>



<?php include "nav333.php"; ?>



<h2>

SEARCH POSTS

</h2>



<form method="post">



<input

type="search"

name="keyword"

placeholder="SEARCH IN POSTS"

value="<?php echo htmlspecialchars($keyword); ?>"

required

>



<br><br>



<button type="submit" name="search">

SEARCH

</button>



</form>



<hr>




<?php



if(isset($_POST['search'])){


    if(empty($posts)){


        echo "<p>NO POSTS FOUND</p>";


    }



    else{



        echo "<table border='4'>";



        echo "

        <tr>

        <th>AUTHOR</th>

        <th>POST</th>

        <th>IMAGE</th>

        <th>DATE</th>

        <th>VIEW</th>

        </tr>

        ";





        foreach($posts as $post){



            echo "<tr>";



            echo "<td>";

            echo htmlspecialchars($post['full_name']);

            echo "</td>";





            echo "<td>";

            echo nl2br(htmlspecialchars($post['post_text']));

            echo "</td>";





            echo "<td>";



            if(

                !empty($post['image_path']) &&

                file_exists($post['image_path'])

            ){


                echo "

                <img src='"

                .htmlspecialchars($post['image_path'])

                ."' width='150'>

                ";

            }


            echo "</td>";






            echo "<td>";

            echo htmlspecialchars($post['created_at']);

            echo "</td>";






            echo "<td>";

            echo "

            <a href='projectdetail333.php?id="

            .$post['post_id'].

            "'>

            VIEW

            </a>

            ";

            echo "</td>";





            echo "</tr>";



        }



        echo "</table>";



    }


}



?>



</body>

</html>