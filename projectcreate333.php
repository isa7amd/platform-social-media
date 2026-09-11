<?php

require "con.php";

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


if(!isset($_COOKIE['user_id'])){

    header("Location: projectlogin333.php");

    exit();

}


$error=[];


if(isset($_POST['addpost'])){


    $text = trim($_POST['textpost']);



    // CHECK POST TEXT

    if(empty($text)){

        $error[]="PLEASE ENTER THE TEXT OF THE POST";

    }



    // CHECK IMAGE

    if(empty($_FILES['path']['name'])){

        $error[]="YOU NEED TO UPLOAD AN IMAGE";

    }



    if(!empty($_FILES['path']['name'])){


        $file = $_FILES['path']['name'];

        $tmp = $_FILES['path']['tmp_name'];

        $size = $_FILES['path']['size'];


        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));



        // Extension check

        if(
            $extension != "png" &&
            $extension != "jpg" &&
            $extension != "jpeg"
        ){

            $error[]="PLEASE UPLOAD ONLY PNG OR JPG FILE";

        }



        // Real image check

        if(!getimagesize($tmp)){

            $error[]="UPLOADED FILE IS NOT AN IMAGE";

        }



        // Size check (5MB)

        if($size > 5 * 1024 * 1024){

            $error[]="IMAGE SIZE MUST BE LESS THAN 5MB";

        }


    }




    if(empty($error)){



        // Create uploads folder if not exists

        if(!is_dir("uploads")){

            mkdir("uploads");

        }



        $newname = time()."_".uniqid().".".$extension;


        $path = "uploads/".$newname;



        move_uploaded_file(

            $tmp,

            $path

        );




        // INSERT POST


        $sql="
        INSERT INTO posts
        (
            user_id,
            post_text,
            image_path
        )

        VALUES

        (
            :user_id,
            :post_text,
            :image_path
        )
        ";



        $statement=$conn->prepare($sql);



        $statement->execute([


            ":user_id"=>$_COOKIE['user_id'],


            ":post_text"=>$text,


            ":image_path"=>$path


        ]);




        header("Location: projecthome333.php");

        exit();



    }


}

?>

<?php

include "nav333.php";

?>

<!DOCTYPE html>
<html>


<head>

<meta charset="utf-8">

<title>CREATE POST</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="project.css" rel="stylesheet">

</head>


<body>


<h2>

WELCOME 

<?php echo htmlspecialchars($_COOKIE['full_name']); ?>

</h2>



<?php

if(!empty($error)){


    echo "<ol>";


    foreach($error as $e){


        echo "<li>".htmlspecialchars($e)."</li>";


    }


    echo "</ol>";


}

?>



<form action="" method="post" enctype="multipart/form-data">



<label for="textpost">

POST TEXT

</label>


<br>


<textarea

name="textpost"

id="textpost"

placeholder="WRITE YOUR POST HERE"

></textarea>



<hr>



<label for="path">

UPLOAD IMAGE

</label>


<br>



<input

type="file"

name="path"

id="path"

accept=".png,.jpg,.jpeg"

onchange="previewImage(event)"

>



<br><br>



<img

id="preview"

width="250"

style="display:none;border-radius:20px;"

>



<hr>



<button type="submit" name="addpost">

CREATE POST

</button>



</form>




<script>

function previewImage(event){


    let image=document.getElementById("preview");


    image.src=URL.createObjectURL(event.target.files[0]);


    image.style.display="block";


}


</script>



</body>

</html>