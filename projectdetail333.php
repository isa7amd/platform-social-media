<?php

require "con.php";

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



if(!isset($_COOKIE['user_id'])){

    header("Location: projectlogin333.php");

    exit();

}



if(!isset($_GET['id'])){

    echo "POST DOES NOT EXIST";

    exit();

}



$id = $_GET['id'];



// GET POST WITH AUTHOR

$sql = "

SELECT

posts.*,

users.full_name

FROM posts

JOIN users

ON posts.user_id = users.user_id

WHERE posts.post_id = :post_id

";



$statement = $conn->prepare($sql);



$statement->execute([

    ":post_id"=>$id

]);



$post = $statement->fetch(PDO::FETCH_ASSOC);



if(!$post){

    echo "POST DOES NOT EXIST";

    exit();

}



?>

<?php

include "nav333.php";

?>

<!DOCTYPE html>

<html>


<head>

<meta charset="utf-8">

<title>POST DETAILS</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="project.css" rel="stylesheet">

</head>



<body>



<h2>

POST DETAILS

</h2>



<hr>



<p>

<b>AUTHOR:</b>

<?php

echo htmlspecialchars($post['full_name']);

?>

</p>




<p>

<b>DATE:</b>

<?php

echo htmlspecialchars($post['created_at']);

?>

</p>




<p>

<b>POST:</b>

</p>



<p>

<?php

echo nl2br(htmlspecialchars($post['post_text']));

?>

</p>





<?php

if(

!empty($post['image_path']) &&

file_exists($post['image_path'])

){

?>

<img

src="<?php echo htmlspecialchars($post['image_path']); ?>"

width="300"

>

<?php

}

?>

<br><br>


<?php

if($_COOKIE['user_id']==$post['user_id']){


    echo "

    <a href='projectdelete333.php?id=".$post['post_id']."'

    onclick=\"return confirm('DELETE THIS POST?')\">

    DELETE POST

    </a>

    ";


}



?>

<br><br>

<a href="projecthome333.php">

BACK TO HOME

</a>


</body>

</html>