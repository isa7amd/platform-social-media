<?php

require "con.php";

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



if(!isset($_COOKIE['user_id'])){

    header("Location: projectlogin333.php");

    exit();

}



if(isset($_GET['id'])){


    $id = $_GET['id'];



    // Get image path and make sure the post belongs to the logged user

    $sql = "
    SELECT image_path 
    FROM posts
    WHERE post_id=:post_id
    AND user_id=:user_id
    ";


    $statement = $conn->prepare($sql);


    $statement->execute([

        ":post_id"=>$id,

        ":user_id"=>$_COOKIE['user_id']

    ]);



    $post = $statement->fetch(PDO::FETCH_ASSOC);



    if($post){


        // Delete post from database

        $sql = "
        DELETE FROM posts
        WHERE post_id=:post_id
        AND user_id=:user_id
        ";


        $statement = $conn->prepare($sql);


        $statement->execute([

            ":post_id"=>$id,

            ":user_id"=>$_COOKIE['user_id']

        ]);



        // Delete image from uploads folder

        if(!empty($post['image_path']) && file_exists($post['image_path'])){


            unlink($post['image_path']);

        }


    }


}



header("Location: projecthome333.php");

exit();

?>